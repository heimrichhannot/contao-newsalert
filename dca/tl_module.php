<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$arrDca = &$GLOBALS['TL_DCA']['tl_module'];

$arrDca['palettes'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertSubscribeModule::MODULE_NAME] =
    '{title_legend},name,headline,type;'
    .'{newsalert_topic_legend},newsalertSourceSelection,newsalertNoTopicSelection;'
    .'{message_handling_legend},newsalertOptIn,formHybridAddOptOut,newsalertModulePage;'
    .'{misc_legend},newsalertCronIntervall,formHybridCustomSubmit;'
    .'{template_legend:hide},formHybridTemplate,customTpl;'
    .'{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;';

$arrDca['palettes'][\HeimrichHannot\ContaoNewsAlertBundle\Modules\NewsalertRedirectModule::MODULE_NAME] =
    '{title_legend},name,headline,type;';

$arrDca['palettes']['__selector__'][] = 'newsalertOptIn';
$arrDca['palettes']['__selector__'][] = 'formHybridCustomSubmit';
$arrDca['palettes']['__selector__'][] = 'newsalertNoTopicSelection';

$arrDca['subpalettes']['newsalertOptIn'] = 'formHybridOptInSuccessMessage,formHybridOptInNotification,formHybridOptInJumpTo';
$arrDca['subpalettes']['formHybridCustomSubmit'] = 'formHybridSubmitLabel,formHybridSubmitClass';
$arrDca['subpalettes']['newsalertNoTopicSelection'] = 'newsalertOverwriteTopic';



$arrFields = [
    'newsalertOptIn'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['formHybridAddOptIn'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50', 'submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'newsalertNoTopicSelection'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['newsalertNoTopicSelection'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'newsalertOverwriteTopic'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['newsalertOverwriteTopic'],
        'exclude'   => true,
        'inputType' => 'select',
        'options_callback' => [\HeimrichHannot\ContaoNewsAlertBundle\EventListener\CallbackListener::class, 'getAllTopics'],
        'sql'       => "varchar(64) NOT NULL default ''",
    ],
    'newsalertSourceSelection'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['newsalertSourceSelection'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'options_callback' => [\HeimrichHannot\ContaoNewsAlertBundle\EventListener\CallbackListener::class, 'getNewsalertSourcesList'],
        'reference' => &$GLOBALS['TL_LANG']['tl_module']['newsalertSources'],
        'eval'      => ['multiple' => true],
        'sql'       => "blob NULL",
    ],
    'newsalertCronIntervall'                         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_module']['newsalertCronIntervall'],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => ['minutely','hourly','daily','weekly','monthly'],
        'reference' => &$GLOBALS['TL_LANG']['tl_module']['newsalertCronIntervall'],
        'eval'      => ['tl_class' => 'w50', 'includeBlankOption'=>true],
        'sql'       => "varchar(12) NOT NULL default ''",
    ],
    'newsalertModulePage'                     => [
        'label'      => &$GLOBALS['TL_LANG']['tl_module']['newsalertModulePage'],
        'exclude'    => true,
        'inputType'  => 'pageTree',
        'foreignKey' => 'tl_page.title',
        'eval'       => ['fieldType' => 'radio', 'tl_class' => 'w50'],
        'sql'        => "int(10) unsigned NOT NULL default '0'",
        'relation'   => ['type' => 'hasOne', 'load' => 'lazy'],
    ],
];

$arrDca['fields'] = array_merge($arrDca['fields'], $arrFields);