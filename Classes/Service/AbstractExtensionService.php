<?php
declare(strict_types = 1);

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Service;

use TYPO3\CMS\Core\SingletonInterface;

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
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
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
