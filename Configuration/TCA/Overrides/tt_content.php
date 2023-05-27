<?php

defined('TYPO3') || die('Access denied.');

/*
 * Register plugin
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'hwt_address',
    'Address',
    'LLL:EXT:hwt_address/Resources/Private/Language/locallang_be.xlf:plugin_address'
);

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase('hwt_address');
$pluginSignature = strtolower($extensionName) . '_address';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:hwt_address/Configuration/FlexForms/Address.xml');
