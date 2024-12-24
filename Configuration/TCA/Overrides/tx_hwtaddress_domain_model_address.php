<?php

if (!defined('TYPO3')) {
    die ('Access denied.');
}


/*
 * Add System Categories
 */
$GLOBALS['TCA']['tx_hwtaddress_domain_model_address']['columns']['categories'] = [
   'config' => [
      'type' => 'category'
   ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_hwtaddress_domain_model_address', 'categories');
