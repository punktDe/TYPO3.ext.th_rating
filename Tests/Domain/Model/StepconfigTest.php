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
 * Testcases for Ratingobject 
 *
 * @version 	$Id:$
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		alpha
 * @entity
 */
class StepconfigTest extends Tx_Extbase_BaseTestCase {

	/**
	 * Checks construction of a new rating object
	 * @test
	 */
	public function anInstanceOfTheStepconfigurationCanBeConstructed() {
		$ratingobject = t3lib_div::makeInstance('Tx_ThRating_Domain_Model_Ratingobject','tt_news','uid');
		$stepconf = t3lib_div::makeInstance('Tx_ThRating_Domain_Model_Stepconf',$ratingobject,1);
		$this->assertEquals($ratingobject,$stepconf->getRatingobject());
		$this->assertEquals(1,$stepconf->getSteporder());
	}
		
}
?>