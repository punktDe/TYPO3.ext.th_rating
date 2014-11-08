<?php
namespace Thucke\ThRating\Task;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Optimize every table in the database schema
 *
 * @author Thomas Hucke <thucke@web.de>
 */
class DatabaseTableOptimizationTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {

	/**
	 * Execute garbage collection, called by scheduler.
	 *
	 * @throws \RuntimeException if configured table was not cleaned up
	 * @return boolean TRUE if task run was successful
	 */
	public function execute() {
		$allTables = implode(',',$this->retrieveTableNames());
		$sqlCommand = 'optimize tables '.$allTables;
		$queryResult = $GLOBALS['TYPO3_DB']->admin_query($sqlCommand);
		$error = $GLOBALS['TYPO3_DB']->sql_error();
		if ($error) {
			throw new \RuntimeException('Thucke\\ThRating\\Task\\DatabaseTableOptimizationTask failed with error: ' . $error, 1415465729);
		}
		return TRUE;
	}

	/**
	 * Retrieve all table names from the database
	 *
	 * @return array all table names
	 */
	protected function retrieveTableNames() {
		$queryResult = $GLOBALS['TYPO3_DB']->admin_query('show tables');
		$tableArray = array();
		foreach ( $queryResult->fetch_all() as $row) {
			array_push($tableArray , $row[0]);
		}
		return $tableArray;
	}

}
?>