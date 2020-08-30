<?php
declare(strict_types = 1);
namespace Thucke\ThRating\Domain\Model;

use phpDocumentor\Reflection\Types\Integer;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
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
 * Model for ratingstep configuration names
 *
 * @author  Thomas Hucke <thucke@web.de>
 * @copyright  Copyright belongs to the respective authors
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @entity
 */
class Stepname extends AbstractEntity
{
    /**
     * @Extbase\Validate("\Thucke\ThRating\Domain\Validator\StepconfValidator")
     * @Extbase\Validate("NotEmpty")
     * @var \Thucke\ThRating\Domain\Model\Stepconf
     */
    protected $stepconf;

    /**
     * The name of this config entry
     *
     * @var string Name or description to display
     */
    protected $stepname;

    /**
     * Localization entry
     * workaround to help avoiding bug in Typo 4.7 handling localized objects
     *
     * @var int
     */
    protected $l18nParent;

    /**
     * languageUid will be mapped to column sys_language_uid
     * @Extbase\Validate("NotEmpty")
     * @var int
     */
    protected $languageUid;

    /**
     * _languageUid will be mapped to column sys_language_uid
     * @deprecated will be removed in when support for TYPO3 v9 is dropped
     * @Extbase\Validate("NotEmpty")
     * @var int
     */
    protected $_languageUid;

    /**
     * Sets the stepconf this rating is part of
     *
     * @param \Thucke\ThRating\Domain\Model\Stepconf $stepconf The Rating
     */
    public function setStepconf(Stepconf $stepconf): void
    {
        $this->stepconf = $stepconf;
        $this->setPid($stepconf->getPid());
    }

    /**
     * Returns the stepconf this rating is part of
     *
     * @return \Thucke\ThRating\Domain\Model\Stepconf The stepconf this rating is part of
     */
    public function getStepconf(): Stepconf
    {
        return $this->stepconf;
    }

    /**
     * Sets the stepconfig name
     *
     * @param string $stepname
     */
    public function setStepname($stepname): void
    {
        $this->stepname = $stepname;
    }

    /**
     * Gets the stepconfig name
     * If not set stepweight is copied
     *
     * @return string Stepconfig name
     */
    /** @noinspection PhpUnused */
    public function getStepname(): string
    {
        $value = $this->stepname;
        if (stripos($value, 'LLL:') === 0) {
            $value = 'stepnames.' . substr($value, 4);
            $value = LocalizationUtility::translate($value, 'ThRating');
        }
        if (empty($value)) {
            $value = (string)$this->getStepconf()->getSteporder();
        }

        return $value;
    }

    /**
     * @return int
     */
    /** @noinspection PhpUnused */
    public function getL18nParent(): int
    {
        return $this->l18nParent;
    }

    /**
     * @param $l18nParent
     */
    public function setL18nParent($l18nParent): void
    {
        $this->l18nParent = $l18nParent;
    }

    /**
     * @deprecated will be removed in when support for TYPO3 v9 is dropped
     * @param int $languageUid
     */
    public function set_languageUid($languageUid): void
    {
        $this->_languageUid = $languageUid;
    }

    /**
     * @deprecated will be removed in when support for TYPO3 v9 is dropped
     * @return int
     */
    public function get_languageUid()
    {
        return $this->_languageUid;
    }

    /**
     * @param int $languageUid
     */
    public function setLanguageUid($languageUid): void
    {
        $this->languageUid = $languageUid;
        $this->set_languageUid($languageUid);
    }

    /**
     * @return int
     */
    public function getLanguageUid()
    {
        return $this->languageUid ?? $this->_languageUid;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return !empty($this->stepconf);
    }

    /**
     * Method to use Object as plain string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getStepname();
    }
}
