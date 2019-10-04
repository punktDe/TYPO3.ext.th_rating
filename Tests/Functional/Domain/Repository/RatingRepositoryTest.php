<?php
declare(strict_types = 1);
namespace Thucke\ThRating\Tests\Functional\Domain\Repository;

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

use Nimut\TestingFramework\Exception\Exception;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Repository\RatingobjectRepository;
use Thucke\ThRating\Domain\Repository\RatingRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 * Testcases for RatingRepository
 *
 * @version 	$Id:$
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		alpha
 * @entity
 */
class RatingRepositoryTest extends FunctionalTestCase
{
    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];

    /**
     * @var RatingRepository
     */
    private $subject;

    /**
     * @var PersistenceManager
     */
    private $persistenceManager;

    /**
     * @var ObjectManager
     */
    private $objectManager;
    /**
     * @var Ratingobject
     */
    private $ratingobject;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->importDataSet(__DIR__ . '/Fixtures/Rating.xml');

        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->subject = $this->objectManager->get(RatingRepository::class);
        $this->subject->setDefaultQuerySettings($this->getDefaultQuerySettings());
        $this->subject->injectPersistenceManager($this->persistenceManager);
        $this->ratingobject = $this->createRatingobjectRepository()->findByUid(1);

    }

    /**
     * @return Typo3QuerySettings
     */
    protected function getDefaultQuerySettings(): Typo3QuerySettings {
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings $defaultQuerySettings */
        $defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        //$defaultQuerySettings->setRespectStoragePage(false);
        $defaultQuerySettings->setStoragePageIds(array(1));
        return $defaultQuerySettings;
    }

    /**
     * @return RatingobjectRepository
     */
    protected function createRatingobjectRepository(): RatingobjectRepository {
        $ratingobjectRepository = $this->objectManager->get(RatingobjectRepository::class);
        $ratingobjectRepository->injectPersistenceManager($this->persistenceManager);
        $ratingobjectRepository->setDefaultQuerySettings($this->getDefaultQuerySettings());
        return $ratingobjectRepository;

    }
    /**
     * @test
     * @throws IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function addAndPersistAllCreatesNewRecord(): void
    {
        $ratedobjectuid = 4;
        $model = new Rating($this->ratingobject, $ratedobjectuid);

        $this->subject->add($model);
        $this->persistenceManager->persistAll();

        $databaseRow = $this->getDatabaseConnection()->selectSingleRow('*', 'tx_thrating_domain_model_rating',
            'uid = ' . $model->getUid());
        $this->assertSame(1, $databaseRow['ratingobject']);
    }

    /**
     * @test
     */
    public function findAll(): void
    {
        $this->assertEquals(4, $this->subject->findAll()->count());
    }

    /**
     * @test
     * @throws IllegalObjectTypeException
     */
    public function findMatchingObjectAndUid(): void
    {
        $foundRow = $this->subject->findByUid(1);
        //check for right object type
        $this->assertInstanceOf(Rating::class, $foundRow);
        $this->assertEquals(1, $foundRow->getUid());
        $this->assertEquals(1, $foundRow->getRatingobject()->getUid());
        $this->assertEquals(1, $foundRow->getRatedobjectuid());

        $foundRow = $this->subject->findMatchingObjectAndUid($this->ratingobject, 1);
        //check for right object type
        $this->assertInstanceOf(Rating::class, $foundRow);
        //validate found object
        //$this->assertFalse($this->objectManager->get(RatingValidator::class)->validate($foundRow)->hasErrors());
        //check if it matches fixture
        $this->assertEquals(1, $foundRow->getUid());

        $foundRow = $this->subject->findMatchingObjectAndUid($this->ratingobject, 4);
        $this->assertEquals(0, $foundRow->getUid());

        $foundRow = $this->subject->findMatchingObjectAndUid($this->ratingobject, 4, true);
        $this->assertEquals(5, $foundRow->getUid());
    }

}
