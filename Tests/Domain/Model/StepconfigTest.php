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
class StepconfigTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var string Put the extension name here
	 */
	protected $extensionName = 'th_rating';
 
 
    public function setUp() {
        //$this->ratingobject = $this->getMock('Tx_ThRating_Domain_Model_Ratingobject');
		$this->ratingobject = Tx_Extbase_Tests_Unit_BaseTestCase::getAccessibleMock('Tx_ThRating_Domain_Model_Ratingobject', array(), array('tt_news', 'uid'));
        $this->stepconf = $this->objectManager->get('Tx_ThRating_Domain_Model_Stepconf');
		$this->stepconf->setRatingobject($this->ratingobject);
		$this->stepconf->setSteporder(1);
		$this->stepconf->setStepweight(2);
		$this->stepname = Tx_Extbase_Tests_Unit_BaseTestCase::getAccessibleMock('Tx_ThRating_Domain_Model_Stepname', array(), array($this->stepconf, 'Step1'));
		$mockRepository = Tx_Extbase_Tests_Unit_BaseTestCase::getAccessibleMock('Tx_ThRating_Domain_Repository_StepnameRepository');
		$this->stepconf->injectStepnameRepository($mockRepository);
    }

    public function tearDown() {
        unset($this->ratingobject, $this->stepconf);
    }

	/**
	 * Checks construction of a new rating object
	 * @test
	 */
	public function anInstanceOfTheStepconfigurationHasBeenConstructed() {
		$this->assertInstanceOf('Tx_ThRating_Domain_Model_Stepconf', $this->stepconf);
		$this->assertSame($this->ratingobject, $this->stepconf->getRatingobject());
		$this->assertEquals(1,$this->stepconf->getSteporder());
		$this->assertEquals(2,$this->stepconf->getStepweight());
		$this->assertEquals('1',$this->stepconf->getStepname());
	}

	/**
	 * Checks __toString gives steporder
	 * @test
	 */
	public function toStringReturnsSteporder() {
		$this->assertEquals($this->stepconf, $this->stepconf->getStepname());
		
	}

	/**
	 * Checks __toString gives current stepname
	 * @test
	 */
	public function aStepameCouldBeAdded() {
		$this->stepconf->addStepname($this->stepname);
		$this->markTestIncomplete(
          'This test has not been implemented yet. - '.$this->stepconf->getStepname()
        );
		$this->assertEquals('Step1', $this->stepconf->getStepname());	
	}
	
}
?>