<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3_MODE') or die();

call_user_func(static function () {
    ExtensionUtility::registerPlugin(
        // The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
        'Thucke.ThRating',
        'Pi1',		// A unique name of the plugin in UpperCamelCase
        'Rating AX'	// A title shown in the backend dropdown field
    );

    $pluginSignature = 'thrating_pi1';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,pages';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        'FILE:EXT:th_rating/Configuration/Flexforms/flexform_pi1.xml'
    );
});
