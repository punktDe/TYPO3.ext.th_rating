.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _signal-slot-support:

Signal / Slot support
=====================

.. toctree::
   :maxdepth: 3
   :titlesonly:


Rating AX provides support for the signal / slot messaging feature of extbase.
Currently the extension will "listen" for two signals:

-  ``afterRatinglinkAction``
-  ``afterCreateAction``

Registered slots are being called with two parameters:

.. container::

   ==================================== ============================================== ================
   Parameter                            Description                                    Type
   ==================================== ============================================== ================
   signalSlotMessage_                   rating data of the rated object                HashTable
   customContent_                       Modify pre- and post- content of the extension HashTable by ref
   ==================================== ============================================== ================

   ``[SignalSlotDispatcherParameter]``


signalSlotMessage
-----------------

This hashtable provides the registered signalslot with some data upon the actual handled ratedobject.
The keys are described in the following tables.


.. container:: table-row

   Property
      ``tablename``

   Data type
      ``String``

   Description
      The tablename of the rated object


.. container:: table-row

   Property
      ``fieldname``

   Data type
      ``String``

   Description
      The fieldname of the rated object


.. container:: table-row

   Property
      ``uid``

   Data type
      ``Integer``

   Description
      The uid of the rated object


.. container:: table-row

   Property
      ``currentRates``

   Data type
      ``Array``

   Description
      Contains information representing the actual rating statistics

      .. _currentRatesKeys:

      .. container::

         ``[Keys of hashtable currentRates]``

         +-----------------------------------+---------------------------------------------------------------+---------------+
         | Key                               | Description                                                   | Type          |
         +===================================+===============================================================+===============+
         | ``currentrate``                   | The calculated overall rating                                 | Long          |
         +-----------------------------------+---------------------------------------------------------------+---------------+
         | ``weightedVotes``                 | Voting counts for each ratingstep                             | Array         |
         +-----------------------------------+---------------------------------------------------------------+---------------+
         | ``sumWeightedVotes``              | Voting counts for each ratingstep multiplied by their weights | Array         |
         +-----------------------------------+---------------------------------------------------------------+---------------+
         | ``currentPollDimensions``         | Detailed key description see currentPollDimensionsKeys_       | HashTable     |
         +-----------------------------------+---------------------------------------------------------------+---------------+
         | .. raw:: html                                                                                                     |
         |                                                                                                                   |
         |    <br/>                                                                                                          |
         |                                                                                                                   |
         | .. important::                                                                                                    |
         |                                                                                                                   |
         |    Depending on whether the user has done a valid voting as anonymous or FE user the following additional key     |
         |    are avaiable                                                                                                   |
         +-----------------------------------+---------------------------------------------------------------+---------------+
         | ``voter``                         | The uid of the frontenduser that has voted                    | Integer       |
         +-----------------------------------+---------------------------------------------------------------+---------------+
         | ``votingStep``                    | The ratingstep that has been choosen                          | Integer       |
         +-----------------------------------+---------------------------------------------------------------+---------------+
         | ``votingName``                    | The name of the ratingstep                                    | String        |
         +-----------------------------------+---------------------------------------------------------------+---------------+
         | ``anonymousVote``                 |  True/False if it was an anonymous rating                     | Boolean       |
         +-----------------------------------+---------------------------------------------------------------+---------------+

      |
      |

      .. _currentPollDimensionsKeys:

      .. container::

         ``[Keys of hashtable currentPollDimensions]``

         ==================================== ============================================================= ================
         Key                                  Description                                                   Type
         ==================================== ============================================================= ================
         ``pctValue``                         Polling percentage for each ratingstep                        Integer
         ``anonymousVotes``                   Count of anonymous voting                                     Integer
         ``numAllVotes``                      Overall count of given votings                                Integer
         ==================================== ============================================================= ================


customContent
-------------

Array by reference to modify pre- and post- content of the extension.
The  registered slothandler could fill this array with pure HTML code wich will be included into the extension output.

.. container::

   ==================================== ====================================================================================
   Parameter                            Description
   ==================================== ====================================================================================
   ``staticPreContent``                 this content will be included in front of the extension output (NOT changed by AJAX)
   ``staticPostContent``                this content will be included after the extension output (NOT changed by AJAX)
   ``preContent``                       this content will be included in front of the extension output (changed by AJAX)
   ``postContent``                      this content will be included after the extension output (changed by AJAX)
   ==================================== ====================================================================================


The following picture will help you understand the different sections of the extension output.

.. figure:: ThRating_defaultLayout.gif
   :alt: Rating AX template structure
   :align: left

   Rating AX HTML template structure

Using the right CSS formattings it would be easy to arrange the different sections for your specific needs.

