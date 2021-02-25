<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Domain\Repository;

use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Validator\StepconfValidator;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * A repository for ratingstep configurations
 * @method findByRatingobject(Ratingobject $getRatingobject)
 */
class StepconfRepository extends Repository
{
    protected $defaultOrderings = ['steporder' => QueryInterface::ORDER_ASCENDING];

    /**
     * Initialize this repository
     */
    public function initializeObject(): void
    {
        //disable RespectStoragePage as pid is always bound to parent objects pid

        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $defaultQuerySettings */
        $defaultQuerySettings = $this->objectManager->get(QuerySettingsInterface::class);
        $defaultQuerySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }

    /**
     * Finds the given stepconf object in the repository
     *
     * @param    \Thucke\ThRating\Domain\Model\Stepconf $stepconf The ratingobject to look for
     * @return    \Thucke\ThRating\Domain\Model\Stepconf
     */
    public function findStepconfObject(Stepconf $stepconf): Stepconf
    {
        $query = $this->createQuery();
        /** @noinspection NullPointerExceptionInspection */
        $query->matching($query->logicalAnd([
            $query->equals('ratingobject', $stepconf->getRatingobject()->getUid()),
            $query->equals('steporder', $stepconf->getSteporder()),
        ]))->setLimit(1);
        $queryResult = $query->execute();

        /** @var \Thucke\ThRating\Domain\Model\Stepconf $foundRow */
        $foundRow = $this->objectManager->get(Stepconf::class);

        if (count($queryResult) !== 0) {
            $foundRow = $queryResult->getFirst();
        }
        return $foundRow;
    }

    /**
     * Finds the ratingstep entry by giving ratingobjectUid
     *
     * @param    \Thucke\ThRating\Domain\Model\Stepconf $stepconf The uid of the ratingobject
     * @return    bool  true if stepconf object exists in repository
     */
    public function existStepconf(Stepconf $stepconf): bool
    {
        $foundRow = $this->findStepconfObject($stepconf);
        $stepconfValidator = $this->objectManager->get(StepconfValidator::class);

        return !$stepconfValidator->validate($foundRow)->hasErrors();
    }
}
