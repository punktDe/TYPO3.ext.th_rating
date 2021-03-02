<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Domain\Validator;

use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\Ratingobject;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * A validator for Ratings
 *
 * @copyright    Copyright belongs to the respective authors
 * @scope singleton
 */
class RatingValidator extends AbstractValidator
{
    /**
     * This validator always needs to be executed even if the given value is empty.
     * See AbstractValidator::validate()
     *
     * @var bool
     */
    protected $acceptsEmptyValues = false;

    /**
     * If the given Rating is valid
     *
     * @param \Thucke\ThRating\Domain\Model\Rating $rating
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    protected function isValid($rating): void
    {
        /** @noinspection NotOptimalIfConditionsInspection */
        if (!$this->isEmpty($rating) && $rating instanceof Rating) {
            $ratedobjectuid = $rating->getRatedobjectuid();
            if (empty($ratedobjectuid)) {
                $this->addError(
                    LocalizationUtility::translate('error.validator.rating.ratedobjectuid', 'ThRating'),
                    1283536994
                );
            }
            if (!$rating->getRatingobject() instanceof Ratingobject) {
                $this->addError(
                    LocalizationUtility::translate('error.validator.rating.ratingobject', 'ThRating'),
                    1283538549
                );
            }
        } else {
            $this->addError(LocalizationUtility::translate('error.validator.rating.empty', 'ThRating'), 1568138421);
        }
    }
}
