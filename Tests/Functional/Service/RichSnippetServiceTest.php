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
use Thucke\ThRating\Service\RichSnippetService;
use Thucke\ThRating\Service\LoggingService;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/**
 * Test case.
 */
class RichSnippetServiceTest extends FunctionalTestCase
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
     * @var array
     */
    protected $settings = [
        'ratetable' =>'tt_content',
        'richSnippetFields' => [
            'aggregateRatingSchemaType' => 'Brand',
            'name' => 'uid',
            'description' => ''
        ],
    ];

    /**
     * @var \Thucke\ThRating\Service\RichSnippetService
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $extAbsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('th_rating');

        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/pages.xml');
        $this->importDataSet($extAbsPath . '/Tests/Functional/Fixtures/Database/tt_content.xml');

        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:fluid_styled_content/Configuration/TypoScript/setup.typoscript',
                $extAbsPath . '/Configuration/TypoScript/setup.typoscript',
                $extAbsPath . '/Tests/Functional/Fixtures/Frontend/Basic.typoscript',
            ]
        );

        $this->prepareLoggingServiceMock();
        $this->subject = new RichSnippetService($this->loggingServiceMock);
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

    /**
     * @test
     * @throws \Exception
     */
    public function setRichSnippetConfigWithoutRichSnippetsReturnsFalse(): void
    {
        $this->assertFalse($this->subject->setRichSnippetConfig([]));
    }

    /**
     * @test
     * @throws \Exception
     */
    public function setRichSnippetConfigWithoutRichSnippetsReturnsTrue(): void
    {
        $this->assertTrue($this->subject->setRichSnippetConfig($this->settings));
    }

    /**
     * @test
     * @throws \Exception
     */
    public function checkRichSnippetObject(): void
    {
        $this->subject->setRichSnippetConfig($this->settings);

        # schema should return "Product" by default
        $this->assertSame('Brand', $this->subject->getRichSnippetObject(1)->getSchema());

        # name should be "uid" in this test
        $this->assertSame('1', $this->subject->getRichSnippetObject(1)->getName());

        # description should be empty in this test
        $this->assertEmpty($this->subject->getRichSnippetObject(1)->getDescription());
    }
}
