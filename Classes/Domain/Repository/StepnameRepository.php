<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Thomas Hucke <thucke@web.de> 
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
 * A repository for ratingstep configurations
 */
class Tx_ThRating_Domain_Repository_StepnameRepository extends Tx_Extbase_Persistence_Repository {			
	protected $defaultOrderings = array(
         'sys_language_uid' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING
	);

	/**
	 * Initialze this repository
	 */
	public function initializeObject() {
		$configurationManager = $this->objectManager->get('Tx_Extbase_Configuration_ConfigurationManager');
		$settings = $configurationManager->getConfiguration('Settings', 'thRating', 'pi1');
	}


	/**
	 * Checks if stepname got a valid language code
	 *
	 * @param 	Tx_ThRating_Domain_Model_Stepname	$stepname 	The stepname object
	 * @return	bool
	 */
	public function checkStepnameLanguage(Tx_ThRating_Domain_Model_Stepname $stepname) {
		$stepnameLang = $stepname->get_languageUid();
		If ( $stepnameLang > 0 ) {
			//check if given language exist
			$queryResult = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_ThRating_Domain_Repository_SyslangRepository')->findByUid($stepnameLang);
			if (!empty($queryResult)) {
				//language code found -> OK
				return TRUE;
			} else {
				//invalid language code -> NOK
				return FALSE;
			}
		} else {
			//default language is always OK
			return TRUE;
		}
	}

	/**
	 * Finds the default language stepconf by giving ratingobject and steporder
	 *
	 * @param 	Tx_ThRating_Domain_Model_Stepname	$stepname 	The ratingname to look for
	 * @return	Tx_ThRating_Domain_Model_Stepname				The stepname in default language
	 */
	public function findDefaultStepname($stepname) {
		$query = $this->createQuery();
		$query	->getQuerySettings()->setRespectSysLanguage(FALSE);
		$query	->matching(
						$query->logicalAnd(
							$query->equals('stepconf', $stepname->getStepconf()->getUid()),
							$query->in('sys_language_uid', array(0,-1))
						)
					)
				->setLimit(1);
		$queryResult = $query->execute();
		if (count($queryResult) != 0) {
			$foundRow = $queryResult->getFirst();
		} else {
			unset($foundRow);
		}
		return $foundRow;
	}	

	/**
	 * Finds the given stepconf object in the repository
	 *
	 * @param 	Tx_ThRating_Domain_Model_Stepname	$stepname 	The ratingname to look for
	 * @return	Tx_ThRating_Domain_Model_Stepname
	 */
	public function findStepnameObject(Tx_ThRating_Domain_Model_Stepname $stepname) {
		$query = $this->createQuery();
		$query	->getQuerySettings()->setRespectSysLanguage(FALSE);
		$query	->matching(
						$query->logicalAnd(
							$query->equals('stepconf', $stepname->getStepconf()->getUid()),
							$query->equals('sys_language_uid', $stepname->get_languageUid())
						)
					)
				->setLimit(1);
		$queryResult = $query->execute();
		if (count($queryResult) != 0) {
			$foundRow = $queryResult->getFirst();
		} else {
			unset($foundRow);
		}
		return $foundRow;
	}

	/**
	 * Finds the localized ratingstep entry by giving ratingobjectUid
	 *
	 * @param 	Tx_ThRating_Domain_Model_Stepname	$stepconf 	The ratingname to look for
	 * @return	bool											TRUE if stepconf having same steporder and _languageUid exists
	 */
	public function existStepname(Tx_ThRating_Domain_Model_Stepname $stepname) {
		$lookForStepname = $this->findStepnameObject($stepname);
		if ( $lookForStepname instanceOf Tx_ThRating_Domain_Model_Stepname ) {
			return TRUE;
		} 
		return FALSE;
	}
}
?>