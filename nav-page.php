<?php

/**
 * nav-page.php
 * Template for older/newer post navigation.
 */

?>

<?php
	// If page is one of several, include navigation
	if ( keel_is_paginated() ) :
?>
	<nav class="text-center">
		<p class="padding-top-large margin-bottom-small"><?php posts_nav_link( ' / ', '&larr; ' . __( 'Newer', 'keel' ), __( 'Older', 'keel' ) . ' &rarr;' ); ?></p>
	</nav>
<?php endif; ?>