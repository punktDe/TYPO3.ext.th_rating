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
 * A repository for ratings
 */
class Tx_ThRating_Domain_Repository_RatingRepository extends Tx_Extbase_Persistence_Repository {			

	/**
	 * Defines name for function parameter
	 *
	 */
	const addIfNotFound = true;

	/**
	 * Finds the specific rating by giving the object and row uid
	 *
	 * @param	Tx_ThRating_Domain_Model_Ratingobject	$ratingobject 	The concerned ratingobject
	 * @param	int 									$ratedobjectuid The Uid of the rated row
	 * @param	bool									$addIfNotFound	Set to true if new objects should instantly be added
	 * @validate	$ratingobject Tx_ThRating_Domain_Validator_RatingobjectValidator
	 * @validate	$ratedobjectuid NumberRange(startRange = 1)
	 * @return Tx_ThRating_Domain_Model_Rating 		The rating
	 */
	public function findMatchingObjectAndUid($ratingobject, $ratedobjectuid, $addIfNotFound = false ) {
		$query = $this->createQuery();
		$query	->matching(
						$query->logicalAnd(
							$query->equals('ratingobject', $ratingobject->getUid()),
							$query->equals('ratedobjectuid', $ratedobjectuid)
							)
						)
					->setLimit(1);

		$foundRow = $this->objectManager->create('Tx_ThRating_Domain_Model_Rating');
		$queryResult = $query->execute();
		if ($queryResult->count() != 0) {
			$foundRow = $queryResult->getFirst();
		} else {
			if ($addIfNotFound) {
				$foundRow->setRatingobject($ratingobject);
				$foundRow->setRatedobjectuid($ratedobjectuid);	
				$validator = $this->objectManager->create('Tx_ThRating_Domain_Validator_RatingValidator');
				$validator->isValid($foundRow) && $this->add($foundRow);
				Tx_Extbase_Dispatcher::getPersistenceManager()->persistAll();
			} else {
				unset($foundRow);
			}
		}
		return $foundRow;
	}
}
?>