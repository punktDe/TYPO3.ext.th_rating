<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
namespace Thucke\ThRating\Tests\Unit\Utility;

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
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Thucke\ThRating\Utility\DeprecationHelperUtility;

class DeprecationHelperUtilityTest extends UnitTestCase
{
    protected $testExtensionsToLoad = ['typo3conf/ext/th_rating'];
    protected $coreExtensionsToLoad = ['extbase', 'fluid'];

    /**
     *
     */
    public function tearDown():void
    {
        parent::tearDown();
    }

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
