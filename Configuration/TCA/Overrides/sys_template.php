<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3_MODE') or die();

call_user_func(static function () {
    ExtensionManagementUtility::addStaticFile('th_rating', 'Configuration/TypoScript', 'Rating AX');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_thrating_domain_model_ratingobject');
});
