<?php

declare(strict_types = 1);

namespace Hwt\HwtAddress\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014-2019 Heiko Westermann <hwt3@gmx.de>
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
 * Address repository with all the callable functionality
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
class AddressRepository extends AbstractRepository {
    
    use TraitCoreQueryBuilderHelper;
    

    /**
     * Find addresses related to page
     *
     * @param int $pageId  The page id
     *
     * @return array  The addresses
     */
    public function findRelatedToPage($pageId, $orderBy='uid', $orderDirection=null, $limit=null, $offset=null) {
        // Create the query
        $table = 'tx_hwtaddress_domain_model_address';
        $tableJoin = 'tx_hwtaddress_domain_model_pages_address_mm';

        $connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Database\ConnectionPool::class
        );
        $queryBuilder = $connectionPool->getQueryBuilderForTable($table);

        if ( TYPO3_MODE === 'FE' ) {
            $queryBuilder->setRestrictions(
                \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    \TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer::class
                )
            );
        }

        $queryBuilder
            ->select($table . '.*', $tableJoin . '.*')
            ->from($table)
            ->join(
                $table, // alias
                $tableJoin,
                $tableJoin, // alias
                $queryBuilder->expr()->eq(
                    $tableJoin . '.uid_foreign', 
                    $queryBuilder->quoteIdentifier($table . '.uid')
                )
            )
            ->where(
                $queryBuilder->expr()->eq(
                    $tableJoin . '.uid_local',
                    $queryBuilder->createNamedParameter($pageId, \PDO::PARAM_INT)
                )
            );

        $this->_setOrderingsForCoreQueryBuilder($queryBuilder, $orderBy, $orderDirection);
        $this->_setRangeForCoreQueryBuilder($queryBuilder, $limit, $offset);

        $result = $queryBuilder->execute();


        // Map rows (array) to objects (model)
        $dataMapper = $this->objectManager->get(
            \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper::class
        );
        $items = $dataMapper->map(\Hwt\HwtAddress\Domain\Model\Address::class, $result->fetchAll());


        return $items;
    }



    /**
     * Find addresses without pid restriction
     *
     * @param false|string $categories
     * @param null|int $zip
     * @param null|string $orderBy
     * @param null|string $orderDirection
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface addresses
     */
    public function findAllWithoutPidRestriction($categories, $zip=null, $orderBy=null, $orderDirection=null) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);

        if ($zip) {
            $zip = substr($zip, 0, 5);
            //$zip = (int)$zip;

            // protect any result if zip is false
            if ($zip == "") {$zip = 'noplz';}
        }

        if($categories) {
            $sql = <<<SQL
                SELECT
                    tx_hwtaddress_domain_model_address.*
                FROM
                    sys_category_record_mm
                LEFT JOIN
                    tx_hwtaddress_domain_model_address
                ON
                    sys_category_record_mm.uid_foreign = tx_hwtaddress_domain_model_address.uid
                WHERE
                    sys_category_record_mm.tablenames = ? AND sys_category_record_mm.uid_local IN (
SQL;
            $sql .= $categories;
            $sql .= ')';

            if ($zip) {
                $sql .= " AND (tx_hwtaddress_domain_model_address.region LIKE '%" . $zip . "%' OR tx_hwtaddress_domain_model_address.region LIKE '%" . $zip . ",%')";
            }

            $sql .= <<<SQL
                AND tx_hwtaddress_domain_model_address.hidden=0 AND tx_hwtaddress_domain_model_address.deleted=0
                GROUP BY
                    tx_hwtaddress_domain_model_address.uid
                ORDER BY tx_hwtaddress_domain_model_address.
SQL;
            $sql .= $orderBy . ' ' . $orderDirection;
            $parameters = array('tx_hwtaddress_domain_model_address');
            $query->statement($sql, $parameters);
        }
        elseif ($zip) {
            $query->matching(
                $query->logicalOr(
                    $query->like('region', '%' . $zip . '%'),
                    $query->like('region', '%' . $zip . ',%')
                )
            );
        }
        return $query->execute();
    }



    /**
     * Find addresses by uid list
     *
     * @param string $uids comma separated address uids
     * @param null|string $orderBy
     * @param null|string $orderDirection
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface addresses
     */
    public function findByUidInList($uids, $orderBy=null, $orderDirection=null) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);

        $uids = explode(',', $uids);
        $query->matching(
            $query->in('uid', $uids)
        );

        $this->_setOrderings($query, $orderBy, $orderDirection);

        return $query->execute();
    }



    /**
     * Find addresses by uid list, ordered by uid list
     *
     * @param string $uids comma separated address uids
     * @param null|string $orderBy comma separated uid list
     * @param null|string $orderDirection
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface addresses
     */
    public function findByUidInListWithOrderList($uids, $orderBy=null, $orderDirection=null) {
        // if oderBy isn't set, just order by uid list
        if ( !$orderBy ) {
            $orderBy = $uids;
        }


        // Create the query
        $table = 'tx_hwtaddress_domain_model_address';

        $connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Database\ConnectionPool::class
        );
        $queryBuilder = $connectionPool->getQueryBuilderForTable($table);

        if ( TYPO3_MODE === 'FE' ) {
            $queryBuilder->setRestrictions(
                \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                    \TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer::class
                )
            );
        }

        $queryBuilder
            ->select('*')
            ->from($table)
            ->where($queryBuilder->expr()->in('uid', $uids))
            ->add('orderBy', 'FIELD(' . $table . '.uid,' . $orderBy . ')');

        $result = $queryBuilder->execute();


        // Map rows (array) to objects (model)
        $dataMapper = $this->objectManager->get(
            \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper::class
        );
        $items = $dataMapper->map(\Hwt\HwtAddress\Domain\Model\Address::class, $result->fetchAll());


        return $items;
    }
}