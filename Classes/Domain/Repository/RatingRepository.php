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
 * A repository for ratings
 */
class RatingRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Defines name for function parameter
     *
     */
    const addIfNotFound = true;

    /**
     * @var \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     */
    protected $extensionHelperService;

    /**
     * @param    \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     * @return    void
     */
    public function injectExtensionHelperService(\Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService)
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Finds the specific rating by giving the object and row uid
     *
     * @param    \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject The concerned ratingobject
     * @param    int $ratedobjectuid The Uid of the rated row
     * @param    bool $addIfNotFound Set to true if new objects should instantly be added
     * @return \Thucke\ThRating\Domain\Model\Rating        The rating
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @validate $ratingobject \Thucke\ThRating\Domain\Validator\RatingobjectValidator
     * @validate $ratedobjectuid NumberRange(minimum = 1)
     */
    public function findMatchingObjectAndUid($ratingobject, $ratedobjectuid, $addIfNotFound = false)
    {
        /** @var \Thucke\ThRating\Domain\Model\Rating $foundRow */
        $foundRow = $this->objectManager->get(\Thucke\ThRating\Domain\Model\Rating::class);

        $query = $this->createQuery();
        $query->matching($query->logicalAnd([$query->equals('ratingobject', $ratingobject->getUid()), $query->equals('ratedobjectuid', $ratedobjectuid)]))->setLimit(1);
        $queryResult = $query->execute();
        if ($queryResult->count() != 0) {
            $foundRow = $queryResult->getFirst();
        //Cope with an obviuos bug in TYPO3 6.1 that $queryResult->getFirst() doesn�t return the fully loaded object
            /* If ( \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) < 6002000 ) {
                $dummy = \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($foundRow, 'dummy', 2, true, false, true);
            } */
        } else {
            if ($addIfNotFound) {
                $foundRow->setRatingobject($ratingobject);
                $foundRow->setRatedobjectuid($ratedobjectuid);
                $validator = $this->objectManager->get(\Thucke\ThRating\Domain\Validator\RatingValidator::class);
                if ($validator->isObjSet($foundRow) && !$validator->validate($foundRow)->hasErrors()) {
                    $this->add($foundRow);
                }
                $this->extensionHelperService->persistRepository('Thucke\ThRating\Domain\Repository\RatingRepository', $foundRow);
                $foundRow = $this->findMatchingObjectAndUid($ratingobject, $ratedobjectuid);
            }
        }
        return $foundRow;
    }
}
