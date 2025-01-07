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

use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Trait that adds helper methods for core query builder
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
trait TraitCoreQueryBuilderHelper
{
    /*
     * Set orderings helper function
     *
     * @param \TYPO3\CMS\Core\Database\Query\QueryBuilder $query
     * @param string $orderBy
     * @param null|string $orderDirection
     */
    protected function _setOrderingsForCoreQueryBuilder(QueryBuilder &$query, string $orderBy = 'uid', ?string $orderDirection = null): void
    {
        if ($orderBy != '') {
            if ($orderDirection &&
                strtoupper($orderDirection) === QueryInterface::ORDER_DESCENDING) {
                $query->orderBy(
                    $orderBy,
                    QueryInterface::ORDER_DESCENDING
                );
            } else {
                $query->orderBy(
                    $orderBy,
                    QueryInterface::ORDER_ASCENDING
                );
            }
        }
    }



    /*
     * Set range for result items
     *
     * @param \TYPO3\CMS\Core\Database\Query\QueryBuilder $query
     * @param int|null $limit
     * @param int|null $offset
     */
    protected function _setRangeForCoreQueryBuilder(QueryBuilder &$query, ?int $limit = null, ?int $offset = null): void
    {
        if ($limit > 0) {
            $query->setMaxResults($limit);
        }
        if ($offset > 0) {
            $query->setFirstResult($offset);
        }
    }
}