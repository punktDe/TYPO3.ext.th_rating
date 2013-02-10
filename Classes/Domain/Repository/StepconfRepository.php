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
 * A repository for ratingstep configurations
 */
class Tx_ThRating_Domain_Repository_StepconfRepository extends Tx_Extbase_Persistence_Repository {			
	protected $defaultOrderings = array(
         'steporder' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING
	);

	/**
	 * Initialze this repository
	 */
	public function initializeObject() {
		$configurationManager = $this->objectManager->get('Tx_Extbase_Configuration_ConfigurationManager');
		$settings = $configurationManager->getConfiguration('Settings', 'thRating', 'pi1');
	}

	
	/**
	 * Finds the specific ratingobject by giving table and fieldname
	 *
	 * @param int 	$ratingobjectUid The tablename of the ratingobject
	 * @return Tx_ThRating_Domain_Model_Stepconf	All related stepconfs in correct localization
	 */
	public function findLocalizedByRatingobject($ratingobjectUid) {
		$query = $this->createQuery();
		$tableName = strtolower($query->getType());
		$statement = 'SELECT * FROM '.$tableName.' WHERE ratingobject=? AND ';
		$statement .= '(sys_language_uid IN (-1,0) AND uid not in (SELECT l18n_parent FROM '.$tableName.' WHERE ratingobject=? AND sys_language_uid=?)'; //default language if noch localized record exists
		$statement .= ' OR sys_language_uid=?)'; //or localized record itself
		$query->statement($statement, array($ratingobjectUid,$ratingobjectUid,$GLOBALS['TSFE']->sys_language_uid,$GLOBALS['TSFE']->sys_language_uid));
		return $query->execute();
	}

}
?>