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
class AbstractRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * Find address records in given page uids
     *
     * @param string $pids
     * @param string $orderBy
     * @param string $orderDirection
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findInPageIds($pids, $orderBy, $orderDirection) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
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
        //$query->getQuerySettings()->setRespectEnableFields(TRUE);

        return $query->matching($query->in('pid', explode(',', $pids)))->execute();
    }
}