<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Service;

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Service for setting cookies like Typo3 does
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU protected License, version 2
 */
class JsonService extends AbstractExtensionService
{

    /**
     * Encode a string to JSON
     * Log a warning on error
     *
     * @param mixed $content
     * @return string|false  The domain to be used on setting cookies
     */
    public function encodeToJson($content)
    {
        if (!empty($content)) {
            try {
                return json_encode($content, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                $this->logger->log(
                    LogLevel::WARNING,
                    LocalizationUtility::translate('system.warning.json.encode', 'ThRating', [
                            1 => $content,
                        ]),
                    [
                        'errorCode' => 1615051494,
                        'JSON' => $content,
                        'Exception' => $e,
                    ]
                );
            }
        }
        return false;
    }

    /**
     * Encode a string to JSON
     * Log a warning on error
     *
     * @param string $content
     * @return array|false  The domain to be used on setting cookies
     */
    public function decodeJsonToArray(string $content)
    {
        if (!empty($content)) {
            try {
                return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                $this->logger->log(
                    LogLevel::WARNING,
                    LocalizationUtility::translate('system.warning.json.encode', 'ThRating', [
                        1 => $content,
                    ]),
                    [
                        'errorCode' => 1615051494,
                        'JSON' => $content,
                        'Exception' => $e,
                    ]
                );
            }
        }
        return false;
    }
}
