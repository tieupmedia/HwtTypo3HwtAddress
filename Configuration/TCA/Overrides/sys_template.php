<?php

if (!defined('TYPO3')) {
	die ('Access denied.');
}

$extensionKey = 'hwt_address';


/*
 * Default selectable TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extensionKey, 'Configuration/TypoScript', 'Modern Address');