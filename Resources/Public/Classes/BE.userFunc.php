<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Thomas Hucke <thucke@web.de> 
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
class user_BEfunc {

	/**
	 * Returns the record title for the rating object in BE
	 *
	 * @return byRef $params
	 */
	public function getRatingObjectRecordTitle($params, $pObj) {
        $params['title'] = $params['row']['ratetable'].' ['.$params['row']['ratefield'].']';
    }

	/**
	 * Returns the record title for the rating in BE
	 *
	 * @return byRef $params
	 */
    public function getStepconfRecordTitle($params, $pObj) {
        $params['title'] = 'Ratingstep ['.$params['row']['steporder'].']';
    }

	 /**
	 * Returns the record title for the rating in BE
	 *
	 * @return byRef $params
	 */
    public function getRatingRecordTitle($params, $pObj) {
        $params['title'] = 'Row Uid ['.$params['row']['ratedobjectuid'].']';
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
    public function clearCachePostProc($_funcRef,$params, $pObj) {
    	if (file_exists(PATH_site.'typo3temp/thratingDyn.css'))
    		unlink( PATH_site.'typo3temp/thratingDyn.css');
			//recreate file with zero length - so its still included via TS
			$fp = fopen ( PATH_site.'typo3temp/thratingDyn.css', 'w' );
			fwrite ( $fp, '');
			fclose ( $fp );
		}
}
?>