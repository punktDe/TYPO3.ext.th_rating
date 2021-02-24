<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Domain\Model;

use Thucke\ThRating\Domain\Repository\StepconfRepository;
use Thucke\ThRating\Domain\Repository\StepnameRepository;
use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Model for ratingstep configuration
 *
 * @copyright  Copyright belongs to the respective authors
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @entity
 */
class Stepconf extends AbstractEntity
{
    /**
     * @Extbase\Validate("\Thucke\ThRating\Domain\Validator\RatingobjectValidator")
     * @Extbase\Validate("NotEmpty")
     * @var \Thucke\ThRating\Domain\Model\Ratingobject
     */
    protected $ratingobject;

    /**
     * The order of this config entry
     *
     * @Extbase\Validate("NumberRange", options={"minimum": 1})
     * @Extbase\Validate("NotEmpty")
     * @var int discrete order of ratingsteps
     */
    protected $steporder;

    /**
     * The weight of this config entry
     *
     * @Extbase\Validate("NumberRange", options={"minimum": 1})
     * @var float  default is 1 which is equal weight
     */
    protected $stepweight;

    /**
     * The value of this config entry
     *
     * @Extbase\ORM\Lazy
     * @Extbase\ORM\Cascade("remove")
     * @var \Thucke\ThRating\Domain\Model\Stepname
     */
    protected $stepname;

    /**
     * The ratings of this object
     *
     * @Extbase\ORM\Lazy
     * @Extbase\ORM\Cascade("remove")
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Vote>
     */
    protected $votes;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    protected $objectManager;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    /** @noinspection PhpUnused */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @var \Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository
     */
    protected $stepnameRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository
     */
    /** @noinspection PhpUnused */
    public function injectStepnameRepository(StepnameRepository $stepnameRepository)
    {
        $this->stepnameRepository = $stepnameRepository;
    }

    /**
     * @var \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;

    /**
     * @param \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     */
    /** @noinspection PhpUnused */
    public function injectExtensionHelperService(ExtensionHelperService $extensionHelperService)
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
     */
    public function initializeObject()
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
     */
    public function setRatingobject(Ratingobject $ratingobject)
    {
        $this->ratingobject = $ratingobject;
        $this->setPid($ratingobject->getPid());
    }

    /**
     * Returns the ratingobject this rating is part of
     *
     * @return \Thucke\ThRating\Domain\Model\Ratingobject|null
     */
    public function getRatingobject()
    {
        return $this->ratingobject;
    }

    /**
     * Sets the stepconfig order
     *
     * @param int $steporder
     */
    public function setSteporder($steporder)
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
     */
    public function setStepweight($stepweight)
    {
        $this->stepweight = $stepweight;
    }

    /**
     * Gets the stepconfig value
     * If not set steporder is copied
     *
     * @return int Stepconfig value
     */
    public function getStepweight()
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
            $stepname->getStepconf()->getStepname();
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
    public function getVotes()
    {
        return clone $this->votes;
    }

    /**
     * Method to use Object as plain string
     *
     * @return string
     */
    public function __toString()
    {
        $stepnameText = $this->getStepname();
        if (!$stepnameText) {
            $stepnameText = $this->getSteporder();
        }
        return (string)$stepnameText;
    }
}
