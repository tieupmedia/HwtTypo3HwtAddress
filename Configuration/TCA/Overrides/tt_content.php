<?php

if (!defined('TYPO3')) {
	die ('Access denied.');
}

$extensionKey = 'hwt_address';


/*
 * Register plugins
 */
$pluginKeys = ['address_list', 'address_single', 'address_search_form'];
foreach ($pluginKeys as $pluginKey) {
    $pluginIdentifier = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $extensionKey,
        $pluginName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($pluginKey),
        'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_be.xlf:plugin.' . $pluginKey . '.title'
    );

    // Fallback for TYPO3 <= 12.0
    // https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.0/Feature-82809-MakeExtensionUtilityregisterPluginMethodReturnPluginSignature.html
    if (!$pluginIdentifier) {
        $pluginIdentifier = str_replace(' ', '', $extensionKey) . '_' .  str_replace(' ', '', $pluginKey);
    }

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginIdentifier] = 'recursive,select_key,pages';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginIdentifier] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        $pluginIdentifier,
        'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/' . $pluginName . '.xml'
    );
}
