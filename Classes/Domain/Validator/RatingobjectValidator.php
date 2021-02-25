<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Domain\Validator;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * A validator for Ratingobjects
 *
 * @copyright  Copyright belongs to the respective author
 * @scope singleton
 */
class RatingobjectValidator extends AbstractValidator
{
    /**
     * If the given Ratingobject is valid
     *
     * @param \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject The ratingobject
     */
    protected function isValid($ratingobject)
    {
        /** @var string $ratetable */
        $ratetable = $ratingobject->getRatetable();
        /** @var string $ratefield */
        $ratefield = $ratingobject->getRatefield();

        if (empty($ratetable)) {
            $this->addError(
                LocalizationUtility::translate(
                    'error.validator.ratingobject_table_extbase',
                    'ThRating'
                ),
                1283528638
            );
        }
        if (empty($ratefield)) {
            $this->addError(
                LocalizationUtility::translate(
                    'error.validator.ratingobject_field_extbase',
                    'ThRating'
                ),
                1283536038
            );
        }
    }
}
