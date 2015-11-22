<?php
namespace Thucke\ThRating\Service;
/***************************************************************
*  Copyright notice
*
*  (c) 2013 Thomas Hucke <thucke@web.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General protected License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General protected License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General protected License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * An access control service
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU protected License, version 2
 */
class AccessControlService extends \Thucke\ThRating\Service\AbstractExtensionService {

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository	$frontendUserRepository
	 */
	protected $frontendUserRepository;
	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $frontendUserRepository
	 * @return void
	 */
	public function injectFrontendUserRepository(\TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $frontendUserRepository) {
		$this->frontendUserRepository = $frontendUserRepository;
	}
	/**
	 * @var \Thucke\ThRating\Domain\Repository\VoterRepository	$voterRepository
	 */
	protected $voterRepository;
	/**
	 * @param \Thucke\ThRating\Domain\Repository\VoterRepository $voterRepository
	 * @return void
	 */
	public function injectVoterRepository(\Thucke\ThRating\Domain\Repository\VoterRepository $voterRepository) {
		$this->voterRepository = $voterRepository;
	}

	/**
	 * Tests, if the given person is logged into the frontend
	 *
	 * @param	\TYPO3\CMS\Extbase\Domain\Model\FrontendUser	$person	The person 
	 * @return	bool 											The result; TRUE if the given person is logged in; otherwise FALSE
	 */
	public function isLoggedIn(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $person = NULL) {
		if ($person instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage) {
			$person->current();
		}
		if (is_object($person)) {
			if ( 	 $person->getUid() &&
					($person->getUid() === $this->getFrontendUserUid()) ) {
				return TRUE;	//treat anonymous user also as logged in
			}
		}
		return FALSE;
	}	
		
	public function backendAdminIsLoggedIn() {
		return $GLOBALS['TSFE']->beUserLogin === 1 ? TRUE : FALSE;
	}
	
	public function hasLoggedInFrontendUser() {
		return !empty($GLOBALS['TSFE']->loginUser);
	}
	
	public function getFrontendUserGroups() {
		if($this->hasLoggedInFrontendUser()) {
			return $GLOBALS['TSFE']->fe_user->groupData['uid'];
		}
		return array();
	}
	
	public function getFrontendUserUid() {
		if($this->hasLoggedInFrontendUser() && !empty($GLOBALS['TSFE']->fe_user->user['uid'])) {
			return intval($GLOBALS['TSFE']->fe_user->user['uid']);
		}
		return NULL;
	}

	/**
	 * Loads objects from repositories
	 *
	 * @param mixed $voter 
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser 
	 */
	public function getFrontendUser($voter = NULL) {
		//set userobject
		if (!$voter instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
			//TODO Errorhandling if no user is logged in
			if (!is_integer(intval($voter)) || intval($voter) == 0) {
				//get logged in fe-user
				$voter = $this->frontendUserRepository->findByUid($this->getFrontendUserUid());
			} else {
				$voter = $this->frontendUserRepository->findByUid(intval($voter));
			}
		}
		return $voter;
	}			

	/**
	 * Loads objects from repositories
	 *
	 * @param mixed $voter 
	 * @return \Thucke\ThRating\Domain\Model\Voter 
	 */
	public function getFrontendVoter($voter = NULL) {
		//set userobject
		if (!$voter instanceof \Thucke\ThRating\Domain\Model\Voter) {
			//TODO Errorhandling if no user is logged in
			if (!is_integer(intval($voter)) || intval($voter) == 0) {
				//get logged in fe-user
				$voter = $this->voterRepository->findByUid($this->getFrontendUserUid());
			} else {
				$voter = $this->voterRepository->findByUid(intval($voter));
			}
		}
		return $voter;
		}			
}
?>