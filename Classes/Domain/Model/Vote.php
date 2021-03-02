<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Model for rating votes
 *
 * @copyright  Copyright belongs to the respective authors
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @entity
 */
class Vote extends AbstractEntity
{
    /**
     * @Extbase\Validate("\Thucke\ThRating\Domain\Validator\RatingValidator")
     * @Extbase\Validate("NotEmpty")
     * @var      \Thucke\ThRating\Domain\Model\Rating
     */
    protected $rating;

    /**
     * The voter of this object
     *
     * @Extbase\Validate("NotEmpty")
     * @var    \Thucke\ThRating\Domain\Model\Voter
     */
    protected $voter;

    /**
     * The actual voting of this object
     *
     * @Extbase\Validate("\Thucke\ThRating\Domain\Validator\StepconfValidator")
     * @Extbase\Validate("NotEmpty")
     * @var      \Thucke\ThRating\Domain\Model\Stepconf
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
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    /** @noinspection PhpUnused */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
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
     */
    public function initializeObject()
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
     */
    public function setRating(Rating $rating)
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
     * @param \Thucke\ThRating\Domain\Model\Voter $voter The frontenduser
     */
    public function setVoter(Voter $voter)
    {
        $this->voter = $voter;
    }

    /**
     * Returns the frontenduser of this vote
     *
     * @return \Thucke\ThRating\Domain\Model\Voter|null
     */
    public function getVoter(): ?Voter
    {
        return $this->voter;
    }

    /**
     * Sets the choosen stepconfig
     *
     * @param \Thucke\ThRating\Domain\Model\Stepconf $vote
     */
    public function setVote($vote)
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
    public function hasRated()
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
        return $this->getVoter()->getUid() === (int)$this->settings['mapAnonymous'] &&
            !empty($this->settings['mapAnonymous']);
    }

    /**
     * Checks cookie if anonymous vote is already done
     * always false if cookie checks is deactivated
     *
     * @param string $prefixId Extension prefix to identify cookie
     * @return  bool
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
