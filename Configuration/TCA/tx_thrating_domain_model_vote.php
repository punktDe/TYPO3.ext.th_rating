<?php
$GLOBALS['TCA']['tx_thrating_domain_model_vote'] = [
    'ctrl' => [
        'title' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.title',
        'label' => 'uid',
        'label_alt' => 'rating,fe_user,vote',
        'label_userFunc' => 'Thucke\\ThRating\\Userfuncs\\Tca->getVoteRecordTitle',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'adminOnly' => true,
        'hideTable' => true,
        'editlock' => 'rating',
        'enablecolumns' => [
            'disabled' => 'hidden', ],
        'iconfile' => 'EXT:th_rating/Resources/Public/Icons/tx_thrating_domain_model_vote.gif', ],
    'interface' => [
        'showRecordFieldList' => 'hidden, rating, voter, vote', ],
    'columns' => [
        'pid' => [
            'exclude' => 1,
            'config' => [
                'type' => 'none', ], ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check', ], ],
        'rating' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.rating',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_thrating_domain_model_rating',
                'maxitems' => 1,
                'minitems' => 1,
                'disableNoMatchingValueElement' => 1, ], ],
        'voter' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.voter',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_table_where' => 'ORDER BY fe_users.username',
                'items' => [
                    ['--div--', 0], ],
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'setValue' => 'prepend',
                        ],
                        'listModule' => [
                            'disabled' => false,
                        ],
                    ],
                ],
            ],
        ],
        //TODO	Prio 3: only provide valid references from foreign table
        'vote' => [
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.vote',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_thrating_domain_model_stepconf',
                'maxitems' => 1,
                'minitems' => 1,
                'disableNoMatchingValueElement' => 1, ], ],
        'uid' => [
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.uid',
            'config' => ['type' => 'none'],
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, rating, voter, vote'], ],
    'palettes' => [
        '1' => ['showitem' => ''], ], ];

return $GLOBALS['TCA']['tx_thrating_domain_model_vote'];
