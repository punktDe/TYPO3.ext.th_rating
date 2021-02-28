<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
namespace Thucke\ThRating\Tests\Unit\Utility;

use Thucke\ThRating\Utility\DeprecationHelperUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DeprecationHelperUtilityTest extends UnitTestCase
{
    use ProphecyTrait;

    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];

    /**
     * @test
     */
    public function versionIsNotLowerThan9(): void
    {
        $this->assertFalse(DeprecationHelperUtility::isTypo3VersionLowerThan('9'));
    }

    /**
     * @test
     */
    public function versionIsLowerThan11(): void
    {
        $this->assertTrue(DeprecationHelperUtility::isTypo3VersionLowerThan('11'));
    }
}
