<?php
namespace Thucke\ThRating\Domain\Repository;
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
class StepnameRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {			
	protected $defaultOrderings = array(
         'sys_language_uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
	);

	/**
	 * Initialze this repository
	 */
	public function initializeObject() {
		$configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$settings = $configurationManager->getConfiguration('Settings', 'thRating', 'pi1');
	}


	/**
	 * Checks if stepname got a valid language code
	 *
	 * @param 	\Thucke\ThRating\Domain\Model\Stepname	$stepname 	The stepname object
	 * @return	bool
	 */
	public function checkStepnameLanguage(\Thucke\ThRating\Domain\Model\Stepname $stepname) {
		$stepnameLang = $stepname->get_languageUid();
		If ( $stepnameLang > 0 ) {
			//check if given language exist
			$queryResult = \Thucke\ThRating\Service\ObjectFactoryService::getObject('Thucke\\ThRating\\Domain\\Repository\\SyslangRepository')->findByUid($stepnameLang);
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
	 * @param 	\Thucke\ThRating\Domain\Model\Stepname	$stepname 	The ratingname to look for
	 * @return	\Thucke\ThRating\Domain\Model\Stepname				The stepname in default language
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
	 * @param 	\Thucke\ThRating\Domain\Model\Stepname	$stepname 	The ratingname to look for
	 * @return	\Thucke\ThRating\Domain\Model\Stepname
	 */
	public function findStepnameObject(\Thucke\ThRating\Domain\Model\Stepname $stepname) {
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
	 * Check on double language entries
	 *
	 * @param 	\Thucke\ThRating\Domain\Model\Stepname	$stepname 	The ratingname to look for
	 * @return	array	return values FALSE says OK
	 */
	public function checkConsistency(\Thucke\ThRating\Domain\Model\Stepname $stepname) {
		//TODO - remove workaround when bug #47192 is solved
		/* Bug #47192 - setRespectSysLanguage(FALSE) doesn't prevent language overlay when fetching localized objects
		 * Here we need all active stepname entries for a specific stepconf to check if
		 * - one language is configured multiple times
		 * - a language entriy does not exist in this website
		 * One the bug has been fixed or a new option implemented in extbase we could switch back to
		 * normal query
		 ********************************************************************************************************
		$query = $this->createQuery();
		$query	->getQuerySettings()->setRespectSysLanguage(FALSE);
		$query	->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$query	->matching(
						$query->equals('stepconf', $stepname->getStepconf()->getUid())
					);
		$queryResult = $query->execute()->toArray();*/
		$where = 'stepconf='.$stepname->getStepconf()->getUid() . \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::enableFields('tx_thrating_domain_model_stepname');
		$queryResult = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_thrating_domain_model_stepname', $where);
		if ( count($queryResult) > 1 ) {
			$allWebsiteLanguages = \Thucke\ThRating\Service\ObjectFactoryService::getObject('Thucke\\ThRating\\Domain\\Repository\\SyslangRepository')->findAll()->toArray();
			foreach( $allWebsiteLanguages as $key => $language ) {
				$websiteLanguagesArray[]=$language->getUid();
			}
			foreach( $queryResult as $key => $value ) {
				$languageUid=$value['sys_language_uid'];
				$languageCounter[$languageUid]++;
				If ($languageCounter[$languageUid] > 1) {
					$checkConsistency['doubleLang'] = TRUE;
				}

				//check if language flag exists in current website
				If ($languageUid > 0) {
					if ( array_search($languageUid, $websiteLanguagesArray) === FALSE ) {
						$checkConsistency['existLang'] = TRUE;
					}
				}
			}
			unset($languageCounter);
		}
		return $checkConsistency;
	}

	/**
	 * Finds the localized ratingstep entry by giving ratingobjectUid
	 *
	 * @param 	\Thucke\ThRating\Domain\Model\Stepname	$stepconf 	The ratingname to look for
	 * @return	bool											TRUE if stepconf having same steporder and _languageUid exists
	 */
	public function existStepname(\Thucke\ThRating\Domain\Model\Stepname $stepname) {
		$lookForStepname = $this->findStepnameObject($stepname);
		if ( $lookForStepname instanceof \Thucke\ThRating\Domain\Model\Stepname ) {
			return TRUE;
		} 
		return FALSE;
	}

	/**
	 * Set default query settings to find ALL records
	 *
	 * @return	void
	 */
	public function clearQuerySettings() {
		$this->defaultQuerySettings = $this->objectManager->create('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$this->defaultQuerySettings->setRespectSysLanguage(FALSE);
		$this->defaultQuerySettings->setIgnoreEnableFields(TRUE);
	}
	
}
?>