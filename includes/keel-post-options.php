<?php

/**
 * Post Options
 * Custom post settings in the admin dashboard.
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

	// Renders heading on the all blog posts
	function keel_settings_field_blog_all_posts_heading() {
		$options = keel_get_post_options();
		?>
		<input type="text" class="large-text" name="keel_post_options[blog_all_posts_heading]" id="blog-all-posts-heading" value="<?php echo esc_attr( $options['blog_all_posts_heading'] ); ?>">
		<label class="description" for="blog-all-posts-heading"><?php _e( 'Heading to diplay at the top of the all blog posts page.', 'keel' ); ?></label>
		<?php
	}

	// Hide all posts heading
	function keel_settings_field_blog_hide_all_posts_heading() {
		$options = keel_get_post_options();
		?>
		<input type="checkbox" name="keel_post_options[blog_hide_all_posts_heading]" id="blog-hide-all-posts-heading" <?php checked( 'on', $options['blog_hide_all_posts_heading'] ); ?>>
		<label class="description" for="blog-hide-all-posts-heading"><?php _e( 'Hide all posts heading visually', 'keel' ); ?></label>
		<?php
	}

	// Renders the all blog posts message textarea setting field.
	function keel_settings_field_blog_all_posts_message() {
		$options = keel_get_post_options();
		?>
		<textarea class="large-text" name="keel_post_options[blog_all_posts_message]" id="blog-all-posts-message" cols="50" rows="10"><?php echo stripslashes( esc_textarea( keel_get_jetpack_markdown( $options, 'blog_all_posts_message' ) ) ); ?></textarea>
		<label class="description" for="blog-all-posts-message"><?php _e( 'Message to diplay at the top of all blog posts.', 'keel' ); ?></label>
		<?php
	}

	// Renders the blog posts message textarea setting field.
	function keel_settings_field_blog_posts_message() {
		$options = keel_get_post_options();
		?>
		<textarea class="large-text" name="keel_post_options[blog_posts_message]" id="blog-posts-message" cols="50" rows="10"><?php echo stripslashes( esc_textarea( keel_get_jetpack_markdown( $options, 'blog_posts_message' ) ) ); ?></textarea>
		<label class="description" for="blog-posts-message"><?php _e( 'Message to display at the end of each blog post.', 'keel' ); ?></label>
		<?php
	}



	/**
	 * Theme Option Defaults & Sanitization
	 * Each option field requires a default value under keel_get_post_options(), and an if statement under keel_post_options_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function keel_get_post_options() {
		$saved = (array) get_option( 'keel_post_options' );
		$defaults = array(
			'blog_all_posts_heading' => '',
			'blog_hide_all_posts_heading' => 'off',
			'blog_all_posts_message' => '',
			'blog_all_posts_message_markdown' => '',
			'blog_posts_message' => '',
			'blog_posts_message_markdown' => '',
		);

		$defaults = apply_filters( 'keel_default_theme_options', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated theme options
	function keel_post_options_validate( $input ) {
		$output = array();

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

		return apply_filters( 'keel_post_options_validate', $output, $input );
	}



	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function keel_post_options_render_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Post Options', 'keel' ); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'keel_post_options' );
					do_settings_sections( 'keel_post_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// Register the post options page and its fields
	function keel_post_options_init() {

		// Register a setting and its sanitization callback
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// $option_group - A settings group name.
		// $option_name - The name of an option to sanitize and save.
		// $sanitize_callback - A callback function that sanitizes the option's value.
		register_setting( 'keel_post_options', 'keel_post_options', 'keel_post_options_validate' );


		// Register our settings field group
		// add_settings_section( $id, $title, $callback, $page );
		// $id - Unique identifier for the settings section
		// $title - Section title
		// $callback - // Section callback (we don't want anything)
		// $page - // Menu slug, used to uniquely identify the page. See keel_post_options_add_page().
		add_settings_section( 'general', '',  '__return_false', 'keel_post_options' );


		// Register our individual settings fields
		// add_settings_field( $id, $title, $callback, $page, $section );
		// $id - Unique identifier for the field.
		// $title - Setting field title.
		// $callback - Function that creates the field (from the Theme Option Fields section).
		// $page - The menu page on which to display this field.
		// $section - The section of the settings page in which to show the field.
		add_settings_field( 'blog_all_posts_heading', __( 'All Posts Heading', 'keel' ), 'keel_settings_field_blog_all_posts_heading', 'keel_post_options', 'general' );
		add_settings_field( 'blog_hide_all_posts_heading', __( 'Hide All Posts Heading', 'keel' ), 'keel_settings_field_blog_hide_all_posts_heading', 'keel_post_options', 'general' );
		add_settings_field( 'blog_all_posts_message', __( 'All Posts Message', 'keel' ), 'keel_settings_field_blog_all_posts_message', 'keel_post_options', 'general' );
		add_settings_field( 'blog_posts_message', __( 'Posts Message', 'keel' ), 'keel_settings_field_blog_posts_message', 'keel_post_options', 'general' );
	}
	add_action( 'admin_init', 'keel_post_options_init' );

	// Add the post options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function keel_post_options_add_page() {

		// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		// $page_title - Name of page
		// $menu_title - Label in menu
		// $capability - Capability required
		// $menu_slug - Used to uniquely identify the page
		// $function - Function that renders the options page
		// $theme_page = add_theme_page( __( 'Post Options', 'keel' ), __( 'Post Options', 'keel' ), 'edit_theme_options', 'keel_post_options', 'keel_post_options_render_page' );

		// $theme_page = add_menu_page( __( 'Theme Options', 'keel' ), __( 'Theme Options', 'keel' ), 'edit_theme_options', 'keel_post_options', 'keel_post_options_render_page' );
		$theme_page = add_submenu_page( 'edit.php', __( 'Post Options', 'keel' ), __( 'Post Options', 'keel' ), 'edit_theme_options', 'keel_post_options', 'keel_post_options_render_page' );
	}
	add_action( 'admin_menu', 'keel_post_options_add_page' );



	// Restrict access to the post options page to admins
	function keel_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_keel_options', 'keel_option_page_capability' );