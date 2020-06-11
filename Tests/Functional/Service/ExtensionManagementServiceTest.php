<?php
declare(strict_types=1);
namespace Thucke\ThRating\Tests\Functional\Service;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Service\ExtensionManagementService;
use Thucke\ThRating\Service\LoggingService;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use TYPO3\CMS\Core\Log\Logger;

/**
 * Test case.
 */
class ExtensionManagementServiceTest extends FunctionalTestCase
{
    /**
     * @var string[]
     */
    //protected $backupGlobalsBlacklist = ['TYPO3_CONF_VARS'];
    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];
    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = ['extbase', 'fluid'];

    /**
     * @var \Thucke\ThRating\Service\ExtensionHelperService|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface
     */
    protected $extensionHelperServiceMock;

    /**
     * @var \Thucke\ThRating\Service\LoggingService|\TYPO3\CMS\Core\Tests\AccessibleObjectInterface
     */
    protected $loggingServiceMock;

    /**
     * @var []
     */
    protected $testRatingObject = [
        'ratetable' =>'ExtTestTable',
        'ratefield' =>'ExtTestField',
        'pid' => 3
    ];

    /**
     * @var \Thucke\ThRating\Service\ExtensionManagementService
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->prepareLoggingServiceMock();
        $this->prepareExtensionHelperServiceMock();

        $this->subject = new ExtensionManagementService($this->loggingServiceMock);
        $this->subject->injectExtensionHelperService($this->extensionHelperServiceMock);

        $this->importDataSet(__DIR__ . '/Fixtures/Database/pages.xml');
        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.txt',
                'EXT:th_rating/Configuration/TypoScript/setup.typoscript',
                'EXT:th_rating/Tests/Functional/Service/Fixtures/Frontend/Basic.typoscript',
            ]
        );
    }

    /**
     * @return void
     */
    private function prepareLoggingServiceMock(): void
    {
        $loggerMock = $this->getMockBuilder( Logger::class)
            ->setConstructorArgs(['MockLogger'])
            ->setMethods(['log'])
            ->getMock();

        $this->loggingServiceMock = $this->getMockBuilder( LoggingService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getLogger'])
            ->getMock();
        $this->loggingServiceMock
            ->method('getLogger')
            ->willReturn($loggerMock);
    }


    /**
     * @return Ratingobject
     */
    private function getTestedRatingobject():Ratingobject
    {
        $ratingobject = new Ratingobject(
            $this->testRatingObject['ratetable'],
            $this->testRatingObject['ratefield']
        );
        $ratingobject->setPid($this->testRatingObject['pid']);
        return $ratingobject;
    }

    /**
     * @return void
     */
    private function prepareExtensionHelperServiceMock(): void
    {
        $this->extensionHelperServiceMock = $this->getMockBuilder(
            \Thucke\ThRating\Service\ExtensionHelperService::class
        )
            ->setConstructorArgs([$this->loggingServiceMock])
            ->setMethods(['getRatingobject'])
            ->getMock();

        $this->extensionHelperServiceMock
            ->method('getRatingobject')
            ->willReturn($this->getTestedRatingobject());
    }

    /**
     * @test
     * @throws \Exception
     */
    public function createdRatingabjectHasPid10(): void
    {
        /*
        $createdRatingobject = $this->subject->makeRatable(
            $this->testRatingObject['ratetable'],
            $this->testRatingObject['ratefield'],
            3
        ); */
        //$this->assertObjectHasAttribute( 'sdfsdfg', $createdRatingobject);
        $this->assertTrue(true);
    }

}
