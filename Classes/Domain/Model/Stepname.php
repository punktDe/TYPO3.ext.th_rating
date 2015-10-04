<?php
namespace Thucke\ThRating\Domain\Model;
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
class Stepname extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var \Thucke\ThRating\Domain\Model\Stepconf
	 * @validate \Thucke\ThRating\Domain\Validator\StepconfValidator
	 * @validate NotEmpty
	 */
	protected $stepconf;
	
	/**
	 * The name of this config entry
	 *
	 * @var string Name or description to display
	 */
	protected $stepname;
	
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
	public function __construct( \Thucke\ThRating\Domain\Model\Stepconf $stepconf = NULL, $stepname=NULL ) {
		if ($stepconf) $this->setStepconf( $stepconf );
		if ($stepname) $this->setStepname( $stepname );
		$this->initializeObject();
	}
	
	/**
	 * Initializes a new stepconf object
	 * @return void
	 */
	public function initializeObject() {
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this,get_class($this).' initializeObject');
	}
	
	
	/**
	 * Sets the stepconf this rating is part of
	 *
	 * @param \Thucke\ThRating\Domain\Model\Stepconf $stepconf The Rating
	 * @return void
	 */
	public function setStepconf(\Thucke\ThRating\Domain\Model\Stepconf $stepconf) {
		$this->stepconf = $stepconf;
		$this->setPid($stepconf->getPid());
	}

	/**
	 * Returns the stepconf this rating is part of
	 *
	 * @return	\Thucke\ThRating\Domain\Model\Stepconf The stepconf this rating is part of
	 */
	public function getStepconf() {
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
			$value = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($value, 'ThRating');
		}
		if ( empty($value) ) {
			$value = strval($this->getStepconf()->getSteporder());
		}
		return $value;
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