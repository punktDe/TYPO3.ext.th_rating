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
 * Model for object rating  
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 		http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Tx_ThRating_Domain_Model_Rating extends Tx_Extbase_DomainObject_AbstractEntity {

	//TODO check deleted referenced records
	
	/**
	 * @var Tx_ThRating_Domain_Model_Ratingobject	The ratingobject this rating belongs to
	 * @validate Tx_ThRating_Domain_Validator_RatingobjectValidator
	 * @lazy
	 */
	protected $ratingobject;
	
	/**
	 * The ratings of this object
	 *
	 * @var int holding uid of the rated row
	 * @validate NumberRange(startRange = 1)
	 */
	protected $ratedobjectuid;
	
	/**
	 * The ratings of this object
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Vote>
	 * @lazy
	 * @cascade remove
	 */
	protected $votes;

	/**
	 * The current calculated rates
	 *
	 * Redundant information to enhance performance in displaying calculated informations
	 * This is a JSON encoded string with the following keys
	 *	- votecounts(1...n)	vote counts of the specific ratingstep
	 * It be updated everytime a vote is created, changed or deleted.
	 * Specific handling must be defined when ratingsteps are added or removed or stepweights are changed
	 * Caclution of ratings:
	 *	currentrate = (  sum of all ( stepweight(n) * votecounts(n) ) ) / number of all votes
	 *	currentwidth = round (currentrate * 100 / number of ratingsteps  )
	 *
	 * @var string	JSON encoded rating summary
	 * @lazy
	 */
	protected $currentrates;
	
	
	/**
	 * Constructs a new rating object
	 * @return void
	 */
	public function __construct( Tx_ThRating_Domain_Model_Ratingobject $ratingobject = NULL, $ratedobjectuid=NULL ) {
		$this->votes = new Tx_Extbase_Persistence_ObjectStorage();
		if ($ratingobject) $this->setRatingobject( $ratingobject );
		if ($ratedobjectuid) $this->setRatedobjectuid( $ratedobjectuid );
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
	 * Sets the rating object uid
	 * 
	 * @param int $ratedobjectuid
	 * @return void
	 */
	public function setRatedobjectuid($ratedobjectuid) {
		$this->ratedobjectuid = $ratedobjectuid;
	}
	
	/**
	 * Gets the rating object uid
	 * 
	 * @return int Rating object row uid field value
	 */
	public function getRatedobjectuid() {
		return $this->ratedobjectuid;
	}

	/**
	 * Adds a vote to this rating
	 *
	 * @param Tx_ThRating_Domain_Model_Vote $vote
	 * @return void
	 */
	public function addVote(Tx_ThRating_Domain_Model_Vote $vote) {
		$this->votes->attach($vote);
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$persistenceManager->persistAll();
		$this->addCurrentrate($vote);
	}

	/**
	 * Remove a vote from this rating
	 *
	 * @param Tx_ThRating_Domain_Model_Vote $voteToRemove The vote to be removed
	 * @return void
	 */
	public function removeVote(Tx_ThRating_Domain_Model_Vote $voteToRemove) {
		$this->votes->detach($voteToRemove);
	}

	/**
	 * Remove all votes from this rating
	 *
	 * @return void
	 */
	public function removeAllVotes() {
		$this->votes = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns all votes in this rating
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage
	 */
	public function getVotes() {
		return clone $this->votes;
	}

	/**
	 * Checks all votes of this rating and sets currentrates accordingly
	 *
	 * This method is used for maintenance to assure consistency
	 * @return void
	 */
	public function checkCurrentrates() {
		$voteRepository = t3lib_div::makeInstance('Tx_ThRating_Domain_Repository_VoteRepository');
		foreach ( $this->getRatingobject()->getStepconfs() as $stepConf ) {
			$stepOrder = $stepConf->getSteporder();
			$voteCount = $voteRepository->countByMatchingRatingAndVote($this, $stepConf);
			$currentratesDecoded['weightedVotes'][$stepOrder] = $voteCount * $stepConf->getStepweight();
			$currentratesDecoded['sumWeightedVotes'][$stepOrder] = $currentratesDecoded['weightedVotes'][$stepOrder] * $stepOrder;
			$numAllVotes += $voteCount;
		}
		$currentratesDecoded['numAllVotes'] = $numAllVotes;
		$this->currentrates = json_encode($currentratesDecoded);
	}

	/**
	 * Adds a vote to the calculations of this rating
	 *
	 * @param Tx_ThRating_Domain_Model_Vote $voteToRemove The vote to be removed
	 * @return void
	 */
	public function addCurrentrate(Tx_ThRating_Domain_Model_Vote $voting) {
		//TODO check deactivation for production use
		//$this->checkCurrentrates(); //check for possible inconsistencies
		$currentratesDecoded = $this->currentrates ? json_decode($this->currentrates, true) : '';
		$currentratesDecoded['numAllVotes']++;
		$votingStep = $voting->getVote();
		$votingSteporder = $votingStep->getSteporder(); 
		$votingStepwheight = $votingStep->getStepweight(); 
		$currentratesDecoded['weightedVotes'][$votingSteporder] += $votingStepwheight;
		$currentratesDecoded['sumWeightedVotes'][$votingSteporder] += $votingStepwheight * $votingSteporder;
		$this->currentrates = json_encode($currentratesDecoded);
	}

	/**
	 * Returns the calculated rating
	 *
	 * @return array
	 */
	public function getCurrentrates() {
		$currentratesDecoded = json_decode($this->currentrates, true);
		if (empty($currentratesDecoded['numAllVotes'])) {
			$this->checkCurrentrates();
			$currentratesDecoded = json_decode($this->currentrates, true);
		}
		$weightedVotes = $currentratesDecoded['weightedVotes'];
		$sumWeightedVotes = $currentratesDecoded['sumWeightedVotes'];
		$numAllVotes = $currentratesDecoded['numAllVotes'];
		if (!empty($numAllVotes)) {
			$currentrate = array_sum ( $sumWeightedVotes ) / $numAllVotes;
		} else {
			$currentrate = 0;
		}
		return array ('currentrate' => $currentrate, 'weightedVotes' => $weightedVotes, 'sumWeightedVotes' => $sumWeightedVotes);
	}

	/**
	 * Returns the calculated rating in percent
	 *
	 * @return string
	 */
	public function getCalculatedRate() {
		$currentrate = $this->getCurrentrates();
		if (!empty($currentrate['weightedVotes'])) {
			$calculatedRate = round ( ($currentrate['currentrate']  * 100) / count($currentrate['weightedVotes']) );
		} else {
			$calculatedRate = 0;
		}
		return $calculatedRate;
	}

}

?>