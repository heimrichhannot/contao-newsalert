<?php
/**
 * // * Contao Open Source CMS
 * // *
 * // * Copyright (c) 2017 Heimrich & Hannot GmbH
 * // *
 * // * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * // * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 * // */

$strTable = 'tl_newsalert_recipients';
//
$GLOBALS['TL_DCA'][$strTable] = [
    'config'   => [
        'dataContainer'    => 'Table',
        'switchToEdit'     => true,
        'enableVersioning' => false,
        'closed'           => true,
        'backlink'         => 'do=news',
        'label'            => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['label'],
        'sql'              => [
            'keys' => [
                'id' => 'primary',
            ]
        ]
    ],
    'list'     => [
        'sorting'           => [
            'mode'        => 2,
            'fields'      => ['email', 'topic', 'confirmed'],
            'flag'        => 1,
            'panelLayout' => 'debug;filter;sort,search,limit',
        ],
        'label'             => [
            'fields'      => ['email', 'topic', 'confirmed'],
            'format'      => '%s',
            'showColumns' => true,
        ],
        'global_operations' => [
            'newsalert_sent' => [
                'label' => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['label'],
                'href'  => 'table=tl_newsalert_sent',
                'icon'  => 'db.svg',
            ]
        ],
        'operations'        => [
            'edit'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_news']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ],
            'copy'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_news']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ],
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_news']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                    . '\'))return false;Backend.getScrollOffset()"',
            ],
            'show'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_news']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            ]
        ]
    ],
    'palettes' => [
        'default' => '{abonnement_legend},email,topic,confirmed'
    ],
    'fields'   => [
        'id'        => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp'    => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'email'     => [
            'label'     => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['email'],
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'text',
            'search'    => true,
            'eval'      => [
                'mandatory'      => true,
                'rgxp'           => 'email',
                'maxlength'      => 128,
                'decodeEntities' => true,
                'nospace'        => true,
                'tl_class'       => 'w50'
            ],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'topic'     => [
            'label'            => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['topic'],
            'sorting'          => true,
            'inputType'        => 'select',
            'options_callback' => ['hh.contao-newsalert.newstopiccollection', 'getAllTopics'],
            'search'           => true,
            'eval'             => [
                'chosen'    => true,
                'maxlength' => 128,
                'mandatory' => true,
                'nospace'   => true,
                'tl_class'  => 'w50'
            ],
            'sql'              => "varchar(255) NOT NULL default ''"
        ],
        'confirmed' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['confirmed'],
            'inputType' => 'checkbox',
            'sorting'   => true,
            'default'   => 0,
            'sql'       => "char(1) NOT NULL default ''",
            'eval'      => ['tl_class' => 'w50'],
        ],
        'captcha'   => [
            'label'     => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['captcha'],
            'inputType' => 'captcha',
        ]
    ]
];

\HeimrichHannot\FormHybrid\FormHybrid::addOptInFieldToTable($strTable);
\HeimrichHannot\FormHybrid\FormHybrid::addOptOutFieldToTable($strTable);
\HeimrichHannot\Haste\Dca\General::addDateAddedToDca($strTable);