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
class Tx_ThRating_Domain_Validator_StepnameValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

	/**
     * @var Tx_ThRating_Domain_Repository_StepnameRepository
     */
    protected $stepnameRepository;

    /**
     * @param Tx_ThRating_Domain_Repository_StepnameRepository $stepnameRepository
     * @return void
     */
    public function injectStepnameRepository(Tx_ThRating_Domain_Repository_StepnameRepository $stepnameRepository) {
        $this->stepnameRepository = $stepnameRepository;
    }

	
	/**
	 * If the given step is valid
	 *
	 * @param Tx_ThRating_Domain_Model_Stepname $stepname
	 * @return boolean
	 */
	public function isValid($stepname) {
		//a stepname object must have a stepconf
		if (!$stepname->getStepconf() instanceof Tx_ThRating_Domain_Model_Stepconf) {
			$this->addError(Tx_Extbase_Utility_Localization::translate('error.validator.stepname.stepconf', 'ThRating'), 1382895072);
			return FALSE;
		}

		//check if given languagecode exists in website
		If ( !$this->stepnameRepository->checkStepnameLanguage($stepname) ) {
			$this->addError(Tx_Extbase_Utility_Localization::translate('error.validator.stepname.sysLang', 'ThRating'), 1382895089);
			return FALSE;
		}
	
		//now check if entry for default language exists
		$langUid = $stepname->get_languageUid();
		if ( !empty($langUid) ) {
			$defaultStepname = $this->stepnameRepository->findDefaultStepname($stepname);
			if ( !($defaultStepname instanceof Tx_ThRating_Domain_Model_Stepname and $this->isValid($defaultStepname)) ) {
				$this->addError(Tx_Extbase_Utility_Localization::translate('error.validator.stepname.defaultLang', 'ThRating'), 1382895097);
				return FALSE;
			}
		}				
		return TRUE;
	}
}
?>