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
class Tx_ThRating_Domain_Repository_VoterRepository extends Tx_Extbase_Domain_Repository_FrontendUserRepository {		
	
	/**
	 * Initialze this repository
	 */
	public function initializeObject() {
		$configurationManager = $this->objectManager->get('Tx_Extbase_Configuration_ConfigurationManager');
		$settings = $configurationManager->getConfiguration('Settings', 'thRating', 'pi1');
		//Even hidden or deleted FE Users  should be found
		$this->defaultQuerySettings = Tx_ThRating_Service_ObjectFactoryService::createObject( 'Tx_Extbase_Persistence_Typo3QuerySettings' );
		If ( t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) >= 6000000 ) {
			$this->defaultQuerySettings->setIgnoreEnableFields(TRUE);
		} else {
			$this->defaultQuerySettings->setRespectEnableFields(FALSE);
		}
	}
}

?>