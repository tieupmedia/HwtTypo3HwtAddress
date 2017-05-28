<?php
namespace Hwt\HwtAddress\Helper;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class TcaHelper {

	/**
	 * Get list of templates
	 *
	 * @param array $params array of select field options (reference)
	 * @param object $pObj parent object (reference)
	 * @return void
	 */
	public function getTemplateList(&$params, $pObj) {
		// Add default item
		$params['items'][0] = [
			0 => LocalizationUtility::translate('LLL:EXT:hwt_address/Resources/Private/Language/locallang_be.xlf:flexform_setting.template.default', 'hwtAddress'),
			1 => 'Default'
		];

		$templateRegistry = $GLOBALS['TYPO3_CONF_VARS']['EXT']['hwt_address']['templates'][$params['row']['switchableControllerActions'][0]];
		if (isset($templateRegistry) && count($templateRegistry) > 0) {
			foreach ($templateRegistry as $item => $name) {
				$params['items'][] = [
					0 => $name,
					1 => GeneralUtility::underscoredToUpperCamelCase($item)
				];
			}
		}
	}
}
