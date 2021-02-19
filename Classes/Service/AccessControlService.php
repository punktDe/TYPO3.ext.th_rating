<?php
/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
namespace Thucke\ThRating\Service;

use Thucke\ThRating\Exception\FeUserNotFoundException;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use \Thucke\ThRating\Domain\Model\Voter;

/***************************************************************
*  Copyright notice
*
*  (c) 2013 Thomas Hucke <thucke@web.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General protected License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General protected License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General protected License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * An access control service
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU protected License, version 2
 */
class AccessControlService extends AbstractExtensionService
{
    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $frontendUserRepository
     */
    protected $frontendUserRepository;

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $frontendUserRepository
     * @noinspection PhpUnused
     */
    public function injectFrontendUserRepository(FrontendUserRepository $frontendUserRepository): void
    {
        $this->frontendUserRepository = $frontendUserRepository;
    }

    /**
     * @var \Thucke\ThRating\Domain\Repository\VoterRepository $voterRepository
     */
    protected $voterRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\VoterRepository $voterRepository
     */
    public function injectVoterRepository(\Thucke\ThRating\Domain\Repository\VoterRepository $voterRepository): void
    {
        $this->voterRepository = $voterRepository;
    }

    /**
     * @var \TYPO3\CMS\Core\Context\Context $context
     */
    protected $context;
    /**
     * @param \TYPO3\CMS\Core\Context\Context $context
     */
    public function injectContext(\TYPO3\CMS\Core\Context\Context $context): void
    {
        $this->context = $context;
    }

    /**
     * Tests, if the given person is logged into the frontend
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser|null $person The person
     * @return bool    The result; true if the given person is logged in; otherwise false
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public function isLoggedIn(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $person = null): bool
    {
        if ($person instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage) {
            $person->current();
        }
        if (is_object($person)) {
            if ($person->getUid() &&
                    ($person->getUid() === $this->getFrontendUserUid())) {
                return true; //treat anonymous user also as logged in
            }
        }
        return false;
    }

    /**
     * @return bool
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public function backendAdminIsLoggedIn(): bool
    {
        return $this->context->getPropertyFromAspect('backend.user', 'isLoggedIn');
    }

    /**
     * @return bool
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public function hasLoggedInFrontendUser(): bool
    {
        /** @var Context $context */
        return $this->context->getPropertyFromAspect('frontend.user', 'isLoggedIn');
    }

    /**
     * @return array
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public function getFrontendUserGroups(): array
    {
        if ($this->hasLoggedInFrontendUser()) {
            return $this->context->getPropertyFromAspect('frontend.user', 'groupIds');
        }
        return [];
    }

    /**
     * @return int|null
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public function getFrontendUserUid(): ?int
    {
        if ($this->hasLoggedInFrontendUser()) {
            return $this->context->getPropertyFromAspect('frontend.user', 'id');
        }
        return null;
    }

    /**
     * Loads objects from repositories
     *
     * @param mixed $voter
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public function getFrontendUser($voter = null): ?\TYPO3\CMS\Extbase\Domain\Model\FrontendUser
    {
        //set userobject
        if (!$voter instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
            //TODO Errorhandling if no user is logged in
            if ((int)$voter === 0) {
                //get logged in fe-user
                $voter = $this->frontendUserRepository->findByUid($this->getFrontendUserUid());
            } else {
                $voter = $this->frontendUserRepository->findByUid((int)$voter);
            }
        }
        return $voter;
    }

    /**
     * Loads objects from repositories
     *
     * @param int|null $voter
     * @return \Thucke\ThRating\Domain\Model\Voter
     * @throws FeUserNotFoundException
     * @throws \TYPO3\CMS\Core\Context\Exception\AspectNotFoundException
     */
    public function getFrontendVoter(?int $voter = 0): Voter
    {
        $exceptionMessageArray = [];

        /** @var Voter $voterObject */
        $voterObject = null;

        //TODO Errorhandling if no user is logged in
        if ((int)$voter === 0) {
            //get logged in fe-user
            $voterObject = $this->voterRepository->findByUid($this->getFrontendUserUid());
            $exceptionMessageArray = [$this->getFrontendUserUid()];
            $exceptionMessageType = 'feUser';
        } else {
            $voterObject = $this->voterRepository->findByUid((int)$voter);
            $exceptionMessageArray = [(int)$voter];
            $exceptionMessageType = 'anonymousUser';
        }

        if (empty($voterObject)) {
            throw new FeUserNotFoundException(
                LocalizationUtility::translate(
                    'flash.pluginConfiguration.missing.' . $exceptionMessageType,
                    'ThRating',
                    $exceptionMessageArray
                ),
                1602095329
            );
        }

        return $voterObject;
    }
}
