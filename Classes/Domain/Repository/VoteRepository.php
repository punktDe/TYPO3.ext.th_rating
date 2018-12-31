<?php

namespace Thucke\ThRating\Domain\Repository;
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
class VoteRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Defines name for function parameter
     *
     */
    const addIfNotFound = true;

    /**
     * Initialze this repository
     */
    public function initializeObject()
    {
    }

    /**
     * Finds the voting by giving the rating and voter objects
     *
     * @param    \Thucke\ThRating\Domain\Model\Rating $rating   The concerned ratingobject
     * @param    \Thucke\ThRating\Domain\Model\Voter $voter     The Uid of the rated row
     * @return    \Thucke\ThRating\Domain\Model\Vote|object     The voting
     */
    public function findMatchingRatingAndVoter($rating = NULL, $voter = NULL)
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        return $query->matching($query->logicalAnd([$query->equals('rating', $rating), $query->equals('voter', $voter)]))->execute()->getFirst();
    }

    /**
     * Counts all votings by giving the rating and ratingstep
     *
     * @param    \Thucke\ThRating\Domain\Model\Rating $rating The concerned ratingobject
     * @param    \Thucke\ThRating\Domain\Model\Stepconf $stepconf The stepconf object
     * @return    Int
     */
    public function countByMatchingRatingAndVote($rating = NULL, $stepconf = NULL)
    {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd([$query->equals('rating', $rating->getUid()), $query->equals('vote', $stepconf->getUid())]));
        return count($query->execute());
    }

    /**
     * Counts all anonymous votings by giving the rating and ratingstep
     *
     * @param    \Thucke\ThRating\Domain\Model\Rating $rating The concerned ratingobject
     * @param    \Thucke\ThRating\Domain\Model\Stepconf $stepconf The stepconf object
     * @param    Int $anonymousVoter UID of the anonymous account
     * @return    Int
     */
    public function countAnonymousByMatchingRatingAndVote($rating = NULL, $stepconf = NULL, $anonymousVoter = NULL)
    {
        if (!empty($anonymousVoter)) {
            $query = $this->createQuery();
            $query->matching($query->logicalAnd([$query->equals('rating', $rating->getUid()), $query->equals('vote', $stepconf->getUid()), $query->equals('voter', $anonymousVoter)]));
            return count($query->execute());
        }
        return 0;
    }

}
