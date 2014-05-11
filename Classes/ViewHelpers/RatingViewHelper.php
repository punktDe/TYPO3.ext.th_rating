<?php
namespace Thucke\ThRating\ViewHelpers;
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
 * The Rating Viewhelper
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class RatingViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\CObjectViewHelper {
	
	/**
	 * @var \Thucke\ThRating\Service\AccessControlService
	 */
	protected $logger;
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
	 * Renders the rating object
	 *
	 * @param string $action the controller action that should be used (ratinglinks, show, new )
	 * @param \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject
	 * @param string $ratetable
	 * @param string $ratefield
	 * @param integer $ratedobjectuid
	 * @param string $display
	 * @return string the content of the rendered TypoScript object
	 * @author Thomas Hucke <thucke@web.de>
	 */
	public function render($action = NULL, $ratingobject = NULL, $ratetable = NULL, $ratefield = NULL, $ratedobjectuid = NULL, $display = NULL) {
		//instantiate the logger
		$this->logger = $this->objectFactoryService->getLogger(__CLASS__);
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG,
							'Entry point',
							array(
								'Viewhelper parameters' => array (
									'action' => $action,
									'ratingobject' => is_object($ratingobject) ? $ratingobject->getUid() : NULL,
									'ratetable' => $ratetable,
									'ratefield' => $ratefield,
									'ratedobjectuid' => $ratedobjectuid,
									'display' => $display,
								),
								'typoscript' => $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT),
							));

		$typoscriptObjectPath = 'plugin.tx_thrating';
		if (TYPO3_MODE === 'BE') {
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'TYPO3_MODE is BE => simulateFrontendEnvironment', array());
			$this->simulateFrontendEnvironment();
		}

		$cObj = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager')->getContentObject();
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'ContentObject to initialize', 
							array(
								'cObj type' => get_class($cObj),
								'data config' => $cObj->data));
		$cObj->start($cObj->data);

		$pathSegments = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('.', $typoscriptObjectPath);
		$lastSegment = array_pop($pathSegments);
		$setup = $this->typoScriptSetup;
		foreach ($pathSegments as $segment) {
			if (!array_key_exists($segment . '.', $setup)) {
				$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::CRITICAL,
									'TypoScript object path does not exist',
									array(
										'Typoscript object path' => htmlspecialchars($typoscriptObjectPath),
										'Setup' => $setup,
										'errorCode' => 1253191023
									));
				throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('TypoScript object path "' . htmlspecialchars($typoscriptObjectPath) . '" does not exist', 1253191023);
			}
			$setup = $setup[$segment . '.'];
		}
		
		if (!empty($action)) {
			$setup[$lastSegment . '.']['action'] = $action;
			$setup[$lastSegment . '.']['switchableControllerActions.']['Vote.']['1'] = $action;
		}
		if (!empty($ratingobject)) {
			$setup[$lastSegment . '.']['settings.']['ratingobject'] = $ratingobject;
		} elseif ( !empty($ratetable) && !empty($ratefield)) {
			$setup[$lastSegment . '.']['settings.']['ratetable'] = $ratetable;
			$setup[$lastSegment . '.']['settings.']['ratefield'] = $ratefield;
		} else {
				$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, 'ratingobject not specified or ratetable/ratfield not set', array('errorCode' => 1399727698));
				throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('ratingobject not specified or ratetable/ratfield not set', 1399727698);
		}
		if (!empty($ratedobjectuid)) {
			$setup[$lastSegment . '.']['settings.']['ratedobjectuid'] = $ratedobjectuid;
		} else {
				$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, 'ratedobjectuid not set', array('errorCode' => 1304624408));
				throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception('ratedobjectuid not set', 1304624408);
		}
		if (!empty($display)) {
			$setup[$lastSegment . '.']['settings.']['display'] = $display;
		}
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Single contentObject to get',
							array(
								'cObj type' => $setup[$lastSegment],
								'cOjb config' => $setup[$lastSegment . '.']));
		$content = $cObj->cObjGetSingle($setup[$lastSegment], $setup[$lastSegment . '.']);
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::INFO, 'Generated content', array('content' => $content));

		if (TYPO3_MODE === 'BE') {
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'TYPO3_MODE is BE => resetFrontendEnvironment', array());
			$this->resetFrontendEnvironment();
		}

		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit point', array());
		return $content;
	}	
	
}
?>