<?php

########################################################################
# Extension Manager/Repository config file for ext "th_rating".
#
# Auto generated 05-02-2012 18:28
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Rating of any content object.',
	'description' => 'Inspired by the extentsion \'ratings\' and \'tt_rating\' moved to extbase/fluid. Allows multiple AJAX ratings (jQuery) within one page. Flexible usage as a cObj especially in other extensions.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.4.1',
	'dependencies' => 'extbase,fluid,t3jquery',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Thomas Hucke',
	'author_email' => 'thucke@web.de',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.4.5-0.0.0',
			'extbase' => '1.3.0',
			'fluid' => '1.3.0',
			't3jquery' => '1.8.8',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:112:{s:11:"changes.txt";s:4:"40f3";s:16:"ext_autoload.php";s:4:"ad1e";s:12:"ext_icon.gif";s:4:"de07";s:17:"ext_localconf.php";s:4:"b2bc";s:14:"ext_tables.php";s:4:"e46a";s:14:"ext_tables.sql";s:4:"8f85";s:25:"ext_tables_static+adt.sql";s:4:"baef";s:12:"t3jquery.txt";s:4:"de72";s:37:"Classes/Controller/VoteController.php";s:4:"6da7";s:31:"Classes/Domain/Model/Rating.php";s:4:"b083";s:37:"Classes/Domain/Model/Ratingobject.php";s:4:"83cd";s:33:"Classes/Domain/Model/Stepconf.php";s:4:"2231";s:29:"Classes/Domain/Model/Vote.php";s:4:"6978";s:46:"Classes/Domain/Repository/RatingRepository.php";s:4:"88b4";s:52:"Classes/Domain/Repository/RatingobjectRepository.php";s:4:"9878";s:48:"Classes/Domain/Repository/StepconfRepository.php";s:4:"fd3c";s:44:"Classes/Domain/Repository/VoteRepository.php";s:4:"b30c";s:44:"Classes/Domain/Validator/RatingValidator.php";s:4:"a291";s:50:"Classes/Domain/Validator/RatingobjectValidator.php";s:4:"0a9e";s:46:"Classes/Domain/Validator/StepconfValidator.php";s:4:"c75e";s:42:"Classes/Domain/Validator/VoteValidator.php";s:4:"0aca";s:40:"Classes/Service/AccessControlService.php";s:4:"baf2";s:35:"Classes/Service/AccessException.php";s:4:"a99e";s:40:"Classes/ViewHelpers/RatingViewHelper.php";s:4:"359c";s:44:"Classes/ViewHelpers/RatinglinkViewHelper.php";s:4:"0d8f";s:40:"Classes/ViewHelpers/SelectViewHelper.php";s:4:"7376";s:53:"Configuration/TCA/tx_thrating_domain_model_rating.php";s:4:"4ad3";s:59:"Configuration/TCA/tx_thrating_domain_model_ratingobject.php";s:4:"5bdd";s:55:"Configuration/TCA/tx_thrating_domain_model_stepconf.php";s:4:"8793";s:51:"Configuration/TCA/tx_thrating_domain_model_vote.php";s:4:"4002";s:38:"Configuration/TypoScript/constants.txt";s:4:"d7fb";s:34:"Configuration/TypoScript/setup.txt";s:4:"17a9";s:44:"Documentation/Manual/OpenOffice/en/Model.gif";s:4:"dcc0";s:45:"Documentation/Manual/OpenOffice/en/manual.sxw";s:4:"af6d";s:38:"Documentation/Model/Umlet/en/Model.uxf";s:4:"54ca";s:57:"Resources/Examples/Templates/blog_example/Post/Index.html";s:4:"41f0";s:40:"Resources/Private/Language/locallang.xml";s:4:"8ff7";s:43:"Resources/Private/Language/locallang_ff.xml";s:4:"34cd";s:44:"Resources/Private/Layouts/defaultLayout.html";s:4:"a63e";s:47:"Resources/Private/Templates/singletonInput.html";s:4:"d242";s:43:"Resources/Private/Templates/Vote/Index.html";s:4:"a1f2";s:41:"Resources/Private/Templates/Vote/New.html";s:4:"ff4c";s:49:"Resources/Private/Templates/Vote/Ratinglinks.html";s:4:"89c0";s:42:"Resources/Private/Templates/Vote/Show.html";s:4:"19cd";s:47:"Resources/Private/Templates/Vote/Singleton.html";s:4:"02af";s:61:"Resources/Public/Classes/BE.tx_thrating_unlinkDynCss_eval.php";s:4:"4fad";s:40:"Resources/Public/Classes/BE.userFunc.php";s:4:"0bc2";s:37:"Resources/Public/Css/facesbarTilt.gif";s:4:"daea";s:35:"Resources/Public/Css/rating_bar.png";s:4:"1057";s:30:"Resources/Public/Css/stars.gif";s:4:"9cdb";s:34:"Resources/Public/Css/starsTilt.gif";s:4:"9d77";s:31:"Resources/Public/Css/styles.css";s:4:"ae54";s:44:"Resources/Public/Css/Graphics/rating_bar.svg";s:4:"5ea9";s:50:"Resources/Public/Css/Graphics/rating_bar_plain.svg";s:4:"5713";s:82:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-2.png";s:4:"fe91";s:82:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-3.png";s:4:"2a69";s:82:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-4.png";s:4:"083c";s:86:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-new-5.png";s:4:"cf1a";s:91:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-new-list-3.png";s:4:"6946";s:84:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-new.png";s:4:"6fcf";s:87:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-silver.png";s:4:"ce0c";s:90:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-toolbar-2.png";s:4:"92e3";s:90:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-toolbar-3.png";s:4:"fb12";s:88:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/bookmark-toolbar.png";s:4:"65aa";s:77:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/stars.xcf";s:4:"067d";s:81:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/16x16/starsTilt.xcf";s:4:"3849";s:82:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-angry.png";s:4:"31a4";s:81:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-cool.png";s:4:"7b81";s:85:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-devilish.png";s:4:"8931";s:88:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-embarrassed.png";s:4:"9fb2";s:82:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-laugh.png";s:4:"5487";s:83:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-monkey.png";s:4:"b3d1";s:82:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-plain.png";s:4:"beb8";s:88:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-raspberry-2.png";s:4:"a692";s:82:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-sad-2.png";s:4:"f859";s:82:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-smirk.png";s:4:"a663";s:86:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-uncertain.png";s:4:"28cd";s:83:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-wink-2.png";s:4:"3916";s:81:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-wink.png";s:4:"740e";s:84:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/face-worried.png";s:4:"952d";s:84:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/facesbarTilt.xcf";s:4:"27b4";s:123:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/24x24/pictograms-road_signs-10_downward_gradient_roadsign.png";s:4:"4805";s:104:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/32x32/pictogram-din-e011-meeting_point.png";s:4:"23e4";s:98:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/32x32/pictograms-hazard_signs-29.png";s:4:"5676";s:97:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/32x32/pictographs-stairs_up_inv.png";s:4:"9855";s:110:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/32x32/road-sign-us-mutcd-w21-1a-construction.png";s:4:"fbe4";s:80:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-angry.svg";s:4:"2a3e";s:79:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-cool.svg";s:4:"c49a";s:83:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-devilish.svg";s:4:"fd03";s:86:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-embarrassed.svg";s:4:"adef";s:80:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-laugh.svg";s:4:"7486";s:81:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-monkey.svg";s:4:"ae2c";s:80:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-plain.svg";s:4:"e258";s:86:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-raspberry-2.svg";s:4:"941c";s:80:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-sad-2.svg";s:4:"22b5";s:80:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-smirk.svg";s:4:"2687";s:84:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-uncertain.svg";s:4:"de5f";s:81:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-wink-2.svg";s:4:"784e";s:82:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/face-worried.svg";s:4:"2226";s:121:"Resources/Public/Css/Graphics/openiconlibrary.sourceforge.net/svg/pictograms-road_signs-10_downward_gradient_roadsign.svg";s:4:"ed96";s:58:"Resources/Public/Icons/tx_thrating_domain_model_rating.gif";s:4:"de07";s:64:"Resources/Public/Icons/tx_thrating_domain_model_ratingobject.gif";s:4:"2c15";s:60:"Resources/Public/Icons/tx_thrating_domain_model_stepconf.gif";s:4:"ab19";s:56:"Resources/Public/Icons/tx_thrating_domain_model_vote.gif";s:4:"fe33";s:30:"Resources/Public/Js/actions.js";s:4:"d4dc";s:34:"Resources/Public/Js/jquery.form.js";s:4:"7a63";s:33:"Tests/Domain/Model/RatingTest.php";s:4:"359e";s:39:"Tests/Domain/Model/RatingobjectTest.php";s:4:"33c0";s:37:"Tests/Domain/Model/StepconfigTest.php";s:4:"a020";s:31:"Tests/Domain/Model/VoteTest.php";s:4:"bcc7";s:53:"Tests/Domain/Repository/RatingobjectRepositoryTest.ph";s:4:"2d0e";s:14:"doc/manual.sxw";s:4:"af6d";}',
	'suggests' => array(
	),
);

?>