<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/** @noinspection PhpUnused */
/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
namespace Thucke\ThRating\Userfuncs;

use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Repository\StepconfRepository;
use Thucke\ThRating\Domain\Repository\StepnameRepository;
use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Core\TypoScript\ExtendedTemplateService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * The backend helper function class
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tca
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager): void
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Constructs a new rating object
     */
    public function __construct()
    {
        if (empty($this->objectManager)) {
            $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        }
    }

    /**
     * Returns the record title for the rating object in BE
     * Note that values of $params are modified by reference
     *
     * @param array $parameters
     * @param object $parentObject
     */
    public function getRatingObjectRecordTitle(&$parameters, &$parentObject): void
    {
        $parameters['title'] =
            '#' . $parameters['row']['uid'] . ': ' . $parameters['row']['ratetable'] . ' [' . $parameters['row']['ratefield'] . ']';
    }

    /**
     * Returns the record title for the step configuration in BE
     * Note that values of $params are modified by reference
     *
     * @param array $parameters
     * @param object $parentObject
     */
    public function getStepconfRecordTitle(&$parameters, &$parentObject): void
    {
        $parameters['title'] = '#' . $parameters['row']['uid'] . ': Steporder [' . $parameters['row']['steporder'] . ']';
    }

    /**
     * Returns the record title for the step configuration name in BE
     * Note that values of $params are modified by reference
     *
     * @param array $parameters
     * @param object $parentObject
     * @throws \TYPO3\CMS\Core\Exception\SiteNotFoundException
     * @throws \Thucke\ThRating\Exception\LanguageNotFoundException
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public function getStepnameRecordTitle(&$parameters, &$parentObject): void
    {
        //look into repository to find clear text object attributes
        $stepnameRepository = $this->objectManager->get(StepnameRepository::class);
        $stepnameRepository->clearQuerySettings(); //disable syslanguage and enableFields
        $stepnameObject = $stepnameRepository->findStrictByUid((int)($parameters['row']['uid']));
        $syslang = '';
        if (is_object($stepnameObject)) {
            /** @var \Thucke\ThRating\Domain\Model\Stepname $stepnameObject */
            $stepnameLang = $stepnameObject->getSysLanguageUid();
            $syslang = $this->objectManager
                ->get(ExtensionHelperService::class)
                ->getStaticLanguageById($stepnameObject->getPid(), $stepnameLang)
                ->getTitle();
        }
        $stepconfRepository = $this->objectManager->get(StepconfRepository::class);
        $stepconfObject = $stepconfRepository->findByUid((int)($parameters['row']['stepconf']));
        $ratetable = LocalizationUtility::translate('tca.BE.new', 'ThRating');
        $ratefield = LocalizationUtility::translate('tca.BE.new', 'ThRating');
        $steporder = LocalizationUtility::translate('tca.BE.new', 'ThRating');
        if ($stepconfObject instanceof Stepconf) {
            $ratingObject = $stepconfObject->getRatingobject();
            if ($ratingObject instanceof Ratingobject) {
                $ratetable = $ratingObject->getRatetable();
                $ratefield = $ratingObject->getRatefield();
                $steporder = $stepconfObject->getSteporder();
            }
        }
        //$syslang = $params['row']['uid'];
        $parameters['title'] = '#' . $parameters['row']['uid'] . ': ' . $ratetable . '[' . $ratefield .
            ']/Step ' . $steporder . '/' . $syslang;
    }

    /**
     * Returns the record title for the rating in BE
     * Note that values of $params are modified by reference
     *
     * @param array $parameters
     * @param object $parentObject
     */
    public function getRatingRecordTitle(&$parameters, &$parentObject): void
    {
        $parameters['title'] = '#' . $parameters['row']['uid'] . ': RowUid [' . $parameters['row']['ratedobjectuid'] . ']';
    }

    /**
     * Returns the record title for the rating in BE
     * Note that values of $params are modified by reference
     *
     * @param array $parameters
     * @param object $parentObject
     */
    public function getVoteRecordTitle(&$parameters, &$parentObject): void
    {
        $parameters['title'] = 'Voteuser Uid [' . $parameters['row']['voter'] . ']';
    }

    /**
     * Returns all configured ratinglink display types for flexform
     *
     * @param array $config
     * @return  array ratinglink configurations
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public function dynFlexRatinglinkConfig($config): array
    {
        //\TYPO3\CMS\Core\Utility\DebugUtility::debug($config,'config');
        $flexFormPid = $config['flexParentDatabaseRow']['pid'];
        $settings = $this->loadTypoScriptForBEModule('tx_thrating', $flexFormPid);
        $ratingconfigs = $settings['settings.']['ratingConfigurations.'];

        $optionList = [];

        // add first option - Default
        $optionList[0] = [0 => 'Default', 1 => ''];
        foreach ($ratingconfigs as $configKey => $configValue) {
            $lastDot = strrpos($configKey, '.');
            if ($lastDot) {
                $name = substr($configKey, 0, $lastDot);
                // add option
                $optionList[] = [0 => $name, 1 => $name];
            }
        }
        /** @noinspection AdditionOperationOnArraysInspection */
        $config['items'] += $optionList;

        return $config;
    }

    /**
     * Loads the TypoScript for the given extension prefix, e.g. tx_cspuppyfunctions_pi1, for use in a backend module.
     *
     * @param string $extKey Extension key to look for config
     * @param int $pid pageUid
     * @return  array
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public function loadTypoScriptForBEModule($extKey, $pid): array
    {
        /** @var array $rootLine */
        $rootLine = $this->objectManager->get(RootlineUtility::class, $pid)->get();
        $TSObj = $this->objectManager->get(ExtendedTemplateService::class);
        $TSObj->runThroughTemplates($rootLine);
        $TSObj->generateConfig();

        return $TSObj->setup['plugin.'][$extKey . '.'];
    }
}
