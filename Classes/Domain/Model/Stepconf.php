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
 * Model for ratingstep configuration  
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Tx_ThRating_Domain_Model_Stepconf extends Tx_Extbase_DomainObject_AbstractEntity {

	
	/**
	 * @var Tx_ThRating_Domain_Model_Ratingobject	The ratingobject this rating belongs to
	 * @validate Tx_ThRating_Domain_Validator_RatingobjectValidator
	 * @lazy
	 */
	protected $ratingobject;
	
	/**
	 * The order of this config entry
	 *
	 * @var int discrete order of ratingsteps
	 * @validate NumberRange(startRange = 1)
	 */
	protected $steporder;
	
	/**
	 * The weight of this config entry
	 *
	 * @var float  default is 1 which is eaqul weight
	 * @validate NumberRange(startRange = 0)
	 */
	protected $stepweight;
	

	/**
	 * The value of this config entry
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Stepname>
	 * @validate Tx_ThRating_Domain_Validator_StepnameValidator
	 * @lazy
	 * @cascade remove
	 */
	protected $stepname;
	

	/**
	 * The ratings of this object
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Vote>
	 * @validate Tx_ThRating_Domain_Validator_VoteValidator
	 * @lazy
	 * @cascade remove
	 */
	protected $votes;

	
	/**
	 * Uid set by extbase
	 * Used to replace existing entries
	 *
	 * @var int 
	 */
	protected $uid;


	/**
	 * @var Tx_ThRating_Domain_Repository_StepnameRepository	$stepnameRepository
	 */
	protected $stepnameRepository;
	/**
	 * @param Tx_ThRating_Domain_Repository_StepnameRepository $stepnameRepository
	 * @return void
	 */
	public function injectStepnameRepository(Tx_ThRating_Domain_Repository_StepnameRepository $stepnameRepository) {
		$this->stepnameRepository = $stepnameRepository;
	}

	/**
	 * Constructs a new stepconfig object
	 * @return void
	 */
	public function __construct( Tx_ThRating_Domain_Model_Ratingobject $ratingobject = NULL, $steporder=NULL ) {
		if ($ratingobject) $this->setRatingobject( $ratingobject );
		if ($steporder) $this->setSteporder( $steporder );
		$this->initializeObject();
}
	
	/**
	 * Initializes a new stepconf object
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();

		//Initialize stepname storage if stepconf is new
		if (!is_object($this->stepname)) {
			$this->stepname=Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_Extbase_Persistence_ObjectStorage');
		}
		//Initialize vote storage if rating is new
		if (!is_object($this->votes)) {
			$this->votes=Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_Extbase_Persistence_ObjectStorage');
		}
		//Initialize repository if injection did not occur on newly generated stepconf object
		if (!$this->stepnameRepository instanceOf Tx_ThRating_Domain_Repository_StepnameRepository) {
			$this->stepnameRepository = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_ThRating_Domain_Repository_StepnameRepository');
		}
	}
	
	
	/**
	 * Sets the ratingobject this rating is part of
	 *
	 * @param Tx_ThRating_Domain_Model_Ratingobject $ratingobject The Rating
	 * @return void
	 */
	public function setRatingobject(Tx_ThRating_Domain_Model_Ratingobject $ratingobject) {
		$this->ratingobject = $ratingobject;
		$this->setPid($ratingobject->getPid());
	}

	/**
	 * Returns the ratingobject this rating is part of
	 *
	 * @return	Tx_ThRating_Domain_Model_Ratingobject The ratingobject this rating is part of
	 */
	public function getRatingobject() {
		if ($this->ratingobject instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->ratingobject = $this->ratingobject->_loadRealInstance();
		}
		return $this->ratingobject;
	}

	/**
	 * Sets the stepconfig order
	 * 
	 * @param int $steporder
	 * @return void
	 */
	public function setSteporder($steporder) {
		$this->steporder = $steporder;
	}
	
	/**
	 * Gets the stepconfig order
	 * 
	 * @return int stepconfig position
	 */
	public function getSteporder() {
		return $this->steporder;
	}

	/**
	 * Sets the stepconfig value
	 * 
	 * @param int $stepweight
	 * @return void
	 */
	public function setStepweight($stepweight) {
		$this->stepweight = $stepweight;
	}
	
	/**
	 * Gets the stepconfig value
	 * If not set steporder is copied
	 * 
	 * @return int Stepconfig value
	 */
	public function getStepweight() {
		empty($this->stepweight) && $this->stepweight = $this->steporder;
		return $this->stepweight;
	}


	/**
	 * Adds a localized stepname to this stepconf
	 *
	 * @param Tx_ThRating_Domain_Model_Stepname $stepname
	 * @return void
	 */
	public function addStepname(Tx_ThRating_Domain_Model_Stepname $stepname) {
		$stepname->setStepconf($this);
		If (!$this->stepnameRepository->existStepname($stepname)) {
			$defaultLanguageObject = $this->stepnameRepository->findDefaultStepname($stepname);
			if ( is_object($defaultLanguageObject) ) {
				//handle localization if an entry for the default language exists
				$stepname->setL18nParent($defaultLanguageObject->getUid());
			}
			$this->stepname->attach($stepname);
			Tx_ThRating_Utility_ExtensionManagementUtility::persistRepository('Tx_ThRating_Domain_Repository_StepnameRepository', $stepname);
			Tx_ThRating_Utility_ExtensionManagementUtility::persistRepository('Tx_ThRating_Domain_Repository_StepconfRepository', $this);
		}
	}

	/**
	 * Returns the localized stepname of this stepconf
	 * 
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Stepname>
	 */
	public function getStepname() {
		if ( $this->stepname->count() == 0 ) {
			$stepname = strval($this->getSteporder());
		} else {
			$stepname = clone $this->stepname;
		}
		return $stepname;
	}
	
	/**
	 * @param int $l18n_parent
	 * @return void
	 */
	public function setUid($uid) {
		$this->uid = $uid;
	}

	/**
	 * Returns all votes in this rating
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Vote>
	 */
	public function getVotes() {
		return clone $this->votes;
	}

	/**
	 * Method to use Object as plain string
	 * 
	 * @return string
	 */
	public function __toString() {
		return ($this->getStepname());
	}	
}
?>