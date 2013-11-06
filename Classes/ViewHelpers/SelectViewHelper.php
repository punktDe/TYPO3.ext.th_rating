<?php

class Tx_ThRating_ViewHelpers_SelectViewHelper extends Tx_Fluid_ViewHelpers_Form_SelectViewHelper {

	
	/**
	 * Renders the rating select form
	 *
	 * @return string the content of the rendered select form object
	 * @author Thomas Hucke <thucke@web.de>
	 */	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('additionalOptions', 'array', 'Associative array with values to prepend', FALSE);
		$this->registerTagAttribute('onchange', 'string', 'Optional event handler');
	}
		
	protected function getOptions() {
		$options = parent::getOptions();
		$additionalOptions = array();
		foreach ($this->arguments['additionalOptions'] as $key => $value) {
			$additionalOptions[utf8_encode('{"value":'.$key.'}')] = $value;
		}
		$array = t3lib_div::array_merge($options, $additionalOptions);
		ksort ($array);
		return $array;
	}
}
?>