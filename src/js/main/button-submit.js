;(function (window, document, undefined) {

	'use strict';

	document.addEventListener('click', function (event) {

		// If a buy now button...
		if (event.target.classList.contains('edd-buy-now-button')) {
			event.target.innerHTML = 'Adding to cart...';
			event.target.classList.add('disabled');
			return;
		}

		// If a MailChimp form...
		if (event.target.classList.contains('mailchimp-form-button')) {
			if (event.target.form.querySelector('#mailchimp_email').value.length < 1) return;
			event.target.innerHTML = 'Joining...';
			event.target.classList.add('disabled');
		}

	}, false);

})(window, document);