<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}


/*
 * Add System Categories
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    'hwt_address',
    'tx_hwtaddress_domain_model_address',
    $fieldName = 'categories',
    $options = array()
);