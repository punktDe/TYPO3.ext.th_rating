<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_thrating_domain_model_rating'] = array(
	'ctrl' => $TCA['tx_thrating_domain_model_rating']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, ratedobjectuid, votes'
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
		'ratingobject' => Array (		
			'exclude' => 1,		
			'label'   => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.rating.ratingobject',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_thrating_domain_model_ratingobject',
				'maxitems' => 1,
				'minitems' => 1,
				'disableNoMatchingValueElement' => 1
			)
		),		
		'ratedobjectuid' => Array (
			'label'   => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.rating.ratedobjectuid',
			'config' => Array (
				'type' => 'input',
				'size' => '8',
				'max' => '12',
				'eval' => 'int',
				'default' => 0
			)
		),
		'votes' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.rating.votes',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_thrating_domain_model_vote',
				'foreign_field' => 'rating',
				'foreign_sortby' => 'uid',
				'maxitems'      => 999999,
				'appearance' => array(
					'levelLinksPosition' => 'bottom',
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			),
		),
		'currentrates' => Array (
			'label'   => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.rating.currentrates',
			'config' => Array (
				'type'		=> '',
				'size'		=> '30',
			)
		),		
		'uid' => array(
			'label'   => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.rating.uid',
		),
		),
	'types' => array(
		'1' => array('showitem' => 'hidden, ratedobjectuid, votes')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>