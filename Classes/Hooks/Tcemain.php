<?php

namespace Hwt\HwtAddress\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Heiko Westermann <hwt3@gmx.de>
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
class Tcemain {
    /*
     * Generate a different preview link
     * @param string $status status
     * @param string $table table name
     * @param integer $recordUid id of the record
     * @param array $fields fieldArray
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $parentObject parent Object
     * @return void
     */
    public function processDatamap_afterDatabaseOperations($status, $table, $recordUid, array $fields, \TYPO3\CMS\Core\DataHandling\DataHandler $parentObject) {

        // Preview link
        if ($table === 'tx_hwtaddress_domain_model_address') {

            // direct preview
            if (!is_numeric($recordUid)) {
                $recordUid = $parentObject->substNEWwithIDs[$recordUid];
            }

            if (isset($GLOBALS['_POST']['_savedokview_x'])) {
                // If "savedokview" has been pressed
                $pagesTsConfig = \TYPO3\CMS\Backend\Utility\BackendUtility::getPagesTSconfig($GLOBALS['_POST']['popViewId']);
                $pagesTsConfigSinglePid = $pagesTsConfig['tx_hwtaddress.']['singlePidAddress'];
                if ($pagesTsConfigSinglePid) {
                    $record = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($table, $recordUid);

                    $parameters = array(
                        'no_cache' => 1,
                        'tx_hwtaddress_address[address]' => $recordUid,
                    );

                    $GLOBALS['_POST']['popViewId_addParams'] = \TYPO3\CMS\Core\Utility\GeneralUtility::implodeArrayForUrl('', $parameters, '', FALSE, TRUE);
                    $GLOBALS['_POST']['popViewId'] = $pagesTsConfigSinglePid;
                }
            }
        }

    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/hwt_address/Classes/Hooks/Tcemain.php']) {
    include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/hwt_address/Classes/Hooks/Tcemain.php']);
}