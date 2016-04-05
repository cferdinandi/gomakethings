<?php

/**
 * content-gmt-projects.php
 * Template for projects content.
 */

?>

<?php
	// Project details
	$options = projects_get_theme_options();
	$details = get_post_meta( $post->ID, 'project_details', true );
?>

<?php
	/**
	 * Individual Posts
	 */
	if ( is_single() ) :
?>

	<article>

		<?php if ( has_post_thumbnail() ) : ?>
			<aside>
				<?php the_post_thumbnail( 'full', array( 'class' => 'your-class-name' ) ); ?>
			</aside>
		<?php endif; ?>

		<header>
			<h1 <?php if ( !empty( $details['url'] ) ) { echo 'class="no-margin-bottom"'; } ?>><?php the_title(); ?></h1>
			<?php if ( !empty( $details['url'] ) ) : ?>
				<p><a href="<?php echo esc_url( $details['url'] ) ?>"><?php echo esc_attr( empty( $details['url_label'] ) ? $details['url'] : $details['url_label'] ); ?></a></p>
			<?php endif; ?>
		</header>

		<?php the_content(); ?>

		<?php
			// The project call-to-action
			echo stripslashes( wpautop( do_shortcode( $options['call_to_action'] ) ) );
		?>

		<?php
			$next = get_next_post();
			$next = empty( $next ) ? get_posts( array( 'post_type' => 'gmt-projects', 'posts_per_page' => 1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ) : $next;
			$next = is_array( $next ) ? $next[0] : $next;
			if ( !empty( $next ) && $next->ID !== $post->ID ) :
		?>
			<div class="padding-top-large text-center">
				<p>
					<a href="<?php the_permalink( $next->ID ); ?>">
						<?php printf( __( 'Learn about %s', 'keel' ), $next->post_title ) ?> &rarr;
					</a>
				</p>
			</div>
		<?php endif; ?>

		<?php
			// Add link to edit pages
			edit_post_link( __( 'Edit', 'keel' ), '<p>', '</p>' );
		?>

	</article>

<?php
	/**
	 * All Posts
	 */
	else :
?>

	<?php
		$excerpt = get_the_excerpt();
		if ( !empty( $excerpt ) ) :
	?>

		<li class="margin-bottom-small">

			<strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong> <?php echo $excerpt; ?>

			<?php
				// Add link to edit pages
				edit_post_link( __( 'Edit', 'keel' ), ' / ', '' );
			?>

		</li>

	<?php endif; ?>

<?php endif; ?>