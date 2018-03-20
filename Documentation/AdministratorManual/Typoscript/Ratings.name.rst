.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Documentation/Includes.txt


.. _ts-pluginThRatingsName:

~.ratings.{name}
================

This page is divided into the following sections:

.. only:: html

   .. contents::
        :local:
        :depth: 2

Each rating could have a special graphical configuration. Use this section to configure it. 
The configurations are seperated into subsections identified by a distinct name.

Within each you could do all typoscript settings described in :ref:`ts-pluginThRatingSettings`
and :ref:`ts-pluginThRatingSettingsFluid` (see :ref:`ts-pluginThRatingsNameExample`).

Best practice would be to include such configuration in your own template.
It is recommended to use distinct names for your ratingconfigurations.
Additionally - if you'd like to adjust the default given configurations - remember that your settings 
will override or enhance the default settings. But it is not possible to delete settings of the default. 
It is recommended to just copy the configuration you want from the file ``EXT:th_rating/Configuration/TypoScript/setup.txt``
or take one from the examples in this documentation. Then choose a different name and make your adjustments as you want. 


Reference
---------

.. container:: ts-properties

   ==================================== ======================================== ===============
   Property                             Title                                    Type
   ==================================== ======================================== ===============
   imagefile_                           File resource of the rating garphic      string
   barimage_                            Sets the imagetype to bar- or starrating boolean
   tilt_                                Activate up/down orientation             boolean
   ==================================== ======================================== ===============

   :ts:`[tsref:plugin.tx_thrating.settings.ratings.{name}]`

.. _tsImagefile:

imagefile
^^^^^^^^^
.. container:: table-row

   Property
      imagefile

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Imagename of the graphical representation including path.
      Path must be given relative to SITE_ROOT (e.g. ``typo3conf/ext/th_rating/Resources/Public/Css/stars.gif``) 

   Default
      \ 

.. _tsBarimage:

barimage
^^^^^^^^

.. container:: table-row

   Property
      barimage

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Sets the imagetype to barrating (1) or starrating (0)

   Default
      :ts:`0`


   
.. _tsTilt:

tilt
^^^^

.. container:: table-row

   Property
      tilt

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      If set the imagetype has up/down orientation

   Default
      :ts:`0`


.. _ts-pluginThRatingsNameExample:

Example
"""""""

Here an example which is also included in one of the default configurations:

.. code-block:: typoscript
   :linenos:

   plugin.tx_thrating.ratings {
      #use this section to configure your own ratingConfigurations
      exampleRatingConfig {
         imagefile = typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png
         barimage = 1
         tilt = 0
         settings {
            showNoFEUser = 1
            showNotRated = 1
            mapAnonymous = 0
            cookieLifetime = 0
         }
         fluid {
            layouts {
               default {
                  hideSummary = {$plugin.tx_thrating.config.hideSummary}
                  showCurrentRates = 1
                  showSectionContent = 1
               }
            }
            partials {
               usersRating {
                  showTextInfo = 1
                  showGraphicInfo = 0
               }
               infoBlock {
                  showAnonymousVotes = 1
               }
            }
         }
      }


Graphics requirements
---------------------

The graphic contains icons or stripes for all states:

-  not rated (e.g. |File_Req_nr.png| )
-  rated (e.g. |File_Req_r.png| )
-  choose rating (e.g. |File_Req_cr.png| )

It is recommended to choose icons of identical dimensions. These icons must be arranged in one file depending on
the imagetype in a manner as follows:

.. t3-field-list-table::
 :header-rows: 1

 - :row1:   Classic starrating
   :row2:   Tilt starrating
   :row3:   Barrating
   :row4:   Tilt barrating
   :row5:   smileyLikes

 - :row1:   |File_Req_classic_starrating|
   :row2:   |File_Req_tilt_starrating|
   :row3:   |File_Req_barrating|
   :row4:   |File_Req_tilt_barrating|
   :row5:   |File_Req_tilt_starrating|

 - :row1:   :typoscript:`stars`
   :row2:   :typoscript:`starsTilt`
   :row3:   :typoscript:`barrating`
   :row4:   :typoscript:`facesbartilt`
   :row5:   :typoscript:`smiley`

The table shows all preconfigured rating configuration and their names.

All icons (except those of the type barrating) are taken from `http://openiconlibrary.sourceforge.net/`_. 
All upper listed icons are licensed by GPL2 or PD. I appreciate the great work of those authors.
Anyway, if the usage of any icon hits the copyright of any person I´d ask this person to drop me a mail if he/she want me to remove it.