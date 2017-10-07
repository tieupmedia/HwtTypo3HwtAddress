<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Hwt.' . $_EXTKEY,
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
 * Register hook for preview of records
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] = 'Hwt\\HwtAddress\\Hooks\\Tcemain';


/*
 * Register CmsLayout hook
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['hwtaddress_address'][$_EXTKEY] = 'Hwt\\HwtAddress\\Hooks\\CmsLayout->getExtensionSummary';


if (TYPO3_MODE === 'BE') {
    /*
     * Register folder icon
     * For TYPO3 >= 7.5, older version just need tca.php codes
     */
    if ( version_compare(TYPO3_version, '7.5.0') >= 0 ) {
        /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Imaging\\IconRegistry');

        $iconRegistry->registerIcon(
            'apps-pagetree-folder-contains-hwtaddress',
            'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\BitmapIconProvider',
            array('source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/folder-hwtaddress.gif')
        );
    }
}