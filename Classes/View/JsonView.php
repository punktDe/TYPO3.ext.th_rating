<?php
namespace Thucke\ThRating\View;

use TYPO3\CMS\Core\Messaging\FlashMessageRendererResolver;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

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
     * @var \TYPO3\CMS\Fluid\Core\ViewHelper\TagBuilder
     */
    protected $tag;

    /**
     * @param TagBuilder $tag
     * @noinspection PhpUnused
     */
    public function injectTag(TagBuilder $tag):void
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
    public function initializeView()
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
    public function getFlashMessages()
    {
        return GeneralUtility::makeInstance(FlashMessageRendererResolver::class)
            ->resolve()
            ->render($this->controllerContext->getFlashMessageQueue()->getAllMessagesAndFlush());
    }
}
