<?php

/**
 * content-gmt-articles.php
 * Template for articles content.
 */

$article_options = articles_get_theme_options();

?>

<?php
	/**
	 * Individual Posts
	 */
	if ( is_single() ) :
?>

	<article>

		<header>

			<aside class="text-muted">
				<time datetime="<?php the_time( 'F j, Y' ); ?>" pubdate><?php the_time( 'F j, Y' ); ?></time>
				<?php edit_post_link( __( 'Edit', 'keel' ), ' / ', '' ); ?>
			</aside>

			<h1 class="no-padding-top">
				<?php the_title(); ?>
			</h1>

		</header>


		<?php
			// The post content
			the_content();
		?>

		<?php
			if ( !empty( $article_options ) && array_key_exists( 'article_message', $article_options ) && !empty( $article_options['article_message'] ) ) {
				echo do_shortcode( wpautop( stripslashes( $article_options['article_message'] ), false ) );
			}
		?>

		<?php
			// Add comments template to blog posts
			// comments_template();
		?>

	</article>

<?php
	/**
	 * All Posts
	 */
	else :
?>

	<?php if ( $wp_query->current_post === 0 && is_archive() ) : ?>
		<header <?php if ( $article_options['page_hide_title'] === 'on' ) { echo 'class="screen-reader"'; } ?>>
			<h1><?php echo $article_options['page_title']; ?></h1>
		</header>
	<?php endif; ?>

	<?php
		if ( $wp_query->current_post === 0 && array_key_exists( 'page_text', $article_options ) && !empty( $article_options['page_text'] ) ) :
	?>
		<aside>
			<?php echo do_shortcode( stripslashes( wpautop( $article_options['page_text'], false ) ) ); ?>
		</aside>
	<?php endif; ?>

	<article>

		<header>

			<aside class="text-muted">
				<time datetime="<?php the_time( 'F j, Y' ); ?>" pubdate><?php the_time( 'F j, Y' ); ?></time>
				<?php edit_post_link( __( 'Edit', 'keel' ), ' / ', '' ); ?>
			</aside>

			<h2 class="no-padding-top margin-bottom-small">
				<a class="link-plain" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

		</header>

		<?php
			// The post content
			echo get_the_excerpt() . ' <a href="' . get_the_permalink() . '">' . sprintf( __( 'read more %s', 'keel' ), '<span class="screen-reader">of ' . get_the_title() . '</span></a>' );
			// the_content(
			// 	sprintf(
			// 		__( 'Read more %s...', 'keel' ),
			// 		'<span class="screen-reader">of ' . get_the_title() . '</span>'
			// 	)
			// );
		?>

		<?php
			// If this is not the last post on the page, insert a divider
			if ( !keel_is_last_post($wp_query) ) :
		?>
		    <hr class="line-clear">
		<?php endif; ?>

	</article>

<?php endif; ?>