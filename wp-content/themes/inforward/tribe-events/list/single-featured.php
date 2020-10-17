<?php
/**
 * List View Single Featured Event
 * This file contains one featured event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-featured.php
 *
 * @version 4.5.6
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// Venue
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();
?>

<div class="col-md-4">

<!-- Event Image -->
<?php echo tribe_event_featured_image( null, 'inforward-portfolio-small-image' ) ?>

</div>

<div class="col-md-8">
<div class="event-info">

	<?php do_action( 'tribe_events_before_the_event_title' ) ?>
	<div class="event-header clearfix">
		<h5 class="event-link f-left">
			<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark" >
			<b><?php the_title() ?></b>
			</a>
		</h5>
		<!-- Event Cost -->
		<?php if ( tribe_get_cost() ) { ?>
			<h6 class="event-price f-right tribe-events-event-cost">
               <span class="ticket-cost"><b><?php echo tribe_get_cost( null, true ); ?></b></span>
			   <?php
				/**
				 * Runs after cost is displayed in list style views
				 *
				 * @since 4.5
				 */
				do_action( 'tribe_events_inside_cost' )
				?>
            </h6> 
		<?php } ?>
		
		<?php do_action( 'tribe_events_after_the_event_title' ) ?>
	</div>

	<!-- Event Meta -->
	<?php do_action( 'tribe_events_before_the_meta' ) ?>
	<div class="tribe-events-event-meta event-desc">
		<div class="author <?php echo esc_attr( $has_venue_address ); ?>">

			<!-- Schedule & Recurrence Details -->
			<div class="tribe-event-schedule-details">
				<?php echo tribe_events_event_schedule_details() ?>
			</div>

			<?php if ( $venue_details ) : ?>
				<!-- Venue Display Info -->
				<div class="tribe-events-venue-details">
				<?php
					$address_delimiter = empty( $venue_address ) ? ' ' : ', ';

					// These details are already escaped in various ways earlier in the process.
					echo implode( $address_delimiter, $venue_details );

					if ( tribe_show_google_map_link() ) {
						echo tribe_get_map_link_html();
					}
				?>
				</div> <!-- .tribe-events-venue-details -->
			<?php endif; ?>

		</div>
	</div><!-- .tribe-events-event-meta -->	

	<?php do_action( 'tribe_events_after_the_meta' ) ?>

	<?php do_action( 'tribe_events_before_the_content' ); ?>
					
		<div class="tribe-events-event-description">
        
		<?php echo tribe_events_get_the_excerpt() ?>
       
		</div><!-- .tribe-events-map-event-description -->

		<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="tribe-events-read-more info-btn" rel="bookmark">
		<?php esc_html_e( 'Find out more', 'inforward' ) ?>
		</a>
		
		<?php do_action( 'tribe_events_after_the_content' ); ?>
		
</div>
</div>
