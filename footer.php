<?php

/**
 * footer.php
 * Template for footer content.
 */

?>

			</div><!-- /.container -->
		</main><!-- /#main -->

		<?php
			// Get page layout options
			global $post;
			$options = keel_get_theme_options();
			$page_navs = get_post_meta( $post->ID, 'keel_page_navs', true );
		?>

		<?php if ( empty( $page_navs ) || $page_navs === 'off' ) : ?>
			<footer class="container container-large">

				<hr class="margin-bottom">

				<?php get_template_part( 'nav', 'secondary' ); ?>

				<?php if ( !empty( $options['footer_content'] ) ) : ?>
					<p>
						<span class="text-small">
							<?php echo stripslashes( str_replace( '[date]', date( 'Y' ), $options['footer_content'] ) ); ?>
						</span>
					</p>
				<?php endif; ?>

			</footer>
		<?php endif; ?>

		<?php wp_footer(); ?>

	</body>
</html>