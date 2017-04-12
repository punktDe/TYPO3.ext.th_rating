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
 * Model for rating votes  
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Vote extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var 		\Thucke\ThRating\Domain\Model\Rating
	 * @validate 	\Thucke\ThRating\Domain\Validator\RatingValidator
	 * @validate 	NotEmpty
	 */
	protected $rating;
	
	/**
	 * The voter of this object
	 *
	 * @var 	\Thucke\ThRating\Domain\Model\Voter
	 * @validate NotEmpty
	 */
	protected $voter;
	
	/**
	 * The actual voting of this object
	 *
	 * @var 		\Thucke\ThRating\Domain\Model\Stepconf
	 * @validate	\Thucke\ThRating\Domain\Validator\StepconfValidator
	 * @validate 	NotEmpty
	 */
	protected $vote;

	/**
	 * @var array
	 */
	protected $settings;

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
	 * Constructs a new rating object
	 *
	 * @return void
	 */
	public function __construct( 
					\Thucke\ThRating\Domain\Model\Rating			$rating = NULL,
					\Thucke\ThRating\Domain\Model\Voter			$voter = NULL, 
					\Thucke\ThRating\Domain\Model\Stepconf		$vote  = NULL ) {
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
		if ( empty($this->objectManager) ) {
			$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		}
		$this->settings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager')->getConfiguration('Settings', 'thRating', 'pi1');
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this,get_class($this).' initializeObject');
	 }
	 

	/**
	 * Sets the rating this vote is part of
	 *
	 * @param \Thucke\ThRating\Domain\Model\Rating $rating The Rating
	 * @return void
	 */
	public function setRating(\Thucke\ThRating\Domain\Model\Rating $rating) {
		$this->rating = $rating;
		$this->setPid($rating->getPid());
	}

	/**
	 * Returns the rating this vote is part of
	 *
	 * @return \Thucke\ThRating\Domain\Model\Rating The rating this vote is part of
	 */
	public function getRating() {
		return $this->rating;
	}

	/**
	 * Sets the frontenduser of this vote 
	 *
	 * @param \Thucke\ThRating\Domain\Model\Voter	$voter	The frontenduser
	 * @return void
	 */
	public function setVoter(\Thucke\ThRating\Domain\Model\Voter $voter) {
		$this->voter = $voter;
	}

	/**
	 * Returns the frontenduser of this vote
	 *
	 * @return \Thucke\ThRating\Domain\Model\Voter	The frontenduser of this vote
	 */
	public function getVoter() {
		return $this->voter;
	}
	
	
	/**
	 * Sets the choosen stepconfig
	 * 
	 * @param \Thucke\ThRating\Domain\Model\Stepconf $vote
	 * @return void
	 */
	public function setVote($vote) {
		$this->vote = $vote;
	}
	
	/**
	 * Gets the rating object uid
	 * 
	 * @return \Thucke\ThRating\Domain\Model\Stepconf Reference to selected stepconfig
	 */
	public function getVote() {
		return $this->vote;
	}

	/**
	 * Sets the rating this vote is part of
	 *
	 * @return boolean
	 */
	public function hasRated() {
		return (get_class($this->getVote()) == 'Thucke\ThRating\Domain\Model\Stepconf');
	}

	/**
	 * Checks if vote is done by anonymous user
	 * 
	 * @return boolean
	 */
	public function isAnonymous() {
		if ( $this->getVoter() instanceof \Thucke\ThRating\Domain\Model\Voter ) {
			$retVal = $this->getVoter()->getUid() == $this->settings['mapAnonymous'] && !empty($this->settings['mapAnonymous']);
		} else {
			$retVal = false;
		}
		return $retVal;
	}	

	/**
	 * Checks cookie if anonymous vote is already done
	 * always false if cookie checks is deactivated
	 * 
	 * @param String $prefixId Extension prefix to identify cookie
	 * @return 	booelan
	 */
	public function hasAnonymousVote($prefixId = 'DummyPrefix') {
		$anonymousRating = json_decode($_COOKIE[$prefixId.'_AnonymousRating_'.$this->getRating()->getUid()], true);
		$retVal = !empty($anonymousRating['voteUid']);
		return $retVal;
	}	

	/**
	 * Method to use Object as plain string
	 * 
	 * @return string
	 */
	public function __toString() {
		return strval($this->getVote());
	}	
}
?>