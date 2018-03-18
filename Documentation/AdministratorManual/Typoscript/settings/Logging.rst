.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Includes.txt

.. _ts-pluginThRatingSettingsLogging:

~.logging
=========

.. only:: html

   .. contents::
        :local:
        :depth: 3


This extension makes use of the logging framework which was newly introduced in TYPO3 6.1. 
For more information on this look at `Logging with TYPO3`_ in the TYPO3 Core API. 
For each log level as there are

-  :ts:`emergency`
-  :ts:`alert`
-  :ts:`critical`
-  :ts:`error`
-  :ts:`warning`
-  :ts:`notice`
-  :ts:`info`
-  :ts:`debug`

different logwriters of types :ts:`file` and/or :ts:`table` could be configured:

.. _Logging with TYPO3: https://docs.typo3.org/typo3cms/CoreApiReference/6.2/ApiOverview/Logging/Index.html


Reference
---------

.. container:: ts-properties

   ==================================== ======================================== ===============
   Property                             Title                                    Type
   ==================================== ======================================== ===============
   file_                                Filename to store log messages           resource
   table_                               Tablename to store log messages          string
   ==================================== ======================================== ===============

   :ts:`[tsref:plugin.tx_thrating.settings.logging.<level>]`

.. _tsLoggingFile:

file
^^^^

.. container:: table-row

   Property
      file

   Data type
      :ref:`t3tsref:data-type-resource`

   Description
      Filename to store log messages.

   Default
      \ 
 

.. _tsLoggingTable:

table
^^^^^

.. container:: table-row

   Property
      table

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      Tablename to store log messages

   Default
      \ 

      
Example
-------

.. code-block:: typoscript
   :linenos:

   plugin.tx_thrating.settings.logging {
      debug {
         file = typo3temp/logs/ThRating.log
         table = sys_log
      }
   }
   