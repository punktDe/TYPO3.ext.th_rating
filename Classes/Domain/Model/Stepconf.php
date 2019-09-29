<?php
namespace Thucke\ThRating\Domain\Model;

use Thucke\ThRating\Domain\Repository\StepnameRepository;
use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use Thucke\ThRating\Domain\Repository\StepconfRepository;

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
 * Model for ratingstep configuration
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Stepconf extends AbstractEntity
{
    /**
     * @var \Thucke\ThRating\Domain\Model\Ratingobject
     * @validate \Thucke\ThRating\Domain\Validator\RatingobjectValidator
     * @validate NotEmpty
     */
    protected $ratingobject;

    /**
     * The order of this config entry
     *
     * @var int discrete order of ratingsteps
     * @validate NumberRange(minimum = 1)
     * @validate NotEmpty
     */
    protected $steporder;

    /**
     * The weight of this config entry
     *
     * @var float  default is 1 which is equal weight
     * @validate NumberRange(minimum = 1)
     */
    protected $stepweight;

    /**
     * The value of this config entry
     *
     * @var \Thucke\ThRating\Domain\Model\Stepname
     * @validate \Thucke\ThRating\Domain\Validator\StepnameValidator
     * @lazy
     * @cascade remove
     */
    protected $stepname;

    /**
     * The ratings of this object
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Vote>
     * @lazy
     * @cascade remove
     */
    protected $votes;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface	$objectManager
     */
    protected $objectManager;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface	$objectManager
     * @return void
     */
    /** @noinspection PhpUnused */
    public function injectObjectManager(ObjectManagerInterface $objectManager): void
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @var \Thucke\ThRating\Domain\Repository\StepnameRepository	$stepnameRepository
     */
    protected $stepnameRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository
     * @return void
     */
    /** @noinspection PhpUnused */
    public function injectStepnameRepository(StepnameRepository $stepnameRepository): void
    {
        $this->stepnameRepository = $stepnameRepository;
    }

    /**
     * @var \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;

    /**
     * @param	\Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     * @return	void
     */
    /** @noinspection PhpUnused */
    public function injectExtensionHelperService(ExtensionHelperService $extensionHelperService): void
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Constructs a new stepconfig object
     * @param \Thucke\ThRating\Domain\Model\Ratingobject|null $ratingobject
     * @param null $steporder
     */
    public function __construct(Ratingobject $ratingobject = null, $steporder = null)
    {
        if ($ratingobject) {
            $this->setRatingobject($ratingobject);
        }
        if ($steporder) {
            $this->setSteporder($steporder);
        }
        $this->initializeObject();
    }

    /**
     * Initializes a new stepconf object
     * @return void
     */
    public function initializeObject(): void
    {
        //Initialize vote storage if rating is new
        if (!is_object($this->votes)) {
            $this->votes = new ObjectStorage();
        }
    }

    /**
     * Sets the ratingobject this rating is part of
     *
     * @param \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject The Rating
     * @return void
     */
    public function setRatingobject(Ratingobject $ratingobject): void
    {
        $this->ratingobject = $ratingobject;
        $this->setPid($ratingobject->getPid());
    }

    /**
     * Returns the ratingobject this rating is part of
     *
     * @return \Thucke\ThRating\Domain\Model\Ratingobject The ratingobject this rating is part of
     */
    public function getRatingobject(): Ratingobject
    {
        return $this->ratingobject;
    }

    /**
     * Sets the stepconfig order
     *
     * @param int $steporder
     * @return void
     */
    public function setSteporder($steporder): void
    {
        $this->steporder = $steporder;
    }

    /**
     * Gets the stepconfig order
     *
     * @return int stepconfig position
     */
    public function getSteporder(): int
    {
        return $this->steporder;
    }

    /**
     * Sets the stepconfig value
     *
     * @param int $stepweight
     * @return void
     */
    public function setStepweight($stepweight): void
    {
        $this->stepweight = $stepweight;
    }

    /**
     * Gets the stepconfig value
     * If not set steporder is copied
     *
     * @return int Stepconfig value
     */
    public function getStepweight(): int
    {
        empty($this->stepweight) && $this->stepweight = $this->steporder;

        return $this->stepweight;
    }

    /**
     * Adds a localized stepname to this stepconf
     *
     * @param \Thucke\ThRating\Domain\Model\Stepname $stepname
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return bool
     */
    public function addStepname(Stepname $stepname): bool
    {
        $success = true;
        $stepname->setStepconf($this);
        if (!$this->stepnameRepository->existStepname($stepname)) {
            $defaultLanguageObject = $this->stepnameRepository->findDefaultStepname($stepname);
            if (is_object($defaultLanguageObject)) {
                //handle localization if an entry for the default language exists
                $stepname->setL18nParent($defaultLanguageObject->getUid());
            } else {
                $stepname->setL18nParent(null);
                $this->stepname = $stepname;
            }
            $this->stepnameRepository->add($stepname);
            $this->extensionHelperService->persistRepository(StepnameRepository::class, $stepname);
            $this->extensionHelperService->persistRepository(StepconfRepository::class, $this);
            $this->extensionHelperService->clearDynamicCssFile();
        } else {
            //warning - existing stepname entry for a language will not be overwritten
            $success = false;
        }

        return $success;
    }

    /**
     * Returns the localized stepname object of this stepconf
     *
     * @return \Thucke\ThRating\Domain\Model\Stepname|null
     */
    public function getStepname()
    {
        if ($this->stepname instanceof LazyLoadingProxy) {
            $this->stepname = $this->stepname->_loadRealInstance();
        }
        return $this->stepname;
    }

    /**
     * Returns all votes in this rating
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Vote>
     */
    /** @noinspection PhpUnused */
    public function getVotes()
    {
        return clone $this->votes;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->steporder) && empty($this->ratingobject);
    }

    /**
     * Method to use Object as plain string
     *
     * @return string
     */
    public function __toString(): string
    {
        $stepnameText = $this->getStepname();
        if (!$stepnameText) {
            $stepnameText = $this->getSteporder();
        }
        return (string)$stepnameText;
    }
}
