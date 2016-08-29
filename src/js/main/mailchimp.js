/**
 * Autopopulate MailChimp email field with email address from querystring
 * @version  1.0.0
 * @author   Chris Ferdinandi - https://gomakethings.com
 * @license  MIT
 */

;(function (window, document, undefined) {

	'use strict';

	// Feature test
	var supports = 'querySelector' in document;
	if ( !supports ) return;

	/**
	 * Get the value of a query string from a URL
	 * @param  {String} field The field to get the value of
	 * @param  {String} url   The URL to get the value from [optional]
	 * @return {String}       The value
	 */
	var getQueryString = function ( field, url ) {
		var href = url ? url : window.location.href;
		var reg = new RegExp( '[?&]' + field + '=([^&#]*)', 'i' );
		var string = reg.exec(href);
		return string ? string[1] : null;
	};

	// Variables
	var email = getQueryString( 'mcemail' );
	var field = document.querySelector( '#mailchimp_email' );

	// Sanity check
	if ( !email || !field ) return;

	// Add email to field
	field.value = email;

})(window, document);