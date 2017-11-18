<?php
namespace Thucke\ThRating\Tests\Domain\Model;
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
 * Testcases for Votes 
 *
 * @version 	$Id:$
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		alpha
 * @entity
 */
class VoteTest extends \TYPO3\CMS\Core\Tests\BaseTestCase {

	/**
	 * Checks construction of a new vote object
	 * @test
	 */
	public function anInstanceOfTheVoteCanBeConstructed() {
		$ratingobject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Ratingobject', 'tt_news', 'uid');
		$rating = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Ratingobject', $ratingobject, 3);
		$step = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Stepconf', $ratingobject, 1);
		//$feU = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
		//$voter = $feUsers->findByUid(1);
		//$vote = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Vote',$rating,$voter,$step);
		//$this->assertEquals($rating,$vote->getRating());
		//$this->assertEquals($voter,$vote->getVoter());
		//$this->assertEquals(1,$vote->getVote());
	}
		
}
?>