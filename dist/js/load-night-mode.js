/*!
 * gomakethings v10.99.0: The WordPress theme for GoMakeThings.com
 * (c) 2017 Chris Ferdinandi
 * MIT License
 * https://github.com/cferdinandi/gomakethings
 * Open Source Credits: https://github.com/toddmotto/fluidvids, http://prismjs.com, https://github.com/muffinresearch/payment-icons, https://nosir.github.io/cleave.js/
 */

;(function (window, document, undefined) {
	'use strict';
	if (!('localStorage' in window)) return;
	var nightMode = localStorage.getItem('gmtNightMode');
	if (nightMode) {
		document.documentElement.className += ' night-mode';
	}
})(window, document);