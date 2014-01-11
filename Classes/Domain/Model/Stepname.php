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
 * Model for ratingstep configuration names
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Tx_ThRating_Domain_Model_Stepname extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var Tx_ThRating_Domain_Model_Stepconf	The Stepconf this name belongs to
	 * @validate Tx_ThRating_Domain_Validator_StepconfValidator
	 * @lazy
	 */
	protected $stepconf;
	
	/**
	 * The name of this config entry
	 *
	 * @var string Name or description to display
	 */
	protected $stepname;
	
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
	public function __construct( Tx_ThRating_Domain_Model_Stepconf $stepconf = NULL, $stepname=NULL ) {
		if ($stepconf) $this->setStepconf( $stepconf );
		if ($stepname) $this->setStepname( $stepname );
		$this->initializeObject();
}
	
	/**
	 * Initializes a new stepconf object
	 * @return void
	 */
	 public function initializeObject() {
		parent::initializeObject();
	 }
	
	
	/**
	 * Sets the stepconf this rating is part of
	 *
	 * @param Tx_ThRating_Domain_Model_Stepconf $stepconf The Rating
	 * @return void
	 */
	public function setStepconf(Tx_ThRating_Domain_Model_Stepconf $stepconf) {
		$this->stepconf = $stepconf;
		$this->setPid($stepconf->getPid());
	}

	/**
	 * Returns the stepconf this rating is part of
	 *
	 * @return	Tx_ThRating_Domain_Model_Stepconf The stepconf this rating is part of
	 */
	public function getStepconf() {
		if ($this->stepconf instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->stepconf = $this->stepconf->_loadRealInstance();
		}
		return $this->stepconf;
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
	 * Method to use Object as plain string
	 * 
	 * @return string
	 */
	public function __toString() {
		return ($this->getStepname());
	}	
}
?>