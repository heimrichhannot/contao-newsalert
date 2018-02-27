<?php
/**
 * // * Contao Open Source CMS
 * // *
 * // * Copyright (c) 2017 Heimrich & Hannot GmbH
 * // *
 * // * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * // * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 * // */

System::loadLanguageFile('tl_newsalert_recipients');

$strTable   = 'tl_newsalert_sent';

$GLOBALS['TL_DCA'][$strTable] = [
    'config' => [
        'dataContainer'    => 'Table',
        'switchToEdit'     => false,
        'enableVersioning' => false,
        'closed'           => true,
        'backlink'         => 'do=news',
        'label'            => &$GLOBALS['TL_LANG'][$strTable]['label'],
        'sql'              => [
            'keys' => [
                'id' => 'primary',
            ]
        ]
    ],
    'list'   => [
        'sorting'    => [
            'mode'        => 2,
            'fields'      => ['senddate DESC'],
            'flag'        => 8,
            'panelLayout' => 'debug;filter;sort,search,limit',
        ],
        'label'      => [
            'fields'      => ['senddate', 'newsId:tl_news.headline', 'topics', 'count_messages', 'pid:tl_module.name'],
            'showColumns' => true,
        ],
        'global_operations' => [
            'newsalert_recipients' => [
                'label' => &$GLOBALS['TL_LANG']['tl_newsalert_recipients']['label'],
                'href'  => 'table=tl_newsalert_recipients',
                'icon'  => 'db.gif',
            ]
        ],
        'operations' => [
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_news']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            ]
        ]
    ],
    'fields' => [
        'id'             => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'pid'            => [
            'label'      => &$GLOBALS['TL_LANG'][$strTable]['pid'],
            'foreignKey' => 'tl_module.name',
            'sql'        => "int(10) unsigned NOT NULL default '0'",
            'relation'   => ['type' => 'belongsTo', 'load' => 'eager']
        ],
        'newsId'            => [
            'label'      => &$GLOBALS['TL_LANG'][$strTable]['newsId'],
            'foreignKey' => 'tl_news.headline',
            'sql'        => "int(10) unsigned NOT NULL default '0'",
            'relation'   => ['type' => 'belongsTo', 'load' => 'eager']
        ],
        'tstamp'         => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'topics'         => [
            'label'     => &$GLOBALS['TL_LANG'][$strTable]['topics'],
            'sorting'   => true,
            'inputType' => 'text',
            'search'    => true,
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'senddate'       => [
            'label'     => &$GLOBALS['TL_LANG'][$strTable]['senddate'],
            'inputType' => 'text',
            'exclude'   => true,
            'sorting'   => true,
            'flag'      => 6,
            'eval'      => ['rgxp' => 'datim', 'datepicker' => true, 'doNotCopy' => true, 'sort' => 12],
            'sql'       => "int(10) unsigned NOT NULL default '0'",
        ],
        'user'           => [
            'label'      => &$GLOBALS['TL_LANG'][$strTable]['user'],
            'inputType'  => 'select',
            'sorting'    => true,
            'exclude'    => true,
            'foreignKey' => 'tl_user.name',
            'sql'        => "int(10) NOT NULL default '0'",
            'eval'       => [
                'tl_class' => 'w50',
                'chosen'   => true
            ],
        ],
        'count_messages' => [
            'label'   => &$GLOBALS['TL_LANG'][$strTable]['count_messages'],
            'sorting' => true,
            'eval'    => ['doNotCopy' => true],
            'sql'     => "int(10) unsigned NOT NULL default '0'",
        ],
    ]
];