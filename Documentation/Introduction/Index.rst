
.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _introduction:

Introduction
============

.. _what-it-does:

What does it do?
----------------

This extension provides a rating plugin for every type of content in the
database. Every field of every table can be defined as a so-called
'ratingobject' that can be used for ratings. The extension could be
included as a normal content plugin to have ratings of the content page.
Nevertheless the best usecase is to integrate it as a cObj in your own
extension. This extension features the future oriented extensions
extbase and fluid. It is expected to adopt it in a easy way to new
versions of TYPO3. It is inspired by the extension 'ratings' from Dmitry
Dulepov and the incredible tutorial about CSS star rating technique from
"Komodomedia":http://www.komodomedia.com/blog/2007/01/css-star-rating-redux/

.. _featurelist:

Featurelist
-----------

-  display ratings (graphically or text)
-  support for AJAX-ratings (graphically or text)
-  one-time voting for logged in FE users
-  multiple anonymous votings
-  highly customizable look for ratings, incl. support for vertical
   ratings
-  different weight for each rating step
-  full localization support for ratingnames (>0.5.1)
-  includes viewhelper for FLUID templates
-  polling mode (>0.10.1)

.. _screenshots:

Screenshots
-----------

The following screenshots may give you a short glimpse on how the extension
will be visible on the screen as per default. You may adjust everthing as
you like.

+------------+------------+
+------------+------------+
| |example1| | |example2| |
+------------+------------+
+------------+------------+
| |example3| | |example4| |
+------------+------------+
+------------+------------+
| |example5| | |example6| |
+------------+------------+
+------------+------------+
| |example7| | |example8| |
+------------+------------+
+------------+------------+
| |example9| |            |
+------------+------------+


.. ==================================================
.. Image definitions
.. --------------------------------------------------

.. |example1| image:: ../Tutorial/Images/Th_rating_example1.png
   :alt: Example 1 - classic starrating
   :align: top

.. |example2| image:: ../Tutorial/Images/Th_rating_example2.png
   :alt: Example 2 - barrating
   :align: top

.. |example3| image:: ../Tutorial/Images/Th_rating_example3.png
   :alt: Example 3 - vertical classic starrating
   :align: top

.. |example4| image:: ../Tutorial/Images/Th_rating_example4.png
   :alt: Example 4 - current rating (text)
   :align: top
   :width: 350

.. |example5| image:: ../Tutorial/Images/Th_rating_example5.png
   :alt: Example 5 - current rating (classic starrating)
   :align: top
   :width: 350

.. |example6| image:: ../Tutorial/Images/Th_rating_example6.png
   :alt: Example 6 - vote form
   :align: top
   :width: 350

.. |example7| image:: ../Tutorial/Images/Th_rating_example7.png
   :alt: Example 7 - vertical rating
   :align: top

.. |example8| image:: ../Tutorial/Images/Th_rating_example8.png
   :alt: Example 8 - polling mode
   :align: top

.. |example9| image:: ../Tutorial/Images/Th_rating_example9.gif
   :alt: Example 8 - polling mode
   :align: top
