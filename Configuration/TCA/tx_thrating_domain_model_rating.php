<?php
$GLOBALS['TCA']['tx_thrating_domain_model_rating'] = [
    'ctrl' => [
        'title' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.title',
        'label' => 'uid',
        'label_alt' => 'ratingobject,ratedobjectuid,votes',
        'label_userFunc' => 'Thucke\\ThRating\\Userfuncs\\Tca->getRatingRecordTitle',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'adminOnly' => true,
        'hideTable' => true,
        'editlock' => 'ratedobjectuid',
        'enablecolumns' => [
            'disabled' => 'hidden', ],
        'iconfile' => 'EXT:th_rating/Resources/Public/Icons/tx_thrating_domain_model_rating.gif', ],
    'interface' => [
        'showRecordFieldList' => 'hidden, ratedobjectuid, votes', ],
    'columns' => [
        'pid' => [
            'exclude' => 1,
            'config' => [
                'type' => 'none',
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'ratingobject' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.ratingobject',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_thrating_domain_model_ratingobject',
                'maxitems' => 1,
                'minitems' => 1,
                'disableNoMatchingValueElement' => 1, ], ],
        'ratedobjectuid' => [
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.ratedobjectuid',
            'config' => [
                'type' => 'input',
                'size' => '8',
                'max' => '12',
                'eval' => 'int',
                'default' => 0, ], ],
        'votes' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.votes',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_thrating_domain_model_vote',
                'foreign_field' => 'rating',
                'foreign_default_sortby' => 'uid',
                'appearance' => [
                    'levelLinksPosition' => 'bottom',
                    'collapseAll' => 1,
                    'expandSingle' => 1, ], ], ],
        'currentrates' => [
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.currentrates',
            'config' => [
                'type' => 'none',
                'size' => '30', ], ],
        'uid' => [
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.uid',
            'config' => ['type' => 'none'],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, ratedobjectuid, votes'], ],
    'palettes' => [
        '1' => ['showitem' => ''], ], ];

return $GLOBALS['TCA']['tx_thrating_domain_model_rating'];
