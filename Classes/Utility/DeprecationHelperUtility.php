<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * Localization helper which should be used to fetch localized labels.
 *
 * @api
 */
class DeprecationHelperUtility
{

    /**
     * @param string $testVersion
     * @return bool|int
     */
    public static function isTypo3VersionLowerThan(string $testVersion)
    {
        $t3VersionNumber = GeneralUtility::makeInstance(VersionNumberUtility::class)->getCurrentTypo3Version();
        return version_compare($t3VersionNumber, $testVersion, '<');
    }
}
