<?php
namespace Thucke\ThRating\Domain\Model;
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Thomas Hucke <thucke@web.de> 
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
 * Model for rating votes  
 *
 * @author		Thomas Hucke <thucke@web.de>
 * @copyright 	Copyright belongs to the respective authors
 * @license 	http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope 		beta
 * @entity
 */
class RatingImage extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var boolean
	 */
	protected $isBuilderObject=false;
	/**
	 * The filename of the final image
	 *
	 * @var string
	 */
	protected $imageFile;
	/**
	 * The typoscript image configuration array
	 * Only the top level node ['GIFBUILDER'] will be used for building the image
	 *
	 * @var array
	 */
	protected $conf;
	/**
	 * @var \TYPO3\CMS\Frontend\Imaging\GifBuilder
	 */
	protected $gifBuilder;
	/**
	 * @param \TYPO3\CMS\Frontend\Imaging\GifBuilder $gifBuilder
	 * @return void
	 */
	public function injectGifBuilder(\TYPO3\CMS\Frontend\Imaging\GifBuilder $gifBuilder) {
		$this->gifBuilder = $gifBuilder;
		$this->gifBuilder->init();
	}

	/**
	 * Constructs a new image object
	 *
	 * @param mixed	$conf	either an array consisting of GIFBUILDER typoscript or a plain string having the filename
	 * @return void
	 */
	public function __construct($conf = NULL) {
		$this->initializeObject();
		If (!empty($conf)) {
            $this->setConf($conf);
        }
	}

	/**
	 * Initializes the new vote object
	 * @return void
	 */
	 public function initializeObject() {
		if ( empty($this->gifBuilder) ) {
            /** @noinspection PhpParamsInspection */
            $this->injectGifBuilder(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Frontend\Imaging\GifBuilder::class));
		}
	 }

	/**
	 * Sets the typoscript configuration for the GIFBUILDER object
	 *
	 * @param mixed	$conf	either an array consisting of GIFBUILDER typoscript or a plain string having the filename
	 * @return void
	 */
	public function setConf($conf) {
		switch (gettype($conf)) {
			case 'string':
				$this->setImageFile($conf);
				break;
			case 'array':
				$this->conf = $conf;
				$this->generateImage();
				break;
			default:
				//TODO: Error message
		}
	}
	/**
	 * Returns the current typoscript configuration of the GIFBUILDER object
	 *
	 * @return array
	 */
	public function getConf() {
		If (empty($this->conf)) {
            return [];
        }
		return $this->conf;
	}
	/**
	 * Sets the filename of the image
	 *
	 * @param string $imageFile
	 * @return void
	 */
	public function setImageFile($imageFile) {
		$fullImagePath = PATH_site.$imageFile;
		if ( file_exists($fullImagePath) ) {
			$this->imageFile = $imageFile;
			$this->isBuilderObject = false;
		} else {
			//clear path if given file is invalid
            unset($this->imageFile, $this->isBuilderObject);
            //TODO: error handling
		}
	}
	/**
	 * Returns the filename of the image
	 *
	 * @var boolean $fullPath	switch if absolute path should be returned
	 * @return string
	 */
	public function getImageFile($fullPath = false) {
		$checkedFile = $this->gifBuilder->checkFile($this->imageFile);
		If (empty($checkedFile)) {
			//clear image if file doe not exist
			$this->setImageFile('xxx');
		}
		return $fullPath ? PATH_site.'/'.$this->imageFile : $this->imageFile;
	}
	/**
	 * Generates the image using the given typoscript
	 *
	 * @return	bool			The result; true if the given the image has been created successfully; otherwise false
	 */
	public function generateImage() {
		If (!empty($this->conf)) {
			$this->gifBuilder->start($this->getConf(), []);
			$genImageFile = $this->gifBuilder->gifBuild();
			If (!file_exists($genImageFile)) {
				//TODO: error handling
				return false;
			}
			$this->setImageFile($genImageFile);
			$this->isBuilderObject = true;
			return true;
		}

        return false;
    }

	/**
	 * Returns the filename of the image
	 *
	 * @var boolean $fullPath	switch if absolute path should be returned
	 * @return array('width','height')
	 */
	public function getImageDimensions() {
		If ($this->isBuilderObject) {
			[$width, $height] = $this->gifBuilder->getImageDimensions($this->imageFile);
		} else {
			[$width, $height] = getimagesize($this->getImageFile(true));
		}
		return ['width'=>$width, 'height'=>$height, 'builderObject'=>$this->isBuilderObject];
	}
	

	/**
	 * Method to use Object as plain string
	 * 
	 * @return string
	 */
		return $this->imageFile;
	}	
}
