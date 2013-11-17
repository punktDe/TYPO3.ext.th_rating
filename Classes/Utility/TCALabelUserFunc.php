<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013 Thomas Hucke <thucke@web.de> 
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * The backend helper function class
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_ThRating_Utility_TCALabelUserFunc {

	/**
	 * Returns the record title for the rating object in BE
	 *
	 * @return byRef $params
	 */
	public function getRatingObjectRecordTitle($params, $pObj) {
        $params['title'] = '#'.$params['row']['uid'].': '.$params['row']['ratetable'].' ['.$params['row']['ratefield'].']';
    }

	/**
	 * Returns the record title for the step configuration in BE
	 *
	 * @return byRef $params
	 */
    public function getStepconfRecordTitle($params, $pObj) {
        $params['title'] = '#'.$params['row']['uid']. ': Steporder ['.$params['row']['steporder'].']';
    }

	/**
	 * Returns the record title for the step configuration name in BE
	 *
	 * @return byRef $params
	 */
    public function getStepnameRecordTitle($params, $pObj) {
		//look into repository to find clear text object attributes
		$stepnameRepository = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_ThRating_Domain_Repository_StepnameRepository');
        $stepnameRepository->clearQuerySettings();	//disable syslanguage and enableFields
        $stepnameObject = $stepnameRepository->findByUid(intval($params['row']['uid']));		
		if (is_object($stepnameObject)) {
			$stepnameLang = $stepnameObject->get_languageUid();
			If (empty($stepnameLang)) {
				$syslang = 'Default';
			} elseif ($stepnameLang == -1) {
				$syslang = 'All';
			} else {
				//look for language name
				$syslangRepository = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_ThRating_Domain_Repository_StepnameRepository');
				$syslangObject = $syslangRepository->findByUid($stepnameLang);
				If ($syslangObject instanceOf Tx_ThRating_Domain_Model_Syslang) {
					$syslang=$syslangObject->getTitle();
				} else {
					$syslang='UNKNOWN';
				}
			}
		} else {
			$stepnameLang = 'new';
		}
		$stepconfRepository = Tx_ThRating_Service_ObjectFactoryService::getObject('Tx_ThRating_Domain_Repository_StepconfRepository');
        $stepconfObject = $stepconfRepository->findByUid(intval($params['row']['stepconf']));
		if ($stepconfObject instanceOf Tx_ThRating_Domain_Model_Stepconf) {
			$ratetable = $stepconfObject->getRatingobject()->getRatetable();
			$ratefield = $stepconfObject->getRatingobject()->getRatefield();
			$steporder = $stepconfObject->getSteporder();
		} else {
			$ratetable = 'new';
			$ratefield = 'new';
			$steporder = 'new';
		}
        $params['title'] = $ratetable.'['.$ratefield.']/Step '.$steporder.'/'.$syslang;
    }

	/**
	 * Returns the record title for the rating in BE
	 *
	 * @return byRef $params
	 */
    public function getRatingRecordTitle($params, $pObj) {
        $params['title'] = '#'.$params['row']['uid']. ': RowUid ['.$params['row']['ratedobjectuid'].']';
    }

	/**
	 * Returns the record title for the rating in BE
	 *
	 * @return byRef $params
	 */
    public function getVoteRecordTitle($params, $pObj) {
        $params['title'] = 'Voteuser Uid ['.$params['row']['voter'].']';
    }
    
	/**
	 * Processings when cache is cleared
	 * 1. Delete the file 'typo3temp/thratingDyn.css'
	 *
	 * @return void
	 */
    public function clearCachePostProc($_funcRef,$params, $pObj=NULL) {
    	if (file_exists(PATH_site.'typo3temp/thratingDyn.css'))
    		unlink( PATH_site.'typo3temp/thratingDyn.css');
		//recreate file with zero length - so its still included via TS
		$fp = fopen ( PATH_site.'typo3temp/thratingDyn.css', 'w' );
		fwrite ( $fp, '');
		fclose ( $fp );
	}

	/**
	 * Returns all configured ratinglink display types for flexform
	 *
	 * @param	array	$config
	 * @return 	array	ratinglink configurations
	 */
	public function dynFlexRatinglinkConfig($config) {
		//t3lib_utility_Debug::debug($config,'config');		
		$settings = $this->loadTypoScriptForBEModule('tx_thrating', $config['row']['pid']);
		$ratingconfigs = $settings['settings.']['ratingConfigurations.'];
		$optionList = array();
		// add first option
		$optionList[0] = array(0 => 'Default', 1 => $ratingconfigs['default']);
		foreach ( $ratingconfigs as $configKey => $configValue ) {
			$lastDot = strrpos( $configKey, '.' );
			if ( $lastDot ) {
				$name = substr($configKey, 0, $lastDot);
				// add option
				$optionList[] = array(0 => $name, 1 => $name);
			}
		}
		$config['items'] = array_merge($config['items'], $optionList);		
		return $config;
	}
	
	
	/**
	 * Loads the TypoScript for the given extension prefix, e.g. tx_cspuppyfunctions_pi1, for use in a backend module.
	 *
	 * @param 	string 	$extKey	Extension key to look for config
	 * @param	int		$pid	pageUid 
	 * @return 	array
	 */
	function loadTypoScriptForBEModule($extKey,$pid) {
		$sysPageObj = t3lib_div::makeInstance('t3lib_pageSelect');
        $rootLine = $sysPageObj->getRootLine($pid);
        $TSObj = t3lib_div::makeInstance('t3lib_tsparser_ext');
        $TSObj->tt_track = 0;
        $TSObj->init();
        $TSObj->runThroughTemplates($rootLine);
        $TSObj->generateConfig();
        return $TSObj->setup['plugin.'][$extKey.'.'];
	}
}
?>