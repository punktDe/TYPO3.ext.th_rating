.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


.. _ts-richSnippetFields:

~.richSnippetFields
===================

This extension provides support for `Google rich snippets`_.
Setting the following options some meta information could be configured which is being read from the database for each rated item.
The configured options must be field descriptors in the rated table.

.. container:: ts-properties

   ==================================== ============================================= ===============
   Property                             Title                                         Type
   ==================================== ============================================= ===============
   name_                                Fieldname to fetch the item name from         string
   description_                         Fieldname to fetch the item description from  string
   aggregateRatingSchemaType_           SchemaType having aggregateRating as property string
   ==================================== ============================================= ===============

   :ts:`[tsref:plugin.tx_thrating.settings.richSnippetFields]`


.. _rsfName:

name
^^^^

.. container:: table-row

   Property
      name

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Fieldname to fetch the item name from.
      If no or an invalid name is given, the default value consists of the constant text "Rating AX"
      appendixed by the UID values of the ratingobject and the rated object.
      (e.g. "``Rating AX 2_30``" meaning ratingobject #2 / ratedobject #30).

   Default
      :ts:`Rating AX xx_yy`

.. _rsfDescription:

description
^^^^^^^^^^^

.. container:: table-row

   Property
      description

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Fieldname to fetch the item description from

   Default
      \


Example
-------

.. code-block:: typoscript
   :linenos:

   temp.pollingDemo < plugin.tx_thrating
   temp.pollingDemo {
      settings {
         richSnippetFields {
            name = pollingheader
            description = pollingbodytext
            url =
         }
      }
   }


.. _rsfAggregateRatingSchemaType:

aggregateRatingSchemaType
^^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      aggregateRatingSchemaType

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      According to `Schema.org aggregateRating`_ and `Google rich snippets types`_ the following are supported:

      - ``3DModel``
      - ``AccountingService``
      - ``AdultEntertainment``
      - ``Airline``
      - ``AmusementPark``
      - ``AnimalShelter``
      - ``ArchiveOrganization``
      - ``ArtGallery``
      - ``Attorney``
      - ``AudioObject``
      - ``Audiobook``
      - ``AutoBodyShop``
      - ``AutoDealer``
      - ``AutoPartsStore``
      - ``AutoRental``
      - ``AutoRepair``
      - ``AutoWash``
      - ``AutomatedTeller``
      - ``AutomotiveBusiness``
      - ``Bakery``
      - ``BankOrCreditUnion``
      - ``BarOrPub``
      - ``Barcode``
      - ``BeautySalon``
      - ``BedAndBreakfast``
      - ``BikeStore``
      - ``BookSeries``
      - ``BookStore``
      - ``Book``
      - ``BowlingAlley``
      - ``Brewery``
      - ``BroadcastEvent``
      - ``BusOrCoach``
      - ``BusinessEvent``
      - ``CafeOrCoffeeShop``
      - ``Campground``
      - ``Car``
      - ``Casino``
      - ``ChildCare``
      - ``ChildrensEvent``
      - ``ClothingStore``
      - ``CollegeOrUniversity``
      - ``ComedyClub``
      - ``ComedyEvent``
      - ``ComicSeries``
      - ``ComputerStore``
      - ``Consortium``
      - ``ConvenienceStore``
      - ``Corporation``
      - ``CourseInstance``
      - ``Course``
      - ``CovidTestingFacility``
      - ``CreativeWorkSeason``
      - ``CreativeWorkSeries``
      - ``DanceEvent``
      - ``DanceGroup``
      - ``DataDownload``
      - ``DaySpa``
      - ``DeliveryEvent``
      - ``Dentist``
      - ``DepartmentStore``
      - ``DiagnosticLab``
      - ``Distillery``
      - ``DryCleaningOrLaundry``
      - ``EducationEvent``
      - ``EducationalOrganization``
      - ``Electrician``
      - ``ElectronicsStore``
      - ``ElementarySchool``
      - ``EmergencyService``
      - ``EmploymentAgency``
      - ``EntertainmentBusiness``
      - ``Episode``
      - ``EventSeries``
      - ``Event``
      - ``ExerciseGym``
      - ``ExhibitionEvent``
      - ``FastFoodRestaurant``
      - ``Festival``
      - ``FinancialService``
      - ``FireStation``
      - ``Florist``
      - ``FoodEstablishment``
      - ``FoodEvent``
      - ``FundingAgency``
      - ``FundingScheme``
      - ``FurnitureStore``
      - ``Game``
      - ``GardenStore``
      - ``GasStation``
      - ``GeneralContractor``
      - ``GolfCourse``
      - ``GovernmentOffice``
      - ``GovernmentOrganization``
      - ``GroceryStore``
      - ``HVACBusiness``
      - ``Hackathon``
      - ``HairSalon``
      - ``HardwareStore``
      - ``HealthAndBeautyBusinness``
      - ``HealthClub``
      - ``HighSchool``
      - ``HobbyShop``
      - ``HomeAndConstructionBusiness``
      - ``HomeGoodsStore``
      - ``Hospital``
      - ``Hostel``
      - ``Hotel``
      - ``HousePainter``
      - ``HowTo``
      - ``IceCreamShop``
      - ``ImageObject``
      - ``IndividualProduct``
      - ``InsuranceAgency``
      - ``InternetCafe``
      - ``JewelryStore``
      - ``LegalService``
      - ``LegislationObject``
      - ``LibrarySystem``
      - ``Library``
      - ``LiquorStore``
      - ``LiteraryEvent``
      - ``LocalBusiness``
      - ``Locksmith``
      - ``LodgingBusiness``
      - ``MediaObject``
      - ``MedicalBusiness``
      - ``MedicalClinic``
      - ``MedicalOrganization``
      - ``MensClothingStore``
      - ``MiddleSchool``
      - ``MobileApplication``
      - ``MobilePhoneStore``
      - ``Motel``
      - ``MotorcycleDealer``
      - ``MotorcycleRepair``
      - ``Motorcycle``
      - ``MotorizedBicycle``
      - ``MovieRentalStore``
      - ``MovieSeries``
      - ``MovieTheater``
      - ``Movie``
      - ``MovingCompany``
      - ``MusicAlbum``
      - ``MusicEvent``
      - ``MusicGroup``
      - ``MusicPlaylist``
      - ``MusicRecording``
      - ``MusicRelease``
      - ``MusicStore``
      - ``MusicVideoObject``
      - ``NGO``
      - ``NailSalon``
      - ``NewsMediaOrganization``
      - ``Newspaper``
      - ``NightClub``
      - ``Notary``
      - ``OfficeEquipmentStore``
      - ``OnDemandEvent``
      - ``Optician``
      - ``Organization``
      - ``OutletStore``
      - ``PawnShop``
      - ``PerformingGroup``
      - ``Periodical``
      - ``PetStore``
      - ``Pharmacy``
      - ``Physician``
      - ``Plumber``
      - ``PodcastEpisode``
      - ``PodcastSeason``
      - ``PodcastSeries``
      - ``PoliceStation``
      - ``PostOffice``
      - ``Preschool``
      - ``ProductCollection``
      - ``ProductGroup``
      - ``ProductModel``
      - ``Product``
      - ``ProfessionalService``
      - ``Project``
      - ``PublicSwimmingPool``
      - ``PublicationEvent``
      - ``RadioEpisode``
      - ``RadioSeason``
      - ``RadioSeries``
      - ``RadioStation``
      - ``RealEstateAgent``
      - ``Recipe``
      - ``RecyclingCenter``
      - ``ResearchProject``
      - ``Resort``
      - ``Restaurant``
      - ``RoofingContractor``
      - ``SaleEvent``
      - ``School``
      - ``ScreeningEvent``
      - ``SelfStorage``
      - ``ShoeStore``
      - ``ShoppingCenter``
      - ``SkiResort``
      - ``SocialEvent``
      - ``SoftwareApplication``
      - ``SomeProducts``
      - ``SportingGoodsStore``
      - ``SportsActivityLocation``
      - ``SportsClub``
      - ``SportsEvent``
      - ``SportsOrganization``
      - ``SportsTeam``
      - ``StadiumOrArena``
      - ``Store``
      - ``TVEpisode``
      - ``TVSeason``
      - ``TVSeries``
      - ``TattooParlor``
      - ``TelevisionStation``
      - ``TennisComplex``
      - ``TheaterEvent``
      - ``TheaterGroup``
      - ``TireShop``
      - ``TouristInformationCenter``
      - ``ToyStore``
      - ``TravelAgency``
      - ``Vehicle``
      - ``VeterinaryCare``
      - ``VideoGameSeries``
      - ``VideoGame``
      - ``VideoObject``
      - ``VisualArtsEvent``
      - ``WebApplication``
      - ``WholesaleStore``
      - ``Winery``
      - ``WorkersUnion``

      .. warning::

         Any other value will cause an exception during frontend rendering.

   Default
      :ts:`Product`


.. ==================================================
.. Image definitions
.. --------------------------------------------------

.. _Schema.org aggregateRating: https://schema.org/aggregateRating
