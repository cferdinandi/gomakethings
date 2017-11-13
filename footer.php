<?php

/**
 * footer.php
 * Template for footer content.
 */

?>

			</div><!-- /.container -->
		</main><!-- /#main -->

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

		<?php wp_footer(); ?>

	</body>
</html>