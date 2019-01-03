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
 * A repository for ratingstep configurations
 */
class StepnameRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    protected const TABLE_NAME = 'tx_thrating_domain_model_stepname';
    protected const STEPCONF_NAME = 'stepconf';
    protected const SYS_LANG_UID_LITERAL = 'sys_language_uid';
    protected $defaultOrderings = [ self::SYS_LANG_UID_LITERAL => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING];

    /**
     * Initialze this repository
     */
    public function initializeObject()
    {
    }


    /**
     * Checks if stepname got a valid language code
     *
     * @param    \Thucke\ThRating\Domain\Model\Stepname $stepname The stepname object
     * @return    boolean
     */
    public function checkStepnameLanguage(\Thucke\ThRating\Domain\Model\Stepname $stepname)
    {
        $stepnameLang = $stepname->get_languageUid();
        If ($stepnameLang > 0) {
            //check if given language exist

            /** @var \Thucke\ThRating\Domain\Model\Syslang|object $queryResult */
            $queryResult = $this->objectManager->get(SyslangRepository::class)->findByUid($stepnameLang);
            if (!empty($queryResult)) {
                //language code found -> OK
                return true;
            }
            //invalid language code -> NOK
            return false;
        }
        //default language is always OK
        return true;
    }

    /**
     * Finds the given stepconf object in the repository
     *
     * @param    \Thucke\ThRating\Domain\Model\Stepname $stepname The ratingname to look for
     * @return    \Thucke\ThRating\Domain\Model\Stepname|object
     * @var \Thucke\ThRating\Domain\Model\Stepname $foundRow
     */
    public function findStepnameObject(\Thucke\ThRating\Domain\Model\Stepname $stepname)
    {
        $foundRow = $this->objectManager->get(\Thucke\ThRating\Domain\Model\Stepname::class);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching($query->logicalAnd(
                    [$query->equals(self::STEPCONF_NAME, $stepname->getStepconf()->getUid()),
                        $query->equals(self::SYS_LANG_UID_LITERAL, $stepname->get_languageUid())])
                    )
                ->setLimit(1);
        $queryResult = $query->execute();
        if (count($queryResult) !== 0) {
            $foundRow = $queryResult->getFirst();
        }
        return $foundRow;
    }

    /**
     * Check on double language entries
     *
     * @param    \Thucke\ThRating\Domain\Model\Stepname $stepname The ratingname to look for
     * @return    array    return values false says OK
     */
    public function checkConsistency(\Thucke\ThRating\Domain\Model\Stepname $stepname)
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $query	->getQuerySettings()->setRespectSysLanguage(false);
        $query	->matching(
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

            $allWebsiteLanguages = $this->objectManager->get(SyslangRepository::class)->findAll()->toArray();

            /** @var \Thucke\ThRating\Domain\Model\Syslang $language */
            foreach (array_values($allWebsiteLanguages) as $language) {
                $websiteLanguagesArray[] = $language->getUid();
            }
            $languageCounter = [];
            foreach (array_values($queryResult) as $value) {
                $languageUid = $value[self::SYS_LANG_UID_LITERAL];
                $languageCounter[$languageUid]++;
                If ($languageCounter[$languageUid] > 1) {
                    $checkConsistency['doubleLang'] = true;
                }

                //check if language flag exists in current website
                If (($languageUid > 0) && in_array($languageUid, $websiteLanguagesArray, true)) {
                    $checkConsistency['existLang'] = true;
                }
            }
        }
        return $checkConsistency;
    }

    /**
     * Finds the default language stepconf by giving ratingobject and steporder
     *
     * @param   \Thucke\ThRating\Domain\Model\Stepname $stepname The ratingname to look for
     * @return  \Thucke\ThRating\Domain\Model\Stepname|object       The stepname in default language
     * @throws  \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @var \Thucke\ThRating\Domain\Model\Stepname $foundRow
     */
    public function findDefaultStepname($stepname)
    {
        $foundRow = $this->objectManager->get(\Thucke\ThRating\Domain\Model\Stepname::class);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching($query->logicalAnd([$query->equals(self::STEPCONF_NAME, $stepname->getStepconf()->getUid()), $query->in(self::SYS_LANG_UID_LITERAL, [0, -1])]))->setLimit(1);

        /** @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $queryResult */
        $queryResult = $query->execute();

        if (count($queryResult) !== 0) {
            $foundRow = $queryResult->getFirst();
        }
        return $foundRow;
    }

    /**
     * Finds the localized ratingstep entry by giving ratingobjectUid
     *
     * @param    \Thucke\ThRating\Domain\Model\Stepname $stepname The ratingname to look for
     * @return    bool                                            true if stepconf having same steporder and _languageUid exists
     */
    public function existStepname(\Thucke\ThRating\Domain\Model\Stepname $stepname)
    {
        $lookForStepname = $this->findStepnameObject($stepname);
        return $lookForStepname instanceof \Thucke\ThRating\Domain\Model\Stepname;
    }

    /**
     * Set default query settings to find ALL records
     *
     * @return    void
     */
    public function clearQuerySettings()
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings $querySettings */
        $querySettings = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings::class);
        $querySettings->setRespectSysLanguage(false);
        $querySettings->setIgnoreEnableFields(true);
        $this->setDefaultQuerySettings($querySettings);
    }
}
