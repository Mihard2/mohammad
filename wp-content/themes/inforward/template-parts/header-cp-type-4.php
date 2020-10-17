
<?php global $inforward_settings; ?>

	<?php if ( $inforward_settings['header-type-4-search'] ): ?>
	
    	<div class="searchform-wrap">
	        <div class="vc-child h-inherit relative">

	          <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	            <input type="text" name="s" id="s" placeholder="<?php esc_attr_e( 'Start typing...', 'inforward' ) ?>" value="<?php echo get_search_query(); ?>">
	          </form>
			   <button class="close-search-form"></button>

	        </div>
	        
	    </div>
	<?php endif; ?>

    <div class="top-header">

        <div class="container extra-size">
          
            <div class="row">
			
				<div class="col-md-4">
		
					<?php if ( $inforward_settings['header-type-4-form'] ): ?>
					<div class="join-us style-3">

						<div class="newslatter">
						  <h6><?php esc_attr_e( 'Email Updates', 'inforward' ) ?></h6>
							
						  <form class="join-form cp_newsletter" action="#" method="POST">
							<button type="submit" name="cp_newsletter-submit" class="signup_submit btn btn-style-4 f-right" data-type="submit"><span class="ajax-loader"></span><?php echo esc_html__('Sign Up','inforward') ?></button>
							<div class="input-holder">
							  <input type="email" name="newsletter-email" placeholder="<?php echo esc_html__('Email address','inforward') ?>">
							  <input type="text" name="zip" placeholder="<?php echo esc_html__('Zip code','inforward') ?>">
							</div>
							

<?php if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>							
<div class="comment-form-cookies-consent"><input id="form-cookies-header" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-header"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>


							 <div class="message-container-subscribe"></div>
						  </form>
						</div>

				    </div>
					<?php endif; ?>
		
				</div>	
				
				<div class="col-md-4 col-xs-6">
              
				  <div class="logo-wrap">

					<?php echo inforward_logo(); ?>

				  </div>

				</div>
			
				<div class="col-md-4 col-xs-6">
				
					<div class="page-options">
						
						<?php if (defined('ICL_LANGUAGE_CODE')): ?>
						<div class="lang-section">
						  <?php echo Inforward_WC_WPML_Config::wpml_header_languages_list(); ?>
						</div>
						<?php endif; ?>
						
						<div class="search-holder">
						  <button class="search-button"></button>
						</div>
						
					</div>
					
					<ul class="social-icons">
						
							<?php if ( $inforward_settings['header-social-linkedin']): ?>
								<li class="linkedin-icon"><a title="<?php echo esc_html__('LinkedIn', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-linkedin']) ?>"><i class="icon-linkedin-1"></i></a></li>
							<?php endif; ?>

							<?php if ( $inforward_settings['header-social-tumblr']): ?>
								<li class="tumblr-icon"><a title="<?php echo esc_html__('Tumblr', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-tumblr']) ?>"><i class="icon-tumblr-1"></i></a></li>
							<?php endif; ?>

							<?php if ( $inforward_settings['header-social-vimeo']): ?>
								<li class="vimeo-icon"><a title="<?php echo esc_html__('Vimeo', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-vimeo']) ?>"><i class="icon-vimeo"></i></a></li>
							<?php endif; ?>

							<?php if ( $inforward_settings['header-social-youtube']): ?>
								<li class="youtube-icon"><a title="<?php echo esc_html__('Youtube', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-youtube']) ?>"><i class="icon-youtube"></i></a></li>
							<?php endif; ?>

							<?php if ( $inforward_settings['header-social-facebook']): ?>
								<li class="fb-icon"><a title="<?php echo esc_html__('Facebook', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-facebook']) ?>"><i class="icon-facebook"></i></a></li>
							<?php endif; ?>

							<?php if ( $inforward_settings['header-social-twitter']): ?>
								<li class="tweet-icon"><a title="<?php echo esc_html__('Twitter', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-twitter']) ?>"><i class="icon-twitter"></i></a></li>
							<?php endif; ?>

							<?php if ( $inforward_settings['header-social-instagram']): ?>
								<li class="insta-icon"><a title="<?php echo esc_html__('Instagram', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-instagram']) ?>"><i class="icon-instagram-4"></i></a></li>
							<?php endif; ?>

							<?php if ( $inforward_settings['header-social-flickr']): ?>
								<li class="flickr-icon"><a title="<?php echo esc_html__('Flickr', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-flickr']) ?>"><i class="icon-flickr"></i></a></li>
							<?php endif; ?>		
							
							<?php if ( $inforward_settings['header-social-telegram']): ?>
								<li class="telegram-icon"><a title="<?php echo esc_html__('Telegram', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-telegram']) ?>"><i class="icon-telegram"></i></a></li>
							<?php endif; ?>		
					 
					 </ul>
					
				</div>	
				
			</div>	
	
		</div>
		
	</div>
	
    <div class="menu-holder">
        
        <div class="container extra-size">
          
          <div class="menu-wrap">

            <div class="nav-item">
	
			<nav id="main-navigation" class="main-navigation">
			<?php echo Inforward_Helper::main_navigation(); ?>
			</nav>
	
			<?php if ( $inforward_settings['header-type-4-inquire'] ): ?>
			<a class="btn btn-style-6 btn-big" href="<?php echo esc_url($inforward_settings['header-inquire-url']) ?>"><?php echo esc_html($inforward_settings['header-inquire-title']) ?></a>
			<?php endif; ?>

            </div>

          </div>

        </div>

    </div>	
		