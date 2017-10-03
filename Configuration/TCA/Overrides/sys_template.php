<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$extensionKey = 'hwt_address';


/*
 * Default TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extensionKey, 'Configuration/TypoScript', 'Modern Address');