<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}


// DB locallang
$ll = 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:tx_hwtaddress_domain_model_address.';

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
        'iconfile' => 'EXT:hwt_address/Resources/Public/Icons/tx_hwtaddress_domain_model_address.gif',
        'searchFields' => 'uid,firstname,lastname,company_title,company_subtitle,zip,city',

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
    ),
    'interface' => array(
        'showRecordFieldList' => 'sorting,hidden,starttime,endtime,academic,firstname,lastname,gender,images,assets,birthday,department,position,info,
            company_title,company_subtitle,company_short,company_bodytext,company_images,
            phone,mobile,fax,email,www,street,building,zip,city,region,country,longitude,latitude'
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
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
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
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            )
        ),

        'academic' => array(
            'exclude' => 1,
            'label' => $ll . 'academic',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'max' => 30,
            )
        ),
        'firstname' => array(
            'exclude' => 1,
            'label' => $ll . 'firstname',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 15,
            )
        ),
        'lastname' => array(
            'exclude' => 1,
            'label' => $ll . 'lastname',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),
        'gender' => array(
            'exclude' => 1,
            'label' => $ll . 'gender',
            'l10n_mode' => 'exclude',
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
            'l10n_mode' => 'exclude',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'images',
                array(
                    'appearance' => array(
                        'headerThumbnail' => array(
                            'width' => '100',
                            'height' => '100',
                        ),
                        'createNewRelationLinkTitle' => $llTtc.'images.addFileReference'
                    ),
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => array(
                        'types' => array(
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
                    ),
                    'maxitems' => 1,
                ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ),
        'assets' => array(
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('assets', array(
                'appearance' => array(
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references.addFileReference'
                ),
                // custom configuration for displaying fields in the overlay/reference table
                // behaves the same as the image field.
                'overrideChildTca' => array(
                    'types' => array(
                        '0' => array(
                            'showitem' => '
                                --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
                            'showitem' => '
                                --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                            'showitem' => '
                                --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
                            'showitem' => '
                                --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.audioOverlayPalette;audioOverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
                            'showitem' => '
                                --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.videoOverlayPalette;videoOverlayPalette,
                                --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                            'showitem' => '
                                --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                --palette--;;filePalette'
                        )
                    ),
                ),
            ), $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'])
        ),
        'birthday' => array(
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'label' => $ll . 'birthday',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'date',
                'default' => 0,
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
            'l10n_mode' => 'exclude',
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
            'label' => $ll . 'company_short',
            'config' => array(
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
            )
        ),
        'company_bodytext' => array(
            'exclude' => 1,
            'label' => $llTtc.'bodytext_formlabel',
            'config' => array(
                'type' => 'text',
                'enableRichtext' => true,
                'fieldControl' => array(
                    'fullScreenRichtext' => array(
                        'disabled' => false,
                    ),
                ),
                'cols' => 30,
                'rows' => 5,
                'softref' => 'rtehtmlarea_images,typolink_tag,images,email[subst],url',
            )
        ),
        'company_images' => array(
            'exclude' => 1,
            'label' => $ll . 'company_images',
            # Cannot be set to avoid bug: https://forge.typo3.org/issues/75850
            #'l10n_mode' => 'exclude',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'company_images',
                array(
                    'behaviour' => array(
                        'allowLanguageSynchronization' => true
                    ),
                    'appearance' => array(
                        'headerThumbnail' => array(
                            'width' => '100',
                            'height' => '100',
                        ),
                        'createNewRelationLinkTitle' => $llTtc.'images.addFileReference'
                    ),
                    // custom configuration for displaying fields in the overlay/reference table
                    // to use the imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => array(
                        'types' => array(
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
                    ),
                    'maxitems' => 1,
                ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ),

        'phone' => array(
            'exclude' => 1,
            'label' => $ll . 'phone',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 30,
            )
        ),
        'mobile' => array(
            'exclude' => 1,
            'label' => $ll . 'mobile',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 30,
            )
        ),
        'fax' => array(
            'exclude' => 1,
            'label' => $ll . 'fax',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 30,
            )
        ),
        'email' => array(
            'exclude' => 1,
            'label' => $ll . 'email',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 80,
            )
        ),
        'www' => array(
            'exclude' => 1,
            'label' => $ll . 'www',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 80,
            )
        ),
        'links' => array(
            'exclude' => 1,
            'label' => $ll . 'links',
            //'l10n_mode' => 'exclude',
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
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 20,
            )
        ),
        'street' => array(
            'exclude' => 0,
            'label' => $ll . 'street',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),
        'zip' => array(
            'exclude' => 0,
            'label' => $ll . 'zip',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 20,
            )
        ),
        'city' => array(
            'exclude' => 0,
            'label' => $ll . 'city',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 80,
            )
        ),
        'region' => array(
            'exclude' => 1,
            'label' => $ll . 'region',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 100,
            )
        ),
        'country' => array(
            'exclude' => 1,
            'label' => $ll . 'country',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 100,
            )
        ),
        'longitude' => array(
            'exclude' => 1,
            'label' => $ll . 'longitude',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),
        'latitude' => array(
            'exclude' => 1,
            'label' => $ll . 'latitude',
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'input',
                'size' => 30,
            )
        ),

        'related_address' => array(
            'exclude' => 1,
            'l10n_mode' => 'exclude',
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
            )
        ),
        'related_address_from' => array(
            'exclude' => 1,
            'label' => $ll . 'related_address_from',
            'l10n_mode' => 'exclude',
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
        'related_pages_from' => array(
            'exclude' => 1,
            'label' => $ll . 'related_pages_from',
            'l10n_mode' => 'exclude',
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
            )
        ),
    ),
    'types' => array(
        0 => array(
            'showitem' =>
                '--palette--;'.$ll.'palette.name;paletteName,
                    birthday,info, --palette--;'.$ll.'palette.employee;paletteEmployee, images, assets,

                --div--;'.$ll.'tabs.company,
                    --palette--;'.$ll.'palette.company_title;paletteCompanyTitle, company_short,company_bodytext,company_images,

                --div--;'.$ll.'tabs.address,
                    --palette--;'.$ll.'palette.electronic_address;paletteElectronicAddress,
                    --palette--;'.$ll.'palette.location_address;paletteLocationAddress,
                    --palette--;'.$ll.'palette.geographical_address;paletteGeographicalAddress,

                --div--;'.$ll.'tabs.relations,
                    --palette--;'.$ll.'palette.relations_address;paletteRelationsAddress,
                    --palette--;'.$ll.'palette.relations_pages;paletteRelationsPages,

                --div--;'.$ll.'tabs.language,
                    --palette--;'.$ll.'palette.language;paletteLanguage,

                --div--;'.$llTtc.'tabs.access,
                    --palette--;'.$llTtc.'palette.visibility;paletteVisbility,
                    --palette--;'.$llTtc.'palette.access;paletteAccess,'

        ),
    ),
    'palettes' => array(
        'paletteName' => array(
            'showitem' => 'l10n_parent, l10n_diffsource, academic, gender, --linebreak--, firstname,lastname,',
            'canNotCollapse' => TRUE,
        ),
        'paletteEmployee' => array(
            'showitem' => 'department, position',
            'canNotCollapse' => TRUE,
        ),
        'paletteCompanyTitle' => array(
            'showitem' => 'company_title, --linebreak--, company_subtitle',
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


// Get extension manager configuration
$emConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['hwt_address']);

// Remove relation field, if not activated in em config
if (!$emConfiguration['enableRelationsInPages']) {
    unset($extTca['columns']['related_pages_from']);
}

return $extTca;