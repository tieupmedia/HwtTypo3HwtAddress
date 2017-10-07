<?php

namespace Hwt\HwtAddress\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014-2017 Heiko Westermann <hwt3@gmx.de>
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
 * Address model
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
class Address extends \Hwt\HwtAddress\DomainObject\AbstractManageableEntity {

    /**
     * @var string
     */
    protected $academic;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var int
     */
    protected $gender;

    /**
     * @var DateTime
     */
    protected $birthday;

    /**
     * @var string
     */
    protected $info;

    /**
     * @var string
     */
    protected $department;

    /**
     * @var string
     */
    protected $position;

    /**
     * @var string
     */
    protected $companyTitle;

    /**
     * @var string
     */
    protected $companySubtitle;

    /**
     * @var string
     */
    protected $companyShort;

    /**
     * @var string
     */
    protected $companyBodytext;

    /**
     * @var string
     */
    protected $building;

    /**
     * @var string
     */
    protected $street;

    /**
     * @var string
     */
    protected $zip;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $region;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $fax;

    /**
     * @var string
     */
    protected $mobile;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $www;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Hwt\HwtAddress\Domain\Model\Link>
     * @lazy
     */
    protected $links;

    /**
     * @var string
     */
    protected $longitude;

    /**
     * @var string
     */
    protected $latitude;

    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories;

    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     */
    protected $images;

    /**
     * company images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     */
    protected $companyImages;

    /**
     * related addresses
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Hwt\HwtAddress\Domain\Model\Address>
     */
    protected $relatedAddress;

    /**
     * related from addresses
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Hwt\HwtAddress\Domain\Model\Address>
     * @lazy
     */
    protected $relatedAddressFrom;



    /**
     * __construct
     * @return AbstractObject
     */
    public function __construct() {
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->companyImages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->links = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->relatedAddress = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->relatedAddressFrom = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }



    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Get academic title
     *
     * @return string
     */
    public function getAcademic() {
        return $this->academic;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Get gender
     *
     * @return int
     */
    public function getGender() {
        return $this->gender;
    }

    /**
     * Get birthday
     *
     * @return DateTime
     */
    public function getBirthday() {
        return $this->birthday;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo() {
        return $this->info;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment() {
        return $this->department;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * Get companyTitle
     *
     * @return string
     */
    public function getCompanyTitle() {
        return $this->companyTitle;
    }

    /**
     * Get companySubtitle
     *
     * @return string
     */
    public function getCompanySubtitle() {
        return $this->companySubtitle;
    }

    /**
     * Get companyShort
     *
     * @return string
     */
    public function getCompanyShort() {
        return $this->companyShort;
    }

    /**
     * Get companyBodytext
     *
     * @return string
     */
    public function getCompanyBodytext() {
        return $this->companyBodytext;
    }

    /**
     * Get building
     *
     * @return string
     */
    public function getBuilding() {
        return $this->building;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip() {
        return $this->zip;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion() {
        return $this->region;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax() {
        return $this->fax;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile() {
        return $this->mobile;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Get www
     *
     * @return string
     */
    public function getWww() {
        return $this->www;
    }

    /**
     * Get links
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Hwt\HwtAddress\Domain\Model\Link>
     */
    public function getLinks() {
        return $this->links;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $images
     */
    public function getImages() {
            return $this->images;
    }

    /**
     * Returns the company images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $companyImages
     */
    public function getCompanyImages() {
            return $this->companyImages;
    }

    /**
     * Returns related addresses
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Hwt\HwtAddress\Domain\Model\Address> $categories
     */
    public function getRelatedAddress() {
        return $this->relatedAddress;
    }

    /**
     * Returns the addresses related from
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Hwt\HwtAddress\Domain\Model\Address> $categories
     */
    public function getRelatedAddressFrom() {
        return $this->relatedAddressFrom;
    }
}
