<?php

class Tx_ThRating_ViewHelpers_RatinglinkViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractTagBasedViewHelper {

	/**
	 * Renders the ratinglink object
	 *
	 * @return string the content of the rendered TypoScript object
	 * @author Thomas Hucke <thucke@web.de>
	 */

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
		$this->tag->setContent($this->renderChildren());
		$content .= $this->tag->render();
		return $content;
	}	
}
?>