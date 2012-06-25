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
 * A repository for rating objects
 */
class Tx_ThRating_Domain_Repository_RatingobjectRepository extends Tx_Extbase_Persistence_Repository {			

	/**
	 * Defines name for function parameter
	 *
	 */
	const addIfNotFound = true;

	/**
	 * @var Tx_Extbase_Persistence_Manager
	 */
	protected $persistenceManager;

	/**
	 * Initialze this repository
	 */
	public function initializeObject() {
		$this->persistenceManager = $this->objectManager->get('Tx_Extbase_Persistence_Manager');
		/*
		$configurationManager = $this->objectManager->get('Tx_Extbase_Configuration_ConfigurationManager');
		$settings = $configurationManager->getConfiguration('Settings', 'thRating', 'pi1');
		$this->defaultQuerySettings = $this->objectManager->create('Tx_Extbase_Persistence_Typo3QuerySettings');
		$this->defaultQuerySettings->setStoragePageIds(split($settings['respectStoragePage'],','));
		$this->defaultQuerySettings->setRespectStoragePage(True);*/
	}
	
	/**
	 * Finds the specific ratingobject by giving table and fieldname
	 *
	 * @param string 	$ratetable The tablename of the ratingobject
	 * @param string 	$ratefield The fieldname of the ratingobject
	 * @param bool 	$addIfNotFound Set to true if new objects should instantly be added
	 * @return Tx_ThRating_Domain_Model_Ratingobject The ratingobject
	 */
	public function findMatchingTableAndField($ratetable, $ratefield, $addIfNotFound = false ) {
		$query = $this->createQuery();
		$query	->matching(
						$query->logicalAnd(
							$query->equals('ratetable', $ratetable),
							$query->equals('ratefield', $ratefield)
							)
						)
					->setLimit(1);

		$foundRow = $this->objectManager->create('Tx_ThRating_Domain_Model_Ratingobject');
		$queryResult = $query->execute();
		if ($queryResult->count() != 0) {
			$foundRow = $queryResult->getFirst();
		} else {
			if ($addIfNotFound) {
				$foundRow->setRatetable($ratetable);
				$foundRow->setRatefield($ratefield);
				$validator = $this->objectManager->create('Tx_ThRating_Domain_Validator_RatingobjectValidator');
				$validator->isValid($foundRow) && $this->add($foundRow);
				$this->persistenceManager->persistAll();
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
	 * @return Tx_ThRating_Domain_Model_Ratingobject All ratingobjects of the site
	 */
	public function findAll($respectStoragePage = false ) {
		$query = $this->createQuery();
		if ($respectStoragePage) {
			$query->getQuerySettings()->setRespectStoragePage(FALSE);
		}
		return $query->execute();;
	}
}
?>