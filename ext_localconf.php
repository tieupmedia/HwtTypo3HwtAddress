<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	'Hwt.' . $_EXTKEY,
	'Address',
	array(
		'Address' => 'list,single,search',
	),
	array(
		'Address' => 'list,single,search',
    )
);


// Register ke_search hooks
$emConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['hwt_address']);
if ($emConfiguration['enableKesearchHooks']) {
    // register custom indexer hook
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = 'EXT:' . $_EXTKEY . '/Classes/Hook/KeSearchHooks.php.php:Hwt\HwtAddress\Hooks\KeSearchHooks';

    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] = 'EXT:' . $_EXTKEY . '/Classes/Hook/KeSearchHooks.php.php:Hwt\HwtAddress\Hooks\KeSearchHooks';
}