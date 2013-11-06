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
include_once( PATH_typo3conf . '/ext/th_rating/Resources/Private/PHP/BE.userFunc.php');

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
	 * @param	string	$repository
	 * @param	Tx_Extbase_DomainObject_AbstractEntity	$objectToPersist
	 * @return	void
	 *
	public function persistObjectIfDirty( $repository, Tx_Extbase_DomainObject_AbstractEntity $objectToPersist ) {
		If ( $objectToPersist->_isDirty() ) {
			self::persistRepository($repository, $objectToPersist);
		}
	}*/

	/**
	 * Update and persist attached objects to the repository
	 *
	 * @param	string	$repository
	 * @param	Tx_Extbase_DomainObject_AbstractEntity	$objectToPersist
	 * @return void
	 */
	public function persistRepository( $repository, Tx_Extbase_DomainObject_AbstractEntity $objectToPersist ) {
		If ( t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) >= 6001000 ) {
			$objectUid=$objectToPersist->getUid();
			If (empty($objectUid)) {
				Tx_ThRating_Service_ObjectFactoryService::getObject($repository)->add($objectToPersist);
			} else {
				Tx_ThRating_Service_ObjectFactoryService::getObject($repository)->update($objectToPersist);
			}
		}
		Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_Extbase_Persistence_Manager')->persistAll();
		user_BEfunc::clearCachePostProc(NULL, NULL, NULL);  //Delete the file 'typo3temp/thratingDyn.css'
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
		
		//create a new default stepconf having stepweight 1 for each step
		for ( $i=1; $i<=$stepcount; $i++) {
			$stepconfArray = array(
				'ratingobject' 	=> $ratingobject,
				'steporder'		=> $i,
				'stepweight'	=> 1 );
			$stepconf = Tx_ThRating_Service_ObjectFactoryService::createStepconf($stepconfArray);
			$ratingobject->addStepconf($stepconf);
		}
		//self::persistRepository('Tx_ThRating_Domain_Repository_RatingobjectRepository', $ratingobject);	
		return $ratingobject;
	}			

	/**
	 * Prepares an object for ratings
	 * 
	 * @param	Tx_ThRating_Domain_Model_Stepconf	$stepconf
	 * @param	string	$stepname
	 * @param	int		$languageIso2Code
	 * @param	bool	$allStepconfs	Take stepname for all steps and add steporder number at the end
	 * @return	void
	 */
	static function setStepname( Tx_ThRating_Domain_Model_Stepconf $stepconf, $stepname, $languageIso2Code=0, $allStepconfs=FALSE ) {
		if ( !$allStepconfs ) {
			//only add the one specific stepname
			$stepnameArray = array(
				'stepname'	=> $stepname,
				'languageIso2Code'	=> $languageIso2Code );
			$stepname = Tx_ThRating_Service_ObjectFactoryService::createStepname($stepnameArray);
			$stepConf->addStepname($stepname);
			//self::persistRepository('Tx_ThRating_Domain_Repository_StepconfRepository', $stepConf);	
		} else {
			$ratingobject = $stepconf->getRatingobject();
			//add stepnames to every stepconf
			foreach ( $ratingobject->getStepconfs() as $i => $loopStepConf ) {
				$stepnameArray = array(
					'stepname'	=> $stepname.$loopStepConf->getSteporder(),
					'languageIso2Code'	=> $languageIso2Code );
				$stepnameObject = Tx_ThRating_Service_ObjectFactoryService::createStepname($stepnameArray);
				$loopStepConf->addStepname($stepnameObject);
			}
			//self::persistRepository('Tx_ThRating_Domain_Repository_RatingobjectRepository', $ratingobject);	
		}
		return;
	}			
}
?>