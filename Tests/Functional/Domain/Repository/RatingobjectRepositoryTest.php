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
use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Repository\RatingobjectRepository;
use Thucke\ThRating\Domain\Validator\RatingobjectValidator;
use Thucke\ThRating\Exception\RecordNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 * Testcases for RatingobjectRepository
 *
 * @version 	$Id:$
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		alpha
 * @entity
 */
class RatingobjectRepositoryTest extends FunctionalTestCase
{
    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];

    /**
     * @var RatingobjectRepository
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
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $extAbsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('th_rating');
        $this->importDataSet($extAbsPath.'/Tests/Functional/Fixtures/Database/Ratingobject.xml');
        $this->importDataSet($extAbsPath.'/Tests/Functional/Fixtures/Database/pages.xml');
        $this->setUpFrontendRootPage(
            1,
            [
                $extAbsPath.'/Tests/Functional/Fixtures/Frontend/Basic.typoscript',
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.txt',
                $extAbsPath.'/Configuration/TypoScript/setup.typoscript'
            ]
        );

        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->subject = $this->objectManager->get(RatingobjectRepository::class);
        //$this->subject->setDefaultQuerySettings($this->getDefaultQuerySettings());
        $this->subject->injectPersistenceManager($this->persistenceManager);
    }

    /**
     * @test
     * @throws IllegalObjectTypeException
     */
    public function addAndPersistAllCreatesNewRecord(): void
    {
        $ratetable = 'newTable';
        $ratefield = 'newField';
        $model = new Ratingobject($ratetable, $ratefield);

        $this->subject->add($model);
        $this->persistenceManager->persistAll();

        $databaseRow = $this->getDatabaseConnection()->selectSingleRow(
            '*',
            'tx_thrating_domain_model_ratingobject',
            'uid = ' . $model->getUid()
        );
        $this->assertSame($ratetable, $databaseRow['ratetable']);
    }

    /**
     * @test
     */
    public function findAllAndStoragePageCombination(): void
    {
        $this->assertEquals(4, $this->subject->findAll(true)->count());
        $this->assertEquals(3, $this->subject->findAll(false)->count());
    }

    /**
     * @test
     * @throws IllegalObjectTypeException
     * @throws RecordNotFoundException
     */
    public function findMatchingTableAndField(): void
    {
        $foundRow = $this->subject->findByUid(1);
        $this->assertEquals(1, $foundRow->getUid());
        $this->assertEquals('testTable', $foundRow->getRatetable());
        $this->assertEquals('testField', $foundRow->getRatefield());

        $foundRow = $this->subject->findMatchingTableAndField('testTable', 'testField');
        //check for right object type
        $this->assertInstanceOf(Ratingobject::class, $foundRow);
        //validate found object
        $this->assertFalse($this->objectManager->get(RatingobjectValidator::class)->validate($foundRow)->hasErrors());
        //check if it matches fixture
        $this->assertEquals(1, $foundRow->getUid());

        /* TODO this test fails only outside the context of TYPO3
        /*
        $foundRow = $this->subject->findMatchingTableAndField('testTable', 'testFieldNewAdded', true);
        $this->assertEquals(5, $foundRow->getUid());
        */
    }

    /**
     * @test
     * @throws IllegalObjectTypeException
     * @throws RecordNotFoundException
     */
    public function exceptionOnMissingEntry(): void
    {
        $this->expectException(RecordNotFoundException::class);
        $this->subject->findMatchingTableAndField('testTable', 'testFieldNewAdded');
    }
}
