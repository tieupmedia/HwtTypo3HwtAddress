<?php

declare(strict_types=1);

namespace Hwt\HwtAddress\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;

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
 * Abstract repository with all the callable functionality
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
class AbstractRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Find records in given page uids
     *
     * @param string $pids
     * @param string $orderBy
     * @param string|null $orderDirection
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findInPageIds(string $pids, string $orderBy = 'uid', ?string $orderDirection = null, ?int $limit = null, ?int $offset = null): \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $this->_setOrderings($query, $orderBy, $orderDirection);
        $this->_setRange($query, $limit, $offset);

        $result = $query->matching($query->in('pid', explode(',', $pids)))->execute();

        return $result;
    }



    /*
     * Set orderings helper function
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param string $orderBy
     * @param string|null $orderDirection
     */
    protected function _setOrderings(QueryInterface &$query, string $orderBy = 'uid', ?string $orderDirection = null): void
    {
        if ($orderBy != '') {
            if ($orderDirection &&
                strtoupper($orderDirection) === QueryInterface::ORDER_DESCENDING) {
                $query->setOrderings([
                    $orderBy => QueryInterface::ORDER_DESCENDING,
                ]);
            } else {
                $query->setOrderings([
                    $orderBy => QueryInterface::ORDER_ASCENDING,
                ]);
            }
        }
    }



    /*
     * Set range for result items
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param int|null $limit
     * @param int|null $offset
     */
    protected function _setRange(QueryInterface &$query, ?int $limit = null, ?int $offset = null): void
    {
        if ($limit > 0) {
            $query->setLimit($limit);
        }
        if ($offset > 0) {
            $query->setOffset($offset);
        }
    }
}