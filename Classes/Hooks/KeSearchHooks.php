<?php

declare(strict_types = 1);

namespace Hwt\HwtAddress\Hooks;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
//use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * ke_search hooks
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
class KeSearchHooks {
    /**
     * indexer configurations
     *
     * Adds the custom indexer to the TCA of indexer configurations, so that
     * it's selectable in the backend as an indexer type when you create a
     * new indexer configuration.
     *
     * @param array $params
     * @param type $pObj
     */
    function registerIndexerConfiguration(&$params, $pObj) {

        // add address indexer item to "type" field
        $newArray = array(
            'Modern Address (hwt_address)',
            'hwtaddressindexer',
            'EXT:hwt_address/Resources/Public/Icons/tx_hwtaddress_domain_model_address.gif'
        );
        $params['items'][] = $newArray;

        // enable "sysfolder" field
        $GLOBALS['TCA']['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'] .= ',hwtaddressindexer';
    }


    /**
    * Address indexer
    *
    * @param array $indexerConfig Configuration from TYPO3 Backend
    * @param array $indexerObject Reference to indexer class.
    * @return string Output.
    */
    public function customIndexer(&$indexerConfig, &$indexerObject) {
        /*
         * address indexing
         */
        if($indexerConfig['type'] == 'hwtaddressindexer') {
            $content = '';

            // get all the entries to index
            // don't index hidden or deleted elements, BUT
            // get the elements with frontend user group access restrictions
            // or time (start / stop) restrictions.
            // Copy those restrictions to the index.
            $sysfolders = GeneralUtility::intExplode(',', $indexerConfig['storagepid'], true);
            if ($sysfolders === '' || count($sysfolders) === 0) {
                $sysfolders = null;
            }


            $fields = '*';
            $table = 'tx_hwtaddress_domain_model_address';

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);

            //$queryBuilder->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));

            $statement = $queryBuilder->select($fields)->from($table);
            if ( $sysfolders ) {
                $statement->where(
                    $queryBuilder->expr()->in('pid', $sysfolders)
                );
            }
            $statement = $statement->execute();


            // Loop through the records and write them to the index.
            while ( ($record = $statement->fetch()) ) {
                // compile the information which should go into the index
                // the field names depend on the table you want to index!
                $title = strip_tags($record['firstname'] . "\n" . $record['lastname'] . "\n" . $record['company_title']);
                $abstract = strip_tags($record['position'] . "\n" . $record['department'] . "\n" . $record['company_subtitle'] . "\n" . $record['company_short']);
                $content = strip_tags($record['info'] . "\n" . $record['company_bodytext']);
                $fullContent = $title . "\n" . $abstract . "\n" . $content;
                $params = '&tx_hwtaddress_address[address]=' . $record['uid'];
                //$tags = '#example_tag_1#,#example_tag_2#';
                $additionalFields = array(
                    'sortdate' => $record['crdate'],
                    'orig_uid' => $record['uid'],
                    'orig_pid' => $record['pid'],
                    'sortdate' => $record['datetime'],
                );

                // add something to the title, just to identify the entries
                // in the frontend
                $title = $title;

                // ... and store the information in the index
                $indexerObject->storeInIndex(
                    $indexerConfig['storagepid'], // storage PID
                    $title, // record title
                    'hwtaddressindexer', // content type
                    $indexerConfig['targetpid'], // target PID: where is the single view?
                    $fullContent, // indexed content, includes the title (linebreak after title)
                    $tags, // tags for faceted search
                    $params, // typolink params for singleview
                    $abstract, // abstract; shown in result list if not empty
                    $record['sys_language_uid'], // language uid
                    $record['starttime'], // starttime
                    $record['endtime'], // endtime
                    $record['fe_group'], // fe_group
                    false, // debug only?
                    $additionalFields // additionalFields
                );
            }

            $content = '<p><b>HWT Address Indexer "' . $indexerConfig['title'] . '": ' . $resCount . 'Elements have been indexed.</b></p>';
        }
        return $content;
    }
}
