
<?php
$id = get_the_ID();
$image_size = array(360,260);
$tags = wp_get_post_tags($id);
$numberposts = 3;
$column_class = 'three-collumn';
$data_rel = 'data-fancybox=group';
$cur_terms = get_the_terms( $id, 'portfolio_categories' );
$counter=0;
$query = array(
		'post_type' => 'portfolio',
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

<div class="related-portfolio content-element">

	<h4 class="related-portfolio-title" ><?php echo esc_html__('Related Portfolio', 'inforward'); ?></h4>
	
    <div class="<?php echo esc_attr($column_class) ?> portfolio-holder">
	
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
		
        <div class="item">
        <div class="project">
        	<div class="project-image">
				<?php echo Inforward_Helper::get_the_post_thumbnail( $related_id, $image_size, true, array(), $thumbnail_atts ); ?>
                <a title="<?php echo esc_attr($title) ?>"  class="project-link project-action fancybox" <?php echo esc_attr($data_rel) ?> href="<?php echo Inforward_Helper::get_post_featured_image( $related_id, '' ) ?>" ></a>
                
                <div class="overlay">
                    <div class="share-wrap style-2">
                    
                      <span class="share-title"><?php echo esc_html__('Share this', 'inforward'); ?>:</span>
                      <ul class="social-icons share">
                    
                        <li><a href="<?php echo Inforward_Helper::get_post_featured_image( $related_id, '' ) ?>" class="sh-facebook share-facebook" target="_blank" title="<?php if(isset($title)) echo esc_attr($title); ?>"><i class="icon-facebook"></i>Facebook</a></li>
                        <li><a href="<?php echo Inforward_Helper::get_post_featured_image( $related_id, '' ) ?>" class="sh-twitter share-twitter" target="_blank" title="<?php if(isset($title)) echo esc_attr($title); ?>"><i class="icon-twitter"></i>Twitter</a></li>

                      </ul>

                    </div>
                 </div>
            
            </div>
        
        	<div class="project-description">
               	<div class="description-inner">
                <h5 class="project-title"><a href="<?php echo esc_url($related_link) ?>"><?php echo esc_html( $title ) ?></a></h5>
                
                <?php if ( !empty($cur_terms) ): ?>
                <ul class="project-cats">
                  <?php foreach($cur_terms as $cur_term): ?>
                  <li><a href="<?php echo get_term_link( (int) $cur_term->term_id, $cur_term->taxonomy ) ?>"><?php echo esc_html($cur_term->name) ?></a></li>
                  <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                                    
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