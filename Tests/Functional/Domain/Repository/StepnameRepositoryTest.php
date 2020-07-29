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
use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Model\Stepname;
use Thucke\ThRating\Domain\Repository\StepnameRepository;
use Thucke\ThRating\Domain\Repository\StepconfRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
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

        $this->importDataSet(__DIR__ . '/Fixtures/Stepconf.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/pages.xml');

        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->subject = $this->objectManager->get(StepnameRepository::class);
        $this->subject->injectPersistenceManager($this->persistenceManager);
        $this->subject->setDefaultQuerySettings($this->getDefaultQuerySettings());
        $this->stepconf = $this->createStepconfRepository()->findByUid(1);
        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.txt',
                'EXT:th_rating/Configuration/TypoScript/setup.typoscript',
                'EXT:th_rating/Tests/Functional/Domain/Repository/Fixtures/Frontend/Basic.typoscript',
            ]
        );
    }

    /**
     * @return Typo3QuerySettings
     */
    protected function getDefaultQuerySettings(): Typo3QuerySettings
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings $defaultQuerySettings */
        $defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $defaultQuerySettings->setRespectStoragePage(false);
        $defaultQuerySettings->setRespectSysLanguage(false);
        $defaultQuerySettings->setStoragePageIds([1]);

        return $defaultQuerySettings;
    }

    /**
     * @return StepconfRepository
     */
    protected function createStepconfRepository(): StepconfRepository
    {
        /** @var StepconfRepository $stepconfRepository */
        $stepconfRepository = $this->objectManager->get(StepconfRepository::class);
        $stepconfRepository->injectPersistenceManager($this->persistenceManager);
        $stepconfRepository->setDefaultQuerySettings($this->getDefaultQuerySettings());

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
        $model->setLanguageUid(1);
        $model->setStepname('stepname eins');

        $this->subject->add($model);
        $this->persistenceManager->persistAll();

        $databaseRow = $this->getDatabaseConnection()->selectSingleRow(
            '*',
            'tx_thrating_domain_model_stepname',
            'uid = ' . $model->getUid()
        );
        $this->assertSame($model->getLanguageUid(), $databaseRow['sys_language_uid']);
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
    public function findStepnameObject(): void
    {
        $model = new Stepname();
        $model->setStepconf($this->stepconf);
        $model->setLanguageUid(0);

        $foundRow = $this->subject->findStepnameObject($model);

        //check for right object type
        $this->assertInstanceOf(Stepname::class, $foundRow);

        //compare with fixure uid
        $this->assertEquals(1, $foundRow->getUid());

        //compare with fixure ratingobject
        $this->assertEquals(1, $foundRow->getStepconf()->getUid());

        //validate found object
        //$this->assertFalse($this->objectManager->get(RatingValidator::class)->validate($foundRow)->hasErrors());
    }

    public function testExistStepname(): void
    {
        $existingModelEntry = new Stepname();
        $existingModelEntry->setStepconf($this->stepconf);
        $existingModelEntry->setLanguageUid(0);

        $this->assertTrue($this->subject->existStepname($existingModelEntry));

        $notExistingModelEntry = new Stepname();
        $notExistingModelEntry->setStepconf($this->stepconf);
        $notExistingModelEntry->setLanguageUid(2);
        $this->assertFalse($this->subject->existStepname($notExistingModelEntry));
    }
}
