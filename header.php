<?php

/**
 * header.php
 * Template for header content.
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php if ( is_home () ) : ?><meta name="description" content="<?php bloginfo('description'); ?>"><?php endif; ?>

		<!-- Mobile Screen Resizing -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Icons: place in the root directory -->
		<!-- https://github.com/audreyr/favicon-cheat-sheet -->
		<link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/dist/img/favicon-144.png">
		<meta name="msapplication-TileColor" content="#0088cc">
		<meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri(); ?>/dist/img/favicon-ms.png">
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/dist/img/favicon.ico">
		<link rel="icon" sizes="16x16 32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/dist/img/favicon.ico">

		<!-- Feeds & Pings -->
		<link rel="alternate" type="application/rss+xml" title="<?php printf( __( '%s RSS Feed', 'keel' ), get_bloginfo( 'name' ) ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<!-- Old Browser Warning -->
		<!--[if lt IE 9]>
			<aside class="container">
				<p>Did you know that your web browser is a bit old? Some of the content on this site might not work right as a result. <a href="http://whatbrowser.org">Upgrade your browser</a> for a faster, safer, and better web experience.</p>
			</aside>
		<![endif]-->

		<?php
			// a11y ehancements
			get_template_part( 'nav', 'accessibility' );
		?>

		<?php
			// Get site navigation
			get_template_part( 'nav', 'main' );
		?>

		<main class="tabindex" id="main" tabindex="-1">

			<?php

				global $post;

				// Get hero (if one exists)
				$hero = get_post_meta( $post->ID, 'keel_page_hero', true );
				if ( !empty( $hero ) ) {
					echo stripslashes( $hero );
				}

				// Get page width
				$container = ( get_post_meta( $post->ID, 'keel_page_width', true ) === 'wide' ? 'container-large' : '' );

			?>

			<div class="container <?php echo $container; ?>">