<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_thrating_domain_model_ratingobject'] = array(
	'ctrl' => $TCA['tx_thrating_domain_model_ratingobject']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, ratetable, ratefield'
	),
	'columns' => array(
		'pid' => Array (  
			'exclude' => 1,
			'config' => Array (
				'type' => 'none',
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'ratetable' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.ratetable',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim,required',
				'max'  => 64
			)
		),
		'ratefield' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.ratefield',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'trim,required',
				'max'  => 64
					)
		),
		'uid' => array(
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.uid',
		),
		'stepconfs' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.stepconfs',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_thrating_domain_model_stepconf',
				'foreign_field' => 'ratingobject',
				'foreign_default_sortby' => 'steporder',
				'maxitems'      => 999999,
				'appearance' => array(
					'levelLinksPosition' 	=> 'bottom',
					'collapseAll' 			=> TRUE,
					'expandSingle' 			=> TRUE,
					'newRecordLinkAddTitle' => TRUE,
					//'newRecordLinkPosition' => 'both',
					//'showSynchronizationLink' => TRUE,
					//'showAllLocalizationLink' => TRUE,
					//'showPossibleLocalizationRecords' => 1,
					//'showRemovedLocalizationRecords' => 1,
				),
			),
		),
		'ratings' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.ratings',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_thrating_domain_model_rating',
				'foreign_field' => 'ratingobject',
				'foreign_sortby' => 'uid',
				'maxitems'      => 999999,
				'appearance' => array(
					'levelLinksPosition' => 'bottom',
					'collapseAll' => 1,
					'expandSingle' => 1,
					'newRecordLinkAddTitle' => 1,
					'newRecordLinkPosition' => 'both',
				),
			),
		),
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, ratetable, ratefield, stepconfs, ratings')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
);
?>