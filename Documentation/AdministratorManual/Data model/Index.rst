.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Documentation/Includes.txt

.. _data-model:

Data model
==========

This extension is based upon the new framework of extbase / fluid included in TYPO3 4.7 (and later)
The following graphic shows the extension model

.. figure:: /Documentation/Images/AdministratorManual/extension_model.png
   :alt: extension_model.png
   :align: left
   :width: 710

   The ER model of the extension

Reference
---------

Except the objecttype ``Tx_Extbase_Domain_Model_FrontendUser`` which is build into extbase all further objects are stored in their own tables:

.. container::

   ====================================== ======================================
   Property                               Title                                 
   ====================================== ======================================
   Tx_ThRating_Domain_Model_Ratingobject_ Root entity holds rating objects                 
   Tx_ThRating_Domain_Model_Stepconf_     Storing the step configuration
   Tx_ThRating_Domain_Model_Stepname_     Language aware names of the steps
   Tx_ThRating_Domain_Model_Rating_       Concrete instances of ratingobects
   Tx_ThRating_Domain_Model_Vote_         User votes of the rating
   Tx_ThRating_Domain_Model_Voter_        Proxy entity to frontend users
   ====================================== ======================================


Tx_ThRating_Domain_Model_Ratingobject
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Holds the basic information on anything you´d like to rate

-  ratetable: the name of the table you like to rate
-  ratefield: the fieldname within the table you like to rate
   (distiguishing fields makes it possible to configure multiple
   ratings on the same tables)
-  stepconfs: Each ratingobject must have ratingsteps configured (see
   Tx_ThRating_Domain_Model_Stepconf)
-  ratings: To do ratings on each row of a table this link is
   required (see Tx_ThRating_Domain_Model_Rating)
      
      

Tx_ThRating_Domain_Model_Stepconf
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Holds all information how to rate an object

-  ratingobject: Hold the connecting information to the parent object
   (Tx_ThRating_Domain_Model_Ratingobject)
-  steporder: ongoing sequence counting the number of ratingsteps
-  stepweight: every step could have a different weight configured
   (eg. 3 steps having the second weighted double). Normal value
   would be 1 on every step.
-  Stepname: links to the localized stepname if entered (see
   Tx_ThRating_Domain_Model_Stepname)
-  Votes: Every vote given by a frontend user is connected to its
   ratingstep (see Tx_ThRating_Domain_Model_Vote)

Tx_ThRating_Domain_Model_Stepname
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Holds localized speaking texts for stepconf entries

-  stepname: speaking text to set a name on every step. This would be
   displayed in different cases.
-  Stepconf: Hold the connecting information to the parent object
   (Tx_ThRating_Domain_Model_Stepconf)

Tx_ThRating_Domain_Model_Rating
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Holds information of every rated row of an object

-  ratingobject: Hold the connecting information to the parent object
   (Tx_ThRating_Domain_Model_Ratingobject)
-  ratedobjectuid: hold the identifier of the rated row
-  votes: Every vote given by a frontend user is connected to its
   rating (see Tx_ThRating_Domain_Model_Vote)
-  currentrates: calculated rating statistic summaries for
   performance reasons

Tx_ThRating_Domain_Model_Vote
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Holds information of every vote given by frontend users

-  vote: Each vote is linked to a ratingsteps (see
   Tx_ThRating_Domain_Model_Stepconf)
-  ratings: Each vote is linked to a rating (see
   Tx_ThRating_Domain_Model_Rating)
-  voter: Each vote is linked to a valid frontend user (see
   Tx_Extbase_Domain_Model_FrontendUser)
-  hasRated(): checks if the FE-User has already rated
-  hasAnonymousVote: checks if anonymous rating has already been done
-  isAnonymous(): checks if this is an anonymous vote

Tx_ThRating_Domain_Model_Voter
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Wrapper object for default Tx_Extbase_Domain_Model_FrontendUser