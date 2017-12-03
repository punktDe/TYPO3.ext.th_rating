<?php
call_user_func(function() {
		
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('th_rating', 'Configuration/TypoScript', 'Rating AX');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_thrating_domain_model_ratingobject');
});
?>