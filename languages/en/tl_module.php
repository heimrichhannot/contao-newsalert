<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$lang = &$GLOBALS['TL_LANG']['tl_module'];

/*
 * Module names
 */
$GLOBALS['TL_LANG']['FMD']['huh_newsalert'] = 'News Alert';
$GLOBALS['TL_LANG']['FMD'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule::MODULE_NAME] = [
    'News alert subscription', 'Subscribe for news alert topic'];
$GLOBALS['TL_LANG']['FMD'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule::MODULE_NAME] = [
    'News alert redirect', 'Module for redirect page for opt-in and opt-out'];

/*
 * Legends
 */
$lang['newsalert_topic_legend'] = "Topic settings";
$lang['message_handling_legend'] = "Message handling";
$lang['misc_legend'] = "Misc";

/*
 * Fields
 */
$lang['newsalertCronIntervall'] = ['Cronjob interval', 'Interval for the contao poor man cron.'];
$lang['newsalertSourceSelection'] = ['Source selection', 'Select topic sources for the newsalert.'];
$lang['newsalertModulePage'] = ['Module page', 'Set page, where this model is added. This is needed for link generation, if no context is given (for example opt-out links). If no page is given, the index page is used.'];
$lang['newsalertNoTopicSelection'] = ['Disable topic selection', 'Disable topic selection field and set a custom topic.'];
$lang['newsalertOverwriteTopic'] = ['Specify topic', 'Set topic for the subscription.'];

/*
 * Sources
 */
$lang['newsalertSources']['archive'] = 'News archives';

/*
 * Cron
 */
$lang['newsalertCronIntervall']['minutely'] = 'minutely';
$lang['newsalertCronIntervall']['hourly']   = 'hourly';
$lang['newsalertCronIntervall']['daily']    = 'daily';
$lang['newsalertCronIntervall']['weekly']   = 'weekly';
$lang['newsalertCronIntervall']['monthly']  = 'monthly';

/*
 * Redirect module
 */
$lang[\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule::MODULE_NAME] = [
    'optin'   => [
        'success' => [
            'head'    => 'Subscription successfull',
            'message' => 'Your subscription to the news alert topic %topic% was successfull.'
        ],
        'error'   => [
            'head'    => 'Subscription was not successfull',
            'message' => 'The registration for the News alert could not be executed. You may already have signed in or your link contains an error. If the problem persists, please contact our customer service.'
        ]
    ],
    'optout'  => [
        'success' => [
            'head'    => 'Unsubscription successful',
            'message' => 'Signing off your news alert on %topic% has been successful.
'
        ],
        'error'   => [
            'head'    => 'Unsubscription was not successful',
            'message' => 'Your news alert subscription could not be canceled. You may have already done this or your link has an error. If the problem persists, please contact our customer service.'
        ]
    ],
    'optnone' => [
        'success' => [
            'head'    => 'Unsubscription successful',
            'message' => 'Signing off your news alert on %topic% has been successful.'
        ],
        'error'   => [
            'head'    => 'Error',
            'message' => 'This page is a confirmation page and should not be called directly. If you have expected an confirmation, there may have been an error. If the problem persists, please contact our customer service.'
        ]
    ]
];