<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Tests\Functional\Domain\Repository;

use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Repository\RatingobjectRepository;
use Thucke\ThRating\Domain\Repository\RatingRepository;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\TestingFramework\Core\Exception;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Testcases for RatingRepository
 *
 * @version 	$Id:$
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
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp(): void
    {
        parent::setUp();

        Bootstrap::initializeLanguageObject();
        $extAbsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('th_rating');
        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/Rating.xml');
        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/pages.xml');
        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.txt',
                $extAbsPath . '/Configuration/TypoScript/setup.typoscript',
                $extAbsPath . '/Tests/Functional/Fixtures/Frontend/Basic.typoscript',
            ]
        );

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
    protected function getDefaultQuerySettings(): Typo3QuerySettings
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings $defaultQuerySettings */
        $defaultQuerySettings = $this->objectManager->get(QuerySettingsInterface::class);
        //$defaultQuerySettings->setRespectStoragePage(false);
        $defaultQuerySettings->setStoragePageIds([1, 10]);

        return $defaultQuerySettings;
    }

    /**
     * @return RatingobjectRepository
     */
    protected function createRatingobjectRepository(): RatingobjectRepository
    {
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

        $connection = $this->getConnectionPool()->getConnectionForTable('tx_thrating_domain_model_rating');
        $databaseRow = $connection->select(
            ['ratingobject'],
            'tx_thrating_domain_model_rating',
            ['uid' => $model->getUid()]
        )->fetch();
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
