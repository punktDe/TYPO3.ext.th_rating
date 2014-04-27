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
 * A validator for Ratings
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @scope singleton
 */
class RatingValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * If the given Rating is valid
	 *
	 * @param \Thucke\ThRating\Domain\Model\Rating $rating The rating
	 * @return boolean true
	 */
	public function isValid($rating) {
		//a rating object must be given
		if (!$rating instanceof \Thucke\ThRating\Domain\Model\Rating) {
			return FALSE;
		} 
		$ratedobjectuid = $rating->getRatedobjectuid();
		if (empty($ratedobjectuid)) {
			$this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.rating.ratedobjectuid', 'ThRating'), 1283536994);
			return FALSE;
		}
		if (!$rating->getRatingobject() instanceof \Thucke\ThRating\Domain\Model\Ratingobject) {
			$this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.rating.ratingobject', 'ThRating'), 1283538549);
			return FALSE;
		}
		return TRUE;
	}
}
?>