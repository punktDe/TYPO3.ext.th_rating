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
 * The Vote Controller
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_ThRating_Controller_VoteController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_ThRating_Domain_Model_Ratingobject
	 */
	protected $ratingobject;
	/**
	 * @var Tx_ThRating_Domain_Model_Rating
	 */
	protected $rating;
	/**
	 * @var Tx_ThRating_Domain_Model_Stepconf
	 */
	protected $vote;
	/**
	 * @var Tx_Extbase_Domain_Model_FrontendUser
	 */
	protected $voter;
	/**
	 * @var array
	 */
	protected $ajaxSelections;
	/**
	 * @var boolean
	 */
	protected $hasRated;
	/**
	 * @var string
	 */
	protected $ratingName;
	

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
	 * @param Tx_ThRating_Domain_Validator_VoteValidator $voteRepository
	 * @return void
	 */
	public function injectVoteValidator(Tx_ThRating_Domain_Validator_VoteValidator $voteValidator) {
		$this->voteValidator = $voteValidator;
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
	 * @var Tx_ThRating_Domain_Repository_RatingRepository	$ratingRepository
	 */
	protected $ratingRepository;
	/**
	 * @param Tx_ThRating_Domain_Repository_RatingRepository $ratingRepository
	 * @return void
	 */
	public function injectRatingRepository(Tx_ThRating_Domain_Repository_RatingRepository $ratingRepository) {
		$this->ratingRepository = $ratingRepository;
	}

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->prefixId = strtolower('tx_' . $this->request->getControllerExtensionName(). '_' . $this->request->getPluginName());
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
		$this->hasRated = false;

		if ( $this->request->hasArgument('ratingName') ) {
			//read unique AJAX identification on AJAX request
			$this->ratingName = $this->request->getArgument('ratingName'); 
		}
		
		if ( $this->request->hasArgument('ajaxRef') ) {
			//read unique AJAX identification on AJAX request
			$this->ajaxSelections['ajaxRef'] = $this->request->getArgument('ajaxRef'); 
		} else { 
			//set unique AJAX identification
			$this->ajaxSelections['ajaxRef'] = $this->getRandomId(); 
			//read and set needed objects from TS settings if possible
			if ( $this->settings['preferTSSettings'] ) {
				$this->loadSettingsObjects();
			}
		}
	}



	/**
	 * Index action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->view->assign('ratingobjects', $this->ratingobjectRepository->findAll() );
	}



	/**
	 * Includes the hidden form to handle AJAX requests
	 */
	public function singletonAction( ) {
		$this->view->assign('allRatingobjects', $allRatingobjects);
		$this->view->assign('ajaxRef', $this->ajaxSelections['ajaxRef']);
		$this->view->assign('vote', $this->vote);
		$this->view->assign('voter', $this->voter);
		$this->view->assign('rating', $this->rating);
		$this->view->assign('ratingobject', $this->ratingobject);
		$this->renderCSS();
	}


	/**
	 * Displays the vote of the current user
	 *
	 * @param Tx_ThRating_Domain_Model_Vote		$vote
	 * @param Tx_ThRating_Domain_Model_Rating		$rating The rating object
	 * @param Tx_Extbase_Domain_Model_FrontendUser 	$voter The UID of the voter
	 * @return string The rendered voting
	 *
	 * Call variant 1:	giving parameter ($vote)
	 * Call variant 2:	giving parameter ($rating, $voter)
	 -> show voting of the given FE user (restricted usage)
	 * Call variant 3:	giving parameter ($ratetable, $ratefield,$ratedobjectuid)
	 */
	public function showAction(	Tx_ThRating_Domain_Model_Vote $vote = NULL,
											Tx_ThRating_Domain_Model_Rating $rating = NULL,
											Tx_Extbase_Domain_Model_FrontendUser $voter = NULL) {

		$this->checkDoubleRate($rating, $vote, $voter );  //just to set all properties

		if ($this->settings["valueOnly"]) {
			$currentRates = $this->rating->getCurrentrates();
			return strval($currentRates["currentrate"]);
		}
		if ($this->voteValidator->isValid($this->vote)) {
			if ($this->accessControllService->isLoggedIn($this->vote->getVoter()) || $this->settings['preferTSSettings'] ) {
				$this->view->assign('vote', $this->vote);
				$this->fillSummaryView();
			} else {
				$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.create.noPermission', 'ThRating', t3lib_FlashMessage::ERROR));
			}
		} elseif ( $voter instanceof Tx_Extbase_Domain_Model_FrontendUser ) {
			$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.show.notRated', 'ThRating', t3lib_FlashMessage::NOTICE));
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
			if (!$vote->isAnonymous()) {
				$matchVote = $this->voteRepository->findMatchingRatingAndVoter($vote->getRating(),$vote->getVoter());
			}
			//add new or anonymous vote
			if (!$this->voteValidator->isValid($matchVote) || $vote->isAnonymous() ) {
				$vote->getRating()->addVote($vote);
				//persist newly added object to enable redirect to show action
				Tx_Extbase_Dispatcher::getPersistenceManager()->persistAll();
				$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.create.newCreated', 'ThRating'));
			} else {
				$vote = $matchVote;
				$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.create.alreadyRated', 'ThRating', t3lib_FlashMessage::NOTICE));
			}
		} else {
			$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.create.noPermission', 'ThRating', t3lib_FlashMessage::ERROR));
		}

		$referrer = $this->request->getArgument('__referrer');
		$this->forward($referrer['actionName'],$referrer['controllerName'],$referrer['extensionName'],$this->request->getArguments());
	}


	/**
	 * FE user gives a new vote by SELECT form
	 * A classic SELECT input form will be provided to AJAX-submit the vote
	 *
	 * @param Tx_ThRating_Domain_Model_Rating 		$rating The rating object
	 * @param Tx_Extbase_Domain_Model_FrontendUser 	$voter The UID of the voter
	 * @param Tx_ThRating_Domain_Model_Vote 		$vote The new vote (used on callback from createAction)
	 * @param string 	$ratetable 		optional: The rating objects table name
	 * @param string 	$ratefield 		optional: The rating objects field name
	 * @param int 	$ratedobjectuid 	optional: The UID of interest
	 * @return string The rendered view
	 * @dontvalidate $vote
	 *
	 * Call variant 1:	giving parameter ($rating)
	 *			-> do a new vote for the logged on FE user
	 * Call variant 2:	giving parameter ($ratetable, $ratefield,$ratedobjectuid)
	 *			-> do a new vote for the logged on FE user
	 * - additional parameter $voter will do the new vote for the FE user having this UID (restricted usage)
	 */
	public function newAction(	Tx_ThRating_Domain_Model_Rating			$rating = null,
										Tx_Extbase_Domain_Model_FrontendUser 	$voter = NULL,
										Tx_ThRating_Domain_Model_Vote 			$vote = NULL) {
		//find vote using additional information
		$this->checkDoubleRate($rating, $vote, $voter );
		if ( !$this->hasRated || $this->vote->isAnonymous() ) {
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
	 * @param Tx_ThRating_Domain_Model_Rating		$rating 	The rating object
	 * @param Tx_Extbase_Domain_Model_FrontendUser 	$voter 	The UID of the voter
	 * @param Tx_ThRating_Domain_Model_Vote 		$vote 	The new vote
	 * @param string 	$ratetable 		optional: The rating objects table name
	 * @param string 	$ratefield 		optional: The rating objects field name
	 * @param int 	$ratedobjectuid 	optional: The UID of interest
	 * @return string The rendered view
	 * @dontvalidate $vote
	 */
	//http://localhost:8503/index.php?id=71&tx_thrating_pi1[controller]=Vote&tx_thrating_pi1[action]=ratinglinks&tx_thrating_pi1[rating]=1&tx_thrating_pi1[voter]=1
	public function RatinglinksAction(	Tx_ThRating_Domain_Model_Rating 			$rating = NULL,
													Tx_Extbase_Domain_Model_FrontendUser 	$voter = NULL,
													Tx_ThRating_Domain_Model_Vote 			$vote = NULL) {

		if ( empty($this->ratingName) ) {
			//choose default ratingConfiguration if nothing is defined
			if ( !empty($this->settings['display']) ) {
				$this->ratingName = $this->settings['display'];
			} else {
				$this->ratingName = $this->settings['ratingConfigurations']['default'];
			}
		}
			
		$this->checkDoubleRate($rating, $vote, $voter );
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

			if ($this->rating instanceof Tx_ThRating_Domain_Model_Rating ) {
				$calculatedRate .= $this->rating->getCalculatedRate().'%';
				$this->view->assign('calculatedRate', $calculatedRate);
			}
			$this->view->assign('ratingName', $this->ratingName);
			$this->view->assign('ratingClass', $ratingClass);
			if ( !$this->hasRated || $this->vote->isAnonymous() ) {
				//if user hasn´t voted yet then include ratinglinks
				$this->view->assign('ajaxSelections', $this->ajaxSelections['steporder']);
			}
			$this->fillSummaryView();
		} else {
			$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.ratinglinks.wrongDisplayConfig', 'ThRating', t3lib_FlashMessage::ERROR));
		}
	}


	/**
	 * Check preconditions for rating
	 *
	 * @param Tx_ThRating_Domain_Model_Rating 		$rating 	the vote this selection is for
	 * @param Tx_ThRating_Domain_Model_Vote 			$vote 	the vote this selection is for
	 * @param Tx_Extbase_Domain_Model_FrontendUser 	$voter 	The UID of the voter
	 * @dontvalidate $vote
	 * @return viod
	 */
	protected function checkDoubleRate(	Tx_ThRating_Domain_Model_Rating 			$rating = null,
													Tx_ThRating_Domain_Model_Vote 			$vote = null,
													Tx_Extbase_Domain_Model_FrontendUser 	$voter = NULL) {
		if ( $vote instanceof Tx_ThRating_Domain_Model_Vote ) {
			unset($this->settings['vote']);
			$this->vote = $vote;
			$this->voter = $this->vote->getVoter();
			$this->loadSettingsObjects();
		} else {
			$requArgs = $this->request->getArguments();		//read additional parameters to find the concerned rating
			if ( $voter instanceof Tx_Extbase_Domain_Model_FrontendUser ) {
				$this->voter = $voter;
			} elseif ( $this->settings['mapAnonymous'] && !$this->accessControllService->getFrontendUserUid() ) {
				//set anonymous vote
				$this->voter = $this->accessControllService->getFrontendUser($this->settings['mapAnonymous']);
			}
			if ( $rating instanceof Tx_ThRating_Domain_Model_Rating ) {
				$this->rating = $rating;
			} else {
				if ( isset($GLOBALS['TSFE']->currentRecord) ) {
						$currentRecord = explode(':',$GLOBALS['TSFE']->currentRecord);	//build array [0=>cObj tablename, 1=> cObj uid] - initialize with content information (usage as normal content)
					} else {
						$currentRecord = array('pages',$GLOBALS['TSFE']->page['uid']);	//build array [0=>cObj tablename, 1=> cObj uid] - initialize with page info if used by typoscript
					}

					if ($this->request->hasArgument('ratetable')) {
						$this->settings['ratetable'] = $requArgs['ratetable'];
					} elseif (empty($this->settings['ratetable'])) {
						$this->settings['ratetable'] = $currentRecord[1];
					}

					if ($this->request->hasArgument('ratefield')) { 
						$this->settings['ratefield'] = $requArgs['ratefield'];
					} elseif (empty($this->settings['ratefield'])) {
						$this->settings['ratefield'] = $currentRecord[1];
					}
					
					if ($this->request->hasArgument('ratedobjectuid')) {
						$this->settings['ratedobjectuid'] = $requArgs['ratedobjectuid'];
					} elseif (empty($this->settings['ratedobjectuid'])) {
						$this->settings['ratedobjectuid'] = $currentRecord[1];
					}
			}
			$this->loadSettingsObjects();
		}

		//set array to create voting information
		if ($this->vote instanceof Tx_ThRating_Domain_Model_Vote) {
			$this->setAjaxSelections($this->vote);
		}
	}


	/**
	 * Build array of possible AJAX selection configuration
	 * @param Tx_ThRating_Domain_Model_Vote $vote the vote this selection is for
	 *
	 * @return array
	 */
	protected function setAjaxSelections(Tx_ThRating_Domain_Model_Vote $vote) {
		foreach ( $vote->getRating()->getRatingobject()->getStepconfs() as $i => $stepConf ) {
			$key = utf8_encode(json_encode( array(
				'value' 	=> $stepConf->getUid(),
				'voter' 	=> $vote->getVoter()->getUid(),
				'rating' 		=> $vote->getRating()->getUid(),
				'ratingName'	=> $this->ratingName,
				'actionName'	=> strtolower($this->request->getControllerActionName()),
				'ajaxRef' 		=> $this->ajaxSelections['ajaxRef'])));
			$this->ajaxSelections['json'][$key] = $stepConf->getStepname();
			$this->ajaxSelections['steporder'][$stepConf->getSteporder()]['step'] = $stepConf;
			$this->ajaxSelections['steporder'][$stepConf->getSteporder()]['ajaxvalue'] = $key;
		}
	}

	/**
	 * Fill all variables for FLUID
	 *
	 * @return void
	 */
	protected function fillSummaryView() {
			$this->view->assign('showSummary', $this->settings['showSummary']);
			$this->view->assign('ajaxRef', $this->ajaxSelections['ajaxRef']);
			$this->view->assign('ratingobject', $this->ratingobject);
			$this->view->assign('rating', $this->rating);
			$this->view->assign('voter', $this->voter);
			
			$currentrate = $this->rating->getCurrentrates();
			$this->view->assign('currentRates', $currentrate['currentrate']);
			$this->view->assign('stepCount', count($currentrate['weightedVotes']));
			$this->view->assign('anonymousVotes', $currentrate['anonymousVotes']);
			$this->view->assign('anonymousVoting', $this->vote->isAnonymous());
			empty($currentrate['currentrate']) && $this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.show.notRated', 'ThRating', t3lib_FlashMessage::ERROR));
			if ( $this->voteValidator->isValid($this->vote) && !$this->vote->isAnonymous() && 
					$this->vote->getVoter()->getUid() == $this->accessControllService->getFrontendUserUid()) {
				$this->view->assign('voting', $this->vote);
			}
	}


	/**
	 * Loads objects from repositories
	 *
	 * Gets TS configuration settings and loads the needed objects
	 * @return void
	 */
	protected function loadSettingsObjects() {
		//first check TS settings for vote object
		( $this->settings['vote'] ) && $this->vote = $this->voteRepository->findByUid($this->settings['vote']);

		if ($this->voteValidator->isValid($this->vote)) {
			$this->voter = $this->vote->getVoter();
			$this->rating = $this->vote->getRating();
			$this->ratingobject = $this->rating->getRatingobject();
		} else {
			//try to find a rating and the correspondig ratingobject
			if ( isset($this->settings['rating']) && !$this->rating instanceof Tx_ThRating_Domain_Model_Rating ) {
				$this->rating = $this->ratingRepository->findByUid($this->settings['rating']);
			}
			if ( $this->rating instanceof Tx_ThRating_Domain_Model_Rating ) {
				$this->ratingobject = $this->rating->getRatingobject();
			}

			//if no ratingobject is configured use default
			while ( !$this->ratingobject instanceof Tx_ThRating_Domain_Model_Ratingobject ) {
				//check whether a dedicated ratingobject is configured
				if ( $this->settings['ratingobject'] ) {
					$this->ratingobject = $this->ratingobjectRepository->findByUid($this->settings['ratingobject']);
				}
				//if no rating is found then ratingobject is also empty
				if ( !(!$this->ratingobject instanceof Tx_ThRating_Domain_Model_Ratingobject && $this->settings['ratetable']  && $this->settings['ratefield'] )) {

					//last chance: fetch ratingobject for given table and fieldname / add object if not found
					if ( !$this->ratingobject instanceof Tx_ThRating_Domain_Model_Ratingobject ) {
						$this->ratingobject = $this->ratingobjectRepository->findMatchingTableAndField(	$this->settings['ratetable'], $this->settings['ratefield'], Tx_ThRating_Domain_Repository_RatingobjectRepository::addIfNotFound);
					}
				} else {
					$this->settings = array_merge($this->settings,$this->settings['defaultObject']);
				}
			}
			
			//get rating of given row
			if ( $this->ratingobject instanceof Tx_ThRating_Domain_Model_Ratingobject && $this->settings['ratedobjectuid'] ) {
				$this->rating = $this->ratingRepository->findMatchingObjectAndUid($this->ratingobject,$this->settings['ratedobjectuid'],Tx_ThRating_Domain_Repository_RatingRepository::addIfNotFound);
			}

			//get voter from settings
			if (!$this->voter instanceof Tx_Extbase_Domain_Model_FrontendUser) {
				$this->voter = $this->accessControllService->getFrontendUser($this->settings['voter']); 
			}

			if (!$this->voter instanceof Tx_Extbase_Domain_Model_FrontendUser) {
				If ( !empty($this->settings['showNoFEUser']) ) {
					$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.noFEuser', 'ThRating', t3lib_FlashMessage::ERROR)); 
				}
			}

			if ($this->rating instanceof Tx_ThRating_Domain_Model_Rating && ($this->voter instanceof Tx_Extbase_Domain_Model_FrontendUser) && 
					($this->voter->getUid() != $this->settings['mapAnonymous']) ) {
				$this->vote = $this->voteRepository->findMatchingRatingAndVoter($this->rating->getUid(),$this->voter->getUid());
				if ($this->voteValidator->isValid($this->vote)) {
					$this->hasRated = true;
				}
			}
			if (!$this->voteValidator->isValid($this->vote) || $this->vote->isAnonymous()) {
				$this->vote = $this->objectManager->create('Tx_ThRating_Domain_Model_Vote');
				if ($this->rating instanceof Tx_ThRating_Domain_Model_Rating) {
					$this->vote->setRating($this->rating);
				}
				if ($this->voter instanceof Tx_Extbase_Domain_Model_FrontendUser) {
					$this->vote->setVoter($this->voter);
				}
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
		$frameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

		$storagePids = explode(',',$frameworkConfiguration['persistence']['storagePid']);
		sort($storagePids);
		if (empty($storagePids[0])) {
			$storagePids[0] = $siteRoot;	//change storagePid to SITEROOT page
			$frameworkConfiguration['persistence']['storagePid'] = implode(',',$storagePids);
		}
		
		//t3lib_utility_Debug::debug($frameworkConfiguration,'Debug');
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
	 * @return void
	 */
	public function renderCSS() {
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
			$stepcount = $ratingobject->getStepconfs()->count();
			$stepconfs = $ratingobject->getStepconfs()->toArray();
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
					$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.renderCSS.defaultImage', 'ThRating', t3lib_FlashMessage::ERROR));
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
}
?>