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
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * The voter
 */
class RichSnippetService extends AbstractExtensionService
{
    /**
     * Instances of AggregateRating may appear as properties of the following types
     * This list derives from Google's information about supported types in aggregateRating (20 May 2021)
     * (see https://developers.google.com/search/docs/data-types/review-snippet#aggregated-rating-type-definition)
     * @const array
     */
    protected const VALID_AGGREGATE_RATING_SCHEMA_TYPES = [
        'Book',
        'Audiobook',
        'Course',
        'CreativeWorkSeason',
        'PodcastSeason',
        'RadioSeason',
        'TVSeason',
        'CreativeWorkSeries',
        'BookSeries',
        'MovieSeries',
        'Periodical',
        'ComicSeries',
        'Newspaper',
        'PodcastSeries',
        'RadioSeries',
        'TVSeries',
        'VideoGameSeries',
        'Episode',
        'PodcastEpisode',
        'RadioEpisode',
        'TVEpisode',
        'Event',
        'BusinessEvent',
        'ChildrensEvent',
        'ComedyEvent',
        'CourseInstance',
        'DanceEvent',
        'DeliveryEvent',
        'EducationEvent',
        'EventSeries',
        'ExhibitionEvent',
        'Festival',
        'FoodEvent',
        'Hackathon',
        'LiteraryEvent',
        'MusicEvent',
        'PublicationEvent',
        'BroadcastEvent',
        'OnDemandEvent',
        'SaleEvent',
        'ScreeningEvent',
        'SocialEvent',
        'SportsEvent',
        'TheaterEvent',
        'VisualArtsEvent',
        'Game',
        'VideoGame',
        'HowTo',
        'Recipe',
        'LocalBusiness',
        'AnimalShelter',
        'ArchiveOrganization',
        'AutomotiveBusiness',
        'AutoBodyShop',
        'AutoDealer',
        'AutoPartsStore',
        'AutoRental',
        'AutoRepair',
        'AutoWash',
        'GasStation',
        'MotorcycleDealer',
        'MotorcycleRepair',
        'ChildCare',
        'Dentist',
        'DryCleaningOrLaundry',
        'EmergencyService',
        'FireStation',
        'Hospital',
        'PoliceStation',
        'EmploymentAgency',
        'EntertainmentBusiness',
        'AdultEntertainment',
        'AmusementPark',
        'ArtGallery',
        'Casino',
        'ComedyClub',
        'MovieTheater',
        'NightClub',
        'FinancialService',
        'AccountingService',
        'AutomatedTeller',
        'BankOrCreditUnion',
        'InsuranceAgency',
        'FoodEstablishment',
        'Bakery',
        'BarOrPub',
        'Brewery',
        'CafeOrCoffeeShop',
        'Distillery',
        'FastFoodRestaurant',
        'IceCreamShop',
        'Restaurant',
        'Winery',
        'GovernmentOffice',
        'PostOffice',
        'HealthAndBeautyBusiness',
        'BeautySalon',
        'DaySpa',
        'HairSalon',
        'HealthClub',
        'NailSalon',
        'TattooParlor',
        'HomeAndConstructionBusiness',
        'Electrician',
        'GeneralContractor',
        'HVACBusiness',
        'HousePainter',
        'Locksmith',
        'MovingCompany',
        'Plumber',
        'RoofingContractor',
        'InternetCafe',
        'LegalService',
        'Attorney',
        'Notary',
        'Library',
        'LodgingBusiness',
        'BedAndBreakfast',
        'Campground',
        'Hostel',
        'Hotel',
        'Motel',
        'Resort',
        'MedicalBusiness',
        'Dentist',
        'MedicalClinic',
        'CovidTestingFacility',
        'Optician',
        'Pharmacy',
        'Physician',
        'ProfessionalService',
        'RadioStation',
        'RealEstateAgent',
        'RecyclingCenter',
        'SelfStorage',
        'ShoppingCenter',
        'SportsActivityLocation',
        'BowlingAlley',
        'ExerciseGym',
        'GolfCourse',
        'HealthClub',
        'PublicSwimmingPool',
        'SkiResort',
        'SportsClub',
        'StadiumOrArena',
        'TennisComplex',
        'Store',
        'AutoPartsStore',
        'BikeStore',
        'BookStore',
        'ClothingStore',
        'ComputerStore',
        'ConvenienceStore',
        'DepartmentStore',
        'ElectronicsStore',
        'Florist',
        'FurnitureStore',
        'GardenStore',
        'GroceryStore',
        'HardwareStore',
        'HobbyShop',
        'HomeGoodsStore',
        'JewelryStore',
        'LiquorStore',
        'MensClothingStore',
        'MobilePhoneStore',
        'MovieRentalStore',
        'MusicStore',
        'OfficeEquipmentStore',
        'OutletStore',
        'PawnShop',
        'PetStore',
        'ShoeStore',
        'SportingGoodsStore',
        'TireShop',
        'ToyStore',
        'WholesaleStore',
        'TelevisionStation',
        'TouristInformationCenter',
        'TravelAgency',
        'MediaObject',
        '3DModel',
        'AudioObject',
        'Audiobook',
        'DataDownload',
        'ImageObject',
        'Barcode',
        'LegislationObject',
        'MusicVideoObject',
        'VideoObject',
        'Movie',
        'MusicPlaylist',
        'MusicAlbum',
        'MusicRelease',
        'MusicRecording',
        'Organization',
        'Airline',
        'Consortium',
        'Corporation',
        'EducationalOrganization',
        'CollegeOrUniversity',
        'ElementarySchool',
        'HighSchool',
        'MiddleSchool',
        'Preschool',
        'School',
        'FundingScheme',
        'GovernmentOrganization',
        'LibrarySystem',
        'LocalBusiness',
        'MedicalOrganization',
        'NGO',
        'NewsMediaOrganization',
        'Dentist',
        'DiagnosticLab',
        'Hospital',
        'MedicalClinic',
        'Pharmacy',
        'Physician',
        'VeterinaryCare',
        'PerformingGroup',
        'DanceGroup',
        'MusicGroup',
        'TheaterGroup',
        'Project',
        'FundingAgency',
        'ResearchProject',
        'SportsOrganization',
        'SportsTeam',
        'WorkersUnion',
        'Product',
        'IndividualProduct',
        'ProductCollection',
        'ProductGroup',
        'ProductModel',
        'SomeProducts',
        'Vehicle',
        'BusOrCoach',
        'Car',
        'Motorcycle',
        'MotorizedBicycle',
        'Recipe',
        'SoftwareApplication',
        'MobileApplication',
        'VideoGame',
        'WebApplication'
    ];

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
    public function setRichSnippetConfig(array $settings): bool
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
     * @return string|false
     */
    public function getRichSnippetConfig()
    {
        return GeneralUtility::makeInstance(\Thucke\ThRating\Service\JsonService::class)
            ->encodeToJson($this->richSnippetConfig);
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }

    /**
     * @param string|null $schema
     * @throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException if parameter is invalid
     */
    public function setSchema(?string $schema): void
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
    public function getAnchor(): string
    {
        return $this->anchor;
    }

    /**
     * @param string $anchor
     */
    public function setAnchor(string $anchor): void
    {
        $this->anchor = $anchor;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param int $uid
     * @return RichSnippetService
     *@throws \Thucke\ThRating\Exception\InvalidAggregateRatingSchemaTypeException
     */
    public function getRichSnippetObject(int $uid): self
    {
        $this->logger->log(LogLevel::DEBUG, 'getRichSnippetObject Entry point');
        $this->setSchema($this->richSnippetConfig['richSnippetFields']['aggregateRatingSchemaType']);
        if (empty($this->richSnippetConfig['richSnippetFields']['name'])) {
            $this->logger->log(LogLevel::INFO, 'No name field defined - skipping database access');
            unset($this->name, $this->description);
            throw new \TYPO3\CMS\Core\Exception();
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

            $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
            //$this->setDescription($row[$this->richSnippetConfig['richSnippetFields']['description']]);
            $this->setDescription($contentObjectRenderer->cObjGetSingle('TEXT', $this->richSnippetConfig['richSnippetFields']['description']));
            //$this->setDescription($contentObjectRenderer->render($this->richSnippetConfig['richSnippetFields']['description']));
        }
        $this->logger->log(LogLevel::DEBUG, 'getRichSnippetObject Exit point', (array)$this);

        return $this;
    }
}
