<?php
global $inforward_settings, $inforward_config;

$data_mailchimp_api = $inforward_settings['mailchimp-api']; 
if ( $data_mailchimp_api == '' ) {
	return;
}

if ( !$inforward_settings['show-footer-newsletter'] || $inforward_config['footer_classes'] != 'footer-1' || is_404() ) return;
?>

<div class="call-out join-us">
        
	<div class="container">

	  <div class="row flex-row">
		<div class="col-md-8">
		  
		  <div class="bg-col-1">
			<h5 class="footer-newsletter-title"><?php echo esc_html__('Join Our Team','inforward') ?></h5>
			
			<form class="join-form cp_newsletter" action="#" method="POST">
			  
			  
			  <button type="submit" name="cp_newsletter-submit" class="signup_submit btn btn-style-4 btn-big f-right" data-type="submit"><span class="ajax-loader"></span><?php echo esc_html__('Sign Up','inforward') ?></button>
			  <div class="input-holder">
				<input type="email" name="newsletter-email" placeholder="<?php echo esc_html__('Email address','inforward') ?>">
				<input type="text" name="zip" placeholder="<?php echo esc_html__('Zip code','inforward') ?>">
			  </div>

<?php 
if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>			  
<div class="comment-form-cookies-consent"><input id="form-cookies-consent" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-consent"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>

			  <div class="message-container-subscribe"></div>
			</form>
			
		  </div>

		</div>
		
		<?php if ( $inforward_settings['footer-newsletter-donate-url'] != '' ): ?>
		<a href="<?php echo esc_url($inforward_settings['footer-newsletter-donate-url']) ?>" target="_blank" class="col-md-4">
		  <div class="bg-col-2">
			<div class="align-center">
			  <h5><?php echo esc_html__('Donate Today!','inforward') ?></h5>
			</div>
		  </div>
		</a>
		<?php endif; ?>
		
	  </div>

	</div>

</div>
