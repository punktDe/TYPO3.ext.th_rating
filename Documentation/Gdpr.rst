.. include:: Includes.txt

==========
GDPR Hints
==========

If cookies are activated using either one of both options (value unequal zero)

* Constant :ref:`constCookieLifetime`
* Typoscript :ref:`tsCookieLifetime`

the extension generates cookies for each anonymous rating.

Cookiename: ``tx_thrating_pi1_AnonymousRating_<xx>``

.. container::

   ================ ======================================================================
   Name             Description
   ================ ======================================================================
   ``ratingtime``   Timestamp when the anonymous rating has be done
   ``voteUid``      Primary key value (integer) the vote is identified in the database
   ================ ======================================================================
