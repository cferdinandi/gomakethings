/**
 * Script initializations
 */

fluidvids.init({
	selector: ['iframe', 'object'],
	players: ['www.youtube.com', 'player.vimeo.com', 'www.slideshare.net', 'www.hulu.com', 'videopress.com/embed/']
});

if ( document.querySelector( 'a[href*="#"]' ) && !document.querySelector( '.edd_discount_link' ) ) {
	smoothScroll.init({
		selector: 'a'
	});
}