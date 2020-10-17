<?php
/**
 * Single Event Template for Widgets
 *
 * This template is used to render single events for both the calendar and advanced
 * list widgets, facilitating a common appearance for each as standard.
 *
 * You can override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/pro/widgets/modules/single-event.php
 *
 * @version 4.4.3
 *
 * @package TribeEventsCalendarPro
 */

$mini_cal_event_atts = tribe_events_get_widget_event_atts();

$post_date = tribe_events_get_widget_event_post_date();
$post_id   = get_the_ID();

$organizer_ids = tribe_get_organizer_ids();
$multiple_organizers = count( $organizer_ids ) > 1;

$city_name   = ! empty( $city ) ? tribe_get_city() : '';
$region_name = ! empty( $region ) ? tribe_get_region() : '';
$zip_text    = ! empty( $zip ) ? tribe_get_zip() : '';

$has_address_details = ! empty( $city_name ) || ! empty( $region_name ) || ! empty( $zip_text );
?>

<div class="tribe-mini-calendar-event event-<?php echo esc_attr( $mini_cal_event_atts['current_post']); ?> <?php echo esc_attr( $mini_cal_event_atts['class'] ); ?>">
	<?php
	if (
		tribe( 'tec.featured_events' )->is_featured( $post_id )
		&& get_post_thumbnail_id( $post_id )
	) {
		/**
		 * Fire an action before the list widget featured image
		 */
		do_action( 'tribe_events_list_widget_before_the_event_image' );

		/**
		 * Allow the default post thumbnail size to be filtered
		 *
		 * @param $size
		 */
		$thumbnail_size = apply_filters( 'tribe_events_list_widget_thumbnail_size', 'post-thumbnail' );
		?>
		<div class="tribe-event-image">
			<?php the_post_thumbnail( $thumbnail_size ); ?>
		</div>
		<?php

		/**
		 * Fire an action after the list widget featured image
		 */
		do_action( 'tribe_events_list_widget_before_the_event_image' );
	}
	?>

	<div class="event-date">
		<?php
		if (
			isset( $instance['tribe_is_list_widget'] )
			&& date( 'm', $post_date ) != date( 'm', current_time( 'timestamp' ) )
		) :
			?>
			 <div class="event-month">
				<?php
				echo apply_filters(
					'tribe-mini_helper_tribe_events_ajax_list_dayname',
					date_i18n( 'M', $post_date ),
					$post_date,
					$mini_cal_event_atts['class']
				);
				?>
			</div>
		<?php else: ?>
			<div class="event-month">
				<?php
				echo apply_filters(
					'tribe-mini_helper_tribe_events_ajax_list_dayname',
					date_i18n( 'D', $post_date ),
					$post_date,
					$mini_cal_event_atts['class']
				);
				?>
			</div>
		<?php endif; ?>

		<div class="event-day"><?php echo apply_filters( 'tribe-mini_helper_tribe_events_ajax_list_daynumber',
			date_i18n( 'd', $post_date ), $post_date, $mini_cal_event_atts['class'] ); ?></div>
	</div>

		<div class="list-info event-info">
			<?php do_action( 'tribe_events_list_widget_before_the_event_title' ); ?>
			<h6 class="tribe-events-title event-link">
					<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h6>
			<?php do_action( 'tribe_events_list_widget_after_the_event_title' ); ?>

			<?php do_action( 'tribe_events_list_widget_before_the_meta' ) ?>

			<div class="tribe-events-duration event-info-item">
				<i class="icon icon-clock"></i>
				<?php echo tribe_get_start_date( null, false, 'h:i a' ) ?> - <?php echo tribe_get_end_date( null, false, 'h:i a' ) ?>
			</div>

			<?php if ( isset( $cost ) && $cost && tribe_get_cost() != '' ) : ?>
				<span class="tribe-events-divider">|</span>
				<div class="tribe-events-event-cost">
					<?php echo tribe_get_cost( null, true ); ?>
				</div>
			<?php endif ?>

			<!-- // Price, Venue Name, Address, City, State or Province, Postal Code, Country, Venue Phone, Organizer Name-->
			<?php ob_start(); ?>
            
            
			<?php if ( isset( $venue ) && $venue && tribe_get_venue() != '' ) : ?>
				<span class="tribe-events-venue"><?php echo tribe_get_venue_link(); ?></span>
			<?php endif ?>

			<?php if ( isset( $address ) && $address && tribe_get_address() != '' ): ?>
				<div class="tribe-street-address"><?php echo tribe_get_address(); ?></div>
			<?php endif ?>

			<?php
			if ( $has_address_details ) : ?>
				<div>
					<?php if ( ! empty( $city_name ) ) : ?>
						<span class="tribe-events-locality"><?php echo esc_html( $city_name ); ?></span>
					<?php endif ?>

					<?php if ( ! empty( $region_name ) ) : ?>
						<span class="tribe-events-region"><?php echo esc_html( $region_name ); ?></span>
					<?php endif ?>

					<?php if ( ! empty( $zip_text ) ) : ?>
						<span class="tribe-events-postal-code"><?php echo esc_html( $zip_text ); ?></span>
					<?php endif ?>
				</div>
			<?php endif; ?>

			<?php if ( isset( $country ) && $country && tribe_get_country() != '' ) : ?>
				<div class="tribe-country-name"><?php echo tribe_get_country(); ?></div>
			<?php endif ?>

			<?php if ( isset( $phone ) && $phone && tribe_get_phone() != '' ) : ?>
				<span class="tribe-events-tel"><?php echo tribe_get_phone(); ?></span>
			<?php endif ?>

			<?php if ( $location = trim( ob_get_clean() ) ) : ?>
				<div class="tribe-events-location tribe-section-s event-info-item">
					<i class="icon icon-location"></i><?php echo wp_kses_post($location); ?>
				</div>
			<?php endif; ?>

			<?php ob_start(); ?>
			<?php if ( isset( $organizer ) && $organizer && ! empty( $organizer_ids ) ) : ?>
				<span class="tribe-events-organizer">
					<?php echo tribe_get_organizer_label( ! $multiple_organizers ); ?>:
					<?php
					$organizer_links = array();
					foreach ( $organizer_ids as $organizer_id ) {
						if ( ! $organizer_id ) {
							continue;
						}

						$organizer_link = tribe_get_organizer_link( $organizer_id, true );

						$organizer_phone = tribe_get_organizer_phone( $organizer_id );
						if ( ! empty( $organizer_phone ) ) {
							$organizer_link .= '<div class="tribe-events-tel">' . $organizer_phone . '</div>';
						}

						$organizer_links[] = $organizer_link;
					}// end foreach

					$and = _x( 'and', 'list separator for final two elements', 'inforward' );
					if ( 1 == count( $organizer_links ) ) {
						echo wp_kses_post($organizer_links[0]);
					} elseif ( 2 == count( $organizer_links ) ) {
						echo wp_kses_post($organizer_links[0]) . ' ' . esc_html( $and ) . ' ' . wp_kses_post($organizer_links[1]);
					} else {
						$last_organizer = array_pop( $organizer_links );

						echo implode( ', ', $organizer_links );
						echo esc_html( ', ' . $and . ' ' );
						echo wp_kses_post($last_organizer);
					}// end else
					?>
				</span>
			<?php endif ?>
			<?php if ( $organizers = trim( ob_get_clean() ) ) : ?>
				<div class="tribe-events-organizer tribe-section-s event-info-item">
					<i class="icon icon-location"></i><?php echo wp_kses_post($organizers); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php do_action( 'tribe_events_list_widget_after_the_meta' ) ?>
</div> <!-- .list-info -->
