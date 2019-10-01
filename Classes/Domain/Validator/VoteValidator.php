<?php /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

namespace Thucke\ThRating\Domain\Validator;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;
use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Model\Vote;
use Thucke\ThRating\Domain\Model\Voter;

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
 * A validator for Votes
 *
 * @author        Thomas Hucke <thucke@web.de>
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
     * @return void
     */
    protected function isValid($vote)
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($vote,get_class($this).' isValid');
        /** @noinspection NotOptimalIfConditionsInspection */
        if (!$this->isEmpty($vote) && $vote instanceof Vote) {
            //a vote object must have a vote
            if (!$vote->getVote() instanceof Stepconf) {
                $this->addError(LocalizationUtility::translate('error.validator.vote.vote', 'ThRating'), 1283537235);
            } else {
                //a vote must have a valid voter
                if (!$vote->getVoter() instanceof Voter) {
                    $this->addError(LocalizationUtility::translate('error.validator.vote.voter', 'ThRating'),
                        1283540684);
                }
                //check if the given vote is a valid step for this ratingobject
                if (!$vote->getRating()->getRatingobject()->getStepconfs()->contains($vote->getVote())) {
                    $this->addError(LocalizationUtility::translate('error.validator.vote.stepconf', 'ThRating'),
                        1283612492);
                }
            }
        } else {
            $this->addError(LocalizationUtility::translate('error.validator.vote.empty', 'ThRating'),1568141014);
            \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($vote,get_class($this).' isValid else');
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
        $result= !$this->isEmpty($vote) && $vote instanceof Vote;
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($result,get_class($this).' isObjSet');

        return $result;
    }
}
