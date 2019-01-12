<?php
$GLOBALS['TCA']['tx_thrating_domain_model_stepconf'] =  [
	'ctrl' => [
		'title'						=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.title',
		'label'						=> 'uid',
		'label_alt' 				=> 'ratingobject,steporder',
 		'label_userFunc' 			=> 'Thucke\\ThRating\\Userfuncs\\Tca->getStepconfRecordTitle',
		'tstamp'					=> 'tstamp',
		'crdate'					=> 'crdate',
		'cruser_id'					=> 'cruser_id',
		'delete'					=> 'deleted',
		'adminOnly'					=> true,
		'hideTable'					=> true,
		'editlock'					=> 'steporder,stepweight',
		'dividers2tabs'				=> true,
		'enablecolumns'				=> ['disabled'	=> 'hidden'],
		'iconfile'			=> 'EXT:th_rating/Resources/Public/Icons/tx_thrating_domain_model_stepconf.gif',],
	'interface' => [
		'showRecordFieldList' => 'hidden, ratingobject, steporder, stepweight, stepname'],
	'columns' => [
		'pid' => [
			'exclude' => 1,
			'config' => [
				'type' => 'none',],],
		'hidden' => [
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config'  => [
				'type' => 'check',
            ],
        ],
		'ratingobject' 	=> [
			'exclude'	=> 1,
			'label'  	=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.ratingobject',
			'config' 	=> [
				'type'		=> 'passthrough',],],
		'steporder' => [
			'label'   		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.steporder',
			'l10n_display'	=> 'defaultAsReadonly',
			//'l10n_cat'		=> 'media',
			'config'=> [
				'type'		=> 'input',
				'size'		=> '8',
				'max'		=> '12',
				'eval'		=> '\Thucke\ThRating\Evaluation\DynamicCssEvaluator::class,int,required',
				'default'	=> '1',
				'range'		=> ['lower' => 1]],],
		'stepweight' => [
			'label'   		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.stepweight',
			'l10n_display'	=> 'defaultAsReadonly',
			//'l10n_cat'		=> 'media',
			'config' 		=> [
				'type'		=> 'input',
				'size'		=> '8',
				'max'		=> '12',
				'eval'		=> '\Thucke\ThRating\Evaluation\DynamicCssEvaluator::class,int',
				'default'	=> '1',],],
		'stepname' => [
			'exclude' => 1,
			'label'  		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.stepname',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_thrating_domain_model_stepname',
				'foreign_field' => 'stepconf',
				'foreign_unique' => 'sys_language_uid',
				'foreign_default_sortby' => 'sys_language_uid',
				'appearance' => [
					'levelLinksPosition' 	=> 'bottom',
					'collapseAll' 			=> true,
					'expandSingle' 			=> true,
					'newRecordLinkAddTitle' => true,
					'enabledControls' => [
						 'info'		=> true,
						 'delete'	=> true,
						 'localize'	=> true,],
					'showPossibleLocalizationRecords' => true,
					'showSynchronizationLink' => true,
					'newRecordLinkPosition' => 'both',
					'showAllLocalizationLink' => true,
					'showRemovedLocalizationRecords' => 1,],
				'behaviour' => [
					'allowLanguageSynchronization' => true,
					'enableCascadingDelete' => true,
                ],
            ],
        ],
		'votes' => [
			'exclude' 		=> 1,
			'label'   		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.votes',
			'l10n_mode' 	=> 'eclude',
			'config' => [
				'type' => 'inline',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
				'foreign_table' 	=> 'tx_thrating_domain_model_vote',
				'foreign_field' 	=> 'vote',
				'foreign_default_sortby'	=> 'uid',
				'appearance' 		=> [
					'levelLinksPosition'	=> 'bottom',
					'collapseAll' 			=> 1,
					'expandSingle' 			=> 1,
					'newRecordLinkAddTitle' => true,
                ],
            ],
        ],
		'uid' => [
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.uid',
			'config' => [
				'type' => 'passthrough',],],],
	'types' => [
		'0' => ['showitem' => 'hidden, steporder, stepweight, stepname, votes'],],
	'palettes' => [
		'1' => ['showitem' => ''],],];
return $GLOBALS['TCA']['tx_thrating_domain_model_stepconf'];
