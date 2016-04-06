<?php

/**
 * nav-main.php
 * Template for site navigation.
 * You may wish to use `wp_nav_menu()` here, or alternatively, hand-code your navigation.
 * http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */

?>


<?php
	// Get hero (if one exists)
	global $post;
	$hero = get_post_meta( $post->ID, 'keel_page_hero', true );
?>

<header class="container container-large <?php if ( empty( $hero ) ) { echo 'margin-bottom-large'; } else { echo 'margin-bottom-small'; } ?>">
	<nav class="nav-wrap">
		<a class="logo" href="<?php echo site_url(); ?>/">
			<svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 32 32"><path d="M28 18v4.13c-2.516 2.57-6.032 5.053-10 5.704V16h6v-2l-6-2.343c2.33-.824 4-3.046 4-5.658 0-3.315-2.686-6-6-6s-6 2.685-6 6c0 2.61 1.67 4.833 4 5.657L8 14v2h6v11.833C10.032 27.18 6.516 24.7 4 22.13V18H0v2c0 4 8 12 16 12s16-8 16-12v-2h-4zM18 6c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2z"/></svg>
			<?php echo get_bloginfo( 'name' ); ?>
		</a>
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<div class="nav-menu" id="nav-menu">
				<?php wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'nav',
						'depth'          => -1,
					)
				); ?>
			</div>
		<?php endif; ?>
	</nav>
</header>