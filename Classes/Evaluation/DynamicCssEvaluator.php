<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Evaluation;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Evaluator
 * Remove the dynamic CSS file when values are modified in the BE
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class DynamicCssEvaluator
{
    /**
     * This function needs to return JavaScript code for client side evaluation of the
     * field value. The JavaScript variable "value" is set to the field value in the context
     * of this JS snippet.
     * In this example we just add the string "[added by JS]" to the field value.
     *
     * @return    string JavaScript code for evaluating the
     */
    public function returnFieldJS()
    {
        return 'return value;';
    }

    /**
     * This is the server side (i.e. PHP) side of the field evaluation.
     * We only remove the dynamic CSS file to re-create it the next request
     *
     * @param string $value : The value that has to be checked
     * @param string $is_in The "is_in" value of the field configuration from TCA
     * @param bool $set Boolean defining if the value is written to the database or not.
     * @return string      The new value of the field
     */
    public function evaluateFieldValue(string $value, string $is_in, bool &$set): string
    {
        $this->clearCachePostProc([]);

        //additionally clear eventually cached content
        $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
        $dataHandler->start([], []);
        $dataHandler->clear_cacheCmd('pages');
        return $value;
    }

    /**
     * Server-side validation/evaluation on opening the record
     *
     * @param array $parameters Array with key 'value' containing the field value from the database
     * @return string Evaluated field value
     */
    public function deevaluateFieldValue(array $parameters)
    {
        return $parameters['value'];
    }

    /**
     * Processings when cache is cleared
     * 1. Delete the file 'typo3temp/thratingDyn.css'
     *
     * @param array $params
     */
    public function clearCachePostProc(array $params)
    {
        $cssFileName = Environment::getPublicPath() . '/typo3temp/thratingDyn.css';
        GeneralUtility::unlink_tempfile($cssFileName);
    }
}
