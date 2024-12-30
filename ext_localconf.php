<?php

if (!defined('TYPO3')) {
    die ('Access denied.');
}

$extensionKey = 'hwt_address';


/*
 * Configure plugins
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    $extensionKey,
    'AddressList',
    array(
        \Hwt\HwtAddress\Controller\AddressController::class => 'list',
    ),
    array(
        \Hwt\HwtAddress\Controller\AddressController::class => 'list',
    )
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    $extensionKey,
    'AddressSingle',
    array(
        \Hwt\HwtAddress\Controller\AddressController::class => 'single',
    ),
    array(
        \Hwt\HwtAddress\Controller\AddressController::class => 'single',
    )
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    $extensionKey,
    'AddressSearchForm',
    array(
        \Hwt\HwtAddress\Controller\AddressController::class => 'searchForm',
    ),
    array(
        \Hwt\HwtAddress\Controller\AddressController::class => 'searchForm',
    )
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(trim('
    plugin {
        tx_hwtaddress_addresslist.view.pluginNamespace = tx_hwtaddress_address
        tx_hwtaddress_addresssingle.view.pluginNamespace = tx_hwtaddress_address
        tx_hwtaddress_addresssearchform.view.pluginNamespace = tx_hwtaddress_address
    }
'));


/*
 * Register ke_search hooks
 */
$emConfiguration = isset($GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['hwt_address']) ? $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['hwt_address'] : [];
if (isset($emConfiguration['enableKesearchHooks']) && $emConfiguration['enableKesearchHooks']) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = 'Hwt\\HwtAddress\\Hooks\\KeSearchHooks';
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] = 'Hwt\\HwtAddress\\Hooks\\KeSearchHooks';
}


/*
 * Add pageTS
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:hwt_address/Configuration/TSconfig/ContentElementWizard/mod.wizards.tsconfig">
');



/*
 * Register folder icon
 * (For TYPO3 >= 7.5)
 */
$icons = array(
    'apps-pagetree-folder-contains-hwtaddress' => 'folder-hwtaddress.gif',
    'ext-hwtaddress-wizard-icon' => 'ce_wiz.gif',
);

/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Imaging\\IconRegistry');

foreach ($icons as $identifier => $file) {
    $iconRegistry->registerIcon(
        $identifier,
        'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\BitmapIconProvider',
        array('source' => 'EXT:' . $extensionKey . '/Resources/Public/Icons/' . $file)
    );
}