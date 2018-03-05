<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */



$GLOBALS['TL_LANG']['FMD']['huh_newsalert'] = 'Newsalert';
$GLOBALS['TL_LANG']['FMD'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule::MODULE_NAME] = [
    'Newsalert Anmeldung',
    'Anmeldung für Newsalert-Topics'
];
$GLOBALS['TL_LANG']['FMD'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule::MODULE_NAME]  = [
    'Newsalert Redirect',
    'Bestätigungsseitenmodul für Opt-in und Opt-out'
];

$lang = &$GLOBALS['TL_LANG']['tl_module'];

$arrLang['message_handling_legend'] = "Nachrichten handling";
$lang['trigger_legend'] = "Sendeevent";
$lang['misc_legend']    = "Verschiedenes";

$lang['newsalertCronIntervall'] = ['Intervall', 'Intervall für dem PoorManCron von Contao'];
$lang['newsalertModulePage'] = ['Modulseite', 'Geben Sie hier die Seite an, auf welcher dieses Module eingebunden wird. Dies wird für die Erstellung von Link (etwa opt-out), bei deren Generierung kein Kontext vorhanden ist, verwendet. Wird keine Seite angegegeben, wird die Startseite verwendet.'];


$lang[\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule::MODULE_NAME] = [
    'optin'   => [
        'success' => [
            'head'    => 'Newsalert-Anmeldung erfolgreich',
            'message' => 'Die Anmeldung Ihres Newsalert zum Thema %topic% war erfolgreich.'
        ],
        'error'   => [
            'head'    => 'Newsalert-Anmeldung nicht erfolgreich',
            'message' => 'Die Anmeldung für den Newsalert konnte nicht durchgeführt werden. Möglicherweise haben Sie die Anmeldung bereits durchgeführt oder Ihr Link enthält einen Fehler. Sollte das Problem weiterhin bestehen, wenden Sie sich bitte an unseren Kundendienst.'
        ]
    ],
    'optout'  => [
        'success' => [
            'head'    => 'Newsalert-Abmeldung erfolgreich',
            'message' => 'Die Abmeldung Ihres Newsalert zum Thema %topic% wurde erfolgreich durchgeführt.'
        ],
        'error'   => [
            'head'    => 'Ihre Newsalert-Abmeldung war nicht erfolgreich',
            'message' => 'Die Abmeldung Ihres Newsalerts konnte nicht durchgeführt werden. Möglicherweise haben Sie diese bereits durchgeführt oder Ihr Link hat einen Fehler. Sollte das Problem weiterhin bestehen, wenden Sie sich bitte an unseren Kundendienst.'
        ]
    ],
    'optnone' => [
        'success' => [
            'head'    => 'Newsalert-Abmeldung erfolgreich',
            'message' => 'Die Abmeldung Ihres Newsalert zum Thema %topic% wurde erfolgreich durchgeführt.'
        ],
        'error'   => [
            'head'    => 'Fehler',
            'message' => 'Diese Seite ist eine Bestätigungsseite und nicht für den direkten Aufruf gedacht. Haben Sie hier eine Bestätigung erwartet, gab es eventuell einen Fehler. Sollte das Problem weiterhin bestehen, wenden Sie sich bitte an unseren Kundendienst.'
        ]
    ]
];