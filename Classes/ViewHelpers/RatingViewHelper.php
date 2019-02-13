<?php
namespace Thucke\ThRating\ViewHelpers;

use Thucke\ThRating\Service\ExtensionHelperService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019 Thomas Hucke <thucke@web.de>
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
 * Renders the rating view based upon plugin.tx_thrating
 * Only the argument ratedobjectuid is required.
 * Others could be used to configure the output
 *
 * = Example =
 *
 * <code title="Render rating view">
 * <thr:rating ratetable="some_tablename" ratefield="one_field_of_the_table" ratedobjectuid="UID integer" ></thr:rating>
 * </code>
 * <output>
 * rendered rating
 * </output>
 *
 */
class RatingViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Disable escaping of this node's output
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController contains a backup of the current $GLOBALS['TSFE'] if used in BE mode
     */
    protected static $tsfeBackup;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger	$logger
     */
    protected $logger;

    /**
     * @var array
     */
    protected $typoScriptSetup;

    /**
     * @var \Thucke\ThRating\Service\ExtensionHelperService
     */
    protected $extensionHelperService;

    /**
     *
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('action', 'string', 'The rating action');
        $this->registerArgument('ratetable', 'string', 'The rating tablename');
        $this->registerArgument('ratefield', 'string', 'The rating fieldname');
        $this->registerArgument('ratedobjectuid', 'integer', 'The ratingobject uid', true);
        $this->registerArgument('ratingobject', 'integer', 'The ratingobject');
        $this->registerArgument('display', 'string', 'The display configuration');
    }

    /**
     * Renders the ratingView
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $typoscriptObjectPath = 'plugin.tx_thrating';
        $ratedobjectuid = $arguments['ratedobjectuid'];
        $action = $arguments['action'];
        $ratingobject = $arguments['ratingobject'];
        $ratetable = $arguments['ratetable'];
        $ratefield = $arguments['ratefield'];
        $display = $arguments['display'];
        $extensionHelperService = static::getExtensionHelperService();
        $contentObjectRenderer = static::getContentObjectRenderer();

        //instantiate the logger
        $logger = $extensionHelperService->getLogger(__CLASS__);
        $logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG,
            'Entry point',
            [
                'Viewhelper parameters' => [
                    'action' => $action,
                    'ratingobject' => $ratingobject,
                    'ratetable' => $ratetable,
                    'ratefield' => $ratefield,
                    'ratedobjectuid' => $ratedobjectuid,
                    'display' => $display, ],
                'typoscript' => static::getConfigurationManager()->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT),
            ]
        );

        if (TYPO3_MODE === 'BE') {
            static::simulateFrontendEnvironment();
        }
        $contentObjectRenderer->start(null);

        $pathSegments = GeneralUtility::trimExplode('.', $typoscriptObjectPath);
        $lastSegment = array_pop($pathSegments);
        $setup = static::getConfigurationManager()->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        foreach ($pathSegments as $segment) {
            if (!array_key_exists($segment . '.', $setup)) {
                $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL,
                    'TypoScript object path does not exist',
                    [
                        'Typoscript object path' => htmlspecialchars($typoscriptObjectPath),
                        'Setup' => $setup,
                        'errorCode' => 1253191023]);

                throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception(
                    'TypoScript object path "' . $typoscriptObjectPath . '" does not exist',
                    1549388144
                );
            }
            $setup = $setup[$segment . '.'];
        }

        if (!isset($setup[$lastSegment])) {
            throw new \TYPO3\CMS\Fluid\Core\ViewHelper\Exception(
                'No Content Object definition found at TypoScript object path "' . $typoscriptObjectPath . '"',
                1549388123
            );
        }

        if (!empty($action)) {
            $setup[$lastSegment . '.']['action'] = $action;
            $setup[$lastSegment . '.']['switchableControllerActions.']['Vote.']['1'] = $action;
        }
        if (!empty($ratingobject)) {
            $setup[$lastSegment . '.']['settings.']['ratingobject'] = $ratingobject;
        } elseif (!empty($ratetable) && !empty($ratefield)) {
            $setup[$lastSegment . '.']['settings.']['ratetable'] = $ratetable;
            $setup[$lastSegment . '.']['settings.']['ratefield'] = $ratefield;
        } else {
            $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, 'ratingobject not specified or ratetable/ratfield not set', ['errorCode' => 1399727698]);
            throw new Exception('ratingobject not specified or ratetable/ratfield not set', 1399727698);
        }
        if (!empty($ratedobjectuid)) {
            $setup[$lastSegment . '.']['settings.']['ratedobjectuid'] = $ratedobjectuid;
        } else {
            $logger->log(\TYPO3\CMS\Core\Log\LogLevel::CRITICAL, 'ratedobjectuid not set', ['errorCode' => 1304624408]);
            throw new Exception('ratedobjectuid not set', 1304624408);
        }
        if (!empty($display)) {
            $setup[$lastSegment . '.']['settings.']['display'] = $display;
        }

        $logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Single contentObjectRenderer to get',
            [
                'contentObjectRenderer type' => $setup[$lastSegment],
                'cOjb config' => $setup[$lastSegment . '.']]);

        $content = $contentObjectRenderer->cObjGetSingle($setup[$lastSegment], $setup[$lastSegment . '.'] ?? []);
        if (TYPO3_MODE === 'BE') {
            static::resetFrontendEnvironment();
        }

        $logger->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, 'Generated content', ['content' => $content]);
        $logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Exit point');
        return $content;
    }

    /**
     * @return ExtensionHelperService
     */
    protected static function getExtensionHelperService(): ExtensionHelperService
    {
        return GeneralUtility::makeInstance(ObjectManager::class)->get(ExtensionHelperService::class);
    }

    /**
     * @return ConfigurationManagerInterface
     */
    protected static function getConfigurationManager(): ConfigurationManagerInterface
    {
        return GeneralUtility::makeInstance(ObjectManager::class)->get(ConfigurationManagerInterface::class);
    }

    /**
     * @return ContentObjectRenderer
     */
    protected static function getContentObjectRenderer()
    {
        return GeneralUtility::makeInstance(
            ContentObjectRenderer::class,
            $GLOBALS['TSFE'] ?? GeneralUtility::makeInstance(TypoScriptFrontendController::class, null, 0, 0)
        );
    }

    /**
     * Sets the $TSFE->cObjectDepthCounter in Backend mode
     * This somewhat hacky work around is currently needed because the cObjGetSingle() function of \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer relies on this setting
     */
    protected static function simulateFrontendEnvironment(): void
    {
        static::$tsfeBackup = $GLOBALS['TSFE'] ?? null;
        $GLOBALS['TSFE'] = new \stdClass();
        $GLOBALS['TSFE']->cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $GLOBALS['TSFE']->cObjectDepthCounter = 100;
    }

    /**
     * Resets $GLOBALS['TSFE'] if it was previously changed by simulateFrontendEnvironment()
     *
     * @see simulateFrontendEnvironment()
     */
    protected static function resetFrontendEnvironment(): void
    {
        $GLOBALS['TSFE'] = static::$tsfeBackup;
    }
}
