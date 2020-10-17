<?php
global $inforward_settings;

$this_post = array();
$this_post['id'] = $id = get_the_ID();
$this_post['link'] = $link = get_permalink();
$this_post['title'] = $title = get_the_title();
$this_post['post_format'] = $format = get_post_format() ? get_post_format() : 'standard';

extract($this_post);

$post_content = has_excerpt() ? get_the_excerpt() : get_the_content();
if($title == '') {
	$title = esc_attr__('Read More', 'inforward');
}
?>

<div id="post-<?php echo (int) $id; ?>" <?php post_class( implode( ' ', array('event-item index-item') ) ); ?>>


		<div class="entry-attachment">

			<?php inforward_post_thumbnail(); ?>

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
					'dates' => true,
					'cat' => true,
					'comments' => true
				)); ?>
			
			<div class="cp-entry-content">
			<?php 
				echo apply_filters( 'the_content', $post_content );
				wp_link_pages(array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'inforward' ) . ':</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '%',
					'separator'   => ''
				));
			?>	
			
			
			</div>
			<a href="<?php echo esc_url($link) ?>" class="info-btn cp-continue-reading-link"><?php echo esc_html__('Read More','inforward') ?></a>
			
			
		</div>

	</div>

