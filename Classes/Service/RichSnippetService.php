<?php
namespace Thucke\ThRating\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Thomas Hucke <thucke@web.de>
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
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * The voter
 */
class RichSnippetService extends AbstractExtensionService
{

    /**
     * Instances of AggregateRating may appear as properties of the following types
     * @const array
     */
    protected const VALID_AGGREGATE_RATING_SCHEMA_TYPES = [
        'Brand',
        'CreativeWork',
        'Event',
        'Offer',
        'Organization',
        'Place',
        'Product',
        'Service'];

    /**
     * @var string
     */
    protected $schema = 'Product';

    /**
     * @var string
     */
    protected $anchor;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $richSnippetConfig;

    /**
     * @param array $settings
     * @return bool
     */
    public function setRichSnippetConfig(array $settings)
    {
        $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'setRichSnippetConfig Entry point', $settings);
        $this->richSnippetConfig['tablename'] = $settings['ratetable'];
        $this->richSnippetConfig['richSnippetFields'] = $settings['richSnippetFields'];

        if (is_array($this->richSnippetConfig['richSnippetFields'])) {
            $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'setRichSnippetConfig Exit point', $this->richSnippetConfig['richSnippetFields']);
            return true;
        }

        $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'setRichSnippetConfig Exit point');
        return false;
    }

    /**
     * @return string
     */
    public function getRichSnippetConfig()
    {
        return json_encode($this->richSnippetConfig);
    }

    /**
     * @return string
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param string $schema
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException if parameter is invalid
     * @return void
     */
    public function setSchema($schema)
    {
        if (!empty($schema)) {
            if (in_array($schema, self::VALID_AGGREGATE_RATING_SCHEMA_TYPES, true)) {
                $this->schema = $schema;
            } else {
                throw new \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.richSnippetConfiguration.AggregateRatingPropertySchema', 'ThRating'), 1521487362
                );
            }
        }
    }

    /**
     * @return string
     */
    public function getAnchor()
    {
        return $this->anchor;
    }

    /**
     * @param string $anchor
     * @return void
     */
    public function setAnchor($anchor)
    {
        $this->anchor = $anchor;
    }

    /**
     * @param string
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param int $uid
     * @return string
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException
     */
    public function getRichSnippetObject($uid)
    {
        $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'getRichSnippetObject Entry point');
        $this->setSchema($this->richSnippetConfig['richSnippetFields']['aggregateRatingSchemaType']);
        if (empty($this->richSnippetConfig['richSnippetFields']['name'])) {
            $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'No name field defined - skipping database access');
            unset($this->name, $this->description);
        } else {
            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($this->richSnippetConfig['tablename']);

            //fetch whole row from database
            /** @var array $row */
            $row = $queryBuilder
                ->select('*')
                ->from($this->richSnippetConfig['tablename'])
                ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid)))
                ->execute()
                ->fetch();

            $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'Data fetched', $row);
            $this->setName($row[$this->richSnippetConfig['richSnippetFields']['name']]);
            $this->setDescription($row[$this->richSnippetConfig['richSnippetFields']['description']]);
        }
        $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, 'getRichSnippetObject Exit point', (array) $this);
        return $this;
    }
}
