<?php
class WPBakeryShortCode_VC_mad_social_buttons extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'show_form' => '',
			'show_social' => '',
			'facebook_link' => '',
			'twitter_link' => '',
			'instagram_link' => '',
			'youtube_link' => '',
			'flickr_link' => '',
			'snapchat_link' => '',
			'telegram_link' => '',
			'css_animation' => '',
		), $atts, 'vc_mad_social_buttons');

		return $this->html($content);
	}

	public function html($content) {

		$wrapper_attributes = array();
		$css_animation = '';

		extract($this->atts);


		$css_classes = array(
			'cp-social-holder'
		);

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, '20' );
		}

		ob_start(); ?>

		<div <?php echo implode( ' ', $wrapper_attributes ) ?> >

			<div class="bg-col-4">
		
				<?php if ( $show_form ): ?>
				<div class="cp-social-holder-inner social_with_form">
                
               <?php echo wpb_js_remove_wpautop( $content, true ); ?>
                
                     <div class="join-us style-3">
                     
                      <form class="join-form cp_newsletter" action="#" method="POST">
                        <button type="submit" name="cp_newsletter-submit" class="signup_submit btn btn-style-6 btn-big f-right" data-type="submit"><?php echo esc_html__('Sign Up','inforward') ?></button>
                        <div class="input-holder">
                          <input type="email" name="newsletter-email" placeholder="<?php echo esc_html__('Email address','inforward') ?>">
                          <input type="text" name="zip" placeholder="<?php echo esc_html__('Zip code','inforward') ?>">
                        </div>
						
<?php if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>							
<div class="comment-form-cookies-consent"><input id="form-cookies-social" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-social"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>

                         <div class="message-container-subscribe"></div>
                      </form>
                      
                      </div>

				</div>
				<?php endif; ?>
		
			</div>
			
				<?php if ( $show_social ): ?>
                <div class="bg-col-5">
				<div class="cp-social-holder-inner">
                
                <h5 class="section-title" ><?php echo sprintf( '%s <br>%s', esc_html__('Stay','inforward'), esc_html__('Connected','inforward') ); ?></h5>
                
                <ul class="social-icons">

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
                
                </div>
                </div>
				<?php endif; ?>
			
			

		</div>

		<?php return ob_get_clean();
	}

}