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
 * A repository for ratingstep configurations
 */
class StepconfRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	protected $defaultOrderings = array(
         'steporder' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
	);

	/**
	 * Initialze this repository
	 */
	public function initializeObject() {
		//disable RespectStoragePage as pid is always bound to parent objects pid
		$defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$defaultQuerySettings->setRespectStoragePage(false);
		$this->setDefaultQuerySettings($defaultQuerySettings);
		
		$configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$settings = $configurationManager->getConfiguration('Settings', 'thRating', 'pi1');
	}

	/**
	 * Finds the given stepconf object in the repository
	 *
	 * @param 	\Thucke\ThRating\Domain\Model\Stepconf	$stepconf 	The ratingobject to look for
	 * @return	\Thucke\ThRating\Domain\Model\Stepconf
	 */
	public function findStepconfObject(\Thucke\ThRating\Domain\Model\Stepconf $stepconf) {
		$query = $this->createQuery();
		$query	->matching(
						$query->logicalAnd(
							$query->equals('ratingobject', $stepconf->getRatingobject()->getUid()),
							$query->equals('steporder', $stepconf->getSteporder())
						)
					)
				->setLimit(1);
		$queryResult = $query->execute();
		if (count($queryResult) != 0) {
			$foundRow = $queryResult->getFirst();
		} else {
			unset($foundRow);
		}
		return $foundRow;
	}

	/**
	 * Finds the ratingstep entry by giving ratingobjectUid
	 *
	 * @param 	\Thucke\ThRating\Domain\Model\Stepconf	$stepconf 	The uid of the ratingobject
	 * @return	bool												true if stepconf object exists in repository
	 */
	public function existStepconf(\Thucke\ThRating\Domain\Model\Stepconf $stepconf) {
		$lookForStepconf = $this->findStepconfObject($stepconf);
		if ( $lookForStepconf instanceof \Thucke\ThRating\Domain\Model\Stepconf ) {
			return true;
		} 
		return false;
	}
}
?>