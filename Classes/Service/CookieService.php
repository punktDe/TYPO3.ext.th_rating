<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Service;

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service for setting cookies like Typo3 does
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU protected License, version 2
 */
class CookieService extends AbstractExtensionService
{
    /**
     * Indicator for cookieProtection has been set
     * @var bool
     */
    protected $cookieProtection = false;

    /**
     * Gets the domain to be used on setting cookies.
     * The information is taken from the value in $GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieDomain'].
     * Protected function taken from t3lib_userAuth (t3 4.7.7)
     *
     * @return string  The domain to be used on setting cookies
     */
    protected function getCookieDomain()
    {
        $result = '';
        $cookieDomain = $GLOBALS['TYPO3_CONF_VARS']['SYS']['cookieDomain'];
        // If a specific cookie domain is defined for a given TYPO3_MODE,
        // use that domain
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['FE']['cookieDomain'])) {
            $cookieDomain = $GLOBALS['TYPO3_CONF_VARS']['FE']['cookieDomain'];
        }
        if ($cookieDomain) {
            if ($cookieDomain[0] === '/') {
                $match = [];
                /** @noinspection PhpUsageOfSilenceOperatorInspection */
                $matchCnt = @preg_match(
                    $cookieDomain,
                    GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY'),
                    $match
                );
                if ($matchCnt === false) {
                    $this->logger->log(
                        LogLevel::ERROR,
                        'getCookieDomain: The regular expression for the cookie domain contains errors.' .
                        'The session is not shared across sub-domains.',
                        ['cookieDomain' => $cookieDomain, 'errorCode' => 1399137882]
                    );
                } elseif ($matchCnt) {
                    $result = $match[0];
                }
            } else {
                $result = $cookieDomain;
            }
        }

        return $result;
    }

    /**
     * Sets the cookie
     * Protected function taken from t3lib_userAuth (t3 4.7.7)
     *
     * @param    string $cookieName identifier for the cookie
     * @param    string $cookieValue cookie value
     * @param    int $cookieExpire expire time for the cookie
     *
     * @throws Exception
     */
    public function setVoteCookie($cookieName, $cookieValue, $cookieExpire = 0)
    {
        // do not set session cookies
        if (!empty($cookieExpire)) {
            $settings = $GLOBALS['TYPO3_CONF_VARS']['SYS'];
            // Get the domain to be used for the cookie (if any):
            $cookieDomain = $this->getCookieDomain();
            // If no cookie domain is set, use the base path:
            $cookiePath = ($cookieDomain ? '/' : GeneralUtility::getIndpEnv('TYPO3_SITE_PATH'));
            // If the cookie lifetime is set, use it:
            $cookieExpire = (int)$GLOBALS['EXEC_TIME'] + $cookieExpire;
            // Use the secure option when the current request is served by a secure connection:
            $cookieSecure = (bool)$settings['cookieSecure'] && GeneralUtility::getIndpEnv('TYPO3_SSL');
            // Deliver cookies only via HTTP and prevent possible XSS by JavaScript:
            $cookieHttpOnly = (bool)$settings['cookieHttpOnly'];

            // Do not set cookie if cookieSecure is set to "1" (force HTTPS) and no secure channel is used:
            if ((int)$settings['cookieSecure'] !== 1 || GeneralUtility::getIndpEnv('TYPO3_SSL')) {
                setcookie(
                    $cookieName,
                    $cookieValue,
                    (int)$cookieExpire,
                    $cookiePath,
                    $cookieDomain,
                    $cookieSecure,
                    $cookieHttpOnly
                );
                $this->cookieProtection = true;
                $this->logger->log(
                    LogLevel::INFO,
                    'setVoteCookie: Cookie set',
                    [
                                        'cookieName' => $cookieName,
                                        'cookieValue' => $cookieValue,
                                        'cookieExpire' => $cookieExpire,
                                        'cookiePath' => $cookiePath,
                                        'cookieDomain' => $cookieDomain,
                                        'cookieSecure' => $cookieSecure,
                                        'cookieHttpOnly' => $cookieHttpOnly,
                                    ]
                );
            } else {
                throw new Exception(
                    "Cookie was not set since HTTPS was forced in \$GLOBALS['TYPO3_CONF_VARS'][SYS][cookieSecure].",
                    1254325546
                );
            }
        }
    }

    /**
     * Return if cookie protection has been set
     *
     * @return bool
     */
    public function isProtected()
    {
        return $this->cookieProtection;
    }
}
