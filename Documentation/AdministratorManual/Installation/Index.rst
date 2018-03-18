.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Includes.txt

.. _installation:

Installation
============

#. Install the extension **static_info_tables** as usual
#. Install this extension as usual

   |Install_EM|

#. Include the template of this extension in your site template

   |Install_InclTemplate|

#. Reference to the container for extension data

   Create a new sysfolder or choose an existing one and write down the PID.
   Open the TS Constant Editor and at least set the value in ``[plugin.tx_thrating.settings.pluginStoragePid]`` 
   to the former written down PID of the sysfolder
       
   |Install_Constants|

#. Reference to the container for Website users

   Create another folder designated as a container for Website Users and again write down the PID.
   Now open your website template and add the following configuration setup:
   :ts:`plugin.tx_felogin_pi1.storagePid = <PID of the website users container>` 