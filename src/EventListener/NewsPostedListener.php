<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\EventListener;

use Contao\ContentModel;
use Contao\Controller;
use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\Module;
use Contao\ModuleModel;
use Contao\NewsArchiveModel;
use Contao\PageModel;
use Contao\System;
use HeimrichHannot\ContaoNewsAlertBundle\Components\NewsTopicCollection;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertRecipientsModel;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertSendModel;
use HeimrichHannot\ContaoNewsAlertBundle\Models\NewsModel;
use HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule;
use HeimrichHannot\FormHybrid\Form;
use HeimrichHannot\FormHybrid\TokenGenerator;
use Model\Collection;
use NotificationCenter\Model\Notification;

class NewsPostedListener
{
    const NOTIFICATION_TYPE_NEWSALERT = 'hh_newsalert';
    const NOTIFICATION_TYPE_NEW_ARTICLE = 'news_posted';

    private $tokengenerator;

    public function __construct()
    {
        $this->tokengenerator = new TokenGenerator();
    }

    /**
     * Trigger the send mechanism by model.
     *
     * @param ModuleModel $module
     * @return bool|int|void
     */
    public function callByModule($module)
    {
        $archives = $this->getArchiveIdsByModule($module);
        if (empty($archives)) {
            return;
        }
        $objArticles = NewsModel::findUnsentPublished(0, $archives);
        if (!$objArticles) {
            return;
        }
        $count = 0;
        while ($objArticles->next()) {
            $count += $this->sendNewsalert($objArticles->current(), $module);
        }
        return $count;
    }

    /**
     * Get array with news archive ids which have given module as configuration.
     *
     * @param \Contao\ModuleModel $module
     *
     * @return array|int
     */
    public function getArchiveIdsByModule($module)
    {
        $archives = NewsArchiveModel::findBy('newsalert_configuration', $module->id);
        $archivesIds = [];
        if ($archives) {
            while ($archives->next()) {
                if ($archives->newsalert_activate) {
                    $archivesIds[] = $archives->id;
                }
            }
        }

        return $archivesIds;
    }

    /**
     * @param NewsModel $objArticle
     * @param ModuleModel $objModule
     *
     * @return bool|int False on failure, number of send messages on success
     */
    public function sendNewsalert($objArticle, ModuleModel $objModule)
    {
        if (!$objArticle or $objArticle->newsalert_sent) {
            return false;
        }

        $sources = null;
        if ($objModule->newsalertSourceSelection)
        {
            $sources = deserialize($objModule->newsalertSourceSelection);
        }

        $topicCollection = NewsTopicCollection::getInstance();
        $topics = $topicCollection->getTopicsByItem($objArticle, $sources);
        $arrRecipients = $this->getRecipientsByTopic($topics);

        if (0 === count($arrRecipients)) {
            $objArticle->newsalert_sent = 1;
            $objArticle->save();
            $this->createSendModel($objArticle, $topics, $objModule->id, 0);

            return 0;
        }

        /**
         * @var Collection|Notification
         */
        $objNotificationCollection = Notification::findByType(static::NOTIFICATION_TYPE_NEW_ARTICLE);
        if (null === $objNotificationCollection)
        {
            System::log(
                'No notification by type ' . static::NOTIFICATION_TYPE_NEW_ARTICLE . ' was found. No newsalert send.',
                __METHOD__,
                TL_CRON
            );
            return false;
        }
        if ($objNotificationCollection->count() > 1)
        {
            System::log(
                'Multiple notifications by type ' . static::NOTIFICATION_TYPE_NEW_ARTICLE . ' found. Can lead to multiple notifications for the same person.',
                __METHOD__,
                TL_CRON
            );
        }

        $strContent = '';
        $strTeaser = empty($objArticle->teaser) ? '' : $objArticle->teaser;

        $objContents = ContentModel::findPublishedByPidAndTable($objArticle->id, 'tl_news');
        if (null !== $objContents) {
            while ($objContents->next()) {
                $item = $objContents->current();
                if (!empty($item->headline)) {
                    $title = deserialize($item->headline);
                    $headline = '<'.$title['unit'].'>'.$title['value'].'</'.$title['unit'].'>';
                    $strContent .= $headline;
                }
                $strContent .= $item->text;
            }
        }
        $intCountMails = 0;

        System::loadLanguageFile('default');

        foreach ($arrRecipients as $email => $data)
        {
            $arrAllTopics = $this->getAllTopicsByRecipient($email, $objModule);
            $optOutLinks = $this->generateOptOutLinks($arrAllTopics, $objModule);
            $strTopics = implode(',', $data['topics']);
            $enclosures = $this->addEnclosures($objArticle);
            $strUrl = Controller::replaceInsertTags('{{news_url::' . $objArticle->id . '}}', false);

            $arrTokens = [
                'huh_newsalert_topic_recipient' => $email,
                'huh_newsalert_recipient_topics' => $strTopics,
                'huh_newsalert_recipient_topic_count' => count($data['topics']),
                'huh_newsalert_news_headline' => $objArticle->headline,
                'huh_newsalert_news_subheadline' => $objArticle->subheadline,
                'huh_newsalert_news_teaser' => $strTeaser,
                'huh_newsalert_news_content' => $strContent,
                'huh_newsalert_news_enclosure_html' => $enclosures['html'],
                'huh_newsalert_news_enclosure_text' => $enclosures['text'],
                'huh_newsalert_news_url' => $strUrl,
                'huh_newsalert_opt_out_html' => $optOutLinks['html'],
                'huh_newsalert_opt_out_text' => $optOutLinks['text'],
                'huh_newsalert_year' => date('Y'),
                'huh_newsalert_root_url' => Environment::get('url'),
                'raw_data' => $strContent,
                // Fix cli error
                'salutation_user' => '',
                'salutation_form' => '',
            ];

            if (isset($GLOBALS['TL_HOOKS']['huh_newsalert_customToken']) && is_array($GLOBALS['TL_HOOKS']['huh_newsalert_customToken'])) {
                foreach ($GLOBALS['TL_HOOKS']['huh_newsalert_customToken'] as $callback) {
                    $arrTokens = System::importStatic($callback[0])->{$callback[1]}($objArticle, $arrTokens);
                }
            }

            if (PHP_SAPI === 'cli') {
                unset($GLOBALS['TL_HOOKS']['sendNotificationMessage']);
            }

            while ($objNotificationCollection->next()) {
                /**
                 * @var Notification
                 */
                $objNotification = $objNotificationCollection->current();
                $objNotification->send($arrTokens);
                ++$intCountMails;
            }

            $objNotificationCollection->reset();

            $objArticle->newsalert_sent = 1;
            $objArticle->save();
        }

        $this->createSendModel($objArticle, $topics, $objModule->id, $intCountMails);

        return $intCountMails;
    }

    protected function createSendModel($objArticle, $arrTopics, $configId, $intCountMails)
    {
        $objNewsalertSend = new NewsalertSendModel();
        $objNewsalertSend->pid = $configId;
        $objNewsalertSend->newsId = $objArticle->id;
        $objNewsalertSend->topics = $arrTopics;
        $objNewsalertSend->senddate = time();
        $objNewsalertSend->tstamp = time();
        $objNewsalertSend->count_messages = $intCountMails;
        $objNewsalertSend->user = $objArticle->author;
        $objNewsalertSend->save();
    }

    /**
     * Return recipients list with emails, topics and unsubscribe links
     * List is filtered, so every recipient is only once included in the list
     * (if he/she is not registered with multiple mail adresses),
     * even if he/she registered to multiple topics from the given list.
     *
     * @param array $arrTopics Simple list of topic names. Example ['Music','Live','Concert']
     *
     * @return array Key is the recipient mail adrress, values are the topics.
     *               Example: ['text@example.org' => ['Windows','MacOs','Linux']]
     */
    protected function getRecipientsByTopic($arrTopics = [])
    {
        $arrRecipients = [];
        foreach ($arrTopics as $strTopic) {
            $recipients = NewsalertRecipientsModel::findByTopic($strTopic);
            if (!$recipients) {
                continue;
            }
            while ($recipients->next()) {
                if (!$recipients->confirmed) {
                    continue;
                }
                $arrRecipients[$recipients->email]['topics'][] = $strTopic;
            }
        }

        return $arrRecipients;
    }

    /**
     * Returns all topics by a recipient with opt out links.
     *
     * @param $recipient string email address of the recipient
     * @param NewsalertSubscribeModule $module Configuration module
     *
     * @return array [Topic => Opt-out-link]
     */
    protected function getAllTopicsByRecipient($recipient, $module)
    {
        $recipientsModel = NewsalertRecipientsModel::findByEmail($recipient);
        $recipientsList = [];
        while ($recipientsModel->next()) {
            if ($module->formHybridAddOptOut && !$recipientsModel->optOutToken)
            {
                $recipientsModel->optOutToken = Form::generateUniqueToken();
                $recipientsModel->save();
            }
            $recipientsList[$recipientsModel->topic] = $this->tokengenerator::optOutTokens(
                NewsalertSubscribeModule::TABLE,
                $recipientsModel->optOutToken,
                ''
            )['opt_out_link'];
        }

        ksort($recipientsList);

        return $recipientsList;
    }

    /**
     * @param array $topics
     * @param ModuleModel $config
     * @return array
     */
    protected function generateOptOutLinks (array $topics, $config)
    {
        $links = [
            'html' => '',
            'text' => ''
        ];
        $url = Environment::get('url');
        if ($config->newsalertModulePage)
        {
            $modulePage = PageModel::findByPk($config->newsalertModulePage);
            if ($modulePage)
            {
                $url .= '/'.Controller::generateFrontendUrl($modulePage->row());
            }
        }

        foreach ($topics as $topic => $token)
        {
            $strLink            = $url . $token;
            $links['html'] .= $topic . ': <a href="' . $strLink . '">' . $GLOBALS['TL_LANG']['MSC']['newsalert']['notifications']['unsubscribe'] . '</a><br />';
            $links['text'] .= $topic . ' ' . $GLOBALS['TL_LANG']['MSC']['newsalert']['notifications']['unsubscribe'] . ': ' . $strLink . '\n';
        }
        return $links;
    }

    /**
     * @param NewsModel $article
     * @return array
     */
    protected function addEnclosures($article)
    {
        $enclosures = [
            'html' => '',
            'text' => ''
        ];
        if ($article->addEnclosure)
        {
            $template = new FrontendTemplate();
            Module::addEnclosuresToTemplate($template, $article->row());
            $enclosuresList = $template->enclosure;
            $countEnclosures = count($enclosuresList);
            $i = 0;
            foreach ($enclosuresList as $entry)
            {
                ++$i;
                $enclosures['text'] .= Environment::get('url').'/'.$entry['enclosure'];
                $enclosures['html'] .= '<a href="'.Environment::get('url').'/'.$entry['enclosure'].'" title="'.$entry['title'].'">'.$entry['name'].'</a> ('.$entry['filesize'].')';
                if ($i < $countEnclosures)
                {
                    $enclosures['text'] .= '\n';
                    $enclosures['html'] .= '<br />';
                }
            }
        }
        return $enclosures;
    }
}
