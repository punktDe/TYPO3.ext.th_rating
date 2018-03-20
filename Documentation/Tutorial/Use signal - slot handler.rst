.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Documentation/Includes.txt

.. _tutorial-signal-slot-handler:

Use signal / slot handler
=========================

Adding a new signal slot is easy. Just add code like the following in your ``ext_localconf.php``:

.. code:: php

   include_once(t3lib_extMgm::extPath($_EXTKEY).'pi1/class.ThRatingSignalSlotHandler.php');
   //Implement handling of signals from rating
   $signalSlotDispatcher = t3lib_div::makeInstance('Tx_Extbase_SignalSlot_Dispatcher');
   $signalSlotDispatcher->connect('Thucke\\ThRating\\Controller\\VoteController', 'afterCreateAction', 'ThRatingSignalSlotHandler', 'afterCreateRatingAction',FALSE);

Second you may create the file e.g. with the following content:

.. code:: php

   <?
   if (!defined ('TYPO3_MODE'))    die ('Access denied.');
   
   class tx_f4missions_main_signalHandler {
   
      /**
       * Signal handler after a rating has bee created
       * Do timestamp update on changed entry and
       * set new staticPre- and staticPostContent on inital display and
       * set new pre- and postContent with each AJAX-Request
       */
      function afterCreateRatingAction( $signalSlotMessage, &$customContent ) {
         $updateFields['tstamp'] = time();
         $GLOBALS['TYPO3_DB']->exec_UPDATEquery( $signalSlotMessage['tablename'], 'uid='.$signalSlotMessage['uid'], $updateFields);
         $customContent['staticPreContent']='<b>This ist my staticPreContent</b>';
         $customContent['staticPostContent']='<b>This ist my staticPostContent</b>';
         $customContent['preContent']='<b>This ist my preContent</b>';
         $customContent['postContent']='<b>This ist my postContent</b>';
      }
   }
   ?>

This handler will update the field tstamp of the rated row each time a rating is added.