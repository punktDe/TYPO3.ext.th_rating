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
 * Aggregate object for rating of content objects 
 *
 * @version 	$Id:$
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Tx_ThRating_Domain_Model_Ratingobject extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Table name of the cObj
	 * Defaults to Typo3 tablename of pages
	 *
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 60)
	 */
	protected $ratetable;
	
	/**
	 * Fieldname within the table of the cObj
	 * Defaults to the field 'uid'
	 *
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 60)
	 */
	protected $ratefield;
	
	/**
	 * The ratings of this object
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Stepconf>
	 * @lazy
	 * @cascade remove
	 */
	protected $stepconfs;

	/**
	 * The ratings of this object
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Rating>
	 * @lazy
	 * @cascade remove
	 */
	protected $ratings;
	
	/**
	 * Constructs a new rating object
	 * @param string $ratetable The rating objects table name
	 * @validate 	  $ratetable StringLength(minimum = 3, maximum = 60)
	 * @param string $ratefield The rating objects field name
	 * @validate 	  $ratefield StringLength(minimum = 3, maximum = 60)
	 * @return void
	 */
	public function __construct($ratetable = NULL, $ratefield = NULL) {
		$this->stepconfs = new Tx_Extbase_Persistence_ObjectStorage();
		$this->ratings = new Tx_Extbase_Persistence_ObjectStorage();
		if ($ratetable) $this->setRatetable($ratetable);
		if ($ratefield) $this->setRatefield($ratefield);
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
	 * @param Tx_ThRating_Domain_Model_Rating $rating
	 * @return void
	 */
	public function addRating(Tx_ThRating_Domain_Model_Rating $rating) {
		$this->ratings->attach($rating);
	}

	/**
	 * Remove a raiting from this object
	 *
	 * @param Tx_ThRating_Domain_Model_Rating $rating The rating to be removed
	 * @return void
	 */
	public function removeRating(Tx_ThRating_Domain_Model_Rating $rating) {
		$this->ratings->detach($rating);
	}

	/**
	 * Remove all raitings from this object
	 *
	 * @return void
	 */
	public function removeAllRatings() {
		$this->ratings = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Sets all ratings of this ratingobject
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Stepconf> $stepconfs The step configurations for this ratingobject
	 * @return void
	 */
	public function setStepconfs(Tx_Extbase_Persistence_ObjectStorage $stepconfs) {
		$this->stepconfs = $stepconfs;
	}
		
	/**
	 * Returns all ratings in this object
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Stepconf>
	 */
	public function getStepconfs() {
		return clone $this->stepconfs;
	}	
	
	/**
	 * Sets all ratings of this ratingobject
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Rating> $ratings The ratings of the organization
	 * @return void
	 */
	public function setRatings(Tx_Extbase_Persistence_ObjectStorage $ratings) {
		$this->ratings = $ratings;
	}
		
	/**
	 * Returns all ratings in this object
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Rating>
	 */
	public function getRatings() {
		return clone $this->ratings;
	}		
}
?>