<?php

class WPBakeryShortCode_VC_mad_share extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'label' => '',
			'show_facebook' => '',
			'show_twitter' => '',
			'show_google' => '',
			'show_pinterest' => '',
			'show_mail' => '',
			'css_animation' => '',
			'type' => 'style-1',
			'animation_delay' => 0,
			'scroll_factor' => ''
		), $atts, 'vc_mad_share');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$label = $type = $show_facebook = $show_twitter = $show_google = $show_pinterest = $show_mail = $output = $class = $css_animation = $animation = $animation_delay = $scroll_factor = "";

		$image = wp_get_attachment_url( get_post_thumbnail_id() );
		$permalink = apply_filters('the_permalink', get_the_permalink());
		$title = get_the_title();
		$extra_attr = 'target="_blank"';
		
		extract($this->atts);

			if ( '' !== $css_animation  ) {
				$animation = Inforward_Helper::create_data_string_animation( $css_animation, $animation_delay, $scroll_factor );
			}

		ob_start();
		
		 
			echo "<div class='wpb_content_element custom_share ' ". $animation .">";
			?>
			<div class="share-wrap <?php echo esc_attr($type) ?>"><span class="share-title"><?php echo esc_html($label) ?></span>

			<ul class="social-icons share">

				<?php if ( $show_facebook ): ?>
					<li><a class="sh-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($permalink) ?>&amp;p&#091;images&#093;&#091;0&#093;=<?php echo esc_url($image) ?>&amp;p&#091;title&#093;=<?php echo esc_attr($title) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-facebook"></i><?php echo esc_html__('Facebook', 'inforward') ?></a></li>
				<?php endif; ?>

				<?php if ( $show_twitter ): ?>
					<li><a class="sh-twitter" href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($title) ?>&amp;url=<?php echo esc_url($permalink) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-twitter"></i><?php echo esc_html__('Twitter', 'inforward') ?></a></li>
				<?php endif; ?>

				<?php if ( $show_google ): ?>
					<li><a class="sh-google"" href="https://plus.google.com/share?url=<?php echo esc_url($permalink) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-gplus-3"></i><?php echo esc_html__('Google Plus', 'inforward') ?></a></li>
				<?php endif; ?>

				<?php if ( $show_pinterest ) : ?>
					<li><a class="sh-pinterest" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url($permalink) ?>&amp;media=<?php echo esc_url($image) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-pinterest"></i><?php echo esc_html__('Pinterest', 'inforward') ?></a></li>
				<?php endif; ?>

				<?php if ( $show_mail ) : ?>
					<li><a class="sh-mail" href="mailto:?subject=<?php echo esc_attr($title) ?>&amp;body=<?php echo esc_url($permalink) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-mail"></i><?php echo esc_html__('Email to a Friend', 'inforward') ?></a></li>
				<?php endif; ?>

			</ul>

		</div>
			<?php 
			echo '</div>';

		return ob_get_clean();

	}

}