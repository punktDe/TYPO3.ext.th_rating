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
 * Aggregate object for rating of content objects 
 *
 * @version 	$Id:$
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Ratingobject extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Table name of the cObj
	 * Defaults to Typo3 tablename of pages
	 *
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 60)
	 * @validate NotEmpty
	 */
	protected $ratetable;
	
	/**
	 * Fieldname within the table of the cObj
	 * Defaults to the field 'uid'
	 *
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 60)
	 * @validate NotEmpty
	 */
	protected $ratefield;
	
	/**
	 * The stepconfs of this object
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf>
	 * @lazy
	 * @cascade remove
	 */
	protected $stepconfs;

	/**
	 * The ratings of this object
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Rating>
	 * @lazy
	 * @cascade remove
	 */
	protected $ratings;
	
	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
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
	 * @var \Thucke\ThRating\Domain\Repository\StepconfRepository
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
	 * @var \Thucke\ThRating\Service\ObjectFactoryService
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
	 * Constructs a new rating object
	 * @param	string	$ratetable The rating objects table name
	 * @param	string	$ratefield The rating objects field name
	 * @validate 	$ratetable StringLength(minimum = 3, maximum = 60)
	 * @validate	$ratefield StringLength(minimum = 3, maximum = 60)
	 * @return 	void
	 */
	public function __construct($ratetable = NULL, $ratefield = NULL) {
		if ($ratetable) $this->setRatetable($ratetable);
		if ($ratefield) $this->setRatefield($ratefield);
		$this->initializeObject();
}
	
	/**
	 * Initializes a new ratingobject
	 * @return void
	 */
	public function initializeObject() {

		//Initialize rating storage if ratingobject is new
		if (!is_object($this->ratings)) {
			$this->ratings = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		}
		//Initialize stepconf storage if ratingobject is new
		if (!is_object($this->stepconfs)) {
			$this->stepconfs = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		}
	}

	/**
	 * Sets the rating table name
	 * 
	 * @param string $ratetable
	 * @return void
	 */
	public function setRatetable($ratetable) {
		$this->ratetable = $ratetable;
	}
	
	/**
	 * Gets the rating table name
	 * 
	 * @return string Rating object table name
	 */
	public function getRatetable() {
		return $this->ratetable;
	}

	/**
	 * Sets the rating field name
	 * 
	 * @param string $ratefield
	 * @return void
	 */
	public function setRatefield($ratefield) {
		$this->ratefield = $ratefield;
	}

	/**
	 * Sets the rating field name
	 * 
	 * @return string Rating object field name
	 */
	public function getRatefield() {
		return $this->ratefield;
	}

	/**
	 * Adds a raiting to this object
	 *
	 * @param \Thucke\ThRating\Domain\Model\Rating $rating
	 * @return void
	 */
	public function addRating(\Thucke\ThRating\Domain\Model\Rating $rating) {
		$this->ratings->attach($rating);
		$this->objectFactoryService->persistRepository('Thucke\ThRating\Domain\Repository\RatingRepository', $rating);
	}

	/**
	 * Remove a raiting from this object
	 *
	 * @param \Thucke\ThRating\Domain\Model\Rating $rating The rating to be removed
	 * @return void
	 */
	public function removeRating(\Thucke\ThRating\Domain\Model\Rating $rating) {
		$this->ratings->detach($rating);
	}

	/**
	 * Remove all raitings from this object
	 *
	 * @return void
	 */
	public function removeAllRatings() {
		$this->ratings = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a stepconf to this object
	 *
	 * @param \Thucke\ThRating\Domain\Model\Stepconf $stepconf
	 * @return void
	 */
	public function addStepconf(\Thucke\ThRating\Domain\Model\Stepconf $stepconf) {
		If (!$this->stepconfRepository->existStepconf($stepconf)) {
			$this->stepconfs->attach( $stepconf );
			$this->objectFactoryService->persistRepository('Thucke\ThRating\Domain\Repository\StepconfRepository', $stepconf);
		}
	}

	/**
	 * Sets all ratings of this ratingobject
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf> $stepconfs The step configurations for this ratingobject
	 * @return void
	 */
	public function setStepconfs(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $stepconfs) {
		$this->stepconfs = $stepconfs;
	}
		
	/**
	 * Returns all ratings in this object
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf>
	 */
	public function getStepconfs() {
		return clone $this->stepconfs;
	}	
	
	/**
	 * Sets all ratings of this ratingobject
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Rating> $ratings The ratings of the organization
	 * @return void
	 */
	public function setRatings(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $ratings) {
		$this->ratings = $ratings;
	}
		
	/**
	 * Returns all ratings in this object
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Rating>
	 */
	public function getRatings() {
		return clone $this->ratings;
	}		
}
?>