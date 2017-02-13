(function (root, factory) {
	if ( typeof define === 'function' && define.amd ) {
		define([], factory(root));
	} else if ( typeof exports === 'object' ) {
		module.exports = factory(root);
	} else {
		root.tableOfContents = factory(root);
	}
})(typeof global !== 'undefined' ? global : this.window || this.global, function (root) {

	'use strict';

	//
	// Variables
	//

	var tableOfContents = {}; // Object for public APIs
	var supports = 'querySelector' in document; // Feature test
	var settings, toc, headings;

	// Default settings
	var defaults = {
		selector: '[data-toc]',
		headings: 'h2',
		before: '',
		after: '',
		initClass: 'js-toc',
		tocClass: 'table-of-contents',
		link: true,
		linkIcon: '#',
		linkClass: 'table-of-contents-link',
		callback: function () {}
	};


	//
	// Methods
	//

	/**
	 * Merge defaults with user options
	 * @private
	 * @param {Object} defaults Default settings
	 * @param {Object} options User options
	 * @returns {Object} Merged values of defaults and options
	 */
	var extend = function () {

		// Variables
		var extended = {};
		var deep = false;
		var i = 0;
		var length = arguments.length;

		// Check if a deep merge
		if ( Object.prototype.toString.call( arguments[0] ) === '[object Boolean]' ) {
			deep = arguments[0];
			i++;
		}

		// Merge the object into the extended object
		var merge = function (obj) {
			for ( var prop in obj ) {
				if ( Object.prototype.hasOwnProperty.call( obj, prop ) ) {
					// If deep merge and property is an object, merge properties
					if ( deep && Object.prototype.toString.call(obj[prop]) === '[object Object]' ) {
						extended[prop] = extend( true, extended[prop], obj[prop] );
					} else {
						extended[prop] = obj[prop];
					}
				}
			}
		};

		// Loop through each object and conduct a merge
		for ( ; i < length; i++ ) {
			var obj = arguments[i];
			merge(obj);
		}

		return extended;

	};

	/**
	 * Create table of contents
	 */
	var createTOC = function () {
		var nav = '';
		for ( var i = 0; i < headings.length; i++ ) {
			nav += '<li><a href="#' + headings[i].id + '">' + headings[i].innerHTML + '</a></li>';
			if ( settings.link ) {
				headings[i].innerHTML += ' <a class="' + settings.linkClass + '" href="#' + headings[i].id + '">' + settings.linkIcon + '</a>';
			}
		}
		toc.innerHTML = settings.before + '<ul class="' + settings.tocClass + '">' + nav + '</ul>' + settings.after;
	};

	/**
	 * Initialize Houdini
	 * @public
	 * @param {Object} options User settings
	 */
	tableOfContents.init = function ( options ) {

		// feature test
		if ( !supports ) return;

		// Merge user options with defaults
		settings = extend( defaults, options || {} );

		// Get table of contents and headings
		toc = document.querySelector( settings.selector );
		headings = document.querySelectorAll( settings.headings );

		console.log(toc);
		console.log(headings);

		// Make sure TOC and headings exist
		if ( !toc || headings.length < 1 ) return;

		// Create Table of Contents
		createTOC();

	};


	//
	// Public APIs
	//

	return tableOfContents;

});