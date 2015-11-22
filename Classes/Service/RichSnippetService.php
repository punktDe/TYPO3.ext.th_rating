<?php
namespace Thucke\ThRating\Service;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
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
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The voter
 */
class RichSnippetService extends \Thucke\ThRating\Service\AbstractExtensionService {

	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var array
	 */
	protected $richSnippetConfig;

	/**
	 * @param string $ajaxRef
	 * @param array	$setting
	 * @return boolean
	 */
	public function setRichSnippetConfig(array $settings) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'setRichSnippetConfig Entry point', $settings);
		$this->richSnippetConfig['tablename'] = $settings['ratetable'];
		$this->richSnippetConfig['richSnippetFields'] = $settings['richSnippetFields'];
		$this->url = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL');  //set url pointing to current page

		if (is_array($this->richSnippetConfig['richSnippetFields'])) {
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'setRichSnippetConfig Exit point', $this->richSnippetConfig['richSnippetFields']);
			return true;
		} else {
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'setRichSnippetConfig Exit point', array());
			return false;
		}
	}
	
	/**
	 * @return string
	 */
	public function getRichSnippetConfig() {
		return json_encode($this->richSnippetConfig);
	}
	
	/**
	 * @param string
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param int $uid
	 * @return string
	 */
	public function getRichSnippetObject($uid) {
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'getRichSnippetObject Entry point', array());
		if (empty($this->richSnippetConfig['richSnippetFields']['name'])) {
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'No name field defined - skipping database access', $row);
			unset($this->name);
			unset($this->description);
		} else {
			$databaseConnection = $this->getDatabaseConnection();
			//fetch whole row from database
			$row = $databaseConnection->exec_SELECTgetSingleRow('*', $this->richSnippetConfig['tablename'], 'uid='.$uid);
			$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Data fetched', $row);
			$this->name = $row[$this->richSnippetConfig['richSnippetFields']['name']];
			$this->description = $row[$this->richSnippetConfig['richSnippetFields']['description']];
		}
		$this->logger->log(	\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'getRichSnippetObject Exit point', (array) $this);
		return $this;
	}

	/**
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		/** @var \TYPO3\CMS\Core\Database\DatabaseConnection $TYPO3_DB */
		global $TYPO3_DB;
		
		return $TYPO3_DB;
	}
}
?>