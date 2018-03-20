.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Documentation/Includes.txt

.. _ts-pluginThRatingSettingsFluidLayouts:

~.layouts
=========

At this point of time the extension uses two layouts:

#. ``DefaultLayout`` for all action handlers except :ts:`polling`
#. ``PollingLayout`` only for action handler :ts:`polling`

You may take a look at the file for better understanding the following options.
 
.. only:: html

   .. contents::
        :local:
        :depth: 3


Reference DefaultLayout
-----------------------

.. container:: ts-properties

   ==================================== ====================================================== ===============
   Property                             Title                                                  Type
   ==================================== ====================================================== ===============
   :ref:`tsShowSummaryDefault`          Switch to display rating summary info in output        boolean
   :ref:`tsShowCurrentRatesDefault`     Switch to display the current rating statistics        boolean
   showSectionContent_                  Switch to display the complete action content section  boolean
   ==================================== ====================================================== ===============

   :ts:`[tsref:plugin.tx_thrating.settings.fluid.layouts.default]`


.. _tsShowSummaryDefault:

showSummary
^^^^^^^^^^^

.. container:: table-row

   Property
      showSummary

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to display rating summary info in output.

   Default
      :ts:`1`
 

.. _tsShowCurrentRatesDefault:

showCurrentRates
^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      showCurrentRates

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to display the current rating statistics.

   Default
      :ts:`1`
 

.. _tsShowSectionContentDefault:

showSectionContent
^^^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      showSectionContent

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to display the complete action content section.

   Default
      :ts:`1`
 
 
Reference PollingLayout
-----------------------

.. container:: ts-properties

   ==================================== ====================================================== ===============
   Property                             Title                                                  Type
   ==================================== ====================================================== ===============
   :ref:`tsShowSummaryPoll`             Switch to display rating summary info in output        boolean
   :ref:`tsShowCurrentRatesPoll`        Switch to display the current polling statistics       boolean
   ==================================== ====================================================== ===============

   :ts:`[tsref:plugin.tx_thrating.settings.fluid.layouts.polling]`


.. _tsShowSummaryPoll:

showSummary
^^^^^^^^^^^

.. container:: table-row

   Property
      showSummary

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to display rating summary info in output.

   Default
      :ts:`0`
 
 
.. _tsShowCurrentRatesPoll:

showCurrentRates
^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      showCurrentPolls

   Data type
      :ref:`t3tsref:data-type-boolean`

   Description
      Switch to display the current polling statistics.

   Default
      :ts:`0`
