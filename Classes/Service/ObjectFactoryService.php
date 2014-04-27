<?php
namespace Thucke\ThRating\Service;
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
class ObjectFactoryService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Returns the completed settings array
	 * 
	 * @param	array	$settings
	 * @return	array
	 */
	private function completeConfigurationSettings( array $settings ) {
		$configurationManager = self::getObject('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$cObj = $configurationManager->getContentObject();
		$currentRecord = array();
		if ( !empty($cObj->currentRecord) ) {
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
	 * @return	\Thucke\ThRating\Domain\Model\Ratingobject
	 */
	static function getRatingobject( array $settings ) {
		$ratingobjectRepository = self::getObject('Thucke\\ThRating\\Domain\\Repository\\RatingobjectRepository');
		//check whether a dedicated ratingobject is configured
		if ( !empty($settings['ratingobject']) ) {
			$ratingobject = $ratingobjectRepository->findByUid($settings['ratingobject']);
		} else {
			if ( empty($settings['ratetable']) || empty($settings['ratefield']) ) {
				//fallback to default configuration
				$settings = array_merge($settings, $settings['defaultObject']);
			}
			$settings = self::completeConfigurationSettings( $settings );		
			$ratingobject = $ratingobjectRepository->findMatchingTableAndField($settings['ratetable'], $settings['ratefield'], \Thucke\ThRating\Domain\Repository\RatingobjectRepository::addIfNotFound);
			//\Thucke\ThRating\Utility\ExtensionManagementUtility::persistObjectIfDirty('\Thucke\ThRating\Domain\Repository\RatingobjectRepository', $ratingobject);
		}
		return $ratingobject;
	}			

	/**
	 * Returns a new or existing ratingobject
	 * 
	 * @param	array	$stepconfArray
	 * @return	\Thucke\ThRating\Domain\Model\Stepconf
	 */
	static function createStepconf( array $stepconfArray ) {
		$stepconf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Stepconf');
		$stepconf->setRatingobject( $stepconfArray['ratingobject'] );
		$stepconf->setSteporder( $stepconfArray['steporder'] );
		$stepconf->setStepweight( $stepconfArray['stepweight'] );
		return $stepconf;
	}			

	/**
	 * Returns a new or existing ratingobject
	 * 
	 * @param	array	$stepconfArray
	 * @return	\Thucke\ThRating\Domain\Model\Stepconf
	 */
	static function createStepname ( array $stepnameArray ) {
		$stepname = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Stepname');
		$stepname->setStepname( $stepnameArray['stepname'] );
		
		if ( !empty($stepnameArray['languageIso2Code']) ) {
			//check if additional language flag exists in current website
			$syslangRepository = self::getObject('Thucke\\ThRating\\Domain\\Repository\\SyslangRepository');
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
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		return $objectManager->get($newObject);
	}


	/**
	 * Implemente a static version of the objectmanager get method
	 * 
	 * @param	string	$newObject	Object class name to get
	 * @return	mixed
	 */
	static function createObject( $newObject ) {
		If ( \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 6001000 ) {
			return self::getObject($newObject);
		} else {
			// get an ObjectManager first
			$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
			return $objectManager->create($newObject);
		}
	}


	/**
	 * Returns a new or existing rating
	 * 
	 * @param	array	$settings
 	 * @param	\Thucke\ThRating\Domain\Model\Ratingobject	$ratingobject
 	 * @throws 	RuntimeException
	 * @return	\Thucke\ThRating\Domain\Model\Rating
	 */
	static function getRating( array $settings,	\Thucke\ThRating\Domain\Model\Ratingobject $ratingobject = NULL ) {
		$settings = self::completeConfigurationSettings( $settings );		
		$ratingobjectValidator = self::getObject('Thucke\\ThRating\\Domain\\Validator\\RatingobjectValidator');
		$ratingRepository = self::getObject('Thucke\\ThRating\\Domain\\Repository\\RatingRepository');

		if ( !empty($settings['rating']) ) {
			//fetch rating when it is configured
			$rating = $ratingRepository->findByUid($settings['rating']);
		} elseif ( $ratingobjectValidator->isValid($ratingobject) && $settings['ratedobjectuid'] ) {
			//get rating according to given row
			$rating = $ratingRepository->findMatchingObjectAndUid($ratingobject, $settings['ratedobjectuid'], \Thucke\ThRating\Domain\Repository\RatingRepository::addIfNotFound);
		} else {
			throw new \TYPO3\CMS\Core\Exception(
				'Incomplete configuration setting. Either \'rating\' or \'ratedobjectuid\' are missing.',
				1398351336
			);		
		}
		return $rating;
	}			
	
	/**
	 * Returns a new or existing vote
	 * 
	 * @param									$prefixId
	 * @param	array							$settings
 	 * @param	\Thucke\ThRating\Domain\Model\Rating	$rating
	 * @return	\Thucke\ThRating\Domain\Model\Vote
	 */
	static function getVote( $prefixId, array $settings, \Thucke\ThRating\Domain\Model\Rating $rating ) {
		$voteRepository = self::getObject('Thucke\\ThRating\\Domain\\Repository\\VoteRepository');
		$voteValidator = self::getObject('Thucke\\ThRating\\Domain\\Validator\\VoteValidator');
		
		//first fetch real voter or anonymous
		$accessControllService = self::getObject('Thucke\\ThRating\\Service\\AccessControlService' );
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
				if ($voter instanceof \Thucke\ThRating\Domain\Model\Voter) {
					$vote = $voteRepository->findMatchingRatingAndVoter($rating->getUid(), $voter->getUid());
				}
			}
		}
		//voting not found in database or anonymous vote? - create new one
		if ( !$voteValidator->isValid($vote) ) {
			$vote = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Vote');
			$ratingValidator = self::getObject('Thucke\\ThRating\\Domain\\Validator\\RatingValidator');
			if ( $ratingValidator->isValid($rating) ) {
				$vote->setRating($rating);
			}
			if ($voter instanceof \Thucke\ThRating\Domain\Model\Voter) {
				$vote->setVoter($voter);
			}
		}
		return $vote;
	}				
}
?>