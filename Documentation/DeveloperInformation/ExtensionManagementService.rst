.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _extensionManagementService:

ExtensionManagement Service
===========================

This service object provides developers support for generating
ratingobjects, stepconfs and localized stepnames automatically.
This could be an easy to use alternative to manually creating them via backend.

Two methods are avaiable:

- ``makeRatable``
- ``setStepname``


This section describes the mentioned methoed and tries to give you an example how to cope with them.

.. only:: html

   .. contents::
        :local:
        :depth: 2



makeRatable
-----------

This function has to be called providing three parameters:

.. code:: php

    $generatedRatingobject = $this->objectManager
                              ->get('Thucke\\ThRating\\Service\\ExtensionManagementService')
                              ->makeRatable( $tablename, $fieldname, $stepcount )


.. container::

   +------------------+--------------------------------------------------------------------------------------+-------------+
   | Parameter        | Description                                                                          | Type        |
   +==================+======================================================================================+=============+
   | ``$tablename``   | These two parameters define the basic ratingobject which should be created.          | String      |
   +------------------+                                                                                      +-------------+
   | ``$fieldname``   |                                                                                      | String      |
   +------------------+--------------------------------------------------------------------------------------+-------------+
   | ``$stepcount``   | - You must define the inital number of ratingsteps that this ratingobject would use. | Integer     |
   |                  |   The ratingsteps will all have a stepweight of ``1``.                               |             |
   |                  | - Stepnames have to be added manually via BE or by using the function setStepname_.  |             |
   |                  |                                                                                      |             |
   +------------------+--------------------------------------------------------------------------------------+-------------+

   ``[makeRatable]``




setStepname
-----------

This function has to be called giving two mandatory and two optional
parameters:

.. code:: php

    $this->objectManager
      ->get('Thucke\\ThRating\\Service\\ExtensionManagementService')
      ->setStepname( \Thucke\ThRating\Domain\Model\Stepconf $stepconf, $stepname, $languageIso2Code=0, $allStepconfs=FALSE )


The parameters specifies the new ratingstep description text:

.. container::

   +---------------------------------------------+--------------------------------------------------------+----------------------------------------+
   | Parameter                                   | Description                                            | Type                                   |
   +=============================================+========================================================+========================================+
   | :ref:`$stepconf <$stepconf>`                | The stepconf object which has to be described          | \Thucke\ThRating\Domain\Model\Stepconf |
   +---------------------------------------------+--------------------------------------------------------+----------------------------------------+
   | :ref:`$stepname <$stepname>`                | The localized description text                         | String                                 |
   +---------------------------------------------+--------------------------------------------------------+----------------------------------------+
   | :ref:`$languageIso2Code <$languageIso2Code>`| The ISO2 language code (e.g. ``43`` = German)          | Integer                                |
   +---------------------------------------------+--------------------------------------------------------+----------------------------------------+
   | :ref:`$allStepconfs <$allStepconfs>`        | Switch to initialize all stepnames with the same value | Integer                                |
   +---------------------------------------------+--------------------------------------------------------+----------------------------------------+

   ``[setStepname]``


.. _$stepconf:

Parameter $stepconf
^^^^^^^^^^^^^^^^^^^
.. container:: table-row

   Property
      $stepconf

   Data type
      ``\Thucke\ThRating\Domain\Model\Stepconf``

   Description
      The stepconf object which has to be described

   Default
      \


.. _$stepname:

Parameter $stepname
^^^^^^^^^^^^^^^^^^^
.. container:: table-row

   Property
      $stepname

   Data type
      ``String``

   Description
      The localized description text

   Default
      \


.. _$languageIso2Code:

Parameter $languageIso2Code
^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. container:: table-row

   Property
      $languageIso2Code

   Data type
      ``Integer``

   Description
      The ISO2 language code (e.g. ``43`` = German)

   Default
      ``0``


.. _$allStepconfs:

Parameter $allStepconfs
^^^^^^^^^^^^^^^^^^^^^^^
.. container:: table-row

   Property
      $stepconf

   Data type
      ``Boolean``

   Description
      Switch to initialize all stepnames with the same value.
      On ``TRUE`` all stepconfs of the ratingobject will be configured with this text.
      The steporder number will be appended to the stepname.

   Default
      ``FALSE``


.. important::

   If an entry for the stepname already exists nothing will be changed.


Example
-------

1. Create initial rating config
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Let´s try to create an initial rating configuration for the field ``Testfield`` in table ``Testtable``.
We need 4 ratingsteps even weighted.
This example assumes that we´re in an extbase controller context.
Basically it could be also a guide for "old" pi_based extensions.

.. code:: php

    //initialize ratingobject and autocreate four ratingsteps
    $ratingobject = $this->objectManager
                     ->get('Thucke\\ThRating\\Service\\ExtensionManagementService')
                     ->makeRatable('TestTabelle', 'TestField', 4);

We store the reference on the generated new ratingobject in a variable.


2. Add stepnames
^^^^^^^^^^^^^^^^

Next the rating stepnames could be added according to our extension needs.
In this example we assume any default language and an additional
website language ``German`` (``UID 43`` in the table ``static_languages``):

.. code:: php

    //add descriptions in default language to each stepconf
    $this->objectManager
      ->get('Thucke\\ThRating\\Service\\ExtensionManagementService')
      ->setStepname($ratingobject->getStepconfs()->current(), 'Automatic generated entry ', 0, TRUE);

    //add descriptions in german language to each stepconf
    $this->objectManager
      ->get('Thucke\\ThRating\\Service\\ExtensionManagementService')
      ->setStepname($ratingobject->getStepconfs()->current(), 'Automatischer Eintrag ', 43, TRUE);


Among others the table ``static_languages`` will be installed by the extension `static_info_tables`_
Find the row of the language you need and write down the value of ``UID`` - which is ``43`` for German.
If we like to add other languages to our stepconfs we just have to find out the correct language ISO2 code
e.g. by checking the table ``static_languages``.

You may also use

.. code:: php

   \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate

for fetching the concrete text.
Then it is recommended that all possible language entries for the stepnames have to reside
in the default language XLF of your extension.

The following example assumes that the file ``locallang.xlf`` of the extension ``MyExtenion``
stores its text in ``rating.<ratingfield>.stepconf.step<steporder>.<ISO2Code>``:

.. code:: php

    //add descriptions in default language to each stepconf
    $this->objectManager->get('Thucke\\ThRating\\Service\\ExtensionManagementService')->setStepname($ratingobject->getStepconfs()->current(),
       \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('rating.testfield.stepconf.step1.30', 'MyExtension'), 0, TRUE);
    //add descriptions in german language to each stepconf
    $this->objectManager->get('Thucke\\ThRating\\Service\\ExtensionManagementService')->setStepname($ratingobject->getStepconfs()->current(),
       \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('rating.testfield.stepconf.step1.43', 'MyExtension'), 43, TRUE);



.. _static_info_tables: https://extensions.typo3.org/extension/static_info_tables/