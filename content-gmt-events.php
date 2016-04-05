<?php

/**
 * content-gmt-events.php
 * Template for events content.
 */

?>

<?php

	// Values
	$details = get_post_meta( $post->ID, 'event_details', true );
	$start_date = get_post_meta( $post->ID, 'event_start_date', true );
	$end_date = get_post_meta( $post->ID, 'event_end_date', true );

	// Dates
	$today = strtotime( 'today', current_time( 'timestamp' ) );
	$date = '';
	if ( !empty( $start_date ) && !empty( $end_date ) && $start_date !== $end_date ) {
		$date = date( 'F j', $start_date ) . ' &ndash; ' . date( 'j', $end_date ) . ', ' . date( 'Y', $start_date );
	} elseif ( !empty( $start_date ) ) {
		$date = date( 'l, F j, Y', $start_date );
	}

?>

<?php
	/**
	 * Individual Posts
	 */
	if ( is_single() ) :
?>

	<article>

		<header>
			<h1><?php the_title(); ?></h1>
		</header>

		<?php the_content(); ?>

		<?php if ( !empty( $date ) || !empty( $details['time_start_hour'] ) || !empty( $details['location'] ) ) : ?>
			<p>
				<?php if ( !empty( $date ) ) : ?>
					<strong>Date:</strong> <?php echo esc_html( $date ); ?>
				<?php endif; ?>

				<?php if ( !empty( $date ) && ( !empty( $details['time_start_hour'] ) || !empty( $details['location'] ) ) ) : ?><br><?php endif; ?>

				<?php if ( !empty( $details['time_start_hour'] ) ) : ?>
					<strong>Time:</strong>
						<?php echo esc_html( $details['time_start_hour'] ) . ( $details['time_start_minutes'] === '00' ? '' : ':' . esc_html( $details['time_start_minutes'] ) ) . esc_html( $details['time_start_ampm'] ); ?>

						<?php if ( !empty( $details['time_end_hour'] ) ) : ?>
							&ndash;
							<?php echo esc_html( $details['time_end_hour'] ) . ( $details['time_end_minutes'] === '00' ? '' : ':' . esc_html( $details['time_end_minutes'] ) ) . esc_html( $details['time_end_ampm'] ); ?>
						<?php endif; ?>

						<?php if ( !empty( $details['timezone'] ) ) : ?>
							<?php echo esc_html( $details['timezone'] ); ?>
						<?php endif; ?>
				<?php endif; ?>

				<?php if ( !empty( $details['time_start_hour'] ) && !empty( $details['location'] ) ) : ?><br><?php endif; ?>

				<?php if ( !empty( $details['location'] ) ) : ?>
					<strong>Location:</strong> <?php echo esc_html( $details['location'] ); ?>
				<?php endif; ?>

			</p>
		<?php endif; ?>

		<?php if ( $start_date >= $today ) : ?>

			<?php echo do_shortcode( wpautop( $details['register_html'] ) ); ?>

			<?php if ( $details['register_link'] ) : ?>
				<p>
					<a class="btn" href="<?php esc_url( $details['register_link'] ); ?>"><?php echo esc_html( $details['register_label'] ); ?></a>
				</p>
			<?php endif; ?>

		<?php endif; ?>

		<?php
			// Add link to edit pages
			edit_post_link( __( 'Edit', 'keel' ), '<p>', '</p>' );
		?>

	</article>

<?php
	/**
	 * All Posts
	 */
	else :
?>

	<?php
		// Variables
		global $show_keel_events_header_future, $show_keel_events_header_past;
		$options = events_get_theme_options();
	?>

	<?php
		// Add header
		if ( $show_keel_events_header_future && $start_date >= $today ) :
			$show_keel_events_header_future = false;
	?>
		<h2><?php echo esc_html( $options['heading_future'] ); ?></h2>
	<?php
		elseif ( $show_keel_events_header_past && $start_date < $today ) :
			$show_keel_events_header_past = false;
	?>
		<h2><?php echo esc_html( $options['heading_past'] ); ?></h2>
	<?php endif; ?>

	<article class="margin-bottom">

		<a class="link-block" href="<?php the_permalink(); ?>">
			<header>
				<h3 class="h5 link-block-styled no-padding-top no-margin-bottom"><?php the_title(); ?></h3>
			</header>

			<aside>
				<?php echo esc_html( $date ); ?>

				<?php if ( !empty( $date ) && !empty( $details['location'] ) ) : ?>, <?php endif; ?>

				<?php echo esc_html( $details['location'] ); ?>
			</aside>
		</a>
		<?php
			// Add link to edit pages
			edit_post_link( __( 'Edit', 'keel' ), '<p>', '</p>' );
		?>

	</article>

<?php endif; ?>