<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\ContaoNewsAlertBundle\EventListener;


use HeimrichHannot\ContaoNewsAlertBundle\Components\NewsTopicCollection;
use HeimrichHannot\ContaoNewsAlertBundle\Forms\NewsAlertSubscriptionForm;
use HeimrichHannot\Dav\Backend\News;

class CallbackListener
{
    public function getNewsalertSourcesList()
    {
        $collection = NewsTopicCollection::getInstance();
        return $collection->getAllSourcesList();
    }

    /**
     * Returns topics by given config
     *
     * @param NewsAlertSubscriptionForm $form
     * @return array
     */
    public function getTopics($form)
    {
        $sourcesList = deserialize($form->newsalertSourceSelection);
        if (empty($sourcesList))
        {
            return NewsTopicCollection::getInstance()->getAllTopics();
        }
        $topics = [];
        foreach ($sourcesList as $alias)
        {
            $topics = array_merge($topics, NewsTopicCollection::getInstance()->getTopicsBySource($alias));
        }
        return $topics;
    }

    /**
     * Returns a list of all available topics
     *
     * @return array
     */
    public function getAllTopics()
    {
        return NewsTopicCollection::getInstance()->getAllTopics();
    }
}