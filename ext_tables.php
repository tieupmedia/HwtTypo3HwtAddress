<?php

if (!defined('TYPO3')) {
    die('Access denied.');
}


/*
 * CSH Files
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hwtaddress_domain_model_address', 'EXT:hwt_address/Resources/Private/Language/locallang_csh_address.xlf');

/*
 * allow db record on standard pages
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hwtaddress_domain_model_address');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hwtaddress_domain_model_link');
