<?php

	/**
	 * Unset first and last name as required fields in checkout
	 * @param  Array $required_fields Required fields
	 */
	function keel_edd_purchase_form_required_fields( $required_fields ) {
		unset( $required_fields['edd_first'] );
		unset( $required_fields['edd_last'] );
		return $required_fields;
	}
	add_filter( 'edd_purchase_form_required_fields', 'keel_edd_purchase_form_required_fields' );



	/**
	 * Remove default name fields from checkout
	 */
	function keel_edd_remove_names() {
		remove_action( 'edd_purchase_form_after_user_info', 'edd_user_info_fields' );
	}
	add_action( 'init', 'keel_edd_remove_names' );



	/**
	 * Remove name fields from checkout form
	 */
	function keel_edd_user_info_fields() {
		if( is_user_logged_in() ) :
			$user_data = get_userdata( get_current_user_id() );
		endif;
		?>
		<fieldset id="edd_checkout_user_info">
			<?php do_action( 'edd_purchase_form_before_email' ); ?>
			<p id="edd-email-wrap">
				<label class="edd-label" for="edd-email"><strong><?php _e('Email Address', 'edd'); ?></strong></label>
				<input class="edd-input required" type="email" name="edd_email" placeholder="<?php _e('Email address', 'edd'); ?>" id="edd-email" value="<?php echo is_user_logged_in() ? $user_data->user_email : ''; ?>"/>
			</p>
			<?php do_action( 'edd_purchase_form_after_email' ); ?>
			<?php do_action( 'edd_purchase_form_user_info' ); ?>
		</fieldset>
		<?php
	}
	add_action( 'edd_purchase_form_after_user_info', 'keel_edd_user_info_fields' );



	/**
	 * Only allow a single item at checkout
	 */
	function keel_edd_force_single_item_cart() {
		edd_empty_cart();
		return edd_get_cart_contents();
	}
	// add_filter( 'edd_add_to_cart', 'keel_edd_force_single_item_cart', 1, 1 );



	/**
	 * Only load PayPal JS and CSS on checkout page
	 */
	function keel_edd_only_load_files_on_checkout() {
		if ( is_page( 'checkout' ) ) return;
		wp_dequeue_style( 'pal-for-edd' );
		wp_dequeue_script( 'pal-for-edd' );
		wp_dequeue_script( 'pal-for-eddpaypal_for_edd_blockUI' );
	}
	add_action( 'wp_enqueue_scripts', 'keel_edd_only_load_files_on_checkout' );



	/**
	 * Disable purchase button if no JS
	 */
	function keel_edd_no_js_disable_purchase() {
		$label = edd_get_option( 'checkout_label', '' );

		if ( edd_get_cart_total() ) {
			$complete_purchase = ! empty( $label ) ? $label : __( 'Purchase', 'easy-digital-downloads' );
		} else {
			$complete_purchase = ! empty( $label ) ? $label : __( 'Free Download', 'easy-digital-downloads' );
		}

		echo
			'<div id="keel-edd-no-js-purchase-message">' .
				'<em>' . __( 'Please enabled JavaScript to complete your purchase.', 'keel' ) . '</em><br>' .
				'<button class="btn btn-large disabled" disabled="disabled">' . $complete_purchase . '</button>' .
			'</div>';
	}
	add_action( 'edd_purchase_form_after_submit', 'keel_edd_no_js_disable_purchase' );



	/**
	 * Removes the credit card billing address fields
	 */
	function keel_edd_remove_default_fields() {
		remove_action( 'edd_after_cc_fields', 'edd_default_cc_address_fields' );
	}
	// add_action( 'init', 'keel_edd_remove_default_fields' );