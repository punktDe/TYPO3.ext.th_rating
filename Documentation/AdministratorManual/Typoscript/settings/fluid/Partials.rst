.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Documentation/Includes.txt

.. _ts-pluginThRatingSettingsFluidPartials:

~.partials
==========

This page is divided into the following sections:

.. only:: html

   .. contents::
        :local:
        :depth: 3


Reference ~.usersRating
-----------------------

.. container:: ts-properties

   ==================================== ====================================================== ===============
   Property                             Title                                                  Type
   ==================================== ====================================================== ===============
   showTextInfo_                        Switch to display rating summary info in output        boolean
   showGraphicInfo_                     Switch to display the current rating statistics.       boolean
   ==================================== ====================================================== ===============

   :ts:`[tsref:plugin.tx_thrating.settings.fluid.partials.usersRating]`


.. _tsShowTextInfo:

showTextInfo
^^^^^^^^^^^^

.. container:: table-row

   Property
      showSummary

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to display rating summary info in output.

   Default
      :ts:`1`
 

.. _tsShowGraphicInfo:

showGraphicInfo
^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      showCurrentRates

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to display the current rating statistics.

   Default
      :ts:`0`
 

 
Reference ~.infoBlock
---------------------

.. container:: ts-properties

   ==================================== ============================================================== ===============
   Property                             Title                                                          Type
   ==================================== ============================================================== ===============
   showAnonymousVotes_                  Switch to hide the infomation the anonymous votes are possible boolean
   ==================================== ============================================================== ===============

   :ts:`[tsref:plugin.tx_thrating.settings.fluid.partials.infoBlock]`


.. _tsShowAnonymousVotes:

showAnonymousVotes
^^^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      showAnonymousVotes

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to hide the infomation the anonymous votes are possible.

   Default
      :ts:`1`
