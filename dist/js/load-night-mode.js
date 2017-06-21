/*!
 * gomakethings v10.90.1: The WordPress theme for GoMakeThings.com
 * (c) 2017 Chris Ferdinandi
 * MIT License
 * https://github.com/cferdinandi/gomakethings
 * Open Source Credits: https://github.com/toddmotto/fluidvids, http://prismjs.com, https://github.com/muffinresearch/payment-icons, https://nosir.github.io/cleave.js/
 */

/**
 * Get the value of a cookie
 * https://gist.github.com/wpsmith/6cf23551dd140fb72ae7
 */
function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}
;(function (window, document, undefined) {
	'use strict';
	var nightMode = getCookie('nightMode');
	if (nightMode && nightMode === 'true') {
		document.documentElement.className += ' night-mode';
	}
})(window, document);