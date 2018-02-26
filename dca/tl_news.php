<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$table = 'tl_news';
$dc = &$GLOBALS['TL_DCA'][$table];

/*
 * Palettes
 */

$dc['palettes']['default'] = str_replace('published','published,newsalert_sent',$dc['palettes']['default']);

/*
 * Fields
 */

$fields = [
    'newsalert_sent' => [
        'label'     => &$GLOBALS['TL_LANG'][$table]['newsalert_sent'],
        'inputType' => 'checkbox',
        'exclude'   => true,
        'default'   => 0,
        'sql'       => "int(1) NOT NULL default '1'"
    ]
];

$dc['fields'] = array_merge($dc['fields'], $fields);