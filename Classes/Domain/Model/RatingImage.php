<?php
namespace Thucke\ThRating\Domain\Model;

use Thucke\ThRating\Utility\DeprecationHelperUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Frontend\Imaging\GifBuilder;

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
 * @author  Thomas Hucke <thucke@web.de>
 * @copyright  Copyright belongs to the respective authors
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope   beta
 * @entity
 */
class RatingImage extends AbstractEntity
{
    /**
     * @var bool
     */
    protected $isBuilderObject = false;
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
     * @var GifBuilder
     */
    protected $gifBuilder;

    /**
     * @param GifBuilder $gifBuilder
     */
    public function injectGifBuilder(GifBuilder $gifBuilder)
    {
        $this->gifBuilder = $gifBuilder;
        $this->gifBuilder->init();
    }

    /**
     * Constructs a new image object
     *
     * @param mixed $conf either an array consisting of GIFBUILDER typoscript or a plain string having the filename
     */
    public function __construct($conf = null)
    {
        $this->initializeObject();
        if (!empty($conf)) {
            $this->setConf($conf);
        }
    }

    /**
     * Initializes the new vote object
     */
    public function initializeObject()
    {
        if (empty($this->gifBuilder)) {
            $this->injectGifBuilder(GeneralUtility::makeInstance(GifBuilder::class));
        }
    }

    /**
     * Sets the typoscript configuration for the GIFBUILDER object
     *
     * @param mixed $conf either an array consisting of GIFBUILDER typoscript or a plain string having the filename
     */
    public function setConf($conf)
    {
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
    public function getConf(): array
    {
        if (empty($this->conf)) {
            return [];
        }

        return $this->conf;
    }

    /**
     * Sets the filename of the image
     *
     * @param string $imageFile
     */
    public function setImageFile($imageFile)
    {

        $fullImagePath = DeprecationHelperUtility::getPublicPath() . $imageFile;
        if (file_exists($fullImagePath)) {
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
     * @param mixed $fullPath
     * @return string
     */
    public function getImageFile($fullPath = false)
    {
        $checkedFile = $this->gifBuilder->checkFile($this->imageFile);
        if (empty($checkedFile)) {
            //clear image if file doe not exist
            $this->setImageFile('xxx');
        }
        return $fullPath ? DeprecationHelperUtility::getPublicPath() . '/' . $this->imageFile : $this->imageFile;
    }

    /**
     * Generates the image using the given typoscript
     *
     * @return bool   The result; true if the given the image has been created successfully; otherwise false
     */
    public function generateImage()
    {
        if (!empty($this->conf)) {
            $this->gifBuilder->start($this->getConf(), []);
            $genImageFile = $this->gifBuilder->gifBuild();
            if (!file_exists($genImageFile)) {
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
     * @var bool switch if absolute path should be returned
     * @return array('width','height')
     */
    public function getImageDimensions()
    {
        if ($this->isBuilderObject) {
            [$width, $height] = $this->gifBuilder->getImageDimensions($this->imageFile);
        } else {
            [$width, $height] = getimagesize($this->getImageFile(true));
        }

        return ['width' => $width, 'height' => $height, 'builderObject' => $this->isBuilderObject];
    }

    /**
     * Method to use Object as plain string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->imageFile;
    }
}
