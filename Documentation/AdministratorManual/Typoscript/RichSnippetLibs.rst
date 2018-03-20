.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Documentation/Includes.txt


.. _ts-richSnippetLibs:

~.richSnippetLibs
=================
      
This extension provides support for `Google rich snippets`_. 
You may enhance the information included in each rating using some typoscript library definitions.
The following paths will be used:
  

.. container:: ts-properties

   ==================================== ============================================ ===============
   Property                             Title                                        Type
   ==================================== ============================================ ===============
   lib.thrating.ratedObjectUrl_         URL of the item                              TEXT
   lib.thrating.ratedObjectImage_       URL of the item image                        IMG_RESOURCE
   ==================================== ============================================ ===============

.. _rslRatedObjectUrl:

lib.thrating.ratedObjectUrl
^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      lib.thrating.ratedObjectUrl

   Data type
      :ref:`t3tsref:cobj-text`

   Description
      URL to the rated item.
      If no or an invalid name is given, the default value consists of the current URL, 
      the constant text "RatingAX" appendixed by the UID values of the ratingobject and the rated object.
      (e.g. "``RatingAX_2_30``" meaning ratingobject #2 / ratedobject #30).

   Default
      ``[scheme]://[host][:[port]][path_script]?id=[page_uid]#RatingAX_xx_yy``
      

         
.. _rslRatedObjectImage:

lib.thrating.ratedObjectImage
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      lib.thrating.ratedObjectImage

   Data type
      :ref:`t3tsref:cobj-img-resource`

   Description
      Reference to an image of the rated object.  

   Default
      \ 