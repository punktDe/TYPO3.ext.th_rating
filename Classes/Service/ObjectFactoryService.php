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

/**
 * Factory for model objects
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU protected License, version 2
 */
class Tx_ThRating_Service_ObjectFactoryService implements t3lib_Singleton {

	/**
	 * Returns the completed settings array
	 * 
	 * @param	array	$settings
	 * @return	array
	 */
	private function completeConfigurationSettings( array $settings ) {
		$configurationManager = self::getObject('Tx_Extbase_Configuration_ConfigurationManager');
		$cObj = $configurationManager->getContentObject();
		$currentRecord = array();
		if ( isset($cObj->currentRecord) ) {
			$currentRecord = explode(':', $cObj->currentRecord);	//build array [0=>cObj tablename, 1=> cObj uid] - initialize with content information (usage as normal content)
		} else {
			$currentRecord = array('pages',$GLOBALS['TSFE']->page['uid']);	//build array [0=>cObj tablename, 1=> cObj uid] - initialize with page info if used by typoscript
		}
		
		if (empty($settings['ratetable'])) {
			$settings['ratetable'] = $currentRecord[0];
		}
		if (empty($settings['ratefield'])) {
			$settings['ratefield'] = 'uid';
		}		
		if (empty($settings['ratedobjectuid'])) {
			$settings['ratedobjectuid'] = $currentRecord[1];
		}
		return $settings;
	}

	/**
	 * Returns a new or existing ratingobject
	 * 
	 * @param	array	$settings
	 * @return	Tx_ThRating_Domain_Model_Ratingobject
	 */
	static function getRatingobject( array $settings ) {
		$ratingobjectRepository = self::getObject('Tx_ThRating_Domain_Repository_RatingobjectRepository');

		//check whether a dedicated ratingobject is configured
		if ( !empty($settings['ratingobject']) ) {
			$ratingobject = $ratingobjectRepository->findByUid($settings['ratingobject']);
		} else {
			if ( empty($settings['ratetable']) || empty($settings['ratefield']) ) {
				//fallback to default configuration
				$settings = array_merge($settings, $settings['defaultObject']);
			}
			$settings = self::completeConfigurationSettings( $settings );		
			$ratingobject = $ratingobjectRepository->findMatchingTableAndField($settings['ratetable'], $settings['ratefield'], Tx_ThRating_Domain_Repository_RatingobjectRepository::addIfNotFound);
			//Tx_ThRating_Utility_ExtensionManagementUtility::persistObjectIfDirty('Tx_ThRating_Domain_Repository_RatingobjectRepository', $ratingobject);
		}
		return $ratingobject;
	}			

	/**
	 * Returns a new or existing ratingobject
	 * 
	 * @param	array	$stepconfArray
	 * @return	Tx_ThRating_Domain_Model_Stepconf
	 */
	static function createStepconf( array $stepconfArray ) {
		$stepconf = t3lib_div::makeInstance('Tx_ThRating_Domain_Model_Stepconf');
		$stepconf->setRatingobject( $stepconfArray['ratingobject'] );
		$stepconf->setSteporder( $stepconfArray['steporder'] );
		$stepconf->setStepweight( $stepconfArray['stepweight'] );
		return $stepconf;
	}			

	/**
	 * Returns a new or existing ratingobject
	 * 
	 * @param	array	$stepconfArray
	 * @return	Tx_ThRating_Domain_Model_Stepconf
	 */
	static function createStepname ( array $stepnameArray ) {
		$stepname = t3lib_div::makeInstance('Tx_ThRating_Domain_Model_Stepname');
		$stepname->setStepname( $stepnameArray['stepname'] );
		
		if ( !empty($stepnameArray['languageIso2Code']) ) {
			//check if additional language flag exists in current website
			$syslangRepository = self::getObject('Tx_ThRating_Domain_Repository_SyslangRepository');
			$languageObject = $syslangRepository->findByStaticLangIsocode($stepnameArray['languageIso2Code']);
			if ( $languageObject->count() > 0 ) {
				$stepname->set_languageUid( $languageObject->getFirst()->getUid() );
			} else {
				//treat as default language on invalid flag
				$stepname->set_languageUid( 0 );
			}
		} else {
			$stepname->set_languageUid( 0 );
		}
		return $stepname;
	}			

	/**
	 * Implemente a static version of the objectmanager get method
	 * 
	 * @param	string	$newObject	Object class name to get
	 * @return	mixed
	 */
	static function getObject( $newObject ) {
		// get an ObjectManager first
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		return $objectManager->get($newObject);
	}


	/**
	 * Implemente a static version of the objectmanager get method
	 * 
	 * @param	string	$newObject	Object class name to get
	 * @return	mixed
	 */
	static function createObject( $newObject ) {
		// get an ObjectManager first
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		return $objectManager->create($newObject);
	}


	/**
	 * Returns a new or existing rating
	 * 
	 * @param	array	$settings
 	 * @param	Tx_ThRating_Domain_Model_Ratingobject	$ratingobject
	 * @return	Tx_ThRating_Domain_Model_Rating
	 */
	static function getRating( array $settings,	Tx_ThRating_Domain_Model_Ratingobject	$ratingobject = NULL ) {
		$settings = self::completeConfigurationSettings( $settings );		
		$ratingobjectValidator = self::getObject('Tx_ThRating_Domain_Validator_RatingobjectValidator');
		$ratingRepository = self::getObject('Tx_ThRating_Domain_Repository_RatingRepository');

		if ( !empty($settings['rating']) ) {
			//fetch rating when it is configured
			$rating = $ratingRepository->findByUid($settings['rating']);
		} elseif ( $ratingobjectValidator->isValid($ratingobject) && $settings['ratedobjectuid'] ) {
			//get rating according to given row
			$rating = $ratingRepository->findMatchingObjectAndUid($ratingobject, $settings['ratedobjectuid'],Tx_ThRating_Domain_Repository_RatingRepository::addIfNotFound);
		}
		return $rating;
	}			
	
	/**
	 * Returns a new or existing vote
	 * 
	 * @param									$prefixId
	 * @param	array							$settings
 	 * @param	Tx_ThRating_Domain_Model_Rating	$rating
	 * @return	Tx_ThRating_Domain_Model_Vote
	 */
	static function getVote( $prefixId, array $settings,	Tx_ThRating_Domain_Model_Rating	$rating ) {
		$voteRepository = self::getObject('Tx_ThRating_Domain_Repository_VoteRepository');
		$voteValidator = self::getObject('Tx_ThRating_Domain_Validator_VoteValidator');

		//first fetch real voter or anonymous
		$accessControllService = self::getObject('Tx_ThRating_Service_AccessControlService' );
		$frontendUserUid = $accessControllService->getFrontendUserUid();
		if ( !empty($settings['mapAnonymous']) && !$frontendUserUid ) {
			//set anonymous vote
			$voter =  $accessControllService->getFrontendVoter($settings['mapAnonymous']);
			$anonymousRating = json_decode($_COOKIE[$prefixId.'_AnonymousRating_'.$rating->getUid()], TRUE);
			if ( !empty($anonymousRating['voteUid']) ) {
				$vote = $voteRepository->findByUid($anonymousRating['voteUid']);
			}
		} else {
			if ( $frontendUserUid ) {
				//set FEUser if one is logged on
				$voter =  $accessControllService->getFrontendVoter( $frontendUserUid );
				if ($voter instanceof Tx_ThRating_Domain_Model_Voter) {
					$vote = $voteRepository->findMatchingRatingAndVoter($rating->getUid(), $voter->getUid());
				}
			}
		}
		
		//voting not found in database or anonymous vote? - create new one
		if ( !$voteValidator->isValid($vote) ) {
			$vote = t3lib_div::makeInstance('Tx_ThRating_Domain_Model_Vote');
			$ratingValidator = self::getObject('Tx_ThRating_Domain_Validator_RatingValidator');
			if ( $ratingValidator->isValid($rating) ) {
				$vote->setRating($rating);
			}
			if ($voter instanceof Tx_ThRating_Domain_Model_Voter) {
				$vote->setVoter($voter);
			}
		}
		return $vote;
	}				
}
?>