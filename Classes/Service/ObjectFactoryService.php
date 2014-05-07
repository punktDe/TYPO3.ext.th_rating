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
class ObjectFactoryService extends \Thucke\ThRating\Service\AbstractExtensionService {

	/**
	 * @var \Thucke\ThRating\Domain\Repository\RatingobjectRepository	$ratingobjectRepository
	 */
	protected $ratingobjectRepository;
	/**
	 * @param \Thucke\ThRating\Domain\Repository\RatingobjectRepository $ratingobjectRepository
	 * @return void
	 */
	public function injectRatingobjectRepository(\Thucke\ThRating\Domain\Repository\RatingobjectRepository $ratingobjectRepository) {
		$this->ratingobjectRepository = $ratingobjectRepository;
	}
	/**
	 * @var \Thucke\ThRating\Domain\Repository\RatingRepository	$ratingRepository
	 */
	protected $ratingRepository;
	/**
	 * @param \Thucke\ThRating\Domain\Repository\RatingRepository $ratingRepository
	 * @return void
	 */
	public function injectRatingRepository(\Thucke\ThRating\Domain\Repository\RatingRepository $ratingRepository) {
		$this->ratingRepository = $ratingRepository;
	}
	/**
	 * @var \Thucke\ThRating\Domain\Repository\VoteRepository
	 */
	protected $voteRepository;
	/**
	 * @param \Thucke\ThRating\Domain\Repository\VoteRepository $voteRepository
	 */
	public function injectVoteRepository(\Thucke\ThRating\Domain\Repository\VoteRepository $voteRepository) {
		$this->voteRepository = $voteRepository;
	}
	/**
	 * @var \Thucke\ThRating\Service\AccessControlService
	 */
	protected $accessControllService;
	/**
	 * @param \Thucke\ThRating\Service\AccessControlService $accessControllService
	 */
	public function injectAccessControlService(\Thucke\ThRating\Service\AccessControlService $accessControllService) {
		$this->accessControllService = $accessControllService;
	}

	/**
	 * Constructor
	 * Must overrule the abstract class method to avoid self referencing
	 * @return void
	 */
	public function __construct(  ) {
		if ( empty($this->objectManager) ) {
			$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		}
		//instantiate the logger
		$this->logger = $this->getLogger(get_class($this));
	}

	/**
	 * Returns the completed settings array
	 * 
	 * @param	array	$settings
	 * @return	array
	 */
	private function completeConfigurationSettings( array $settings ) {
		$cObj = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager')->getContentObject();
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
	public function getRatingobject( array $settings ) {
		//check whether a dedicated ratingobject is configured
		if ( !empty($settings['ratingobject']) ) {
			$ratingobject = $this->ratingobjectRepository->findByUid($settings['ratingobject']);
		} else {
			if ( empty($settings['ratetable']) || empty($settings['ratefield']) ) {
				//fallback to default configuration
				$settings = array_merge($settings, $settings['defaultObject']);
			}
			$settings = $this->completeConfigurationSettings( $settings );		
			$ratingobject = $this->ratingobjectRepository->findMatchingTableAndField($settings['ratetable'], $settings['ratefield'], \Thucke\ThRating\Domain\Repository\RatingobjectRepository::addIfNotFound);
		}
		return $ratingobject;
	}			

	/**
	 * Returns a new or existing ratingobject
	 * 
	 * @param	array	$stepconfArray
	 * @return	\Thucke\ThRating\Domain\Model\Stepconf
	 */
	public function createStepconf( array $stepconfArray ) {
		$stepconf = $this->objectManager->get('Thucke\\ThRating\\Domain\\Model\\Stepconf');
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
	public function createStepname ( array $stepnameArray ) {
		$stepname = $this->objectManager->get('Thucke\\ThRating\\Domain\\Model\\Stepname');
		$stepname->setStepname( $stepnameArray['stepname'] );
		
		if ( !empty($stepnameArray['languageIso2Code']) ) {
			//check if additional language flag exists in current website
			$languageObject = $this->objectManager->get('Thucke\\ThRating\\Domain\\Repository\\SyslangRepository')->findByStaticLangIsocode($stepnameArray['languageIso2Code']);
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
	 * Returns a new or existing rating
	 * 
	 * @param	array	$settings
 	 * @param	\Thucke\ThRating\Domain\Model\Ratingobject	$ratingobject
 	 * @throws 	RuntimeException
	 * @return	\Thucke\ThRating\Domain\Model\Rating
	 */
	public function getRating( array $settings,	\Thucke\ThRating\Domain\Model\Ratingobject $ratingobject = NULL ) {
		$settings = $this->completeConfigurationSettings( $settings );		
		if ( !empty($settings['rating']) ) {
			//fetch rating when it is configured
			$rating = $this->ratingRepository->findByUid($settings['rating']);
		} elseif ( $this->objectManager->get('Thucke\\ThRating\\Domain\\Validator\\RatingobjectValidator')->isValid($ratingobject) && $settings['ratedobjectuid'] ) {
			//get rating according to given row
			$rating = $this->ratingRepository->findMatchingObjectAndUid($ratingobject, $settings['ratedobjectuid'], \Thucke\ThRating\Domain\Repository\RatingRepository::addIfNotFound);
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
	public function getVote( $prefixId, array $settings, \Thucke\ThRating\Domain\Model\Rating $rating ) {
		//first fetch real voter or anonymous
		$frontendUserUid = $this->accessControllService->getFrontendUserUid();
		if ( !empty($settings['mapAnonymous']) && !$frontendUserUid ) {
			//set anonymous vote
			$voter =  $this->accessControllService->getFrontendVoter($settings['mapAnonymous']);
			$anonymousRating = json_decode($_COOKIE[$prefixId.'_AnonymousRating_'.$rating->getUid()], TRUE);
			if ( !empty($anonymousRating['voteUid']) ) {
				$vote = $this->voteRepository->findByUid($anonymousRating['voteUid']);
			}
		} else {
			if ( $frontendUserUid ) {
				//set FEUser if one is logged on
				$voter =  $this->accessControllService->getFrontendVoter( $frontendUserUid );
				if ($voter instanceof \Thucke\ThRating\Domain\Model\Voter) {
					$vote = $this->voteRepository->findMatchingRatingAndVoter($rating->getUid(), $voter->getUid());
				}
			}
		}
		//voting not found in database or anonymous vote? - create new one
		if ( !$this->objectManager->get('Thucke\\ThRating\\Domain\\Validator\\VoteValidator')->isValid($vote) ) {
			$vote = $this->objectManager->get('Thucke\\ThRating\\Domain\\Model\\Vote');
			if ( $this->objectManager->get('Thucke\\ThRating\\Domain\\Validator\\RatingValidator')->isValid($rating) ) {
				$vote->setRating($rating);
			}
			if ($voter instanceof \Thucke\ThRating\Domain\Model\Voter) {
				$vote->setVoter($voter);
			}
		}
		return $vote;
	}

	
	/**
	 * Get a logger instance
	 * The configuration of the logger is modified by extension typoscript config
	 *
	 * @param	string	$name the class name which this logger is for
	 * @return void
	 */
	public function getLogger( $name ) {
		$writerConfiguration = $GLOBALS['TYPO3_CONF_VARS']['LOG']['Thucke']['ThRating']['writerConfiguration'];
		$settings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager')->getConfiguration('Settings', 'thRating', 'pi1');
		foreach ($settings['logging'] as $logLevel => $logConfig) {
			$levelUppercase = strtoupper($logLevel);
			If ( !empty($logConfig['file'] )) {
				$writerConfiguration[constant('\TYPO3\CMS\Core\Log\LogLevel::'.$levelUppercase)]['TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter'] = 
					array('logFile' => $logConfig['file']);
			}
			If ( !empty($logConfig['database'] )) {
				$writerConfiguration[constant('\TYPO3\CMS\Core\Log\LogLevel::'.$levelUppercase)]['TYPO3\\CMS\\Core\\Log\\Writer\\Database'] = 
					array('table' => $logConfig['table']);
			}
		}
		$GLOBALS['TYPO3_CONF_VARS']['LOG']['Thucke']['ThRating']['writerConfiguration'] = $writerConfiguration;
		$logger = $this->objectManager->get('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger( $name );
		return $logger;
	}
	
	/**
	 * Update and persist attached objects to the repository
	 *
	 * @param	string	$repository
	 * @param	\TYPO3\CMS\Extbase\DomainObject\AbstractEntity	$objectToPersist
	 * @return void
	 */
	public function persistRepository($repository, \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $objectToPersist) {
		$objectUid=$objectToPersist->getUid();
		If (empty($objectUid)) {
			$this->objectManager->get($repository)->add($objectToPersist);
		} else {
			$this->objectManager->get($repository)->update($objectToPersist);
		}
		$this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
		$this->objectManager->get('Thucke\\ThRating\\Utility\\TCALabelUserFuncUtility')->clearCachePostProc(NULL, NULL, NULL);  //Delete the file 'typo3temp/thratingDyn.css'
	}
}
?>