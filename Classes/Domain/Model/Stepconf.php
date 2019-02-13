<?php
namespace Thucke\ThRating\Domain\Model;

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
class Stepconf extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
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
    public function injectStepnameRepository(\Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository)
    {
        $this->stepnameRepository = $stepnameRepository;
    }

    /**
     * @var \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     */
    protected $extensionHelperService;
    /**
     * @param	\Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     * @return	void
     */
    public function injectExtensionHelperService(\Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService)
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Constructs a new stepconfig object
     * @param Ratingobject|null $ratingobject
     * @param null $steporder
     */
    public function __construct(Ratingobject $ratingobject = null, $steporder=null)
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
    public function initializeObject()
    {
        //Initialize vote storage if rating is new
        if (!is_object($this->votes)) {
            $this->votes = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        }
    }

    /**
     * Sets the ratingobject this rating is part of
     *
     * @param Ratingobject $ratingobject The Rating
     * @return void
     */
    public function setRatingobject(Ratingobject $ratingobject)
    {
        $this->ratingobject = $ratingobject;
        $this->setPid($ratingobject->getPid());
    }

    /**
     * Returns the ratingobject this rating is part of
     *
     * @return \Thucke\ThRating\Domain\Model\Ratingobject The ratingobject this rating is part of
     */
    public function getRatingobject()
    {
        return $this->ratingobject;
    }

    /**
     * Sets the stepconfig order
     *
     * @param int $steporder
     * @return void
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
    public function getSteporder()
    {
        return $this->steporder;
    }

    /**
     * Sets the stepconfig value
     *
     * @param int $stepweight
     * @return void
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
     * @param Stepname $stepname
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function addStepname(Stepname $stepname)
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
            $this->extensionHelperService->persistRepository('Thucke\ThRating\Domain\Repository\StepnameRepository', $stepname);
            $this->extensionHelperService->persistRepository('Thucke\ThRating\Domain\Repository\StepconfRepository', $this);
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
     * @return Stepname
     */
    public function getStepname()
    {
        if ($this->stepname instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
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
     * @return bool
     */
    public function isValid()
    {
        return empty($this->steporder) && empty($this->ratingobject);
    }
    /**
     * Method to use Object as plain string
     *
     * @return string
     */
    public function __toString()
    {
        $stepname = $this->getStepname();
        if ($stepname) {
        } else {
            $stepname = $this->getSteporder();
        }
        return strval($stepname);
    }
}
