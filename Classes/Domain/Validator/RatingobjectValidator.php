<?php
namespace Thucke\ThRating\Domain\Validator;
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Thomas Hucke <thucke@web.de> 
*  All rights reserved
*
*  This class is a backport of the corresponding class of FLOW3.
*  All credits go to the v5 team.
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
 * A validator for Ratingobjects
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective author
 * @scope singleton
 */
class RatingobjectValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * If the given Ratingobject is valid
	 *
	 * @param \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject The ratingobject
	 * @return void
	 */
	public function isValid($ratingobject) {
		$ratetable = $ratingobject->getRatetable();
		$ratefield = $ratingobject->getRatefield();
		if (empty($ratetable)) {
			$this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.ratingobject_table_extbase', 'ThRating'), 1283528638);
		}
		if (empty($ratefield)) {
			$this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.ratingobject_field_extbase', 'ThRating'), 1283536038);
		}
	}
}
?>