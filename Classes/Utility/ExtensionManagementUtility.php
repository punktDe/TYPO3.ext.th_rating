<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013 Thomas Hucke <thucke@web.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General protected License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General protected License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General protected License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
include_once( PATH_typo3conf . '/ext/th_rating/Resources/Public/Classes/BE.userFunc.php');

/**
 * Factory for model objects
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU protected License, version 2
 */
class Tx_ThRating_Utility_ExtensionManagementUtility implements t3lib_Singleton {

	/**
	 * Set a new properties for a stepconf
	 * 
	 * @param	Tx_Extbase_DomainObject_AbstractEntity	$objectToPersist
	 * @return	void
	 */
	public function persistObjectIfDirty( Tx_Extbase_DomainObject_AbstractEntity $objectToPersist ) {
		If ( $objectToPersist->_isDirty() ) {
			Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_Extbase_Persistence_ManagerInterface')->persistAll();
			user_BEfunc::clearCachePostProc(NULL,NULL,NULL);  //Delete the file 'typo3temp/thratingDyn.css'
		}
	}


	/**
	 * Prepares an object for ratings
	 * 
	 * @param	string	$tablename
	 * @param	string	$fieldname
	 * @param	int		$stepcount
	 * @return	Tx_ThRating_Domain_Model_Ratingobject
	 */
	static function makeRatable( $tablename, $fieldname, $stepcount ) {
		$ratingobject = Tx_ThRating_Service_ObjectFactoryService::getRatingobject( array('ratetable'=>$tablename, 'ratefield'=>$fieldname) );

		//create a new default stepconf for each step
		for ( $i=1; $i<=$stepcount; $i++) {
			$stepconfArray = array(
				'ratingobject' 	=> $ratingobject,
				'steporder'		=> $i,
				'stepweight'	=> 1,
				'stepname'		=> 'Auto generated step '.$i,
				'_languageUid'	=> 0 );
			$stepconf = Tx_ThRating_Service_ObjectFactoryService::createStepconf($stepconfArray);
			$ratingobject->addStepconf($stepconf);
		}
		self::persistObjectIfDirty($ratingobject);
		return $ratingobject;
	}			

	
	/**
	 * Set new properties for a stepconf
	 * 
	 * @param	Tx_ThRating_Domain_Model_Stepconf	$stepconf
	 * @return	void
	 */
	static function updateStepconf( Tx_ThRating_Domain_Model_Stepconf $stepconf ) {
		If ( Tx_ThRating_Service_ObjectFactoryService::createObject('Tx_ThRating_Domain_Validator_StepconfValidator')->isValid( $stepconf ) ) {
			//first check if a stepconf for default language exists
			$stepconfRepository = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_ThRating_Domain_Repository_StepconfRepository');
			$defaultLanguageStepconf = $stepconfRepository->findDefaultStepconf($stepconf->getRatingobject(), $stepconf->getSteporder());
			$stepconfLanguage = $stepconf->get_languageUid();
			If ( $defaultLanguageStepconf instanceOf Tx_ThRating_Domain_Model_Stepconf && !empty($stepconfLanguage) ) {
				//connect stepconf to defaults language parent entry
				$stepconf->setL18nParent($defaultLanguageStepconf->getUid());
			} else {
				//set entry to language default
				$stepconf->setL18nParent(0);
			}
			
			//second check if there is an existing localized stepconf entry
			$oldStepconfObject = $stepconfRepository->findStepconfObject($stepconf);
			If ( $oldStepconfObject ) {
				$stepconf->setUid($oldStepconfObject->getUid());
				$stepconfRepository->replace($oldStepconfObject, $stepconf);
			} else {
				//add new stepconf entry
				$stepconf->getRatingobject()->addStepconf($stepconf);			
			}
			self::persistObjectIfDirty($stepconf);
		}
	}
}
?>