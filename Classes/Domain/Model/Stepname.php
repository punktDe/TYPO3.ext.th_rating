<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Model for ratingstep configuration names
 *
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
     * @param int $l18nParent
     */
    public function setL18nParent($l18nParent): void
    {
        $this->l18nParent = $l18nParent;
    }

    /**
     * Get sys language
     *
     * @return int
     */
    public function getSysLanguageUid(): int
    {
        return $this->_languageUid;
    }

    /**
     * Set sys language
     *
     * @param int $sysLanguageUid language uid
     */
    public function setSysLanguageUid($sysLanguageUid): void
    {
        $this->_languageUid = $sysLanguageUid;
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
