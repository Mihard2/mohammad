<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version  4.3
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();
$event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single">

	<?php tribe_the_notices() ?>

		<div class="event-nav">
          <div class="flex-row flex-justify">
           <a href="<?php echo esc_url( tribe_get_events_link() ); ?>" class="info-btn prev-btn"><?php printf( esc_html_x( 'All %s', '%s Events plural label', 'inforward' ), $events_label_plural ); ?></a>
                
           <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
         </div>
        </div>

	<?php while ( have_posts() ) :  the_post(); 
	$id = get_the_ID();
	$start_time = tribe_get_start_date( $id, false, 'M d h:i A' );
	$end_time = tribe_get_end_date( $id, false, 'M d h:i A' );
	?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('event-item single-event'); ?>>
			
           <div class="event-info">
        
                  <div class="event-header clearfix">
                  <?php the_title( '<h3 class="event-link f-left">', '</h3>' ); ?>
                    <?php if ( tribe_get_cost() ) : ?>
                    <h5 class="event-price f-right tribe-events-cost"><b><?php echo tribe_get_cost( null, true ) ?></b></h5>
                    <?php endif; ?>
                  </div>
                  <div class="event-desc">
					 <span><?php echo esc_attr($start_time); ?> - <?php echo esc_attr($end_time); ?></span>
                  </div>
                  
           </div>
                
            <div class="content-element5"> 
            
                  <div class="row">
                  
                        <div class=" <?php if ( tribe_embed_google_map() ) { echo 'col-md-8'; } else { echo 'col-md-12'; } ?> col-sm-12"> 
                        <?php echo tribe_event_featured_image( $event_id, 'inforward-post-grid', false ); ?>
                         </div>
                         
                          <?php if ( tribe_embed_google_map() ) { ?>
                          <div class="col-md-4 col-sm-12">
                          <div class="map-section">
                          <?php tribe_get_template_part( 'modules/meta/map' ); ?>
                          </div>
                          </div>
                          <?php } ?>
                
                 </div>
                <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
                <div class="tribe-events-single-event-description tribe-events-content">
                    <?php the_content(); ?>
                </div>
			</div>

			
		</div>
		
		 <div class="content-element3">
          <div class="row">
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		  </div>
        </div>
        
        <?php if ( function_exists('inforward_content_share') ): ?>
         <div class="content-element2">
            <?php inforward_content_share(); ?>
         </div>
        <?php endif; ?>
		
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<div id="tribe-events-footer" class="entries-nav content-element" >
		<h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'inforward' ), $events_label_singular ); ?></h3>
		
        <div class="page-nav">
        <div class="flex-row flex-justify">
			<div class="tribe-events-nav-previous"><?php tribe_the_prev_event_link('<span class="info-btn prev-btn">%title%</span>' ) ?></div>
			<div class="tribe-events-nav-next"><?php tribe_the_next_event_link( '<span class="info-btn next-btn">%title%</span>' ) ?></div>
		</div>
        </div>
        
	</div>

    <div class="single_event_related">
    <?php do_action( 'tribe_events_single_event_related' ) ?>
    </div>

</div>