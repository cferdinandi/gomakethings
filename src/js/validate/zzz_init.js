/**
 * Script initializations
 */

;(function (window, document, undefined) {

	'use strict';

	var requiredFields = document.querySelectorAll('#edd_purchase_form .required');
	var eddCompletePurchase = document.querySelector('#edd-purchase-button');

	for (var i = 0; i < requiredFields.length; i++) {
		requiredFields[i].setAttribute('required', 'required');
		if (requiredFields[i].id === 'edd-email') {
			requiredFields[i].setAttribute('title', 'The domain portion of the email address is invalid (the portion after the @).');
			requiredFields[i].setAttribute('pattern', '^([^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+|\\x22([^\\x0d\\x22\\x5c\\x80-\\xff]|\\x5c[\\x00-\\x7f])*\\x22)(\\x2e([^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+|\\x22([^\\x0d\\x22\\x5c\\x80-\\xff]|\\x5c[\\x00-\\x7f])*\\x22))*\\x40([^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+|\\x5b([^\\x0d\\x5b-\\x5d\\x80-\\xff]|\\x5c[\\x00-\\x7f])*\\x5d)(\\x2e([^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+|\\x5b([^\\x0d\\x5b-\\x5d\\x80-\\xff]|\\x5c[\\x00-\\x7f])*\\x5d))*(\\.\\w{2,})+$');
			continue;
		}
		if (requiredFields[i].id === 'card_number') {
			requiredFields[i].setAttribute('title', 'Please use a valid credit card number.');
			requiredFields[i].setAttribute('pattern', requiredFields[i].getAttribute('pattern').replace('[0-9', '[0-9 ').replace('{13,16}', '{13,19}'));
		}
		if (requiredFields[i].id === 'card_cvc') {
			requiredFields[i].setAttribute('title', 'Please enter a valid security code.');
		}
	}

	// Handle EDD "complete purchase" submissions
	var completePurchaseHandler = function (event) {

		// Get all of the form elements
		var fields = event.target.form.elements;

		// Validate each field
		// Store the first field with an error to a variable so we can bring it into focus later
		var hasErrors;
		for (var i = 0; i < fields.length; i++) {
			var error = validate.hasError(fields[i]);
			if (error) {
				validate.showError(fields[i], error);
				if (!hasErrors) {
					hasErrors = fields[i];
				}
			}
		}

		// Prevent form from submitting if there are errors or submission is disabled
		if (hasErrors) {
			event.preventDefault();
			event.stopPropagation();
		}

		// If there are errrors, focus on first element with error
		if (hasErrors) {
			hasErrors.focus();
			return;
		}

		// Otherwise, submit the form
		event.target.value = 'Processing...';
	};

	if (eddCompletePurchase) {
		eddCompletePurchase.addEventListener('click', completePurchaseHandler, false);
	}

})(window, document);

validate.init({
	selector: '#edd_purchase_form, .mailchimp-form',
	fieldClass: 'error-field',
	onSubmit: function (form) {
		var submit = form.querySelector('.mailchimp-form-button');
		if (!submit) return;
		submit.innerHTML = 'Joining...';
		submit.classList.add('disabled');
	}
});