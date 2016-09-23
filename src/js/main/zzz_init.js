/**
 * Script initializations
 */

fluidvids.init({
	selector: ['iframe', 'object'],
	players: ['www.youtube.com', 'player.vimeo.com', 'www.slideshare.net', 'www.hulu.com']
});

if ( document.querySelector( 'a[href*="#"]' ) ) {
	smoothScroll.init({
		selector: 'a'
	});
}