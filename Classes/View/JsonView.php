<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\View;

use TYPO3\CMS\Core\Messaging\FlashMessageRendererResolver;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

/**
 * The Rating Viewhelper
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class JsonView extends \TYPO3\CMS\Extbase\Mvc\View\JsonView
{
    protected const CONFIGURATION_EXCLUDE = '_exclude';
    protected const CONFIGURATION_DESCEND = '_descend';

    /**
     * Tag builder instance
     *
     * @var \TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder
     */
    protected $tag;

    /**
     * @param TagBuilder $tag
     * @noinspection PhpUnused
     */
    public function injectTag(TagBuilder $tag): void
    {
        $this->tag = $tag;
    }

    /**
     * Only variables whose name is contained in this array will be rendered
     *
     * @var array
     */
    protected $variablesToRender = [
        'actionMethodName',
        'currentPollDimensions',
        'ratingClass',
        'preContent',
        'postContent',
        'ajaxRef',
        'rating',
        'voter',
        //'ratingobject',
        //'currentRates',
        //'anonymousVotes',
        'stepCount',
        'anonymousVoting',
        'protected',
        'voting',
        'usersRate',
        'ratingobjects',
        //'LANG',
        'flashMessages', ];

    /**
     * Initializes this view.
     *
     * Override this method for initializing your concrete view implementation.
     * @api
     */

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function initializeView(): void
    {
        $configuration = [
            'voter' => [
                self::CONFIGURATION_EXCLUDE => ['pid', 'uid'], ],
            'rating' => [
                self::CONFIGURATION_EXCLUDE => ['pid', 'uid'],
                self::CONFIGURATION_DESCEND => [
                    'currentrates' => [],
                    'ratingobject' => [
                        self::CONFIGURATION_EXCLUDE => ['pid', 'uid'], ], ], ],
            'voting' => [
                self::CONFIGURATION_EXCLUDE => ['pid', 'uid'],
                self::CONFIGURATION_DESCEND => [
                    'vote' => [
                        self::CONFIGURATION_EXCLUDE => ['pid', 'uid'],
                        self::CONFIGURATION_DESCEND => [
                            'stepname' => [
                                self::CONFIGURATION_EXCLUDE => ['pid', 'uid'], ], ], ], ], ], ];
        $this->setConfiguration($configuration);
    }

    /**
     * Get the classic DIV rendered FlashMessages from queue
     *
     * @return string
     */
    public function getFlashMessages(): string
    {
        return GeneralUtility::makeInstance(FlashMessageRendererResolver::class)
            ->resolve()
            ->render($this->controllerContext->getFlashMessageQueue()->getAllMessagesAndFlush());
    }
}
