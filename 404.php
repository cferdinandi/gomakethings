<?php

/**
 * 404.php
 * Template for 404 error page.
 */

get_header(); ?>


<article>
	<header>
		<h1><?php _e( 'Oh snap!', 'keel' ) ?></h1>
	</header>

	<p><?php _e( 'The page you\'re looking for was looted by pirates! (Or more likely, I messed up and moved something on you&mdash;sorry.) At this point, you have a few options:', 'keel' ) ?></p>

	<ol>
		<li><?php _e( 'Try searching for it.', 'keel' ) ?></li>
		<li><?php _e( 'Become a pirate hunter and embark on a quest to reclaim the lost page.', 'keel' ) ?></li>
		<li><?php _e( 'Give up and go make something awesome instead.', 'keel' ) ?></li>
	</ol>

	<?php
		// Insert the search form
		get_search_form();
	?>

</article>


<?php get_footer(); ?>