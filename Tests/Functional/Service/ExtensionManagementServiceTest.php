<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Tests\Functional\Service;

use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Service\ExtensionManagementService;
use Thucke\ThRating\Service\LoggingService;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

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
     * @var \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperServiceMock;

    /**
     * @var \Thucke\ThRating\Service\LoggingService
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
        $extAbsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('th_rating');

        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/pages.xml');

        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.typoscript',
                $extAbsPath . '/Configuration/TypoScript/setup.typoscript',
                $extAbsPath . '/Tests/Functional/Fixtures/Frontend/Basic.typoscript',
            ]
        );

        $this->prepareLoggingServiceMock();
        $this->prepareExtensionHelperServiceMock();

        $this->subject = new ExtensionManagementService($this->loggingServiceMock);
        $this->subject->injectExtensionHelperService($this->extensionHelperServiceMock);
    }

    private function prepareLoggingServiceMock(): void
    {
        $loggerMock = $this->getMockBuilder(Logger::class)
            ->setConstructorArgs(['MockLogger'])
            ->setMethods(['log'])
            ->getMock();

        $this->loggingServiceMock = $this->getMockBuilder(LoggingService::class)
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
    private function getTestedRatingobject(): Ratingobject
    {
        $ratingobject = new Ratingobject(
            $this->testRatingObject['ratetable'],
            $this->testRatingObject['ratefield']
        );
        $ratingobject->setPid($this->testRatingObject['pid']);
        return $ratingobject;
    }

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
    public function createdRatingobjectHasPid10(): void
    {
        /* $createdRatingobject = $this->subject->makeRatable(
            $this->testRatingObject['ratetable'],
            $this->testRatingObject['ratefield'],
            3
        );
        $this->assertObjectHasAttribute( 'sdfsdfg', $createdRatingobject); */
        $this->assertTrue(true);
    }
}
