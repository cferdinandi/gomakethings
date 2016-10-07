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
	add_action( 'init', 'keel_edd_remove_default_fields' );



	/**
	 * Adds in only the required credit card address fields
	 * @link https://easydigitaldownloads.com/forums/topic/can-i-remove-billing-details-from-checkout-page/#post-445013
	 */
	function keel_edd_default_cc_address_fields() {
		ob_start(); ?>
		<fieldset id="edd_cc_address" class="cc-address">
			<span><legend><?php _e( 'Billing Details', 'edd' ); ?></legend></span>
			<?php do_action( 'edd_cc_billing_top' ); ?>
			<p id="edd-card-zip-wrap">
				<label for="card_zip" class="edd-label">
					<?php _e( 'Billing Zip / Postal Code', 'edd' ); ?>
					<?php if( edd_field_is_required( 'card_zip' ) ) { ?>
						<span class="edd-required-indicator">*</span>
					<?php } ?>
				</label>
				<span class="edd-description"><?php _e( 'The zip or postal code for your billing address.', 'edd' ); ?></span>
				<input type="text" size="4" name="card_zip" class="card-zip edd-input required" placeholder="<?php _e( 'Zip / Postal code', 'edd' ); ?>" value="<?php echo $zip; ?>"/>
			</p>

			<p id="edd-card-country-wrap">
				<label for="billing_country" class="edd-label">
					<?php _e( 'Billing Country', 'edd' ); ?>
					<?php if( edd_field_is_required( 'billing_country' ) ) { ?>
						<span class="edd-required-indicator">*</span>
					<?php } ?>
				</label>
				<span class="edd-description"><?php _e( 'The country for your billing address.', 'edd' ); ?></span>
				<select name="billing_country" id="billing_country" class="billing_country edd-select<?php if( edd_field_is_required( 'billing_country' ) ) { echo ' required'; } ?>">
					<?php
					$selected_country = edd_get_shop_country();
					if( $logged_in && ! empty( $user_address['country'] ) && '*' !== $user_address['country'] ) {
						$selected_country = $user_address['country'];
					}
					$countries = edd_get_country_list();
					foreach( $countries as $country_code => $country ) {
					  echo '<option value="' . esc_attr( $country_code ) . '"' . selected( $country_code, $selected_country, false ) . '>' . $country . '</option>';
					}
					?>
				</select>
			</p>

			<?php do_action( 'edd_cc_billing_bottom' ); ?>
		</fieldset>
		<?php
		echo ob_get_clean();
	}
	add_action( 'edd_after_cc_fields', 'keel_edd_default_cc_address_fields' );