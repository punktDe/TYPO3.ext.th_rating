<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$GLOBALS['TCA']['tx_thrating_domain_model_rating'] = array(
	'ctrl' => array (
		'title'				=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.title',
		'label'				=> 'uid',
		'label_alt'			=> 'ratingobject,ratedobjectuid,votes',
 		'label_userFunc'	=> 'Thucke\\ThRating\\Utility\\TCALabelUserFuncUtility->getRatingRecordTitle',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'cruser_id'			=> 'cruser_id',
		'delete'			=> 'deleted',
		'adminOnly'			=> TRUE,
		'hideTable'			=> TRUE,
		'editlock'			=> 'ratedobjectuid',
		'enablecolumns'		=> array(
			'disabled'	=> 'hidden'
		),
		'iconfile'			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('th_rating') . 'Resources/Public/Icons/tx_thrating_domain_model_rating.gif'
	),
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
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.ratingobject',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'tx_thrating_domain_model_ratingobject',
				'maxitems' => 1,
				'minitems' => 1,
				'disableNoMatchingValueElement' => 1
			)
		),		
		'ratedobjectuid' => Array (
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.ratedobjectuid',
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
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.votes',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_thrating_domain_model_vote',
				'foreign_field' => 'rating',
				'foreign_default_sortby' => 'uid',
				'maxitems'      => 999999,
				'appearance' => array(
					'levelLinksPosition' => 'bottom',
					'collapseAll' => 1,
					'expandSingle' => 1,
				),
			),
		),
		'currentrates' => Array (
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.currentrates',
			'config' => Array (
				'type'		=> 'none',
				'size'		=> '30',
			)
		),		
		'uid' => array(
			'label'   => 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.rating.uid',
		),
		),
	'types' => array(
		'1' => array('showitem' => 'hidden, ratedobjectuid, votes')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
return $GLOBALS['TCA']['tx_thrating_domain_model_rating'];
?>