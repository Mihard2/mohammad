<?php
/**
 * Map View Single Featured Event
 * This file contains one featured event in the map
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/pro/map/single-featured.php
 *
 * @version 4.4
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

global $post;

$venue_details = tribe_get_venue_details();

// Venue microformats
$has_venue         = ( $venue_details ) ? ' vcard' : '';
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';
?>

<div class="col-md-4">

<!-- Event Image -->
<?php echo tribe_event_featured_image( null, 'inforward-portfolio-small-image' ) ?>

</div>

<div class="col-md-8">
<div class="event-info">

    <!-- Event Title -->
    <?php do_action( 'tribe_events_before_the_event_title' ) ?>
    
    <div class="event-header clearfix">
        <!-- Event Distance -->
        <?php echo tribe_event_distance(); ?>
        
        <h5 class="tribe-events-map-event-title event-link f-left">
            <a class="tribe-event-url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title() ?>" rel="bookmark">
                <b><?php the_title() ?></b>
            </a>
        </h5>
        
        	<!-- Event Cost -->
			<?php if ( tribe_get_cost() ) : ?>
            <h6 class="event-price f-right tribe-events-event-cost">
               <b><?php echo tribe_get_cost( null, true ); ?></b>
            </h6>   
            <?php endif; ?>
        
        <?php do_action( 'tribe_events_after_the_event_title' ) ?>
    </div>

	<!-- Event Meta -->
	<?php do_action( 'tribe_events_before_the_meta' ) ?>
    <div class="tribe-events-event-meta event-desc <?php echo esc_attr( $has_venue . $has_venue_address ); ?>">
    
        <!-- Schedule & Recurrence Details -->
        <div class="published time-details">
            <?php echo tribe_events_event_schedule_details() ?>
        </div>
    
        <?php if ( $venue_details ) : ?>
            <!-- Venue Display Info -->
            <div class="tribe-events-venue-details">
                <?php echo implode( ', ', $venue_details ); ?>
            </div> <!-- .tribe-events-venue-details -->
        <?php endif; ?>
    
    </div><!-- .tribe-events-event-meta -->
    <?php do_action( 'tribe_events_after_the_meta' ) ?>

    <!-- Event Content -->
    <?php do_action( 'tribe_events_before_the_content' ) ?>
    <div class="tribe-events-map-event-description tribe-events-content description entry-summary">
        
		<?php echo tribe_events_get_the_excerpt() ?>
       
    </div><!-- .tribe-events-map-event-description -->
     <a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="tribe-events-read-more info-btn" rel="bookmark"><?php esc_html_e( 'Find out more', 'inforward' ) ?></a>
    <?php
    do_action( 'tribe_events_after_the_content' ); 
	?>

</div>
</div>
