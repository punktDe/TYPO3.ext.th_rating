<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\ViewHelpers;

/**
 * The Selectbox Viewhelper
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class SelectViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper
{
    /**
     * Renders the rating select form
     */
    /** @noinspection PhpMissingParentCallCommonInspection */
    public function initializeArguments()
    {
        $this->registerArgument('additionalOptions', 'array', 'Associative array with values to prepend');
        $this->registerArgument(
            'options',
            'array',
            'Associative array with internal IDs as key, and the values are displayed in the select box.' .
                'Can be combined with or replaced by child f:form.select.* nodes.'
        );
        $this->registerTagAttribute('name', 'string', 'HTML name of this element');
        $this->registerTagAttribute('class', 'string', 'CSS class(es) for this element');
        $this->registerTagAttribute('onchange', 'string', 'Optional event handler');
    }

    /**
     * Render the option tags.
     *
     * @return array an associative array of options, key will be the value of the option tag
     */
    protected function getOptions()
    {
        $options = parent::getOptions();
        $additionalOptions = [];
        foreach ($this->arguments['additionalOptions'] as $key => $value) {
            $additionalOptions[utf8_encode('{"value":' . $key . '}')] = $value;
        }
        $array = $additionalOptions + $options;
        ksort($array);

        return $array;
    }
}
