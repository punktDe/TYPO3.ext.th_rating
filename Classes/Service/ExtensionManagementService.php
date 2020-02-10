<?php /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

/** @noinspection PhpFullyQualifiedNameUsageInspection */

namespace Thucke\ThRating\Service;

use TYPO3\CMS\Core\Log\LogLevel;
use Thucke\ThRating\Domain\Model\Stepconf;

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
     * @var \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;

    /**
     * @param \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     * @noinspection PhpUnused
     */
    public function injectExtensionHelperService(ExtensionHelperService $extensionHelperService)
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Prepares an object for ratings
     *
     * @param string $tablename
     * @param string $fieldname
     * @param int $stepcount
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @return \Thucke\ThRating\Domain\Model\Ratingobject
     */
    public function makeRatable($tablename, $fieldname, $stepcount)
    {
        $this->logger->log(
            LogLevel::INFO,
            'makeRatable called',
            ['tablename' => $tablename, 'fieldname' => $fieldname, 'stepcount' => $stepcount]
        );
        $ratingobject = $this->extensionHelperService->getRatingobject(
            ['ratetable' => $tablename, 'ratefield' => $fieldname]
        );

        //create a new default stepconf having stepweight 1 for each step
        for ($i = 1; $i <= $stepcount; $i++) {
            $stepconfArray = ['ratingobject' => $ratingobject, 'steporder' => $i, 'stepweight' => 1];
            $stepconf = $this->extensionHelperService->createStepconf($stepconfArray);
            $ratingobject->addStepconf($stepconf);
        }

        // CREATE NEW DYNCSS FILE
        $this->extensionHelperService->clearDynamicCssFile();
        $this->extensionHelperService->renderDynCSS();

        return $ratingobject;
    }

    /**
     * Prepares an object for ratings
     *
     * @param   \Thucke\ThRating\Domain\Model\Stepconf $stepconf
     * @param   string $stepname
     * @param   int $languageIso2Code
     * @param   bool $allStepconfs Take stepname for all steps and add steporder number at the end
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @return  bool
     */
    public function setStepname(Stepconf $stepconf, $stepname, $languageIso2Code = 0, $allStepconfs = false)
    {
        $this->logger->log(
            LogLevel::INFO,
            'setStepname called',
            [
                'stepconf' => $stepconf->getUid(),
                'steporder' => $stepconf->getSteporder(),
                'stepname' => $stepname,
                'languageIso2Code' => $languageIso2Code,
                'allStepconfs' => $allStepconfs
            ]
        );
        $success = true;
        if (!$allStepconfs) {
            //only add the one specific stepname
            /** @var array $stepnameArray */
            $stepnameArray = ['stepname' => $stepname, 'languageIso2Code' => $languageIso2Code];
            /** @var \Thucke\ThRating\Domain\Model\Stepname $stepname */
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $stepname = $this->extensionHelperService->createStepname($stepnameArray);
            if (!$stepconf->addStepname($stepname)) {
                $this->logger->log(
                    LogLevel::WARNING,
                    'Stepname entry for language already exists',
                    [
                        'stepconf' => $stepconf->getUid(),
                        'steporder' => $stepconf->getSteporder(),
                        'stepname' => $stepname,
                        'languageIso2Code' => $languageIso2Code,
                        'errorCode' => 1398972827
                    ]
                );
                $success = false;
            }
        } else {
            /** @var \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject */
            $ratingobject = $stepconf->getRatingobject();
            //add stepnames to every stepconf
            foreach ($ratingobject->getStepconfs() as $i => $loopStepConf) {
                $stepnameArray = [
                    'stepname' => $stepname . $loopStepConf->getSteporder(),
                    'languageIso2Code' => $languageIso2Code
                ];
                $stepnameObject = $this->extensionHelperService->createStepname($stepnameArray);
                if ($success && !$loopStepConf->addStepname($stepnameObject)) {
                    $this->logger->log(
                        LogLevel::WARNING,
                        'Stepname entry for language already exists',
                        [
                            'stepconf' => $stepconf->getUid(),
                            'steporder' => $stepconf->getSteporder(),
                            'stepname' => $stepname,
                            'languageIso2Code' => $languageIso2Code,
                            'errorCode' => 1398972331
                        ]
                    );
                    $success = false;
                }
            }
        }

        return $success;
    }
}
