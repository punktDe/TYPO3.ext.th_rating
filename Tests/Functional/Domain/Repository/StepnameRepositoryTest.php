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

        $extAbsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('th_rating');
        $this->importDataSet($extAbsPath.'/Tests/Functional/Fixtures/Database/Stepconf.xml');
        $this->importDataSet($extAbsPath.'/Tests/Functional/Fixtures/Database/Stepname.xml');
        $this->importDataSet($extAbsPath.'/Tests/Functional/Fixtures/Database/sys_language.xml');
        $this->importDataSet($extAbsPath.'/Tests/Functional/Fixtures/Database/pages.xml');

        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.txt',
                $extAbsPath.'/Configuration/TypoScript/setup.typoscript',
                $extAbsPath.'/Tests/Functional/Fixtures/Frontend/Basic.typoscript'
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
    public function findExistingStepnameObject(): void
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
        $model->setLanguageUid(2);

        $foundRow = $this->subject->findStepnameObject($model);
        //check for right object type
        $this->assertNull($foundRow);
    }

    public function testExistingStepname(): void
    {
        $existingModelEntry = new Stepname();
        $existingModelEntry->setStepconf($this->stepconf);
        $existingModelEntry->setLanguageUid(0);
        $this->assertTrue($this->subject->existStepname($existingModelEntry));

        $existingModelEntry->setLanguageUid(2);
        $this->assertFalse($this->subject->existStepname($existingModelEntry));

    }

    public function testMissingStepname(): void
    {
        $notExistingModelEntry = new Stepname();
        $notExistingModelEntry->setStepconf($this->stepconf);
        $notExistingModelEntry->setLanguageUid(2);
        $this->assertFalse($this->subject->existStepname($notExistingModelEntry));
    }
}
