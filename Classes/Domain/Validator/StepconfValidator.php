<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Thomas Hucke <thucke@web.de> 
*  All rights reserved
*
*  This class is a backport of the corresponding class of FLOW3.
*  All credits go to the v5 team.
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
 * A validator for Ratings
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright Copyright belongs to the respective authors
 * @scope singleton
 */
class Tx_ThRating_Domain_Validator_StepconfValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

	/**
	 * If the given step is valid
	 *
	 * @param Tx_ThRating_Domain_Model_Stepconf $stepconf
	 * @return boolean true
	 */
	public function isValid($stepconf) {
		//a stepconf object must have a ratingobject
		if (!$stepconf->getRatingobject() instanceof Tx_ThRating_Domain_Model_Ratingobject) {
			$this->addError(Tx_Extbase_Utility_Localization::translate('error.validator.stepconf.ratingobject', 'ThRating'), 1284700846);
			return false;
		}
		//at least a steporder value must be set
		if (empty($stepconf->getSteporder())) {
			$this->addError(Tx_Extbase_Utility_Localization::translate('error.validator.stepconf.steporder', 'ThRating'), 1284700903);
			return false;
		}
		return true;
	}
}
?>