<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/** @noinspection PhpFullyQualifiedNameUsageInspection */
namespace Thucke\ThRating\Domain\Validator;

use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Model\Stepname;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * A validator for Ratings
 *
 * @copyright Copyright belongs to the respective authors
 * @scope singleton
 */
class StepnameValidator extends AbstractValidator
{
    /**
     * @var \Thucke\ThRating\Domain\Repository\StepnameRepository
     */
    protected $stepnameRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository
     */
    public function injectStepnameRepository(\Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository)
    {
        $this->stepnameRepository = $stepnameRepository;
    }

    /**
     * If the given step is valid
     *
     * @param \Thucke\ThRating\Domain\Model\Stepname $stepname
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    protected function isValid($stepname): void
    {
        //a stepname object must have a stepconf
        if (!$stepname->getStepconf() instanceof Stepconf) {
            $this->addError(
                LocalizationUtility::translate('error.validator.stepname.stepconf', 'ThRating'),
                1382895072
            );
        }

        //check if given languagecode exists in website
        if (!$this->stepnameRepository->checkStepnameLanguage($stepname)) {
            $this->addError(LocalizationUtility::translate('error.validator.stepname.sysLang', 'ThRating'), 1382895089);
        }

        //now check if entry for default language exists
        $langUid = $stepname->getSysLanguageUid();
        if (!empty($langUid)) {
            $defaultStepname = $this->stepnameRepository->findDefaultStepname($stepname);
            if (get_class($defaultStepname) !== Stepname::class || $this->validate($defaultStepname)->hasErrors()) {
                $this->addError(
                    LocalizationUtility::translate('error.validator.stepname.defaultLang', 'ThRating'),
                    1382895097
                );
            }
        }
    }
}
