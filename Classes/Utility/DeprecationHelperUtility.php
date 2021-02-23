<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Utility;

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
