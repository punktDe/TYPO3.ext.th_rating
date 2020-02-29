<?php
namespace Thucke\ThRating\Domain\Repository;

use Thucke\ThRating\Domain\Model\Stepname;
use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
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
 * A repository for ratingstep configurations
 */
class StepnameRepository extends Repository
{
    protected const TABLE_NAME = 'tx_thrating_domain_model_stepname';
    protected const STEPCONF_NAME = 'stepconf';

    /**
     * @var string $syslangUidLiteral
     */
    protected $syslangUidLiteral;

    /**
     * @var int
     */
    protected $defaultOrderings ;


    /**
     * Initialize this repository
     */
    /** @noinspection PhpUnused */
    public function initializeObject(): void
    {
        $this->syslangUidLiteral = $GLOBALS['TCA'][self::TABLE_NAME]['ctrl']['languageField'];
        $this->defaultOrderings = [ $this->syslangUidLiteral => QueryInterface::ORDER_ASCENDING];
    }

    /**
     * Checks if stepname got a valid language code
     *
     * @param Stepname $stepname The stepname object
     * @return    bool
     * @throws \TYPO3\CMS\Core\Exception\SiteNotFoundException
     */
    public function checkStepnameLanguage(Stepname $stepname): bool
    {
        $stepnameLang = $stepname->getLanguageUid();
        if ($stepnameLang > 0) {
            //check if given language exist

            try {
                //** @var \Thucke\ThRating\Domain\Model\Syslang|object $queryResult */
                $queryResult = $this->objectManager->get(ExtensionHelperService::class)->getStaticLanguageById($stepnameLang);
            } catch (\InvalidArgumentException $exception) {
                //invalid language code -> NOK
                return false;
            }
        }
        //language code found -> OK
        return true;
    }

    /**
     * Finds the given stepconf object in the repository
     *
     * @param    Stepname $stepname The ratingname to look for
     * @return    Stepname|object
     * @var Stepname $foundRow
     */
    public function findStepnameObject(Stepname $stepname)
    {
        $foundRow = $this->objectManager->get(Stepname::class);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching(
            $query->logicalAnd(
                [$query->equals(self::STEPCONF_NAME, $stepname->getStepconf()->getUid()),
                        $query->equals($this->syslangUidLiteral, $stepname->getLanguageUid()), ]
            )
        )
                ->setLimit(1);
        $queryResult = $query->execute();
        if (count($queryResult) !== 0) {
            $foundRow = $queryResult->getFirst();
        }

        return $foundRow;
    }

    /**
     * Finds the given stepconf object in the repository
     *
     * @param int $uid
     * @return object The matching object if found, otherwise NULL
     */
    public function findStrictByUid($uid)
    {
        $foundRow = $this->objectManager->get(Stepname::class);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->logicalAnd(
                [$query->equals('uid', $uid)]
            )
        )->setLimit(1);
        $queryResult = $query->execute();
        if (count($queryResult) !== 0) {
            $foundRow = $queryResult->getFirst();
        }

        return $foundRow;
    }

    /**
     * Check on double language entries
     *
     * @param    Stepname $stepname The ratingname to look for
     * @return    array    return values false says OK
     */
    public function checkConsistency(Stepname $stepname): array
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $query ->getQuerySettings()->setRespectSysLanguage(false);
        $query ->matching(
            $query->equals(self::STEPCONF_NAME, $stepname->getStepconf()->getUid())
        );
        $queryResult = $query
            ->execute(true)
            ->toArray();  /** instead of setReturnRawQueryResult(true); */

        /** @var array $checkConsistency */
        $checkConsistency = [];

        if (count($queryResult) > 1) {
            /** @var array $websiteLanguagesArray */
            $websiteLanguagesArray = [];

            $allWebsiteLanguages = \Thucke\ThRating\Utility\DeprecationHelperUtility::getAllSiteLanguages();
            //TODO remove $allWebsiteLanguages = $this->objectManager->get(SyslangRepository::class)->findAll()->toArray();

            /** @var \TYPO3\CMS\Core\Site\Entity\SiteLanguage $language */
            foreach (array_values($allWebsiteLanguages) as $language) {
                $websiteLanguagesArray[] = $language->getLanguageId();
            }
            $languageCounter = [];
            foreach (array_values($queryResult) as $value) {
                $languageUid = $value[$this->syslangUidLiteral];
                $languageCounter[$languageUid]++;
                if ($languageCounter[$languageUid] > 1) {
                    $checkConsistency['doubleLang'] = true;
                }

                //check if language flag exists in current website
                if (($languageUid > 0) && in_array($languageUid, $websiteLanguagesArray, true)) {
                    $checkConsistency['existLang'] = true;
                }
            }
        }

        return $checkConsistency;
    }

    /**
     * Finds the default language stepconf by giving ratingobject and steporder
     *
     * @param   Stepname $stepname The ratingname to look for
     * @throws  InvalidQueryException
     * @return  Stepname|object       The stepname in default language
     * @var Stepname $foundRow
     */
    public function findDefaultStepname($stepname)
    {
        $foundRow = $this->objectManager->get(Stepname::class);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals(self::STEPCONF_NAME, $stepname->getStepconf()->getUid()),
                    $query->in($this->syslangUidLiteral, [0, -1])
                ]
            )
        )->setLimit(1);

        /** @var QueryResultInterface $queryResult */
        $queryResult = $query->execute();

        if (count($queryResult) !== 0) {
            $foundRow = $queryResult->getFirst();
        }

        return $foundRow;
    }

    /**
     * Finds the localized ratingstep entry by giving ratingobjectUid
     *
     * @param    Stepname $stepname The ratingname to look for
     * @return    bool  true if stepconf having same steporder and _languageUid exists
     */
    public function existStepname(Stepname $stepname): bool
    {
        $lookForStepname = $this->findStepnameObject($stepname);

        return $lookForStepname instanceof Stepname;
    }

    /**
     * Set default query settings to find ALL records
     */
    public function clearQuerySettings(): void
    {
        /** @var Typo3QuerySettings $querySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $querySettings->setRespectSysLanguage(false);
        $querySettings->setIgnoreEnableFields(true);
        $this->setDefaultQuerySettings($querySettings);
    }
}
