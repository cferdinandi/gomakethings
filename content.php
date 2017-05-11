<?php

/**
 * content.php
 * Template for post content.
 */

$options = keel_get_theme_options();

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
			// Category list
			$tags = get_the_category();
			if ( !empty( $tags ) ) :
		?>
			<ul class="padding-top text-small list-inline">
				<li><strong><?php echo stripslashes( esc_html( $options['blog_category_label'] ) ); ?></strong></li>
				<?php foreach( $tags as $key => $tag ) : ?>
					<li><a href="<?php echo get_category_link( $tag->cat_ID ); ?>"><?php echo $tag->cat_name; ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php
			// Blog post message
			if ( !empty( $options ) && array_key_exists( 'blog_posts_message', $options ) && !empty( $options['blog_posts_message'] ) ) {
				echo do_shortcode( wpautop( stripslashes( $options['blog_posts_message'] ), false ) );
			}
		?>

		<!-- $posttags = get_the_tags();
		if ($posttags) {
		  foreach($posttags as $tag) {
		    echo $tag->name . ' ';
		  }
		} -->



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

	<?php if ( $wp_query->current_post === 0 && !is_archive() ) : ?>
		<header <?php if ( $options['blog_hide_all_posts_heading'] === 'on' ) { echo 'class="screen-reader"'; } ?>>
			<h1><?php echo $options['blog_all_posts_heading']; ?></h1>
		</header>
	<?php endif; ?>

	<?php
		if ( $wp_query->current_post === 0 && array_key_exists( 'blog_all_posts_message', $options ) && !empty( $options['blog_all_posts_message'] ) ) :
	?>
		<aside>
			<?php echo do_shortcode( stripslashes( wpautop( $options['blog_all_posts_message'], false ) ) ); ?>
		</aside>
	<?php endif; ?>

	<?php
		global $year;
		$post_year = get_the_time( 'Y', $post );
		if ( empty($year) || intval( $year ) !== intval( $post_year ) ) :
	?>
		<h2 <?php echo ( $wp_query->current_post === 0 ? 'class="no-padding-top"' : '' ); ?>><?php echo $post_year; ?></h2>
	<?php
		$year = $post_year;
		endif;
	?>

	<article>

		<header class="row">

			<div class="grid-fourth grid-flip ">
				<aside class="text-muted text-small">
					<time datetime="<?php the_time( 'F j, Y' ); ?>" pubdate><?php the_time( 'F j, Y' ); ?></time>
					<?php edit_post_link( __( 'Edit', 'keel' ), ' / ', '' ); ?>
				</aside>
			</div>

			<div class="grid-three-fourths">
				<h3 class="h5 text-normal no-padding-top">
					<a class="link-plain" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
			</div>

		</header>

		<?php
			// The post content
			// echo get_the_excerpt() . ' <a href="' . get_the_permalink() . '">' . sprintf( __( 'read more %s', 'keel' ), '<span class="screen-reader">of ' . get_the_title() . '</span></a>' );
			// the_content(
			// 	sprintf(
			// 		__( 'Read more %s...', 'keel' ),
			// 		'<span class="screen-reader">of ' . get_the_title() . '</span>'
			// 	)
			// );
		?>
		<?php
			// Comment out...
			if (false) :
		?>
		<p>
			<a href="<?php the_permalink(); ?>">
				<?php
					printf(
						__( 'Read more %s...', 'keel' ),
						'<span class="screen-reader">of ' . get_the_title() . '</span>'
					);
				?>
			</a>
		</p>
		<?php endif; ?>

		<?php
			// If this is not the last post on the page, insert a divider
			// if ( !keel_is_last_post($wp_query) ) :
			if (false) :
		?>
		    <hr class="line-clear">
		<?php endif; ?>

	</article>

<?php endif; ?>