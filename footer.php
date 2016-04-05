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

			<p>
				<span class="text-small">
					Made with &lt;3 in Massachusetts. Copyright <?php echo date( 'Y' ); ?> Go Make Things, LLC. Code available under <a href="<?php echo site_url(); ?>/mit/">the MIT license</a>.
				</span>
			</p>

		</footer>

		<?php wp_footer(); ?>

	</body>
</html>