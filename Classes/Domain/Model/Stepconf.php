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

	//TODO Extend model with calculated ratings (number of votes, calculated rating)
	
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
	 * @var string Name or description to display
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
	 * Localization entry
	 * workaround to help avoiding bug in Typo 4.7 handling localized objects
	 *
	 * @var int 
	 */
	protected $l18nParent;

	/**
	 * _languageUid
	 * @var int
	 * @validate NotEmpty
	 */
	protected $_languageUid;
 

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
		// get an ObjectManager first
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		// get persistence manager
		$this->votes = $objectManager->get('Tx_Extbase_Persistence_ObjectStorage');
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
	 * Sets the stepconfig name
	 * 
	 * @param string $stepname
	 * @return void
	 */
	public function setStepname($stepname) {
		$this->stepname = $stepname;
	}
	
	/**
	 * Gets the stepconfig name
	 * If not set stepweight is copied
	 * 
	 * @return string Stepconfig name
	 */
	public function getStepname() {
		$value = $this->stepname;
		if ( strtoupper(substr($value, 0, 4)) == 'LLL:' ) {
			$value = 'stepnames.'.substr($value, 4);
			$value = Tx_Extbase_Utility_Localization::translate($value, 'ThRating');
		}
		if ( empty($value) ) {
			$value = strval($this->steporder);
		}
		return $value;
	}
	
	/**
	 * @param int $l18n_parent
	 * @return void
	 */
	public function setUid($uid) {
		$this->uid = $uid;
	}

	/**
	 * @return int
	 */
	public function getL18nParent() {
		return $this->l18nParent;
	}
	/**
	 * @param int $l18n_parent
	 * @return void
	 */
	public function setL18nParent($l18nParent) {
		$this->l18nParent = $l18nParent;
	}

	/**
	 * @param int $_languageUid
	 * @return void
	 */	
	public function set_languageUid($_languageUid) {
		$this->_languageUid = $_languageUid;
	}
 
	/**
	 * @return int
	 */
	public function get_languageUid() {
		return $this->_languageUid;
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