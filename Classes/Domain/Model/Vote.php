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
	 * @var 		Tx_ThRating_Domain_Model_Rating
	 * @validate 	Tx_ThRating_Domain_Validator_RatingValidator
	 * lazy
	 */
	protected $rating;
	
	/**
	 * The voter of this object
	 *
	 * @var 	Tx_ThRating_Domain_Model_Voter
	 * validate Tx_ThRating_Domain_Validator_VoterValidator
	 * @lazy
	 */
	protected $voter;
	
	/**
	 * The actual voting of this object
	 *
	 * @var 		Tx_ThRating_Domain_Model_Stepconf
	 * @validate	Tx_ThRating_Domain_Validator_StepconfValidator
	 * lazy
	 */
	protected $vote;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Constructs a new rating object
	 *
	 * @return void
	 */
	public function __construct( 
					Tx_ThRating_Domain_Model_Rating			$rating = NULL,
					Tx_ThRating_Domain_Model_Voter			$voter = NULL, 
					Tx_ThRating_Domain_Model_Stepconf		$vote  = NULL ) {
		If ($rating)  $this->setRating($rating);
		If ($voter)   $this->setVoter($voter);
		If ($vote)    $this->setVote($vote);
		$this->initializeObject();
	}
	
	
	/**
	 * Initializes the new vote object
	 * @return void
	 */
	 public function initializeObject() {
		parent::initializeObject();
		$configurationManager = t3lib_div::makeInstance( 'Tx_Extbase_Configuration_ConfigurationManager');
		$this->settings = $configurationManager->getConfiguration('Settings', 'thRating', 'pi1');
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
	 * @param Tx_ThRating_Domain_Model_Voter	$voter	The frontenduser
	 * @return void
	 */
	public function setVoter(Tx_ThRating_Domain_Model_Voter $voter) {
		$this->voter = $voter;
	}

	/**
	 * Returns the frontenduser of this vote
	 *
	 * @return Tx_ThRating_Domain_Model_Voter	The frontenduser of this vote
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
	 * Sets the rating this vote is part of
	 *
	 * @return boolean
	 */
	public function hasRated() {
		return (get_class($this->getVote()) == 'Tx_ThRating_Domain_Model_Stepconf');
	}

	/**
	 * Checks if vote is done by anonymous user
	 * 
	 * @return booelan
	 */
	public function isAnonymous() {
		if ( $this->getVoter() instanceof Tx_ThRating_Domain_Model_Voter ) {
			$retVal = $this->getVoter()->getUid() == $this->settings['mapAnonymous'] && !empty($this->settings['mapAnonymous']);
		} else {
			$retVal = FALSE;
		}
		return $retVal;
	}	

	/**
	 * Checks cookie if anonymous vote is already done
	 * always FALSE if cookie checks is deactivated
	 * 
	 * @param	string	$prefixId	Extension prefix to identify cookie
	 * @return 	booelan
	 */
	public function hasAnonymousVote($prefixId) {
		$anonymousRating = json_decode($_COOKIE[$prefixId.'_AnonymousRating_'.$this->getRating()->getUid()], TRUE);
		$retVal = !empty($anonymousRating['voteUid']);
		return $retVal;
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