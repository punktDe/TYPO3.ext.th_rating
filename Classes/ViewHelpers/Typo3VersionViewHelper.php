<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\ViewHelpers;

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
