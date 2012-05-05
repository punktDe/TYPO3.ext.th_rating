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
 * A repository for votes
 */
class Tx_ThRating_Domain_Repository_VoteRepository extends Tx_Extbase_Persistence_Repository {			

	/**
	 * Defines name for function parameter
	 *
	 */
	const addIfNotFound = true;

	/**
	 * Finds the voting by giving the rating and voter objects 
	 *
	 * @param 	Tx_ThRating_Domain_Model_Rating	$rating The concerned ratingobject
	 * @param 	Tx_ThRating_Domain_Model_Voter	$voter 	The Uid of the rated row
	 * @return 	Tx_ThRating_Domain_Model_Vote 			The voting
	 */
	public function findMatchingRatingAndVoter($rating = NULL, $voter = NULL ) {
		$query = $this->createQuery();
		return $query
			->matching(
				$query->logicalAnd(
					$query->equals('rating', $rating),
					$query->equals('voter', $voter)
					)
				)
			->execute()
			->getFirst();
	}

	/**
	 * Counts all votings by giving the rating and ratingstep 
	 *
	 * @param 	Tx_ThRating_Domain_Model_Rating 	$rating 	The concerned ratingobject
	 * @param 	Tx_ThRating_Domain_Model_Stepconf	$stepconf 	The stepconf object
	 * @return 	Int
	 */
	public function countByMatchingRatingAndVote($rating = NULL, $stepconf = NULL ) {
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				$query->equals('rating', $rating->getUid()),
				$query->equals('vote', $stepconf->getUid())
			)
		);
		return $query->execute()->count();
	}
	
	/**
	 * Counts all anonymous votings by giving the rating and ratingstep 
	 *
	 * @param 	Tx_ThRating_Domain_Model_Rating 	$rating 		The concerned ratingobject
	 * @param 	Tx_ThRating_Domain_Model_Stepconf	$stepconf 		The stepconf object
	 * @param 	Int 								$anonymousVoter	UID of the anonymous account
	 * @return 	Int
	 */
	public function countAnonymousByMatchingRatingAndVote($rating = NULL, $stepconf = NULL, $anonymousVoter = NULL ) {
		if ( !empty($anonymousVoter) ) {
			$query = $this->createQuery();
			$query->matching(
				$query->logicalAnd(
					$query->equals('rating', $rating->getUid()),
					$query->equals('vote', $stepconf->getUid()),
					$query->equals('voter', $anonymousVoter)
				)
			);
			return $query->execute()->count();
		}
		return 0;
	}

}

?>