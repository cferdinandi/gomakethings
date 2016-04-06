<?php

/**
 * nav-accessibility.php
 * Template for accessibility improvements to the navigation.
 */

?>

<div class="container container-large">

	<!-- Skip nav link for better a11y -->
	<a class="screen-reader screen-reader-focusable" href="#main"><?php _e( 'Skip to main content', 'keel' ); ?></a>

	<!-- Skip to secondary nav -->
	<a class="screen-reader screen-reader-focusable" href="#nav-secondary"><?php _e( 'Skip to secondary navigation', 'keel' ); ?></a>

	<!-- a11y feedback -->
	<a class="screen-reader screen-reader-focusable" href="mailto:<?php echo antispambot( get_option( 'admin_email' ) ); ?>?subject=Go%20Make%20Things:%20Accessibility%20Feedback"><?php _e( 'Accessibility Feedback', 'keel' ); ?></a>

</div>