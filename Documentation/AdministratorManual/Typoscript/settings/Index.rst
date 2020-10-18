.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


.. _ts-pluginThRatingSettings:

~.settings
==========

Whithin this section you may set some general configurations regarding your rating.

.. only:: html

   .. contents::
        :local:
        :depth: 2

Sub-Sections
------------

.. toctree::
   :maxdepth: 5
   :titlesonly:

   fluid/Index
   Logging
   RichSnippetFields


Reference
---------

.. container:: ts-properties

   ==================================== ======================================== ===============
   Property                             Title                                    Type
   ==================================== ======================================== ===============
   display_                             Name of the rating configuration to use. string
   ratetable_                           Tablename of the ratingobject            string
   ratefield_                           Fieldname of the ratingobject            string
   ratingContext_                       CSS class addition                       string
   ratingobject_                        UID of the ratingobject                  int
   ratedobjectuid_                      UID of the rated row in the table        int
   mapAnonymous_                        UID of the anonymous FE user             int
   cookieLifetime_                      Cookie protection lifetime               int
   showNoFEUser_                        Switch to activate info                  boolean
   showNotRated_                        Switch to deactivate info                boolean
   displayOnly_                         Switch to deactivate ratings             boolean
   enableReVote_                        Switch to enable re-votings              boolean
   foreignFieldArrayUpdate_             Switch to enable foreign updates         boolean
   ==================================== ======================================== ===============

   :ts:`[tsref:plugin.tx_thrating.settings]`


.. _tsDisplay:

display
^^^^^^^

.. container:: table-row

   Property
      display

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Name of the rating configuration to use as set per default. Value depends on choosen action.

   Default
      different depending on action


.. _tsRatetable:

ratetable
^^^^^^^^^

.. container:: table-row

   Property
      ratetable

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Tablename of the ratingobject

   Default
      :ts:`tt_content`


.. _tsRatefield:

ratefield
^^^^^^^^^

.. container:: table-row

   Property
      ratefield

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Fieldname of the ratingobject

   Default
      :ts:`uid`


.. _tsRatingContext:

ratingContext
^^^^^^^^^^^^^

.. container:: table-row

   Property
      ratingContext

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      CSS class addition to defer between different formattings in different contexts

   Default
      :ts:`defaultContext`


.. _tsRatingobject:

ratingobject
""""""""""""

.. container:: table-row

   Property
      ratingobject

   Data type
      :ref:`t3tsref:data-type-integer`

   Description
      UID of the ratingobject. Could be helpful to increase performance instead of using ratetable/ratefield combination.

   Default
      \

.. _tsRatedobjectuid:

ratedobjectuid
^^^^^^^^^^^^^^

.. container:: table-row

   Property
      ratedobjectuid

   Data type
      :ref:`t3tsref:data-type-integer`

   Description
      UID of the rated row in the table

   Default


.. _tsMapAnonymous:

mapAnonymous
^^^^^^^^^^^^

.. container:: table-row

   Property
      mapAnonymous

   Data type
      :ref:`t3tsref:data-type-integer`

   Description
      UID of the FE user that holds all anonymous votings

   Default
      see constant :ref:`constMapAnonymous`

.. _tsCookieLifetime:

cookieLifetime
^^^^^^^^^^^^^^

.. container:: table-row

   Property
      cookieLifetime

   Data type
      :ref:`t3tsref:data-type-integer`

   Description
      Lifetime of cookie protection for anonymous votes

   Default
      :ts:`0`


.. _tsShowNoFEUser:

showNoFEUser
^^^^^^^^^^^^

.. container:: table-row

   Property
      showNoFEUser

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to activate info if no user is logged on.

   Default
      see constants: :ref:`constShowNoFEUser`


.. _tsShowNotRated:

showNotRated
^^^^^^^^^^^^

.. container:: table-row

   Property
      showNotRated

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to deactivate info if no no rating has been done yet.

   Default
      :ts:`0`


.. _tsDisplayOnly:

displayOnly
^^^^^^^^^^^

.. container:: table-row

   Property
      displayOnly

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to deactivate ratings and only display current rating.

   Default
      :ts:`0`


.. _tsEnableReVote:

enableReVote
^^^^^^^^^^^^

.. container:: table-row

   Property
      enableReVote

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to enable users to change their given votings.

   Default
      :ts:`0`


.. _tsForeignFieldArrayUpdate:

foreignFieldArrayUpdate
^^^^^^^^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      foreignFieldArrayUpdate

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Update foreign ratetable in ratefield using the whole getCurrentRates array or double value (default)

   Default
      :ts:`0`


**Example**

Here an example which is also included in one of the default configurations:

.. code-block:: typoscript
   :linenos:

   plugin.tx_thrating.settings {
         ratetable = tt_content
         ratefield = uid
         #ratingobject = 1
         ratedobjectuid = 1
         #display = stars - not needed if default is used
     }
