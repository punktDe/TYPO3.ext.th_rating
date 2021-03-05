<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Tests\Functional\Domain\Repository;

use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Model\Stepname;
use Thucke\ThRating\Domain\Repository\StepconfRepository;
use Thucke\ThRating\Domain\Repository\StepnameRepository;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
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
class StepnameRepositoryTest extends FunctionalTestCase
{
    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];

    /**
     * @var StepnameRepository
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
     * @var Stepconf
     */
    private $stepconf;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        Bootstrap::initializeLanguageObject();
        $extAbsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('th_rating');
        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/Stepconf.xml');
        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/Stepname.xml');
        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/pages.xml');

        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.typoscript',
                $extAbsPath . '/Configuration/TypoScript/setup.typoscript',
                $extAbsPath . '/Tests/Functional/Fixtures/Frontend/Basic.typoscript'
            ]
        );

        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->subject = $this->objectManager->get(StepnameRepository::class);
        $this->subject->injectPersistenceManager($this->persistenceManager);
        $this->stepconf = $this->createStepconfRepository()->findByUid(1);
    }

    /**
     * @return StepconfRepository
     */
    protected function createStepconfRepository(): StepconfRepository
    {
        /** @var StepconfRepository $stepconfRepository */
        $stepconfRepository = $this->objectManager->get(StepconfRepository::class);
        $stepconfRepository->injectPersistenceManager($this->persistenceManager);
        return $stepconfRepository;
    }

    /**
     * @test
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function addAndPersistAllCreatesNewRecord(): void
    {
        $model = new Stepname();
        $model->setStepconf($this->stepconf);
        $model->setSysLanguageUid(1);
        $model->setStepname('stepname eins');

        $this->subject->add($model);
        $this->persistenceManager->persistAll();

        $connection = $this->getConnectionPool()->getConnectionForTable('tx_thrating_domain_model_stepname');
        $databaseRow = $connection->select(
            ['sys_language_uid'],
            'tx_thrating_domain_model_stepname',
            ['uid' => $model->getUid()]
        )->fetch();
        $this->assertSame($model->getSysLanguageUid(), $databaseRow['sys_language_uid']);
    }

    /**
     * @test
     */
    public function findAll(): void
    {
        $this->assertEquals(2, $this->subject->countAll());
    }

    /**
     * @test
     */
    public function findExistingStepnameObject(): void
    {
        $model = new Stepname();
        $model->setStepconf($this->stepconf);
        $model->setSysLanguageUid(0);

        $foundRow = $this->subject->findStepnameObject($model);
        //check for right object type
        $this->assertInstanceOf(Stepname::class, $foundRow);
        //compare with fixure uid
        $this->assertEquals(1, $foundRow->getUid());
        //compare with fixure ratingobject
        $this->assertEquals(1, $foundRow->getStepconf()->getUid());
    }

    /**
     * @test
     */
    public function findDefaultStepnameObject(): void
    {
        $localizedStepname = $this->subject->findStrictByUid(3);
        $defaultStepname = $this->subject->findDefaultStepname($localizedStepname);
        //check for right object type
        $this->assertInstanceOf(Stepname::class, $defaultStepname);
        //compare with fixure uid
        $this->assertEquals($localizedStepname->getL18nParent(), $defaultStepname->getUid());
        //compare with fixure uid
        $this->assertEquals(0, $defaultStepname->getL18nParent());
    }
    /**
     * @test
     */
    public function findMissingStepnameObject(): void
    {
        $model = new Stepname();
        $model->setStepconf($this->stepconf);
        $model->setSysLanguageUid(2);

        $foundRow = $this->subject->findStepnameObject($model);
        //check for right object type
        $this->assertNull($foundRow);
    }

    public function testExistingStepname(): void
    {
        $existingModelEntry = new Stepname();
        $existingModelEntry->setStepconf($this->stepconf);
        $existingModelEntry->setSysLanguageUid(0);
        $this->assertTrue($this->subject->existStepname($existingModelEntry));

        $existingModelEntry->setSysLanguageUid(2);
        $this->assertFalse($this->subject->existStepname($existingModelEntry));
    }

    public function testMissingStepname(): void
    {
        $notExistingModelEntry = new Stepname();
        $notExistingModelEntry->setStepconf($this->stepconf);
        $notExistingModelEntry->setSysLanguageUid(2);
        $this->assertFalse($this->subject->existStepname($notExistingModelEntry));
    }
}
