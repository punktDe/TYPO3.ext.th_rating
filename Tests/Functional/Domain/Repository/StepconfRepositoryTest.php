<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Tests\Functional\Domain\Repository;

use TYPO3\TestingFramework\Core\Exception;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Repository\RatingobjectRepository;
use Thucke\ThRating\Domain\Repository\StepconfRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Testcases for RatingRepository
 *
 * @version 	$Id:$
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		alpha
 * @entity
 */
class StepconfRepositoryTest extends FunctionalTestCase
{
    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];

    /**
     * @var StepconfRepository
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
        $extAbsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('th_rating');

        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/Ratingobject.xml');
        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/Stepconf.xml');

        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->subject = $this->objectManager->get(StepconfRepository::class);
        $this->subject->injectPersistenceManager($this->persistenceManager);
        $this->ratingobject = $this->createRatingobjectRepository()->findByUid(1);
    }

    /**
     * @return RatingobjectRepository
     */
    protected function createRatingobjectRepository(): RatingobjectRepository
    {
        $ratingobjectRepository = $this->objectManager->get(RatingobjectRepository::class);
        $ratingobjectRepository->injectPersistenceManager($this->persistenceManager);

        return $ratingobjectRepository;
    }

    /**
     * @test
     * @throws IllegalObjectTypeException
     */
    public function addAndPersistAllCreatesNewRecord(): void
    {
        $steporder = 3;
        $model = new Stepconf($this->ratingobject, $steporder);

        $this->subject->add($model);
        $this->persistenceManager->persistAll();

        $databaseRow = $this->getDatabaseConnection()->selectSingleRow(
            '*',
            'tx_thrating_domain_model_stepconf',
            'uid = ' . $model->getUid()
        );
        $this->assertSame($steporder, $databaseRow['steporder']);
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
     */
    public function findStepconfObject(): void
    {
        $steporder = 2;
        $model = new Stepconf($this->ratingobject, $steporder);

        $foundRow = $this->subject->findStepconfObject($model);
        //check for right object type
        $this->assertInstanceOf(Stepconf::class, $foundRow);

        //compare with fixure uid
        $this->assertEquals(2, $foundRow->getUid());

        //compare with fixure ratingobject
        $this->assertEquals(1, $foundRow->getRatingobject()->getUid());

        //validate found object
        //$this->assertFalse($this->objectManager->get(RatingValidator::class)->validate($foundRow)->hasErrors());
    }

    public function testExistStepconf(): void
    {
        $existingModelEntry = new Stepconf($this->ratingobject, 2);
        $this->assertTrue($this->subject->existStepconf($existingModelEntry));

        $notExistingModelEntry = new Stepconf($this->ratingobject, 5);
        $this->assertFalse($this->subject->existStepconf($notExistingModelEntry));
    }
}
