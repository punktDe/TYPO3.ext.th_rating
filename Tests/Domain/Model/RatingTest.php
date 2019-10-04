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
 * Testcases for Ratingobject
 *
 * @version 	$Id:$
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		alpha
 * @entity
 */
class RatingTest extends \TYPO3\CMS\Core\Tests\BaseTestCase
{
    /**
     * @var string Put the extension name here
     */
    protected $extensionName = 'th_rating';

    /**
     * @var \Thucke\ThRating\Domain\Model\Rating
     */
    protected $fixture = null;

    public function setUp()
    {
        $this->ratingobject = \TYPO3\CMS\Core\Tests\BaseTestCase::getMock('Thucke\\ThRating\\Domain\\Model\\Ratingobject', [], ['tt_news', 'uid']);
        $this->stepconf = \TYPO3\CMS\Core\Tests\BaseTestCase::getMock('Thucke\\ThRating\\Domain\\Model\\Stepconf', [], [$this->ratingobject, 1]);
        $this->stepconf->setStepweight(2);
        $mockStepconfRepository = \TYPO3\CMS\Core\Tests\BaseTestCase::getMock('Thucke\\ThRating\\Domain\\Repository\\StepconfRepository', [], [], '', false);
        $this->ratingobject->injectStepconfRepository($mockStepconfRepository);
        $this->ratingobject->addStepconf($this->stepconf);
        $this->fixture = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Rating', $this->ratingobject, 1);
        $mockVoteRepository = \TYPO3\CMS\Core\Tests\BaseTestCase::getMock('Thucke\\ThRating\\Domain\\Repository\\VoteRepository', [], [], '', false);
        $this->fixture->injectVoteRepository($mockVoteRepository);
    }

    public function tearDown()
    {
        unset($this->ratingobject, $this->stepconf);
    }

    /**
     * Checks construction of a new rating object
     * @test
     */
    public function anInstanceOfTheRatingCanBeConstructed()
    {
        $this->assertEquals($this->ratingobject, $this->fixture->getRatingobject());
        $this->assertEquals(1, $this->fixture->getRatedobjectuid());
    }

    /**
     * Applies the validator
     * @test
     */
    public function theValidatorCheckIsGood()
    {
        $validator = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Validator\\RatingValidator');
        $this->assertTrue($validator->isValid($this->fixture));
    }

    /**
     * Checks the initialisation of a new ratingobject having no ratings
     * @test
     */
    public function theVotesAreInitializedAsEmptyObjectStorage()
    {
        $this->assertEquals('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', get_class($this->fixture->getVotes()));
        $this->assertEquals(0, count($this->fixture->getVotes()));
    }

    /**
     * Checks adding a new rating to the object
     * @test
     */
    public function aVoteCanBeAdded()
    {
        $vote = $this->getMock('Thucke\\ThRating\\Domain\\Model\\Vote', [], [], '', false);
        //$vote = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Vote');
        $vote->setVote(3);
        $this->fixture->addVote($vote);
        $this->assertTrue($this->fixture->getVotes()->contains($vote));
    }
}
