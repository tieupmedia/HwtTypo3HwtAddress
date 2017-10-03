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
 * Wizard Plugin
 */
if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_' . strtolower($extensionName) . '_wizicon'] =
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Private/Php/class.tx_' . strtolower($extensionName) . '_wizicon.php';
}

/*
 * Add System Categories (deprecated since TYPO3 6.2.1)
 */
/*\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    $_EXTKEY,
    'tx_hwtaddress_domain_model_address',
    $fieldName = 'categories',
    $options = array()
);*/
