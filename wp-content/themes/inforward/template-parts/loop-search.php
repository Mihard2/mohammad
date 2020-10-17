<?php
global $inforward_settings;

$this_post = array();
$this_post['id'] = $id = get_the_ID();
$this_post['link'] = $link = get_permalink();
$this_post['title'] = $title = get_the_title();
$this_post['post_format'] = $format = get_post_format() ? get_post_format() : 'standard';

extract($this_post);

$excerpt_count_blog = $inforward_settings['excerpt-count-big-thumbs'];

$post_content = has_excerpt() ? get_the_excerpt() : get_the_content();
if($title == '') {
	$title = esc_attr__('Read More', 'inforward');
}
?>

<div id="post-<?php echo (int) $id; ?>" <?php post_class( implode( ' ', array('event-item') ) ); ?>>
	
		<div class="cp-entry-attachment entry-attachment">

			<?php inforward_post_thumbnail(); ?>

		</div>

		<div class="event-date">
			<div class="event-month"><?php echo esc_attr(get_the_date( 'M', $id )) ?></div>
			<div class="event-day"><?php echo esc_attr(get_the_date( 'd', $id )) ?></div>
		</div>
		
		<div class="event-info">
			
			<h4 class="cp-post-title event-link">
				<?php if ( is_sticky($id) ): ?>
					<?php printf( '<span class="sticky-post label">%s</span>', esc_html__( 'Featured', 'inforward' ) ); ?>
				<?php endif; ?>
				<a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
			</h4>
		
			<?php echo inforward_blog_post_meta($id, array(
														'author' => true,
														'dates' => false,
														'cat' => true,
														'comments' => true
													)); ?>
													
			<?php 
				if ( has_excerpt($id) ) {
					echo inforward_get_excerpt( $post_content, $excerpt_count_blog );
				} else {
					the_excerpt(); 
				}
			?>										
			
		</div>
</div>
