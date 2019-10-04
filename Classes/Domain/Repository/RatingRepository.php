<?php
namespace Thucke\ThRating\Domain\Repository;

use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Validator\RatingValidator;
use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
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
 * A repository for ratings
 */
class RatingRepository extends Repository
{
    /**
     * Defines name for function parameter
     */
    public const ADD_IF_NOT_FOUND = true;

    /**
     * @var  \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;

    /**
     * @param     \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     * @return    void
     */
    /** @noinspection PhpUnused */
    public function injectExtensionHelperService(ExtensionHelperService $extensionHelperService): void
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Finds the specific rating by giving the object and row uid
     *
     * @param    \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject The concerned ratingobject
     * @param    int $ratedobjectuid The Uid of the rated row
     * @param    bool $addIfNotFound Set to true if new objects should instantly be added
     * @throws  IllegalObjectTypeException
     * @return  Rating        The rating
     * @validate $ratingobject \Thucke\ThRating\Domain\Validator\RatingobjectValidator
     * @validate $ratedobjectuid NumberRange(minimum = 1)
     */
    public function findMatchingObjectAndUid(Ratingobject $ratingobject, $ratedobjectuid, $addIfNotFound = false): Rating
    {
        /** @var \Thucke\ThRating\Domain\Model\Rating $foundRow */
        $foundRow = $this->objectManager->get(Rating::class);

        $query = $this->createQuery();
        $query->matching($query->logicalAnd([$query->equals('ratingobject', $ratingobject->getUid()), $query->equals('ratedobjectuid', $ratedobjectuid)]))->setLimit(1);
        $queryResult = $query->execute();
        if ($queryResult->count() !== 0) {
            $foundRow = $queryResult->getFirst();
            //Cope with an obvious bug in TYPO3 6.1 that $queryResult->getFirst() doesnt return the fully loaded object
            /* If ( \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) < 6002000 ) {
                $dummy = \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($foundRow, 'dummy', 2, true, false, true);
            } */
        } elseif ($addIfNotFound) {
            $foundRow->setRatingobject($ratingobject);
            $foundRow->setRatedobjectuid($ratedobjectuid);
            $validator = $this->objectManager->get(RatingValidator::class);
            if (!$validator->validate($foundRow)->hasErrors()) {
                $this->add($foundRow);
            }
            $this->extensionHelperService->persistRepository(__CLASS__, $foundRow);
            $foundRow = $this->findMatchingObjectAndUid($ratingobject, $ratedobjectuid);
        }

        return $foundRow;
    }
}
