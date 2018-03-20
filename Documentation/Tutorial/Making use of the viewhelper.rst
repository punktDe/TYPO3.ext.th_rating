.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _tutorial-viewhelper:

Making use of the viewhelper
============================

Target group: **Administrators** and **Developers**

The easiest way to use this extension is FLUID and new viewhelper. The file
``EXT:th_rating\Resources\Examples\Templates\blog_example\Post\Index.html``
could be a good example:

In your template first propagate the new namespace:

::

   {namespace thr=Thucke\ThRating\ViewHelpers}


Next create the needed ratingobject and ratingsteps as described below.
Modify your FLUID template and include the extension viewhelper, e.g.:

::

   <f:format.raw>
      <thr:rating ratetable="tx_blogexample_domain_model_post" ratefield="uid" ratedobjectuid="{post.uid}" ></thr:rating>
   </f:format.raw>

.. important::

   CObject viewhelpers like those of Rating AX must be embedded in a ``<f:format.raw>`` viewhelper.