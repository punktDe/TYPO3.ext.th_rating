<?php
class Tx_ThRating_ViewHelpers_RatingViewHelper extends Tx_Fluid_ViewHelpers_CObjectViewHelper {

	
	/**
	 * Renders the rating object
	 *
	 * @param string $action the controller action that should be used (ratinglinks, show, new )
	 * @param Tx_ThRating_Domain_Model_Ratingobject $ratingobject
	 * @param string $ratetable
	 * @param string $ratefield
	 * @param string $ratedobjectuid
	 * @param string $display
	 * @return string the content of the rendered TypoScript object
	 * @author Thomas Hucke <thucke@web.de>
	 */
	public function render($action = NULL, $ratingobject = NULL, $ratetable = NULL, $ratefield = NULL, $ratedobjectuid = NULL, $display = NULL) {
		$typoscriptObjectPath = 'plugin.tx_thrating';
		if (TYPO3_MODE === 'BE') {
			$this->simulateFrontendEnvironment();
		}

		$cObj = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_Extbase_Configuration_ConfigurationManager')->getContentObject();
		$cObj->start($data);

		$pathSegments = t3lib_div::trimExplode('.', $typoscriptObjectPath);
		$lastSegment = array_pop($pathSegments);
		$setup = $this->typoScriptSetup;
		foreach ($pathSegments as $segment) {
			if (!array_key_exists($segment . '.', $setup)) {
				throw new Tx_Fluid_Core_ViewHelper_Exception('TypoScript object path "' . htmlspecialchars($typoscriptObjectPath) . '" does not exist' , 1253191023);
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
				throw new Tx_Fluid_Core_ViewHelper_Exception('ratedobjectuid not set' , 1304624408);
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