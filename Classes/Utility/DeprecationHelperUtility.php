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

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Localization helper which should be used to fetch localized labels.
 *
 * @api
 */
class DeprecationHelperUtility
{

    /**
     * Deprecation: #85285 - Deprecated path related constants (9.4)
     * @return string
     */
    public static function getPublicPath()
    {
        if (self::isTypo3VersionLowerThan('9.4')) {
            return PATH_site;
        }

        return Environment::getPublicPath() .'/';

    }

    /**
     * Deprecation: #85557 - PageRepository->getRootLine (9.4)
     * @param int $pid
     * @return array
     * @throws \Exception
     */
    public static function getRootLine(int $pid)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        if (self::isTypo3VersionLowerThan('9.4')) {
            $sysPageObj = $objectManager->get(PageRepository::class);
            return $sysPageObj->getRootLine($pid);
        }

        /** @var RootlineUtility $rootlineUtility */
        $rootlineUtility = $objectManager->get(RootlineUtility::class, $pid);
        return $rootlineUtility->get();
    }

    /**
     * Deprecation: #85389 - Various public properties in favor of Context API (9.4)
     * @return bool
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public static function contextLoggedInFeUser(){
        if (self::isTypo3VersionLowerThan('9.4')) {
            return $GLOBALS['TSFE']->loginUser;
        }

        /** @var Context $context */
        $context = GeneralUtility::makeInstance(Context::class, null);
        return $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');
    }

    /**
     * Deprecation: #85389 - Various public properties in favor of Context API (9.4)
     * @return bool
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public static function contextLoggedInBeUser(){
        if (self::isTypo3VersionLowerThan('9.4')) {
            return $GLOBALS['TSFE']->beUserLogin;
        }

        /** @var Context $context */
        $context = GeneralUtility::makeInstance(Context::class, null);
        return $context->getPropertyFromAspect('backend.user', 'isLoggedIn');
    }


    /**
     * @param string $testVersion
     * @return bool|int
     */
    public static function isTypo3VersionLowerThan(string $testVersion)
    {
        $t3VersionNumber = GeneralUtility::makeInstance(VersionNumberUtility::class)->getCurrentTypo3Version();
        return version_compare($t3VersionNumber, $testVersion, '<');
    }
}
