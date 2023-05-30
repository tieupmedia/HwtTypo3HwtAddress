<?php

defined('TYPO3') || die('Access denied.');

/*
 * Configure plugin(s)
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'hwt_address',
    'Address',
    [
        \Hwt\HwtAddress\Controller\AddressController::class => 'list,single,search',
    ],
    [
        \Hwt\HwtAddress\Controller\AddressController::class => 'list,single,search',
    ]
);


/*
 * Register ke_search hooks
 */
$emConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['hwt_address'];
if ($emConfiguration['enableKesearchHooks']) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = 'Hwt\\HwtAddress\\Hooks\\KeSearchHooks';
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] = 'Hwt\\HwtAddress\\Hooks\\KeSearchHooks';
}


/*
 * Register CmsLayout hook
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['hwtaddress_address']['hwt_address'] = 'Hwt\\HwtAddress\\Hooks\\CmsLayout->getExtensionSummary';


/*
 * Add pageTS
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
    @import \'EXT:hwt_address/Configuration/TSconfig/ContentElementWizard/mod.wizards.txt\'
');

/*
 * Register icons
 */
$icons = [
    'apps-pagetree-folder-contains-hwtaddress' => 'folder-hwtaddress.gif',
    'ext-hwtaddress-wizard-icon' => 'ce_wiz.gif',
];

/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

foreach ($icons as $identifier => $file) {
    $iconRegistry->registerIcon(
        $identifier,
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => 'EXT:hwt_address/Resources/Public/Icons/' . $file]
    );
}
