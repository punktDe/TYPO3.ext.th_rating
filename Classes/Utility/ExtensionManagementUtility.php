<?php
namespace Thucke\ThRating\Utility;
/***************************************************************
*  Copyright notice
*
*  (c) 2013 Thomas Hucke <thucke@web.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General protected License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General protected License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General protected License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Factory for model objects
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU protected License, version 2
 */
class ExtensionManagementUtility implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Thucke\ThRating\Service\ObjectFactoryService $objectFactoryService
	 */
	protected $objectFactoryService;
	/**
	 * @param	\Thucke\ThRating\Service\ObjectFactoryService $objectFactoryService
	 * @return	void
	 */
	public function injectObjectFactoryService( \Thucke\ThRating\Service\ObjectFactoryService $objectFactoryService ) {
		$this->objectFactoryService = $objectFactoryService;
	}
	/**
	 * @var $logger \TYPO3\CMS\Core\Log\Logger
	 */
	protected $logger;

	/**
	 * Constructor
	 * @return void
	 */
	public function __construct(  ) {
		//instantiate the logger
		$this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')->get('Thucke\\ThRating\\Service\\ObjectFactoryService')->getLogger(__CLASS__);
	}

	
	/**
	 * Prepares an object for ratings
	 * 
	 * @param	string	$tablename
	 * @param	string	$fieldname
	 * @param	int		$stepcount
	 * @return	\Thucke\ThRating\Domain\Model\Ratingobject
	 */
	public function makeRatable( $tablename, $fieldname, $stepcount ) {
		$this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, 'makeRatable called', array('tablename' => $tablename, 'fieldname' => $fieldname, 'stepcount' => $stepcount));
		$ratingobject = $this->objectFactoryService->getRatingobject( array('ratetable'=>$tablename, 'ratefield'=>$fieldname) );
		
		//create a new default stepconf having stepweight 1 for each step
		for ( $i=1; $i<=$stepcount; $i++) {
			$stepconfArray = array(
				'ratingobject' 	=> $ratingobject,
				'steporder'		=> $i,
				'stepweight'	=> 1 );
			$stepconf = $this->objectFactoryService->createStepconf($stepconfArray);
			$ratingobject->addStepconf($stepconf);
		}
		return $ratingobject;
	}			

	/**
	 * Prepares an object for ratings
	 * 
	 * @param	\Thucke\ThRating\Domain\Model\Stepconf	$stepconf
	 * @param	string	$stepname
	 * @param	int		$languageIso2Code
	 * @param	bool	$allStepconfs	Take stepname for all steps and add steporder number at the end
	 * @return	void
	 */
	public function setStepname( \Thucke\ThRating\Domain\Model\Stepconf $stepconf, $stepname, $languageIso2Code=0, $allStepconfs=FALSE ) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO,
							'setStepname called',
							array(
								'stepconf' => $stepconf->getUid(),
								'steporder' => $stepconf->getSteporder(),
								'stepname' => $stepname,
								'languageIso2Code' => $languageIso2Code,
								'allStepconfs' => $allStepconfs));
		$success = TRUE;
		If ( !$allStepconfs ) {
			//only add the one specific stepname
			$stepnameArray = array(
				'stepname'	=> $stepname,
				'languageIso2Code'	=> $languageIso2Code );
			$stepname = $this->objectFactoryService->createStepname($stepnameArray);
			If ( !$stepconf->addStepname($stepname) ) {
				$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::WARNING,
									'Stepname entry for language already exists', 
									array(
										'stepconf' => $stepconf->getUid(),
										'steporder' => $stepconf->getSteporder(),
										'stepname' => $stepname,
										'languageIso2Code' => $languageIso2Code,
										'errorCode' => 1398972827
									));
				$success = FALSE;
			}
		} else {
			$ratingobject = $stepconf->getRatingobject();
			//add stepnames to every stepconf
			foreach ( $ratingobject->getStepconfs() as $i => $loopStepConf ) {
				$stepnameArray = array(
					'stepname'	=> $stepname.$loopStepConf->getSteporder(),
					'languageIso2Code'	=> $languageIso2Code );
				$stepnameObject = $this->objectFactoryService->createStepname($stepnameArray);
				If ( !$loopStepConf->addStepname($stepnameObject) && $success ) {
					$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::WARNING,
										'Stepname entry for language already exists',
										array(
											'stepconf' => $stepconf->getUid(),
											'steporder' => $stepconf->getSteporder(),
											'stepname' => $stepname,
											'languageIso2Code' => $languageIso2Code,
											'errorCode' => 1398972331
										));
					$success = FALSE;
				}
			}
		}
		return $success;
	}			
}
?>