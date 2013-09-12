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
class Tx_ThRating_Domain_Repository_StepconfRepository extends Tx_Extbase_Persistence_Repository {			
	protected $defaultOrderings = array(
         'steporder' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING
	);

	/**
	 * Initialze this repository
	 */
	public function initializeObject() {
		$configurationManager = $this->objectManager->get('Tx_Extbase_Configuration_ConfigurationManager');
		$settings = $configurationManager->getConfiguration('Settings', 'thRating', 'pi1');
	}

	/**
	 * Finds the localized ratingstep entry by giving ratingobjectUid
	 *
	 * @param int	$ratingobjectUid 					The uid of the ratingobject
	 * @return 		Tx_ThRating_Domain_Model_Stepconf	All related stepconfs in correct localization
	 */
	public function findLocalizedByRatingobject($ratingobjectUid) {
		$query = $this->createQuery();
		$tableName = strtolower($query->getType());
		$statement = 'SELECT * FROM '.$tableName.' WHERE ratingobject=? '.tslib_cObj::enableFields('tx_thrating_domain_model_stepconf');
		$statement .= ' AND (sys_language_uid IN (-1,0) AND uid not in (SELECT l18n_parent FROM '.$tableName.' WHERE ratingobject=? AND sys_language_uid=? '.tslib_cObj::enableFields('tx_thrating_domain_model_stepconf').')'; //default language if noch localized record exists
		$statement .= ' OR sys_language_uid=?)'; //or localized record itself
		$query->statement($statement, array($ratingobjectUid,$ratingobjectUid,$GLOBALS['TSFE']->sys_language_uid,$GLOBALS['TSFE']->sys_language_uid));
		return $query->execute();
	}

	
	/**
	 * Finds the default language stepconf by giving ratingobject and steporder
	 *
	 * @param 	Tx_ThRating_Domain_Model_Ratingobject	$ratingobject	The parent ratingobject
	 * @param 	int										$steporder	 	The concerned steporder number
	 * @return	Tx_ThRating_Domain_Model_Stepconf						The stepconf
	 */
	public function findDefaultStepconf($ratingobject, $steporder) {
		$query = $this->createQuery();
		$query	->getQuerySettings()->setRespectSysLanguage(FALSE);
		$query	->matching(
						$query->logicalAnd(
							$query->equals('ratingobject', $ratingobject->getUid()),
							$query->equals('steporder', $steporder),
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
	 * @param 	Tx_ThRating_Domain_Model_Stepconf	$stepconf 	The uid of the ratingobject
	 * @return	Tx_ThRating_Domain_Model_Stepconf
	 */
	public function findStepconfObject($stepconf) {
		$query = $this->createQuery();
		$query	->getQuerySettings()->setRespectSysLanguage(FALSE);
		$query	->matching(
						$query->logicalAnd(
							$query->equals('ratingobject', $stepconf->getRatingobject()->getUid()),
							$query->equals('steporder', $stepconf->getSteporder()),
							$query->equals('sys_language_uid', $stepconf->get_languageUid())
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
	 * Checks if stepconf got a valid language code
	 *
	 * @param 	Tx_ThRating_Domain_Model_Stepconf	$stepconf 	The stepconf object
	 * @return	bool
	 */
	public function checkStepconfLanguage($stepconf) {
		$stepconfLang = $stepconf->get_languageUid();
		If ( $stepconfLang > 0 ) {
			//check if given language exist
			$queryResult = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_ThRating_Domain_Repository_SyslangRepository')->findByUid($stepconfLang);
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
	 * Finds the localized ratingstep entry by giving ratingobjectUid
	 *
	 * @param 	Tx_ThRating_Domain_Model_Stepconf	$stepconf 	The uid of the ratingobject
	 * @return	bool											TRUE if stepconf having same steporder and _languageUid exists
	 */
	public function existStepconf($stepconf) {
		$lookForStepconf = $this->findStepconfObject($stepconf);
		if ( $lookForStepconf instanceOf Tx_ThRating_Domain_Model_Stepconf ) {
			return TRUE;
		} 
		return FALSE;
	}
}
?>