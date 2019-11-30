<?php

declare(strict_types = 1);

namespace Hwt\HwtAddress\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015-2019 Heiko Westermann <hwt3@gmx.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Hook into tcemain which is used to show preview of items
 *
 * @package TYPO3
 * @subpackage hwt_address
 */
class CmsLayout {
    /**
     * Extension key
     *
     * @var string
     */
    const KEY = 'hwt_address';

    /**
     * Path to the locallang file
     *
     * @var string
     */
    const LLPATH = 'LLL:EXT:hwt_address/Resources/Private/Language/locallang_be.xlf:';

    /**
     * Flexform information
     *
     * @var array
     */
    public $flexformData = array();

    /**
     * Table information
     *
     * @var array
     */
    public $tableData = array();



    /**
     * Returns translations
     *
     * @param	string		$llPathAndKey	Parameter with the locallang path and key
     * @return	string		The translation
     */
    function getPluginLL($llPathAndKey) {
        $llValue = $GLOBALS['LANG']->sL($llPathAndKey);
        return htmlspecialchars($llValue);
    }

    /**
     * Returns information about this extension's pi1 plugin
     *
     * @param	array		$params	Parameters to the hook
     * @param	object		$pObj	A reference to calling object
     * @return	string		Information about pi1 plugin
     */
    function getExtensionSummary($params, &$pObj) {
        $result = '';

        if ($params['row']['list_type'] == 'hwtaddress_address') {
            $result .= '<br /><strong>' . $this->getPluginLL(self::LLPATH . 'plugin_address') . '</strong><br />';

            $this->flexformData = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($params['row']['pi_flexform']);


            $actions = $this->getFieldFromFlexform('switchableControllerActions');
            $actionsArray = explode(';', $actions);
            foreach ( $actionsArray as $action ) {
                $action = strtolower(str_replace('->', '_', $action));
                $result .= $this->getPluginLL(self::LLPATH . 'flexform_setting.mode.' . $action) . ' ';
            }



            /*
             * Plugin settings
             */
            $this->tableData[] = array(
                $this->getPluginLL(self::LLPATH . 'flexform_setting.addressStoragePages'),
                $this->getFieldFromFlexform('settings.addressStoragePages')
            );

            if ($actions === 'Address->single') {
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.addressSingleRecord'),
                    $this->getFieldFromFlexform('settings.addressSingleRecord')
                );
            }
            elseif (($actions === 'Address->list;Address->single')) {
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.addressRecords'),
                    $this->getFieldFromFlexform('settings.addressRecords')
                );
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.orderBy'),
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.orderBy.' . $this->getFieldFromFlexform('settings.orderBy'))
                );
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.orderDirection'),
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.orderDirection.' . $this->getFieldFromFlexform('settings.orderDirection'))
                );
            }

            $this->tableData[] = array(
                $this->getPluginLL(self::LLPATH . 'flexform_setting.addressCategories'),
                $this->getFieldFromFlexform('settings.addressCategories')
            );



            /*
             * Template variants
             */
            if ($actions === 'Address->single') {
                $variantField = $this->getFieldFromFlexform('settings.templateVariantSingle', 'template');
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.templateVariantSingle'),
                    ($variantField ? ucfirst($variantField) : '')
                );
            }
            elseif (($actions === 'Address->list;Address->single')) {
                $variantField = $this->getFieldFromFlexform('settings.templateVariantList', 'template');
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.templateVariantList'),
                    ($variantField ? ucfirst($variantField) : '')
                );

                $variantField = $this->getFieldFromFlexform('settings.templateVariantSingle', 'template');
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.templateVariantSingle'),
                    ($variantField ? ucfirst($variantField) : '')
                );
            }
            elseif (($actions === 'Address->search')) {
                $variantField = $this->getFieldFromFlexform('settings.templateVariantSearch', 'template');
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.templateVariantSearch'),
                    ($variantField ? ucfirst($variantField) : '')
                );
            }



            $result .= $this->renderSettingsAsTable();
        }

        return $result;
    }



    /**
     * Get field value from flexform configuration,
     * including checks if flexform configuration is available
     *
     * @param string $key name of the key
     * @param string $sheet name of the sheet
     * @return string|NULL if nothing found, value if found
     */
    public function getFieldFromFlexform($key, $sheet = 'sDEF') {
        $flexform = $this->flexformData;
        if (isset($flexform['data'])) {
            $flexform = $flexform['data'];
            if (is_array($flexform) && is_array($flexform[$sheet]) && is_array($flexform[$sheet]['lDEF'])
                && is_array($flexform[$sheet]['lDEF'][$key]) && isset($flexform[$sheet]['lDEF'][$key]['vDEF'])
            ) {
                return $flexform[$sheet]['lDEF'][$key]['vDEF'];
            }
        }

        return NULL;
    }



    /**
     * Render the settings as table for Web>Page module
     * System settings are displayed in mono font
     *
     * @return string
     */
    protected function renderSettingsAsTable() {
        if (count($this->tableData) == 0) {
            return '';
        }

        $content = '';
        foreach ($this->tableData as $line) {
            $content .= '<strong>' . $line[0] . '</strong>' . ' ' . $line[1] . '<br />';
        }

        return '<pre style="white-space:normal">' . $content . '</pre>';
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/hwt_address/Classes/Hooks/CmsLayout.php']) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/hwt_address/Classes/Hooks/CmsLayout.php']);
}