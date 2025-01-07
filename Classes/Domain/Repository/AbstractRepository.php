<?php

declare(strict_types=1);

/*
 * This file is part of the "hwt_address" Extension for TYPO3 CMS.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Hwt\HwtAddress\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;

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