<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2018 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Src
	'HeimrichHannot\ContaoNewsAlertBundle\Forms\NewsAlertSubscriptionForm'     => 'system/modules/newsalert/src/Forms/NewsAlertSubscriptionForm.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Components\NewsTopicCollection'      => 'system/modules/newsalert/src/Components/NewsTopicCollection.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Components\NewsTopicSourceInterface' => 'system/modules/newsalert/src/Components/NewsTopicSourceInterface.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Components\NewsArchiveTopics'        => 'system/modules/newsalert/src/Components/NewsArchiveTopics.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Components\Cronjob'                  => 'system/modules/newsalert/src/Components/Cronjob.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule'     => 'system/modules/newsalert/src/Modules/NewsalertRedirectModule.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule'    => 'system/modules/newsalert/src/Modules/NewsalertSubscribeModule.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Backend\Modules'                     => 'system/modules/newsalert/src/Backend/Modules.php',
	'HeimrichHannot\ContaoNewsAlertBundle\EventListener\NewsPostedListener'    => 'system/modules/newsalert/src/EventListener/NewsPostedListener.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertSendModel'           => 'system/modules/newsalert/src/Models/NewsalertSendModel.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Models\NewsalertRecipientsModel'     => 'system/modules/newsalert/src/Models/NewsalertRecipientsModel.php',
	'HeimrichHannot\ContaoNewsAlertBundle\Models\NewsModel'                    => 'system/modules/newsalert/src/Models/NewsModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_newsalert_subscribe' => 'system/modules/newsalert/templates/modules',
	'mod_newsalert_redirect'  => 'system/modules/newsalert/templates/modules',
));
