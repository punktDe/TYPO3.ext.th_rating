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
			'label'   => 'LLL:EXT:Resources/Private/Language/locallang.xml:TCA.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'ratingobject' => Array (		
			'exclude' => 1,		
			'label'   => 'Rating Object',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_thrating_domain_model_ratingobject',
				'maxitems' => 1,
				'minitems' => 1,
				'disableNoMatchingValueElement' => 1
			)
		),		
		'ratedobjectuid' => Array (
			'label' => 'Rated Object Uid',
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
			'label'   => 'Votes',
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
			'label' => 'Calculated values',
			'config' => Array (
				'type'		=> '',
				'size'		=> '30',
			)
		),		
		'uid' => array(
			'label'   => 'Rating list',
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