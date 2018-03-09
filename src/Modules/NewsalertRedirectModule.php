<?php

/*
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0+
 */

namespace HeimrichHannot\ContaoNewsAlertBundle\Modules;

use Contao\BackendTemplate;
use Contao\Module;
use Contao\Session;
use Contao\System;

class NewsalertRedirectModule extends Module
{
    const MODULE_NAME = 'contao-newsalert-redirect';

    protected $topic;
    protected $success = 'error';
    protected $opt = 'none';
    protected $strTemplate = 'mod_newsalert_redirect';

    /**
     * Parse the template.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE') {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### '.utf8_strtoupper($GLOBALS['TL_LANG']['FMD'][static::MODULE_NAME][0]).' ###';
            $objTemplate->id = $this->id;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        $session = Session::getInstance();
        if ($session->get('contao_newsalert_success')) {
            $this->success = $session->get('contao_newsalert_success') ? 'success' : 'error';
        }
        $this->topic = $session->get('contao_newsalert_topic');
        $session->get('contao_newsalert_opt') ? $this->opt = $session->get('contao_newsalert_opt') : true;

        $session->remove('contao_newsalert_success');
        $session->remove('contao_newsalert_topic');
        $session->remove('contao_newsalert_opt');

        $this->strWrapperId .= $this->id;

        return parent::generate();
    }

    /**
     * Compile the current element.
     */
    protected function compile()
    {
        System::loadLanguageFile('tl_module');
        $strMessageId = $GLOBALS['TL_LANG']['tl_module'][static::MODULE_NAME]['opt'.$this->opt][$this->success];
        $this->Template->headline = $strMessageId['head'];
        $this->Template->wrapperClass = $this->strWrapperClass;
        $this->Template->wrapperId = $this->strWrapperId;
        $this->Template->strMessage = str_replace('%topic%', $this->topic, $strMessageId['message'] );
    }
}
