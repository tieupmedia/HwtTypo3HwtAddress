<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}


// DB locallang
$ll = 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:tx_hwtaddress_domain_model_link.';

// General locallang
if ( version_compare(TYPO3_version, '9.3.0') >= 0 ) {
    $llGeneral = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';
} elseif ( version_compare(TYPO3_version, '8.5.0') >= 0 ) {
    $llGeneral = 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:';
} else {
    $llGeneral = 'LLL:EXT:lang/locallang_general.xlf:';
}

// TCA locallang
$llTca = 'LLL:EXT:lang/locallang_tca.xlf:';

// CMS locallang
if ( version_compare(TYPO3_version, '8.0.0') >= 0 ) {
    $llTtc = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:';
} else {
    $llTtc = 'LLL:EXT:cms/locallang_ttc.xlf:';
}

$extTca = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:tx_hwtaddress_domain_model_link',
        'label' => 'header',
        'label_alt' => 'linktext, type, parameter',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'default_sortby' => 'ORDER BY sorting',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'iconfile' => 'EXT:hwt_address/Resources/Public/Icons/tx_hwtaddress_domain_model_link.gif',
        'searchFields' => 'uid,header,type,link,linktext',

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
    ),
    'interface' => array(
        'showRecordFieldList' => 'sorting,hidden,starttime,endtime,header,type,parameter,linktext'
    ),
    'columns' => array(
        'sys_language_uid' => [
            'exclude' => true,
            'label' => $llGeneral . 'LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        $llGeneral . 'LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
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
        'pid' => array(
            'label' => 'pid',
            'config' => array(
                'type' => 'passthrough'
            )
        ),
        'sorting' => array(
            'label' => 'sorting',
            'config' => array(
                'type' => 'passthrough'
            )
        ),
        'crdate' => array(
            'label' => 'crdate',
            'config' => array(
                'type' => 'passthrough',
            )
        ),
        'tstamp' => array(
            'label' => 'tstamp',
            'config' => array(
                'type' => 'passthrough',
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => $llGeneral . 'LGL.hidden',
            'config' => array(
                'type' => 'check',
                'default' => 0
            )
        ),
        'starttime' => array(
            'exclude' => 1,
            'label' => $llGeneral . 'LGL.starttime',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 10,
                'eval' => 'datetime,int',
                'default' => 0,
            )
        ),
        'endtime' => array(
            'exclude' => 1,
            'label' => $llGeneral . 'LGL.endtime',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 10,
                'eval' => 'datetime,int',
                'default' => 0,
            )
        ),

        'header' => array(
            'exclude' => 1,
            'label' => $ll . 'header',
            'config' => array(
                'type' => 'input',
                'size' => 15,
                'max' => 30,
            )
        ),
        'parameter' => array(
            'exclude' => 0,
            'label' => $ll . 'parameter',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 50,
                'max' => 1024,
                'eval' => 'trim',
                'softref' => 'typolink'
            )
        ),
        'linktext' => array(
            'exclude' => 1,
            'label' => $ll . 'linktext',
            'config' => array(
                'type' => 'input',
                'size' => 15,
                'max' => 30,
            )
        ),
        'type' => array(
            'exclude' => 0,
            'label' => $ll . 'type',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array($ll . 'type.pleaseSelect', ''),
                    array($ll . 'type.facebook', 'facebook'),
                    array($ll . 'type.github', 'github'),
                    array($ll . 'type.gitlab', 'gitlab'),
                    array($ll . 'type.google', 'google'),
                    array($ll . 'type.pinterest', 'pinterest'),
                    array($ll . 'type.instagram', 'instagram'),
                    array($ll . 'type.linkedin', 'linkedin'),
                    array($ll . 'type.twitter', 'twitter'),
                    array($ll . 'type.vimeo', 'vimeo'),
                    array($ll . 'type.xing', 'xing'),
                    array($ll . 'type.youtube', 'youtube'),
                ),
                'size' => 1,
                'max' => 1,
            )
        ),
    ),
    'types' => array(
        0 => array(
            'showitem' =>
                '--palette--;'.$ll.'palette.name;paletteName,

                --div--;'.$ll.'tabs.language,
                    --palette--;'.$ll.'palette.language;paletteLanguage,

                --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                    --palette--;'.$llTtc.'palette.visibility;paletteVisbility,
                    --palette--;'.$llTtc.'palette.access;paletteAccess,'
        ),
    ),
    'palettes' => array(
        'paletteName' => array(
            'showitem' => 'header, --linebreak--, type, parameter, linktext',
            'canNotCollapse' => TRUE,
        ),

        'paletteVisbility' => array(
            'showitem' => 'hidden',
            'canNotCollapse' => TRUE,
        ),
        'paletteAccess' => array(
            'showitem' => 'starttime;'.$llTtc.'starttime_formlabel, endtime;'.$llTtc.'endtime_formlabel,',
            'canNotCollapse' => TRUE,
        ),
        'paletteLanguage' => array(
            'showitem' => '
                sys_language_uid;'.$llTtc.'sys_language_uid_formlabel,l10n_parent
            ',
        ),
    ),
);

return $extTca;