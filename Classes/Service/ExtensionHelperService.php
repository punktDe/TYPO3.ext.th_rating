<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

/** @noinspection PhpFullyQualifiedNameUsageInspection */
namespace Thucke\ThRating\Service;

use Psr\Http\Message\ServerRequestInterface;
use Thucke\ThRating\Domain\Model\Rating;
use Thucke\ThRating\Domain\Model\RatingImage;
use Thucke\ThRating\Domain\Model\Ratingobject;
use Thucke\ThRating\Domain\Model\Stepconf;
use Thucke\ThRating\Domain\Model\Stepname;
use Thucke\ThRating\Domain\Model\Vote;
use Thucke\ThRating\Domain\Repository\RatingobjectRepository;
use Thucke\ThRating\Domain\Repository\RatingRepository;
use Thucke\ThRating\Domain\Repository\StepnameRepository;
use Thucke\ThRating\Domain\Repository\VoteRepository;
use Thucke\ThRating\Domain\Validator\RatingobjectValidator;
use Thucke\ThRating\Domain\Validator\RatingValidator;
use Thucke\ThRating\Domain\Validator\StepconfValidator;
use Thucke\ThRating\Domain\Validator\VoteValidator;
use Thucke\ThRating\Evaluation\DynamicCssEvaluator;
use Thucke\ThRating\Exception\LanguageNotFoundException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Factory for model objects
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU protected License, version 2
 */
class ExtensionHelperService extends AbstractExtensionService
{
    protected const DYN_CSS_FILENAME = 'typo3temp/thratingDyn.css';

    /**
     * The current request.
     *
     * @var \TYPO3\CMS\Extbase\Mvc\Request
     */
    protected $request;

    /**
     * @var \Thucke\ThRating\Domain\Repository\RatingobjectRepository
     */
    protected $ratingobjectRepository;

    /**
     * @param \Thucke\ThRating\Domain\Repository\RatingobjectRepository $ratingobjectRepository
     */
    public function injectRatingobjectRepository(RatingobjectRepository $ratingobjectRepository): void
    {
        $this->ratingobjectRepository = $ratingobjectRepository;
    }

    /**
     * @var \Thucke\ThRating\Domain\Repository\RatingRepository
     */
    protected $ratingRepository;
    /**
     * @param \Thucke\ThRating\Domain\Repository\RatingRepository $ratingRepository
     */
    public function injectRatingRepository(RatingRepository $ratingRepository): void
    {
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * @var \Thucke\ThRating\Domain\Repository\StepnameRepository
     */
    protected $stepnameRepository;
    /**
     * @param \Thucke\ThRating\Domain\Repository\StepnameRepository $stepnameRepository
     */
    public function injectStepnameRepository(StepnameRepository $stepnameRepository): void
    {
        $this->stepnameRepository = $stepnameRepository;
    }

    /**
     * @var \Thucke\ThRating\Domain\Repository\VoteRepository
     */
    protected $voteRepository;
    /**
     * @param \Thucke\ThRating\Domain\Repository\VoteRepository $voteRepository
     */
    public function injectVoteRepository(VoteRepository $voteRepository): void
    {
        $this->voteRepository = $voteRepository;
    }

    /**
     * @var \Thucke\ThRating\Service\AccessControlService
     */
    protected $accessControllService;
    /**
     * @param AccessControlService $accessControllService
     */
    public function injectAccessControlService(AccessControlService $accessControllService): void
    {
        $this->accessControllService = $accessControllService;
    }

    /**
     * @var \Thucke\ThRating\Domain\Validator\StepconfValidator
     */
    protected $stepconfValidator;
    /**
     * @param \Thucke\ThRating\Domain\Validator\StepconfValidator $stepconfValidator
     */
    public function injectStepconfValidator(StepconfValidator $stepconfValidator): void
    {
        $this->stepconfValidator = $stepconfValidator;
    }

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;
    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     */
    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Contains the settings of the current extension
     *
     * @var array
     */
    protected $settings;
    /**
     * @var \Thucke\ThRating\Domain\Model\RatingImage
     */
    protected $ratingImage;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface
     */
    protected $extDefaultQuerySettings;

    /**
     * Constructor
     */
    public function initializeObject(): void
    {
        $this->settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'thrating',
            'pi1'
        );

        $frameworkConfiguration = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'thrating',
            'pi1'
        );
        if (!empty($frameworkConfiguration['ratings'])) {
            //Merge extension ratingConfigurations with customer added ones
            ArrayUtility::mergeRecursiveWithOverrule(
                $this->settings['ratingConfigurations'],
                $frameworkConfiguration['ratings']
            );
        }
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController(): TypoScriptFrontendController
    {
        global $TSFE;

        return $TSFE;
    }

    /**
     * Returns the completed settings array
     *
     * @param array $settings
     * @return array
     */
    private function completeConfigurationSettings(array $settings): array
    {
        $cObj = $this->configurationManager->getContentObject();

        if (!empty($cObj->currentRecord)) {
            /* build array [0=>cObj tablename, 1=> cObj uid] - initialize with content information
             (usage as normal content) */
            $currentRecord = explode(':', $cObj->currentRecord);
        } else {
            //build array [0=>cObj tablename, 1=> cObj uid] - initialize with page info if used by typoscript
            $currentRecord = ['pages', $GLOBALS['TSFE']->page['uid']];
        }

        if (empty($settings['ratetable'])) {
            $settings['ratetable'] = $currentRecord[0];
        }
        if (empty($settings['ratefield'])) {
            $settings['ratefield'] = 'uid';
        }
        if (empty($settings['ratedobjectuid'])) {
            $settings['ratedobjectuid'] = $currentRecord[1];
        }
        return $settings;
    }

    /**
     * Returns a new or existing ratingobject
     *
     * @param array $settings
     * @throws \Thucke\ThRating\Exception\RecordNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @return \Thucke\ThRating\Domain\Model\Ratingobject
     */
    public function getRatingobject(array $settings): Ratingobject
    {
        $ratingobject = null;

        //check whether a dedicated ratingobject is configured
        if (!empty($settings['ratingobject'])) {
            $ratingobject = $this->ratingobjectRepository->findByUid($settings['ratingobject']);
        } else {
            if (empty($settings['ratetable']) || empty($settings['ratefield'])) {
                //fallback to default configuration
                $settings = $settings['defaultObject'] + $settings;
            }
            $settings = $this->completeConfigurationSettings($settings);
            $ratingobject = $this->ratingobjectRepository->findMatchingTableAndField(
                $settings['ratetable'],
                $settings['ratefield'],
                RatingobjectRepository::ADD_IF_NOT_FOUND
            );
        }
        return $ratingobject;
    }

    /**
     * Returns a new or existing ratingobject
     *
     * @param array $stepconfArray
     * @return \Thucke\ThRating\Domain\Model\Stepconf
     */
    public function createStepconf(array $stepconfArray): Stepconf
    {
        /** @var \Thucke\ThRating\Domain\Model\Stepconf $stepconf */
        $stepconf = $this->objectManager->get(Stepconf::class);
        $stepconf->setRatingobject($stepconfArray['ratingobject']);
        $stepconf->setSteporder($stepconfArray['steporder']);
        $stepconf->setStepweight($stepconfArray['stepweight']);

        return $stepconf;
    }

    /**
     * Returns a new or existing ratingobject
     *
     * @param Stepconf $stepconf
     * @param array $stepnameArray
     * @return  \Thucke\ThRating\Domain\Model\Stepname
     * @throws LanguageNotFoundException
     * @throws \TYPO3\CMS\Core\Exception\SiteNotFoundException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function createStepname(Stepconf $stepconf, array $stepnameArray): Stepname
    {
        /** @var \Thucke\ThRating\Domain\Model\Stepname $stepname */
        $stepname = $this->objectManager->get(Stepname::class);
        $stepname->setStepconf($stepconf);
        $stepname->setStepname($stepnameArray['stepname']);
        $stepname->setPid($stepnameArray['pid']);
        $stepname->setSysLanguageUid(
            $this->getStaticLanguageByIsoCode(
                $stepname->getPid(),
                $stepnameArray['twoLetterIsoCode'] ?: null
            )->getLanguageId()
        );

        $defaultStepname = $this->stepnameRepository->findDefaultStepname($stepname);
        $l18nParent = is_null($defaultStepname) ? 0 : $defaultStepname->getUid();
        $stepname->setL18nParent($l18nParent);
        return $stepname;
    }

    /**
     * Returns a new or existing rating
     *
     * @param array $settings
     * @param \Thucke\ThRating\Domain\Model\Ratingobject|null $ratingobject
     * @return \Thucke\ThRating\Domain\Model\Rating
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \Thucke\ThRating\Service\Exception
     */
    public function getRating(array $settings, ?Ratingobject $ratingobject): Rating
    {
        $settings = $this->completeConfigurationSettings($settings);
        if (!empty($settings['rating'])) {
            //fetch rating when it is configured
            $rating = $this->ratingRepository->findByUid($settings['rating']);
        } elseif ($settings['ratedobjectuid'] && !$this->objectManager->get(RatingobjectValidator::class)
                ->validate($ratingobject)->hasErrors()) {
            //get rating according to given row
            /** @noinspection NullPointerExceptionInspection */
            $rating = $this->ratingRepository->findMatchingObjectAndUid(
                $ratingobject,
                $settings['ratedobjectuid'],
                RatingRepository::ADD_IF_NOT_FOUND
            );
        } else {
            throw new \Thucke\ThRating\Service\Exception(
                'Incomplete configuration setting. Either \'rating\' or \'ratedobjectuid\' are missing.',
                1398351336
            );
        }
        return $rating;
    }

    /**
     * Returns a new or existing vote
     *
     * @param string $prefixId
     * @param array $settings
     * @param \Thucke\ThRating\Domain\Model\Rating $rating
     * @return \Thucke\ThRating\Domain\Model\Vote
     * @throws \Thucke\ThRating\Exception\FeUserNotFoundException
     */
    public function getVote(string $prefixId, array $settings, Rating $rating): Vote
    {
        // initialize variables
        /** @var \Thucke\ThRating\Domain\Model\Vote $vote */
        $vote = null;
        /** @var \Thucke\ThRating\Domain\Model\Voter $voter */
        $voter = null;

        //first fetch real voter or anonymous
        /** @var int $frontendUserUid */
        $frontendUserUid = $this->accessControllService->getFrontendUserUid();
        if (!$frontendUserUid && !empty($settings['mapAnonymous'])) {
            //set anonymous vote
            $voter = $this->accessControllService->getFrontendVoter($settings['mapAnonymous']);
            $anonymousRating = json_decode(
                $_COOKIE[$prefixId . '_AnonymousRating_' . $rating->getUid()],
                true,
                512,
                JSON_THROW_ON_ERROR
            );
            if (!empty($anonymousRating['voteUid'])) {
                $vote = $this->voteRepository->findByUid($anonymousRating['voteUid']);
            }
        } elseif ($frontendUserUid) {
            //set FEUser if one is logged on
            $voter = $this->accessControllService->getFrontendVoter($frontendUserUid);
            if ($voter instanceof \Thucke\ThRating\Domain\Model\Voter) {
                $vote = $this->voteRepository->findMatchingRatingAndVoter($rating, $voter);
            }
        }
        //voting not found in database or anonymous vote? - create new one
        $voteValidator = $this->objectManager->get(VoteValidator::class);
        if ($voteValidator->validate($vote)->hasErrors()) {
            $vote = $this->objectManager->get(Vote::class);
            $ratingValidator = $this->objectManager->get(RatingValidator::class);
            if (!$ratingValidator->validate($rating)->hasErrors()) {
                $vote->setRating($rating);
            }
            if ($voter instanceof \Thucke\ThRating\Domain\Model\Voter) {
                $vote->setVoter($voter);
            }
        }

        return $vote;
    }

    /**
     * Get a logger instance
     * The configuration of the logger is modified by extension typoscript config
     *
     * @param string|null $name the class name which this logger is for
     * @return  \TYPO3\CMS\Core\Log\Logger
     */
    public function getLogger(?string $name): Logger
    {
        if (empty($name)) {
            return $this->loggingService->getLogger(__CLASS__);
        }

        return $this->loggingService->getLogger($name);
    }

    /**
     * Update and persist attached objects to the repository
     *
     * @param string $repository
     * @param \TYPO3\CMS\Extbase\DomainObject\AbstractEntity $objectToPersist
     */
    public function persistRepository(string $repository, AbstractEntity $objectToPersist): void
    {
        $objectUid = $objectToPersist->getUid();
        if (!is_int($objectUid)) {
            $this->objectManager->get($repository)->add($objectToPersist);
        } else {
            $this->objectManager->get($repository)->update($objectToPersist);
        }
        $this->objectManager->get(PersistenceManager::class)->persistAll();
    }

    /**
     * Clear the dynamic CSS file for recreation
     */
    public function clearDynamicCssFile(): void
    {
        $this->objectManager->get(DynamicCssEvaluator::class)->clearCachePostProc([]);
    }

    /**
     * Render CSS-styles for ratings and ratingsteps
     * Only called by singeltonAction to render styles once per page.
     * The file self::DYN_CSS_FILENAME will be created if it doesn�t exist
     *
     * @return array
     */
    public function renderDynCSS(): array
    {
        $messageArray = [];
        $cssFile = '';

        //create file if it does not exist
        if (file_exists(Environment::getPublicPath() . '/' . self::DYN_CSS_FILENAME)) {
            $fstat = stat(Environment::getPublicPath() . '/' . self::DYN_CSS_FILENAME);
            //do not recreate file if it has greater than zero length
            if ($fstat[7] !== 0) {
                $this->logger->log(LogLevel::DEBUG, 'Dynamic CSS file exists - exiting');
                return $messageArray;
            }
        }

        //now walk through all ratingobjects to calculate stepwidths
        $allRatingobjects = $this->ratingobjectRepository->findAll(true);

        foreach ($allRatingobjects as $ratingobject) {
            $ratingobjectUid = $ratingobject->getUid();
            /** @var ObjectStorage<\Thucke\ThRating\Domain\Model\Stepconf> $stepconfObjects */
            $stepconfObjects = $ratingobject->getStepconfs();
            $stepcount = count($stepconfObjects);
            if (!$stepcount) {
                if ($this->settings['showMissingStepconfError']) {
                    //show error message in GUI
                    $messageArray[] = [
                        'messageText' => LocalizationUtility::translate(
                            'flash.renderCSS.noStepconf',
                            'ThRating',
                            [
                                1 => $ratingobject->getUid(),
                                2 => $ratingobject->getPid()
                            ]
                        ),
                        'messageTitle' => LocalizationUtility::translate(
                            'flash.configuration.error',
                            'ThRating'
                        ),
                        'severity' => 'ERROR',
                        'additionalInfo' => [
                            'errorCode' => 1384705470,
                            'ratingobject UID' => $ratingobject->getUid(),
                            'ratingobject PID' => $ratingobject->getPid(),
                        ],
                    ];
                } else {
                    //only log message
                    $this->logger->log(
                        LogLevel::ERROR,
                        LocalizationUtility::translate(
                            'flash.renderCSS.noStepconf',
                            'ThRating',
                            [
                                1 => $ratingobject->getUid(),
                                2 => $ratingobject->getPid()
                            ]
                        ),
                        [
                            'errorCode' => 1384705470,
                            'ratingobject UID' => $ratingobject->getUid(),
                            'ratingobject PID' => $ratingobject->getPid(),
                        ]
                    );
                }
            }

            $stepWeights = [];
            $sumStepWeights = 0;

            $stepconfs = $stepconfObjects->toArray();
            foreach ($stepconfs as $stepconf) { //stepconfs are already sorted by steporder
                //just do checks here that all steps are OK
                if (!$this->stepconfValidator->validate($stepconf)->hasErrors()) {
                    /** @var \Thucke\ThRating\Domain\Model\Stepconf $stepconf */
                    $stepWeights[] = $stepconf->getStepweight();
                    $sumStepWeights += $stepconf->getStepweight();
                } else {
                    foreach ($this->stepconfValidator->validate($stepconf)->getErrors() as $errorMessage) {
                        $messageArray[] = [
                            'messageText' => $errorMessage->getMessage(),
                            'messageTitle' => LocalizationUtility::translate('flash.configuration.error', 'ThRating'),
                            'severity' => 'ERROR',
                            'additionalInfo' => ['errorCode' => $errorMessage->getCode(),
                                                      'errorMessage' => $errorMessage->getMessage(), ], ];
                    }
                }
            }
            $this->logger->log(
                LogLevel::INFO,
                'Ratingobject data',
                [
                    'ratingobject UID' => $ratingobject->getUid(),
                    'ratingobject PID' => $ratingobject->getPid(),
                    'stepcount' => $stepcount,
                    'stepWeights' => $stepWeights,
                    'sumStepWeights' => $sumStepWeights,
                    'messageCount' => count($messageArray)
                ]
            );

            //generate CSS for all ratings out of TSConfig
            foreach ($this->settings['ratingConfigurations'] as $ratingName => $ratingConfig) {
                if ($ratingName === 'default') {
                    continue;
                }
                $subURI = substr(Environment::getPublicPath() . '/', strlen($_SERVER['DOCUMENT_ROOT']) + 1);
                $basePath = $this->getTypoScriptFrontendController()->baseUrl ?: '//' .
                    $_SERVER['HTTP_HOST'] . '/' . $subURI;

                $this->ratingImage = $this->objectManager->get(RatingImage::class);
                $this->ratingImage->setConf($ratingConfig['imagefile']);
                $filename = $this->ratingImage->getImageFile();
                if (empty($filename)) {
                    $messageArray[] = [
                        'messageText' => LocalizationUtility::translate(
                            'flash.vote.renderCSS.defaultImage',
                            'ThRating'
                        ),
                        'messageTitle' => LocalizationUtility::translate(
                            'flash.heading.warning',
                            'ThRating'
                        ),
                        'severity' => 'WARNING',
                        'additionalInfo' => ['errorCode' => 1403192702,
                                    'ratingName' => $ratingName,
                                    'ratingConfig' => $ratingConfig, ], ];
                    $defaultRatingName = $this->settings['ratingConfigurations']['default'];
                    $ratingConfig = $this->settings['ratingConfigurations'][$defaultRatingName];
                    $this->ratingImage->setConf($ratingConfig['imagefile']);
                    $filename = $this->ratingImage->getImageFile();
                }
                $filenameUri = $basePath . '/' . $filename;  //prepend host basepath if no URL is given

                $imageDimensions = $this->ratingImage->getImageDimensions();
                $height = $imageDimensions['height'];
                $width = $imageDimensions['width'];
                $mainId = '.thRating-RObj' . $ratingobjectUid . '-' . $ratingName;
                $this->logger->log(
                    LogLevel::DEBUG,
                    'Main CSS info',
                    [
                                'mainId' => $mainId,
                                'filenameUri' => $filenameUri,
                                'image width' => $width,
                                'image height' => $height, ]
                );

                //calculate overall rating size depending on rating direction
                if ($ratingConfig['tilt']) {
                    $width = round($width / 3, 1);
                    if (!$ratingConfig['barimage']) {
                        $height *= $sumStepWeights;
                    }
                    $cssFile .= $mainId . ' { width:' . $width . 'px; height:' . $height . 'px; }' . chr(10);
                    $cssFile .= $mainId . ', ' . $mainId . ' span:hover, ' . $mainId . ' span:active, ' . $mainId .
                        ' span:focus, ' . $mainId . ' .current-rating { background:url(' . $filenameUri .
                        ') right bottom repeat-y; }' . chr(10);
                    $cssFile .= $mainId . ' span, ' . $mainId . ' .current-rating { width:' . $width . 'px; }' .
                        chr(10);
                } else {
                    $height = round($height / 3, 1);
                    if (!$ratingConfig['barimage']) {
                        $width *= $sumStepWeights;
                    }
                    $cssFile .= $mainId . ' { width:' . $width . 'px; height:' . $height . 'px; }' . chr(10);
                    $cssFile .= $mainId . ', ' . $mainId . ' span:hover, ' . $mainId . ' span:active, ' . $mainId .
                        ' span:focus, ' . $mainId . ' .current-rating { background:url(' . $filenameUri .
                        ') 0 0 repeat-x; }' . chr(10);
                    $cssFile .= $mainId . ' span, ' . $mainId . ' .current-rating { height:' . $height .
                        'px; line-height:' . $height . 'px; }' . chr(10);
                    //calculate widths/heights related to stepweights
                }
                $cssFile .= $mainId . ' .current-poll { background:url(' . $filenameUri . '); }' . chr(10);
            }

            //calculate widths/heights related to stepweights
            $i = 1;
            $stepPart = 0;
            $sumWeights = 0;
            foreach ($stepWeights as $stepWeight) {
                $sumWeights += $stepWeight;
                $zIndex = $stepcount - $i + 2;  //add 2 to override .current-poll and .currentPollText
                //configure rating and polling styles for steps
                $oneStepPart = round($stepWeight * 100 / $sumStepWeights, 1); //calculate single width of ratingstep
                $cssFile .= 'span.RObj' . $ratingobjectUid . '-StpOdr' . $i . '-ratingpoll-normal { width:' .
                    $oneStepPart . '%; z-index:' . $zIndex . '; margin-left:' . $stepPart . '%;}' . chr(10);
                $cssFile .= 'span.RObj' . $ratingobjectUid . '-StpOdr' . $i . '-ratingpoll-tilt { height:' .
                    $oneStepPart . '%; z-index:' . $zIndex . '; margin-bottom:' . $stepPart . '%; }' . chr(10);
                $cssFile .= 'li.RObj' . $ratingobjectUid . '-StpOdr' . $i . '-currentpoll-normal { width:' .
                    $oneStepPart . '%; margin-left:' . $stepPart . '%; }' . chr(10);
                $cssFile .= 'li.RObj' . $ratingobjectUid . '-StpOdr' . $i . '-currentpoll-normal span { width:100%; }' .
                    chr(10);
                $cssFile .= 'li.RObj' . $ratingobjectUid . '-StpOdr' . $i . '-currentpoll-tilt { height:' .
                    $oneStepPart . '%; margin-bottom:' . $stepPart . '%; }' . chr(10);
                $cssFile .= 'li.RObj' . $ratingobjectUid . '-StpOdr' . $i . '-currentpoll-tilt span { height:100%; }' .
                    chr(10);
                $stepPart = round($sumWeights * 100 / $sumStepWeights, 1); //calculate sum of widths to this ratingstep
                $cssFile .= 'span.RObj' . $ratingobjectUid . '-StpOdr' . $i . '-ratingstep-normal { width:' .
                    $stepPart . '%; z-index:' . $zIndex . '; }' . chr(10);
                $cssFile .= 'span.RObj' . $ratingobjectUid . '-StpOdr' . $i . '-ratingstep-tilt { height:' .
                    $stepPart . '%; z-index:' . $zIndex . '; }' . chr(10);
                $i++;
            }
            //reset variables for next iteration
            unset($stepWeights, $sumWeights, $sumStepWeights);
            $this->logger->log(LogLevel::DEBUG, 'CSS finished for ratingobject');
        }

        $this->logger->log(LogLevel::DEBUG, 'Saving CSS file', ['cssFile' => $cssFile]);
        $fp = fopen(Environment::getPublicPath() . '/' . self::DYN_CSS_FILENAME, 'wb');
        fwrite($fp, $cssFile);
        fclose($fp);

        return $messageArray;
    }

    /**
     * Returns the language object
     * If not ISO code is provided the default language is returned
     *
     * @param int $pid page id to which is part of the site
     * @param string|null $twoLetterIsoCode iso-639-1 string (e.g. en, de, us)
     * @return \TYPO3\CMS\Core\Site\Entity\SiteLanguage
     * @throws LanguageNotFoundException
     */
    public function getStaticLanguageByIsoCode(int $pid, string $twoLetterIsoCode = null): SiteLanguage
    {
        /** @var Site $site */
        $site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pid);

        if (!is_null($twoLetterIsoCode)) {
            foreach ($site->getAllLanguages() as $language) {
                if ($language->getTwoLetterIsoCode() === $twoLetterIsoCode) {
                    return $language;
                }
            }
            throw new LanguageNotFoundException(LocalizationUtility::translate(
                'flash.general.languageNotFound',
                'ThRating'
            ), 1582980369);
        }
        return $site->getDefaultLanguage();
    }

    /**
     * Returns the language object
     * If not ISO code is provided the default language is returned
     *
     * @param int $pid page id to which is part of the site
     * @param int|null $languageId iso-639-1 string (e.g. en, de, us)
     * @return \TYPO3\CMS\Core\Site\Entity\SiteLanguage
     * @throws \TYPO3\CMS\Core\Exception\SiteNotFoundException
     */
    public function getStaticLanguageById(int $pid, int $languageId = null): ?SiteLanguage
    {
        /** @var Site $site */
        $site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pid);

        if ($languageId) {
            return $site->getLanguageById($languageId);
        }
        return $site->getDefaultLanguage();
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }

    /**
     * Sets the current request object
     *
     * @param \TYPO3\CMS\Extbase\Mvc\Request $request
     */
    public function setRequest(\TYPO3\CMS\Extbase\Mvc\Request $request): void
    {
        $this->request = $request;
    }
}
