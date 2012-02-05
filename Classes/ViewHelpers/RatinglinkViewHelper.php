<?php

class Tx_ThRating_ViewHelpers_RatinglinkViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'a';
	
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('href', 'string', 'URI for non-javascript viewers');
	}
		
	/**
	 * Renders the hidden field.
	 * @return string
	 * @api
	 */
	public function render() {
		//<input type="hidden" name="ajaxSelect" value="{ajaxSelection}">		
		$this->tag->setContent($this->renderChildren());
		$content .= $this->tag->render();
		return $content;
	}	
}
?>