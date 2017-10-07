<?php

namespace Hwt\HwtAddress\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Heiko Westermann <hwt3@gmx.de>
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

    /**
     * Find addresses related to page
     *
     * @param int $pageId page id
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface addresses
     */
    public function findRelatedToPage($pageId) {
        $sql = <<<SQL
        SELECT
            tx_hwtaddress_domain_model_address.*,
            tx_hwtaddress_domain_model_pages_address_mm.uid_local
        FROM
            tx_hwtaddress_domain_model_address
        JOIN
            tx_hwtaddress_domain_model_pages_address_mm
        ON
            tx_hwtaddress_domain_model_pages_address_mm.uid_foreign = tx_hwtaddress_domain_model_address.uid
        WHERE
            tx_hwtaddress_domain_model_pages_address_mm.uid_local=? AND tx_hwtaddress_domain_model_address.hidden=0 AND tx_hwtaddress_domain_model_address.deleted=0;
SQL;
        $parameter = array($pageId);

        $query = $this->createQuery();
        $query->statement($sql, $parameter);
        return $query->execute();
    }



    /**
     * Find addresses without pid restriction
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface addresses
     */
    public function findAllWithoutPidRestriction($categories, $zip, $orderBy, $orderDirection) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);

        if ($zip) {
            $zip = substr($zip, 0, 2);
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
     * @param string $orderBy
     * @param string $orderDirection
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface addresses
     */
    public function findByUidInList($uids, $orderBy, $orderDirection) {
        $uids = explode(',', $uids);
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->matching(
                $query->in('uid', $uids)
        );
        if ($orderDirection == 'desc') {
            $query->setOrderings(array(
                $orderBy => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
            ));
        }
        else {
            $query->setOrderings(array(
                $orderBy => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
            ));
        }

        return $query->execute();
    }
}