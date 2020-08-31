<?php
/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
namespace Thucke\ThRating\Domain\Repository;

use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Validator\RatingobjectValidator;
use Thucke\ThRating\Exception\RecordNotFoundException;
use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
 * A repository for rating objects
 */
class RatingobjectRepository extends Repository
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
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;
    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Finds the specific ratingobject by giving table and fieldname
     *
     * @param string $ratetable The tablename of the ratingobject
     * @param string $ratefield The fieldname of the ratingobject
     * @param bool $addIfNotFound Set to true if new objects should instantly be added
     * @return \Thucke\ThRating\Domain\Model\Ratingobject The ratingobject
     * @throws RecordNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function findMatchingTableAndField(string $ratetable, string $ratefield, bool $addIfNotFound = false): Ratingobject
    {
        /** @var \Thucke\ThRating\Domain\Model\Ratingobject $foundRow */
        $foundRow = $this->objectManager->get(Ratingobject::class);

        $query = $this->createQuery();

        $query->matching($query->logicalAnd([
            $query->equals('ratetable', $ratetable),
            $query->equals('ratefield', $ratefield),
        ]))->setLimit(1);

        /*$queryParser = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser::class);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL(), get_class($this).' SQL');
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getParameters(), get_class($this).' SQL Parameter');*/

        /** @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $queryResult */
        $queryResult = $query->execute();

        if ($queryResult->count() > 0) {
            $foundRow = $queryResult->getFirst();
        } elseif ($addIfNotFound) {
            $foundRow->setRatetable($ratetable);
            $foundRow->setRatefield($ratefield);

            if (!$this->objectManager->get(RatingobjectValidator::class)->validate($foundRow)->hasErrors()) {
                $this->add($foundRow);
            }
            $this->extensionHelperService->persistRepository(self::class, $foundRow);
            $foundRow = $this->findMatchingTableAndField($ratetable, $ratefield);
        } else {
            throw new RecordNotFoundException(LocalizationUtility::translate('recordNotFound', 'ThRating'), 1567962473);
        }
        return $foundRow;
    }

    /**
     * Finds the specific ratingobject by giving table and fieldname
     *
     * @param bool   Switch to fetch ALL entries regardless of their pid
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array All ratingobjects of the site
     */
    /** @noinspection PhpMissingParentCallCommonInspection */
    public function findAll($ignoreStoragePage = false)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(!$ignoreStoragePage);
        return $query->execute();
    }
}
