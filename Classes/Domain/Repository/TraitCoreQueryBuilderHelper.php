<?php

declare(strict_types = 1);

namespace Hwt\HwtAddress\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Heiko Westermann <hwt3@gmx.de>
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
 * Trait that adds helper methods for core query builder
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
trait TraitCoreQueryBuilderHelper {
    /*
     * Set orderings helper function
     *
     * @param \TYPO3\CMS\Core\Database\Query\QueryBuilder $query
     * @param string $orderBy
     * @param null|string $orderDirection
     */
    protected function _setOrderingsForCoreQueryBuilder(&$query, $orderBy='uid', $orderDirection)
    {
        if ( $orderBy != '' ) {
            if ( $orderDirection === 'desc' ) {
                $query->orderBy(
                    $orderBy,
                    \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
                );
            }
            else {
                $query->orderBy(
                    $orderBy,
                    \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
                );
            }
        }
    }



    /*
     * Set range for result items
     *
     * @param \TYPO3\CMS\Core\Database\Query\QueryBuilder $query
     * @param null|int $limit
     * @param null|int $offset
     */
    protected function _setRangeForCoreQueryBuilder(&$query, $limit=null, $offset=null)
    {
        if ($limit > 0) {$query->setMaxResults($limit);}
        if ($offset > 0) {$query->setFirstResult($offset);}
    }
}