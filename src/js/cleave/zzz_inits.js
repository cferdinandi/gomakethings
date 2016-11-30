;(function (window, document, undefined) {

	'use strict';

	// Feature test
	var supports = 'querySelector' in document;
	if ( !supports ) return;

	// Variables
	var cards = document.querySelectorAll( '.edd-payment-icons .icon' );

	var updateCard = function (type) {
		for (var i = 0; i < cards.length; i++) {
			if ( cards[i].id === 'icon-' + type ) {
				cards[i].classList.add( 'active' );
				continue;
			}
			cards[i].classList.remove( 'active' );
		}
	};

	new Cleave('#card_number', {
		creditCard: true,
		onCreditCardTypeChanged: function (type) {
			updateCard( type );
		}
	});

})(window, document);