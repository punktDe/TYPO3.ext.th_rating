<?php
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

/**
 * The Selectbox Viewhelper
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @author Thomas Hucke <thucke@web.de>
 */
class SelectViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper
{
    /**
     * Renders the rating select form
     */
    public function initializeArguments()
    {
        $this->registerArgument('additionalOptions', 'array', 'Associative array with values to prepend');
        $this->registerArgument('options', 'array', 'Associative array with internal IDs as key, and the values are displayed in the select box. Can be combined with or replaced by child f:form.select.* nodes.');
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
        //TODO delete deprecated $array = \TYPO3\CMS\Core\Utility\GeneralUtility::array_merge($options, $additionalOptions);
        $array = $additionalOptions + $options;
        ksort($array);

        return $array;
    }
}
