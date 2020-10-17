
<?php
global $inforward_settings;
$image = wp_get_attachment_url( get_post_thumbnail_id() );
$permalink = apply_filters('the_permalink', get_the_permalink());
$title = get_the_title();
$extra_attr = 'target="_blank"';
?>

<?php if( is_single() ) { ?>

<div id="share_popup_holder">
    <div class="mad_popup">

		<span class="cp-title"><?php esc_html_e('Share', 'inforward') ?>:</span>

		<div class="social_icon_list">
		<ul class="cp-social-icons social-icons style-2">

				<li class="linkedin-icon"><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($permalink) ?>&amp;title=<?php echo esc_attr($title) ?>" <?php echo wp_kses_post($extra_attr) ?> title="<?php echo esc_html__('LinkedIn', 'inforward') ?>"><i class="icon-linkedin"></i></a></li>
			
				<li class="tumblr-icon"><a href="http://www.tumblr.com/share/link?url=<?php echo esc_url($permalink) ?>&amp;name=<?php echo urlencode($title) ?>&amp;description=<?php echo urlencode(get_the_excerpt()) ?>" <?php echo wp_kses_post($extra_attr) ?> title="<?php echo esc_html__('Tumblr', 'inforward') ?>"><i class="icon-tumblr"></i></a></li>
			
				<li class="tweet-icon"><a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($title) ?>&amp;url=<?php echo esc_url($permalink) ?>" <?php echo wp_kses_post($extra_attr) ?> title="<?php echo esc_html__('Twitter', 'inforward') ?>"><i class="icon-twitter"></i></a></li>
			
				<li class="fb-icon"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($permalink) ?>&amp;p&#091;images&#093;&#091;0&#093;=<?php echo esc_url($image) ?>&amp;p&#091;title&#093;=<?php echo esc_attr($title) ?>" <?php echo wp_kses_post($extra_attr) ?> title="<?php echo esc_html__('Facebook', 'inforward') ?>"><i class="icon-facebook"></i></a></li>
			
				<li class="google-icon"><a href="https://plus.google.com/share?url=<?php echo esc_url($permalink) ?>" <?php echo wp_kses_post($extra_attr) ?> title="<?php echo esc_html__('Google +', 'inforward') ?>"><i class="icon-gplus"></i></a></li>
			
		</ul>
		</div>

    </div>
</div>

<?php } ?>