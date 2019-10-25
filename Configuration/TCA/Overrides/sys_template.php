<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3_MODE') or die();

call_user_func(static function () {
    ExtensionManagementUtility::addStaticFile('th_rating', 'Configuration/TypoScript', 'Rating AX');
    ExtensionManagementUtility::allowTableOnStandardPages('tx_thrating_domain_model_ratingobject');
});
