<?php

/**
 * functions.php
 * For modifying and expanding core WordPress functionality.
 */


	/**
	 * Load theme files
	 */
	function keel_load_theme_files() {
		$keel_theme = wp_get_theme();
		wp_enqueue_style( 'keel-theme-styles', get_template_directory_uri() . '/dist/css/main.min.' . $keel_theme->get( 'Version' ) . '.css', null, null, 'all' );
	}
	add_action('wp_enqueue_scripts', 'keel_load_theme_files');



	/**
	 * Load inline header content
	 */
	function keel_load_inline_header() {
		$keel_theme = wp_get_theme();

		?>
			<script>
				<?php echo file_get_contents( get_template_directory_uri() . '/dist/js/detects.min.' . $keel_theme->get( 'Version' ) . '.js' ); ?>
				loadCSS('http://fonts.googleapis.com/css?family=PT+Serif:400,400italic,700,700italic');
			</script>
		<?php
	}
	add_action('wp_head', 'keel_load_inline_header', 30);



	/**
	 * Load inline footer content
	 */
	function keel_load_inline_footer() {
		$keel_theme = wp_get_theme();

		?>
			<!-- Fallback for noJS -->
			<noscript>
				<link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700,400italic' rel='stylesheet' type='text/css'>
			</noscript>

			<script>
				// Asynchronously load JavaScript if browser passes mustard test
				<?php echo file_get_contents( get_template_directory_uri() . '/dist/js/loadJS.min.' . $keel_theme->get( 'Version' ) . '.js' ); ?>
				if ( 'querySelector' in document && 'addEventListener' in window ) {
					loadJS('<?php echo get_template_directory_uri() . "/dist/js/main.min." . $keel_theme->get( "Version" ) . ".js"; ?>');
				}
			</script>
		<?php
	}
	add_action('wp_footer', 'keel_load_inline_footer', 30);



	/**
	 * Add a shortcode for the search form
	 * @return string Markup for search form
	 */
	function keel_wpsearch() {
		return get_search_form();
	}
	add_shortcode( 'searchform', 'keel_wpsearch' );



	/**
	 * Add a shortcode for the current theme directory
	 * @return string Current theme directory
	 */
	function keel_get_theme_directory_uri() {
		return get_template_directory_uri();
	}
	add_shortcode( 'themeuri', 'keel_get_theme_directory_uri' );



	/**
	 * Add a shortcode for the base URL
	 * @return string Site base URL
	 */
	function keel_get_site_url() {
		return site_url();
	}
	add_shortcode( 'siteurl', 'keel_get_site_url' );



	/**
	 * Replace RSS links with Feedburner url
	 * @link http://codex.wordpress.org/Using_FeedBurner
	 */
	function keel_custom_rss_feed( $output, $feed ) {
		if ( strpos( $output, 'comments' ) ) {
			return $output;
		}
		return esc_url( 'http://feeds.feedburner.com/GoMakeThings' );
	}
	add_action( 'feed_link', 'keel_custom_rss_feed', 10, 2 );



	/**
	 * Replace the default password-protected post messaging with custom language
	 * @return string Custom language
	 */
	function keel_post_password_form() {
		global $post;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$form =
			'<form class="text-center" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post"><p>' . __( 'This is a password protected post.', 'keel' ) . '</p><label class="screen-reader" for="' . $label . '">' . __( 'Password', 'keel' ) . '</label><input id="' . $label . '" name="post_password" type="password"><input type="submit" name="Submit" value="' . __( 'Submit', 'keel' ) . '"></form>';
		return $form;
	}
	add_filter( 'the_password_form', 'keel_post_password_form' );



	/**
	 * Customize the `wp_title` method
	 * @param  string $title The page title
	 * @param  string $sep   The separator between title and description
	 * @return string        The new page title
	 */
	function keel_pretty_wp_title( $title, $sep ) {

		global $paged, $page;

		if ( is_feed() )
			return $title;

		// If is events, update
		if ( is_post_type_archive( 'gmt-events' ) ) {
			$options = events_get_theme_options();
			$title = $options['page_title'] . ' ' . $sep . ' ';
		}

		// Add the site name
		$title .= get_bloginfo( 'name' );

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'keel' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( 'wp_title', 'keel_pretty_wp_title', 10, 2 );



	/**
	 * Override default the_excerpt length
	 * @param  number $length Default length
	 * @return number         New length
	 */
	function keel_excerpt_length( $length ) {
		return 35;
	}
	add_filter( 'excerpt_length', 'keel_excerpt_length', 999 );



	/**
	 * Override default the_excerpt read more string
	 * @param  string $more Default read more string
	 * @return string       New read more string
	 */
	function keel_excerpt_more( $more ) {
		// return '... <a href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'keel') . '</a>';
		return '...';
	}
	add_filter( 'excerpt_more', 'keel_excerpt_more' );



	/**
	 * Sets max allowed content width
	 * Deliberately large to prevent pixelation from content stretching
	 * @link http://codex.wordpress.org/Content_Width
	 */
	if ( !isset( $content_width ) ) {
		$content_width = 960;
	}



	/**
	 * Registers navigation menus for use with wp_nav_menu function
	 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus
	 */
	function keel_register_menus() {
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu' ),
				'secondary' => __( 'Secondary Menu' ),
				// 'secondary_1' => __( 'Secondary Menu 1' ),
				// 'secondary_2' => __( 'Secondary Menu 2' ),
				// 'contact' => __( 'Contact Menu' ),
			)
		);
	}
	add_action( 'init', 'keel_register_menus' );



	/**
	 * Adds support for featured post images
	 * @link http://codex.wordpress.org/Post_Thumbnails
	 */
	function keel_post_thumbnails_support() {
		add_theme_support( 'post-thumbnails', array( 'gmt-projects' ) );
	}
	add_action( 'after_setup_theme', 'keel_post_thumbnails_support' );



	/**
	 * Adds support for custom header images
	 * @link http://codex.wordpress.org/Custom_Headers
	 */
	// add_theme_support( 'custom-header' );



	/**
	 * Custom comment callback for wp_list_comments used in comments.php
	 * @param  object $comment The comment
	 * @param  object $args Comment settings
	 * @param  integer $depth How deep to nest comments
	 * @return string Comment markup
	 * @link http://codex.wordpress.org/Function_Reference/wp_list_comments
	 */
	function keel_comment_layout($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' === $args['style'] ) {
			$tag = 'div';
		} else {
			$tag = 'li';
		}
	?>

		<<?php echo $tag ?> <?php if ( $depth > 1 ) { echo 'class="comment-nested"'; } ?> id="comment-<?php comment_ID() ?>">

			<hr class="line-secondary">

			<article>

				<?php if ($comment->comment_approved == '0') : // If the comment is held for moderation ?>
					<p><em><?php _e( 'Your comment is being held for moderation.', 'keel' ) ?></em></p>
				<?php endif; ?>

				<header class="margin-bottom-small clearfix">
					<figure>
						<?php if ( $args['avatar_size'] !== 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					</figure>
					<h3 class="no-margin no-padding">
						<?php comment_author_link() ?>
					</h3>
					<aside class="text-muted">
						<time datetime="<?php comment_date( 'Y-m-d' ); ?>" pubdate><?php comment_date('F jS, Y') ?></time>
						<?php edit_comment_link('Edit', ' / ', ''); ?>
					</aside>
				</header>

				<?php comment_text(); ?>
				<?php
					/**
					 * Add inline reply link.
					 * Only displays if nested comments are enabled.
					 */
					comment_reply_link( array_merge(
						$args,
						array(
							'add_below' => 'comment',
							'depth' => $depth,
							'max_depth' => $args['max_depth'],
							'before' => '<p>',
							'after' => '</p>'
						)
					) );
				?>

			</article>

	<?php
	}



	/**
	 * Custom implementation of comment_form
	 * @return string Markup for comment form
	 */
	function keel_comment_form() {

		$commenter = wp_get_current_commenter();
		global $user_identity;

		$must_log_in =
			'<p>' .
				sprintf(
					__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
					wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
				) .
			'</p>';

		$logged_in_as =
			'<p>' .
				sprintf(
					__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s">Log out.</a>' ),
					admin_url( 'profile.php' ),
					$user_identity,
					wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
				) .
			'</p>';

		$notes_before = '';
		$notes_after = '';

		$field_author =
			'<div class="row">' .
				'<div class="grid-two-thirds">' .
					'<label for="author">' . __( 'Name' ) . '</label>' .
					'<input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" required>' .
				'</div>' .
			'</div>';

		$field_email =
			'<div class="row">' .
				'<div class="grid-two-thirds">' .
					'<label for="email">' . __( 'Email' ) . '</label>' .
					'<input type="email" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" required>' .
				'</div>' .
			'</div>';

		$field_url =
			'<div class="row">' .
				'<div class="grid-two-thirds">' .
					'<label for="url">' . __( 'Website (optional)' ) . '</label>' .
					'<input type="url" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '">' .
				'</div>' .
			'</div>';

		$field_comment =
			'<div>' .
				'<p class="margin-bottom-small">Share links, code and more with <a href="http://en.support.wordpress.com/markdown-quick-reference/">Markdown</a>.</p>' .
				'<textarea name="comment" id="comment" required></textarea>' .
			'</div>';

		$args = array(
			'title_reply' => __( 'Leave a Comment' ),
			'title_reply_to' => __( 'Reply to %s' ),
			'cancel_reply_link' => __( '[Cancel]' ),
			'label_submit' => __( 'Submit Comment' ),
			'comment_field' => $field_comment,
			'must_log_in' => $must_log_in,
			'logged_in_as' => $logged_in_as,
			'comment_notes_before' => $notes_before,
			'comment_notes_after' => $notes_after,
			'fields' => apply_filters(
				'comment_form_default_fields',
				array(
					'author' => $field_author,
					'email' => $field_email,
					'url' => $field_url
				)
			),
		);

		return comment_form( $args );

	}



	/**
	 * Add script for threaded comments if enabled
	 */
	if ( is_single() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script( 'comment-reply' );
	}



	/**
	 * Deregister JetPack's devicepx.js script
	 */
	function keel_dequeue_devicepx() {
		wp_dequeue_script( 'devicepx' );
	}
	add_action( 'wp_enqueue_scripts', 'keel_dequeue_devicepx', 20 );



	/**
	 * Convert markdown to HTML using Jetpack
	 * @param  string $content Markdown content
	 * @return string          Converted content
	 */
	function keel_process_jetpack_markdown( $content ) {

		// If markdown class is defined, convert content
		if ( class_exists( 'WPCom_Markdown' ) ) {

			// Get markdown library
			jetpack_require_lib( 'markdown' );

			// Return converted content
			return WPCom_Markdown::get_instance()->transform( $content );

		}

		// Else, return content
		return $content;

	}



	/**
	 * Get saved markdown content if it exists and Jetpack is active. Otherwise, get HTML.
	 * @param  array  $options  Array with HTML and markdown content
	 * @param  string $name     The name of the content
	 * @param  string $suffix   The suffix to denote the markdown version of the content
	 * @return string           The content
	 */
	function keel_get_jetpack_markdown( $options, $name, $suffix = '_markdown' ) {

		// If markdown class is defined, get markdown content
		if ( class_exists( 'WPCom_Markdown' ) && array_key_exists( $name . $suffix, $options ) && !empty( $options[$name . $suffix] ) ) {
			return $options[$name . $suffix];
		}

		// Else, return HTML
		return $options[$name];

	}



	/**
	 * Disable WordPress auto-formatting
	 * Disabled by default. Uncomment add_action to enable
	 */
	function keel_remove_wpautop() {
		remove_filter('the_content', 'wpautop');
	}
	// add_action( 'pre_get_posts', 'keel_remove_wpautop' );



	/**
	 * Remove empty paragraphs created by wpautop()
	 * @author Ryan Hamilton
	 * @link https://gist.github.com/Fantikerz/5557617
	 */
	function keel_remove_empty_p( $content ) {
		$content = force_balance_tags( $content );
		$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
		$content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
		return $content;
	}
	add_filter('the_content', 'keel_remove_empty_p', 20, 1);



	/**
	 * Unlink images by default
	 */
	function keel_update_image_default_link_type() {
		update_option( 'image_default_link_type', 'none' );
	}
	add_action( 'admin_init', 'keel_update_image_default_link_type' );



	/**
	 * Modify query for Events CPT
	 * @param  array $query The WordPress post query
	 */
	function keel_modify_events_query( $query ) {

		if ( is_admin() || !is_post_type_archive( 'gmt-events' ) || $query->get( 'post_type' ) !== 'gmt-events' ) return;

		// Order by start date
		$query->set( 'post_type', 'gmt-events' );
		$query->set( 'meta_key', 'event_start_date' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'DESC' );

		// Show all posts on one page
		$query->set( 'posts_per_page', '-1' );

	}
	add_action( 'pre_get_posts', 'keel_modify_events_query' );



	/**
	 * Modify query for Projects CPT
	 * @param  array $query The WordPress post query
	 */
	function keel_modify_projects_query( $query ) {

		if ( is_admin() || !is_post_type_archive( 'gmt-projects' ) || $query->get( 'post_type' ) !== 'gmt-projects' ) return;

		// Order by start date
		$query->set( 'post_type', 'gmt-projects' );
		$query->set( 'orderby', 'menu_order' );
		$query->set( 'order', 'ASC' );

		// Show all posts on one page
		$query->set( 'posts_per_page', '-1' );

	}
	add_action( 'pre_get_posts', 'keel_modify_projects_query' );



	/**
	 * Exclude past or upcoming events from events query
	 * @param Array $query The database query
	 */
	function keel_events_filter_query( $query ) {

		if ( is_admin() || !isset( $query->query['post_type'] ) || $query->query['post_type'] !== 'keel-events' || !isset( $query->query['date'] )  || !$query->is_main_query() ) return $query;

		//Get original meta query
		$meta_query = $query->get('meta_query');

		// if filtering by past events
		if ( $query->query['date'] === 'past' ) {
			//Add our meta query to the original meta queries
			$meta_query[] = array(
				'relation' => 'AND',
				array(
					'relation' => 'OR',
					array(
						'key' => 'keel_events_start_date',
						'value' => strtotime( 'today', current_time( 'timestamp' ) ),
						'compare' => '<',
						'type' => 'NUMERIC',
					),
					array(
						'key' => 'keel_events_end_date',
						'value' => strtotime( 'today', current_time( 'timestamp' ) ),
						'compare' => '<',
						'type' => 'NUMERIC',
					),
				),
				array(
					'key' => 'keel_events_start_date',
					'value' => array(''),
					'compare' => 'NOT IN',
				),
			);
			$query->set( 'meta_query', $meta_query );
			$query->set('meta_key', 'keel_events_start_date');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'DESC');
		}

		// If filtering by upcoming events
		if ( $query->query['date'] === 'upcoming' ) {
			//Add our meta query to the original meta queries
			$meta_query[] = array(
				'relation' => 'AND',
				array(
					'relation' => 'OR',
					array(
						'key' => 'keel_events_start_date',
						'value' => strtotime( 'today', current_time( 'timestamp' ) ),
						'compare' => '>=',
						'type' => 'NUMERIC',
					),
					array(
						'key' => 'keel_events_end_date',
						'value' => strtotime( 'today', current_time( 'timestamp' ) ),
						'compare' => '>=',
						'type' => 'NUMERIC',
					),
				),
				array(
					'key' => 'keel_events_start_date',
					'value' => array(''),
					'compare' => 'NOT IN',
				),
			);
			$query->set( 'meta_query', $meta_query );
			$query->set('meta_key', 'keel_events_start_date');
			$query->set('orderby', 'meta_value_num');
			$query->set('order', 'ASC');
		}

	}
	add_action( 'pre_get_posts', 'keel_events_filter_query' );



	/**
	 * Get number of comments (without trackbacks or pings)
	 * @return integer Number of comments
	 */
	function keel_just_comments_count() {
		global $post;
		return count( get_comments( array( 'type' => 'comment', 'post_id' => $post->ID ) ) );
	}



	/**
	 * Get number of trackbacks
	 * @return integer Number of trackbacks
	 */
	function keel_trackbacks_count() {
		global $post;
		return count( get_comments( array( 'type' => 'trackback', 'post_id' => $post->ID ) ) );
	}



	/**
	 * Get number of pings
	 * @return integer Number of pings
	 */
	function keel_pings_count() {
		global $post;
		return count( get_comments( array( 'type' => 'pingback', 'post_id' => $post->ID ) ) );
	}



	/**
	 * Check if more than one page of content exists
	 * @return boolean True if content is paginated
	 */
	function keel_is_paginated() {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) {
			return true;
		} else {
			return false;
		}
	}



	/**
	 * Check if post is the last in a set
	 * @param  object  $wp_query WPQuery object
	 * @return boolean           True if is last post
	 */
	function keel_is_last_post($wp_query) {
		$post_current = $wp_query->current_post + 1;
		$post_count = $wp_query->post_count;
		if ( $post_current == $post_count ) {
			return true;
		} else {
			return false;
		}
	}



	/**
	 * Print a pre formatted array to the browser - useful for debugging
	 * @param array $array Array to print
	 * @author 	Keir Whitaker
	 * @link https://github.com/viewportindustries/starkers/
	 */
	function keel_print_a( $a ) {
		print( '<pre>' );
		print_r( $a );
		print( '</pre>' );
	}



	/**
	 * Pass in a path and get back the page ID
	 * @param  string $path The URL of the page
	 * @return integer Page or post ID
	 * @author Keir Whitaker
	 * @link https://github.com/viewportindustries/starkers/
	 */
	function keel_get_page_id_from_path( $path ) {
		$page = get_page_by_path( $path );
		if( $page ) {
			return $page->ID;
		} else {
			return null;
		};
	}



	/**
	 * Includes
	 */
	require_once( dirname( __FILE__) . '/includes/keel-post-options.php' ); // Page hero metabox
	require_once( dirname( __FILE__) . '/includes/keel-page-hero.php' ); // Page hero metabox
	require_once( dirname( __FILE__) . '/includes/keel-set-page-width.php' ); // Page width settings
	// require_once( dirname( __FILE__) . '/includes/keel-contact-form-7-overrides.php' ); // Override default Contact Form 7 behaviors