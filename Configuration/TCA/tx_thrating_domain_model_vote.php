<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_thrating_domain_model_vote'] = array(
	'ctrl' => $TCA['tx_thrating_domain_model_vote']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, rating, voter, vote'
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
		'rating' => Array (		
			'exclude' => 1,		
			'label'   => 'Rating',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_thrating_domain_model_rating',
				'maxitems' => 1,
				'minitems' => 1,
				'disableNoMatchingValueElement' => 1
			)
		),		
		'voter' => Array (
			'label' => 'FE User',
			'config' => Array (
				'type' => 'select',
				'items'	=> Array (
					Array ('--div--',0),
				),
				'foreign_table' => 'fe_users',
				'maxitems' => 1,
			),
		),
		//TODO	Prio 3: only provide valid references from foreign table
		'vote' => Array (
			'label' => 'Vote',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_thrating_domain_model_stepconf',
				'maxitems' => 1,
				'minitems' => 1,
				'disableNoMatchingValueElement' => 1
			)
		),
		'uid' => array(
			'label'   => 'Vote list',
		),
		),
	'types' => array(
		'1' => array('showitem' => 'hidden, rating, voter, vote'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);
?>