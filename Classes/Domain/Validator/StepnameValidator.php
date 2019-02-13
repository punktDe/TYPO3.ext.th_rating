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
class StepnameValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
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
     * @param \Thucke\ThRating\Domain\Model\Stepname $stepname
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return void
     */
    protected function isValid($stepname)
    {
        //a stepname object must have a stepconf
        if (!$stepname->getStepconf() instanceof \Thucke\ThRating\Domain\Model\Stepconf) {
            $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepname.stepconf', 'ThRating'), 1382895072);
        }

        //check if given languagecode exists in website
        if (!$this->stepnameRepository->checkStepnameLanguage($stepname)) {
            $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepname.sysLang', 'ThRating'), 1382895089);
        }

        //now check if entry for default language exists
        $langUid = $stepname->get_languageUid();
        if (!empty($langUid)) {
            $defaultStepname = $this->stepnameRepository->findDefaultStepname($stepname);
            if (!get_class($defaultStepname) == \Thucke\ThRating\Domain\Model\Stepname::class || $this->validate($defaultStepname)->hasErrors()) {
                $this->addError(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.validator.stepname.defaultLang', 'ThRating'), 1382895097);
            }
        }
    }
}
