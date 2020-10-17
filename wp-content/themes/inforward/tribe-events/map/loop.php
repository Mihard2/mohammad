<?php
/**
 * Map View Loop
 * This file sets up the structure for the map view events loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/pro/map/loop.php
 *
 * @version 4.4
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php

global $more;
$more = false;

?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php do_action( 'tribe_events_inside_before_loop' ); ?>

	<!-- Event  -->
	<div id="post-<?php the_ID() ?>" class="event-item <?php tribe_events_event_classes() ?>">
    <div class="row">
		<?php
		$event_type = tribe( 'tec.featured_events' )->is_featured( get_the_ID() ) ? 'featured' : 'event';

		/**
		 * Filters the event type used when selecting a template to render
		 *
		 * @param $event_type
		 */
		$event_type = apply_filters( 'tribe_events_map_view_event_type', $event_type );

		tribe_get_template_part( 'pro/map/single', $event_type );
		?>
	</div>
    </div>

	<?php do_action( 'tribe_events_inside_after_loop' ); ?>
<?php
endwhile;
