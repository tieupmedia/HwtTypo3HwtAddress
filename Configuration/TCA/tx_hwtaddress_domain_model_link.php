<?php

if (!defined('TYPO3')) {
    die('Access denied.');
}


// DB locallang
$ll = 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:tx_hwtaddress_domain_model_link.';

// General locallang
if (version_compare(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getVersion(), '9.3.0') >= 0) {
    $llGeneral = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';
} elseif (version_compare(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getVersion(), '8.5.0') >= 0) {
    $llGeneral = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';
} else {
    $llGeneral = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';
}

// TCA locallang
$llTca = 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:';

// CMS locallang
if (version_compare(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getVersion(), '8.0.0') >= 0) {
    $llTtc = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:';
} else {
    $llTtc = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:';
}

$extTca = [
    'ctrl' => [
        'title' => 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:tx_hwtaddress_domain_model_link',
        'label' => 'header',
        'label_alt' => 'linktext, type, parameter',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'origUid' => 't3_origuid',
        'default_sortby' => 'ORDER BY sorting',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'iconfile' => 'EXT:hwt_address/Resources/Public/Icons/tx_hwtaddress_domain_model_link.gif',
        'searchFields' => 'uid,header,type,link,linktext',

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
    ],
    'interface' => [
        'showRecordFieldList' => 'sorting,hidden,starttime,endtime,header,type,parameter,linktext'
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => $llGeneral . 'LGL.language',
            'config' => ['type' => 'language']
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => $llGeneral . 'LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_hwtaddress_domain_model_address',
                'foreign_table_where' => 'AND tx_hwtaddress_domain_model_address.pid=###CURRENT_PID### AND tx_hwtaddress_domain_model_address.sys_language_uid IN (-1,0)',
                'default' => 0,
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => ''
            ]
        ],
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'sorting' => [
            'label' => 'sorting',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => $llGeneral . 'LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0
            ]
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => $llGeneral . 'LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 10,
                'eval' => 'datetime,int',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => $llGeneral . 'LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 10,
                'eval' => 'datetime,int',
                'default' => 0,
            ]
        ],

        'header' => [
            'exclude' => 1,
            'label' => $ll . 'header',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'max' => 30,
            ]
        ],
        'parameter' => [
            'exclude' => 0,
            'label' => $ll . 'parameter',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 50,
                'max' => 1024,
                'eval' => 'trim',
                'softref' => 'typolink'
            ]
        ],
        'linktext' => [
            'exclude' => 1,
            'label' => $ll . 'linktext',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'max' => 30,
            ]
        ],
        'type' => [
            'exclude' => 0,
            'label' => $ll . 'type',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [$ll . 'type.pleaseSelect', ''],
                    [$ll . 'type.facebook', 'facebook'],
                    [$ll . 'type.github', 'github'],
                    [$ll . 'type.gitlab', 'gitlab'],
                    [$ll . 'type.google', 'google'],
                    [$ll . 'type.pinterest', 'pinterest'],
                    [$ll . 'type.instagram', 'instagram'],
                    [$ll . 'type.linkedin', 'linkedin'],
                    [$ll . 'type.twitter', 'twitter'],
                    [$ll . 'type.vimeo', 'vimeo'],
                    [$ll . 'type.xing', 'xing'],
                    [$ll . 'type.youtube', 'youtube'],
                ],
                'size' => 1,
                'max' => 1,
            ]
        ],
    ],
    'types' => [
        0 => [
            'showitem' =>
                '--palette--;' . $ll . 'palette.name;paletteName,

                --div--;' . $ll . 'tabs.language,
                    --palette--;' . $ll . 'palette.language;paletteLanguage,

                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                    --palette--;' . $llTtc . 'palette.visibility;paletteVisbility,
                    --palette--;' . $llTtc . 'palette.access;paletteAccess,'
        ],
    ],
    'palettes' => [
        'paletteName' => [
            'showitem' => 'header, --linebreak--, type, parameter, linktext',
            'canNotCollapse' => true,
        ],

        'paletteVisbility' => [
            'showitem' => 'hidden',
            'canNotCollapse' => true,
        ],
        'paletteAccess' => [
            'showitem' => 'starttime;' . $llTtc . 'starttime_formlabel, endtime;' . $llTtc . 'endtime_formlabel,',
            'canNotCollapse' => true,
        ],
        'paletteLanguage' => [
            'showitem' => '
                sys_language_uid;' . $llTtc . 'sys_language_uid_formlabel,l10n_parent
            ',
        ],
    ],
];

return $extTca;
