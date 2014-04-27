<?php
namespace Thucke\ThRating\ViewHelpers;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Hucke <thucke@web.de>
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
 * The Rating Viewhelper
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class RatingViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\CObjectViewHelper {
	
	/**
	 * Renders the rating object
	 *
	 * @param string $action the controller action that should be used (ratinglinks, show, new )
	 * @param \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject
	 * @param string $ratetable
	 * @param string $ratefield
	 * @param integer $ratedobjectuid
	 * @param string $display
	 * @return string the content of the rendered TypoScript object
	 * @author Thomas Hucke <thucke@web.de>
	 */
	public function render($action = NULL, $ratingobject = NULL, $ratetable = NULL, $ratefield = NULL, $ratedobjectuid = NULL, $display = NULL) {
		$typoscriptObjectPath = 'plugin.tx_thrating';
		if (TYPO3_MODE === 'BE') {
			$this->simulateFrontendEnvironment();
		}

		$cObj = \Thucke\ThRating\Service\ObjectFactoryService::getObject('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager')->getContentObject();
		$cObj->start($data);

		$pathSegments = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('.', $typoscriptObjectPath);
		$lastSegment = array_pop($pathSegments);
		$setup = $this->typoScriptSetup;
		foreach ($pathSegments as $segment) {
			if (!array_key_exists($segment . '.', $setup)) {
				throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('TypoScript object path "' . htmlspecialchars($typoscriptObjectPath) . '" does not exist', 1253191023);
			}
			$setup = $setup[$segment . '.'];
		}
		
		if ($action !== NULL) {
			$setup[$lastSegment . '.']['action'] = $action;
			$setup[$lastSegment . '.']['switchableControllerActions.']['Vote.']['1'] = $action;
		}
		if ($ratingobject !== NULL) {
			$setup[$lastSegment . '.']['settings.']['ratingobject'] = $ratingobject;
		} elseif ( $ratetable !== NULL && $ratefield !== NULL ) {
			$setup[$lastSegment . '.']['settings.']['ratetable'] = $ratetable;
			$setup[$lastSegment . '.']['settings.']['ratefield'] = $ratefield;
		}
		if ($ratedobjectuid !== NULL) {
			$setup[$lastSegment . '.']['settings.']['ratedobjectuid'] = $ratedobjectuid;
		} else {
				throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('ratedobjectuid not set', 1304624408);
		}
		if ($display !== NULL) {
			$setup[$lastSegment . '.']['settings.']['display'] = $display;
		}		
		$content = $cObj->cObjGetSingle($setup[$lastSegment], $setup[$lastSegment . '.']);

		if (TYPO3_MODE === 'BE') {
			$this->resetFrontendEnvironment();
		}

		return $content;
	}	
	
}
?>