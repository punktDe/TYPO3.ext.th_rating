<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Service;

use phpDocumentor\Reflection\Types\Boolean;
use Thucke\ThRating\Exception\FeUserStoragePageException;
use Thucke\ThRating\Exception\InvalidStoragePageException;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
class ExtensionConfigurationService extends AbstractExtensionService
{
    /**
     * Contains configuration of the calling extension
     *
     * @var array
     */
    protected $originalConfiguration;

    /**
     * Calling extension query settings
     *
     * @var QuerySettingsInterface
     */
    protected $originalTypo3QuerySettings;

    /**
     * @var int
     */
    protected $cookieLifetime;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;
    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Contains the settings of the current extension
     *
     * @var array
     */
    protected $settings;

    /**
     * Contains configuration of th_rating
     *
     * @var array
     */
    protected $thRatingConfiguration;

    /**
     * Contains configuration of the current extension
     *
     * @var array
     */
    protected $frameworkConfiguration;

    /**
     * Constructor
     */
    public function initializeObject(): void
    {
        // store calling extension configuration
        $this->originalConfiguration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );

        $this->thRatingConfiguration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'thrating',
            'pi1'
        );
        if (!empty($this->thRatingConfiguration['ratings'])) {
            //Merge extension ratingConfigurations with customer added ones
            ArrayUtility::mergeRecursiveWithOverrule(
                $this->thRatingConfiguration['settings']['ratingConfigurations'],
                $this->thRatingConfiguration['ratings']
            );
        }

        $this->frameworkConfiguration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
            'thrating',
            'pi1'
        );

        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->frameworkConfiguration,get_class($this).' frameworkConfiguration');
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->thRatingConfiguration,get_class($this).' thRatingConfiguration');
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->originalConfiguration,get_class($this).' originalConfiguration');
    }

    /**
     * Get a logger instance
     * The configuration of the logger is modified by extension typoscript config
     *
     * @param string|null $name the class name which this logger is for
     * @return  \TYPO3\CMS\Core\Log\Logger
     */
    public function getLogger(string $name = null): Logger
    {
        if (empty($name)) {
            return $this->loggingService->getLogger(__CLASS__);
        }

        return $this->loggingService->getLogger($name);
    }

    /**
     * Set default query settings to those of th_rating
     * (could be different if services are called from other extensions
     * @throws FeUserStoragePageException
     * @throws InvalidStoragePageException
     */
    public function setExtDefaultQuerySettings(): void
    {
        $this->mergeStoragePids();
        $this->extDefaultQuerySettings = $this->objectManager->get(QuerySettingsInterface::class);
        $this->extDefaultQuerySettings->setStoragePageIds(
            explode(',', $this->thRatingConfiguration['persistence']['storagePid'])
        );
    }

    /**
     * @return bool
     */
    protected function getCookieProtection(): Boolean
    {
        $this->cookieLifetime = abs((int)$this->thRatingConfiguration['settings']['cookieLifetime']);
        $this->logger->log(
            LogLevel::DEBUG,
            'Cookielifetime set to ' . $this->cookieLifetime . ' days',
            ['errorCode' => 1465728751]
        );
        return empty($this->cookieLifetime);
    }

    /**
     * Checks storagePid settings of th_rating and tx_felogin_pi1 and
     * concatenates them to the new storagePid setting
     *
     * @throws InvalidStoragePageException if plugin.tx_thrating.storagePid has not been set
     * @throws FeUserStoragePageException if plugin.tx_felogin_pi1.storagePid has not been set
     */
    private function mergeStoragePids(): void
    {
        $storagePids = GeneralUtility::intExplode(',', $this->thRatingConfiguration['storagePid'], true);
        if (empty($storagePids[0])) {
            throw new InvalidStoragePageException(
                LocalizationUtility::translate('flash.vote.general.invalidStoragePid', 'ThRating'),
                1403203519
            );
        }

        $storagePids[] = $this->getFeUserStoragePage();
        $this->thRatingConfiguration['persistence.']['storagePid'] = implode(',', $storagePids);
    }

    /**
     * Check and return the first configured storage page for website users
     * @return int
     * @throws FeUserStoragePageException
     */
    private function getFeUserStoragePage(): int
    {
        $feUserStoragePid = array_merge(
            GeneralUtility::intExplode(
                ',',
                $this->frameworkConfiguration['plugin.']['tx_felogin_pi1.']['storagePid'],
                true
            ),
            GeneralUtility::intExplode(',', $this->thRatingConfiguration['feUsersStoragePid'], true)
        );
        if (empty($feUserStoragePid[0])) {
            throw new FeUserStoragePageException(
                LocalizationUtility::translate('flash.pluginConfiguration.missing.feUserStoragePid', 'ThRating'),
                1403190539
            );
        }
        return $feUserStoragePid[0];
    }

    /**
     * Change the current extbase configuration to the one of th_rating
     */
    public function prepareExtensionConfiguration(): void
    {
        if ($this->originalConfiguration['extensionName'] !== 'ThRating') {
            //Set default storage pids
            $this->setExtDefaultQuerySettings();
        }
        $this->configurationManager->setConfiguration($this->thRatingConfiguration);
    }

    /**
     * Change the current extbase configuration to the one of th_rating
     */
    public function restoreCallingExtensionConfiguration(): void
    {
        if ($this->originalConfiguration['extensionName'] !== 'ThRating') {
            $this->configurationManager->setConfiguration($this->originalConfiguration);
        }
    }
}
