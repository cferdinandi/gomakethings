<?php

	/**
	 * Add a hero option to pages
	 */

	// Create a metabox
	function keel_page_hero_box() {
		add_meta_box( 'keel_page_hero_textarea', 'Page Hero', 'keel_page_hero_textarea', 'page', 'normal', 'default' );
	}
	add_action( 'add_meta_boxes', 'keel_page_hero_box' );


	// Add textarea to the metabox
	function keel_page_hero_textarea() {

		global $post;

		// Get hero content
		$hero = stripslashes( get_post_meta( $post->ID, 'keel_page_hero', true ) );

		?>

			<fieldset id="keel-page-hero-box">
				<textarea class="large-text" name="keel_page_hero" id="keel_page_hero" cols="50" rows="10"><?php echo stripslashes( esc_textarea( $hero ) ); ?></textarea>
				<label class="description" for="keel_page_hero"><?php _e( 'Add a hero at the top of the page', 'keel' ); ?></label>
			</fieldset>

		<?php

		// Security field
		wp_nonce_field( 'keel-page-hero-nonce', 'keel-page-hero-process' );

	}

	// Save textarea data
	function keel_save_page_hero_textarea( $post_id, $post ) {

		// Verify data came from edit screen
		if ( !isset( $_POST['keel-page-hero-process'] ) || !wp_verify_nonce( $_POST['keel-page-hero-process'], 'keel-page-hero-nonce' ) ) {
			return $post->ID;
		}

		// Verify user has permission to edit post
		if ( !current_user_can( 'edit_post', $post->ID )) {
			return $post->ID;
		}

		// Update data in database
		$hero = $_POST['keel_page_hero'];
		if ( isset( $_POST['keel_page_hero'] ) ) {
			update_post_meta( $post->ID, 'keel_page_hero', $_POST['keel_page_hero'] );
		}

	}
	add_action('save_post', 'keel_save_page_hero_textarea', 1, 2);

	// Save the data with revisions
	function keel_save_revisions_page_hero_textarea( $post_id ) {

		// Check if it's a revision
		$parent_id = wp_is_post_revision( $post_id );

		// If is revision
		if ( $parent_id ) {

			// Get the data
			$parent = get_post( $parent_id );
			$hero = get_post_meta( $parent->ID, 'keel_page_hero', true );

			// If data exists, add to revision
			if ( !empty( $hero ) ) {
				add_metadata( 'post', $post_id, 'keel_page_hero', $hero );
			}

		}

	}
	add_action( 'save_post', 'keel_save_revisions_page_hero_textarea' );

	// Restore the data with revisions
	function keel_restore_revisions_page_hero_textarea( $post_id, $revision_id ) {

		// Variables
		$post = get_post( $post_id );
		$revision = get_post( $revision_id );
		$hero = get_metadata( 'post', $revision->ID, 'keel_page_hero', true );


		if ( !empty( $hero ) ) {
			update_post_meta( $post_id, 'keel_page_hero', $hero );
		} else {
			delete_post_meta( $post_id, 'keel_page_hero' );
		}

	}
	add_action( 'wp_restore_post_revision', 'keel_restore_revisions_page_hero_textarea', 10, 2 );

	// Get the data to display the revisions page
	function keel_get_revisions_field_page_hero_textarea( $fields ) {
		$fields['keel_page_hero'] = 'Page Hero';
		return $fields;
	}
	add_filter( '_wp_post_revision_fields', 'keel_get_revisions_field_page_hero_textarea' );

	// Display the data on the revisions page
	function keel_display_revisions_field_page_hero_textarea( $value, $field ) {
		global $revision;
		return get_metadata( 'post', $revision->ID, $field, true );
	}
	add_filter( '_wp_post_revision_field_my_meta', 'keel_display_revisions_field_page_hero_textarea', 10, 2 );