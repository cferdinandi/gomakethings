;(function (window, document, undefined) {
	'use strict';
	var nightMode = getCookie('nightMode');
	if (nightMode && nightMode === 'true') {
		document.documentElement.className += ' night-mode';
	}
})(window, document);