<?php

declare(strict_types = 1);

namespace Hwt\HwtAddress\Preview;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2024 Heiko Westermann <hwt3@gmx.de>
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
 * Page preview renderer which is used to show preview of items in the backend.
 *
 * @package TYPO3
 * @subpackage hwt_address
 */
class PluginPreviewRenderer extends \TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer {
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
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException
     * @throws \TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException
     */
    public function renderPageModulePreviewContent(\TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem $item): string
    {
        $row = $item->getRecord();

		$pluginLLKey = str_replace('hwtaddress_address', 'plugin.address_', $row['list_type']);
		if ($pluginLLKey === 'plugin.address_searchform') {
			$pluginLLKey = 'plugin.address_search_form';
		}
        $result = '<br /><strong>' . $this->getPluginLL(self::LLPATH . $pluginLLKey . '.title') . '</strong><br />';

        $flexforms = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($row['pi_flexform']);
        if (is_string($flexforms)) {
            return 'ERROR: ' . htmlspecialchars($flexforms);
        }
        $this->flexformData = (array)$flexforms;

        if (!empty($this->flexformData)) {
            /*
             * Plugin settings
             */
            $this->tableData[] = array(
                $this->getPluginLL(self::LLPATH . 'flexform_setting.addressStoragePages'),
                $this->getFieldFromFlexform('settings.addressStoragePages')
            );

            if ($row['list_type'] === 'hwtaddress_addresssingle') {
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.addressSingleRecord'),
                    $this->getFieldFromFlexform('settings.addressSingleRecord')
                );
            }
            elseif ($row['list_type'] === 'hwtaddress_addresslist') {
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
            if ($row['list_type'] === 'hwtaddress_addresssingle') {
                $variantField = $this->getFieldFromFlexform('settings.templateVariantSingle', 'template');
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.templateVariantSingle'),
                    ($variantField ? ucfirst($variantField) : '')
                );
            }
            elseif ($row['list_type'] === 'hwtaddress_addresslist') {
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
            elseif ($row['list_type'] === 'hwtaddress_addresssearchform') {
                $variantField = $this->getFieldFromFlexform('settings.templateVariantSearchForm', 'template');
                $this->tableData[] = array(
                    $this->getPluginLL(self::LLPATH . 'flexform_setting.templateVariantSearchForm'),
                    ($variantField ? ucfirst($variantField) : '')
                );
            }



            $result .= $this->renderSettingsAsTable();
        }
        return $result;
    }



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
                && isset($flexform[$sheet]['lDEF'][$key]) && is_array($flexform[$sheet]['lDEF'][$key]) && isset($flexform[$sheet]['lDEF'][$key]['vDEF'])
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
