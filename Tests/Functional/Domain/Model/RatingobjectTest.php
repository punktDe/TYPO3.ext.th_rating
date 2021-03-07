<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Tests\Functional\Domain\Model;

use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\Ratingobject;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Testcases for Ratingobject
 *
 * @version 	$Id:$
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		alpha
 * @entity
 */
class RatingobjectTest extends FunctionalTestCase
{
    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];
    protected $coreExtensionsToLoad = ['extbase', 'fluid'];

    /**
     * @var Ratingobject
     */
    protected $ratingobjectDomainModelInstance;

    public function setUp(): void
    {
        parent::setUp();

        $this->ratingobjectDomainModelInstance = new Ratingobject('tt_news', 'uid');

        Bootstrap::initializeLanguageObject();
        $extAbsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('th_rating');
        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/Ratingobject.xml');
        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/pages.xml');
        $this->setUpFrontendRootPage(
            1,
            [
                $extAbsPath . '/Tests/Functional/Fixtures/Frontend/Basic.typoscript',
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.typoscript',
                $extAbsPath . '/Configuration/TypoScript/setup.typoscript'
            ]
        );
    }

    public function tearDown(): void
    {
        //unset($this->ratingobjectDomainModelInstance);
        //parent::tearDown();
    }

    /**
     * Checks construction of a new rating object
     */
    public function testConstructor(): void
    {
        static::assertEquals('tt_news', $this->ratingobjectDomainModelInstance->getRatetable());
        static::assertEquals('uid', $this->ratingobjectDomainModelInstance->getRatefield());
    }

    /**
     * @test
     * @depends testConstructor
     */
    public function pidCanBeSet(): void
    {
        $this->ratingobjectDomainModelInstance->setPid(1);
        static::assertEquals('1', $this->ratingobjectDomainModelInstance->getPid());
    }

    /**
     * est
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function ratingCanBeAdded(): void
    {
        $ratingobject = new Ratingobject('tt_news', 'uid');
        $ratingobject->setPid(2);
        $rating = new Rating($ratingobject, 1);

        $ratingobject->addRating($rating);
        self::assertEquals($ratingobject->getRatings()->current(), $rating);

        $rating2 = new Rating($ratingobject, 2);
        $ratingobject->addRating($rating2);
        self::assertEquals($ratingobject->getRatings()->current(), $rating2);
    }
}
