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
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY, 'Address', 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf:plugin_address'
);

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
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
            0 => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf:folder',
            1 => 'hwtaddress',
            2 => 'apps-pagetree-folder-contains-hwtaddress'
        );
    }
    else {
            // before TYPO3 7.5
        $folderName = 'hwtaddress';
        $folderPath = '../typo3conf/ext/' . $_EXTKEY . '/Resources/Public/Icons/folder-hwtaddress.gif';

        unset($GLOBALS['ICON_TYPES'][$folderName]);

        \TYPO3\CMS\Backend\Sprite\SpriteManager::addTcaTypeIcon('pages', 'contains-'.$folderName, $folderPath);

        $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = array(
            0 => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf:folder',
            1 => $folderName,
            2 => $folderPath
        );
    }
}