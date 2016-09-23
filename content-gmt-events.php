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

	// Configure date
	if ( !empty( $start_date ) && !empty( $end_date ) && $start_date !== $end_date ) {
		if ( date( 'F', $start_date ) === date( 'F', $end_date ) ) {
			// If there's a start and end date, and they're in the same month
			$date = date( 'F j', $start_date ) . '&ndash;' . date( 'j', $end_date ) . ', ' . date( 'Y', $start_date );
		} else {
			// If there's a start and end date, in different months
			$date = date( 'F j', $start_date ) . '&ndash;' . date( 'F j', $end_date ) . ', ' . date( 'Y', $start_date );
		}
	} elseif ( !empty( $start_date ) ) {
		// If there's a start date
		$date = date( 'F j, Y', $start_date );

		// If there's a start time
		if ( !empty( $details['time_start_hour'] ) && $start_date >= $today ) {
			$date .= ' at ' . esc_html( $details['time_start_hour'] ) . ( $details['time_start_minutes'] === '00' ? '' : ':' . esc_html( $details['time_start_minutes'] ) ) . esc_html( $details['time_start_ampm'] );
		}

		// If there's an end time
		if ( !empty( $details['time_end_hour'] ) && $start_date >= $today ) {
			$date .= '&ndash;' . esc_html( $details['time_end_hour'] ) . ( $details['time_end_minutes'] === '00' ? '' : ':' . esc_html( $details['time_end_minutes'] ) ) . esc_html( $details['time_end_ampm'] );
		}

		// If there's a timezone
		if ( !empty( $details['timezone'] ) && $start_date >= $today ) {
			$date .= ' ' . esc_html( $details['timezone'] );
		}

	}

	// Create materials links
	$materials = array();
	if ( !empty( $details['video'] ) ) $materials['Video'] = $details['video'];
	if ( !empty( $details['slides'] ) ) $materials['Slides'] = $details['slides'];
	if ( !empty( $details['audio'] ) ) $materials['Audio'] = $details['audio'];
	if ( !empty( $details['downloads'] ) ) $materials['Downloads'] = $details['downloads'];
	if ( !empty( $details['post'] ) ) $materials['Post'] = $details['post'];

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

			<?php echo do_shortcode( wpautop( $details['register_html'], false ) ); ?>

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
		<header>
			<h3 class="h5 no-padding-top no-margin-bottom">
				<?php
					// If there's a location provided, link to it
					if ( !empty( $details['register_link'] ) ) :
				?>
					<a href="<?php echo esc_url( $details['register_link'] ); ?>">
						<?php the_title(); ?>
					</a>
				<?php
					// Otherwise, just use the title
					else :
				?>
					<?php the_title(); ?>
				<?php endif; ?>
				<?php
					// Add link to edit pages
					edit_post_link( __( 'Edit', 'keel' ), '&ndash; ', '' );
				?>
			</h3>
		</header>

		<p <?php if ( !empty( $materials ) && $start_date < $today ) { echo 'class="no-margin-bottom"'; } ?>>
			<?php
				// If there's a location, add it
				if ( !empty( $details['location'] ) ) :
			?>
				<em><?php echo stripslashes( esc_html( $details['location'] ) ); ?></em>
			<?php endif; ?>

			<?php if ( !empty( $details['location'] ) && !empty( $date ) ) : ?>
				<br>
			<?php endif; ?>

			<?php
				// If there's a date, add it
				if ( !empty( $date ) ) :
			?>
				<?php echo $date; ?>
			<?php endif; ?>
		</p>

		<?php
			// If there are linked materials, add them
			if ( !empty( $materials ) && $start_date < $today ) :
		?>
			<ul class="list-inline">
				<?php foreach ( $materials as $key => $material ) : ?>
					<li>
						<a href="<?php echo esc_url( $material ); ?>">
							<?php echo $key; ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</article>

<?php endif; ?>