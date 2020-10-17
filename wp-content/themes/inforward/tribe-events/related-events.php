<?php
/**
 * Related Events Template
 * The template for displaying related events on the single event page.
 *
 * You can recreate an ENTIRELY new related events view by doing a template override, and placing
 * a related-events.php file in a tribe-events/pro/ directory within your theme directory, which
 * will override the /views/pro/related-events.php.
 *
 * You can use any or all filters included in this file or create your own filters in
 * your functions.php. In order to modify or extend a single filter, please see our
 * readme on templates hooks and filters
 *
 * @package TribeEventsCalendarPro
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$posts = tribe_get_related_posts();

if ( is_array( $posts ) && ! empty( $posts ) ) : ?>

<h3 class="tribe-events-related-events-title"><?php printf( wp_kses(__( 'Related %s', 'inforward' ), 'default'), tribe_get_event_label_plural() ); ?></h3>
<div class="events-holder">
<div class="row flex-row tribe-related-events tribe-clearfix">
	<?php foreach ( $posts as $post ) : ?>
     <div class="col-sm-4">
	<div class="event-item">
		<?php $thumb = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail( $post->ID, 'inforward-portfolio-small-image' ) : '<img src="' . esc_url( trailingslashit( Tribe__Events__Pro__Main::instance()->pluginUrl ) . 'src/resources/images/tribe-related-events-placeholder.png' ) . '" alt="' . esc_attr( get_the_title( $post->ID ) ) . '" />'; ?>
		
            <div class="event-img">
                <a href="<?php echo esc_url( tribe_get_event_link( $post ) ); ?>" class="url" rel="bookmark"><?php echo wp_kses_post($thumb) ?></a>
            </div>
        
		<div class="tribe-related-event-info event-info">
			<h5 class="event-link"><a href="<?php echo tribe_get_event_link( $post ); ?>" class="tribe-event-url" rel="bookmark"><b><?php echo get_the_title( $post->ID ); ?></b></a></h5>
			<?php
				if ( $post->post_type == Tribe__Events__Main::POSTTYPE ) {
					echo '<div class="event-desc">';
					echo tribe_events_event_schedule_details( $post );
					echo '</div>';
				}
			?>
		</div>
	</div>
    </div>
	<?php endforeach; ?>
</div>
</div>
<?php
endif;
