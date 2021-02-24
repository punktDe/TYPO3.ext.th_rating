<?php

/*
 * This file is part of the package thucke/th-rating.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Thucke\ThRating\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
        'Service', ];

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
        $this->logger->log(LogLevel::DEBUG, 'setRichSnippetConfig Entry point', $settings);
        $this->richSnippetConfig['tablename'] = $settings['ratetable'];
        $this->richSnippetConfig['richSnippetFields'] = $settings['richSnippetFields'];

        if (is_array($this->richSnippetConfig['richSnippetFields'])) {
            $this->logger->log(
                LogLevel::DEBUG,
                'setRichSnippetConfig Exit point',
                $this->richSnippetConfig['richSnippetFields']
            );

            return true;
        }

        $this->logger->log(LogLevel::DEBUG, 'setRichSnippetConfig Exit point');

        return false;
    }

    /**
     * @return string
     */
    /** @noinspection PhpUnused */
    public function getRichSnippetConfig()
    {
        return json_encode($this->richSnippetConfig);
    }

    /**
     * @return string
     */
    /** @noinspection PhpUnused */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param string $schema
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException if parameter is invalid
     */
    public function setSchema($schema)
    {
        if (!empty($schema)) {
            if (in_array($schema, self::VALID_AGGREGATE_RATING_SCHEMA_TYPES, true)) {
                $this->schema = $schema;
            } else {
                throw new \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException(
                    LocalizationUtility::translate(
                        'error.richSnippetConfiguration.AggregateRatingPropertySchema',
                        'ThRating'
                    ),
                    1521487362
                );
            }
        }
    }

    /**
     * @return string
     */
    /** @noinspection PhpUnused */
    public function getAnchor()
    {
        return $this->anchor;
    }

    /**
     * @param string $anchor
     */
    public function setAnchor($anchor)
    {
        $this->anchor = $anchor;
    }

    /**
     * @param mixed $name
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
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException
     * @return string
     */
    public function getRichSnippetObject($uid)
    {
        $this->logger->log(LogLevel::DEBUG, 'getRichSnippetObject Entry point');
        $this->setSchema($this->richSnippetConfig['richSnippetFields']['aggregateRatingSchemaType']);
        if (empty($this->richSnippetConfig['richSnippetFields']['name'])) {
            $this->logger->log(LogLevel::DEBUG, 'No name field defined - skipping database access');
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

            $this->logger->log(LogLevel::DEBUG, 'Data fetched', $row);
            $this->setName($row[$this->richSnippetConfig['richSnippetFields']['name']]);
            $this->setDescription($row[$this->richSnippetConfig['richSnippetFields']['description']]);
        }
        $this->logger->log(LogLevel::DEBUG, 'getRichSnippetObject Exit point', (array)$this);

        return $this;
    }
}
