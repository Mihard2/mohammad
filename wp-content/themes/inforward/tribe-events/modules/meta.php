<?php
/**
 * Single Event Meta Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta.php
 *
 * @package TribeEventsCalendar
 */

do_action( 'tribe_events_single_meta_before' );

// Check for skeleton mode (no outer wrappers per section)
$not_skeleton = ! apply_filters( 'tribe_events_single_event_the_meta_skeleton', false, get_the_ID() );

// Do we want to group venue meta separately?
$set_venue_apart = apply_filters( 'tribe_events_single_event_the_meta_group_venue', false, get_the_ID() );
?>

<?php
do_action( 'tribe_events_single_event_meta_primary_section_start' );

// Always include the main event details in this first section
echo '<div class="col-md-4 col-sm-12">';
tribe_get_template_part( 'modules/meta/details' );
echo '</div>';

// If we have no map to embed and no need to keep the venue separate...
if ( ! $set_venue_apart && ! tribe_embed_google_map() ) {
	echo '<div class="col-md-4 col-sm-12">';
	tribe_get_template_part( 'modules/meta/venue' );
	echo '</div>';
} elseif ( ! $set_venue_apart && ! tribe_has_organizer() && tribe_embed_google_map() ) {
	// If we have no organizer, no need to separate the venue but we have a map to embed...
	echo '<div class="col-md-4 col-sm-12">';
	tribe_get_template_part( 'modules/meta/venue' );
	echo '</div>';
} else {
	// If the venue meta has not already been displayed then it will be printed separately by default
	$set_venue_apart = true;
}

// Include organizer meta if appropriate
if ( tribe_has_organizer() ) {
	echo '<div class="col-md-4 col-sm-12">';
	tribe_get_template_part( 'modules/meta/organizer' );
	echo '</div>';
}

do_action( 'tribe_events_single_event_meta_primary_section_end' );
?>



<?php if ( $set_venue_apart ) : ?>

	<?php
	
    echo '<div class="col-md-4 col-sm-12">';
	do_action( 'tribe_events_single_event_meta_secondary_section_start' );
	tribe_get_template_part( 'modules/meta/venue' );
	do_action( 'tribe_events_single_event_meta_secondary_section_end' );
    echo '</div>';
	
	?>

<?php
endif;
do_action( 'tribe_events_single_meta_after' );
