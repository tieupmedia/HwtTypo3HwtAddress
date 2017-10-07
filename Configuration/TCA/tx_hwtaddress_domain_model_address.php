<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// Extension manager configuration
$emConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['hwt_address']);

$ll = 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:tx_hwtaddress_domain_model_address.';

// General locallang
$llGeneral = 'LLL:EXT:lang/locallang_general.xlf:';

// TCA locallang
$llTca = 'LLL:EXT:lang/locallang_tca.xlf:';

$extTca = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:tx_hwtaddress_domain_model_address',
        'label' => 'firstname',
        'label_alt' => 'lastname, company_title',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'default_sortby' => 'ORDER BY crdate',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('hwt_address') . 'Resources/Public/Icons/tx_hwtaddress_domain_model_address.gif',
        'searchFields' => 'uid,firstname,lastname,company_title,company_subtitle,zip,city',
    ),
    'interface' => array(
        'showRecordFieldList' => 'sorting,hidden,starttime,endtime,academic,firstname,lastname,gender,images,birthday,department,position,info,
            company_title,company_subtitle,company_short,company_bodytext,company_images,
            phone,mobile,fax,email,www,street,building,zip,city,region,country,longitude,latitude'
    ),
    'feInterface' => $TCA['tx_hwtaddress_domain_model_address']['feInterface'],
    'columns' => array(
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
                'size' => 8,
                'max' => 20,
                'eval' => 'datetime',
                'default' => 0,
            )
        ),
        'endtime' => array(
            'exclude' => 1,
            'label' => $llGeneral . 'LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 8,
                'max' => 20,
                'eval' => 'datetime',
                'default' => 0,
            )
        ),

        'academic' => array(
            'exclude' => 1,
            'label' => $ll . 'academic',
            'config' => array(
                'type' => 'input',
                'size' => 15,
                'max' => 20,
            )
        ),
        'firstname' => array(
            'exclude' => 1,
            'label' => $ll . 'firstname',
            'config' => array(
                'type' => 'input',
                'size' => 15,
            )
        ),
        'lastname' => array(
            'exclude' => 1,
            'label' => $ll . 'lastname',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),
        'gender' => array(
            'exclude' => 1,
            'label' => $ll . 'gender',
            'config' => array(
                'type' => 'radio',
                'items' => array(
                    array($ll . 'gender.0', '0'),
                    array($ll . 'gender.1', '1'),
                ),
            )
        ),
        'images' => array(
            'exclude' => 1,
            'label' => $ll . 'images',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'images',
                array(
                    'appearance' => array(
                        'headerThumbnail' => array(
                            'width' => '100',
                            'height' => '100',
                        ),
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                    ),
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the imageoverlayPalette instead of the basicoverlayPalette
                    'foreign_types' => array(
                        '0' => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        )
                    ),
                    'maxitems' => 1,
                ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ),
        'birthday' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $ll . 'birthday',
            'config' => array(
                'type' => 'input',
                'size' => 12,
                'max' => 20,
                'eval' => 'date',
            )
        ),

        'department' => array(
            'exclude' => 1,
            'label' => $ll . 'department',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),
        'position' => array(
            'exclude' => 1,
            'label' => $ll . 'position',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),

        'info' => array(
            'exclude' => 1,
            'l10n_mode' => 'noCopy',
            'label' => $ll . 'info',
            'config' => array(
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
            )
        ),

        'company_title' => array(
            'exclude' => 1,
            'label' => $ll . 'company_title',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),
        'company_subtitle' => array(
            'exclude' => 1,
            'label' => $ll . 'company_subtitle',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),
        'company_short' => array(
            'exclude' => 1,
            'l10n_mode' => 'noCopy',
            'label' => $ll . 'company_short',
            'config' => array(
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
            )
        ),
        'company_bodytext' => array(
            'exclude' => 1,
            'l10n_mode' => 'noCopy',
            'label' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext_formlabel',
            'defaultExtras' => 'richtext[]:rte_transform[mode=ts_css]',
            'config' => array(
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
                'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
                'wizards' => array(
                    '_PADDING' => 2,
                    'RTE' => array(
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'type' => 'script',
                        'title' => 'Full screen Rich Text Editing',
                        'icon' => 'wizard_rte2.gif',
                        'module' => array(
                            'name' => 'wizard_rte',
                        ),
                    ),
                ),
            )
        ),
        'company_images' => array(
            'exclude' => 1,
            'label' => $ll . 'company_images',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'company_images',
                array(
                    'appearance' => array(
                        'headerThumbnail' => array(
                            'width' => '100',
                            'height' => '100',
                        ),
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                    ),
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the imageoverlayPalette instead of the basicoverlayPalette
                    'foreign_types' => array(
                        '0' => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                            'showitem' => '
                                --palette--;' . $llTca . 'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        )
                    ),
                    'maxitems' => 1,
                ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ),

        'phone' => array(
            'exclude' => 1,
            'label' => $ll . 'phone',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 30,
            )
        ),
        'mobile' => array(
            'exclude' => 1,
            'label' => $ll . 'mobile',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 30,
            )
        ),
        'fax' => array(
            'exclude' => 1,
            'label' => $ll . 'fax',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 30,
            )
        ),
        'email' => array(
            'exclude' => 1,
            'label' => $ll . 'email',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 80,
            )
        ),
        'www' => array(
            'exclude' => 1,
            'label' => $ll . 'www',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 80,
            )
        ),
        'links' => array(
            'exclude' => 1,
            'label' => $ll . 'links',
            'config' => array(
                'type' => 'inline',
                'allowed' => 'tx_hwtaddress_domain_model_link',
                'foreign_table' => 'tx_hwtaddress_domain_model_link',
                'foreign_sortby' => 'sorting',
                'foreign_field' => 'address',
                'minitems' => 0,
                'maxitems' => 20,
                'appearance' => array(
                'collapse' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'building' => array(
            'exclude' => 1,
            'label' => $ll . 'building',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 20,
            )
        ),
        'street' => array(
            'exclude' => 0,
            'label' => $ll . 'street',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),
        'zip' => array(
            'exclude' => 0,
            'label' => $ll . 'zip',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 20,
            )
        ),
        'city' => array(
            'exclude' => 0,
            'label' => $ll . 'city',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 80,
            )
        ),
        'region' => array(
            'exclude' => 1,
            'label' => $ll . 'region',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 100,
            )
        ),
        'country' => array(
            'exclude' => 1,
            'label' => $ll . 'country',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 100,
            )
        ),
        'longitude' => array(
            'exclude' => 1,
            'label' => $ll . 'longitude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),
        'latitude' => array(
            'exclude' => 1,
            'label' => $ll . 'latitude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),

        'related_address' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $ll . 'related_address',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_hwtaddress_domain_model_address',
                'foreign_table' => 'tx_hwtaddress_domain_model_address',
                'MM_opposite_field' => 'related_address_from',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_hwtaddress_domain_model_address_related_mm',
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                    ),
                ),
            )
        ),
        'related_address_from' => array(
            'exclude' => 1,
            'label' => $ll . 'related_address_from',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'db',
                'foreign_table' => 'tx_hwtaddress_domain_model_address',
                'allowed' => 'tx_hwtaddress_domain_model_address',
                'size' => 5,
                'maxitems' => 100,
                'MM' => 'tx_hwtaddress_domain_model_address_related_mm',
                'readOnly' => 1,
            )
        ),
    //		'related_pages' => array(
    //			'exclude' => 1,
    //			'l10n_mode' => 'mergeIfNotBlank',
    //			'label' => $ll . 'related_pages',
    //			'config' => array(
    //				'type' => 'group',
    //				'internal_type' => 'db',
    //				'allowed' => 'pages',
    //				'foreign_table' => 'pages',
    //                'MM_opposite_field' => 'tx_hwtaddress_related_address_from',
    //				'size' => 5,
    //				'minitems' => 0,
    //				'maxitems' => 100,
    //				'MM' => 'tx_hwtaddress_domain_model_address_pages_mm',
    //				'wizards' => array(
    //					'suggest' => array(
    //						'type' => 'suggest',
    //					),
    //				),
    //			)
    //		),
        'related_pages_from' => array(
            'exclude' => 1,
            'label' => $ll . 'related_pages_from',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'foreign_table' => 'pages',
                'MM_opposite_field' => 'tx_hwtaddress_related_address',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_hwtaddress_domain_model_pages_address_mm',
                /*'MM_match_fields' => array(
                    'tablenames' => 'pages'
                ),*/
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                    ),
                ),
    //                'readOnly' => 1,
            )
        ),
    ),
    'types' => array(
        0 => array(
            'showitem' =>
                '--palette--;'.$ll.'palette.name;paletteName,
                    birthday,info, --palette--;'.$ll.'palette.employee;paletteEmployee, images,

                --div--;'.$ll.'tabs.company,
                    company_title;;paletteCompanyTitle,company_short,company_bodytext,company_images,

                --div--;'.$ll.'tabs.address,
                    --palette--;'.$ll.'palette.electronic_address;paletteElectronicAddress,
                    --palette--;'.$ll.'palette.location_address;paletteLocationAddress,
                    --palette--;'.$ll.'palette.geographical_address;paletteGeographicalAddress,

                --div--;'.$ll.'tabs.relations,
                    --palette--;'.$ll.'palette.relations_address;paletteRelationsAddress,
                    --palette--;'.$ll.'palette.relations_pages;paletteRelationsPages,

                --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;paletteVisbility,
                    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;paletteAccess,'
        ),
    ),
    'palettes' => array(
        'paletteName' => array(
            'showitem' => 'academic, gender, --linebreak--, firstname,lastname,',
            'canNotCollapse' => TRUE,
        ),
        'paletteEmployee' => array(
            'showitem' => 'department, position',
            'canNotCollapse' => TRUE,
        ),
        'paletteCompanyTitle' => array(
            'showitem' => 'company_subtitle',
            'canNotCollapse' => TRUE,
        ),

        'paletteElectronicAddress' => array(
            'showitem' => 'phone, fax, --linebreak--, mobile, email, --linebreak--, www, --linebreak--, links',
            'canNotCollapse' => TRUE,
        ),
        'paletteLocationAddress' => array(
            'showitem' => 'street, building, --linebreak--, zip, city, --linebreak--, region, country',
            'canNotCollapse' => TRUE,
        ),
        'paletteGeographicalAddress' => array(
            'showitem' => 'longitude, latitude',
            'canNotCollapse' => TRUE,
        ),

        'paletteRelationsAddress' => array(
            'showitem' => 'related_address, --linebreak--, related_address_from',
            'canNotCollapse' => TRUE,
        ),
        'paletteRelationsPages' => array(
            'showitem' => 'related_pages, --linebreak--, related_pages_from',
            'canNotCollapse' => TRUE,
        ),

        'paletteVisbility' => array(
            'showitem' => 'hidden',
            'canNotCollapse' => TRUE,
        ),
        'paletteAccess' => array(
            'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xlf:starttime_formlabel, endtime;LLL:EXT:cms/locallang_ttc.xlf:endtime_formlabel,',
            'canNotCollapse' => TRUE,
        ),
    ),
);

if (!$emConfiguration['enableRelationsInPages']) {
    unset($extTca['columns']['related_pages_from']);
}

return $extTca;