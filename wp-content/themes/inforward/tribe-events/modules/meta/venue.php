<?php
/**
 * Single Event Meta (Venue) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/venue.php
 *
 * @package TribeEventsCalendar
 */

if ( ! tribe_get_venue_id() ) {
	return;
}

$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();

?>

<div class="tribe-events-meta-group tribe-events-meta-group-venue">
	<h6 class="event-detail-title"> <?php echo esc_html( tribe_get_venue_label_singular() ) ?> </h6>
	<ul  class="event-detail-list">
		<?php do_action( 'tribe_events_single_meta_venue_section_start' ) ?>

		<li class="flex-row flex-justify">
          <div class="detail-col"><?php echo esc_html__('Venue Name:','inforward') ?></div>
          <div class="detail-col tribe-venue"> <?php echo tribe_get_venue() ?> </div>
        </li>

		<?php if ( tribe_address_exists() ) : ?>
        <li class="flex-row flex-justify">
        	<div class="detail-col"><?php echo esc_html__('Address:','inforward') ?></div>
			<div class="detail-col tribe-venue-location">
				<address class="tribe-events-address">
					<?php echo tribe_get_full_address(); ?>

					<?php if ( tribe_show_google_map_link() ) : ?>
						<?php echo tribe_get_map_link_html(); ?>
					<?php endif; ?>
				</address>
			</div>
         </li> 
		<?php endif; ?>

		<?php if ( ! empty( $phone ) ): ?>
        <li class="flex-row flex-justify">
			<div class="detail-col"><?php esc_html_e( 'Phone:', 'inforward' ) ?> </div>
			<div class="detail-col tribe-venue-tel"><?php echo esc_attr($phone) ?> </div>
         </li>     
		<?php endif ?>

		<?php if ( ! empty( $website ) ): ?>
        <li class="flex-row flex-justify">
			<div class="detail-col"><?php esc_html_e( 'Website:', 'inforward' ) ?> </div>
			<div class="detail-col url"><?php echo wp_kses_post($website) ?> </div>
        </li>   
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_venue_section_end' ) ?>
	</ul>
</div>
