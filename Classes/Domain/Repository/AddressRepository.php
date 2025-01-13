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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Address repository with all the callable functionality
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
class AddressRepository extends AbstractRepository
{
    use TraitCategoryHelper;
    use TraitCoreQueryBuilderHelper;
    

    /**
     * Find addresses related to page
     *
     * @param int $pageId  The page id
     * @param string $orderBy
     * @param string|null $orderDirection
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array  The addresses
     */
    public function findRelatedToPage(int $pageId, string $orderBy = 'uid', ?string $orderDirection = null, ?int $limit = null, ?int $offset = null): array
    {
        // Create the query
        $table = 'tx_hwtaddress_domain_model_address';
        $tableJoin = 'tx_hwtaddress_domain_model_pages_address_mm';

        $connectionPool = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Database\ConnectionPool::class
        );
        $queryBuilder = $connectionPool->getQueryBuilderForTable($table);

        if (($GLOBALS['TYPO3_REQUEST'] ?? null) instanceof ServerRequestInterface &&
            ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend()) {
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
        $dataMapper = GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper::class
        );
        $items = $dataMapper->map(\Hwt\HwtAddress\Domain\Model\Address::class, $result->fetchAll());


        return $items;
    }



    /**
     * Find addresses without pid restriction
     *
     * @param string|null $categories
     * @param string|null $zip
     * @param string $orderBy
     * @param string|null $orderDirection
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface addresses
     */
    public function findAllWithoutPidRestriction(?string $categories = null, ?string $zip = null, string $orderBy = 'uid', ?string $orderDirection = null): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        if ($zip) {
            if ($zip !== trim($zip)) {
                throw new \UnexpectedValueException(
                    sprintf(
                        'The zip/postal code parameter must not contain any whitespace at the beginning or the end, but "%s" given!',
                        $zip
                    ),
                    1736765075
                );
            }

            // https://en.wikipedia.org/wiki/Postal_code#Presentation
            if (strlen($zip) < 3 || strlen($zip) > 10) {
                throw new \UnexpectedValueException(
                    sprintf(
                        'The zip/postal code parameter must not be shorter than 3 and longer than 10 numbers or characters, but "%s" with length "%s" given!',
                        $zip,
                        strlen($zip)
                    ),
                    1736765162
                );
            }
        }

        $constraints = [];

        if ($categories) {
            $categories = GeneralUtility::intExplode(',', $categories, true);
            if ($categories) {
                $constraints['categories'] = $this->_createCategoryConstraint();
            }
        }

        if ($zip) {
            $constraints['zip'] = $query->logicalOr(
                $query->like('region', '%' . $zip . '%'),
                $query->like('region', '%' . $zip . ',%')
            );
        }

        $query->matching(
            $query->logicalAnd(...$constraints)
        );

        $this->_setOrderings($query, $orderBy, $orderDirection);

        return $query->execute();
    }



    /**
     * Find addresses by uid list
     *
     * @param string $uids comma separated address uids
     * @param string $orderBy
     * @param string|null $orderDirection
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface addresses
     */
    public function findByUidInList(string $uids, string $orderBy = 'uid', ?string $orderDirection = null): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

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
     * @param string $orderBy comma separated uid list
     * @param string|null $orderDirection
     *
     * @return array addresses
     */
    public function findByUidInOrderedList(string $uids, ?string $orderDirection = null): array
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $uids = explode(',', $uids);
        if ($orderDirection &&
            strtoupper($orderDirection) === QueryInterface::ORDER_DESCENDING) {
            $uids = array_reverse($uids);
        }

        $items = [];
        foreach ($uids as $uid) {
            $item = $this->findByIdentifier($uid);
            if ($item) {
                $items[] = $item;
            }
        }

        return $items;
    }
}