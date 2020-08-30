<?php
/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
namespace Thucke\ThRating\Domain\Repository;

use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Validator\RatingValidator;
use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Annotation as Extbase;

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
     * @var \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;

    /**
     * @param \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     */
    public function injectExtensionHelperService(ExtensionHelperService $extensionHelperService): void
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Finds the specific rating by giving the object and row uid
     *
     * @Extbase\Validate("\Thucke\ThRating\Domain\Validator\RatingobjectValidator", param="ratingobject")
     * @param    \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject The concerned ratingobject
     * @Extbase\Validate("NumberRange", options={"minimum": 1}, param="ratedobjectuid")
     * @param    int $ratedobjectuid The Uid of the rated row
     * @param    bool $addIfNotFound Set to true if new objects should instantly be added
     * @return  Rating
     * @throws  IllegalObjectTypeException
     */
    public function findMatchingObjectAndUid(
        Ratingobject $ratingobject,
        int $ratedobjectuid,
        $addIfNotFound = false
    ): Rating
    {
        /** @var \Thucke\ThRating\Domain\Model\Rating $foundRow */
        $foundRow = $this->objectManager->get(Rating::class);

        $query = $this->createQuery();
        $query->matching($query->logicalAnd(
            [
                $query->equals('ratingobject', $ratingobject->getUid()),
                $query->equals('ratedobjectuid', $ratedobjectuid)
            ]
        ))->setLimit(1);
        /*$queryParser = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser::class);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL(), get_class($this).' SQL');
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getParameters(), get_class($this).' SQL Parameter');*/

        $queryResult = $query->execute();
        if ($queryResult->count() > 0) {
            $foundRow = $queryResult->getFirst();
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
