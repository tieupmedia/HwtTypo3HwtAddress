<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$extensionKey = 'hwt_address';


/*
 * Configure plugin(s)
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hwt.' . $extensionKey,
    'Address',
    array(
        'Address' => 'list,single,search',
    ),
    array(
        'Address' => 'list,single,search',
    )
);


/*
 * Register ke_search hooks
 */
$emConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['hwt_address']);
if ($emConfiguration['enableKesearchHooks']) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = 'Hwt\\HwtAddress\\Hooks\\KeSearchHooks';
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] = 'Hwt\\HwtAddress\\Hooks\\KeSearchHooks';
}


/*
 * Register CmsLayout hook
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['hwtaddress_address'][$_EXTKEY] = 'Hwt\\HwtAddress\\Hooks\\CmsLayout->getExtensionSummary';


/*
 * Add pageTS
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:hwt_address/Configuration/TSconfig/ContentElementWizard/mod.wizards.txt">
');


if (TYPO3_MODE === 'BE') {
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
            array('source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/' . $file)
        );
    }
}