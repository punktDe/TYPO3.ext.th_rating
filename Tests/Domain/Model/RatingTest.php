<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Tests\Domain\Model;

use Nimut\TestingFramework\TestCase\UnitTestCase;
use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Model\Vote;
use Thucke\ThRating\Domain\Repository\StepconfRepository;
use Thucke\ThRating\Domain\Repository\VoteRepository;
use Thucke\ThRating\Domain\Validator\RatingValidator;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		alpha
 * @entity
 */
class RatingTest extends UnitTestCase
{
    /**
     * @var string Put the extension name here
     */
    protected $extensionName = 'th_rating';

    /**
     * @var \Thucke\ThRating\Domain\Model\Rating
     */
    protected $fixture;
    /**
     * @var \Thucke\ThRating\Domain\Model\Ratingobject
     */
    protected $ratingobject;
    /**
     * @var \Thucke\ThRating\Domain\Model\Stepconf
     */
    private $stepconf;

    public function setUp()
    {
        $this->ratingobject = $this->getMockBuilder(Ratingobject::class)
            ->setConstructorArgs(['tt_news', 'uid'])
            ->getMock();
        $this->stepconf = $this->getMockBuilder(Stepconf::class)
            ->setConstructorArgs([$this->ratingobject, 1])
            ->getMock();
        $this->stepconf->setStepweight(2);
        $mockStepconfRepository = $this->getMockBuilder(StepconfRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->ratingobject->injectStepconfRepository($mockStepconfRepository);
        $this->ratingobject->addStepconf($this->stepconf);
        $this->fixture = new Rating($this->ratingobject, 1);
        $mockVoteRepository = $this->getMockBuilder(VoteRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
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
        static::assertEquals($this->ratingobject, $this->fixture->getRatingobject());
        static::assertEquals(1, $this->fixture->getRatedobjectuid());
    }

    /**
     * Applies the validator
     * @test
     */
    public function theValidatorCheckIsGood()
    {
        $validator = new RatingValidator();
        static::assertTrue($validator->validate($this->fixture));
    }

    /**
     * Checks the initialisation of a new ratingobject having no ratings
     * @test
     */
    public function theVotesAreInitializedAsEmptyObjectStorage()
    {
        static::assertInstanceOf(ObjectStorage::class, $this->fixture->getVotes());
        static::assertCount(0, $this->fixture->getVotes());
    }

    /**
     * Checks adding a new rating to the object
     * @test
     */
    public function aVoteCanBeAdded()
    {
        $vote = (Vote::class)($this->getMockBuilder(Vote::class)
            ->disableOriginalConstructor()
            ->getMock());
        //$vote = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Thucke\\ThRating\\Domain\\Model\\Vote');
        $vote->setVote(3);
        $this->fixture->addVote($vote);
        static::assertTrue($this->fixture->getVotes()->contains($vote));
    }
}
