<?php

namespace Hwt\HwtAddress\Controller;

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
 * Controller of address records
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
class AddressController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
    /**
     * @var \Hwt\HwtAddress\Domain\Repository\AddressRepository
     */
    protected $addressRepository;

    /**
     * Inject a address repository
     *
     * @param \Hwt\HwtAddress\Domain\Repository\AddressRepository $addressRepository
     * @return void
     */
    public function injectNewsRepository(\Hwt\HwtAddress\Domain\Repository\AddressRepository $addressRepository) {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Output search form for address
     *
     * @return void
     */
    public function searchAction() {
        // workaround cause only $zip is filled. a caching problem?
        if ($this->request->hasArgument('city')) {
            $city = $this->request->getArgument('city');
        }
        elseif ($this->request->hasArgument('zip')) {
            $zip = $this->request->getArgument('zip');
        }
        $this->view->assign('searchform', array('zip'=>$zip, 'city'=>$city));
    }

    /**
     * Outputs a list view of address
     *
     * @return void
     */
    public function listAction() {
        if ($this->request->hasArgument('zip') && ($this->request->getArgument('zip')!='')) {
            $zip = $this->request->getArgument('zip');
            $isSearch = TRUE;
        }
        if (($zip=='') && $this->request->hasArgument('city') && ($this->request->getArgument('city')!='')) {
                $jsonFileName = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('hwt_address').'Resources/Private/Data/city-zip.json';
                $dataArray = array_change_key_case(json_decode(file_get_contents($jsonFileName), true));

                $city = strtolower($this->request->getArgument('city'));

                if (!empty($dataArray[$city])) {
                    $zip = substr($dataArray[$city],0,5);
                }
                $isSearch = TRUE;
        }

        if ($this->settings['addressStoragePages'] && ($this->settings['addressStoragePages'] != '')) {
            $addressRecords = $this->addressRepository->findInPageIds($this->settings['addressStoragePages'], $this->settings['orderBy'], $this->settings['orderDirection']);
        }
        elseif ($this->settings['list']['displayPageRelated']==1) {
            $addressRecords = $this->addressRepository->findRelatedToPage($GLOBALS['TSFE']->id);
        }
        elseif (($this->settings['addressCategories']) || ($zip)) {
            $addressRecords = $this->addressRepository->findAllWithoutPidRestriction($this->settings['addressCategories'], $zip, $this->settings['orderBy'], $this->settings['orderDirection']);
        }

        if ((count($addressRecords)==0) && $this->settings['addressRecords']) {
            $addressRecords = $this->addressRepository->findByUidInList($this->settings['addressRecords'], $this->settings['orderBy'], $this->settings['orderDirection']);
        }
        $this->view->assign('addresses', $addressRecords);
    }

    /**
     * Single view of a address record
     *
     * @param \Hwt\HwtAddress\Domain\Model\Address $address single address item
     * @return void
     */
    public function singleAction(\Hwt\HwtAddress\Domain\Model\Address $address = NULL) {
        if ($address) {
            $record = $this->addressRepository->findByUid($address);
        }
        elseif ((int)$this->settings['addressSingleRecord'] > 0) {
            $record = $this->addressRepository->findByUid((int)$this->settings['addressSingleRecord']);
        }
        elseif ((int)$this->settings['single']['redirectIfEmptyPid'] > 0) {
            $this->uriBuilder->setTargetPageUid($this->settings['single']['redirectIfEmptyPid']);
            $link = $this->uriBuilder->build();

            $this->redirectToURI($link);
        }

        $this->view->assign('address', $record);
    }
}