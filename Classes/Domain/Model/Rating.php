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
	 * @var array
	 */
	protected $settings;
	
	/**
	 * Constructs a new rating object
	 * @return void
	 */
	public function __construct( Tx_ThRating_Domain_Model_Ratingobject $ratingobject = NULL, $ratedobjectuid=NULL ) {
		if ($ratingobject) $this->setRatingobject( $ratingobject );
		if ($ratedobjectuid) $this->setRatedobjectuid( $ratedobjectuid );
		$this->initializeObject();
	}


	/**
	 * Initializes a new rating object
	 * @return void
	 */
	 public function initializeObject() {
		parent::initializeObject();
		$this->settings = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_Extbase_Configuration_ConfigurationManager')->getConfiguration('Settings', 'thRating', 'pi1');

		//Initialize vote storage if rating is new
		if (!is_object($this->votes)) {
			$this->votes=Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_Extbase_Persistence_ObjectStorage');
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
		$this->addCurrentrate($vote);
		Tx_ThRating_Utility_ExtensionManagementUtility::persistRepository('Tx_ThRating_Domain_Repository_VoteRepository', $vote);
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
	 * @return	Tx_Extbase_Persistence_ObjectStorage<Tx_ThRating_Domain_Model_Vote>
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
		$voteRepository = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_ThRating_Domain_Repository_VoteRepository');
		foreach ( $this->getRatingobject()->getStepconfs() as $stepConf ) {
			$stepOrder = $stepConf->getSteporder();
			$voteCount = $voteRepository->countByMatchingRatingAndVote($this, $stepConf);
			$anonymousCount = $voteRepository->countAnonymousByMatchingRatingAndVote($this, $stepConf, $this->settings['mapAnonymous']);
			$currentratesDecoded['weightedVotes'][$stepOrder] = $voteCount * $stepConf->getStepweight();
			$currentratesDecoded['sumWeightedVotes'][$stepOrder] = $currentratesDecoded['weightedVotes'][$stepOrder] * $stepOrder;
			$numAllVotes += $voteCount;
			$numAllAnonymousVotes += $anonymousCount;
		}
		$currentratesDecoded['numAllVotes'] = $numAllVotes;
		$currentratesDecoded['anonymousVotes'] = $numAllAnonymousVotes;
		$this->currentrates = json_encode($currentratesDecoded);
	}


	/**
	 * Adds a vote to the calculations of this rating
	 *
	 * @param Tx_ThRating_Domain_Model_Vote $voteToRemove The vote to be removed
	 * @return void
	 */
	public function addCurrentrate(Tx_ThRating_Domain_Model_Vote $voting) {
		if ( empty($this->currentrates) ) {
			$this->checkCurrentrates(); //initialize entry
		}
		$currentratesDecoded = json_decode($this->currentrates, TRUE);
		$currentratesDecoded['numAllVotes']++;
		if ( $voting->isAnonymous() ) {
			$currentratesDecoded['anonymousVotes']++;
		}
		$votingStep = $voting->getVote();
		$votingSteporder = $votingStep->getSteporder(); 
		$votingStepweight = $votingStep->getStepweight(); 
		$currentratesDecoded['weightedVotes'][$votingSteporder] += $votingStepweight;
		$currentratesDecoded['sumWeightedVotes'][$votingSteporder] += $votingStepweight * $votingSteporder;
		$this->currentrates = json_encode($currentratesDecoded);
	}

	/**
	 * Returns the calculated rating
	 *
	 * @return array
	 */
	public function getCurrentrates() {
		$currentratesDecoded = json_decode($this->currentrates, TRUE);
		if (empty($currentratesDecoded['numAllVotes'])) {
			$this->checkCurrentrates();
			$currentratesDecoded = json_decode($this->currentrates, TRUE);
		}
		$weightedVotes = $currentratesDecoded['weightedVotes'];
		$sumWeightedVotes = $currentratesDecoded['sumWeightedVotes'];
		$numAllVotes = $currentratesDecoded['numAllVotes'];
		$numAnonymousVotes = $currentratesDecoded['anonymousVotes'];
		if (!empty($numAllVotes)) {
			$currentrate = array_sum ( $sumWeightedVotes ) / $numAllVotes;
		} else {
			$currentrate = 0;
		}
		return array ('currentrate' => $currentrate, 'weightedVotes' => $weightedVotes, 'sumWeightedVotes' => $sumWeightedVotes, 'anonymousVotes' => $numAnonymousVotes);
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