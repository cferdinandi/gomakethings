;(function (window, document, undefined) {

	'use strict';

	// Variables
	var buyNow = document.querySelectorAll('.edd-buy-now-button');
	var mailchimp = document.querySelectorAll('.mailchimp-form');

	// Handle "buy now" clicks
	var buyNowHandler = function (event) {
		if (!event.target.classList.contains('edd-buy-now-button')) return;
		event.target.innerHTML = 'Adding to cart...';
		event.target.classList.add('disabled');
	};

	// Add novalidate to mailchimp forms
	var mailchimpNoValidate = function () {
		for (var i = 0; i < mailchimp.length; i++) {
			mailchimp[i].setAttribute('novalidate', true);
		}
	};

	// Add errors to the DOM
	var mailchimpGetError = function (email, message) {

		if (/^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*(\.\w{2,})+$/.test(email.value)) return null;

		if (!message) {
			message = document.createElement('div');
			message.className = 'error-message';
			message.id = 'for_mailchimp_email';
			email.parentNode.insertBefore(message, email.nextSibling);
			email.setAttribute('aria-describedby', 'for_mailchimp_email');
		}

		email.classList.add('error-field');
		message.innerHTML = 'Please use a valid email address.';
		email.focus();
		return message;

	};

	// Handle MailChimp form submissions
	var mailchimpHandler = function (event) {

		if (!event.target.classList.contains('mailchimp-form')) return;

		var email = event.target.querySelector('#mailchimp_email');
		var submit = event.target.querySelector('.mailchimp-form-button');
		if (!email || !submit) return;

		var message = event.target.querySelector('.error-message');
		var error = mailchimpGetError(email, message);
		if (error) {
			event.preventDefault();
			return;
		}

		email.classList.remove('error-field');
		if (message) {
			message.style.display = 'none';
			message.style.visibility = 'hidden';
		}

		submit.innerHTML = 'Joining...';
		submit.classList.add('disabled');

	};

	// Listen for "buy now" clicks
	if (buyNow.length > 0) {
		document.addEventListener('click', buyNowHandler, false);
	}

	// Listen for MailChimp submits
	if (mailchimp.length > 0) {
		mailchimpNoValidate();
		document.addEventListener('submit', mailchimpHandler, false);
	}

})(window, document);