<?php
namespace Thucke\ThRating\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

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
 * Model for rating votes
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class Vote extends AbstractEntity
{
    /**
     * @var         \Thucke\ThRating\Domain\Model\Rating
     * @validate    \Thucke\ThRating\Domain\Validator\RatingValidator
     * @validate 	NotEmpty
     */
    protected $rating;

    /**
     * The voter of this object
     *
     * @var    \Thucke\ThRating\Domain\Model\Voter
     * @validate NotEmpty
     */
    protected $voter;

    /**
     * The actual voting of this object
     *
     * @var         \Thucke\ThRating\Domain\Model\Stepconf
     * @validate    \Thucke\ThRating\Domain\Validator\StepconfValidator
     * @validate    NotEmpty
     */
    protected $vote;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
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
     * Constructs a new rating object
     *
     * @param \Thucke\ThRating\Domain\Model\Rating|null $rating
     * @param \Thucke\ThRating\Domain\Model\Voter|null $voter
     * @param \Thucke\ThRating\Domain\Model\Stepconf|null $vote
     * @throws InvalidConfigurationTypeException
     * return void
     */
    /** @noinspection PhpUnused */
    public function __construct(
        Rating $rating = null,
        Voter $voter = null,
        Stepconf $vote = null
    ) {
        if ($rating) {
            $this->setRating($rating);
        }
        if ($voter) {
            $this->setVoter($voter);
        }
        if ($vote) {
            $this->setVote($vote);
        }
        $this->initializeObject();
    }

    /**
     * Initializes the new vote object
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @return void
     */
    public function initializeObject(): void
    {
        if (empty($this->objectManager)) {
            $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        }
        $this->settings = $this->objectManager->get(ConfigurationManager::class)->getConfiguration(
            'Settings',
            'thRating',
            'pi1'
        );
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this,get_class($this).' initializeObject');
    }

    /**
     * Sets the rating this vote is part of
     *
     * @param \Thucke\ThRating\Domain\Model\Rating $rating The Rating
     * @return void
     */
    public function setRating(Rating $rating): void
    {
        $this->rating = $rating;
        $this->setPid($rating->getPid());
    }

    /**
     * Returns the rating this vote is part of
     *
     * @return \Thucke\ThRating\Domain\Model\Rating The rating this vote is part of
     */
    public function getRating(): Rating
    {
        return $this->rating;
    }

    /**
     * Sets the frontenduser of this vote
     *
     * @param \Thucke\ThRating\Domain\Model\Voter $voter	The frontenduser
     * @return void
     */
    public function setVoter(Voter $voter): void
    {
        $this->voter = $voter;
    }

    /**
     * Returns the frontenduser of this vote
     *
     * @return \Thucke\ThRating\Domain\Model\Voter    The frontenduser of this vote
     */
    public function getVoter(): Voter
    {
        return $this->voter;
    }

    /**
     * Sets the choosen stepconfig
     *
     * @param \Thucke\ThRating\Domain\Model\Stepconf $vote
     * @return void
     */
    public function setVote($vote): void
    {
        $this->vote = $vote;
    }

    /**
     * Gets the rating object uid
     *
     * @return \Thucke\ThRating\Domain\Model\Stepconf|null Reference to selected stepconfig
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Sets the rating this vote is part of
     *
     * @return bool
     */
    /** @noinspection PhpUnused */
    public function hasRated(): bool
    {
        return $this->getVote() !== null && ($this->getVote() instanceof Stepconf);
    }

    /**
     * Checks if vote is done by anonymous user
     *
     * @return bool
     */
    public function isAnonymous(): bool
    {
        if ($this->getVoter() instanceof Voter) {
            $retVal = $this->getVoter()->getUid() === (int)$this->settings['mapAnonymous'] && !empty($this->settings['mapAnonymous']);
        } else {
            $retVal = false;
        }

        return $retVal;
    }

    /**
     * Checks cookie if anonymous vote is already done
     * always false if cookie checks is deactivated
     *
     * @param string $prefixId Extension prefix to identify cookie
     * @return 	bool
     */
    public function hasAnonymousVote($prefixId = 'DummyPrefix'): bool
    {
        $anonymousRating = json_decode($_COOKIE[$prefixId . '_AnonymousRating_' . $this->getRating()->getUid()], true);
        return !empty($anonymousRating['voteUid']);
    }

    /**
     * Method to use Object as plain string
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->getVote();
    }
}
