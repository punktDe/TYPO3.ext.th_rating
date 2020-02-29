<?php
/** @noinspection PhpMissingFieldTypeInspection */
/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
namespace Thucke\ThRating\Controller;

use mysql_xdevapi\Exception;
use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Model\Vote;
use Thucke\ThRating\Domain\Model\Voter;
use Thucke\ThRating\Domain\Repository\RatingobjectRepository;
use Thucke\ThRating\Domain\Repository\StepconfRepository;
use Thucke\ThRating\Domain\Repository\VoteRepository;
use Thucke\ThRating\Domain\Validator\RatingValidator;
use Thucke\ThRating\Domain\Validator\StepconfValidator;
use Thucke\ThRating\Domain\Validator\VoteValidator;
use Thucke\ThRating\Exception\FeUserStoragePageException;
use Thucke\ThRating\Exception\InvalidStoragePageException;
use Thucke\ThRating\Service\AccessControlService;
use Thucke\ThRating\Service\CookieService;
use Thucke\ThRating\Service\ExtensionHelperService;
use Thucke\ThRating\Service\ExtensionManagementService;
use Thucke\ThRating\Service\RichSnippetService;
use Thucke\ThRating\View\JsonView;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Hucke <thucke@web.de>
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
 * The Vote Controller
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class VoteController extends ActionController
{
    protected const AJAX_REFERENCE_ID = 'ajaxRef';

    /**
     * @var \Thucke\ThRating\Domain\Model\Vote
     */
    protected $vote;
    /**
     * @var \Thucke\ThRating\Domain\Model\RatingImage
     */
    protected $ratingImage;
    /**
     * @var array
     */
    protected $ajaxSelections;
    /**
     * @var string
     */
    protected $ratingName;
    /**
     * @var bool
     */
    protected $cookieProtection;
    /**
     * @var int
     */
    protected $cookieLifetime;
    /**
     * @var array
     */
    protected $signalSlotHandlerContent;
    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;
    /**
     * @var string
     */
    protected $prefixId;

    /**
     * @var \Thucke\ThRating\Service\AccessControlService
     */
    protected $accessControlService;

    /**
     * @param \Thucke\ThRating\Service\AccessControlService $accessControlService
     */
    /** @noinspection PhpUnused */
    public function injectAccessControlService(AccessControlService $accessControlService): void
    {
        $this->accessControlService = $accessControlService;
    }

    /**
     * @var \Thucke\ThRating\Service\RichSnippetService
     */
    protected $richSnippetService;

    /**
     * @param \Thucke\ThRating\Service\RichSnippetService $richSnippetService
     */
    /** @noinspection PhpUnused */
    public function injectRichSnippetService(RichSnippetService $richSnippetService): void
    {
        $this->richSnippetService = $richSnippetService;
    }

    /**
     * @var \Thucke\ThRating\Service\CookieService
     */
    protected $cookieService;

    /**
     * @param \Thucke\ThRating\Service\CookieService $cookieService
     */
    /** @noinspection PhpUnused */
    public function injectCookieService(CookieService $cookieService): void
    {
        $this->cookieService = $cookieService;
    }

    /**
     * @var \Thucke\ThRating\Domain\Repository\VoteRepository
     */
    protected $voteRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\VoteRepository $voteRepository
     */
    /** @noinspection PhpUnused */
    public function injectVoteRepository(VoteRepository $voteRepository): void
    {
        $this->voteRepository = $voteRepository;
    }

    /**
     * @var \Thucke\ThRating\Domain\Validator\VoteValidator
     */
    protected $voteValidator;

    /**
     * @param    \Thucke\ThRating\Domain\Validator\VoteValidator $voteValidator
     */
    /** @noinspection PhpUnused */
    public function injectVoteValidator(VoteValidator $voteValidator): void
    {
        $this->voteValidator = $voteValidator;
    }

    /**
     * @var \Thucke\ThRating\Domain\Validator\RatingValidator
     */
    protected $ratingValidator;

    /**
     * @param    \Thucke\ThRating\Domain\Validator\RatingValidator $ratingValidator
     */
    /** @noinspection PhpUnused */
    public function injectRatingValidator(RatingValidator $ratingValidator): void
    {
        $this->ratingValidator = $ratingValidator;
    }

    /**
     * @var \Thucke\ThRating\Domain\Repository\RatingobjectRepository
     */
    protected $ratingobjectRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\RatingobjectRepository $ratingobjectRepository
     */
    /** @noinspection PhpUnused */
    public function injectRatingobjectRepository(RatingobjectRepository $ratingobjectRepository): void
    {
        $this->ratingobjectRepository = $ratingobjectRepository;
    }

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
     * @var \Thucke\ThRating\Domain\Validator\StepconfValidator
     */
    protected $stepconfValidator;

    /**
     * @param \Thucke\ThRating\Domain\Validator\StepconfValidator $stepconfValidator
     */
    /** @noinspection PhpUnused */
    public function injectStepconfValidator(StepconfValidator $stepconfValidator): void
    {
        $this->stepconfValidator = $stepconfValidator;
    }

    /**
     * @var \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;

    /**
     * @param \Thucke\ThRating\Service\ExtensionHelperService $extensionHelperService
     */
    /** @noinspection PhpUnused */
    public function injectExtensionHelperService(ExtensionHelperService $extensionHelperService): void
    {
        $this->extensionHelperService = $extensionHelperService;
    }

    /**
     * Lifecycle-Event
     * wird nach der Initialisierung des Objekts und nach dem Auflösen der Dependencies aufgerufen.
     */
    public function initializeObject(): void
    {
    }

    /**
     * Initializes the current action
     *
     * @return void
     * @throws FeUserStoragePageException
     * @throws InvalidStoragePageException*
     * @throws \Exception
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    /** @noinspection PhpMissingParentCallCommonInspection */
    protected function initializeAction(): void
    {
        //instantiate the logger
        $this->logger = GeneralUtility::makeInstance(ObjectManager::class)
            ->get(ExtensionHelperService::class)->getLogger(__CLASS__);

        $this->logger->log(LogLevel::DEBUG, 'Entry point');

        $this->prefixId =
            strtolower("tx_{$this->request->getControllerExtensionName()}_{$this->request->getPluginName()}");

        //Set default storage pids to SITEROOT
        $this->setStoragePids();

        /** @var array $frameworkConfiguration */
        $frameworkConfiguration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );

        if ($this->request->hasArgument(self::AJAX_REFERENCE_ID)) {
            //switch to JSON respone on AJAX request
            $this->request->setFormat('json');
            $this->defaultViewObjectName = JsonView::class;
            //read unique AJAX identification on AJAX request
            $this->ajaxSelections['ajaxRef'] = $this->request->getArgument(self::AJAX_REFERENCE_ID);
            $this->settings = json_decode($this->request->getArgument('settings'), true, 512, PHP_MINOR_VERSION>=3 ? JSON_THROW_ON_ERROR : null);
            $frameworkConfiguration['settings'] = $this->settings;
            $this->initSettings();
            $this->logger->log(
                LogLevel::INFO,
                'AJAX request detected - set new frameworkConfiguration',
                $frameworkConfiguration
            );
            //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->settings,get_class($this).' initializeAction');
        } else {
            //set unique AJAX identification
            $this->ajaxSelections['ajaxRef'] = $this->prefixId . '_' . $this->getRandomId();
            $this->logger->log(LogLevel::DEBUG, 'Set id for AJAX requests', $this->ajaxSelections);
        }

        if (!is_array($frameworkConfiguration['ratings'])) {
            $frameworkConfiguration['ratings'] = [];
        }
        ArrayUtility::mergeRecursiveWithOverrule(
            $this->settings['ratingConfigurations'],
            $frameworkConfiguration['ratings']
        )
        ;
        $this->setFrameworkConfiguration($frameworkConfiguration);
    }

    /**
     * Index action for this controller.
     *
     * @return void
     * @throws \TYPO3\CMS\Core\Exception\SiteNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @throws \Thucke\ThRating\Exception\Exception
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     */
    public function indexAction(): void
    {
        // @var \Thucke\ThRating\Domain\Model\Ratingobject $ratingobject
        //update foreign table for each rating
        foreach ($this->ratingobjectRepository->findAll() as $ratingobject) {
            foreach ($ratingobject->getRatings() as $rating) {
                $this->setForeignRatingValues($rating);
            }
        }
        $this->view->assign('ratingobjects', $this->ratingobjectRepository->findAll());

        //initialize ratingobject and autocreate four ratingsteps
        $ratingobject = $this->objectManager
            ->get(ExtensionManagementService::class)
            ->makeRatable('TestTable', 'TestField', 4);
        //add descriptions in default language to each stepconf
        $this->objectManager->get(ExtensionManagementService::class)->setStepname(
            $ratingobject->getStepconfs()->current(),
            'Automatic generated entry ',
            0,
            true
        );
        //add descriptions in german language to each stepconf
        $this->objectManager->get(ExtensionManagementService::class)->setStepname(
            $ratingobject->getStepconfs()->current(),
            'Automatischer Eintrag ',
            43,
            true
        );
    }

    /**
     * Includes the hidden form to handle AJAX requests
     *
     * @return void
     * @noinspection PhpUnused
     */
    public function singletonAction(): void
    {
        $this->logger->log(LogLevel::DEBUG, 'Entry singletonAction');

        $messageArray = $this->extensionHelperService->renderDynCSS();
        //generate dynamic CSS file and add messages to flashMessageQueue
        foreach ($messageArray as $message) {
            $this->logFlashMessage(
                $message['messageText'],
                $message['messageTitle'],
                $message['severity'],
                $message['additionalInfo']
            );
        }
        $this->controllerContext->getFlashMessageQueue()->clear();
        $this->logger->log(LogLevel::DEBUG, 'Exit singletonAction');
    }

    /**
     * Displays the vote of the current user
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote
     * @return void
     * @throws \TYPO3\CMS\Core\Exception
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     * @noinspection PhpUnused
     */
    public function showAction(\Thucke\ThRating\Domain\Model\Vote $vote = null): void
    {
        $this->logger->log(LogLevel::DEBUG, 'Entry showAction');
        //is_object($vote) && \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($vote->getUid(),'showAction');
        $this->initVoting($vote);  //just to set all properties

        $this->fillSummaryView();
        if (!$this->voteValidator->validate($this->vote)->hasErrors()) {
            if ($this->accessControlService->isLoggedIn($vote->getVoter()) || $vote->isAnonymous()) {
            } else {
                $this->logFlashMessage(
                    LocalizationUtility::translate('flash.vote.create.noPermission', 'ThRating'),
                    LocalizationUtility::translate('flash.heading.error', 'ThRating'),
                    'ERROR',
                    ['errorCode' => 1403201246]
                );
            }
        }
        $this->view->assign('actionMethodName', $this->actionMethodName);
        $this->logger->log(LogLevel::DEBUG, 'Exit showAction');
    }

    /**
     * Creates a new vote
     *
     * @param  \Thucke\ThRating\Domain\Model\Vote $vote
     * @return void
     * @throws \TYPO3\CMS\Core\Exception
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @noinspection PhpUnused
     */
    public function createAction(\Thucke\ThRating\Domain\Model\Vote $vote): void
    {
        //http://localhost:8503/index.php?id=71&tx_thrating_pi1[controller]=Vote&tx_thrating_pi1[action]=create&
        //tx_thrating_pi1[vote][rating]=1&tx_thrating_pi1[vote][voter]=1&tx_thrating_pi1[vote][vote]=1
        $this->logger->log(LogLevel::DEBUG, 'Entry createAction', ['errorCode' => 1404934047]);
        if ($this->accessControlService->isLoggedIn($vote->getVoter()) || $vote->isAnonymous()) {
            $this->logger->log(LogLevel::DEBUG, 'Start processing', ['errorCode' => 1404934054]);
            //if not anonymous check if vote is already done
            if (!$vote->isAnonymous()) {
                $this->logger->log(
                    LogLevel::DEBUG,
                    'FE user is logged in - looking for existing vote',
                    ['errorCode' => 1404933999]
                );
                /** @var \Thucke\ThRating\Domain\Model\Vote $matchVote */
                $matchVote = $this->voteRepository->findMatchingRatingAndVoter($vote->getRating(), $vote->getVoter());
            }
            //add new or anonymous vote
            /** @noinspection PhpUndefinedVariableInspection */
            if ($this->voteValidator->validate($matchVote)->hasErrors() || $vote->isAnonymous()) {
                $this->logger->log(LogLevel::DEBUG, 'New vote could be added', ['errorCode' => 1404934012]);
                $vote->getRating()->addVote($vote);
                if ($this->cookieProtection && $vote->isAnonymous() && !$vote->hasAnonymousVote($this->prefixId)) {
                    $this->logger->log(
                        LogLevel::DEBUG,
                        'Anonymous rating; preparing cookie potection',
                        ['errorCode' => 1404934021]
                    );
                    $anonymousRating['ratingtime'] = time();
                    $anonymousRating['voteUid'] = $vote->getUid();
                    $lifeTime = (new \DateTime('NOW'))
                        ->add(\DateInterval::createFromDateString($this->cookieLifetime . ' days'));
                    //set cookie to prevent multiple anonymous ratings
                    $this->cookieService->setVoteCookie(
                        $this->prefixId . '_AnonymousRating_' . $vote->getRating()->getUid(),
                        json_encode($anonymousRating),
                        $lifeTime
                    );
                }
                $setResult = $this->setForeignRatingValues($vote->getRating());
                if (!$setResult) {
                    $this->logFlashMessage(
                        LocalizationUtility::translate('flash.vote.create.foreignUpdateFailed', 'ThRating'),
                        LocalizationUtility::translate('flash.heading.warning', 'ThRating'),
                        'WARNING',
                        [
                            'errorCode' => 1403201551,
                            'ratingobject' => $vote->getRating()->getRatingobject()->getUid(),
                            'ratetable' => $vote->getRating()->getRatingobject()->getRatetable(),
                            'ratefield' => $vote->getRating()->getRatingobject()->getRatefield()
                        ]
                    );
                }
                $this->logFlashMessage(
                    LocalizationUtility::translate('flash.vote.create.newCreated', 'ThRating'),
                    LocalizationUtility::translate('flash.heading.ok', 'ThRating'),
                    'DEBUG',
                    [
                        'ratingobject' => $vote->getRating()->getRatingobject()->getUid(),
                        'ratetable' => $vote->getRating()->getRatingobject()->getRatetable(),
                        'ratefield' => $vote->getRating()->getRatingobject()->getRatefield(),
                        'voter' => $vote->getVoter()->getUsername(),
                        'vote' => (string)$vote->getVote()
                    ]
                );
            } elseif (!empty($this->settings['enableReVote']) &&
                !$this->voteValidator->validate($matchVote)->hasErrors()) {
                /** @var \Thucke\ThRating\Domain\Model\Stepconf $matchVoteStepconf */
                $matchVoteStepconf = $matchVote->getVote();
                /** @var \Thucke\ThRating\Domain\Model\Stepconf $newVoteStepconf */
                $newVoteStepconf = $vote->getVote();
                if ($matchVoteStepconf !== $newVoteStepconf) {
                    //do update of existing vote
                    $this->logFlashMessage(
                        LocalizationUtility::translate(
                            'flash.vote.create.updateExistingVote',
                            'ThRating',
                            [$matchVoteStepconf->getSteporder(), (string)$matchVoteStepconf]
                        ),
                        LocalizationUtility::translate('flash.heading.ok', 'ThRating'),
                        'DEBUG',
                        [
                            'voter UID' => $vote->getVoter()->getUid(),
                            'ratingobject UID' => $vote->getRating()->getRatingobject()->getUid(),
                            'rating' => $vote->getRating()->getUid(),
                            'vote UID' => $vote->getUid(),
                            'new vote' => (string)$vote->getVote(),
                            'old vote' => (string)$matchVoteStepconf
                        ]
                    );
                    $vote->getRating()->updateVote($matchVote, $vote);
                } else {
                    $this->logFlashMessage(
                        LocalizationUtility::translate('flash.vote.create.noUpdateSameVote', 'ThRating'),
                        LocalizationUtility::translate('flash.heading.warning', 'ThRating'),
                        'WARNING',
                        [
                            'voter UID' => $vote->getVoter()->getUid(),
                            'ratingobject UID' => $vote->getRating()->getRatingobject()->getUid(),
                            'rating' => $vote->getRating()->getUid(),
                            'vote UID' => $vote->getUid(),
                            'new vote' => (string)$newVoteStepconf,
                            'old vote' => (string)$matchVoteStepconf
                        ]
                    );
                }
            } else {
                //display message that rating has been already done
                $vote = $matchVote;
                $this->logFlashMessage(
                    LocalizationUtility::translate('flash.vote.create.alreadyRated', 'ThRating'),
                    LocalizationUtility::translate('flash.heading.notice', 'ThRating'),
                    'NOTICE',
                    [
                        'errorCode' => 1403202280,
                        'voter UID' => $vote->getVoter()->getUid(),
                        'ratingobject UID' => $vote->getRating()->getRatingobject()->getUid(),
                        'rating' => $vote->getRating()->getUid(),
                        'vote UID' => $vote->getUid()
                    ]
                );
            }
            $this->vote = $vote;
        } else {
            $this->logFlashMessage(
                LocalizationUtility::translate('flash.vote.create.noPermission', 'ThRating'),
                LocalizationUtility::translate('flash.heading.error', 'ThRating'),
                'ERROR',
                ['errorCode' => 1403203210]
            );
        }

        $referrer = $this->request->getInternalArgument('__referrer');
        $newArguments = $this->request->getArguments();
        //replace vote argument with correct vote if user has already rated
        $newArguments['vote']['vote'] = $this->vote->getVote();
        unset($newArguments['action'], $newArguments['controller']);

        //Send signal to connected slots
        $this->initSignalSlotDispatcher('afterCreateAction');
        $newArguments = ['signalSlotHandlerContent' => $this->signalSlotHandlerContent] + $newArguments;

        /** @noinspection PhpIllegalStringOffsetInspection */
        $this->logger->log(LogLevel::DEBUG, 'Exit createAction - forwarding request', [
                'action' => $referrer['@action'],
                'controller' => $referrer['@controller'],
                'extension' => $referrer['@extension'],
                'arguments' => $newArguments
            ]);
        $this->controllerContext->getFlashMessageQueue()->clear();
        /** @var array $referrer */
        $this->forward($referrer['@action'], $referrer['@controller'], $referrer['@extension'], $newArguments);
    }

    /**
     * FE user gives a new vote by SELECT form
     * A classic SELECT input form will be provided to AJAX-submit the vote
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote The new vote (used on callback from createAction)
     * @Extbase\IgnoreValidation("vote")
     * @return void
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException
     * @throws \TYPO3\CMS\Core\Exception
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     * @noinspection PhpUnused
     */
    public function newAction(Vote $vote = null): void
    {
        $this->logger->log(LogLevel::DEBUG, 'Entry newAction');
        //find vote using additional information
        $this->initSettings();
        $this->initVoting($vote);
        $this->view->assign('actionMethodName', $this->actionMethodName);
        if (!$this->vote->hasRated() ||
            (!$this->accessControlService->isLoggedIn($this->vote->getVoter()) && $this->vote->isAnonymous())) {
            $this->view->assign('ajaxSelections', $this->ajaxSelections['json']);
        } else {
            $this->logger->log(LogLevel::INFO, 'New rating is not possible; forwarding to showAction');
        }
        $this->fillSummaryView();
        ($this->request->getFormat() === 'json') &&
        $this->view->assign('flashMessages', $this->view->getFlashMessages());
        $this->logger->log(LogLevel::DEBUG, 'Exit newAction');
    }

    /** @noinspection PhpUnused */
    /**
     * FE user gives a new vote by using a starrating obejct
     * A graphic starrating object containing links will be provided to AJAX-submit the vote
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote The new vote
     * @Extbase\IgnoreValidation("vote")
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException*
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     * @throws \TYPO3\CMS\Core\Exception
     */
    //http://localhost:8503/index.php?id=71&tx_thrating_pi1[controller]=Vote&tx_thrating_pi1[action]=ratinglinks
    public function ratinglinksAction(Vote $vote = null): void
    {
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->view,get_class($this).' ratinglinksAction');
        $this->logger->log(LogLevel::DEBUG, 'Entry ratinglinksAction');
        $this->settings['ratingConfigurations']['default'] =
            $this->settings['defaultRatingConfiguration']['ratinglinks'];
        $this->graphicActionHelper($vote);
        $this->initSignalSlotDispatcher('afterRatinglinkAction');
        $this->logger->log(LogLevel::DEBUG, 'Exit ratinglinksAction');
    }

    /**
     * Handle graphic pollings
     * Graphic bars containing links will be provided to AJAX-submit the polling
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote The new vote
     * @Extbase\IgnoreValidation("vote")
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException*
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     * @throws \TYPO3\CMS\Core\Exception
     * @noinspection PhpUnused
     */
    public function pollingAction(Vote $vote = null): void
    {
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->view,get_class($this).' pollingAction');
        $this->logger->log(LogLevel::DEBUG, 'Entry pollingAction');
        $this->settings['ratingConfigurations']['default'] =
            $this->settings['defaultRatingConfiguration']['polling'];

        $this->graphicActionHelper($vote);
        $this->initSignalSlotDispatcher('afterPollingAction');
        $this->logger->log(LogLevel::DEBUG, 'Exit pollingAction');
    }

    /**
     * Handle mark action
     * An icon containing for the mark action will be provided for AJAX-submission
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote The new vote
     * @Extbase\IgnoreValidation("vote")
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException*
     * @throws \TYPO3\CMS\Core\Exception
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     */
    /** @noinspection PhpUnused */
    public function markAction(\Thucke\ThRating\Domain\Model\Vote $vote = null): void
    {
        $this->logger->log(LogLevel::DEBUG, 'Entry markAction');
        $this->settings['ratingConfigurations']['default'] = $this->settings['defaultRatingConfiguration']['mark'];

        $this->graphicActionHelper($vote);

        $this->initSignalSlotDispatcher('afterMarkAction');
        $this->logger->log(LogLevel::DEBUG, 'Exit markAction');
    }

    /**
     * FE user gives a new vote by using a starrating obejct
     * A graphic starrating object containing links will be provided to AJAX-submit the vote
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote The new vote
     * @Extbase\IgnoreValidation("vote")
     * @return void
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException*
     * @throws \TYPO3\CMS\Core\Exception
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     */
    //http://localhost:8503/index.php?id=71&tx_thrating_pi1[controller]=Vote&tx_thrating_pi1[action]=ratinglinks
    public function graphicActionHelper(Vote $vote = null): void
    {
        $this->logger->log(LogLevel::DEBUG, 'Entry graphicActionHelper');
        $this->initSettings();
        $this->initVoting($vote);
        $this->view->assign('actionMethodName', $this->actionMethodName);

        $rating = $this->vote->getRating();
        if (!$this->ratingValidator->validate($rating)->hasErrors()) {
            $this->ratingImage = $this->objectManager->get(\Thucke\ThRating\Domain\Model\RatingImage::class);
            $this->ratingImage->setConf($this->settings['ratingConfigurations'][$this->ratingName]['imagefile']);
            //read dimensions of the image
            $imageDimensions = $this->ratingImage->getImageDimensions();
            $height = $imageDimensions['height'];
            $width = $imageDimensions['width'];

            //calculate concrete values for polling display
            $currentRates = $rating->getCurrentrates();
            $currentPollDimensions = $currentRates['currentPollDimensions'];

            foreach ($currentPollDimensions as $step => $currentPollDimension) {
                $currentPollDimensions[$step]['steporder'] = $step;
                $currentPollDimensions[$step]['backgroundPos'] = round(
                    $height / 3 * (($currentPollDimension['pctValue'] / 100) - 2),
                    1
                );
                $currentPollDimensions[$step]['backgroundPosTilt'] = round(
                    $width / 3 * (($currentPollDimension['pctValue'] / 100) - 2),
                    1
                );
            }

            $this->logger->log(
                LogLevel::DEBUG,
                'Current polling dimensions',
                ['currentPollDimensions' => $currentPollDimensions]
            );
            $this->view->assign('currentPollDimensions', $currentPollDimensions);
        }
        $this->view->assign('ratingName', $this->ratingName);
        $this->view->assign('ratingClass', $this->settings['ratingClass']);
        if ((!$this->vote->isAnonymous() &&
                $this->accessControlService->isLoggedIn($this->vote->getVoter()) &&
                (!$this->vote->hasRated() || !empty($this->settings['enableReVote']))) ||
            (
                ($this->vote->isAnonymous() &&
                    !$this->accessControlService->isLoggedIn($this->vote->getVoter())) &&
                ((!$this->vote->hasAnonymousVote($this->prefixId) &&
                        $this->cookieProtection &&
                        !$this->request->hasArgument('settings')) ||
                    !$this->cookieProtection
                )
            )
        ) {
            //if user hasn�t voted yet then include ratinglinks
            $this->view->assign('ajaxSelections', $this->ajaxSelections['steporder']);
            $this->logger->log(
                LogLevel::INFO,
                'Set ratinglink information',
                ['errorCode' => 1404933850, 'ajaxSelections[steporder]' => $this->ajaxSelections['steporder']]
            );
        }
        $this->fillSummaryView();
        ($this->request->getFormat() === 'json') && $this->view->assign(
            'flashMessages',
            $this->view->getFlashMessages()
        );
        $this->logger->log(LogLevel::DEBUG, 'Exit graphicActionHelper');
    }

    /**
     * Initialize signalSlotHandler for given action
     * Registered slots are being called with two parameters
     * 1. signalSlotMessage:    an array consisting of
     *        'tablename'        - the tablename of the rated object
     *        'fieldname'        - the fieldname of the rated object
     *        'uid'            - the uid of the rated object
     *        'currentRates'    - an array constising of the actual rating statistics
     *            'currentrate'        - the calculated overall rating
     *            'weightedVotes'  - an array giving the voting counts for every ratingstep
     *            'sumWeightedVotes' an array giving the voting counts for every ratingstep multiplied by their weights
     *            'anonymousVotes'    - count of anonymous votings
     *        if the user has voted anonymous or non-anonymous:
     *        'voter'            - the uid of the frontenduser that has voted
     *        'votingStep'    - the ratingstep that has been choosen
     *        'votingName'    - the name of the ratingstep
     *        'anonymousVote'    - boolean info if it was an anonymous rating
     *
     * @param string $slotName the slotname
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    protected function initSignalSlotDispatcher($slotName): void
    {
        $this->logger->log(LogLevel::DEBUG, 'Entry initSignalSlotDispatcher', ['slotName' => $slotName]);
        if ($this->request->hasArgument('signalSlotHandlerContent')) {
            //set orginal handlerContent if action has been forwarded
            $this->signalSlotHandlerContent = $this->request->getArgument('signalSlotHandlerContent');
            $this->logger->log(
                LogLevel::INFO,
                'Fetch static SignalSlotHandlerContent',
                ['signalSlotHandlerContent' => $this->signalSlotHandlerContent]
            );
        } else {
            $signalSlotMessage = [];
            $signalSlotMessage['tablename'] = $this->vote->getRating()->getRatingobject()->getRatetable();
            $signalSlotMessage['fieldname'] = $this->vote->getRating()->getRatingobject()->getRatefield();
            $signalSlotMessage['uid'] = (int)$this->vote->getRating()->getRatedobjectuid();
            $signalSlotMessage['currentRates'] = $this->vote->getRating()->getCurrentrates();
            if (!$this->voteValidator->validate($this->vote)->hasErrors()) {
                $signalSlotMessage['voter'] = $this->vote->getVoter()->getUid();
                $signalSlotMessage['votingStep'] = $this->vote->getVote()->getSteporder();
                $signalSlotMessage['votingName'] = (string)$this->vote->getVote()->getStepname();
                $signalSlotMessage['anonymousVote'] = $this->vote->isAnonymous();
            }
            $this->logger->log(
                LogLevel::INFO,
                'Going to process signalSlot',
                ['signalSlotMessage' => $signalSlotMessage]
            );

            //clear signalSlotHandlerArray for sure
            $this->signalSlotHandlerContent = [];
            $this->signalSlotDispatcher->dispatch(
                __CLASS__,
                $slotName,
                [$signalSlotMessage, &$this->signalSlotHandlerContent]
            );
            $this->logger->log(
                LogLevel::INFO,
                'New signalSlotHandlerContent',
                ['signalSlotHandlerContent' => $this->signalSlotHandlerContent]
            );
        }
        $this->view->assign('staticPreContent', $this->signalSlotHandlerContent['staticPreContent']);
        $this->view->assign('staticPostContent', $this->signalSlotHandlerContent['staticPostContent']);
        unset(
            $this->signalSlotHandlerContent['staticPreContent'],
            $this->signalSlotHandlerContent['staticPostContent']
        );
        $this->view->assign('preContent', $this->signalSlotHandlerContent['preContent']);
        $this->view->assign('postContent', $this->signalSlotHandlerContent['postContent']);
        $this->logger->log(LogLevel::DEBUG, 'Exit initSignalSlotDispatcher');
    }

    /**
     * Check preconditions for rating
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote the vote this selection is for
     * @return void
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     * @throws \TYPO3\CMS\Core\Exception
     */
    protected function initVoting(Vote $vote = null): void
    {
        $this->logger->log(LogLevel::DEBUG, 'Entry initVoting');

        /** @var int $logVoterUid */
        $logVoterUid = 0;

        if ($this->voteValidator->isObjSet($vote) && !$this->voteValidator->validate($vote)->hasErrors()) {
            $this->vote = $vote;
            $this->logger->log(LogLevel::DEBUG, 'Using valid vote');
        } else {
            $this->logger->log(LogLevel::DEBUG, 'initVoting ELSE');
            //first initialize parent objects for vote object
            $ratingobject = $this->extensionHelperService->getRatingobject($this->settings);
            $rating = $this->extensionHelperService->getRating($this->settings, $ratingobject);
            $this->vote = $this->extensionHelperService->getVote($this->prefixId, $this->settings, $rating);

            $countSteps = count($ratingobject->getStepconfs());
            if (empty($countSteps)) {
                $this->logger->log(LogLevel::DEBUG, 'No ratingsteps configured', ['errorCode' => 1403201012]);
                $this->logFlashMessage(
                    LocalizationUtility::translate('flash.ratingobject.noRatingsteps', 'ThRating'),
                    LocalizationUtility::translate('flash.heading.error', 'ThRating'),
                    'ERROR',
                    ['errorCode' => 1403201012]
                );
            }

            if (!$this->vote->getVoter() instanceof \Thucke\ThRating\Domain\Model\Voter) {
                if (!empty($this->settings['showNoFEUser'])) {
                    $this->logFlashMessage(
                        LocalizationUtility::translate('flash.vote.noFEuser', 'ThRating'),
                        LocalizationUtility::translate('flash.heading.notice', 'ThRating'),
                        'NOTICE',
                        ['errorCode' => 1403201096]
                    );
                }
            } else {
                $logVoterUid = $this->vote->getVoter()->getUid();
            }
        }
        $this->logger->log(LogLevel::INFO, 'Using vote', [
                'ratingobject' => $this->vote->getRating()->getRatingobject()->getUid(),
                'rating' => $this->vote->getRating()->getUid(),
                'voter' => $logVoterUid
            ]);
        //set array to create voting information
        $this->setAjaxSelections($this->vote);
        $this->logger->log(LogLevel::DEBUG, 'Exit initVoting');
    }

    /**
     * Check preconditions for settings
     *
     * @return void
     */
    protected function initSettings(): void
    {
        $this->logger->log(LogLevel::DEBUG, 'Entry initSettings');

        //switch display mode to correct config if nothing is set
        if (empty($this->settings['display'])) {
            $this->settings['display'] = $this->settings['ratingConfigurations']['default'];
        }

        //set display configuration
        if (!empty($this->settings['display'])) {
            if (isset($this->settings['ratingConfigurations'][$this->settings['display']])) {
                $this->ratingName = $this->settings['display'];
            } else {
                //switch back to default if given display configuration does not exist
                $this->ratingName = $this->settings['ratingConfigurations']['default'];
                $this->logFlashMessage(
                    LocalizationUtility::translate('flash.vote.ratinglinks.wrongDisplayConfig', 'ThRating'),
                    LocalizationUtility::translate('flash.heading.error', 'ThRating'),
                    'WARNING',
                    [
                        'errorCode' => 1403203414,
                        'settings display' => $this->settings['display'],
                        'avaiable ratingConfigurations' => $this->settings['ratingConfigurations']
                    ]
                );
            }
        } else {
            //choose default ratingConfiguration if nothing is defined
            $this->ratingName = $this->settings['ratingConfigurations']['default'];
            $this->logger->log(
                LogLevel::WARNING,
                'Display name not set - using configured default',
                ['default display' => $this->ratingName]
            );
        }
        $ratingConfiguration = $this->settings['ratingConfigurations'][$this->ratingName];
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
        //$this->settings,get_class($this).' settings '.$this->ratingName);

        //override extension settings with rating configuration settings
        if (is_array($ratingConfiguration['settings'])) {
            unset(
                $ratingConfiguration['settings']['defaultObject'],
                $ratingConfiguration['settings']['ratingConfigurations']
            );
            if (!is_array($ratingConfiguration['ratings'])) {
                $ratingConfiguration['ratings'] = [];
            }
            ArrayUtility::mergeRecursiveWithOverrule($this->settings, $ratingConfiguration['settings']);
            $this->logger->log(
                LogLevel::DEBUG,
                'Override extension settings with rating configuration settings',
                ['Original setting' => $this->settings, 'Overruling settings' => $ratingConfiguration['settings']]
            );
        }
        //override fluid settings with rating fluid settings
        if (is_array($ratingConfiguration['fluid'])) {
            ArrayUtility::mergeRecursiveWithOverrule($this->settings['fluid'], $ratingConfiguration['fluid']);
            $this->logger->log(LogLevel::DEBUG, 'Override fluid settings with rating fluid settings');
        }
        $this->logger->log(LogLevel::INFO, 'Final extension configuration', ['settings' => $this->settings]);

        if ($this->view) {
            //distinguish between bar and no-bar rating
            $this->view->assign('barimage', 'noratingbar');
            if ($ratingConfiguration['barimage']) {
                $this->view->assign('barimage', 'ratingbar');
                $this->logger->log(LogLevel::DEBUG, 'Set ratingbar config');
            }
        }

        //set tilt or normal rating direction
        $this->settings['ratingClass'] = 'normal';
        if ($ratingConfiguration['tilt']) {
            $this->logger->log(LogLevel::DEBUG, 'Tilt rating class configuration');
            $this->settings['ratingClass'] = 'tilt';
        }

        $frameworkConfiguration =
            $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $frameworkConfiguration['settings'] = $this->settings;

        $this->setFrameworkConfiguration($frameworkConfiguration);

        $this->logger->log(LogLevel::DEBUG, 'Exit initSettings');
    }

    /**
     * Build array of possible AJAX selection configuration
     *
     * @param \Thucke\ThRating\Domain\Model\Vote $vote the vote this selection is for
     * @return void
     */
    protected function setAjaxSelections(Vote $vote): void
    {
        if (empty($this->settings['displayOnly']) && $vote->getVoter() instanceof Voter) {
            //cleanup settings to reduce data size in POST form
            $tmpDisplayConfig = $this->settings['ratingConfigurations'][$this->settings['display']];
            unset($this->settings['defaultObject'], $this->settings['ratingConfigurations']);
            $this->settings['ratingConfigurations'][$this->settings['display']] = $tmpDisplayConfig;
            //TODO: ?? $currentRates = $vote->getRating()->getCurrentrates();

            foreach ($vote->getRating()->getRatingobject()->getStepconfs() as $i => $stepConf) {
                $key = utf8_encode(json_encode([
                        'value' => $stepConf->getUid(),
                        'voter' => $vote->getVoter()->getUid(),
                        'rating' => $vote->getRating()->getUid(),
                        'ratingName' => $this->ratingName,
                        'settings' => json_encode($this->settings, PHP_MINOR_VERSION>=3 ? JSON_THROW_ON_ERROR : null, 512),
                        'actionName' => strtolower($this->request->getControllerActionName()),
                        self::AJAX_REFERENCE_ID => $this->ajaxSelections['ajaxRef'],
                    ], PHP_MINOR_VERSION>=3 ? JSON_THROW_ON_ERROR : null, 512)
                );
                $this->ajaxSelections['json'][$key] = (string)$stepConf;
                $this->ajaxSelections['steporder'][$stepConf->getSteporder()]['step'] = $stepConf;
                $this->ajaxSelections['steporder'][$stepConf->getSteporder()]['ajaxvalue'] = $key;
            }
            $this->logger->log(
                LogLevel::DEBUG,
                'Finalized ajaxSelections',
                ['ajaxSelections' => $this->ajaxSelections]
            );
        }
    }

    /**
     * Fill all variables for FLUID
     *
     * @return void
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException
     */
    protected function fillSummaryView()
    {
        $this->view->assign('settings', $this->settings);
        $this->view->assign('ajaxRef', $this->ajaxSelections['ajaxRef']);
        $this->view->assign('rating', $this->vote->getRating());
        $this->view->assign('voter', $this->vote->getVoter());

        if ($this->richSnippetService->setRichSnippetConfig($this->settings)) {
            /** @var \Thucke\ThRating\Service\RichSnippetService $richSnippetObject */
            $richSnippetObject =
                $this->richSnippetService->getRichSnippetObject($this->vote->getRating()->getRatedobjectuid());
            $richSnippetObject->setAnchor('RatingAX_' . $this->vote->getRating()->getRatingobject()->getUid() .
                '_' . $this->vote->getRating()->getRatedobjectuid());
            if (empty($richSnippetObject->getName())) {
                $richSnippetObject->setName('Rating AX ' . $this->vote->getRating()->getRatingobject()->getUid() .
                    '_' . $this->vote->getRating()->getRatedobjectuid());
            }
            $this->view->assign('richSnippetObject', $richSnippetObject);
        }

        $currentrate = $this->vote->getRating()->getCurrentrates();
        $this->view->assign('stepCount', count($currentrate['weightedVotes']));
        $this->view->assign('anonymousVotes', $currentrate['anonymousVotes']);
        $this->view->assign(
            'anonymousVoting',
            !empty($this->settings['mapAnonymous']) && !$this->accessControlService->getFrontendUserUid()
        );
        if ($this->settings['showNotRated'] && empty($currentrate['currentrate'])) {
            $this->logFlashMessage(
                LocalizationUtility::translate('flash.vote.show.notRated', 'ThRating'),
                LocalizationUtility::translate('flash.heading.info', 'ThRating'),
                'INFO',
                ['errorCode' => 1403203414]
            );
        }
        if (!$this->voteValidator->validate($this->vote)->hasErrors()) {
            /** @noinspection NotOptimalIfConditionsInspection */
            if ((!$this->vote->isAnonymous() &&
                    $this->vote->getVoter()->getUid() === $this->accessControlService->getFrontendUserUid()
                ) || ($this->vote->isAnonymous() && ($this->vote->hasAnonymousVote($this->prefixId) ||
                        $this->cookieProtection || $this->cookieService->isProtected()))) {
                $this->view->assign('protected', $this->cookieService->isProtected());
                $this->view->assign('voting', $this->vote);
                $this->view->assign(
                    'usersRate',
                    $this->vote->getVote()->getSteporder() * 100 / count($currentrate['weightedVotes']) . '%'
                );
            }
        }
        //$this->view->assign('LANG', \Thucke\ThRating\Utility\LocalizationUtility::getLangArray('ThRating'));
    }

    /**
     * Override getErrorFlashMessage to present
     * nice flash error messages.
     *
     * @return string
     */
    protected function getErrorFlashMessage()
    {
        switch ($this->actionMethodName) {
            case 'createAction':
                return 'Could not create the new vote:';
            case 'showAction':
                return 'Could not show vote!';
            default:
                return parent::getErrorFlashMessage();
        }
    }

    /**
     * Checks all storagePid settings and
     * sets them to SITEROOT if zero or empty
     *
     * @return void
     * @throws InvalidStoragePageException if plugin.tx_thrating.storagePid has not been set
     * @throws FeUserStoragePageException if plugin.tx_felogin_pi1.storagePid has not been set
     */
    protected function setStoragePids()
    {
        /** @var array $frameworkConfiguration */
        $frameworkConfiguration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        );
        $feUserStoragePid = GeneralUtility::intExplode(
            ',',
            $frameworkConfiguration['plugin.']['tx_felogin_pi1.']['storagePid'],
            true
        );
        $frameworkConfiguration = $frameworkConfiguration['plugin.']['tx_thrating.'];

        $storagePids = GeneralUtility::intExplode(',', $frameworkConfiguration['storagePid'], true);
        if (empty($storagePids[0])) {
            throw new InvalidStoragePageException(
                LocalizationUtility::translate('flash.vote.general.invalidStoragePid', 'ThRating'),
                1403203519
            );
        }

        if (empty($feUserStoragePid[0])) {
            throw new FeUserStoragePageException(
                LocalizationUtility::translate('flash.pluginConfiguration.missing.feUserStoragePid', 'ThRating'),
                1403190539
            );
        }
        $storagePids[] = $feUserStoragePid[0];
        $frameworkConfiguration['persistence.']['storagePid'] = implode(',', $storagePids);
        $this->setFrameworkConfiguration($frameworkConfiguration);
    }

    /**
     * Generates a random number
     * used as the unique iddentifier for AJAX objects
     *
     * @return int
     * @throws \Exception
     */
    protected function getRandomId()
    {
        mt_srand((float)microtime() * 1000000);
        return random_int(1000000, 9999999);
    }

    /**
     * @param array $frameworkConfiguration
     * @return void
     */
    protected function setFrameworkConfiguration(array $frameworkConfiguration)
    {
        $this->configurationManager->setConfiguration($frameworkConfiguration);
        $this->cookieLifetime = abs((int)$this->settings['cookieLifetime']);
        $this->logger->log(
            LogLevel::DEBUG,
            'Cookielifetime set to ' . $this->cookieLifetime . ' days',
            ['errorCode' => 1465728751]
        );
        if (empty($this->cookieLifetime)) {
            $this->cookieProtection = false;
        } else {
            $this->cookieProtection = true;
        }
    }

    /**
     * Sends log information to flashMessage and logging framework
     *
     * @param string $messageText
     * @param string $messageTitle
     * @param string $severity
     * @param array $additionalInfo
     * @return void
     */
    private function logFlashMessage(
        string $messageText,
        string $messageTitle,
        string $severity,
        array $additionalInfo
    )
    {
        $additionalInfo = ['messageTitle' => $messageTitle] + $additionalInfo;
        $severity = strtoupper($severity);
        switch ($severity) {
            case 'DEBUG':
                $flashSeverity = 'OK';
                break;
            case 'INFO':
                $flashSeverity = 'INFO';
                break;
            case 'NOTICE':
                $flashSeverity = 'NOTICE';
                break;
            case 'WARNING':
                $flashSeverity = 'WARNING';
                break;
            default:
                $flashSeverity = 'ERROR';
        }
        if ((int)$additionalInfo['errorCode']) {
            $messageText .= ' (' . $additionalInfo['errorCode'] . ')';
        }

        //TODO: locally enqueue flashmessages of setStoragePids when controllerContext has not been set yet
        if (is_object($this->controllerContext)) {
            $this->addFlashMessage(
                $messageText,
                $messageTitle,
                constant('\TYPO3\CMS\Core\Messaging\AbstractMessage::' . $flashSeverity)
            );
        }
        $this->logger->log(constant('\TYPO3\CMS\Core\Log\LogLevel::' . $severity), $messageText, $additionalInfo);
    }

    /**
     * Sets the rating values in the foreign table
     * Recommended field type is VARCHAR(255)
     *
     * @param Rating $rating The rating
     * @return bool
     */
    protected function setForeignRatingValues(Rating $rating)
    {
        $table = $rating->getRatingobject()->getRatetable();
        $lockedFieldnames = $this->getLockedfieldnames($table);
        $rateField = $rating->getRatingobject()->getRatefield();
        if (!empty($GLOBALS['TCA'][$table]['columns'][$rateField]) && !in_array($rateField, $lockedFieldnames, false)) {
            $rateUid = $rating->getRatedobjectuid();
            $currentRatesArray = $rating->getCurrentrates();
            if (empty($this->settings['foreignFieldArrayUpdate'])) {
                //do update using DOUBLE value
                $currentRates = round($currentRatesArray['currentrate'], 2);
            } else {
                //do update using whole currentrates JSON array
                $currentRates = json_encode($currentRatesArray);
            }

            /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);

            //do update foreign table
            $queryResult = $queryBuilder
                ->update($table)
                ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($rateUid)))
                ->set($rateField, $currentRates)
                ->execute();

            return !empty($queryResult);
        }

        $this->logger->log(
            LogLevel::NOTICE,
            'Foreign ratefield does not exist in ratetable or is locked for rating updates',
            [
                'ratingobject UID' => $rating->getRatingobject()->getUid(),
                'ratetable' => $rating->getRatingobject()->getRatetable(),
                'ratefield' => $rating->getRatingobject()->getRatefield()
            ]
        );

        return true;
    }

    /**
     * Create a list of fieldnamed that must not be updated with ratingvalues
     *
     * @param    string $table tablename looking for system fields
     * @return array
     */
    protected function getLockedfieldnames($table)
    {
        $TCA = &$GLOBALS['TCA'][$table]['ctrl']; // Set private TCA var
        $lockedFields = GeneralUtility::intExplode(',', $TCA['label_alt'], true);
        $lockedFields[] .= 'pid';
        $lockedFields[] .= 'uid';
        $lockedFields[] .= 'pages';
        $lockedFields[] .= 'pages_language_overlay';
        $lockedFields[] .= $TCA['label'];
        $lockedFields[] .= $TCA['tstamp'];
        $lockedFields[] .= $TCA['crdate'];
        $lockedFields[] .= $TCA['cruser_id'];
        $lockedFields[] .= $TCA['delete'];
        $lockedFields[] .= $TCA['enablecolumns']['disabled'];
        $lockedFields[] .= $TCA['enablecolumns']['starttime'];
        $lockedFields[] .= $TCA['enablecolumns']['endtime'];
        $lockedFields[] .= $TCA['enablecolumns']['fe_group'];
        $lockedFields[] .= $TCA['selicon_field'];
        $lockedFields[] .= $TCA['sortby'];
        $lockedFields[] .= $TCA['editlock'];
        $lockedFields[] .= $TCA['origUid'];
        $lockedFields[] .= $TCA['fe_cruser_id'];
        $lockedFields[] .= $TCA['fe_crgroup_id'];
        $lockedFields[] .= $TCA['fe_admin_lock'];
        $lockedFields[] .= $TCA['languageField'];
        $lockedFields[] .= $TCA['transOrigPointerField'];
        $lockedFields[] .= $TCA['transOrigDiffSourceField'];

        return $lockedFields;
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        /** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $TSFE */
        global $TSFE;

        return $TSFE;
    }

    /**
     * Demo slotHandler for slot 'afterRatinglinkAction'
     *
     * @param    array $signalSlotMessage array containing signal information
     * @param    array $customContent array by reference to return pre and post content
     * @return void
     */
    /** @noinspection PhpUnused */
    public function afterRatinglinkActionHandler(
        /** @noinspection PhpUnusedParameterInspection */
        $signalSlotMessage,
        &$customContent
    )
    {
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($signalSlotMessage,'signalSlotMessage');
        $customContent['preContent'] = '<b>This ist my preContent</b>';
        $customContent['staticPreContent'] = '<b>This ist my staticPreContent</b>';
        $customContent['postContent'] = '<b>This ist my postContent</b>';
        $customContent['staticPostContent'] = '<b>This ist my stticPostContent</b>';
    }

    /**
     * Demo slotHandler for slot 'afterCreateAction'
     *
     * @param    array $signalSlotMessage array containing signal information
     * @param    array $customContent array by reference to return pre and post content
     * @return void
     */
    /** @noinspection PhpUnusedParameterInspection */
    /** @noinspection PhpUnused */
    public function afterCreateActionHandler(
        /** @noinspection PhpUnusedParameterInspection */
        $signalSlotMessage,
        &$customContent
    )
    {
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($signalSlotMessage,'signalSlotMessage');
        $customContent['preContent'] = '<b>This ist my preContent after afterCreateActionHandler</b>';
        $customContent['staticPreContent'] = '<b>This ist my staticPreContent after afterCreateActionHandler</b>';
        $customContent['postContent'] = '<b>This ist my postContent after afterCreateActionHandler</b>';
    }
}
