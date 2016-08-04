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
	 * Add custom personal info checkout fields
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
	add_filter( 'edd_add_to_cart', 'keel_edd_force_single_item_cart', 1, 1 );



	/**
	 * Only load PayPal JS and CSS on checkout page
	 */
	function keel_only_load_files_on_checkout() {
		if ( is_page( 'checkout' ) ) return;
		wp_dequeue_style( 'pal-for-edd' );
		wp_dequeue_script( 'pal-for-edd' );
		wp_dequeue_script( 'pal-for-eddpaypal_for_edd_blockUI' );
	}
	add_action( 'wp_enqueue_scripts', 'keel_only_load_files_on_checkout' );