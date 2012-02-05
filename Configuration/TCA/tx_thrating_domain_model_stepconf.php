<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_thrating_domain_model_stepconf'] = array(
	'ctrl' => $TCA['tx_thrating_domain_model_stepconf']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, steporder, stepweight, stepname'
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
			'label'   => 'Rating Object',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_thrating_domain_model_ratingobject',
				'maxitems' => 1,
				'minitems' => 1,
				'disableNoMatchingValueElement' => 1
			)
		),		
		'steporder' => Array (
			'label'		=> 'Ratingstep order',
			'config'=> Array (
				'type'		=> 'input',
				'size'		=> '8',
				'max'		=> '12',
				'eval'		=> 'tx_thrating_unlinkDynCss_eval,int,required',
				'default'	=> 0,
				'range'		=> array('lower' => 1)
			)
		),
		'stepweight' => Array (
			'label' => 'Ratingstep weight',
			'config' => Array (
				'type'		=> 'input',
				'size'		=> '8',
				'max'		=> '12',
				'eval'		=> 'tx_thrating_unlinkDynCss_eval,int',
			)
		),
		'stepname' => Array (
			'label' => 'Ratingstep name',
			'config' => Array (
				'type'		=> 'input',
				'size'		=> '15',
				'max'		=> '60',
				'eval'		=> 'trim,alphanum_x',
			)
		),
		'votes' => array(
			'label'   => 'Assigned votes',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_thrating_domain_model_vote',
				'foreign_field' => 'vote',
				'foreign_sortby' => 'uid',
				'maxitems'      => 999999,
				'appearance' => array(
					'levelLinksPosition' => 'bottom',
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			),
		),
		'uid' => array(
			'label'   => 'Ratingstep configuration list',
			'config' => array(
				'type' => 'passthrough',
			)
		),
		),
	'types' => array(
		'1' => array('showitem' => 'hidden, steporder, stepweight, stepname, votes')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>