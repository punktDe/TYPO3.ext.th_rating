<?php
namespace Thucke\ThRating\Utility;

/*
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
 * Localization helper which should be used to fetch localized labels.
 *
 * @api
 */
class LocalizationUtility extends \TYPO3\CMS\Extbase\Utility\LocalizationUtility {

    /**
     * Returns the localized label of the LOCAL_LANG key, $key.
     *
     * @param string $extensionName The name of the extension
     * @return string|NULL The value from LOCAL_LANG or NULL if no translation was found.
     * @api
     * @todo : If vsprintf gets a malformed string, it returns false! Should we throw an exception there?
     */
	static public function getLangArray($extensionName) {
		self::initializeLocalization($extensionName);
		// The "from" charset of csConv() is only set for strings from TypoScript via _LOCAL_LANG
		if (!empty(self::$alternativeLanguageKeys)) {
			$languages = array_reverse(self::$alternativeLanguageKeys);
			foreach ($languages as $language) {
				if (is_array(self::$LOCAL_LANG[$extensionName][$language])) {
					// Alternative language translation exists
					self::$LOCAL_LANG[$extensionName] = array_merge(self::$LOCAL_LANG[$extensionName][$language], self::$LOCAL_LANG[$extensionName]);
				}
			}
		}
		self::$LOCAL_LANG[$extensionName] = array_merge(self::$LOCAL_LANG[$extensionName]['default'], self::$LOCAL_LANG[$extensionName]);
		return self::$LOCAL_LANG[$extensionName];
	}
}
