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
 * The Selectbox Viewhelper
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class SelectViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper {

	
	/**
	 * Renders the rating select form
	 *
	 * @return string the content of the rendered select form object
	 * @author Thomas Hucke <thucke@web.de>
	 */	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('additionalOptions', 'array', 'Associative array with values to prepend', false);
		$this->registerTagAttribute('onchange', 'string', 'Optional event handler');
	}
		
	protected function getOptions() {
		$options = parent::getOptions();
		$additionalOptions = array();
		foreach ($this->arguments['additionalOptions'] as $key => $value) {
			$additionalOptions[utf8_encode('{"value":'.$key.'}')] = $value;
		}
		//TODO delete deprecated $array = \TYPO3\CMS\Core\Utility\GeneralUtility::array_merge($options, $additionalOptions);
		$array = $additionalOptions + $options;
		ksort ($array);
		return $array;
	}
}
?>