/*!
 * gomakethings v10.22.2: The WordPress theme for GoMakeThings.com
 * (c) 2016 Chris Ferdinandi
 * MIT License
 * https://github.com/cferdinandi/gomakethings
 * Open Source Credits: https://github.com/ftlabs/fastclick, https://github.com/toddmotto/fluidvids, http://prismjs.com
 */

/*!
loadCSS: load a CSS file asynchronously.
[c]2014 @scottjehl, Filament Group, Inc.
Licensed MIT
*/
function loadCSS( href, before, media ){
	"use strict";
	// Arguments explained:
	// `href` is the URL for your CSS file.
	// `before` optionally defines the element we'll use as a reference for injecting our <link>
	// By default, `before` uses the first <script> element in the page.
	// However, since the order in which stylesheets are referenced matters, you might need a more specific location in your document.
	// If so, pass a different reference element to the `before` argument and it'll insert before that instead
	// note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
	var ss = window.document.createElement( "link" );
	var ref = before || window.document.getElementsByTagName( "script" )[ 0 ];
	var sheets = window.document.styleSheets;
	ss.rel = "stylesheet";
	ss.href = href;
	// temporarily, set media to something non-matching to ensure it'll fetch without blocking render
	ss.media = "only x";
	// inject link
	ref.parentNode.insertBefore( ss, ref );
	// This function sets the link's media back to `all` so that the stylesheet applies once it loads
	// It is designed to poll until document.styleSheets includes the new sheet.
	function toggleMedia(){
		var defined;
		for( var i = 0; i < sheets.length; i++ ){
			if( sheets[ i ].href && sheets[ i ].href.indexOf( href ) > -1 ){
				defined = true;
			}
		}
		if( defined ){
			ss.media = media || "all";
		}
		else {
			setTimeout( toggleMedia );
		}
	}
	toggleMedia();
	return ss;
}
/*!
onloadCSS: adds onload support for asynchronous stylesheets loaded with loadCSS.
[c]2014 @zachleat, Filament Group, Inc.
Licensed MIT
*/
function onloadCSS( ss, callback ) {
	ss.onload = function() {
		ss.onload = null;
		if( callback ) {
			callback.call( ss );
		}
	};

	// This code is for browsers that don’t support onload, any browser that
	// supports onload should use that instead.
	// No support for onload:
	//	* Android 4.3 (Samsung Galaxy S4, Browserstack)
	//	* Android 4.2 Browser (Samsung Galaxy SIII Mini GT-I8200L)
	//	* Android 2.3 (Pantech Burst P9070)

	// Weak inference targets Android < 4.4
	if( "isApplicationInstalled" in navigator && "onloadcssdefined" in ss ) {
		ss.onloadcssdefined( callback );
	}
}
;(function (window, document, undefined) {

	'use strict';

	// SVG feature detection
	var supports = !!document.createElementNS && !!document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect;

	// If SVG is supported, add `.svg` class to <html> element
	if ( !supports ) return;
	document.documentElement.className += (document.documentElement.className ? ' ' : '') + 'svg';

})(window, document);