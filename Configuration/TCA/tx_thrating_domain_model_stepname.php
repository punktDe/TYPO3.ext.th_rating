<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$GLOBALS['TCA']['tx_thrating_domain_model_stepname'] = [
    'ctrl' => [
        'title' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepname.title',
        'label' => 'uid',
        'label_alt' => 'stepconf,sys_language_uid',
        'label_userFunc' => 'Thucke\\ThRating\\Userfuncs\\Tca->getStepnameRecordTitle',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l18n_parent',
        'transOrigDiffSourceField' => 'l18n_diffsource',
        'delete' => 'deleted',
        'adminOnly' => false,
        'hideTable' => false,
        'editlock' => 'sys_language_uid,stepconf',
        'dividers2tabs' => true,
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'iconfile' => 'EXT:th_rating/Resources/Public/Icons/tx_thrating_domain_model_stepname.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, stepconf, stepname, sys_language_uid',
    ],
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
            'l10n_display' => 'hideDiff',
            'l10n_mode' => 'exclude',
            'displayCond' => [
                'AND' => [
                    'FIELD:sys_language_uid:=:0',
                ],
            ],
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'stepconf' => [
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepname.stepconf',
            'config' => [
                'type' => 'passthrough', ], ],
        'stepname' => [
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepname.stepname',
            'l10n_mode' => 'prefixLangTitle',
            'l10n_display' => 'hideDiff',
            'config' => [
                'type' => 'input',
                'size' => '15',
                'max' => '64',
                'eval' => 'Thucke\\ThRating\\Evaluation\\DynamicCssEvaluator,trim',
            ],
        ],
        'uid' => [
            'label' => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepname.uid',
            'config' => [
                'type' => 'none',
            ],
        ],
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'readOnly' => true,
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    [
                        'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l18n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        '',
                        0
                    ],
                ],
                'foreign_table' => 'tx_thrating_domain_model_stepname',
                'foreign_table_where' => 'AND {#tx_thrating_domain_model_stepname}.{#uid}=###REC_FIELD_l18n_parent###' .
                    'AND {#tx_thrating_domain_model_stepname}.{#sys_language_uid} IN (-1,0)',
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => true,
                    ],
                ],
                'default' => 0
            ],
        ],
        'l18n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'hidden, stepname, stepconf, sys_language_uid'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
];

return $GLOBALS['TCA']['tx_thrating_domain_model_stepname'];
