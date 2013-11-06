<?php

if (!defined ('TYPO3_MODE')) die ('Access denied.');

include_once(t3lib_extMgm::extPath($_EXTKEY) . 'Resources/Private/PHP/BE.userFunc.php');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,	// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	'Pi1',		// A unique name of the plugin in UpperCamelCase
	'Rating AX'	// A title shown in the backend dropdown field
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Rating AX');

t3lib_extMgm::allowTableOnStandardPages('tx_thrating_domain_model_ratingobject');
$TCA['tx_thrating_domain_model_ratingobject'] = array (
	'ctrl' => array (
		'title'				=> 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.ratingobject.title',
		'label'				=> 'uid',
		'label_alt'			=> 'ratetable,ratefield',
 		'label_userFunc'	=> 'user_BEfunc->getRatingObjectRecordTitle',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'cruser_id'			=> 'cruser_id',
		'delete'			=> 'deleted',
		'enablecolumns'		=> array(
			'disabled'	=> 'hidden'
			),
		'dynamicConfigFile'	=> t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tx_thrating_domain_model_ratingobject.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_thrating_domain_model_ratingobject.gif'
	)
);

//t3lib_extMgm::allowTableOnStandardPages('tx_thrating_domain_model_stepconf');
$TCA['tx_thrating_domain_model_stepconf'] = array (
	'ctrl' => array (
		'title'						=> 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.stepconf.title',
		'label'						=> 'uid',
		'label_alt' 				=> 'ratingobject,steporder',
 		'label_userFunc' 			=> 'user_BEfunc->getStepconfRecordTitle',
		'type'						=> '1',
		'tstamp'					=> 'tstamp',
		'crdate'					=> 'crdate',
		'cruser_id'					=> 'cruser_id',
		'delete'					=> 'deleted',
		'adminOnly'					=> FALSE,
		'hideTable'					=> FALSE,
		'editlock'					=> 'steporder,stepweight',
		'dividers2tabs'				=> TRUE,
		'enablecolumns'				=> array( 'disabled'	=> 'hidden' ),
		'dynamicConfigFile'	=> t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tx_thrating_domain_model_stepconf.php',
		'iconfile'			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_thrating_domain_model_stepconf.gif',
	)
);

//t3lib_extMgm::allowTableOnStandardPages('tx_thrating_domain_model_stepname');
$TCA['tx_thrating_domain_model_stepname'] = array (
	'ctrl' => array (
		'title'						=> 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.stepname.title',
		'label'						=> 'uid',
		'label_alt' 				=> 'stepconf,sys_language_uid',
 		'label_userFunc' 			=> 'user_BEfunc->getStepnameRecordTitle',
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
		'dynamicConfigFile'	=> t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tx_thrating_domain_model_stepname.php',
		'iconfile'			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_thrating_domain_model_stepname.gif',
	)
);

//t3lib_extMgm::allowTableOnStandardPages('tx_thrating_domain_model_rating');
$TCA['tx_thrating_domain_model_rating'] = array (
	'ctrl' => array (
		'title'				=> 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.rating.title',
		'label'				=> 'uid',
		'label_alt'			=> 'ratingobject,ratedobjectuid,votes',
 		'label_userFunc'	=> 'user_BEfunc->getRatingRecordTitle',
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
		'dynamicConfigFile'	=> t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tx_thrating_domain_model_rating.php',
		'iconfile'				=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_thrating_domain_model_rating.gif'
	)
);

//t3lib_extMgm::allowTableOnStandardPages('tx_thrating_domain_model_vote');
$TCA['tx_thrating_domain_model_vote'] = array (
	'ctrl' => array (
		'title'				=> 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang.xlf:tca.model.vote.title',
		'label'				=> 'uid',
		'label_alt'			=> 'rating,fe_user,vote',
 		'label_userFunc'	=> 'user_BEfunc->getVoteRecordTitle',
		'tstamp'			=> 'tstamp',
		'crdate'			=> 'crdate',
		'cruser_id'			=> 'cruser_id',
		'delete'			=> 'deleted',
		'adminOnly'			=> TRUE,
		'hideTable'			=> TRUE,
		'editlock'			=> 'rating',
		'enablecolumns'	=> array(
			'disabled'		=> 'hidden'
			),
		'dynamicConfigFile'	=> t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tx_thrating_domain_model_vote.php',
		'iconfile'			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_thrating_domain_model_vote.gif'
	)
);

$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,recursive,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/Flexforms/flexform_pi1.xml');
?>