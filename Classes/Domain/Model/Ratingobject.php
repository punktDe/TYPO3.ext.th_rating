<?php
namespace Thucke\ThRating\Domain\Model;

use Thucke\ThRating\Domain\Repository\RatingRepository;
use Thucke\ThRating\Domain\Repository\StepconfRepository;
use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * Aggregate object for rating of content objects
 *
 * @version 	$Id:$
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Ratingobject extends AbstractEntity
{
    /**
     * Table name of the cObj
     * Defaults to Typo3 tablename of pages
     *
     * @var string
     * @validate StringLength(minimum = 3, maximum = 60)
     * @validate NotEmpty
     */
    protected $ratetable;

    /**
     * Fieldname within the table of the cObj
     * Defaults to the field 'uid'
     *
     * @var string
     * @validate StringLength(minimum = 3, maximum = 60)
     * @validate NotEmpty
     */
    protected $ratefield;

    /**
     * The stepconfs of this object
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf>
     * @lazy
     * @cascade remove
     */
    protected $stepconfs;

    /**
     * The ratings of this object
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Rating>
     * @lazy
     * @cascade remove
     */
    protected $ratings;

    /**
     * @var \Thucke\ThRating\Domain\Repository\StepconfRepository
     */
    protected $stepconfRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\StepconfRepository $stepconfRepository
     */
    /** @noinspection PhpUnused */
    public function injectStepconfRepository(StepconfRepository $stepconfRepository): void
    {
        $this->stepconfRepository = $stepconfRepository;
    }

    /**
     * @var  \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;

    /**
     * @param	\Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     */
    /** @noinspection PhpUnused */
    public function injectExtensionHelperService(ExtensionHelperService $extensionHelperService): void
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Constructs a new rating object
     * @param	string	$ratetable The rating objects table name
     * @param	string	$ratefield The rating objects field name
     * @validate 	$ratetable StringLength(minimum = 3, maximum = 60)
     * @validate	$ratefield StringLength(minimum = 3, maximum = 60)
     */
    public function __construct($ratetable = null, $ratefield = null)
    {
        if ($ratetable) {
            $this->setRatetable($ratetable);
        }
        if ($ratefield) {
            $this->setRatefield($ratefield);
        }
        $this->initializeObject();
    }

    /**
     * Initializes a new ratingobject
     */
    public function initializeObject(): void
    {
        //Initialize rating storage if ratingobject is new
        if (!is_object($this->ratings)) {
            $this->ratings = new ObjectStorage();
        }
        //Initialize stepconf storage if ratingobject is new
        if (!is_object($this->stepconfs)) {
            $this->stepconfs = new ObjectStorage();
        }
    }

    /**
     * Sets the rating table name
     *
     * @param string $ratetable
     */
    public function setRatetable($ratetable): void
    {
        $this->ratetable = $ratetable;
    }

    /**
     * Gets the rating table name
     *
     * @return string Rating object table name
     */
    public function getRatetable(): string
    {
        return $this->ratetable;
    }

    /**
     * Sets the rating field name
     *
     * @param string $ratefield
     */
    public function setRatefield($ratefield): void
    {
        $this->ratefield = $ratefield;
    }

    /**
     * Sets the rating field name
     *
     * @return string Rating object field name
     */
    public function getRatefield(): string
    {
        return $this->ratefield;
    }

    /**
     * Adds a rating to this object
     *
     * @param \Thucke\ThRating\Domain\Model\Rating $rating
     */
    /** @noinspection PhpUnused */
    public function addRating(Rating $rating): void
    {
        $this->ratings->attach($rating);
        $this->extensionHelperService->persistRepository(RatingRepository::class, $rating);
        $this->extensionHelperService->clearDynamicCssFile();
    }

    /**
     * Remove a rating from this object
     *
     * @param \Thucke\ThRating\Domain\Model\Rating $rating The rating to be removed
     */
    /** @noinspection PhpUnused */
    public function removeRating(Rating $rating): void
    {
        $this->ratings->detach($rating);
    }

    /**
     * Remove all ratings from this object
     */
    /** @noinspection PhpUnused */
    public function removeAllRatings(): void
    {
        $this->ratings = new ObjectStorage();
    }

    /**
     * Adds a stepconf to this object
     *
     * @param \Thucke\ThRating\Domain\Model\Stepconf $stepconf
     */
    public function addStepconf(Stepconf $stepconf): void
    {
        if (!$this->stepconfRepository->existStepconf($stepconf)) {
            $this->stepconfs->attach($stepconf);
            $this->extensionHelperService->persistRepository(StepconfRepository::class, $stepconf);
            $this->extensionHelperService->clearDynamicCssFile();
        }
    }

    /**
     * Sets all ratings of this ratingobject
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf> $stepconfs The step configurations for this ratingobject
     */
    /** @noinspection PhpUnused */
    public function setStepconfs(ObjectStorage $stepconfs): void
    {
        $this->stepconfs = $stepconfs;
    }

    /**
     * Returns all ratings in this object
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf>
     */
    public function getStepconfs()
    {
        return clone $this->stepconfs;
    }

    /**
     * Sets all ratings of this ratingobject
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Rating> $ratings The ratings of the organization
     */
    /** @noinspection PhpUnused */
    public function setRatings(ObjectStorage $ratings): void
    {
        $this->ratings = $ratings;
    }

    /**
     * Returns all ratings in this object
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Thucke\ThRating\Domain\Model\Rating>
     */
    /** @noinspection PhpUnused */
    public function getRatings()
    {
        return clone $this->ratings;
    }
}
