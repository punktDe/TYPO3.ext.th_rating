<?php
declare(strict_types=1);
namespace Thucke\ThRating\Service;

use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Core\SingletonInterface;

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
class AbstractExtensionService implements SingletonInterface
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;
    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager) {
        $this->objectManager = $objectManager;
    }

    /**
     * @var \Thucke\ThRating\Service\LoggingService
     */
    protected $loggingService;
    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * Constructor
     * @param \Thucke\ThRating\Service\LoggingService $loggingService
     */
    public function __construct(LoggingService $loggingService)
    {
        $this->loggingService = $loggingService;
        $this->logger = $loggingService->getLogger(get_class($this));
    }
}
