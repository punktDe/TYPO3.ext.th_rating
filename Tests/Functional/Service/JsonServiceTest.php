<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Service;

use TYPO3\CMS\Core\Log\Logger;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class JsonServiceTest extends FunctionalTestCase
{

    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];

    /**
     * @var JsonService
     */
    protected $subject;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $loggingServiceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $extAbsPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('th_rating');

        $this->prepareLoggingServiceMock();

        $this->subject = new JsonService($this->loggingServiceMock);
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
     * @test
     */
    public function encodeArrayToJson(): void
    {
        $expectedJson = '["foo","bar","baz","blong"]';
        $sourceArray = ['foo', 'bar', 'baz', 'blong'];
        self::assertSame($expectedJson, $this->subject->encodeToJson($sourceArray));
    }

    /**
     * @test
     */
    public function encodeArrayToJsonAcceptsEmpty(): void
    {
        self::assertFalse($this->subject->encodeToJson(null));
        self::assertFalse($this->subject->encodeToJson([]));
    }

    /**
     * @test
     */
    public function decodeJson(): void
    {
        $expectedArray = [
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => 4,
            'e' => 5
        ];
        $sourceJson = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
        self::assertSame($expectedArray, $this->subject->decodeJsonToArray($sourceJson));
    }

    /**
     * @test
     */
    public function decodeJsonAcceptsEmpty(): void
    {
        self::assertFalse($this->subject->decodeJsonToArray(null));
        self::assertFalse($this->subject->decodeJsonToArray(''));
    }
}
