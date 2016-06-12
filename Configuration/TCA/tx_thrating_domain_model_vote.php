<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$GLOBALS['TCA']['tx_thrating_domain_model_vote'] = array(
	'ctrl' => array (
		'title'				=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.title',
		'label'				=> 'uid',
		'label_alt'			=> 'rating,fe_user,vote',
 		'label_userFunc'	=> 'Thucke\\ThRating\\Service\\TCALabelUserFuncService->getVoteRecordTitle',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'cruser_id'			=> 'cruser_id',
		'delete'			=> 'deleted',
		'adminOnly'			=> true,
		'hideTable'			=> true,
		'editlock'			=> 'rating',
		'enablecolumns'	=> array(
			'disabled'		=> 'hidden'
			),
		'iconfile'			=> 'EXT:th_rating/Resources/Public/Icons/tx_thrating_domain_model_vote.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, rating, voter, vote'
	),
	'columns' => array(
		'pid' => array(
			'exclude' => 1,
			'config' => array(
				'type' => 'none',
			)
		),
		'hidden' => array(
			'exclude' 	=> 1,
			'label'   	=> 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  	=> array(
				'type' 		=> 'check'
			)
		),
		'rating' => array(
			'exclude' 	=> 1,
			'label'		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.rating',
			'config' 	=> array(
				'type' 			=> 'select',
				'renderType' 	=> 'selectSingle',
				'foreign_table' => 'tx_thrating_domain_model_rating',
				'maxitems' 		=> 1,
				'minitems' 		=> 1,
				'disableNoMatchingValueElement' => 1
			)
		),
		'voter' => array(
			'exclude' => 1,
			'label'		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.voter',
			'config' => array(
				'type' => 'select',
				'renderType' 	=> 'selectSingle',
				'foreign_table' => 'fe_users',
				//'foreign_table_where' => 'AND fe_users.pid=###CURRENT_PID###',
				//'foreign_table_where' => 'AND fe_users.disable=0 AND fe_users.deleted=0 ORDER BY username',
				'foreign_table_where' => 'ORDER BY username',
				'items'	=> array(
					array('--div--',0),
				),
				'wizards' => Array(
		             '_PADDING' => 1,
		             '_VERTICAL' => 0,
		             'edit' => Array(
		                 'type' => 'popup',
		                 'title' => 'Edit',
		                 'script' => 'wizard_edit.php',
		                 'icon' => 'edit2.gif',
		                 'popup_onlyOpenIfSelected' => 1,
		                 'JSopenParams' => 'height=650,width=650,status=0,menubar=0,scrollbars=1',
		             ),
		             'add' => Array(
		                 'type' => 'script',
		                 'title' => 'Create new',
		                 'icon' => 'add.gif',
		                 'params' => Array(
		                     'table'=>'fe_users',
		                     'pid' => '###CURRENT_PID###',
		                     'setValue' => 'prepend'
		                 ),
		                 'script' => 'wizard_add.php',
		             ),
		         ),
			),
		),
		//TODO	Prio 3: only provide valid references from foreign table
		'vote' => array(
			'label'		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.vote',
			'config' => array(
				'type' => 'select',
				'renderType' 	=> 'selectSingle',
				'foreign_table' => 'tx_thrating_domain_model_stepconf',
				'maxitems' => 1,
				'minitems' => 1,
				'disableNoMatchingValueElement' => 1
			)
		),
		'uid' => array(
			'label'		=> 'LLL:EXT:th_rating/Resources/Private/Language/locallang.xlf:tca.model.vote.uid',
		),
		),
	'types' => array(
		'1' => array('showitem' => 'hidden, rating, voter, vote'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	)
);
return $GLOBALS['TCA']['tx_thrating_domain_model_vote'];
?>