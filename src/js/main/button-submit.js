;(function (window, document, undefined) {

	'use strict';

	document.addEventListener('click', function (event) {

		// If a buy now button...
		if (event.target.classList.contains('edd-buy-now-button')) {
			event.target.innerHTML = 'Adding to cart...';
			event.target.setAttribute('disabled', 'disabled');
			return;
		}

		// If a MailChimp form...
		if (event.target.classList.contains('mailchimp-form-button')) {
			event.target.innerHTML = 'Joining...';
			event.target.setAttribute('disabled', 'disabled');
		}

	}, false);

})(window, document);