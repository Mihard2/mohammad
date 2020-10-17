<?php
    $next_post = get_next_post();
    $prev_post = get_previous_post();
    $next_post_url = $prev_post_url = "";
	$next_post_title = $prev_post_title = "";
	$col_class = 'col-xs-6';
    if ( is_object($next_post) ) {
        $next_post_url = get_permalink($next_post->ID);
        $next_post_title = $next_post->post_title;
    }
    if ( is_object($prev_post) ) {
        $prev_post_url = get_permalink($prev_post->ID);
		$prev_post_title = $prev_post->post_title;
    }
	if ( empty($prev_post_url) || empty($next_post_url) ) {
		$col_class = 'col-xs-12';
	}
?>

<?php if ( !empty($prev_post_url) || !empty($next_post_url) ): ?>

<div class="content-element2">
	<div class="cp-entries-nav entries-nav">
    <div class="row">

		<?php if ( !empty($prev_post_url) ): ?>

			<?php if ( empty($prev_post_title) ): ?>
				<?php $prev_post_title = esc_html__('No Title', 'inforward') ?>
			<?php endif; ?>
           	 <div class="<?php echo esc_attr($col_class); ?>">
                      
                  <a href="<?php echo esc_url($prev_post_url) ?>" class="info-btn prev-btn"><?php echo esc_html__('Previous Post', 'inforward'); ?></a>
                  <h6><a href="<?php echo esc_url($prev_post_url) ?>"><b><?php echo esc_html($prev_post_title); ?></b></a></h6>
              
                </div>

		<?php endif; ?>

		<?php if (!empty($next_post_url)): ?>

			<?php if ( empty($next_post_title) ): ?>
				<?php $next_post_title = esc_html__('No Title', 'inforward') ?>
			<?php endif; ?>
            
            <div class="<?php echo esc_attr($col_class); ?>">
                      
                      <div class="align-right">
                        <a href="<?php echo esc_url($next_post_url) ?>" class="info-btn next-btn"><?php echo esc_html__('Next Post', 'inforward'); ?></a>
                        <h6><a href="<?php echo esc_url($next_post_url) ?>"><b><?php echo esc_html($next_post_title); ?></b></a></h6>
                      </div>
                  
            </div>
			
		<?php endif; ?>
	</div>
	</div>
</div>
<?php endif; ?>