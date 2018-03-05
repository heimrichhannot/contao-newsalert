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

$GLOBALS['TL_LANG']['FMD']['contao-newsalert-subscribe'] = array('Newsalert subscription', 'Subscribe for newsalert topic');
$GLOBALS['TL_LANG']['FMD']['contao-newsalert-redirect'] = array('Newsalert redirect', 'Module for redirect page for opt-in and opt-out');

$arrLang = &$GLOBALS['TL_LANG']['tl_module'];

$arrLang['message_handling_legend'] = "Message handling";
$arrLang['trigger_legend'] = "Send event";
$arrLang['misc_legend'] = "Misc";

$lang['newsalertCronIntervall'] = ['Interval', 'Interval for the contao poor man cron.'];
$lang['newsalertModulePage'] = ['Module page', 'Set page, where this model is added. This is needed for link generation, if no context is given (for example opt-out links). If no page is given, the index page is used.'];