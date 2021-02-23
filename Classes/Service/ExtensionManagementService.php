<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Service;

use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Model\Stepconf;
use TYPO3\CMS\Core\Log\LogLevel;

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
class ExtensionManagementService extends AbstractExtensionService
{
    /**
     * @var \Thucke\ThRating\Service\ExtensionConfigurationService
     */
    protected $extensionConfigurationService;
    /**
     * @param \Thucke\ThRating\Service\ExtensionConfigurationService $extensionConfigurationService
     */
    public function injectExtensionConfigurationService(ExtensionConfigurationService $extensionConfigurationService): void
    {
        $this->extensionConfigurationService = $extensionConfigurationService;
    }

    /**
     * @var \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;
    /**
     * @param \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     */
    public function injectExtensionHelperService(ExtensionHelperService $extensionHelperService)
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Prepares an object for ratings
     *
     * @api
     * @param string $tablename
     * @param string $fieldname
     * @param int $stepcount
     * @return \Thucke\ThRating\Domain\Model\Ratingobject
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     */
    public function makeRatable(string $tablename, string $fieldname, int $stepcount): Ratingobject
    {
        $this->logger->log(
            LogLevel::INFO,
            'makeRatable called',
            ['tablename' => $tablename, 'fieldname' => $fieldname, 'stepcount' => $stepcount]
        );
        $this->extensionConfigurationService->prepareExtensionConfiguration();

        $ratingobject = $this->extensionHelperService->getRatingobject(
            ['ratetable' => $tablename, 'ratefield' => $fieldname]
        );

        //create a new default stepconf having stepweight 1 for each step
        for ($i = 1; $i <= $stepcount; $i++) {
            $stepconfArray = ['ratingobject' => $ratingobject, 'steporder' => $i, 'stepweight' => 1];
            $stepconf = $this->extensionHelperService->createStepconf($stepconfArray);
            $ratingobject->addStepconf($stepconf);
        }

        //Full reload of newly created object
        $ratingobject = $this->extensionHelperService->getRatingobject(
            ['ratetable' => $tablename, 'ratefield' => $fieldname]
        );

        // CREATE NEW DYNCSS FILE
        $this->extensionHelperService->clearDynamicCssFile();
        $this->extensionHelperService->renderDynCSS();
        $this->extensionConfigurationService->restoreCallingExtensionConfiguration();
        return $ratingobject;
    }

    /**
     * Prepares an object for ratings
     *
     * @api
     * @param \Thucke\ThRating\Domain\Model\Stepconf $stepconf
     * @param string $stepname
     * @param string|null $twoLetterIsoCode
     * @param bool $allStepconfs Take stepname for all steps and add steporder number at the end
     * @return  bool
     * @throws \TYPO3\CMS\Core\Exception\SiteNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \Thucke\ThRating\Exception\Exception
     */
    public function setStepname(
        Stepconf $stepconf,
        string $stepname,
        string $twoLetterIsoCode=null,
        bool $allStepconfs = false
    ): bool {
        $this->logger->log(
            LogLevel::INFO,
            'setStepname called',
            [
                'stepconf' => $stepconf->getUid(),
                'steporder' => $stepconf->getSteporder(),
                'stepname' => $stepname,
                'twoLetterIsoCode' => $twoLetterIsoCode,
                'allStepconfs' => $allStepconfs
            ]
        );

        $this->extensionConfigurationService->prepareExtensionConfiguration();

        /** @var \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject */
        $ratingobject = $stepconf->getRatingobject();

        $success = true;
        if (!$allStepconfs) {
            //only add the one specific stepname
            $stepnameArray = [
                'stepname' => $stepname,
                'twoLetterIsoCode' => $twoLetterIsoCode,
                'pid' => $stepconf->getPid()
            ];
            /** @var \Thucke\ThRating\Domain\Model\Stepname $stepname */
            $stepnameObject = $this->extensionHelperService->createStepname($stepconf, $stepnameArray);

            if (!$stepconf->addStepname($stepnameObject)) {
                $this->logger->log(
                    LogLevel::WARNING,
                    'Stepname entry for language already exists',
                    [
                        'stepconf' => $stepconf->getUid(),
                        'steporder' => $stepconf->getSteporder(),
                        'stepname' => $stepnameObject,
                        'twoLetterIsoCode' => $twoLetterIsoCode,
                        'errorCode' => 1398972827
                    ]
                );
                $success = false;
            }
        } else {

            //add stepnames to every stepconf
            foreach ($ratingobject->getStepconfs() as $loopStepConf) {
                $stepnameArray = [
                    'stepname' => $stepname . $loopStepConf->getSteporder(),
                    'twoLetterIsoCode' => $twoLetterIsoCode,
                    'pid' => $ratingobject->getPid()
                ];

                $stepnameObject = $this->extensionHelperService->createStepname($loopStepConf, $stepnameArray);
                if ($success && !$loopStepConf->addStepname($stepnameObject)) {
                    $this->logger->log(
                        LogLevel::WARNING,
                        'Stepname entry for language already exists',
                        [
                            'stepconf' => $stepconf->getUid(),
                            'steporder' => $stepconf->getSteporder(),
                            'stepname' => $stepname,
                            'twoLetterIsoCode' => $twoLetterIsoCode,
                            'errorCode' => 1398972331
                        ]
                    );
                    $success = false;
                }
            }
        }

        $this->extensionConfigurationService->restoreCallingExtensionConfiguration();
        return $success;
    }
}
