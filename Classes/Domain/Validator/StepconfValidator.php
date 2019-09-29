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
 * @copyright Copyright belongs to the respective authors
 * @scope singleton
 */
class StepconfValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
    /**
     * @var \Thucke\ThRating\Domain\Repository\StepconfRepository
     */
    protected $stepconfRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\StepconfRepository $stepconfRepository
     * @return void
     */
    public function injectStepconfRepository(\Thucke\ThRating\Domain\Repository\StepconfRepository $stepconfRepository)
    {
        $this->stepconfRepository = $stepconfRepository;
    }

    /**
     * @var \Thucke\ThRating\Domain\Repository\StepnameRepository
     */
    protected $stepnameRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository
     * @return void
     */
    public function injectStepnameRepository(\Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository)
    {
        $this->stepnameRepository = $stepnameRepository;
    }

    /**
     * If the given step is valid
     *
     * @param \Thucke\ThRating\Domain\Model\Stepconf $stepconf
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @var \Thucke\ThRating\Domain\Model\Stepname $stepname
     * @var int $countNames
     * @var array $checkConsistency
     */
    protected function isValid($stepconf)
    {
        //a stepconf object must have a ratingobject
        if (!$stepconf->getRatingobject() instanceof \Thucke\ThRating\Domain\Model\Ratingobject) {
            $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepconf.ratingobject', 'ThRating'), 1284700846);

            return;
        }
        //at least a steporder value must be set
        $steporder = $stepconf->getSteporder();
        if (empty($steporder)) {
            $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepconf.steps', 'ThRating'), 1284700903);

            return;
        }

        //steporder must be positive integer ( >0 )
        if (!is_int($stepconf->getSteporder()) or $stepconf->getSteporder() < 1) {
            $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepconf.invalidSteporderNumber', 'ThRating'), 1368123953);

            return;
        }

        //check if given steporder is valid (integer, maximum +1)
        /** @var object $maxSteporderStepconfobject */
        $maxSteporderStepconfobject = $this->stepconfRepository->findByRatingobject($stepconf->getRatingobject());
        $maxSteporder = $maxSteporderStepconfobject[$maxSteporderStepconfobject->count() - 1]->getSteporder();
        if ($stepconf->getSteporder() > $maxSteporder + 1) {
            $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepconf.maxSteporder', 'ThRating'), 1368123970);

            return;
        }

        //check if a stepname is given that at least has the default language definition
        //TODO move to query on stepname repository

        $stepname = $stepconf->getStepname();
        $countNames = 0;
        if ($stepname instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
            $countNames = $stepname->count();
        }
        if ($countNames != 0) {
            /** @var \Thucke\ThRating\Domain\Model\Stepname $firstStepname */
            $firstStepname = $stepname->current();

            /** @var \Thucke\ThRating\Domain\Model\Stepname|object $defaultName */
            $defaultName = $this->stepnameRepository->findDefaultStepname($firstStepname);
            if (!$defaultName->isValid()) {
                $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepconf.defaultStepname', 'ThRating', [$firstStepname->getStepconf()->getUid()]), 1384374165);

                return;
            }

            //Finally check on language constistency
            $checkConsistency = $this->stepnameRepository->checkConsistency($firstStepname);
            if ($checkConsistency['doubleLang']) {
                $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepconf.doubleLangEntry', 'ThRating', [$firstStepname->getStepconf()->getUid()]), 1384374589);

                return;
            }
            if ($checkConsistency['existLang']) {
                $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepconf.notExistingLanguage', 'ThRating', [$firstStepname->getUid()]), 1384374589);

                return;
            }
        }
    }

    /**
     * If the given step is set
     *
     * @param \Thucke\ThRating\Domain\Model\Stepconf $stepconf
     * @return bool
     */
    public function isObjSet($stepconf)
    {
        return !$this->isEmpty($stepconf) && $stepconf instanceof \Thucke\ThRating\Domain\Model\Stepconf;
    }
}
