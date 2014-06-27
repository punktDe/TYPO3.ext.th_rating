<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$GLOBALS['TCA']['tx_thrating_domain_model_stepname'] = array(
	'ctrl' => array (
		'title'						=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepname.title',
		'label'						=> 'uid',
		'label_alt' 				=> 'stepconf,sys_language_uid',
 		'label_userFunc' 			=> 'Thucke\\ThRating\\Utility\\TCALabelUserFuncUtility->getStepnameRecordTitle',
		'type'						=> '1',
		'tstamp'					=> 'tstamp',
		'crdate'					=> 'crdate',
		'cruser_id'					=> 'cruser_id',
		'languageField'           	=> 'sys_language_uid',
		'transOrigPointerField'    	=> 'l18n_parent',
		'transOrigDiffSourceField'	=> 'l18n_diffsource',
		'delete'					=> 'deleted',
		'adminOnly'					=> FALSE,
		'hideTable'					=> FALSE,
		'editlock'					=> 'sys_language_uid,stepconf',
		'dividers2tabs'				=> TRUE,
		'enablecolumns'				=> array( 'disabled'	=> 'hidden' ),
		'iconfile'					=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('th_rating') . 'Resources/Public/Icons/tx_thrating_domain_model_stepname.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, stepconf, stepname'
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
		'stepconf' => Array (
			'label'   		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepname.stepconf',
			'config' 	=> Array (
				'type'		=> 'passthrough',
			),
		),
		'stepname' => Array (
			'label'  		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepname.stepname',
			'l10n_mode'		=> 'prefixLangTitle ',
			'l10n_display'	=> 'hideDiff ',
			'config' => Array (
				'type'		=> 'input',
				'size'		=> '15',
				'max'		=> '64',
				'eval'		=> 'tx_thrating_unlinkDynCss_eval,trim',
			),
		),
		'uid' => array(
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.stepname.uid',
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'sys_language_uid' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'readOnly'				=> FALSE,
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
				'foreign_table'       => 'tx_thrating_domain_model_stepname',
				'foreign_table_where' => 'AND tx_thrating_domain_model_stepname.uid=###REC_FIELD_l18n_parent### AND tx_thrating_domain_model_stepname.sys_language_uid IN (-1,0)',
			),
		),
		'l18n_diffsource' => array (
			'config' => array (
				'type' => 'passthrough'
			),
		),
	),
	'types' => array(
		'0' => Array('showitem' => 'hidden,sys_language_uid,stepname'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
);
return $GLOBALS['TCA']['tx_thrating_domain_model_stepname'];
?>