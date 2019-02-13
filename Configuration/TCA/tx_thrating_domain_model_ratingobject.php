<?php
$GLOBALS['TCA']['tx_thrating_domain_model_ratingobject'] = [
    'ctrl' => [
        'title' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.title',
        'label' => 'uid',
        'label_alt' => 'ratetable,ratefield',
        'label_userFunc' => 'Thucke\\ThRating\\Userfuncs\\Tca->getRatingObjectRecordTitle',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden', ],
        'iconfile' => 'EXT:th_rating/Resources/Public/Icons/tx_thrating_domain_model_ratingobject.gif', ],
    'interface' => [
        'showRecordFieldList' => 'hidden, ratetable, ratefield', ],
    'columns' => [
        'pid' => [
            'exclude' => 1,
            'config' => [
                'type' => 'none', ], ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check', ], ],
        'ratetable' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.ratetable',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 64, ], ],
        'ratefield' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.ratefield',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 64, ], ],
        'uid' => [
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.uid',
            'config' => ['type' => 'none'],
        ],
        'stepconfs' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.stepconfs',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_thrating_domain_model_stepconf',
                'foreign_field' => 'ratingobject',
                'foreign_default_sortby' => 'steporder',
                'appearance' => [
                    'levelLinksPosition' => 'bottom',
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'newRecordLinkAddTitle' => true,
                    //'newRecordLinkPosition' => 'both',
                    //'showSynchronizationLink' => true,
                    //'showAllLocalizationLink' => true,
                    //'showPossibleLocalizationRecords' => 1,
                    //'showRemovedLocalizationRecords' => 1,
                ], ], ],
        'ratings' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.ratings',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_thrating_domain_model_rating',
                'foreign_field' => 'ratingobject',
                'foreign_default_sortby' => 'uid',
                'appearance' => [
                    'levelLinksPosition' => 'bottom',
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                    'newRecordLinkAddTitle' => 1,
                    'newRecordLinkPosition' => 'both', ], ], ], ],
    'types' => [
        '1' => ['showitem' => 'hidden, ratetable, ratefield, stepconfs, ratings'], ],
    'palettes' => [
        '1' => ['showitem' => ''], ], ];

return $GLOBALS['TCA']['tx_thrating_domain_model_ratingobject'];
