<?php

/**
 * content-page.php
 * Template for page content.
 */

?>

<article>

	<?php
		$hide_header = get_post_meta( $post->ID, 'keel_page_header', true );
		if ( $hide_header !== 'on' ) :
	?>
		<header>
			<h1><?php the_title(); ?></h1>
		</header>
	<?php endif; ?>

	<?php the_content(); ?>

	<?php
		// Add link to edit pages
		edit_post_link( __( 'Edit', 'keel' ), '<p>', '</p>' );
	?>

</article>