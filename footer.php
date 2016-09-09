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
			$page_navs = get_post_meta( $post->ID, 'keel_page_navs', true );
		?>

		<?php if ( empty( $page_navs ) || $page_navs === 'off' ) : ?>
			<footer class="container container-large">

				<hr class="margin-bottom">

				<?php get_template_part( 'nav', 'secondary' ); ?>

				<p>
					<span class="text-small">
						Made with &lt;3 in Massachusetts. Copyright <?php echo date( 'Y' ); ?> Go Make Things, LLC. Unless otherwise noted, all code is free to use under the <a href="<?php echo site_url(); ?>/mit">MIT License</a>.
					</span>
				</p>

			</footer>
		<?php endif; ?>

		<?php wp_footer(); ?>

	</body>
</html>