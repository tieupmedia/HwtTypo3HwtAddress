<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

/*
 * CSH Files
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hwtaddress_domain_model_address', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_address.xlf');

/*
 * allow db record on standard pages
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hwtaddress_domain_model_address');

/*
 * Plugin
 */
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY, 'Address', 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf:plugin_address'
);

$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_address';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/Address.xml');

/*
 * Default TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Modern Address');

/*
 * Wizard Plugin
 */
if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_' . strtolower($extensionName) . '_wizicon'] =
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Private/Php/class.tx_' . strtolower($extensionName) . '_wizicon.php';
}

/*
 * Add System Categories
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    $_EXTKEY,
    'tx_hwtaddress_domain_model_address',
    $fieldName = 'categories',
    $options = array()
);

/*
 * Extend tca pages
 */
$tempColumns = array(
    'tx_hwtaddress_related_address' => array(
        'exclude' => 1,
        'l10n_mode' => 'mergeIfNotBlank',
        'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xlf:pages.tx_hwtaddress_related_address',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'db',
            'allowed' => 'tx_hwtaddress_domain_model_address',
            'foreign_table' => 'tx_hwtaddress_domain_model_address',
//            'MM_opposite_field' => 'related_pages_from',
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
t3lib_extMgm::addTCAcolumns('pages', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('pages', 'tx_hwtaddress_related_address;;;;1-1-1, tx_hwtaddress_related_address_from');

/*
 * Add folder contains type
 */
if (TYPO3_MODE == 'BE') {
    $folderName = 'hwtaddr';
    $folderPath = '../typo3conf/ext/' . $_EXTKEY . '/Resources/Public/Icons/folder-hwtaddr.gif';

    unset($GLOBALS['ICON_TYPES'][$folderName]);

	\TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('pages', 'contains-'.$folderName, $folderPath);

    $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = array(
        0 => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf:folder',
        1 => $folderName,
        2 => $folderPath
    );
}