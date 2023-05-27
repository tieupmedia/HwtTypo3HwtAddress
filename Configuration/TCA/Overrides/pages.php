<?php

defined('TYPO3') || die('Access denied.');

/*
 * Add folder contains type,
 * mount page icon
 * (since TYPO3 7.5)
 */

$GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-hwtaddress'] = 'apps-pagetree-folder-contains-hwtaddress';

// add select option for hwtaddress
$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
    0 => 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_be.xlf:folder',
    1 => 'hwtaddress',
    2 => 'apps-pagetree-folder-contains-hwtaddress'
];

$extensionConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['hwt_address'];

// Add relation field, if activated in em config
if ($extensionConfiguration['enableRelationsInPages'] ?? false) {
    /*
     * Extend tca of pages
     */
    $tempColumns = [
        'tx_hwtaddress_related_address' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:pages.tx_hwtaddress_related_address',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_hwtaddress_domain_model_address',
                'foreign_table' => 'tx_hwtaddress_domain_model_address',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_hwtaddress_domain_model_pages_address_mm',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tempColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'pages',
        'tx_hwtaddress_related_address'
    );
}
