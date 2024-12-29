<?php

declare(strict_types = 1);

namespace Hwt\HwtAddress\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility as GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018-2019 Heiko Westermann <hwt3@gmx.de>
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
 * Trait for custom error handling
 *
 * @package TYPO3
 * @subpackage tx_hwtaddress
 * @author Heiko Westermann <hwt3@gmx.de>
 */
trait CustomErrorHandlingTrait {

    /**
     * Error handling configured before
     *
     * @param string $configuration configuration what will be done
     * @throws \InvalidArgumentException
     * @return string
     */
    protected function doConfiguredErrorHandling($configuration) {
        $return = $statusCode = null;

        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($configuration);
        if ( is_array($configuration) && isset($configuration['mode']) ) {
            $redirectMode = $configuration['mode'];
            switch ( $redirectMode ) {
                case 'redirectToPage':
                    if ( isset($configuration['pid']) && ((int)$configuration['pid']>0) ) {
                        $this->uriBuilder->reset();
                        $this->uriBuilder->setTargetPageUid((int)$configuration['pid']);
                        $this->uriBuilder->setCreateAbsoluteUri(true);
                        if ( GeneralUtility::getIndpEnv('TYPO3_SSL') ) {
                            $this->uriBuilder->setAbsoluteUriScheme('https');
                        }
                        $url = $this->uriBuilder->build();

                        $statusCode = 303;
                        if ( isset($configuration['httpStatusCode']) ) {
                            $statusCode = (int)$configuration['httpStatusCode'];
                        }
                        # ToDo: Any other than '303' (=default) returns '302' intead of given one, see https://forum.typo3.org/index.php/t/192428/extbase-redirecttouri-setzt-statuscode-nicht
                        //$this->redirectToUri($url, 0, $statusCode);
                        $this->redirectToUri($url);

                        // not executed
                        //break;
                    } else {
                        $msg = sprintf('If error handling "%s" is used, "%s" key must be set to a page id.', 'redirectToPage', 'pid');
                        throw new \InvalidArgumentException($msg);
                    }
                case 'pageNotFoundHandler':
					$response = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
						\TYPO3\CMS\Frontend\Controller\ErrorController::class
					)->pageNotFoundAction(
						$GLOBALS['TYPO3_REQUEST'], 'No record of type "' . $configuration['recordType'] . '" found.'
					);
            		throw new \TYPO3\CMS\Core\Http\ImmediateResponseException($response, 1617116194);

                    // not executed
                    //break;
                case 'showStandaloneTemplate':
                    if ( isset($configuration['templatePathAndFilename']) ) {
                        if ( isset($configuration['httpStatusCode']) ) {
                            $statusCode = (int)$configuration['httpStatusCode'];
                        }

                        $standaloneTemplate = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
                        $standaloneTemplate->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName($configuration['templatePathAndFilename']));
                        $return = $standaloneTemplate->render();

                        break;
                    } else {
                        $msg = sprintf('If error handling "%s" is used, "%s" key must be set.', 'showStandaloneTemplate', 'templatePathAndFilename');
                        throw new \InvalidArgumentException($msg);
                    }
                case 'showContentObject':
                    if ( isset($configuration['cObjectUid']) && ((int)$configuration['cObjectUid']>0) ) {
                        $return = $this->_getContentObjectByUid((int)$configuration['cObjectUid']);

                        break;
                    } else {
                        $msg = sprintf('If error handling "%s" is used, "%s" key must be set.', 'showContentObject', 'cObjectUid');
                        throw new \InvalidArgumentException($msg);
                    }
                default:
                    // Do nothing, it might be handled in the view.
            }
        }

        $response = $this->htmlResponse($return);
        if ($statusCode) {
            $response = $response->withStatus($statusCode);
        }
        return $response;
    }



    /**
     * Get a content object
     *
     * @param integer $uid
     * @return string
     */
    protected function _getContentObjectByUid($uid) {
        $conf = array(
            'tables' => 'tt_content',
            'source' => $uid,
            'dontCheckPid' => 1
        );

        $cObjectRenderer = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
        return $cObjectRenderer->cObjGetSingle('RECORDS', $conf);
    }
}