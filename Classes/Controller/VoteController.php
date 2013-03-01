<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Thomas Hucke <thucke@web.de>
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
class Tx_ThRating_Controller_VoteController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_ThRating_Domain_Model_Stepconf
	 */
	protected $vote;
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
	 * @var Tx_Extbase_SignalSlot_Dispatcher
	 */
	protected $signalSlotDispatcher;

	/**
	 * @param Tx_ThRating_Service_ObjectFactoryService $objectFactoryService
	 */
	public function injectObjectFactoryService(Tx_ThRating_Service_ObjectFactoryService $objectFactoryService) {
		//... to make static functions of this singleton avaiable
	}
	
	/**
	 * @var Tx_ThRating_Service_AccessControlService
	 */
	protected $accessControllService;
	/**
	 * @param Tx_ThRating_Service_AccessControlService $accessControllService
	 */
	public function injectAccessControlService(Tx_ThRating_Service_AccessControlService $accessControllService) {
		$this->accessControllService = $accessControllService;
	}

	/**
	 * @var Tx_ThRating_Domain_Repository_VoteRepository
	 */
	protected $voteRepository;
	/**
	 * @param Tx_ThRating_Domain_Repository_VoteRepository $voteRepository
	 */
	public function injectVoteRepository(Tx_ThRating_Domain_Repository_VoteRepository $voteRepository) {
		$this->voteRepository = $voteRepository;
	}

	/**
	 * @var Tx_ThRating_Domain_Validator_VoteValidator
	 */
	protected $voteValidator;
	/**
	 * @param	Tx_ThRating_Domain_Validator_VoteValidator $voteValidator
	 * @return 	void
	 */
	public function injectVoteValidator(Tx_ThRating_Domain_Validator_VoteValidator $voteValidator) {
		$this->voteValidator = $voteValidator;
	}

	/**
	 * @var Tx_ThRating_Domain_Validator_RatingValidator
	 */
	protected $ratingValidator;
	/**
	 * @param	Tx_ThRating_Domain_Validator_RatingValidator	$ratingValidator
	 * @return	void
	 */
	public function injectRatingValidator( Tx_ThRating_Domain_Validator_RatingValidator $ratingValidator ) {
		$this->ratingValidator = $ratingValidator;
	}

	/**
	 * @var Tx_ThRating_Domain_Repository_RatingobjectRepository	$ratingobjectRepository
	 */
	protected $ratingobjectRepository;
	/**
	 * @param Tx_ThRating_Domain_Repository_RatingobjectRepository $ratingobjectRepository
	 * @return void
	 */
	public function injectRatingobjectRepository(Tx_ThRating_Domain_Repository_RatingobjectRepository $ratingobjectRepository) {
		$this->ratingobjectRepository = $ratingobjectRepository;
	}

	/**
	 * @var Tx_ThRating_Domain_Repository_StepconfRepository	$stepconfRepository
	 */
	protected $stepconfRepository;
	/**
	 * @param Tx_ThRating_Domain_Repository_StepconfRepository $stepconfRepository
	 * @return void
	 */
	public function injectStepconfRepository(Tx_ThRating_Domain_Repository_StepconfRepository $stepconfRepository) {
		$this->stepconfRepository = $stepconfRepository;
	}

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->prefixId = strtolower('tx_' . $this->request->getControllerExtensionName(). '_' . $this->request->getPluginName());
		$this->signalSlotDispatcher = $this->objectManager->get('Tx_Extbase_SignalSlot_Dispatcher');
		// checks if t3jquery is loaded
		if (t3lib_extMgm::isLoaded('t3jquery')) { require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php'); }
		// if t3jquery is loaded and the custom Library had been created
		// Integration of t3jquery moved to TS-Configuration
		/*if (T3JQUERY === true) {
			tx_t3jquery::addJqJS();
		} else {
			// if none of the previous is true, you need to include your own library
		}*/
		
		//Set default storage pids to SITEROOT
		$this->setStoragePids();

		//$this->defaultQuerySettings = $this->objectManager->create('Tx_Extbase_Persistence_Typo3QuerySettings');
		//Tx_Extbase_Utility_Debugger::var_dump($this->defaultQuerySettings->getRespectSysLanguage(),'vote');

		if ( $this->request->hasArgument('ajaxRef') ) {
			//read unique AJAX identification on AJAX request
			$this->ajaxSelections['ajaxRef'] = $this->request->getArgument('ajaxRef');
			If ( strtolower($this->request->getArgument('cookieLifetime')) == 'off' ) {
				$this->cookieProtection = false;
			} else {
				$this->cookieProtection = true;
				$this->cookieLifetime = intval($this->request->getArgument('cookieLifetime'));
			}
		} else { 
			//set unique AJAX identification
			$this->ajaxSelections['ajaxRef'] = $this->prefixId.'_'.$this->getRandomId();
			If ( empty($this->settings['cookieProtection']) ) {
				$this->cookieProtection = false;
			} else {
				$this->cookieProtection = true;
				$this->cookieLifetime = intval($this->settings['cookieLifetime']);
			}
		}
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
	}


	/**
	 * Includes the hidden form to handle AJAX requests
	 */
	public function singletonAction( ) {
		$this->renderCSS();
	}


	/**
	 * Displays the vote of the current user
	 *
	 * @param 	Tx_ThRating_Domain_Model_Vote	$vote
	 * @return 	string 							The rendered voting
	 */
	public function showAction(	Tx_ThRating_Domain_Model_Vote	$vote = NULL ) {
		//is_object($vote) && Tx_Extbase_Utility_Debugger::var_dump($vote->getUid(),'showAction');
		//Tx_Extbase_Utility_Debugger::var_dump(($vote->getVoter(),'vote_getVoter');
		$this->initVoting( $vote );  //just to set all properties

		if ($this->settings["valueOnly"]) {
			$currentRates = $this->vote->getRating()->getCurrentrates();
			return strval($currentRates["currentrate"]);
		}
		if ($this->voteValidator->isValid($this->vote)) {
			if ($this->accessControllService->isLoggedIn($this->vote->getVoter())) {
				$this->view->assign('vote', $this->vote);
				$this->fillSummaryView();
			} else {
				$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.create.noPermission', 'ThRating'),
													Tx_Extbase_Utility_Localization::translate('flash.heading.error', 'ThRating'),
													t3lib_FlashMessage::ERROR);
			}
		} else {
			$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.show.notRated', 'ThRating'), 
												Tx_Extbase_Utility_Localization::translate('flash.heading.notice', 'ThRating'),
												t3lib_FlashMessage::NOTICE);
		}
	}


	/**
	 * Creates a new vote
	 *
	 * @param Tx_ThRating_Domain_Model_Vote $vote A fresh vote object which has not yet been added to the repository
	 * @return void
	 * dontverifyrequesthash
	 */
	//http://localhost:8503/index.php?id=71&tx_thrating_pi1[controller]=Vote&tx_thrating_pi1[action]=create&tx_thrating_pi1[vote][rating]=1&tx_thrating_pi1[vote][voter]=1&tx_thrating_pi1[vote][vote]=1
	public function createAction(Tx_ThRating_Domain_Model_Vote $vote) {
		if ($this->accessControllService->isLoggedIn($vote->getVoter())  || $vote->isAnonymous() ) {
			//if not anonymous check if vote is already done
			if ( !$vote->isAnonymous() ) {
				$matchVote = $this->voteRepository->findMatchingRatingAndVoter($vote->getRating(),$vote->getVoter());
			}
			//add new or anonymous vote
			if ( !$this->voteValidator->isValid($matchVote) || $vote->isAnonymous() ) {
				$vote->getRating()->addVote($vote);
				//persist newly added object to enable redirect to show action
				//$this->persistenceManager->persistAll();
				if ( $vote->isAnonymous() && !$vote->hasAnonymousVote($this->prefixId) && $this->cookieProtection ) {
					$anonymousRating['ratingtime']=time();
					$anonymousRating['voteUid']=$vote->getUid();
					$lifeTime = time() + 60 * 60 * 24 * $this->cookieLifetime;
					#set cookie to prevent multiple anonymous ratings
					setcookie($this->prefixId.'_AnonymousRating_'.$vote->getRating()->getUid(), json_encode($anonymousRating), $lifeTime, '/',NULL, 0,1); #HTTP_ONLY
				}
				$setResult = $this->setForeignRatingValues($vote->getRating());
				If (!$setResult) {
					$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.create.foreignUpdateFailed', 'ThRating'), 
														Tx_Extbase_Utility_Localization::translate('flash.heading.warning', 'ThRating'),
														t3lib_Flashmessage::WARNING);
				}
				$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.create.newCreated', 'ThRating'), 
													Tx_Extbase_Utility_Localization::translate('flash.heading.ok', 'ThRating'),
													t3lib_Flashmessage::OK);
			} else {
				$vote = $matchVote;
				$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.create.alreadyRated', 'ThRating'), 
													Tx_Extbase_Utility_Localization::translate('flash.heading.notice', 'ThRating'),
													t3lib_FlashMessage::NOTICE);
			}
		} else {
			$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.create.noPermission', 'ThRating'), 
												Tx_Extbase_Utility_Localization::translate('flash.heading.error', 'ThRating'),
												t3lib_FlashMessage::ERROR);
		}

		$referrer = $this->request->getInternalArgument('__referrer');
		$newArguments = $this->request->getArguments();
		
		//Send signal to connected slots
		$this->signalSlotDispatcher->dispatch(__CLASS__, 'afterCreateAction', array($vote));

		$this->forward($referrer['@action'],$referrer['@controller'],$referrer['@extension'],$newArguments );
	}


	/**
	 * FE user gives a new vote by SELECT form
	 * A classic SELECT input form will be provided to AJAX-submit the vote
	 *
	 * @param Tx_ThRating_Domain_Model_Vote 		$vote The new vote (used on callback from createAction)
	 * @return string The rendered view
	 * @ignorevalidation $vote
	 *
	 */
	public function newAction(	Tx_ThRating_Domain_Model_Vote	$vote = NULL) {
		//find vote using additional information
		$this->initVoting( $vote );
		if ( !$this->vote->hasRated() || (!$this->accessControllService->isLoggedIn($this->vote->getVoter()) && $this->vote->isAnonymous()) ) {
			$this->view->assign('ajaxSelections', $this->ajaxSelections['json']);
			$this->fillSummaryView();
		} else {
			$this->forward('show');
		}
	}

	/**
	 * FE user gives a new vote by using a starrating obejct
	 * A graphic starrating object containing links will be provided to AJAX-submit the vote
	 *
	 * @param Tx_ThRating_Domain_Model_Vote 		$vote 	The new vote
	 * @return string The rendered view
	 * @ignorevalidation $vote
	 */
	//http://localhost:8503/index.php?id=71&tx_thrating_pi1[controller]=Vote&tx_thrating_pi1[action]=ratinglinks
	public function ratinglinksAction(	Tx_ThRating_Domain_Model_Vote	$vote = NULL) {
		//set display configuration
		if ( $this->request->hasArgument('ratingName') ) {
			//get ratingname e.g. when redirected from create action
			$this->ratingName = $this->request->getArgument('ratingName'); 
		} else {
			//choose default ratingConfiguration if nothing is defined
			if ( !empty($this->settings['display']) ) {
				$this->ratingName = $this->settings['display'];
			} else {
				$this->ratingName = $this->settings['ratingConfigurations']['default'];
			}
		}
		$this->initVoting( $vote );
		$ratingConfiguration = $this->settings['ratingConfigurations'][$this->ratingName];

		//first check if given ratingConfiguration exists
		if ( isset($ratingConfiguration) ) {
			$this->view->assign('barimage', 'noratingbar');
			if ( $ratingConfiguration['tilt']) {
				$calculatedRate = 'height:';
				$ratingClass = 'tilt';
				if ( $ratingConfiguration['barimage']) {
					$this->view->assign('barimage', 'ratingbar');
				}
				
			} else {
				$calculatedRate = 'width:';
				$ratingClass = 'normal';
			}

			if ( $this->ratingValidator->isValid($this->vote->getRating()) ) {
				$calculatedRate .= $this->vote->getRating()->getCalculatedRate().'%';
				$this->view->assign('calculatedRate', $calculatedRate);
			}
			$this->view->assign('ratingName', $this->ratingName);
			$this->view->assign('ratingClass', $ratingClass);
			//Tx_Extbase_Utility_Debugger::var_dump($this->vote,'vote');
			//is_object($this->vote->getVoter()) && Tx_Extbase_Utility_Debugger::var_dump($this->vote->hasAnonymousVote($this->prefixId),'isAnonymous');
			if ( !$this->vote->hasRated() || 
					(!$this->accessControllService->isLoggedIn($this->vote->getVoter()) && $this->vote->isAnonymous() && 
						!($this->vote->hasAnonymousVote($this->prefixId) || ( $this->cookieProtection && $this->request->getArgument('cookieLifetime')))
					) 
				) {
				//if user hasn´t voted yet then include ratinglinks
				$this->view->assign('ajaxSelections', $this->ajaxSelections['steporder']);
			}
			$this->fillSummaryView();
		} else {
			$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.ratinglinks.wrongDisplayConfig', 'ThRating'), 
												Tx_Extbase_Utility_Localization::translate('flash.heading.error', 'ThRating'),
												t3lib_FlashMessage::ERROR);
		}
		$this->signalSlotDispatcher->dispatch(__CLASS__, 'afterRatinglinkAction', array($this->vote, $this->view));
		//TODO: expected for Typo3 6.x
		//t3lib_SignalSlot_Dispatcher::getInstance()->dispatch(__CLASS__, 'afterRatinglinkAction', array( 'ratingname'=>$this->ratingname ));
	}

	public function afterRatinglinkActionHandler($vote, $view) {
		Tx_Extbase_Utility_Debugger::var_dump(func_num_args(),'func_num_args()');	
		Tx_Extbase_Utility_Debugger::var_dump(func_get_args(),' func_get_args()');	
		Tx_Extbase_Utility_Debugger::var_dump($view,'afterRatinglinkActionHandler_data');
	}

	/**
	 * Check preconditions for rating
	 *
	 * @param Tx_ThRating_Domain_Model_Vote 			$vote 	the vote this selection is for
	 * @ignorevalidation $vote
	 * @return void
	 */
	protected function initVoting(	Tx_ThRating_Domain_Model_Vote 			$vote = null ) {
		if ( $this->voteValidator->isValid($vote) ) {
			$this->vote = $vote;
		} else {
			//first initialize parent objects for vote object
			$ratingobject = Tx_ThRating_Service_ObjectFactoryService::getRatingobject( $this->settings );
			$rating = Tx_ThRating_Service_ObjectFactoryService::getRating( $this->settings, $ratingobject );
			$this->vote = Tx_ThRating_Service_ObjectFactoryService::getVote( $this->prefixId, $this->settings, $rating );

			$countSteps=count( $ratingobject->getStepconfs() );
			If ( empty($countSteps)) {
				$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.ratingobject.noRatingsteps', 'ThRating'), 
													Tx_Extbase_Utility_Localization::translate('flash.heading.error', 'ThRating'),
													t3lib_FlashMessage::ERROR); 
			}

			if (!$this->vote->getVoter() instanceof Tx_ThRating_Domain_Model_Voter) {
				If ( !empty($this->settings['showNoFEUser']) ) {
					$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.noFEuser', 'ThRating'), 
														Tx_Extbase_Utility_Localization::translate('flash.heading.notice', 'ThRating'),
														t3lib_FlashMessage::NOTICE); 
				}
			}
		}
		//set array to create voting information
		$this->setAjaxSelections($this->vote);
	}


	/**
	 * Build array of possible AJAX selection configuration
	 * @param Tx_ThRating_Domain_Model_Vote $vote the vote this selection is for
	 *
	 * @return array
	 */
	protected function setAjaxSelections(Tx_ThRating_Domain_Model_Vote $vote) {
		if ($vote->getVoter() instanceof Tx_ThRating_Domain_Model_Voter) {
			foreach ( $this->getLocalizedStepconfs($vote->getRating()->getRatingobject()) as $i => $stepConf ) {
				$key = utf8_encode(json_encode( array(
					'value' 	=> $stepConf->getUid(),
					'voter' 	=> $vote->getVoter()->getUid(),
					'rating' 		=> $vote->getRating()->getUid(),
					'ratingName'	=> $this->ratingName,
					'cookieLifetime'	=> $this->cookieProtection ? $this->cookieLifetime : 'off',
					'actionName'	=> strtolower($this->request->getControllerActionName()),
					'ajaxRef' 		=> $this->ajaxSelections['ajaxRef'])));
				$this->ajaxSelections['json'][$key] = $stepConf->getStepname();
				$this->ajaxSelections['steporder'][$stepConf->getSteporder()]['step'] = $stepConf;
				$this->ajaxSelections['steporder'][$stepConf->getSteporder()]['ajaxvalue'] = $key;
			}
		}
	}

	
	/**
	 * Find all localized stepconf records of a given ratingobject
	 * Due to a bug in l18n-handling in Typo3 4.7 this was necessary
	 * @param Tx_ThRating_Domain_Model_Ratingobject $ratingobject the ratingobject this selection is for
	 *
	 * @return array
	 */
	protected function getLocalizedStepconfs(Tx_ThRating_Domain_Model_Ratingobject $ratingobject) {
		If ( t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) < 6000000 ) {
			$localizedStepconfs = $this->stepconfRepository->findLocalizedByRatingobject(intval($ratingobject->getUid()));
		} else {
			$localizedStepconfs = $ratingobject->getStepconfs();
		}
		return $localizedStepconfs;
	}
	
	
	/**
	 * Fill all variables for FLUID
	 *
	 * @return void
	 */
	protected function fillSummaryView() {
			$this->view->assign('ajaxRef', $this->ajaxSelections['ajaxRef']);
			$this->view->assign('ratingobject', $this->vote->getRating()->getRatingobject());
			$this->view->assign('rating', $this->vote->getRating());
			$this->view->assign('voter', $this->vote->getVoter());

			$currentrate = $this->vote->getRating()->getCurrentrates();
			$this->view->assign('currentRates', $currentrate['currentrate']);
			$this->view->assign('stepCount', count($currentrate['weightedVotes']));
			$this->view->assign('anonymousVotes', $currentrate['anonymousVotes']);
			$this->view->assign('anonymousVoting', !empty($this->settings['mapAnonymous']) && !$this->accessControllService->getFrontendUserUid());
			empty($currentrate['currentrate']) && $this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('flash.vote.show.notRated', 'ThRating'), 
																					Tx_Extbase_Utility_Localization::translate('flash.heading.notice', 'ThRating'),
																					t3lib_FlashMessage::NOTICE);
			if ( $this->voteValidator->isValid($this->vote) ) {
				if ( ( !$this->vote->isAnonymous() && $this->vote->getVoter()->getUid() == $this->accessControllService->getFrontendUserUid()) ||
						( $this->vote->isAnonymous() && 
							( $this->vote->hasAnonymousVote($this->prefixId)  || ( $this->cookieProtection && $this->request->getArgument('cookieLifetime')))
						)
					)
				{
					$this->view->assign('voting', $this->vote);
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
		$frameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		//t3lib_utility_Debug::debug($frameworkConfiguration,'frameworkConfiguration');		
		//$storagePids = explode(',',$frameworkConfiguration['persistence']['storagePid']);
		$storagePids = Tx_Extbase_Utility_Arrays::integerExplode(',',$frameworkConfiguration['persistence']['storagePid'],true);
		foreach ($storagePids as $i => $value) {
			if ( !is_null($value) && (empty($value) || $value==$siteRoot) ) {
				unset($storagePids[$i]);		//cleanup invalid values
			}
		}
		$storagePids = array_values($storagePids); 	//re-index array
		if ( count($storagePids)<2 && !is_null($storagePid) && !(empty($storagePid) || $storagePid==$siteRoot) ) {
			array_unshift($storagePids,$storagePid);	//append the page storagePid if it is assumed to be missed and is valid
		}

		if (empty($storagePids[0])) {
			$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.general.invalidStoragePid', 'ThRating'), 
												Tx_Extbase_Utility_Localization::translate('flash.heading.error', 'ThRating'),
												t3lib_FlashMessage::ERROR);
		} 
		$frameworkConfiguration['persistence']['storagePid'] = implode(',',$storagePids);
		$this->configurationManager->setConfiguration($frameworkConfiguration);
	}
	
	/**
	 * Generates a random number
	 * used as the unique iddentifier for AJAX objects
	 *
	 * @return int
	 */
	protected function getRandomId () {
		srand ( (double)microtime () * 1000000 );
		return rand(1000000,9999999);
	}



	/**
	 * Render CSS-styles for ratings and ratingsteps
	 * Only called by singeltonAction to render styles once per page.
	 * The file 'typo3temp/thratingDyn.css' will be created if it doesn´t exist
	 * 
	 * @return void
	 */
	protected function renderCSS() {
	//create file if it does not exist
		if (file_exists(PATH_site.'typo3temp/thratingDyn.css')) {
			$fstat = stat (PATH_site.'typo3temp/thratingDyn.css');
			//do not recreate file if it has greater than zero length
			if ( $fstat[7] != 0 ) {
				return;
			}
		}
		
		//now walk through all ratingobjects to calculate stepwidths
		$allRatingobjects = $this->ratingobjectRepository->findAll(true);
		foreach ( $allRatingobjects as $ratingobject) {
			$ratingobjectUid = $ratingobject->getUid();
			$localizedStepconfs = $this->getLocalizedStepconfs($ratingobject);
			$stepcount = count($localizedStepconfs);
			$stepconfs = $localizedStepconfs->toArray();
			foreach ( $stepconfs as $stepconf ) {	//stepconfs are already sorted by steporder
				$stepWeights[] = $stepconf->getStepweight();
				$sumStepWeights += $stepconf->getStepweight();
			}

			//generate CSS for all ratings out of TSConfig
			foreach ( $this->settings['ratingConfigurations'] as $ratingName => $ratingConfig) {
				$subURI = substr(PATH_site,strlen($_SERVER['DOCUMENT_ROOT'])+1);
				$basePath = $GLOBALS['TSFE']->baseUrl ? $GLOBALS['TSFE']->baseUrl : 'http://'.$_SERVER['HTTP_HOST'].'/'.$subURI;

				$filename = PATH_site.'/'.$ratingConfig['imagefile'];
				if ( empty($ratingConfig['imagefile']) || !file_exists($filename) ) {
					$defaultRatingName = $this->settings['ratingConfigurations']['default'];
					$ratingConfig = $this->settings['ratingConfigurations'][$defaultRatingName];
					$filename = PATH_site.'/'.$ratingConfig['imagefile'];
					$this->flashMessageContainer->add(	Tx_Extbase_Utility_Localization::translate('flash.vote.renderCSS.defaultImage', 'ThRating'), 
														Tx_Extbase_Utility_Localization::translate('flash.heading.warning', 'ThRating'),
														t3lib_FlashMessage::WARNING);
				}
				$filenameUri = $basePath.'/'.$ratingConfig['imagefile'];		//prepend host basepath if no URL is given

				//read dimensions of the image
				list($width, $height) = getimagesize($filename);
				$mainId = '.thRating-RObj'.$ratingobjectUid.'-'.$ratingName;

				//calculate overall rating size depending on rating direction
				if ( $ratingConfig['tilt'] ){
					$width = round($width / 3);
					if ( !$ratingConfig['barimage'] ) {
						$height = $height * $sumStepWeights;
					}
					$cssFile .= $mainId.' { width:'.$width.'px; height:'.$height.'px; }'.CHR(10);
					$cssFile .= $mainId.', '.$mainId.' a:hover, '.$mainId.' a:active, '.$mainId.' a:focus, '.$mainId.' .current-rating {	background:url('.$filenameUri.') 0 0 repeat-y;	}'.CHR(10);
					$cssFile .= $mainId.' a, '.$mainId.' .current-rating {	width:'.$width.'px; }'.CHR(10);
				} else {
					$height = round($height / 3);
					if ( !$ratingConfig['barimage'] ) {
						$width = $width * $sumStepWeights;
					}
					$cssFile .= $mainId.' { width:'.$width.'px; height:'.$height.'px; }'.CHR(10);
					$cssFile .= $mainId.', '.$mainId.' a:hover, '.$mainId.' a:active, '.$mainId.' a:focus, '.$mainId.' .current-rating {	background:url('.$filenameUri.') 0 0 repeat-x;	}'.CHR(10);
					$cssFile .= $mainId.' a, '.$mainId.' .current-rating {	height:'.$height.'px; line-height:'.$height.'px; }'.CHR(10);
				}
			}
				
			//calculate widths/heights related to stepweights
			$i = 1;
			foreach ( $stepWeights as $stepWeight) {
				$sumWeights +=  $stepWeight;
				$zIndex = $stepcount-$i+2;
				$stepPart =  round($sumWeights * 100 / $sumStepWeights);
				$cssFile .= 'a.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-ratingstep-normal { width:'.$stepPart.'%; z-index:'.$zIndex.'; }'.CHR(10);
				$cssFile .= 'a.RObj'.$ratingobjectUid.'-StpOdr'.$i.'-ratingstep-tilt { height:'.$stepPart.'%; z-index:'.$zIndex.'; }'.CHR(10);
				$i++;
			}
			//reset variables for next iteration
			unset($stepWeights);
			unset($sumWeights);
			unset($sumStepWeights);
		}

		$fp = fopen ( PATH_site.'typo3temp/thratingDyn.css', 'w' );
		fwrite ( $fp, $cssFile);
		fclose ( $fp );
		return;
	}

	/**
	 * Sets the rating values in the foreign table
	 * Recommended field type is DOUBLE
	 *
	 * @param Tx_ThRating_Domain_Model_Rating 		$rating The rating
	 * 
	 * @return boolean
	 *
	 */
	protected function setForeignRatingValues(	Tx_ThRating_Domain_Model_Rating	$rating ) {
		$table=$rating->getRatingobject()->getRatetable();
		$lockedFieldnames = $this->getLockedfieldnames($table);
		$rateField = $rating->getRatingobject()->getRatefield();
		if ( !in_array($rateField,$lockedFieldnames )) {
			$rateTable = $rating->getRatingobject()->getRatetable();
			$rateUid = $rating->getRatedobjectuid();
			$currentRatesArray = $rating->getCurrentrates();
			$currentRate = round($currentRatesArray["currentrate"],2);
			#do update foreign table
			$queryResult = $GLOBALS['TYPO3_DB']->exec_UPDATEquery ($rateTable,'uid = '.$rateUid,array($rateField => $currentRate)) ;
			return !empty($queryResult);
		} else {
			return true;
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
		$GLOBALS['TSFE']->includeTCA();
		t3lib_div::loadTCA($table);
		$TCA = &$GLOBALS["TCA"][$table]['ctrl']; // Set private TCA var
		$lockedFields = Tx_Extbase_Utility_Arrays::trimExplode(',',$TCA['label_alt'],true);
		$lockedFields[] .= 'pid';
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
}
?>