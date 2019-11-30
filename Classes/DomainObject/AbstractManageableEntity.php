<?php

declare(strict_types = 1);

namespace Hwt\HwtAddress\DomainObject;

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
 * Entity fully manageable in typo3 (backend)
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
abstract class AbstractManageableEntity extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * @var DateTime
     */
    protected $crdate;

    /**
     * @var DateTime
     */
    protected $tstamp;

    /**
     * @var DateTime
     */
    protected $starttime;

    /**
     * @var DateTime
     */
    protected $endtime;

    /**
     * @var boolean
     */
    protected $hidden;

    /**
     * @var boolean
     */
    protected $deleted;

    /**
     * @var integer
     */
    protected $cruserId;

    /**
     * @var integer
     */
    protected $sorting;



    /**
     * Get creation date
     *
     * @return integer
     */
    public function getCrdate() {
            return $this->crdate;
    }

    /**
     * Get timestamp
     *
     * @return integer
     */
    public function getTstamp() {
            return $this->tstamp;
    }

    /**
     * Get id of creator user
     *
     * @return integer
     */
    public function getCruserId() {
            return $this->cruserId;
    }

    /**
     * Get editlock flag
     *
     * @return integer
     */
    public function getEditlock() {
            return $this->editlock;
    }

    /**
     * Get hidden flag
     *
     * @return integer
     */
    public function getHidden() {
            return $this->hidden;
    }

    /**
     * Get deleted flag
     *
     * @return integer
     */
    public function getDeleted() {
            return $this->deleted;
    }

    /**
     * Get start time
     *
     * @return DateTime
     */
    public function getStarttime() {
            return $this->starttime;
    }

    /**
     * Get endtime
     *
     * @return DateTime
     */
    public function getEndtime() {
            return $this->endtime;
    }

    /**
     * Get sorting
     *
     * @return integer
     */
    public function getSorting() {
            return $this->sorting;
    }
}