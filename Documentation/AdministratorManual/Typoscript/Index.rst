.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

.. _ts-settings:

Typoscript
==========

Please scan the following sections to find out what is configurable by using TypoScript:

.. only:: html

.. toctree::
   :maxdepth: 3
   :titlesonly:

   Ratings.name
   RichSnippetLibs
   settings/Index


plugin.tx_thrating
******************

This page is divided into the following sections:

.. only:: html

   .. contents::
        :local:
        :depth: 2


Reference
---------

.. container:: ts-properties

   ==================================== ====================================== ===============
   Property                             Title                                  Type
   ==================================== ====================================== ===============
   action_                              MVC-action to use                      string
   storagePid_                          General storage page                     int
   ==================================== ====================================== ===============


.. _tsAction:

action
^^^^^^

.. container:: table-row

   Property
      action

   Data type
      :ref:`t3tsref:data-type-string`

   Description
      MVC-Action to activa. Possible values:

      - :typoscript:`ratinglinks`
			Graphical presentation to do and to display ratings

      - :typoscript:`mark`
			One step rating similar to FB like button

      - :typoscript:`polling`
			ratings are presented as pollings giving percentages.

      - :typoscript:`show`
			Display the actual vote of the currently logged on FE user in plain text

      - :typoscript:`new`
			Generate a classic form element (default: drop-drown select field) for voting.
			If the user has already voted action :typoscript:`show` is used.

      .. important::

         Whatever value is configured here it must also be set in :typoscript:`plugin.tx_thrating.switchableControllerActions.Vote`:

         .. code-block:: typoscript

            plugin.tx_thrating.switchableControllerActions {
               Vote {
                  1 = ratinglinks
               }
            }

   Default
      :ts:`ratinglinks`

.. _tsStoragePid:

storagePid
^^^^^^^^^^

.. container:: table-row

   Property
      storagePid

   Data type
      :ref:`t3tsref:data-type-integer`

   Description
      General storage page where all records are stored.

   Default
      value of constant :ref:`constPluginStoragePid`

.. _tsFeUsersStoragePid:

feUsersStoragePid
^^^^^^^^^^^^^^^^^

.. container:: table-row

   Property
      feUsersStoragePid

   Data type
      :ref:`t3tsref:data-type-integer`

   Description
      Storage page where frontend user records are stored (normally set in context of
`Frontend Login configuration<https://docs.typo3.org/c/typo3/cms-felogin/master/en-us/Configuration/Index.html>`_).

   Default
      value of constant :typoscript:`styles.content.loginform.pid`


Example
-------

.. code-block:: typoscript
   :linenos:

   temp.pollingDemo < plugin.tx_thrating
   temp.pollingDemo {
      action = polling
      switchableControllerActions {
         Vote {
            1 = polling
         }
      }
