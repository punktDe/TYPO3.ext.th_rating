<?php
namespace Thucke\ThRating\Domain\Repository;
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
 * A repository for rating objects
 */
class RatingobjectRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {			

	/**
	 * Defines name for function parameter
	 *
	 */
	const addIfNotFound = TRUE;

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
	 * Finds the specific ratingobject by giving table and fieldname
	 *
	 * @param string 	$ratetable The tablename of the ratingobject
	 * @param string 	$ratefield The fieldname of the ratingobject
	 * @param bool 	$addIfNotFound Set to true if new objects should instantly be added
	 * @return \Thucke\ThRating\Domain\Model\Ratingobject The ratingobject
	 */
	public function findMatchingTableAndField($ratetable, $ratefield, $addIfNotFound = FALSE ) {
		$query = $this->createQuery();
		$query	->matching(
						$query->logicalAnd(
							$query->equals('ratetable', $ratetable),
							$query->equals('ratefield', $ratefield)
							)
						)
					->setLimit(1);

		$queryResult = $query->execute();
		if (count($queryResult) != 0) {
			$foundRow = $queryResult->getFirst();
		} else {
			if ($addIfNotFound) {
				$foundRow = $this->objectManager->get('Thucke\\ThRating\\Domain\\Model\\Ratingobject');
				$foundRow->setRatetable($ratetable);
				$foundRow->setRatefield($ratefield);
				$validator = $this->objectManager->get('Thucke\\ThRating\\Domain\\Validator\\RatingobjectValidator');
				if ($validator->isValid($foundRow)) {
					$this->add($foundRow);
				}
				$this->objectFactoryService->persistRepository('Thucke\\ThRating\\Domain\\Repository\\RatingobjectRepository', $foundRow);
			} else {
				unset($foundRow);
			}
		}
		return $foundRow;
	}

	/**
	 * Finds the specific ratingobject by giving table and fieldname
	 *
	 * @param bool 	$respectStoragePage Set to true if storagepage should be ignored
	 * @return \Thucke\ThRating\Domain\Model\Ratingobject All ratingobjects of the site
	 */
	public function findAll($respectStoragePage = FALSE ) {
		$query = $this->createQuery();
		if ($respectStoragePage) {
			$query->getQuerySettings()->setRespectStoragePage(FALSE);
		}
		return $query->execute();
	}
}
?>