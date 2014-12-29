<?php
namespace Thucke\ThRating\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Hucke <thucke@web.de>
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
 * The Vote Controller
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class VoteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Thucke\ThRating\Domain\Model\Stepconf \Thucke\ThRating\Domain\Model\Stepconf
	 */
	protected $vote;
	/**
	 * @var \Thucke\ThRating\Domain\Model\RatingImage $ratingImage
	 */
	protected $ratingImage;
	/**
	 * @var array
	 */
	protected $ajaxSelections;
	/**
	 * @var string
	 */
	protected $ratingName;
	/**
	 * @var boolean
	 */
	protected $cookieProtection;
	/**
	 * @var int
	 */
	protected $cookieLifetime;
	/**
	 * @var array
	 */
	protected $signalSlotHandlerContent;
	/**
	 * @var $logger \TYPO3\CMS\Core\Log\Logger
	 */
	protected $logger;

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
	 * @var \Thucke\ThRating\Domain\Validator\VoteValidator
	 */
	protected $voteValidator;
	/**
	 * @param	\Thucke\ThRating\Domain\Validator\VoteValidator $voteValidator
	 * @return 	void
	 */
	public function injectVoteValidator(\Thucke\ThRating\Domain\Validator\VoteValidator $voteValidator) {
		$this->voteValidator = $voteValidator;
	}
	/**
	 * @var \Thucke\ThRating\Domain\Validator\RatingValidator
	 */
	protected $ratingValidator;
	/**
	 * @param	\Thucke\ThRating\Domain\Validator\RatingValidator	$ratingValidator
	 * @return	void
	 */
	public function injectRatingValidator( \Thucke\ThRating\Domain\Validator\RatingValidator $ratingValidator ) {
		$this->ratingValidator = $ratingValidator;
	}
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
	 * @var \Thucke\ThRating\Domain\Repository\StepconfRepository	$stepconfRepository
	 */
	protected $stepconfRepository;
	/**
	 * @param \Thucke\ThRating\Domain\Repository\StepconfRepository $stepconfRepository
	 * @return void
	 */
	public function injectStepconfRepository(\Thucke\ThRating\Domain\Repository\StepconfRepository $stepconfRepository) {
		$this->stepconfRepository = $stepconfRepository;
	}
	/**
	 * @var \Thucke\ThRating\Stepconf\Domain\Validator\StepconfValidator
	 */
	protected $stepconfValidator;
	/**
	 * @param	\Thucke\ThRating\Domain\Validator\StepconfValidator	$stepconfValidator
	 * @return	void
	 */
	public function injectStepconfValidator( \Thucke\ThRating\Domain\Validator\StepconfValidator $stepconfValidator ) {
		$this->stepconfValidator = $stepconfValidator;
	}
	/**
	 * @var \Thucke\ThRating\Service\ObjectFactoryService $objectFactoryService
	 */
	protected $objectFactoryService;
	/**
	 * @param	\Thucke\ThRating\Service\ObjectFactoryService $objectFactoryService
	 * @return	void
	 */
	public function injectObjectFactoryService( \Thucke\ThRating\Service\ObjectFactoryService $objectFactoryService ) {
		$this->objectFactoryService = $objectFactoryService;
	}
	/**
	 * @var \TYPO3\CMS\Core\Database\DatabaseConnection	The TYPO3 database object
	 */
	 protected $databaseConnection;
	 
	/**
	   * Lifecycle-Event
	   * wird nach der Initialisierung des Objekts und nach dem Auflösen der Dependencies aufgerufen.
	   * 
	   */
	  public function initializeObject() {
		 $this->databaseConnection = $GLOBALS['TYPO3_DB'];
		 //uncomment the following lines to get SQL DEBUG information of this extension
		 /*
		 $this->databaseConnection->explainOutput = 2;
		 $this->databaseConnection->store_lastBuiltQuery = TRUE;
		 $this->databaseConnection->debugOutput = 2;
		 */
	 }

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {
		//instantiate the logger
		$this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('Thucke\\ThRating\\Service\\ObjectFactoryService')->getLogger(__CLASS__);
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry point', array());

		$this->prefixId = strtolower('tx_' . $this->request->getControllerExtensionName(). '_' . $this->request->getPluginName());
				
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->settings,'settings');

		//Set default storage pids to SITEROOT
		$this->setStoragePids();

		$frameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		if ( $this->request->hasArgument('ajaxRef') ) {
			//read unique AJAX identification on AJAX request
			$this->ajaxSelections['ajaxRef'] = $this->request->getArgument('ajaxRef');
			$this->settings = json_decode($this->request->getArgument('settings'), TRUE);
			$frameworkConfiguration['settings'] = $this->settings;
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO, 'AJAX request detected - set new frameworkConfiguration', $frameworkConfiguration);
		} else { 
			//set unique AJAX identification
			$this->ajaxSelections['ajaxRef'] = $this->prefixId.'_'.$this->getRandomId();
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Set id for AJAX requests', $this->ajaxSelections);
		}

		if ( !is_array($frameworkConfiguration['ratings']) ) {
			$frameworkConfiguration['ratings'] = array();
		}	
        if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) < 6002004) {
            \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($this->settings['ratingConfigurations'], $frameworkConfiguration['ratings']);
            //$this->settings['ratingConfigurations'] = \TYPO3\CMS\Core\Utility\GeneralUtility::array_merge_recursive_overrule($this->settings['ratingConfigurations'], $frameworkConfiguration['ratings']);
        } else {
            \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($this->settings['ratingConfigurations'], $frameworkConfiguration['ratings']);
		}

		$this->setFrameworkConfiguration($frameworkConfiguration);
	}


	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		//update foreign table for each rating
		foreach ( $this->ratingobjectRepository->findAll() as $ratingobject ) {
			foreach ( $ratingobject->getRatings() as $rating ) {
				$setResult = $this->setForeignRatingValues($rating);
			}
		}
		$this->view->assign('ratingobjects', $this->ratingobjectRepository->findAll() );
		
		//initialize ratingobject and autocreate four ratingsteps
		$ratingobject = $this->objectManager->get('Thucke\\ThRating\\Utility\\ExtensionManagementUtility')->makeRatable('TestTable', 'TestField', 4);
		//add descriptions in default language to each stepconf
		$this->objectManager->get('Thucke\\ThRating\\Utility\\ExtensionManagementUtility')->setStepname($ratingobject->getStepconfs()->current(), 'Automatic generated entry ', 0, TRUE);		
		//add descriptions in german language to each stepconf
		$this->objectManager->get('Thucke\\ThRating\\Utility\\ExtensionManagementUtility')->setStepname($ratingobject->getStepconfs()->current(), 'Automatischer Eintrag ', 43, TRUE);		
	}



	/**
	 * Includes the hidden form to handle AJAX requests
	 */
	public function singletonAction( ) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry singletonAction', array());
		$this->renderCSS();
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit singletonAction', array());
	}


	/**
	 * Displays the vote of the current user
	 *
	 * @param 	\Thucke\ThRating\Domain\Model\Vote	$vote
	 * @return 	string 							The rendered voting
	 */
	public function showAction(	\Thucke\ThRating\Domain\Model\Vote	$vote = NULL ) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry showAction', array());
		//is_object($vote) && \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($vote->getUid(),'showAction');
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($vote->getVoter(),'vote_getVoter');
		$this->initVoting( $vote );  //just to set all properties

		if ($this->voteValidator->isValid($this->vote)) {
			if ($this->accessControllService->isLoggedIn($this->vote->getVoter())) {
				$this->fillSummaryView();
			} else {
				$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.create.noPermission', 'ThRating'),
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.error', 'ThRating'),
										"ERROR", array('errorCode' => 1403201246));
			}
		} else {
			if ($this->settings['showNotRated']) {
				$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.show.notRated', 'ThRating'), 
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.notice', 'ThRating'),
										"NOTICE", array('errorCode' => 1403201498));
			}
		}
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit showAction', array());
	}


	/**
	 * Creates a new vote
	 *
	 * @param	\Thucke\ThRating\Domain\Model\Vote	$vote	A fresh vote object which has not yet been added to the repository
	 * @return void
	 * dontverifyrequesthash
	 */
	//http://localhost:8503/index.php?id=71&tx_thrating_pi1[controller]=Vote&tx_thrating_pi1[action]=create&tx_thrating_pi1[vote][rating]=1&tx_thrating_pi1[vote][voter]=1&tx_thrating_pi1[vote][vote]=1
	public function createAction( \Thucke\ThRating\Domain\Model\Vote $vote) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry createAction', array('errorCode' => 1404934047));
		if ($this->accessControllService->isLoggedIn($vote->getVoter()) || $vote->isAnonymous() ) {
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Start processing', array('errorCode' => 1404934054));
			//if not anonymous check if vote is already done
			if ( !$vote->isAnonymous() ) {
				$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'FE user is logged in - looking for existing vote', array('errorCode' => 1404933999));
				$matchVote = $this->voteRepository->findMatchingRatingAndVoter($vote->getRating(), $vote->getVoter());
			}
			//add new or anonymous vote
			if ( !$this->voteValidator->isValid($matchVote) || $vote->isAnonymous() ) {
				$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'New vote could be added', array('errorCode' => 1404934012));
				$vote->getRating()->addVote($vote);
				if ( $vote->isAnonymous() && !$vote->hasAnonymousVote($this->prefixId) && $this->cookieProtection ) {
					$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Anonymous rating; preparing cookie potection', array('errorCode' => 1404934021));
					$anonymousRating['ratingtime']=time();
					$anonymousRating['voteUid']=$vote->getUid();
					$lifeTime = time() + 60 * 60 * 24 * $this->cookieLifetime;
					//set cookie to prevent multiple anonymous ratings
					$this->objectManager->get('Thucke\\ThRating\\Service\\CookieService')->setVoteCookie($this->prefixId.'_AnonymousRating_'.$vote->getRating()->getUid(), json_encode($anonymousRating), $lifeTime );
				}
				$setResult = $this->setForeignRatingValues($vote->getRating());
				If (!$setResult) {
					$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.create.foreignUpdateFailed', 'ThRating'), 
											\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.warning', 'ThRating'),
											"WARNING", array('errorCode' => 1403201551,
											'ratingobject' => $vote->getRating()->getRatingobject()->getUid(),
											'ratetable' => $vote->getRating()->getRatingobject()->getRatetable(),
											'ratefield' => $vote->getRating()->getRatingobject()->getRatefield()));
				}
				$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.create.newCreated', 'ThRating'), 
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.ok', 'ThRating'),
										"DEBUG", array( 'ratingobject' => $vote->getRating()->getRatingobject()->getUid(),
														'ratetable' => $vote->getRating()->getRatingobject()->getRatetable(),
														'ratefield' => $vote->getRating()->getRatingobject()->getRatefield(),
														'voter' => $vote->getVoter()->getUsername(),
														'vote' => (string) $vote->getVote()));
			} else {
				If ( $this->voteValidator->isValid($matchVote) && !empty($this->settings['enableReVote']) ) {
					$matchVoteStepconf = $matchVote->getVote();
					$newVoteStepconf = $vote->getVote();
					If ( $matchVoteStepconf !== $newVoteStepconf ) {
						//do update of existing vote
						$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.create.updateExistingVote', 'ThRating', 
													array($matchVoteStepconf->getSteporder(), (string) $matchVoteStepconf)),
												\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.ok', 'ThRating'),
												"DEBUG", array('voter UID' => $vote->getVoter()->getUid(),
												'ratingobject UID' => $vote->getRating()->getRatingobject()->getUid(),
												'rating' => $vote->getRating()->getUid(),
												'vote UID' => $vote->getUid(),
												'new vote' => (string) $vote->getVote(),
												'old vote' => (string) $matchVoteStepconf));
						$vote->getRating()->updateVote($matchVote, $vote);
					} else {
						$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.create.noUpdateSameVote', 'ThRating'), 
												\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.warning', 'ThRating'),
												"WARNING", array('voter UID' => $vote->getVoter()->getUid(),
												'ratingobject UID' => $vote->getRating()->getRatingobject()->getUid(),
												'rating' => $vote->getRating()->getUid(),
												'vote UID' => $vote->getUid(),
												'new vote' => (string) $newVoteStepconf,
												'old vote' => (string) $matchVoteStepconf));
					}
				} else {
					//display message that rating has been already done
					$vote = $matchVote;
					$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.create.alreadyRated', 'ThRating'), 
											\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.notice', 'ThRating'),
											"NOTICE", array('errorCode' => 1403202280,
											'voter UID' => $vote->getVoter()->getUid(),
											'ratingobject UID' => $vote->getRating()->getRatingobject()->getUid(),
											'rating' => $vote->getRating()->getUid(),
											'vote UID' => $vote->getUid()));
				}
			}
			$this->vote = $vote;
		} else {
			$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.create.noPermission', 'ThRating'), 
									\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.error', 'ThRating'),
									"ERROR", array('errorCode' => 1403203210));
		}

		$referrer = $this->request->getInternalArgument('__referrer');
		$newArguments = $this->request->getArguments();
		$newArguments['vote']['vote'] = $this->vote->getVote();  //replace vote argument with correct vote if user has already rated
		
		//Send signal to connected slots
		$this->initSignalSlotDispatcher( 'afterCreateAction' );
		$newArguments = \TYPO3\CMS\Core\Utility\GeneralUtility::array_merge($newArguments, array('signalSlotHandlerContent' => $this->signalSlotHandlerContent));

		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit createAction - forwarding request',
							array(
								'action' => $referrer['@action'],
								'controller' => $referrer['@controller'],
								'extension' => $referrer['@extension'],
								'newArguments' => $newArguments,
							));
		$this->forward($referrer['@action'], $referrer['@controller'], $referrer['@extension'], $newArguments );
	}


	/**
	 * FE user gives a new vote by SELECT form
	 * A classic SELECT input form will be provided to AJAX-submit the vote
	 *
	 * @param \Thucke\ThRating\Domain\Model\Vote 		$vote The new vote (used on callback from createAction)
	 * @return string The rendered view
	 * @ignorevalidation $vote
	 *
	 */
	public function newAction(	\Thucke\ThRating\Domain\Model\Vote	$vote = NULL) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry newAction', array());
		//find vote using additional information
		$this->initVoting( $vote );
		if ( !$this->vote->hasRated() || (!$this->accessControllService->isLoggedIn($this->vote->getVoter()) && $this->vote->isAnonymous()) ) {
			$this->view->assign('ajaxSelections', $this->ajaxSelections['json']);
			$this->fillSummaryView();
		} else {
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO, 'New rating is not possible; forwarding to showAction', array());
			$this->forward('show');
		}
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit newAction', array());
	}

	/**
	 * FE user gives a new vote by using a starrating obejct
	 * A graphic starrating object containing links will be provided to AJAX-submit the vote
	 *
	 * @param \Thucke\ThRating\Domain\Model\Vote 		$vote 	The new vote
	 * @return string The rendered view
	 * @ignorevalidation $vote
	 */
	//http://localhost:8503/index.php?id=71&tx_thrating_pi1[controller]=Vote&tx_thrating_pi1[action]=ratinglinks
	public function ratinglinksAction( \Thucke\ThRating\Domain\Model\Vote $vote = NULL) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry ratinglinksAction', array());
		$this->settings['ratingConfigurations']['default'] = 'stars';
		
		$this->graphicActionHelper($vote);
		if ( $this->settings['fluid']['templates']['ratinglinks']['likesMode'] ) {
			\TYPO3\CMS\Core\Utility\GeneralUtility::deprecationLog(
				get_class($this).': Setting "fluid.templates.ratinglinks.likesMode" is deprecated' .
					' Use the specific action "mark" as a replacement. Will be removed two versions after 0.10.2 - at least in version 1.0.'
			);
			$this->view->assign('actionMethodName','markAction');
		}
		
		$this->initSignalSlotDispatcher( 'afterRatinglinkAction' );
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit ratinglinksAction', array());
	}

	
	
	/**
	 * Handle graphic pollings
	 * Graphic bars containing links will be provided to AJAX-submit the polling
	 *
	 * @param \Thucke\ThRating\Domain\Model\Vote $vote The new vote
	 * @return string The rendered view
	 * @ignorevalidation $vote
	 */
	public function pollingAction( \Thucke\ThRating\Domain\Model\Vote $vote = NULL) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry pollingAction', array());
		$this->settings['ratingConfigurations']['default'] = 'polling';

		$this->graphicActionHelper($vote);

		$this->initSignalSlotDispatcher( 'afterPollingAction' );
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit pollingAction', array());
	}


	/**
	 * Handle mark action
	 * An icon containing for the mark action will be provided for AJAX-submission
	 *
	 * @param \Thucke\ThRating\Domain\Model\Vote 		$vote 	The new vote
	 * @return string The rendered view
	 * @ignorevalidation $vote
	 */
	public function markAction( \Thucke\ThRating\Domain\Model\Vote $vote = NULL) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry markAction', array());
		$this->settings['ratingConfigurations']['default'] = 'smileyLikes';

		$this->graphicActionHelper($vote);
		
		$this->initSignalSlotDispatcher( 'afterMarkAction' );
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit markAction', array());
	}

	
	/**
	 * FE user gives a new vote by using a starrating obejct
	 * A graphic starrating object containing links will be provided to AJAX-submit the vote
	 *
	 * @param \Thucke\ThRating\Domain\Model\Vote 		$vote 	The new vote
	 * @return string The rendered view
	 * @ignorevalidation $vote
	 */
	//http://localhost:8503/index.php?id=71&tx_thrating_pi1[controller]=Vote&tx_thrating_pi1[action]=ratinglinks
	public function graphicActionHelper(\Thucke\ThRating\Domain\Model\Vote	$vote = NULL) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry graphicActionHelper', array());
		$this->initSettings( $vote );
		$this->initVoting( $vote );
		$this->view->assign('actionMethodName',$this->actionMethodName);


		if ( $this->ratingValidator->isValid($this->vote->getRating()) ) {
			$calculatedRate = $this->vote->getRating()->getCalculatedRate().'%';
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Calculated rate', array('calculatedRate' => $calculatedRate));
			$this->view->assign('calculatedRate', $calculatedRate);

			$this->ratingImage = $this->objectManager->get('Thucke\\ThRating\\Domain\\Model\\RatingImage',$this->settings['ratingConfigurations'][$this->ratingName]['imagefile']);
			//read dimensions of the image
			$imageDimensions = $this->ratingImage->getImageDimensions();
			$height = $imageDimensions['height'];
			$width = $imageDimensions['width'];
			
			//calculate concrete values for polling display
			$currentRates = $this->vote->getRating()->getCurrentrates();
			$currentPollDimensions = $currentRates['currentPollDimensions'];
			foreach ( $currentPollDimensions as $step => $currentPollDimension ) {
				$currentPollDimensions[$step]['steporder'] = $step;
				$currentPollDimensions[$step]['backgroundPos'] = round( $height/3 * ( ($currentPollDimension['pctValue'] / 100) - 2 ),1);
				$currentPollDimensions[$step]['backgroundPosTilt'] = round( $width/3 * ( ($currentPollDimension['pctValue'] / 100) - 2 ),1);
			}
			
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Current polling dimensions', array('currentPollDimensions' => $currentPollDimensions));
			$this->view->assign('currentPollDimensions', $currentPollDimensions);
		}
		$this->view->assign('ratingName', $this->ratingName);
		$this->view->assign('ratingClass', $this->settings['ratingClass']);
		if ( 	(!$this->vote->isAnonymous() && $this->accessControllService->isLoggedIn($this->vote->getVoter()) && 
					(!$this->vote->hasRated() || !empty($this->settings['enableReVote']))) ||
				(($this->vote->isAnonymous() && !$this->accessControllService->isLoggedIn($this->vote->getVoter())) &&
					((!$this->vote->hasAnonymousVote($this->prefixId) && $this->cookieProtection && !$this->request->hasArgument('settings')) || !$this->cookieProtection))
			) {
			//if user hasn´t voted yet then include ratinglinks
			$this->view->assign('ajaxSelections', $this->ajaxSelections['steporder']);
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO, 'Set ratinglink information', array('errorCode' => 1404933850, 'ajaxSelections[steporder]' => $this->ajaxSelections['steporder']));
		}
		$this->fillSummaryView();
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit graphicActionHelper', array());
	}
	
	
	/**
	 * Initialize signalSlotHandler for given action
	 * Registered slots are being called with two parameters
	 * 1. signalSlotMessage:	an array consisting of
	 *		'tablename'		- the tablename of the rated object
	 *		'fieldname'		- the fieldname of the rated object
	 *		'uid'			- the uid of the rated object
	 *		'currentRates' 	- an array constising of the actual rating statistics
	 *			'currentrate'		- the calculated overall rating
	 *			'weightedVotes'		- an array giving the voting counts for every ratingstep
	 *			'sumWeightedVotes'	- an array giving the voting counts for every ratingstep multiplied by their weights
	 *			'anonymousVotes'	- count of anonymous votings
	 *		If the user has voted anonymous or non-anonymous:
	 *		'voter'			- the uid of the frontenduser that has voted
	 *		'votingStep'	- the ratingstep that has been choosen
	 *		'votingName'	- the name of the ratingstep
	 *		'anonymousVote'	- boolean info if it was an anonymous rating
	 *
	 * @param string	$slotName	the slotname
	 * @return void
	 */
	protected function initSignalSlotDispatcher( $slotName ) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry initSignalSlotDispatcher', array());
		if ( $this->request->hasArgument('signalSlotHandlerContent') ) {
			//set orginal handlerContent if action has been forwarded
			$this->signalSlotHandlerContent = $this->request->getArgument('signalSlotHandlerContent');
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO, 'Fetch static SignalSlotHandlerContent', array('signalSlotHandlerContent' => $this->signalSlotHandlerContent));
		} else {
			$signalSlotMessage = array();
			$signalSlotMessage['tablename'] = (string) $this->vote->getRating()->getRatingobject()->getRatetable();
			$signalSlotMessage['fieldname'] = (string) $this->vote->getRating()->getRatingobject()->getRatefield();
			$signalSlotMessage['uid'] = (int) $this->vote->getRating()->getRatedobjectuid();
			$signalSlotMessage['currentRates'] = $this->vote->getRating()->getCurrentrates();
			if ( $this->voteValidator->isValid($this->vote) ) {
				$signalSlotMessage['voter'] = $this->vote->getVoter()->getUid();
				$signalSlotMessage['votingStep'] = $this->vote->getVote()->getSteporder();
				$signalSlotMessage['votingName'] = strval($this->vote->getVote()->getStepname());
				$signalSlotMessage['anonymousVote'] = (bool) $this->vote->isAnonymous();
			}
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO, 'Going to process signalSlot', array('signalSlotMessage' => $signalSlotMessage));

			//clear signalSlotHandlerArray for sure
			$this->signalSlotHandlerContent = array();
			$this->signalSlotDispatcher->dispatch(__CLASS__, $slotName, array( $signalSlotMessage, &$this->signalSlotHandlerContent ));			
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO, 'New signalSlotHandlerContent', array('signalSlotHandlerContent' => $this->signalSlotHandlerContent));
		}
		$this->view->assign('staticPreContent', $this->signalSlotHandlerContent['staticPreContent']);
		$this->view->assign('staticPostContent', $this->signalSlotHandlerContent['staticPostContent']);
		unset($this->signalSlotHandlerContent['staticPreContent']);
		unset($this->signalSlotHandlerContent['staticPostContent']);
		$this->view->assign('preContent', $this->signalSlotHandlerContent['preContent']);
		$this->view->assign('postContent', $this->signalSlotHandlerContent['postContent']);
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit initSignalSlotDispatcher', array());
	}

	/**
	 * Check preconditions for rating
	 *
	 * @param \Thucke\ThRating\Domain\Model\Vote 			$vote 	the vote this selection is for
	 * @ignorevalidation $vote
	 * @return void
	 */
	protected function initVoting(	\Thucke\ThRating\Domain\Model\Vote $vote = NULL ) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry initVoting', array());
		if ( $this->voteValidator->isValid($vote) ) {
			$this->vote = $vote;
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Using valid vote', array());
		} else {
			//first initialize parent objects for vote object
			$ratingobject = $this->objectFactoryService->getRatingobject( $this->settings );
			$rating = $this->objectFactoryService->getRating($this->settings, $ratingobject);
			$this->vote = $this->objectFactoryService->getVote( $this->prefixId, $this->settings, $rating );

			$countSteps=count( $ratingobject->getStepconfs() );
			If ( empty($countSteps)) {
				$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.ratingobject.noRatingsteps', 'ThRating'),
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.error', 'ThRating'),
										"ERROR", array('errorCode' => 1403201012));
			}

			if (!$this->vote->getVoter() instanceof \Thucke\ThRating\Domain\Model\Voter) {
				$logVoterUid = 0;
				If ( !empty($this->settings['showNoFEUser']) ) {
					$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.noFEuser', 'ThRating'), 
											\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.notice', 'ThRating'),
											"NOTICE", array('errorCode' => 1403201096));
				}
			} else {
				$logVoterUid = $this->vote->getVoter()->getUid();
			}
		}
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO, 'Using vote', 
							array(
								'ratingobject' => $this->vote->getRating()->getRatingobject()->getUid(),
								'rating' => $this->vote->getRating()->getUid(),
								'voter' => $logVoterUid,
							));
		//set array to create voting information
		$this->setAjaxSelections($this->vote);
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit initVoting', array());
	}

	
	/**
	 * Check preconditions for settings
	 *
	 * @return void
	 */
	protected function initSettings() {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Entry initSettings', array());

		//set display configuration
		if ( !empty($this->settings['display'] ) ) {
			if ( isset($this->settings['ratingConfigurations'][$this->settings['display']]) ) {
				$this->ratingName = $this->settings['display'];
			} else {
				//switch back to default if given display configuration does not exist
				$this->ratingName = $this->settings['ratingConfigurations']['default'];
				$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.ratinglinks.wrongDisplayConfig', 'ThRating'),
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.error', 'ThRating'),
										"WARNING", array('errorCode' => 1403203414,
										'settings display' => $this->settings['display'],
										'avaiable ratingConfigurations' => $this->settings['ratingConfigurations']));
			}
		} else {
			//choose default ratingConfiguration if nothing is defined
			$this->ratingName = $this->settings['ratingConfigurations']['default'];
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::WARNING, 'Display name not set - using configured default',
								array('default display' => $this->ratingName));
		}
		$ratingConfiguration = $this->settings['ratingConfigurations'][$this->ratingName];

		//override extension settings with rating configuration settings
		if ( is_array($ratingConfiguration['settings']) ) {
			unset($ratingConfiguration['settings']['defaultObject']);
			unset($ratingConfiguration['settings']['ratingConfigurations']);
			if ( !is_array($ratingConfiguration['ratings'] )) {
				$ratingConfiguration['ratings'] = array();
			}	
            \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($this->settings, $ratingConfiguration['ratings']);
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 
								'Override extension settings with rating configuration settings', 
								array("Original setting" => $this->settings, "Overruling settings" => $ratingConfiguration['settings']));
		}
		//override fluid settings with rating fluid settings
		if (is_array($ratingConfiguration['fluid'])) {
            \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($this->settings['fluid'], $ratingConfiguration['fluid']);
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Override fluid settings with rating fluid settings', array());
		}
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO, 'Final extension configuration',
							array('settings' => $this->settings));
		
		//distinguish between bar and no-bar rating
		$this->view->assign('barimage', 'noratingbar');
		if ( $ratingConfiguration['barimage']) {
			$this->view->assign('barimage', 'ratingbar');
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Set ratingbar config', array());
		}

		//set tilt or normal rating direction
		$this->settings['ratingClass'] = 'normal';
		if ( $ratingConfiguration['tilt']) {
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Tilt rating class configuration', array());
			$this->settings['ratingClass'] = 'tilt';
		}

		$frameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$frameworkConfiguration['settings'] = $this->settings;
		$this->setFrameworkConfiguration($frameworkConfiguration);

		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit initSettings', array());
	}
	

	/**
	 * Build array of possible AJAX selection configuration
	 * @param \Thucke\ThRating\Domain\Model\Vote $vote the vote this selection is for
	 *
	 * @return array
	 */
	protected function setAjaxSelections(\Thucke\ThRating\Domain\Model\Vote $vote) {
		if ($vote->getVoter() instanceof \Thucke\ThRating\Domain\Model\Voter && empty($this->settings['displayOnly'])) {
			//cleanup settings to reduce data size in POST form
			$tmpDisplayConfig = $this->settings['ratingConfigurations'][$this->settings['display']];
			unset($this->settings['defaultObject']);
			unset($this->settings['ratingConfigurations']);
			$this->settings['ratingConfigurations'][$this->settings['display']] = $tmpDisplayConfig;

			$currentRates = $this->vote->getRating()->getCurrentrates();
			$currentPollDimensions = $currentRates['currentPollDimensions'];
			
			foreach ( $vote->getRating()->getRatingobject()->getStepconfs() as $i => $stepConf ) {
				$key = utf8_encode(json_encode( array(
					'value' 		=> $stepConf->getUid(),
					'voter' 		=> $vote->getVoter()->getUid(),
					'rating' 		=> $vote->getRating()->getUid(),
					'ratingName'	=> $this->ratingName,
					'settings'		=> json_encode($this->settings),
					'actionName'	=> strtolower($this->request->getControllerActionName()),
					'ajaxRef' 		=> $this->ajaxSelections['ajaxRef'])));
				$this->ajaxSelections['json'][$key] = strval($stepConf);
				$this->ajaxSelections['steporder'][$stepConf->getSteporder()]['step'] = $stepConf;
				$this->ajaxSelections['steporder'][$stepConf->getSteporder()]['ajaxvalue'] = $key;
			}
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Finalized ajaxSelections', array('ajaxSelections' => $this->ajaxSelections));
		}
	}


	/**
	 * Fill all variables for FLUID
	 *
	 * @return void
	 */
	protected function fillSummaryView() {
			$this->view->assign('settings', $this->settings);
			$this->view->assign('ajaxRef', $this->ajaxSelections['ajaxRef']);
			$this->view->assign('ratingobject', $this->vote->getRating()->getRatingobject());
			$this->view->assign('rating', $this->vote->getRating());
			$this->view->assign('voter', $this->vote->getVoter());

			$currentrate = $this->vote->getRating()->getCurrentrates();
			$this->view->assign('currentRates', $currentrate['currentrate']);
			$this->view->assign('stepCount', count($currentrate['weightedVotes']));
			$this->view->assign('anonymousVotes', $currentrate['anonymousVotes']);
			$this->view->assign('anonymousVoting', !empty($this->settings['mapAnonymous']) && !$this->accessControllService->getFrontendUserUid());
			if ( $this->settings['showNotRated'] && empty($currentrate['currentrate']) ) {
				$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.show.notRated', 'ThRating'), 
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.notice', 'ThRating'),
										"NOTICE", array('errorCode' => 1403203414));
			}
			if ( $this->voteValidator->isValid($this->vote) ) {
				if ( ( !$this->vote->isAnonymous() && $this->vote->getVoter()->getUid() == $this->accessControllService->getFrontendUserUid()) ||
						( $this->vote->isAnonymous() &&
							( $this->vote->hasAnonymousVote($this->prefixId) || $this->cookieProtection )
						)
					)
				{
					$this->view->assign('voting', $this->vote);
					$this->view->assign('usersRate', $this->vote->getVote()->getSteporder()*100/count($currentrate['weightedVotes']).'%');
				}
			}
	}

	/**
	 * Override getErrorFlashMessage to present
	 * nice flash error messages.
	 *
	 * @return string
	 */
	protected function getErrorFlashMessage() {
		switch ($this->actionMethodName) {
			case 'createAction' :
				return 'Could not create the new vote:';
			case 'showAction' :
				return 'Could not show vote!';
			default :
				return parent::getErrorFlashMessage();
		}
	}

	/**
	 * Checks all storagePid settings and
	 * sets them to SITEROOT if zero or empty
	 *
	 * @return void
	 */
	protected function setStoragePids() {
		$siteRootPids = $GLOBALS['TSFE']->getStorageSiterootPids();
		$siteRoot = $siteRootPids['_SITEROOT'];
		$storagePid = $siteRootPids['_STORAGE_PID'];
		$frameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$storagePids = \TYPO3\CMS\Extbase\Utility\ArrayUtility::integerExplode(',', $frameworkConfiguration['persistence']['storagePid'], TRUE);
		foreach ($storagePids as $i => $value) {
			if ( !is_null($value) && (empty($value) || $value==$siteRoot) ) {
				unset($storagePids[$i]);		//cleanup invalid values
			}
		}
		$storagePids = array_values($storagePids); 	//re-index array
		if ( count($storagePids)<2 && !is_null($storagePid) && !(empty($storagePid) || $storagePid==$siteRoot) ) {
			array_unshift($storagePids, $storagePid);	//append the page storagePid if it is assumed to be missed and is valid
		}

		foreach ( $frameworkConfiguration['persistence']['pluginCheckHelper'] as $x => $y) {
			if (intval($y)==0) {
				$frameworkConfiguration['persistence']['pluginCheckHelper'][$x] = 0;
			}
		}
		if (empty($storagePids[0])) {
			$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.general.invalidStoragePid', 'ThRating', array (1=>$storagePid)),
									\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.error', 'ThRating'),
									"ERROR", array('errorCode' => 1403203519));
		} 
		if ( empty($frameworkConfiguration['persistence']['pluginCheckHelper']['pluginStoragePid']) ) {
			$frameworkConfiguration['persistence']['classes']['Thucke\ThRating\Domain\Model\Ratingobject']['newRecordStoragePid'] = $storagePid;
			$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.pluginConfiguration.missing.pluginStoragePid', 'ThRating', array(1=>$storagePid)),
									\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.configuration.error', 'ThRating'),
									"WARNING", array('errorCode' => 1403203529,
													 '_STORAGE_PID' => $storagePid));
		}
		if ( empty($frameworkConfiguration['persistence']['pluginCheckHelper']['feUserStoragePid']) ) {
			$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.pluginConfiguration.missing.feUserStoragePid', 'ThRating', array()),
									\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.configuration.error', 'ThRating'),
									"ERROR", array('errorCode' => 1403190539));
		}
		$frameworkConfiguration['persistence']['storagePid'] = implode(',', $storagePids);
		$this->setFrameworkConfiguration($frameworkConfiguration);
	}
	
	/**
	 * Generates a random number
	 * used as the unique iddentifier for AJAX objects
	 *
	 * @return int
	 */
	protected function getRandomId () {
		srand ( (double)microtime () * 1000000 );
		return rand(1000000, 9999999);
	}

	/**
	 * Generates a random number
	 * used as the unique iddentifier for AJAX objects
	 *
	 * @return int
	 */
	protected function setFrameworkConfiguration(array $frameworkConfiguration) {
		$this->configurationManager->setConfiguration($frameworkConfiguration);
		$this->cookieLifetime = abs(intval($this->settings['cookieLifetime']));
		If ( empty($this->cookieLifetime) ) {
			$this->cookieProtection = FALSE;
		} else {
			$this->cookieProtection = TRUE;
		}
	}


	/**
	 * Render CSS-styles for ratings and ratingsteps
	 * Only called by singeltonAction to render styles once per page.
	 * The file 'typo3temp/thratingDyn.css' will be created if it doesn´t exist
	 * 
	 * @throws RuntimeException
	 * @return void
	 */
	protected function renderCSS() {
	//create file if it does not exist
		if (file_exists(PATH_site.'typo3temp/thratingDyn.css')) {
			$fstat = stat (PATH_site.'typo3temp/thratingDyn.css');
			//do not recreate file if it has greater than zero length
			if ( $fstat[7] != 0 ) {
				$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Dynamic CSS file exists - exiting', array());
				return;
			}
		}
		//display an error to update TYPO3 at least to version 6.2.1
		If ( \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) == 6002000 ) {
				$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.renderCSS.incompatible620', 'ThRating'),
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.configuration.error', 'ThRating'),
										"EMERGENCY", array( 'errorCode' => 1398526413,
															'T3version' => TYPO3_version));
				return;
		}

		//now walk through all ratingobjects to calculate stepwidths
		$allRatingobjects = $this->ratingobjectRepository->findAll(TRUE);
		foreach ( $allRatingobjects as $ratingobject) {
			$ratingobjectUid = $ratingobject->getUid();
			$stepconfObjects = $ratingobject->getStepconfs();
			$stepcount = count($stepconfObjects);
			If (!$stepcount) {
				$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.renderCSS.noStepconf', 'ThRating', 
																							array(1=>$ratingobject->getUid(), 2=>$ratingobject->getPid())),
										\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.configuration.error', 'ThRating'),
										"ERROR", array( 'errorCode' => 1384705470,
														'ratingobject UID' => $ratingobject->getUid(), 
														'ratingobject PID' => $ratingobject->getPid()));
				return;
			}
			$stepconfs = $stepconfObjects->toArray();
			foreach ( $stepconfs as $stepconf ) {	//stepconfs are already sorted by steporder
				//just do checks here that all steps are OK
				if ($this->stepconfValidator->isValid($stepconf)) {
					$stepWeights[] = $stepconf->getStepweight();
					$sumStepWeights += $stepconf->getStepweight();
				} else {
					foreach ($this->stepconfValidator->getErrors() as $errorMessage) {
						$this->logFlashMessage(	$errorMessage->getMessage(), 
												\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.configuration.error', 'ThRating'),
												"ERROR", array( 'errorCode' => $errorMessage->getCode(),
																'errorMessage' => $errorMessage->getMessage()));
					}
					return;
				}
			}
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO,
								'Ratingobject data',
								array(
									'ratingobject UID' => $ratingobject->getUid(), 
									'ratingobject PID' => $ratingobject->getPid(),
									'stepcount' => $stepcount,
									'stepWeights' => $stepWeights,
									'sumStepWeights' => $sumStepWeights,									
								));

			//generate CSS for all ratings out of TSConfig
			foreach ( $this->settings['ratingConfigurations'] as $ratingName => $ratingConfig) {
				if ( $ratingName == 'default' ) {
					continue;
				}
				$subURI = substr(PATH_site, strlen($_SERVER['DOCUMENT_ROOT'])+1);
				$basePath = $GLOBALS['TSFE']->baseUrl ? $GLOBALS['TSFE']->baseUrl : 'http://'.$_SERVER['HTTP_HOST'].'/'.$subURI;

				$this->ratingImage = $this->objectManager->get('Thucke\\ThRating\\Domain\\Model\\RatingImage',$ratingConfig['imagefile']);
				$filename = $this->ratingImage->getImageFile();
				if ( empty($filename) ) {
					$this->logFlashMessage(	\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.vote.renderCSS.defaultImage', 'ThRating'),
											\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('flash.heading.warning', 'ThRating'),
											"WARNING", array( 'errorCode' => 1403192702,
															  'ratingName' => $ratingName, 
															  'ratingConfig' => $ratingConfig));
					$defaultRatingName = $this->settings['ratingConfigurations']['default'];
					$ratingConfig = $this->settings['ratingConfigurations'][$defaultRatingName];
					$this->ratingImage->setConf($ratingConfig['imagefile']);
					$filename = $this->ratingImage->getImageFile();
				}
				$filenameUri = $basePath.'/'.$filename;		//prepend host basepath if no URL is given

				$imageDimensions = $this->ratingImage->getImageDimensions();
				$height = $imageDimensions['height'];
				$width = $imageDimensions['width'];
				$mainId = '.thRating-RObj'.$ratingobjectUid.'-'.$ratingName;
				$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Main CSS info',
									array(
										'mainId' => $mainId,
										'filenameUri' => $filenameUri,
										'image width' => $width,
										'image height' => $height));

				//calculate overall rating size depending on rating direction
				if ( $ratingConfig['tilt'] ){
					$width = round($width / 3,1);
					if ( !$ratingConfig['barimage'] ) {
						$height = $height * $sumStepWeights;
					}
					$cssFile .= $mainId.' { width:'.$width.'px; height:'.$height.'px; }'.CHR(10);
					$cssFile .= $mainId.', '.$mainId.' span:hover, '.$mainId.' span:active, '.$mainId.' span:focus, '.$mainId.' .current-rating {	background:url('.$filenameUri.') 0 0 repeat-y;	}'.CHR(10);
					$cssFile .= $mainId.' span, '.$mainId.' .current-rating { width:'.$width.'px; }'.CHR(10);
				} else {
					$height = round($height / 3,1);
					if ( !$ratingConfig['barimage'] ) {
						$width = $width * $sumStepWeights;
					}
					$cssFile .= $mainId.' { width:'.$width.'px; height:'.$height.'px; }'.CHR(10);
					$cssFile .= $mainId.', '.$mainId.' span:hover, '.$mainId.' span:active, '.$mainId.' span:focus, '.$mainId.' .current-rating {	background:url('.$filenameUri.') 0 0 repeat-x;	}'.CHR(10);
					$cssFile .= $mainId.' span, '.$mainId.' .current-rating { height:'.$height.'px; line-height:'.$height.'px; }'.CHR(10);
					//calculate widths/heights related to stepweights
					$i = 1;
					$stepPart = 0;
				}
				$cssFile .= $mainId.', '.$mainId.' span:hover, '.$mainId.' span:active, '.$mainId.' span:focus, '.$mainId.' .current-poll {	background:url('.$filenameUri.');	}'.CHR(10);
			}
				
			//calculate widths/heights related to stepweights
			$i = 1;
			$stepPart = 0;
			$sumWeights = 0;
			foreach ( $stepWeights as $stepWeight) {
				$sumWeights +=  $stepWeight;
				$zIndex = $stepcount-$i+2;  //add 2 to override .current-poll and .currentPollText
				//configure rating and polling styles for steps
				$oneStepPart =  round($stepWeight * 100 / $sumStepWeights, 1);	//calculate single width of ratingstep
				$cssFile .= 'span.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-ratingpoll-normal { width:'.$oneStepPart.'%; z-index:'.$zIndex.'; margin-left:'.$stepPart.'%;}'.CHR(10);
				$cssFile .= 'span.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-ratingpoll-tilt { height:'.$oneStepPart.'%; z-index:'.$zIndex.'; margin-bottom:'.$stepPart.'%; }'.CHR(10);
				$cssFile .= 'li.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-currentpoll-normal { width:'.$oneStepPart.'%; margin-left:'.$stepPart.'%; }'.CHR(10);
				$cssFile .= 'li.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-currentpoll-normal span { width:100%; }'.CHR(10);
				$cssFile .= 'li.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-currentpoll-tilt { height:'.$oneStepPart.'%; margin-bottom:'.$stepPart.'%; }'.CHR(10);
				$cssFile .= 'li.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-currentpoll-tilt span { height:100%; }'.CHR(10);
				$stepPart =  round($sumWeights * 100 / $sumStepWeights, 1);	//calculate sum of widths to this ratingstep
				$cssFile .= 'span.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-ratingstep-normal { width:'.$stepPart.'%; z-index:'.$zIndex.'; }'.CHR(10);
				$cssFile .= 'span.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-ratingstep-tilt { height:'.$stepPart.'%; z-index:'.$zIndex.'; }'.CHR(10);
				$i++;
			}
			//reset variables for next iteration
			unset($stepWeights);
			unset($sumWeights);
			unset($sumStepWeights);
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'CSS finished for ratingobjct', array());
		}

		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Saving CSS file', array('cssFile' => $cssFile));
		$fp = fopen ( PATH_site.'typo3temp/thratingDyn.css', 'w' );
		fwrite ( $fp, $cssFile);
		fclose ( $fp );
		return;
	}

	/**
	 * Sends log information to flashMessage and logging framework
	 *
	 * $messageText		string 	The message
	 * $messageTitle 	string	The header of the message
	 * $severity		string 	Logging severity
	 * $additionalInfo	array	some additional data - at least 'errorCode'
	 * @return	void
	 */
	private function logFlashMessage(	$messageText, 
										$messageTitle, 
										$severity, 
										array $additionalInfo) {
		$additionalInfo = \TYPO3\CMS\Core\Utility\GeneralUtility::array_merge($additionalInfo, array('messageTitle' => $messageTitle));
		$severity = strtoupper($severity);
		switch ($severity) {
			case 'DEBUG' :
				$flashSeverity = 'OK';
				break;
			case 'INFO' :
				$flashSeverity = 'NOTICE';
				break;
			case 'NOTICE' :
				$flashSeverity = 'INFO';
				break;
			case 'WARNING' :
				$flashSeverity = 'WARNING';
				break;
			default :
				$flashSeverity = 'ERROR';
		}
		If ( intval($additionalInfo['errorCode']) ) {
			$messageText = $messageText.' ('.$additionalInfo['errorCode'].')';
		}
		$this->addFlashMessage( $messageText,
								$messageTitle,
								constant('\TYPO3\CMS\Core\Messaging\AbstractMessage::'.$flashSeverity));
		$this->logger->log(	constant('\TYPO3\CMS\Core\Log\LogLevel::'.$severity),
							$messageText,
							$additionalInfo );
	}

	/**
	 * Sets the rating values in the foreign table
	 * Recommended field type is VARCHAR(255)
	 *
	 * @param \Thucke\ThRating\Domain\Model\Rating 		$rating The rating
	 * 
	 * @return boolean
	 *
	 */
	protected function setForeignRatingValues(	\Thucke\ThRating\Domain\Model\Rating	$rating ) {
		$table=$rating->getRatingobject()->getRatetable();
		$lockedFieldnames = $this->getLockedfieldnames($table);
		$rateField = $rating->getRatingobject()->getRatefield();
		if ( !in_array($rateField, $lockedFieldnames) && !empty($GLOBALS['TCA'][$table]['columns'][$rateField])) {
			$rateTable = $rating->getRatingobject()->getRatetable();
			$rateUid = $rating->getRatedobjectuid();
			$currentRatesArray = $rating->getCurrentrates();
				If (empty($this->settings['foreignFieldArrayUpdate'])) {
				//do update using DOUBLE value
				$currentRates = round($currentRatesArray['currentrate'], 2);
			} else {
				//do update using whole currentrates JSON array
				$currentRates = json_encode($currentRatesArray);
			}
			//do update foreign table
			$queryResult = $this->databaseConnection->exec_UPDATEquery ($rateTable, 'uid = '.$rateUid, array($rateField => $currentRates));
			return !empty($queryResult);
		} else {
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::NOTICE, 'Foreign ratefield does not exist in ratetable',
								array(
									'ratingobject UID' => $rating->getRatingobject()->getUid(),
									'ratetable' => $rating->getRatingobject()->getRatetable(),
									'ratefield' => $rating->getRatingobject()->getRatefield()));
			return TRUE;
		}
	}
	
	/**
	 * Create a list of fieldnamed that must not be updated with ratingvalues
	 *
	 * @param	string 	$table	tablename looking for system fields
	 * 
	 * @return array
	 *
	 */
	protected function getLockedfieldnames( $table ) {
		$TCA = &$GLOBALS['TCA'][$table]['ctrl']; // Set private TCA var
		$lockedFields = \TYPO3\CMS\Extbase\Utility\ArrayUtility::trimExplode(',', $TCA['label_alt'], TRUE);
		$lockedFields[] .= 'pid';
		$lockedFields[] .= 'uid';
		$lockedFields[] .= $TCA['label'];
		$lockedFields[] .= $TCA['tstamp'];
		$lockedFields[] .= $TCA['crdate'];
		$lockedFields[] .= $TCA['cruser_id'];
		$lockedFields[] .= $TCA['delete'];
		$lockedFields[] .= $TCA['enablecolumns']['disabled'];
		$lockedFields[] .= $TCA['enablecolumns']['starttime'];
		$lockedFields[] .= $TCA['enablecolumns']['endtime'];
		$lockedFields[] .= $TCA['enablecolumns']['fe_group'];
		$lockedFields[] .= $TCA['selicon_field'];
		$lockedFields[] .= $TCA['sortby'];
		$lockedFields[] .= $TCA['editlock'];
		$lockedFields[] .= $TCA['origUid'];
		$lockedFields[] .= $TCA['fe_cruser_id'];
		$lockedFields[] .= $TCA['fe_crgroup_id'];
		$lockedFields[] .= $TCA['fe_admin_lock'];
		$lockedFields[] .= $TCA['languageField'];
		$lockedFields[] .= $TCA['transOrigPointerField'];
		$lockedFields[] .= $TCA['transOrigPointerTable'];
		$lockedFields[] .= $TCA['transOrigDiffSourceField'];
		$lockedFields[] .= $TCA['transForeignTable'];
		return $lockedFields;
	}

	/**
	 * Demo slotHandler for slot 'afterRatinglinkAction'
	 *
	 * @param	array	$signalSlotMessage 	array containing signal information
	 * @param	array	$customContent 		array by reference to return pre and post content
	 * @return	void
	 */
	public function afterRatinglinkActionHandler($signalSlotMessage, &$customContent) {
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($signalSlotMessage,'signalSlotMessage');
		$customContent['preContent']='<b>This ist my preContent</b>';
		$customContent['staticPreContent']='<b>This ist my staticPreContent</b>';
		$customContent['postContent']='<b>This ist my postContent</b>';
		$customContent['staticPostContent']='<b>This ist my stticPostContent</b>';
	}

	/**
	 * Demo slotHandler for slot 'afterCreateAction'
	 *
	 * @param	array	$signalSlotMessage 	array containing signal information
	 * @param	array	$customContent 		array by reference to return pre and post content
	 * @return	void
	 */
	public function afterCreateActionHandler($signalSlotMessage, &$customContent) {
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($signalSlotMessage,'signalSlotMessage');
		$customContent['preContent']='<b>This ist my preContent after afterCreateActionHandler</b>';
		$customContent['staticPreContent']='<b>This ist my staticPreContent after afterCreateActionHandler</b>'; //this one would be display anyway ;-)
		$customContent['postContent']='<b>This ist my postContent after afterCreateActionHandler</b>';
	}

}
?>