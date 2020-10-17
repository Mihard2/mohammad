<?php
/**
 * Map View Nav
 * This file contains the map view navigation.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/pro/map/nav.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_plural = tribe_get_event_label_plural();

?>

<h3 class="tribe-events-visuallyhidden"><?php printf( wp_kses(__( '%s List Navigation', 'inforward' ), 'default'), $events_label_plural ); ?></h3>
<ul class="tribe-events-sub-nav">
	<?php if ( tribe_has_previous_event() ) : ?>
		<!-- Display Previous Page Navigation -->
		<li class="tribe-events-nav-previous">
			<a href="#" class="tribe_map_paged"><?php printf( wp_kses(__( '<span>&laquo;</span> Previous %s', 'inforward' ), 'default'), $events_label_plural ); ?></a>
		</li>
	<?php endif; ?>

</ul>
