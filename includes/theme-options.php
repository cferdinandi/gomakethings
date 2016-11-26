<?php

/**
 * Theme Options v1.1.0
 * Adjust theme settings from the admin dashboard.
 * Find and replace `keel` with your own namepspacing.
 *
 * Created by Michael Fields.
 * https://gist.github.com/mfields/4678999
 *
 * Forked by Chris Ferdinandi
 * http://gomakethings.com
 *
 * Free to use under the MIT License.
 * http://gomakethings.com/mit/
 */


	/**
	 * Theme Options Fields
	 * Each option field requires its own uniquely named function. Select options and radio buttons also require an additional uniquely named function with an array of option choices.
	 */

	//
	// Post
	//

	function keel_settings_field_blog_all_posts_heading() {
		$options = keel_get_theme_options();
		?>
		<input type="text" class="large-text" name="keel_theme_options[blog_all_posts_heading]" id="blog-all-posts-heading" value="<?php echo stripslashes( esc_attr( $options['blog_all_posts_heading'] ) ); ?>">
		<label class="description" for="blog-all-posts-heading"><?php _e( 'Heading to diplay at the top of the all blog posts page.', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_blog_hide_all_posts_heading() {
		$options = keel_get_theme_options();
		?>
		<input type="checkbox" name="keel_theme_options[blog_hide_all_posts_heading]" id="blog-hide-all-posts-heading" <?php checked( 'on', $options['blog_hide_all_posts_heading'] ); ?>>
		<label class="description" for="blog-hide-all-posts-heading"><?php _e( 'Hide all posts heading visually', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_blog_all_posts_message() {
		$options = keel_get_theme_options();
		?>
		<textarea class="large-text" name="keel_theme_options[blog_all_posts_message]" id="blog-all-posts-message" cols="50" rows="10"><?php echo stripslashes( esc_textarea( keel_get_jetpack_markdown( $options, 'blog_all_posts_message' ) ) ); ?></textarea>
		<label class="description" for="blog-all-posts-message"><?php _e( 'Message to diplay at the top of all blog posts.', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_blog_posts_message() {
		$options = keel_get_theme_options();
		?>
		<textarea class="large-text" name="keel_theme_options[blog_posts_message]" id="blog-posts-message" cols="50" rows="10"><?php echo stripslashes( esc_textarea( keel_get_jetpack_markdown( $options, 'blog_posts_message' ) ) ); ?></textarea>
		<label class="description" for="blog-posts-message"><?php _e( 'Message to display at the end of each blog post.', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_blog_category_label() {
		$options = keel_get_theme_options();
		?>
		<input type="text" class="large-text" name="keel_theme_options[blog_category_label]" id="blog_category_label" value="<?php echo stripslashes( esc_attr( $options['blog_category_label'] ) ); ?>">
		<label class="description" for="blog_category_label"><?php _e( 'Label to display next for blog post categories.', 'keel' ); ?></label>
		<?php
	}


	//
	// 404
	//

	function keel_settings_field_404_heading() {
		$options = keel_get_theme_options();
		?>
		<input type="text" name="keel_theme_options[404_heading]" id="404_heading" value="<?php echo stripslashes( esc_attr( $options['404_heading'] ) ); ?>" />
		<label class="description" for="404_heading"><?php _e( 'Heading for the 404 page', 'keel' ); ?></label>
		<?php
	}

	function keel_settings_field_404_content() {
		$options = keel_get_theme_options();
		?>
		<textarea class="large-text" type="text" name="keel_theme_options[404_content]" id="404_content" cols="50" rows="10" /><?php echo stripslashes( esc_textarea( keel_get_jetpack_markdown( $options, '404_content' ) ) ); ?></textarea>
		<label class="description" for="404_content"><?php _e( 'Content for the 404 page', 'keel' ); ?></label>
		<?php
	}

	// Sample checkbox field
	function keel_settings_field_404_show_search() {
		$options = keel_get_theme_options();
		?>
		<label>
			<input type="checkbox" name="keel_theme_options[404_show_search]" <?php checked( 'on', $options['404_show_search'] ); ?> />
			<?php _e( 'Show a search box on the 404 page', 'keel' ); ?>
		</label>
		<?php
	}


	//
	// Footer
	//

	function keel_settings_field_footer_content() {
		$options = keel_get_theme_options();
		?>
		<textarea class="large-text" name="keel_theme_options[footer_content]" id="footer_content" cols="50" rows="10"><?php echo stripslashes( esc_textarea( keel_get_jetpack_markdown( $options, 'footer_content' ) ) ); ?></textarea>
		<label class="description" for="footer_content"><?php _e( 'Content for the footer', 'keel' ); ?></label>
		<?php
	}



	/**
	 * Theme Option Defaults & Sanitization
	 * Each option field requires a default value under keel_get_theme_options(), and an if statement under keel_theme_options_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function keel_get_theme_options() {
		$saved = (array) get_option( 'keel_theme_options' );
		$defaults = array(

			// Posts
			'blog_all_posts_heading' => 'Posts',
			'blog_hide_all_posts_heading' => 'off',
			'blog_all_posts_message' => '',
			'blog_all_posts_message_markdown' => '',
			'blog_posts_message' => '',
			'blog_posts_message_markdown' => '',
			'blog_category_label' => 'More like this...',

			// 404
			'404_heading' => 'Oops!',
			'404_content' => 'We can\'t seem to find the page you\'re looking for. Try searching for it?',
			'404_content_markdown' => '',
			'404_show_search' => 'off',

			// Footer
			'footer_content' => '',
			'footer_content_markdown' => '',

		);

		$defaults = apply_filters( 'keel_default_theme_options', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated theme options
	function keel_theme_options_validate( $input ) {
		$output = array();

		// Posts
		if ( isset( $input['blog_all_posts_heading'] ) && ! empty( $input['blog_all_posts_heading'] ) )
			$output['blog_all_posts_heading'] = wp_filter_nohtml_kses( $input['blog_all_posts_heading'] );

		if ( isset( $input['blog_hide_all_posts_heading'] ) )
			$output['blog_hide_all_posts_heading'] = 'on';

		if ( isset( $input['blog_all_posts_message'] ) && ! empty( $input['blog_all_posts_message'] ) ) {
			$output['blog_all_posts_message'] = keel_process_jetpack_markdown( wp_filter_post_kses( $input['blog_all_posts_message'] ) );
			$output['blog_all_posts_message_markdown'] = wp_filter_post_kses( $input['blog_all_posts_message'] );
		}

		if ( isset( $input['blog_posts_message'] ) && ! empty( $input['blog_posts_message'] ) ) {
			$output['blog_posts_message'] = keel_process_jetpack_markdown( wp_filter_post_kses( $input['blog_posts_message'] ) );
			$output['blog_posts_message_markdown'] = wp_filter_post_kses( $input['blog_posts_message'] );
		}

		if ( isset( $input['blog_category_label'] ) && ! empty( $input['blog_category_label'] ) )
			$output['blog_category_label'] = wp_filter_nohtml_kses( $input['blog_category_label'] );

		// 404
		if ( isset( $input['404_heading'] ) && ! empty( $input['404_heading'] ) )
			$output['404_heading'] = wp_filter_nohtml_kses( $input['404_heading'] );

		if ( isset( $input['404_content'] ) && ! empty( $input['404_content'] ) ) {
			$output['404_content'] = keel_process_jetpack_markdown( wp_filter_post_kses( $input['404_content'] ) );
			$output['404_content_markdown'] = wp_filter_post_kses( $input['404_content'] );
		}

		if ( isset( $input['404_show_search'] ) )
			$output['404_show_search'] = 'on';

		// Footer
		if ( isset( $input['footer_content'] ) && ! empty( $input['footer_content'] ) ) {
			$output['footer_content'] = keel_process_jetpack_markdown( wp_filter_post_kses( $input['footer_content'] ) );
			$output['footer_content_markdown'] = wp_filter_post_kses( $input['footer_content'] );
		}

		return apply_filters( 'keel_theme_options_validate', $output, $input );
	}



	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function keel_theme_options_render_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Theme Options', 'keel' ); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'keel_options' );
					do_settings_sections( 'keel_theme_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// Register the theme options page and its fields
	function keel_theme_options_init() {

		// Register a setting and its sanitization callback
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// $option_group - A settings group name.
		// $option_name - The name of an option to sanitize and save.
		// $sanitize_callback - A callback function that sanitizes the option's value.
		register_setting( 'keel_options', 'keel_theme_options', 'keel_theme_options_validate' );


		// Register our settings field group
		// add_settings_section( $id, $title, $callback, $page );
		// $id - Unique identifier for the settings section
		// $title - Section title
		// $callback - // Section callback (we don't want anything)
		// $page - // Menu slug, used to uniquely identify the page. See keel_theme_options_add_page().
		add_settings_section( 'post', __( 'Posts', 'keel' ),  '__return_false', 'keel_theme_options' );
		add_settings_section( '404', __( '404 Page', 'keel' ),  '__return_false', 'keel_theme_options' );
		add_settings_section( 'footer', __( 'Footer', 'keel' ),  '__return_false', 'keel_theme_options' );


		// Register our individual settings fields
		// add_settings_field( $id, $title, $callback, $page, $section );
		// $id - Unique identifier for the field.
		// $title - Setting field title.
		// $callback - Function that creates the field (from the Theme Option Fields section).
		// $page - The menu page on which to display this field.
		// $section - The section of the settings page in which to show the field.
		add_settings_field( 'blog_all_posts_heading', __( 'All Posts Heading', 'keel' ), 'keel_settings_field_blog_all_posts_heading', 'keel_theme_options', 'post' );
		add_settings_field( 'blog_hide_all_posts_heading', __( 'Hide All Posts Heading', 'keel' ), 'keel_settings_field_blog_hide_all_posts_heading', 'keel_theme_options', 'post' );
		add_settings_field( 'blog_all_posts_message', __( 'All Posts Message', 'keel' ), 'keel_settings_field_blog_all_posts_message', 'keel_theme_options', 'post' );
		add_settings_field( 'blog_posts_message', __( 'Posts Message', 'keel' ), 'keel_settings_field_blog_posts_message', 'keel_theme_options', 'post' );
		add_settings_field( 'blog_category_label', __( 'Category Label', 'keel' ), 'keel_settings_field_blog_category_label', 'keel_theme_options', 'post' );

		add_settings_field( '404_heading', __( 'Heading', 'keel' ), 'keel_settings_field_404_heading', 'keel_theme_options', '404' );
		add_settings_field( '404_content', __( 'Content', 'keel' ), 'keel_settings_field_404_content', 'keel_theme_options', '404' );
		add_settings_field( '404_show_search', __( 'Search', 'keel' ), 'keel_settings_field_404_show_search', 'keel_theme_options', '404' );

		add_settings_field( 'footer_content', __( 'Footer', 'keel' ), 'keel_settings_field_footer_content', 'keel_theme_options', 'footer' );
	}
	add_action( 'admin_init', 'keel_theme_options_init' );

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function keel_theme_options_add_page() {

		// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		// $page_title - Name of page
		// $menu_title - Label in menu
		// $capability - Capability required
		// $menu_slug - Used to uniquely identify the page
		// $function - Function that renders the options page
		$theme_page = add_theme_page( __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_theme_options', 'keel_theme_options_render_page' );

		// $theme_page = add_menu_page( __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_theme_options', 'keel_theme_options_render_page' );
		// $theme_page = add_submenu_page( 'tools.php', __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_theme_options', 'keel_theme_options_render_page' );
	}
	add_action( 'admin_menu', 'keel_theme_options_add_page' );



	// Restrict access to the theme options page to admins
	function keel_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_keel_options', 'keel_option_page_capability' );
