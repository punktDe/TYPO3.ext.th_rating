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
 * Model for ratingstep configuration  
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Stepconf extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	
	/**
	 * @var \Thucke\ThRating\Domain\Model\Ratingobject
	 * @validate \Thucke\ThRating\Domain\Validator\RatingobjectValidator
	 * @validate NotEmpty
	 */
	protected $ratingobject;
	
	/**
	 * The order of this config entry
	 *
	 * @var int discrete order of ratingsteps
	 * @validate NumberRange(minimum = 1)
	 * @validate NotEmpty
	 */
	protected $steporder;
	
	/**
	 * The weight of this config entry
	 *
	 * @var float  default is 1 which is equal weight
	 * @validate NumberRange(minimum = 1)
	 */
	protected $stepweight;
	

	/**
	 * The value of this config entry
	 *
	 * @var \Thucke\ThRating\Domain\Model\Stepname
	 * @validate \Thucke\ThRating\Domain\Validator\StepnameValidator
	 * @lazy
	 * @cascade remove
	 */
	protected $stepname;
	

	/**
	 * The ratings of this object
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Vote>
	 * @lazy
	 * @cascade remove
	 */
	protected $votes;

	
	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface	$objectManager
	 */
	protected $objectManager;
	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface	$objectManager
	 * @return void
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @var \Thucke\ThRating\Domain\Repository\StepnameRepository	$stepnameRepository
	 */
	protected $stepnameRepository;
	/**
	 * @param \Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository
	 * @return void
	 */
	public function injectStepnameRepository(\Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository) {
		$this->stepnameRepository = $stepnameRepository;
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
	 * Constructs a new stepconfig object
	 * @return void
	 */
	public function __construct( \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject = NULL, $steporder=NULL ) {
		if ($ratingobject) $this->setRatingobject( $ratingobject );
		if ($steporder) $this->setSteporder( $steporder );
		$this->initializeObject();
}
	
	/**
	 * Initializes a new stepconf object
	 * @return void
	 */
	public function initializeObject() {
		//Initialize vote storage if rating is new
		if (!is_object($this->votes)) {
			$this->votes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		}
	}
	
	
	/**
	 * Sets the ratingobject this rating is part of
	 *
	 * @param \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject The Rating
	 * @return void
	 */
	public function setRatingobject(\Thucke\ThRating\Domain\Model\Ratingobject $ratingobject) {
		$this->ratingobject = $ratingobject;
		$this->setPid($ratingobject->getPid());
	}

	/**
	 * Returns the ratingobject this rating is part of
	 *
	 * @return \Thucke\ThRating\Domain\Model\Ratingobject The ratingobject this rating is part of
	 */
	public function getRatingobject() {
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
	 * @param \Thucke\ThRating\Domain\Model\Stepname $stepname
	 * @return boolean
	 */
	public function addStepname(\Thucke\ThRating\Domain\Model\Stepname $stepname) {
		$success = true;
		$stepname->setStepconf($this);
		If (!$this->stepnameRepository->existStepname($stepname)) {
			$defaultLanguageObject = $this->stepnameRepository->findDefaultStepname($stepname);
			if ( is_object($defaultLanguageObject) ) {
				//handle localization if an entry for the default language exists
				$stepname->setL18nParent($defaultLanguageObject->getUid());
			} else {
				$stepname->setL18nParent(NULL);
				$this->stepname = $stepname;
			
			}
			$this->stepnameRepository->add($stepname);
			$this->objectFactoryService->persistRepository('Thucke\ThRating\Domain\Repository\StepnameRepository', $stepname);
			$this->objectFactoryService->persistRepository('Thucke\ThRating\Domain\Repository\StepconfRepository', $this);
		} else {
			//warning - existing stepname entry for a language will not be overwritten
			$success = false;
		}
		return $success;
	}

	/**
	 * Returns the localized stepname object of this stepconf
	 * 
	 * @return \Thucke\ThRating\Domain\Model\Stepname
	 */
	public function getStepname() {
		if ( $this->stepname instanceOf \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy ) {
			$stepname = $this->stepname->_loadRealInstance();
		}
		return $this->stepname;
	}
	
	/**
	 * Returns all votes in this rating
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Vote>
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
		$stepname = $this->getStepname();
		if ( $stepname ) {
		} else {
			$stepname = $this->getSteporder();
		}
		return strval($stepname);
	}	
}
?>