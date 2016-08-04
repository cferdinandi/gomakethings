;(function (window, document, undefined) {

	'use strict';

	// Feature Test
	var supports = 'querySelector' in document && 'addEventListener' in window && 'localStorage' in window && 'classList' in document.createElement('_'); // Feature test
	if ( !supports ) return;

	// // Variables
	// var link = document.querySelector( '.edd-cancel a' );
	// var cancel = sessionStorage.getItem( 'eddCancelLocation' );

	// /**
	//  * Handle click events
	//  */
	// var clickHandler = function (event) {
	// 	var toggle = event.target;
	// 	if ( toggle.classList.contains( 'edd-add-to-cart' ) || toggle.classList.contains( 'edd_go_to_checkout' ) ) {
	// 		sessionStorage.setItem( 'eddCancelLocation', window.location.href );
	// 	}
	// };

	// // Add class to HTML element to activate conditional CSS
	// document.documentElement.className += ' js-edd';

	// // If location set, show cancel link
	// if ( link && cancel ) {
	// 	link.href = cancel;
	// 	document.documentElement.className += ' js-edd-cancel';
	// }

	// // Listen for click events
	// document.addEventListener('click', clickHandler, false);

	// Variables
	var link = document.querySelector( '.edd-cancel a' );

	// If location set, show cancel link
	if ( link ) {
		link.href = window.location.origin + window.location.pathname;
		document.documentElement.className += ' js-edd-cancel';
	}

})(window, document);