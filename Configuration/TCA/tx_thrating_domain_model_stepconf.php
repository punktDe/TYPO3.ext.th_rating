<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$GLOBALS['TCA']['tx_thrating_domain_model_stepconf'] =  array(
	'ctrl' => array(
		'title'						=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.title',
		'label'						=> 'uid',
		'label_alt' 				=> 'ratingobject,steporder',
 		'label_userFunc' 			=> 'Thucke\\ThRating\\Service\\TCALabelUserFuncService->getStepconfRecordTitle',
		'tstamp'					=> 'tstamp',
		'crdate'					=> 'crdate',
		'cruser_id'					=> 'cruser_id',
		'delete'					=> 'deleted',
		'adminOnly'					=> true,
		'hideTable'					=> true,
		'editlock'					=> 'steporder,stepweight',
		'dividers2tabs'				=> true,
		'enablecolumns'				=> array( 'disabled'	=> 'hidden' ),
		'iconfile'			=> 'EXT:th_rating/Resources/Public/Icons/tx_thrating_domain_model_stepconf.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, ratingobject, steporder, stepweight, stepname'
	),
	'columns' => array(
		'pid' => array(
			'exclude' => 1,
			'config' => array(
				'type' => 'none',
			),
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check',
				'default' => 0,
			),
		),
		'ratingobject' 	=> array(
			'exclude'	=> 1,
			'label'  	=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.ratingobject',
			'config' 	=> array(
				'type'		=> 'passthrough',
			),
		),
		'steporder' => array(
			'label'   		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.steporder',
			'l10n_display'	=> 'defaultAsReadonly',
			//'l10n_cat'		=> 'media',
			'config'=> array(
				'type'		=> 'input',
				'size'		=> '8',
				'max'		=> '12',
				'eval'		=> '\Thucke\ThRating\Evaluation\DynamicCssEvaluator::class,int,required',
				'default'	=> '1',
				'range'		=> array('lower' => 1)
			),
		),
		'stepweight' => array(
			'label'   		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.stepweight',
			'l10n_display'	=> 'defaultAsReadonly',
			//'l10n_cat'		=> 'media',
			'config' 		=> array(
				'type'		=> 'input',
				'size'		=> '8',
				'max'		=> '12',
				'eval'		=> '\Thucke\ThRating\Evaluation\DynamicCssEvaluator::class,int',
				'default'	=> '1',
			),
		),
		'stepname' => array(
			'exclude' => 1,
			'label'  		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.stepname',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_thrating_domain_model_stepname',
				'foreign_field' => 'stepconf',
				'foreign_unique' => 'sys_language_uid',
				'foreign_default_sortby' => 'sys_language_uid',
				'maxitems'      => 999999,
				'appearance' => array(
					'levelLinksPosition' 	=> 'bottom',
					'collapseAll' 			=> true,
					'expandSingle' 			=> true,
					'newRecordLinkAddTitle' => true,
					'enabledControls' => array(
						 'info'		=> true,
						 'delete'	=> true,
						 'localize'	=> true,
					),
					'showPossibleLocalizationRecords' => true,
					'showSynchronizationLink' => true,
					'newRecordLinkPosition' => 'both',
					'showAllLocalizationLink' => true,
					'showRemovedLocalizationRecords' => 1,
				),
				'behaviour' => array(
					'localizationMode' => 'select',
					'enableCascadingDelete' => true,
				),
			),
		),
		'votes' => array(
			'exclude' 		=> 1,
			'label'   		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.votes',
			'l10n_mode' 	=> 'exclude',
			//'l10n_display'	=> 'hideDiff',
			'config' => array(
				'type' => 'inline',
				'foreign_table' 	=> 'tx_thrating_domain_model_vote',
				'foreign_field' 	=> 'vote',
				'foreign_default_sortby'	=> 'uid',
				'maxitems'      	=> 999999,
				'appearance' 		=> array(
					'levelLinksPosition'	=> 'bottom',
					'collapseAll' 			=> 1,
					'expandSingle' 			=> 1,
					'newRecordLinkAddTitle' => true,
				),
			),
		),
		'uid' => array(
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.uid',
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden, steporder, stepweight, stepname, votes'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
);
return $GLOBALS['TCA']['tx_thrating_domain_model_stepconf'];
?>