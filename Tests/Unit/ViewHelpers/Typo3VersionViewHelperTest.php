<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
namespace Thucke\ThRating\Tests\Unit;

/*
 * This file is part of the TYPO3 extension Rating AX <EXT:th_rating>.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read
 * LICENSE file that was distributed with this source code.
 */
use Nimut\TestingFramework\MockObject\AccessibleMockObjectInterface;
use Nimut\TestingFramework\TestCase\ViewHelperBaseTestcase;
use Thucke\ThRating\ViewHelpers\Typo3VersionViewHelper;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

class Typo3VersionViewHelperTest extends ViewHelperBaseTestcase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|AccessibleMockObjectInterface|\Thucke\ThRating\ViewHelpers\Typo3VersionViewHelper */
    protected $mockedViewHelper;

    /** @var string */
    protected $t3VersionNumber;

    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];
    protected $coreExtensionsToLoad = ['extbase', 'fluid'];

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockedViewHelper = $this->getAccessibleMock(Typo3VersionViewHelper::class, ['dummy'], [], '', true, true, false);
        $this->injectDependenciesIntoViewHelper($this->mockedViewHelper);
        $this->mockedViewHelper->initializeArguments();
    }

    /**
     * @test
     */
    public function renderEqualsTYPO3Version(): void
    {
        $arguments['testVersion'] = VersionNumberUtility::getCurrentTypo3Version();
        $arguments['testOperator'] = '==';
        $this->mockedViewHelper->_set('arguments', $arguments);
        $actual = $this->mockedViewHelper->_call('render');
        $this->assertTrue($actual);
    }

    /**
     * @test
     */
    public function renderNotLtVersion60(): void
    {
        $arguments['testVersion'] = '6.0';
        $arguments['testOperator'] = '<=';
        $this->mockedViewHelper->setArguments($arguments);
        $actual = $this->mockedViewHelper->_call('render');
        $this->assertFalse($actual);
    }

    /**
     * @test
     */
    public function renderNotGtTYPO3Version(): void
    {
        $arguments['testVersion'] = VersionNumberUtility::getCurrentTypo3Version();
        $arguments['testOperator'] = '>';
        $this->mockedViewHelper->setArguments($arguments);
        $actual = $this->mockedViewHelper->_call('render');
        $this->assertFalse($actual);
    }
}
