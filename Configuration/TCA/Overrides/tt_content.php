<?php

if (!defined('TYPO3')) {
    die('Access denied.');
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

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginIdentifier] = 'recursive,select_key,pages';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginIdentifier] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        $pluginIdentifier,
        'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/' . $pluginName . '.xml'
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['previewRenderer'][$pluginIdentifier] = \Hwt\HwtAddress\Preview\PluginPreviewRenderer::class;
}