<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_thrating_domain_model_stepconf'] = array(
	'ctrl' => $TCA['tx_thrating_domain_model_stepconf']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, ratingobject, steporder, stepweight, stepname'
	),
	'columns' => array(
		'pid' => Array (  
			'exclude' => 1,
			'config' => Array (
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
		'ratingobject' 	=> Array (		
			'exclude'	=> 1,		
			'label'  	=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.ratingobject',
			'config' 	=> Array (
				'type'		=> 'passthrough',
			),
		),		
		'steporder' => Array (
			'label'   		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.steporder',
			'l10n_display'	=> 'defaultAsReadonly',
			//'l10n_cat'		=> 'media',
			'config'=> Array (
				'type'		=> 'input',
				'size'		=> '8',
				'max'		=> '12',
				'eval'		=> 'tx_thrating_unlinkDynCss_eval,int,required',
				'default'	=> 0,
				'range'		=> array('lower' => 1)
			),
		),
		'stepweight' => Array (
			'label'   		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.stepweight',
			'l10n_display'	=> 'defaultAsReadonly',
			//'l10n_cat'		=> 'media',
			'config' 		=> Array (
				'type'	=> 'input',
				'size'	=> '8',
				'max'	=> '12',
				'eval'	=> 'tx_thrating_unlinkDynCss_eval,int',
			),
		),
		'stepname' => Array (
			'label'  		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepconf.stepname',
			'l10n_mode'		=> 'prefixLangTitle ',
			'l10n_display'	=> 'hideDiff ',
			'config' => Array (
				'type'		=> 'input',
				'size'		=> '15',
				'max'		=> '60',
				'eval'		=> 'trim',
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
				'foreign_sortby' 	=> 'uid',
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
		'sys_language_uid' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'readOnly'				=> true,
				'type'                	=> 'select',
				'foreign_table'       	=> 'sys_language',
				'foreign_table_where' 	=> 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l18n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_thrating_domain_model_stepconf',
				'foreign_table_where' => 'AND tx_thrating_domain_model_stepconf.uid=###REC_FIELD_l18n_parent### AND tx_thrating_domain_model_stepconf.sys_language_uid IN (-1,0)',
			),
		),
		'l18n_diffsource' => array (
			'config' => array (
				'type' => 'passthrough'
			),
		),
	),
	'types' => array(
		'0' => Array('showitem' => '--div--;Display,sys_language_uid,stepname,--div--;Rating,steporder, stepweight,votes,--div--;General,hidden'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
);
?>