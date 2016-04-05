<?php

/**
 * nav-secondary.php
 * Template for the secondary site navigation.
 * http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */

?>

<?php if ( has_nav_menu( 'secondary' ) ) : ?>
	<?php wp_nav_menu(
		array(
			'theme_location' => 'secondary',
			'container'      => false,
			'menu_class'     => 'list-inline list-inline-responsive',
			'depth'          => -1,
		)
	); ?>
<?php endif; ?>