/*!
 * Javascript Library for TYPO3 extension th_rating
 * version: 1.05 (21-Sep-2015)
 * @requires jQuery v1.5 or later
 * @requires jQuery Form Plugin 2.47 or later
 *
 *  Copyright notice
*
*  (c) 2015 Thomas Hucke <thucke@web.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

// noinspection JSUnusedGlobalSymbols
const constRatingFadeOut = 400;
// noinspection JSUnusedGlobalSymbols
const constRatingFadein = 300;
const constDelayFlashMessage = 0;
const constFlashMessageFadein = 200;
const constFlashMessageDuration = 1500;
const constFlashMessageFadeout = 500;

/**
 * Constructor
 */
jQuery(document).ready(function() {
	initBinding();
	jQuery('.currentPollText').each(function(){
		adjustHeights(jQuery(this));
	});
	jQuery('#vote').ajaxForm({
		type:			'post',
		dataType:  		'json', //expect JSON formatted response
		beforeSubmit:  	checkVoteSubmission,  // pre-submit callback
		success:		handleReceivedVote  // post-submit callback
	});
	jQuery('.tx-thrating-flash-message').each(fadeFlashMessage);
});


/**
 * Initialize all event listeners
 */
function initBinding() {
	//clear existing events and re-create them later
	jQuery('span.ajaxLink').off('click');
	jQuery('select.ajaxLink').off('change');

	jQuery('span.ajaxLink').hover( function() {  { switchStepname(this,true); } }, function() {  { switchStepname(this,false); } });
	jQuery('span.ajaxLink').one('click', function() {
		submitVoteForm(jQuery.parseJSON(jQuery('input:first',this).val()));
		return false;
	});

	//handle all changes of selection inputs
	jQuery('select.ajaxLink').attr("disabled", false);
	jQuery('select.ajaxLink').one('change', function() {
		//value is like '{"value":2,"voter":1,"rating":2,"ajaxRef":3599914}'
		submitVoteForm(jQuery.parseJSON(this.value));
		return false;
	});
}

/**
 * Form submission
 *
 * ... being called by multiple event handlers
 */
function submitVoteForm( choosenValue ) {
		let targetObj = document.getElementById(choosenValue.ajaxRef);
		jQuery(targetObj).addClass("loading");
		jQuery("select",targetObj).prop('disabled','disabled');
		let targetFormElements = document.forms["vote"].elements;
		targetFormElements["tx_thrating_pi1[__referrer][@action]"].value = choosenValue.actionName;
		targetFormElements["tx_thrating_pi1[vote][vote]"].value = choosenValue.value;
		targetFormElements["tx_thrating_pi1[vote][voter]"].value = choosenValue.voter;
		targetFormElements["tx_thrating_pi1[vote][rating]"].value = choosenValue.rating;
		targetFormElements["tx_thrating_pi1[settings]"].value = choosenValue.settings;
		targetFormElements["tx_thrating_pi1[ajaxRef]"].value = choosenValue.ajaxRef;
		jQuery('#vote').submit();
}

/**
 * jQuery pre-submit callback
 */
// noinspection JSUnusedLocalSymbols
function checkVoteSubmission(formData, jqForm, options) {
	for (let i = 0; i < formData.length; ++i) {
		if (formData[i]["name"] == "tx_thrating_pi1[vote][vote]" && formData[i]["value"] == 0) {
			//alert("Choose a valid rating");
			initBinding();
			// return false to prevent the form from being submitted;
			return false;
		}
		if (formData[i]["name"] == "tx_thrating_pi1[ajaxRef]") {
      // noinspection JSUnusedLocalSymbols
      let ajaxTargetId = formData[i]["value"];
    }
	}
	return true;
}

/**
 * jQuery post-submit callback
 *
 * The returned content will only be replaced if voteform or ratinglink is returned.
 * Possibly returned flash messages are copied into the right content element DIV.
 */
function handleReceivedVote(jsonData)  {
  let ajaxTargetId = jsonData.ajaxRef;
  let targetObj = document.getElementById(ajaxTargetId); //find target object in DOM
  let flashMessages = jsonData.flashMessages; //save flash-messages

    jQuery(targetObj).removeClass("loading");
	jQuery('*[data-role="onCurrentRateActive"]',targetObj).show();					//unhide element
	jQuery('*[data-role="onCurrentRateHidden"]',targetObj).hide();					//hide element

	//hide/unhide blocks based upon the value of jsonData.voting
	if (jsonData.voting) {
		jQuery('*[data-role="onVotingActive"]',targetObj).show();					//unhide element
		jQuery('*[data-role="onVotingHidden"]',targetObj).hide();					//hide element
		if (jsonData.protected) {
		  jQuery('*[data-role="onRatedHidden"]',targetObj).hide()
    }
		try {
			jQuery('.tx_thrating_ajax-votingStepname',targetObj).html(jsonData.voting.vote.stepname.stepname);
		} catch (e) { //show steporder if not name is given
			jQuery('.tx_thrating_ajax-votingStepname',targetObj).html(jsonData.voting.vote.steporder);
		}
		jQuery('.tx_thrating_ajax-votingVoteSteporder',targetObj).html(jsonData.voting.vote.steporder);
	} else {
		jQuery('*[data-role="onVotingActive"]',targetObj).hide();
		jQuery('*[data-role="onVotingHidden"]',targetObj).show();
	}

	//hide/unhide blockes based upon the value of jsonData.voting
	if (jsonData.anonymousVoting) {
		jQuery('*[data-role="onAnonymousVotingActive"]',targetObj).show();
	} else {
		jQuery('*[data-role="onAnonymousVotingActive"]',targetObj).hide();
	}

	jQuery('.tx-thrating-preContent',targetObj).html(jsonData.preContent);
	jQuery('.tx-thrating-postContent',targetObj).html(jsonData.postContent);
	jQuery('.tx_thrating_ajax-voterUsername',targetObj).html(jsonData.voter.username);
	jQuery('.tx_thrating_ajax-voterFirstName',targetObj).html(jsonData.voter.firstname);
	jQuery('.tx_thrating_ajax-voterLastName',targetObj).html(jsonData.voter.lastname);
	jQuery('.tx_thrating_ajax-ratingRatingobjectRatetable',targetObj).html(jsonData.rating.ratingobject.ratetable);
	jQuery('.tx_thrating_ajax-ratingRatingobjectRatefield',targetObj).html(jsonData.rating.ratingobject.ratefield);
	jQuery('.tx_thrating_ajax-ratingRatedobjectuid',targetObj).html(jsonData.rating.ratingobjectuid);
	jQuery('.tx_thrating_ajax-ratingCurrentratesCurrentrate',targetObj).html((jsonData.rating.currentrates.currentrate).toFixed(1)); //truncate number to one digit
	jQuery('.tx_thrating_ajax-ratingCurrentratesNumAllVotes',targetObj).html(jsonData.rating.currentrates.numAllVotes);
	jQuery('.tx_thrating_ajax-ratingCurrentratesAnonymousVotes',targetObj).html(jsonData.rating.currentrates.anonymousVotes);
	jQuery('.tx_thrating_ajax-ratingCalculatedRateHeight',targetObj).css('height', jsonData.rating.calculatedRate + '%');
	jQuery('.tx_thrating_ajax-ratingCalculatedRateWidth',targetObj).css('width', jsonData.rating.calculatedRate + '%');
	jQuery('.tx_thrating_ajax-stepCount',targetObj).html(jsonData.stepCount);
	jQuery('.tx_thrating_ajax-usersRateHeight',targetObj).css('height', jsonData.usersRate);
	jQuery('.tx_thrating_ajax-usersRateWidth',targetObj).css('width', jsonData.usersRate);

	if (jsonData.currentPollDimensions) {
		//set new values in polling graphic
		jQuery.each(jsonData.currentPollDimensions, function ( step, currentPollDimension) {
			jQuery('.currentPollText.' + currentPollDimension.steporder,targetObj).html(currentPollDimension.pctValue + '%');
			jQuery('.current-poll.' + currentPollDimension.steporder + '.tx-thrating-currentPollHeight',targetObj).css({
																					'height': currentPollDimension.pctValue + '%',
																					'background-position': '0px ' + currentPollDimension.backgroundPos + 'px'
																					});

			jQuery('.current-poll.' + currentPollDimension.steporder + '.tx-thrating-currentPollWidth',targetObj).css({
																					'width': currentPollDimension.pctValue + '%',
																					'background-position': '0px ' + currentPollDimension.backgroundPos + 'px'
																					});
		});
	}

	jQuery('.tx-thrating-flash-message',targetObj)
		.delay(constDelayFlashMessage)
		.html(flashMessages)				//replace flashMessages
		.each(fadeFlashMessage);

	jQuery('span.dummy4focus',targetObj).focus(); // remove focus from ratinglinks
	jQuery('.ajaxLink',targetObj).prop('selectedIndex',0); //reset selection box
	initBinding();
}

/**
 * FlashMessages Fadein / Fadeout
 */
function fadeFlashMessage() {
	if ( jQuery.trim(jQuery(this).html()).length ) {	//Anzeige des DIV nur wenn Inhalt vorhanden
		jQuery(this).fadeTo(constFlashMessageFadein,0.9,function() {
			jQuery(this)
				.delay(constFlashMessageDuration)
				.fadeOut(constFlashMessageFadeout)
		});
	}
}

/**
 * Switch stepname visibility
 */
function switchStepname( linkObj, hoverIn ) {
	stepname = jQuery(linkObj).attr('title');
	if ( hoverIn ) {
		const stepnameObj = jQuery(linkObj).parents('div.tx-thrating-ratinglinks').children('div.stepnameTooltip').first();
		jQuery(stepnameObj).html(stepname).addClass('stepnameTooltipOn').removeClass('stepnameTooltip');
	} else {
		const stepnameObj = jQuery(linkObj).parents('div.tx-thrating-ratinglinks').children('div.stepnameTooltipOn').first();
		jQuery(stepnameObj).html('&nbsp;').removeClass('stepnameTooltipOn').addClass('stepnameTooltip');
	}
}


/**
 * Adjust font size to fit in polling bars
 */
function adjustHeights(currElem) {
	let fontstep = 1;
	if (jQuery(currElem).height()>jQuery(currElem).parent().height() || jQuery(currElem).width()>jQuery(currElem).parent().width()) {
		jQuery('.currentPollText').css('font-size',(jQuery(currElem).css('font-size').substr(0,2)-fontstep) + 'px');
		adjustHeights(jQuery(currElem));
	}
}
