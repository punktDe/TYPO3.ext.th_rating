<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * The TYPO3 version viewhelper
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Typo3VersionViewHelper extends AbstractViewHelper
{
    /** @var string */
    protected $t3VersionNumber;

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function initializeArguments()
    {
        $this->t3VersionNumber = GeneralUtility::makeInstance(VersionNumberUtility::class)->getCurrentTypo3Version();
        $this->registerArgument('testVersion', 'string', 'The version number to check against', true);
        $this->registerArgument('testOperator', 'string', 'The operator', true);
    }

    /**
     * Gives the current TYPO3 version
     *
     * @return int|bool test result
     * @api
     */
    public function render()
    {
        $testVersion = $this->arguments['testVersion'];
        $testOperator = $this->arguments['testOperator'];

        return version_compare($this->t3VersionNumber, $testVersion, $testOperator);
    }
}
