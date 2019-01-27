<?php
namespace Thucke\ThRating\Service;
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
class LoggingService {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;
	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * Constructor
	 * Must overrule the abstract class method to avoid self referencing
	 * @param	\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 * @param	\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager, 
	 * @return void
	 */
	public function __construct(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager, 
								\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$this->objectManager = $objectManager;
		$this->configurationManager = $configurationManager;		
	}

	/**
	 * Get a logger instance
	 * The configuration of the logger is modified by extension typoscript config
	 *
	 * @param	string	$name the class name which this logger is for
	 * @return 	\TYPO3\CMS\Core\Log\Logger
	 */
	public function getLogger( $name ) {
		$writerConfiguration = $GLOBALS['TYPO3_CONF_VARS']['LOG']['Thucke']['ThRating']['writerConfiguration'];
		$settings = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,'thRating','pi1');
		If ( is_array($settings['logging']) ){
			foreach ($settings['logging'] as $logLevel => $logConfig) {
				$levelUppercase = strtoupper($logLevel);
				If ( !empty($logConfig['file']) ) {
					$writerConfiguration[constant('\TYPO3\CMS\Core\Log\LogLevel::'.$levelUppercase)]['TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter'] = 
						['logFile' => $logConfig['file']];
				}
				If ( !empty($logConfig['database']) ) {
					$writerConfiguration[constant('\TYPO3\CMS\Core\Log\LogLevel::'.$levelUppercase)]['TYPO3\\CMS\\Core\\Log\\Writer\\Database'] = 
						['table' => $logConfig['table']];
				}
			}
		}
		$GLOBALS['TYPO3_CONF_VARS']['LOG']['Thucke']['ThRating']['writerConfiguration'] = $writerConfiguration;
		$logger = $this->objectManager->get('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger( $name );
		return $logger;
	}
	
}
