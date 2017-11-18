<?php
namespace Thucke\ThRating\Userfuncs;
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
class Tca {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;
	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface	$objectManager
	 * @return void
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}
	
	/**
	 * Constructs a new rating object
	 * @return void
	 */
	public function __construct( ) {
		if ( empty($this->objectManager) ) {
			$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		}
	}

	/**
	 * Returns the record title for the rating object in BE
	 * Note that values of $params are modified by reference
	 * 
	 * @return void
	 */
	public function getRatingObjectRecordTitle(&$params, &$pObj) {
        $params['title'] = '#'.$params['row']['uid'].': '.$params['row']['ratetable'].' ['.$params['row']['ratefield'].']';
    }

	/**
	 * Returns the record title for the step configuration in BE
	 * Note that values of $params are modified by reference
	 * 
	 * @return void
	 */
    public function getStepconfRecordTitle(&$params, &$pObj) {
        $params['title'] = '#'.$params['row']['uid']. ': Steporder ['.$params['row']['steporder'].']';
    }

	/**
	 * Returns the record title for the step configuration name in BE
	 * Note that values of $params are modified by reference
	 * 
	 * @return void
	 */
    public function getStepnameRecordTitle(&$params, &$pObj) {
		//look into repository to find clear text object attributes
		$stepnameRepository = $this->objectManager->get('Thucke\\ThRating\\Domain\\Repository\\StepnameRepository');
        $stepnameRepository->clearQuerySettings();	//disable syslanguage and enableFields
        $stepnameObject = $stepnameRepository->findByUid(intval($params['row']['uid']));		
		if (is_object($stepnameObject)) {
			$stepnameLang = $stepnameObject->get_languageUid();
			If (empty($stepnameLang)) {
				$syslang = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tca.BE.default', 'ThRating');
			} elseif ($stepnameLang == -1) {
				$syslang = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tca.BE.all', 'ThRating');
			} else {
				//look for language name
				$syslangRepository = $this->objectManager->get('Thucke\\ThRating\\Domain\\Repository\\StepnameRepository');
				$syslangObject = $syslangRepository->findByUid($stepnameLang);
				If ($syslangObject instanceof \Thucke\ThRating\Domain\Model\Syslang) {
					$syslang=$syslangObject->getTitle();
				} else {
					$syslang = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tca.BE.unknown', 'ThRating');
				}
			}
		} else {
			$stepnameLang = 'new';
		}
		$stepconfRepository = $this->objectManager->get('Thucke\\ThRating\\Domain\\Repository\\StepconfRepository');
        $stepconfObject = $stepconfRepository->findByUid(intval($params['row']['stepconf']));
		$ratetable = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tca.BE.new', 'ThRating');
		$ratefield = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tca.BE.new', 'ThRating');
		$steporder = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tca.BE.new', 'ThRating');
		if ($stepconfObject instanceof \Thucke\ThRating\Domain\Model\Stepconf) {
			$ratingObject = $stepconfObject->getRatingobject();
			if ($ratingObject instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
				$ratingObject = $ratingObject->_loadRealInstance();
			}
			if ($ratingObject instanceof \Thucke\ThRating\Domain\Model\Ratingobject) {
				$ratetable = $ratingObject->getRatetable();
				$ratefield = $ratingObject->getRatefield();
				$steporder = $stepconfObject->getSteporder();
			}
		}
        $params['title'] = $ratetable.'['.$ratefield.']/Step '.$steporder.'/'.$syslang;
    }

	/**
	 * Returns the record title for the rating in BE
	 * Note that values of $params are modified by reference
	 * 
	 * @return void
	 */
    public function getRatingRecordTitle(&$params, &$pObj) {
        $params['title'] = '#'.$params['row']['uid']. ': RowUid ['.$params['row']['ratedobjectuid'].']';
    }

	/**
	 * Returns the record title for the rating in BE
	 * Note that values of $params are modified by reference
	 * 
	 * @return void
	 */
    public function getVoteRecordTitle(&$params, &$pObj) {
        $params['title'] = 'Voteuser Uid ['.$params['row']['voter'].']';
    }
    
	/**
	 * Returns all configured ratinglink display types for flexform
	 *
	 * @param	array	$config
	 * @return 	array	ratinglink configurations
	 */
	public function dynFlexRatinglinkConfig($config) {
		//\TYPO3\CMS\Core\Utility\DebugUtility::debug($config,'config');
		if ( \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) < 7006000 ) {
			$flexFormPid = $config['row']['pid'];
		} else {
			$flexFormPid = $config['flexParentDatabaseRow']['pid'];
		}
		$settings = $this->loadTypoScriptForBEModule('tx_thrating', $flexFormPid);
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
		$sysPageObj = $this->objectManager->get('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        $rootLine = $sysPageObj->getRootLine($pid);
        $TSObj = $this->objectManager->get('TYPO3\\CMS\\Core\\TypoScript\\ExtendedTemplateService');
        $TSObj->tt_track = 0;
        $TSObj->init();
        $TSObj->runThroughTemplates($rootLine);
        $TSObj->generateConfig();
        return $TSObj->setup['plugin.'][$extKey.'.'];
	}
}
?>