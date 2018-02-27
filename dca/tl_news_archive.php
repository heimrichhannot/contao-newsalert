<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$dc = &$GLOBALS['TL_DCA']['tl_news_archive'];

/*
 * List comments_legend
 */

array_insert($dc['list']['global_operations'], 1, [
    'newsalert_sent' =>
        [
            'label' => &$GLOBALS['TL_LANG']['tl_news_archive']['newsalert'],
            'href'  => 'table=tl_newsalert_sent',
            'icon'  => 'news.gif',
        ]
]);

$dc['palettes']['default']               = str_replace('{comments_legend', '{newsalert_legend},newsalert_activate;{comments_legend', $dc['palettes']['default']);
$dc['palettes']['__selector__'][]        = 'newsalert_activate';
$dc['subpalettes']['newsalert_activate'] = 'newsalert_configuration';

$fields = [
    'newsalert_activate'      => [
        'label'     => &$GLOBALS['TL_LANG']['tl_news_archive']['newsalert_activate'],
        'inputType' => 'checkbox',
        'exclude'   => true,
        'default'   => false,
        'sql'       => "int(1) NOT NULL default '0'",
        'eval'      => ['tl_class' => 'w50 clr', 'submitOnChange' => true],
    ],
    'newsalert_configuration' => [
        'label'            => &$GLOBALS['TL_LANG']['tl_news_archive']['newsalert_configuration'],
        'inputType'        => 'select',
        'exclude'          => true,
        'sql'              => "int(11) NOT NULL default '0'",
        'eval'             => ['tl_class' => 'w50'],
        'options_callback' => ['HeimrichHannot\ContaoNewsAlertBundle\Backend\Modules', 'getNewsalertModules']
    ]
];

$dc['fields'] = array_merge($dc['fields'], $fields);