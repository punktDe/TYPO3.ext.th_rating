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
	 * @param \Thucke\ThRating\Utility\TCALabelUserFuncUtility $tcaLabelUserFuncUtility
	 */
	public function injectTCALabelUserFuncUtility(\Thucke\ThRating\Utility\TCALabelUserFuncUtility $tcaLabelUserFuncUtility) {
		//... to make static functions of this singleton avaiable
	}

	/**
	 * Set a new properties for a stepconf
	 * 
	 * @param	string	$repository
	 * @param	\TYPO3\CMS\Extbase\DomainObject\AbstractEntity	$objectToPersist
	 * @return	void
	 *
	public function persistObjectIfDirty( $repository, \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $objectToPersist ) {
		If ( $objectToPersist->_isDirty() ) {
			self::persistRepository($repository, $objectToPersist);
		}
	}*/

	/**
	 * Update and persist attached objects to the repository
	 *
	 * @param	string	$repository
	 * @param	\TYPO3\CMS\Extbase\DomainObject\AbstractEntity	$objectToPersist
	 * @return void
	 */
	public function persistRepository( $repository, \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $objectToPersist ) {
		If ( \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 6001000 ) {
			$objectUid=$objectToPersist->getUid();
			If (empty($objectUid)) {
				\Thucke\ThRating\Service\ObjectFactoryService::getObject($repository)->add($objectToPersist);
			} else {
				\Thucke\ThRating\Service\ObjectFactoryService::getObject($repository)->update($objectToPersist);
			}
		}
		\Thucke\ThRating\Service\ObjectFactoryService::getObject('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
		\Thucke\ThRating\Utility\TCALabelUserFuncUtility::clearCachePostProc(NULL, NULL, NULL);  //Delete the file 'typo3temp/thratingDyn.css'
	}


	/**
	 * Prepares an object for ratings
	 * 
	 * @param	string	$tablename
	 * @param	string	$fieldname
	 * @param	int		$stepcount
	 * @return	\Thucke\ThRating\Domain\Model\Ratingobject
	 */
	static function makeRatable( $tablename, $fieldname, $stepcount ) {
		$ratingobject = \Thucke\ThRating\Service\ObjectFactoryService::getRatingobject( array('ratetable'=>$tablename, 'ratefield'=>$fieldname) );
		
		//create a new default stepconf having stepweight 1 for each step
		for ( $i=1; $i<=$stepcount; $i++) {
			$stepconfArray = array(
				'ratingobject' 	=> $ratingobject,
				'steporder'		=> $i,
				'stepweight'	=> 1 );
			$stepconf = \Thucke\ThRating\Service\ObjectFactoryService::createStepconf($stepconfArray);
			$ratingobject->addStepconf($stepconf);
		}
		//self::persistRepository('\Thucke\ThRating\Domain\Repository\RatingobjectRepository', $ratingobject);	
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
	static function setStepname( \Thucke\ThRating\Domain\Model\Stepconf $stepconf, $stepname, $languageIso2Code=0, $allStepconfs=FALSE ) {
		if ( !$allStepconfs ) {
			//only add the one specific stepname
			$stepnameArray = array(
				'stepname'	=> $stepname,
				'languageIso2Code'	=> $languageIso2Code );
			$stepname = \Thucke\ThRating\Service\ObjectFactoryService::createStepname($stepnameArray);
			$stepConf->addStepname($stepname);
			//self::persistRepository('\Thucke\ThRating\Domain\Repository\StepconfRepository', $stepConf);	
		} else {
			$ratingobject = $stepconf->getRatingobject();
			//add stepnames to every stepconf
			foreach ( $ratingobject->getStepconfs() as $i => $loopStepConf ) {
				$stepnameArray = array(
					'stepname'	=> $stepname.$loopStepConf->getSteporder(),
					'languageIso2Code'	=> $languageIso2Code );
				$stepnameObject = \Thucke\ThRating\Service\ObjectFactoryService::createStepname($stepnameArray);
				$loopStepConf->addStepname($stepnameObject);
			}
			//self::persistRepository('\Thucke\ThRating\Domain\Repository\RatingobjectRepository', $ratingobject);	
		}
		return;
	}			
}
?>