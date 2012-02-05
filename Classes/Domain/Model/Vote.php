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
 * Model for rating votes  
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Tx_ThRating_Domain_Model_Vote extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var Tx_ThRating_Domain_Model_Rating
	 * @validate Tx_ThRating_Domain_Validator_RatingValidator
	 * @lazy
	 */
	protected $rating;
	
	/**
	 * The voter of this object
	 *
	 * @var Tx_Extbase_Domain_Model_FrontendUser
	 * @lazy
	 */
	protected $voter;
	
	/**
	 * The actual voting of this object
	 *
	 * @var Tx_ThRating_Domain_Model_Stepconf
	 * @lazy
	 */
	protected $vote;

	/**
	 * Constructs a new rating object
	 *
	 * @return void
	 */
	public function __construct( 
					Tx_ThRating_Domain_Model_Rating			$rating = NULL,
					Tx_Extbase_Domain_Model_FrontendUser 	$voter = NULL, 
					Tx_ThRating_Domain_Model_Stepconf		$vote  = NULL ) {
		If ($rating)  $this->setRating($rating);
		If ($voter)   $this->setVoter($voter);
		If ($vote)    $this->setVote($vote);
	}
	
	
	/**
	 * Sets the rating this vote is part of
	 *
	 * @param Tx_ThRating_Domain_Model_Rating $rating The Rating
	 * @return void
	 */
	public function setRating(Tx_ThRating_Domain_Model_Rating $rating) {
		$this->rating = $rating;
		$this->setPid($rating->getPid());
	}

	/**
	 * Returns the rating this vote is part of
	 *
	 * @return Tx_ThRating_Domain_Model_Rating The rating this vote is part of
	 */
	public function getRating() {
		if ($this->rating instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->rating = $this->rating->_loadRealInstance();
		}
		return $this->rating;
	}

	/**
	 * Sets the frontenduser of this vote 
	 *
	 * @param Tx_Extbase_Domain_Model_FrontendUser $voter An object storage containing the frontenduser
	 * @return void
	 */
	public function setVoter(Tx_Extbase_Domain_Model_FrontendUser $voter) {
		$this->voter = $voter;
	}

	/**
	 * Returns the frontenduser of this vote
	 *
	 * @return Tx_Extbase_Domain_Model_FrontendUser	The frontenduser of this vote
	 */
	public function getVoter() {
		if ($this->voter instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->voter = $this->voter->_loadRealInstance();
		}
		return $this->voter;
	}
	
	
	/**
	 * Sets the choosen stepconfig
	 * 
	 * @param Tx_ThRating_Domain_Model_Stepconf $vote
	 * @return void
	 */
	public function setVote($vote) {
		$this->vote = $vote;
	}
	
	/**
	 * Gets the rating object uid
	 * 
	 * @return Tx_ThRating_Domain_Model_Stepconf Reference to selected stepconfig
	 */
	public function getVote() {
		if ($this->vote instanceof Tx_Extbase_Persistence_LazyLoadingProxy) {
			$this->vote = $this->vote->_loadRealInstance();
		}
		return $this->vote;
	}
	/**
	 * Method to use Object as plain string
	 * 
	 * @return string
	 */
	public function __toString() {
		return (strval($this->vote));
	}	
}
?>