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

		if ( $this->request->hasArgument('ajaxRef') ) {
			//read unique AJAX identification on AJAX request
			$this->ajaxSelections['ajaxRef'] = $this->request->getArgument('ajaxRef'); 
		} else { 
			//set unique AJAX identification
			$this->ajaxSelections['ajaxRef'] = $this->prefixId.'_'.$this->getRandomId(); 
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
		$this->renderCSS();
	}


	/**
	 * Displays the vote of the current user
	 *
	 * @param 	Tx_ThRating_Domain_Model_Vote	$vote
	 * @return 	string 							The rendered voting
	 */
	public function showAction(	Tx_ThRating_Domain_Model_Vote	$vote = NULL ) {
		//is_object($vote) && t3lib_utility_Debug::debug($vote->getUid(),'showAction');
		//Tx_ExtDebug::var_dump($vote->getVoter());
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
				$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.create.noPermission', 'ThRating', t3lib_FlashMessage::ERROR));
			}
		} else {
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
			if ( !$vote->isAnonymous() ) {
				$matchVote = $this->voteRepository->findMatchingRatingAndVoter($vote->getRating(),$vote->getVoter());
			}
			//add new or anonymous vote
			if ( !$this->voteValidator->isValid($matchVote) || $vote->isAnonymous() ) {
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
	 * @param Tx_ThRating_Domain_Model_Vote 		$vote The new vote (used on callback from createAction)
	 * @return string The rendered view
	 * @dontvalidate $vote
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
	 * @dontvalidate $vote
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
			if ( !$this->vote->hasRated() || (!$this->accessControllService->isLoggedIn($this->vote->getVoter()) && $this->vote->isAnonymous()) ) {
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
	 * @param Tx_ThRating_Domain_Model_Vote 			$vote 	the vote this selection is for
	 * @dontvalidate $vote
	 * @return void
	 */
	protected function initVoting(	Tx_ThRating_Domain_Model_Vote 			$vote = null ) {
		if ( $this->voteValidator->isValid($vote) ) {
			$this->vote = $vote;
		} else {
			//first initialize parent objects for vote object
			$ratingobject = Tx_ThRating_Service_ObjectFactoryService::getRatingobject( $this->settings );
			$rating = Tx_ThRating_Service_ObjectFactoryService::getRating( $this->settings, $ratingobject );
			$this->vote = Tx_ThRating_Service_ObjectFactoryService::getVote( $this->settings, $rating );

			if (!$this->vote->getVoter() instanceof Tx_ThRating_Domain_Model_Voter) {
				If ( !empty($this->settings['showNoFEUser']) ) {
					$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('error.vote.noFEuser', 'ThRating', t3lib_FlashMessage::ERROR)); 
				}
			}
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
			$this->view->assign('ajaxRef', $this->ajaxSelections['ajaxRef']);
			$this->view->assign('ratingobject', $this->vote->getRating()->getRatingobject());
			$this->view->assign('rating', $this->vote->getRating());
			$this->view->assign('voter', $this->vote->getVoter());

			$currentrate = $this->vote->getRating()->getCurrentrates();
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