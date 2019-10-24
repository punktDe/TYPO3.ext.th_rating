<?php
namespace Thucke\ThRating\Domain\Repository;

use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\Vote;
use Thucke\ThRating\Domain\Model\Voter;
use TYPO3\CMS\Extbase\Persistence\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Thomas Hucke <thucke@web.de>
 *  All rights reserved
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
 * A repository for votes
 */
class VoteRepository extends Repository
{
    /**
     * Defines name for function parameter
     */
    public const     /** @noinspection PhpUnused */
        ADD_IF_NOT_FOUND = true;

    /**
     * Initialize this repository
     */
    /** @noinspection PhpUnused */
    public function initializeObject(): void
    {
    }

    /**
     * Finds the voting by giving the rating and voter objects
     *
     * @param    Rating $rating   The concerned ratingobject
     * @param    Voter $voter     The Uid of the rated row
     * @return   Vote|object     The voting
     */
    public function findMatchingRatingAndVoter($rating = null, $voter = null)
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();

        return $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('rating', $rating),
                    $query->equals('voter', $voter)
                ]
            )
        )->execute()->getFirst();
    }

    /**
     * Counts all votings by giving the rating and ratingstep
     *
     * @param    Rating $rating The concerned ratingobject
     * @param    \Thucke\ThRating\Domain\Model\Stepconf $stepconf The stepconf object
     * @return    int
     */
    public function countByMatchingRatingAndVote($rating = null, $stepconf = null): int
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd(
            [
                $query->equals('rating', $rating->getUid()),
                $query->equals('vote', $stepconf->getUid())
            ]
        ));

        return count($query->execute());
    }

    /**
     * Counts all anonymous votings by giving the rating and ratingstep
     *
     * @param    Rating $rating The concerned ratingobject
     * @param    \Thucke\ThRating\Domain\Model\Stepconf $stepconf The stepconf object
     * @param    int $anonymousVoter UID of the anonymous account
     * @return    int
     */
    public function countAnonymousByMatchingRatingAndVote($rating = null, $stepconf = null, $anonymousVoter = null): int
    {
        /** @var int $count */
        $count = 0;

        if ($anonymousVoter !== null) {
            $query = $this->createQuery();
            $query->matching(
                $query->logicalAnd([
                    $query->equals('rating', $rating->getUid()),
                    $query->equals('vote', $stepconf->getUid()),
                    $query->equals('voter', $anonymousVoter),
                ])
            );
            $count = count($query->execute());
        }

        return $count;
    }
}
