<?php
namespace Thucke\ThRating\Domain\Model;

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
 * @scope   beta
 * @entity
 */
class Stepname extends AbstractEntity
{
    /**
     * @validate \Thucke\ThRating\Domain\Validator\StepconfValidator
     * @validate NotEmpty
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
     * _languageUid
     * @validate NotEmpty
     * @Extbase\Validate("NotEmpty")
     * @var int
     */
    protected $_languageUid;

    /**
     * Constructs a new stepconfig object
     * @param \Thucke\ThRating\Domain\Model\Stepconf|null $stepconf
     * @param null $stepname
     */
    public function __construct(Stepconf $stepconf = null, $stepname = null)
    {
        if ($stepconf) {
            $this->setStepconf($stepconf);
        }
        if ($stepname) {
            $this->setStepname($stepname);
        }
        $this->initializeObject();
    }

    /**
     * Initializes a new stepconf object
     */
    public function initializeObject(): void
    {
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this,get_class($this).' initializeObject');
    }

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
     * @param int $_languageUid
     */
    public function set_languageUid($_languageUid): void
    {
        $this->_languageUid = $_languageUid;
    }

    /**
     * @return int
     */
    public function get_languageUid(): int
    {
        return $this->_languageUid;
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
