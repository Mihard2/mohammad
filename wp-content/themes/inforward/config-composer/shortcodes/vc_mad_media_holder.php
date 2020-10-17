<?php
class WPBakeryShortCode_VC_mad_media_holder extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'image' => '',
			'show_form' => '',
			'show_social' => '',
			'box_type' => 'style-1',
			'facebook_link' => '',
			'twitter_link' => '',
			'instagram_link' => '',
			'youtube_link' => '',
			'flickr_link' => '',
			'snapchat_link' => '',
			'telegram_link' => '',
			'css_animation' => '',
		), $atts, 'vc_mad_media_holder');

		return $this->html($content);
	}

	public function html($content) {

		$wrapper_attributes = array();
		$image = $css_animation = '';

		extract($this->atts);

		$attach_id = preg_replace('/[^\d]/', '', $image);
		$alt = trim( strip_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) ) );
		$img = Inforward_Helper::get_post_attachment_image( $attach_id, 'full');

		if ( $img == null ) {
			$img_large =  vc_asset_url( 'vc/no_image.png' );
		} else {
			$img_large = esc_url($img);
		}

		$css_classes = array(
			'cp-media-holder',
			'media-holder',
			'full-src',
			$box_type
		);

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, '20' );
		}

		ob_start(); ?>

		<div <?php echo implode( ' ', $wrapper_attributes ) ?> data-bg="<?php echo esc_url($img_large); ?>">

		
			<?php if ( $box_type == 'style-1' ): ?>
			<div class="media-inner left-side">
				<?php echo wpb_js_remove_wpautop( $content, true ); ?>
				
				<?php if ( $show_form ): ?>
					<div class="join-us">
				  
					  <form class="join-form cp_newsletter" action="#" method="POST">
						<button type="submit" name="cp_newsletter-submit" class="signup_submit btn btn-style-4 btn-big f-right" data-type="submit"><?php echo esc_html__('Sign Up','inforward') ?></button>
						<div class="input-holder">
						  <input type="email" name="newsletter-email" placeholder="<?php echo esc_html__('Email address','inforward') ?>">
						</div>
						
<?php if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>							
						<div class="comment-form-cookies-consent"><input id="form-cookies-media" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-media"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>

						 <div class="message-container-subscribe"></div>
					  </form>

					</div>
				
				<?php endif; ?>

			</div>

			<?php elseif( $box_type == 'style-2' ): ?>
			
			<div class="media-inner">
		
				<?php echo wpb_js_remove_wpautop( $content, true ); ?>
				
				<?php if ( $show_form ): ?>
				<div class="join-us style-3">
			  
				  <form class="join-form cp_newsletter" action="#" method="POST">
					<button type="submit" name="cp_newsletter-submit" class="signup_submit btn btn-style-4 btn-big f-right" data-type="submit"><?php echo esc_html__('Sign Up','inforward') ?></button>
					<div class="input-holder">
					  <input type="email" name="newsletter-email" placeholder="<?php echo esc_html__('Email address','inforward') ?>">
					</div>
					
<?php if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>				
					<div class="comment-form-cookies-consent"><input id="form-cookies-media2" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-media2"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>
					
					 <div class="message-container-subscribe"></div>
				  </form>

				</div>
				<?php endif; ?>
		
			</div>
			
				<?php if ( $show_social ): ?>
				<ul class="social-icons style-2 v-type">

					<?php if (!empty($facebook_link)): ?>
					<li><a href="<?php echo esc_url($facebook_link); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
					<?php endif; ?>
					<?php if (!empty($twitter_link)): ?>
					<li><a href="<?php echo esc_url($twitter_link); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
					<?php endif; ?>
					<?php if (!empty($instagram_link)): ?>
					<li><a href="<?php echo esc_url($instagram_link); ?>" target="_blank"><i class="icon-instagram-5"></i></a></li>
					<?php endif; ?>
					<?php if (!empty($youtube_link)): ?>
					<li><a href="<?php echo esc_url($youtube_link); ?>" target="_blank"><i class="icon-youtube-play"></i></a></li>
					<?php endif; ?>
					<?php if (!empty($flickr_link)): ?>
					<li><a href="<?php echo esc_url($flickr_link); ?>" target="_blank"><i class="icon-flickr"></i></a></li>
					<?php endif; ?>
					<?php if (!empty($snapchat_link)): ?>
					<li><a href="<?php echo esc_url($snapchat_link); ?>" target="_blank"><i class="icon-snapchat-ghost"></i></a></li>
					<?php endif; ?>
					
					<?php if (!empty($telegram_link)): ?>
					<li><a href="<?php echo esc_url($telegram_link); ?>" target="_blank"><i class="icon-telegram"></i></a></li>
					<?php endif; ?>

				</ul>
				<?php endif; ?>
			
			<?php endif; ?>

		</div>

		<?php return ob_get_clean();
	}

}