
<?php
$id = get_the_ID();
$image_size = array(360,260);
$tags = wp_get_post_tags($id);
$numberposts = 3;
$column_class = 'col-xs-4';
$counter=0;
$query = array(
		'post_type' => 'post',
		'numberposts' => $numberposts,
		'ignore_sticky_posts'=> 1,
		'post__not_in' => array($id)
	);
	
if (!empty($tags) && is_array($tags)) {
	foreach ($tags as $tag ) {
		$tag_ids[] = (int) $tag->term_id;
	}
}
if (!empty($tag_ids)) {
	$query['tag__in'] = $tag_ids;
}
$entries = get_posts($query);

if (empty($entries)) return;
?>

<div class="related-news">

	<h4 class="related-news-title" ><?php echo esc_html__('Related News', 'inforward'); ?></h4>
	
    <div class="events-holder type-2 small-events">
	<div class="row">
	
	<?php foreach($entries as $post): setup_postdata($post); ?>
		<?php
		$related_id = get_the_ID();
		$title = get_the_title($related_id);
		$related_link = get_permalink($related_id);
		$comments_count = get_comments_number($related_id);
		$post_thumbnail = get_post_thumbnail_id($related_id);
		
		if (isset($post_thumbnail) && $post_thumbnail > 0) {
			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($related_id), '');
			if (is_array($thumbnail) && isset($thumbnail[0])) {
				$thumbnail = $thumbnail[0];
			}
		}
		
		$thumbnail_atts = array(
			'class'	=> "tr_all",
			'alt'	=> esc_attr($title),
			'title'	=> esc_attr($title),
		);
	    ?>
		
		<div class="<?php echo esc_attr($column_class) ?>"> 
		<div class="event-item">
		
			<div class="entry-attachment-related">
			<a class="cp-related-thumb" href="<?php echo esc_url(get_permalink($related_id)); ?>">
				<?php 
				if (isset($post_thumbnail) && $post_thumbnail > 0) {
				echo Inforward_Helper::get_the_post_thumbnail( $related_id, $image_size, true, '', $thumbnail_atts );
				}
				?>
			</a>
			</div>
			
			<div class="event-info">
            
            	<h6 class="event-link"><a href="<?php echo esc_url(get_permalink($related_id)) ?>"><?php echo esc_html($title) ?></a></h6>
				
                <div class="entry-meta">
                <time class="entry-date" datetime="<?php echo esc_attr(get_the_date(DATE_W3C, $related_id)); ?>"><?php echo esc_html(get_the_date('', $related_id)); ?></time>
                <?php
					printf( '<span class="entry-byline">%1$s<a href="%2$s">%3$s</a></span>',
						esc_attr__('by ','inforward'),
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);
				?>
                </div>

			</div>
		
		</div>
        </div>
		
	<?php 
	$counter++;
	endforeach; ?>
	
	<?php wp_reset_postdata(); ?>
	</div>
    </div>
</div>