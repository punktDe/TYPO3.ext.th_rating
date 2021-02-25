<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Domain\Validator;

use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Model\Vote;
use Thucke\ThRating\Domain\Model\Voter;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * A validator for Votes
 *
 * @copyright Copyright belongs to the respective authors
 * @scope singleton
 */
class VoteValidator extends AbstractValidator
{
    /**
     * This validator always needs to be executed even if the given value is empty.
     * See AbstractValidator::validate()
     *
     * @var bool
     */
    protected $acceptsEmptyValues = false;

    /**
     * If the given Vote is valid
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote The vote
     */
    protected function isValid($vote)
    {
        /** @noinspection NotOptimalIfConditionsInspection */
        if (!$this->isEmpty($vote) && $vote instanceof Vote) {
            //a vote object must have a vote
            if (!$vote->getVote() instanceof Stepconf) {
                $this->addError(LocalizationUtility::translate('error.validator.vote.vote', 'ThRating'), 1283537235);
            } else {
                //a vote must have a valid voter
                if (!$vote->getVoter() instanceof Voter) {
                    $this->addError(
                        LocalizationUtility::translate('error.validator.vote.voter', 'ThRating'),
                        1283540684
                    );
                }
                //check if the given vote is a valid step for this ratingobject
                if (!$vote->getRating()->getRatingobject()->getStepconfs()->contains($vote->getVote())) {
                    $this->addError(
                        LocalizationUtility::translate('error.validator.vote.stepconf', 'ThRating'),
                        1283612492
                    );
                }
            }
        } else {
            $this->addError(LocalizationUtility::translate('error.validator.vote.empty', 'ThRating'), 1568141014);
        }
    }

    /**
     * If the given Vote is set
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote The vote
     * @return bool
     */
    public function isObjSet($vote)
    {
        $result = !$this->isEmpty($vote) && $vote instanceof Vote;

        return $result;
    }
}
