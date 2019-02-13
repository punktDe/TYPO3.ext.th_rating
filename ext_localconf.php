<?php
defined('TYPO3_MODE') or die();

(function () {
    /**
     * Configure the Plugin to call the
     * right combination of Controller and Action according to
     * the user input (default settings, FlexForm, URL etc.)
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Thucke.ThRating',    // The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
        'Pi1',        // A unique name of the plugin in UpperCamelCase
        [        // An array holding the controller-action-combinations that are accessible
            'Vote' => 'ratinglinks,polling,mark,index,show,create,new,singleton',    // The first controller and its first action will be the default
        ],
        [        // An array of non-cachable controller-action-combinations (they must already be enabled)
            'Vote' => 'new,create,ratinglinks,polling,mark' ]
    );

    // here we register "DynamicCssEvaluator" to remove the dynamic CSS file when values are modified in the BE
    $TYPO3_CONF_VARS['SC_OPTIONS']['tce']['formevals'][Thucke\ThRating\Evaluation\DynamicCssEvaluator::class] = '';
    //add hook to remove the dynamic CSS file when cache is cleared
    $TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = 'Thucke\ThRating\Evaluation\DynamicCssEvaluator->clearCachePostProc';

    /**
     * Base configuration of logging events.
     * Each loglevel could be swichted off using typoscript setting
     */
    /*$GLOBALS['TYPO3_CONF_VARS']['LOG']['Thucke']['ThRating']['writerConfiguration'] = array(
        \TYPO3\CMS\Core\Log\LogLevel::EMERGENCY => array(),
        \TYPO3\CMS\Core\Log\LogLevel::ALERT => array(),
        \TYPO3\CMS\Core\Log\LogLevel::CRITICAL => array(),
        \TYPO3\CMS\Core\Log\LogLevel::ERROR => array(),
        \TYPO3\CMS\Core\Log\LogLevel::WARNING => array(),
        \TYPO3\CMS\Core\Log\LogLevel::NOTICE => array(),
        \TYPO3\CMS\Core\Log\LogLevel::INFO => array(),
        \TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(),
        );*/

    // Example for using signals of this extension:
    //$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
    //$signalSlotDispatcher->connect('Thucke\\ThRating\\Controller\\VoteController', 'afterRatinglinkAction', 'Thucke\\ThRating\\Controller\\VoteController', 'afterRatinglinkActionHandler',false);
    //$signalSlotDispatcher->connect('Thucke\\ThRating\\Controller\\VoteController', 'afterCreateAction', 'Thucke\\ThRating\\Controller\\VoteController', 'afterCreateActionHandler',false);
})();
