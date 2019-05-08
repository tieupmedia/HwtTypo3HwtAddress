<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}


$extensionKey = 'hwt_address';

/*
 * Add folder contains type
 */
if (TYPO3_MODE == 'BE') {
    /*
     * Mount page icon
     */
    if ( version_compare(TYPO3_version, '7.5.0') >= 0 ) {
            // since TYPO3 7.5
        $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-hwtaddress'] = 'apps-pagetree-folder-contains-hwtaddress';

        // add select option for hwtaddress
        $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = array(
            0 => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_be.xlf:folder',
            1 => 'hwtaddress',
            2 => 'apps-pagetree-folder-contains-hwtaddress'
        );
    }
    else {
            // before TYPO3 7.5
        $folderName = 'hwtaddress';
        $folderPath = '../typo3conf/ext/' . $extensionKey . '/Resources/Public/Icons/folder-hwtaddress.gif';

        unset($GLOBALS['ICON_TYPES'][$folderName]);

        \TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('pages', 'contains-'.$folderName, $folderPath);

        $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = array(
            0 => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_be.xlf:folder',
            1 => $folderName,
            2 => $folderPath
        );
    }
}


//$configurationUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extensionmanager\\Utility\\ConfigurationUtility');
//$extensionConfiguration = $configurationUtility->getCurrentConfiguration('hwt_address');
$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['hwt_address']);

// Add relation field, if activated in em config
if ( isset($extensionConfiguration['enableRelationsInPages']) && ($extensionConfiguration['enableRelationsInPages']==true) ) {
    // Extension locallang
    $ll = 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_db.xlf:pages.';

    /*
     * Extend tca of pages
     */
    $tempColumns = array(
        'tx_hwtaddress_related_address' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => $ll . 'tx_hwtaddress_related_address',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_hwtaddress_domain_model_address',
                'foreign_table' => 'tx_hwtaddress_domain_model_address',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_hwtaddress_domain_model_pages_address_mm',
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                    ),
                ),
            )
        ),
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tempColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'pages',
        'tx_hwtaddress_related_address'
    );
}