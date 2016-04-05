<?php

	/**
	 * Override default Contact Form 7 behaviors
	 */


	// Disable default CSS and JavaScript
	add_filter( 'wpcf7_load_js', '__return_false' );
	add_filter( 'wpcf7_load_css', '__return_false' );

	// Use PHP redirect instead of JS
	function keel_contact_form_7_overrides( $wpcf7 ) {

		$on_sent_ok = $wpcf7->additional_setting('redirect_on_sent_ok', false);

		if ( is_array( $on_sent_ok ) && count( $on_sent_ok ) > 0 ) {
			wp_redirect( trim( $on_sent_ok[0] ) );
			exit;
		}

	}
	add_action( 'wpcf7_mail_sent', 'keel_contact_form_7_overrides' );