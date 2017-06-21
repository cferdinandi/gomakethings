;(function (window, document, undefined) {

	'use strict';

	// Get the navigation menu
	var nav = document.querySelector('#menu-primary');
	if (!nav) return;

	// Insert the night mode toggle
	nav.innerHTML += '<li id="night-mode"><a role="button" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 16 16"><title>moon</title><path d="M11.185 1.008A8.014 8.014 0 0 0 8.223 0 8.035 8.035 0 0 1 .798 12.861a8.033 8.033 0 0 0 13.328-.88 8.034 8.034 0 0 0-2.94-10.974z"/></svg><span class="icon-fallback-text">Night Mode</span></a></li>';

	// Get our newly insert toggle
	var nightMode = document.querySelector('#night-mode');
	if (!nightMode) return;

	// When clicked, toggle night mode on or off
	nightMode.addEventListener('click', function () {
		document.documentElement.classList.toggle('night-mode');
		var expires = document.documentElement.classList.contains('night-mode') ? new Date(+new Date() + (7 * 24 * 60 * 60 * 1000)).toUTCString() : 'Thu, 01 Jan 1970 00:00:00 GMT';
		document.cookie = 'nightMode=true; expires=' + expires;
	}, false);

})(window, document);