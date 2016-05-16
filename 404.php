<?php

/**
 * 404.php
 * Template for 404 error page.
 */

get_header(); ?>

<?php
	// Get the theme options
	$options = keel_get_theme_options();
?>

<article>
	<header>
		<h1><?php echo esc_html( $options['404_heading'] ); ?></h1>
	</header>

	<?php echo stripslashes( do_shortcode( wpautop( $options['404_content'], false ) ) ); ?>

	<?php
		// Insert the search form
		if ( $options['404_show_search'] === 'on' ) {
			get_search_form();
		}
	?>

</article>


<?php get_footer(); ?>