.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Documentation/Includes.txt

.. _ts-constants:

Constants
=========

This page is divided into the following sections which are all configurable by using TypoScript or the constant editor:
All constants could be configured once per site. 

.. only:: html

   .. contents::
        :local:
        :depth: 1

plugin.tx_thrating.settings
---------------------------

.. container:: ts-properties

   ==================================== ====================================== ===============
   Property                             Title                                  Type
   ==================================== ====================================== ===============
   pluginStoragePid_                    General storage page                   int
   ==================================== ====================================== ===============


.. _constPluginStoragePid:

pluginStoragePid
""""""""""""""""

.. container:: table-row

   Property
      pluginStoragePid

   Data type
      :ref:`t3tsref:data-type-integer`

   Description
      General storage page where all records are stored. 

   Default
      \ 

plugin.tx_thrating.config
-------------------------

.. container:: ts-properties

   ==================================== ====================================== ===============
   Property                             Title                                  Type
   ==================================== ====================================== ===============
   loadJQuery_                          Switch to load jQuery                  boolean
   showNoFEUser_                        Display switch                         boolean
   cookieLifetime_                      Cookie protection lifetime             int
   mapAnonymous_                        Map UID to anonymous user              int
   ==================================== ====================================== ===============
   

.. _constLoadJQuery:

loadJQuery
""""""""""

.. container:: table-row

   Property
      loadJQuery

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Enable (1) / Disable (0) loading jQuery by this extension string

   Default
      :ts:`1`
      
      
.. _constShowNoFEUser:

showNoFEUser
""""""""""""

.. container:: table-row

   Property
      showNoFEUser

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Enable (1) / Disable (0) info if no FE user is logged on

   Default
      :ts:`0`


.. _constCookieLifetime:

cookieLifetime
""""""""""""""

.. container:: table-row

   Property
      cookieLifetime

   Data type
      :ref:`t3tsref:data-type-integer`

   Description
      Set lifetime for cookie protection (global setting [days]).
      Could be overridden by individual settings.

   Default
      :ts:`0`


.. _constMapAnonymous:

mapAnonymous
""""""""""""

.. container:: table-row

   Property
      mapAnonymous

   Data type
      :ref:`t3tsref:data-type-integer`

   Description
      UID of the FE user that holds all anonymous votings

   Default
      :ts:`0` (no anonymous votes allowed)



plugin.tx_thrating.view
-----------------------

.. container:: ts-properties

   ==================================== ====================================== ===============
   Property                             Title                                  Type
   ==================================== ====================================== ===============
   templateRootPath_                    path directive                         string
   partialRootPath_                     path directive                         string
   layoutRootPath_                      path directive                         string
   ==================================== ====================================== ===============
   
   
.. _constTemplateRootPath:

templateRootPath
""""""""""""""""

.. container:: table-row

   Property
      templateRootPath

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Path where the FLUID templates are stored

   Default
      :ts:`EXT:th_rating/Resources/Private/Templates/`


      
.. _constPartialRootPath:

partialRootPath
"""""""""""""""

.. container:: table-row

   Property
      partialRootPath

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Path where the FLUID partials are stored

   Default
      :ts:`EXT:th_rating/Resources/Private/Partials/`


.. _constLayoutRootPath:

layoutRootPath
""""""""""""""

.. container:: table-row

   Property
      layoutRootPath

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Path where the FLUID layouts are stored

   Default
      :ts:`EXT:th_rating/Resources/Private/Layouts/`
