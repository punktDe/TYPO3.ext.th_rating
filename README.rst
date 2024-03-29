.. ==================================================
.. Image definitions
.. --------------------------------------------------

.. |phpstorm.png| image:: Documentation/Images/phpstorm100.png
   :target: https://www.jetbrains.com/?from=RatingAXTYPO3extension
   :alt: Jetbrains PHPStorm IDE
   :align: top

.. |Latest Stable Version| image:: https://img.shields.io/packagist/v/thucke/th-rating.svg
   :target: https://packagist.org/packages/thucke/th-rating
   :alt: Latest stable version

.. |License| image:: https://img.shields.io/packagist/l/thucke/th-rating.svg
   :target: https://packagist.org/packages/thucke/th-rating
   :alt: Licence

.. |Downloads| image:: https://img.shields.io/packagist/dt/thucke/th-rating
   :target: https://packagist.org/packages/thucke/th-rating
   :alt: Packagist downloads

.. |PHP| image:: https://img.shields.io/packagist/php-v/thucke/th-rating.svg
   :target: https://packagist.org/packages/thucke/th-rating
   :alt: PHP version

.. |Issues| image:: https://img.shields.io/github/issues/thucke/TYPO3.ext.th_rating
   :target: https://github.com/thucke/TYPO3.ext.th_rating/issues
   :alt: Number of open issues

.. |New commits| image:: https://img.shields.io/github/commits-since/thucke/th_rating/latest
   :target: https://github.com/thucke/TYPO3.ext.th_rating/releases
   :alt: GitHub commits since latest release

.. |Crowdin| image:: https://badges.crowdin.net/typo3-extension-thrating/localized.svg
   :target: https://crowdin.com/project/typo3-extension-thrating
   :alt: Crowdin translation status


.. _readme:

\|
`Contributing <CONTRIBUTING.rst>`__  \|

=============================
Rating AX (maintainer wanted)
=============================

|Latest Stable Version| |License| |Downloads| |PHP| |Issues| |New commits| |Crowdin|

Guide to the TYPO3 extension to make ratings of any content object.

:Repository:  https://github.com/thucke/TYPO3.ext.th_rating
:Read online: https://docs.typo3.org/p/thucke/th-rating/master/en-us/

Maintainer needed
=================
Due to personal reasons I cannot provide support for this extension anymore.
If one would feel to take over the responsibility I'll be exited to transfer the extension to him. 
He may still contact me to answer questions etc.


Support welcome
===============
Please support this extension by doing some translations.

Just check `Crowdin <https://crowdin.com/project/typo3-extension-thrating>`__ if you're interested.
If it happens that your favorite language is missing, please don't hesitate to contact the extension author
asking to activate it.

Important updates
=================
As of version 1.8.0 the extension uses the SiteLanguage-API for localization.
Therefore it is required that administrators do configure their site languages via "Site Management" in the backend.
Because of that the following is not needed anymore:

* old typoscript configuration of language definitions
* dependency to the extension "static_info_tables"
* website language system records

Version 1.9.0 dropped support for PHP 7.2

|phpstorm.png|

This extension is supported by Jetbrains PHPStorm IDE.
