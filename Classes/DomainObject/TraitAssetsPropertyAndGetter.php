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

namespace Hwt\HwtAddress\DomainObject;

/**
 * Trait that adds assets property and getter method
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
trait TraitAssetsPropertyAndGetter
{
    /**
     * Assets
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @extensionScannerIgnoreLine Still needed for TYPO3 8.7
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $assets;

    /**
     * Returns the assets
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $assets
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Init function for trait, e.g. to execute in constructor of using object
     */
    public function initTraitAssetsPropertyAndGetter(): void
    {
        $this->assets = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
}