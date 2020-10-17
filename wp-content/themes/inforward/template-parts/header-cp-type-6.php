
<?php global $inforward_settings; ?>

<?php if ( $inforward_settings['header-type-6-search'] ): ?>
	
    	<div class="searchform-wrap">
	        <div class="vc-child h-inherit relative">

	          <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	            <input type="text" name="s" id="s" placeholder="<?php esc_attr_e( 'Start typing...', 'inforward' ) ?>" value="<?php echo get_search_query(); ?>">
	          </form>
			   <button class="close-search-form"></button>

	        </div>
	        
	    </div>
<?php endif; ?>

    <?php if ( $inforward_settings['show-header6-top-bar'] ): ?>
	<div class="pre-header">
	<div class="flex-row justify-content-between">
	 
		<div class="our-info">
                    
            <div class="info-item">
              <div class="wrapper">
                <span><?php echo wp_kses_post($inforward_settings['header6-topbar-info']) ?></span>
              </div>
            </div>
           
        </div>
		
		<div class="right-actions">
		<?php if ( $inforward_settings['header-type-6-social'] ): ?>
		<ul class="social-icons">
		
		    <?php if ( $inforward_settings['header6-social-linkedin']): ?>
				<li class="linkedin-icon"><a title="<?php echo esc_html__('LinkedIn', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header6-social-linkedin']) ?>"><i class="icon-linkedin-1"></i></a></li>
			<?php endif; ?>

			<?php if ( $inforward_settings['header6-social-tumblr']): ?>
				<li class="tumblr-icon"><a title="<?php echo esc_html__('Tumblr', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header6-social-tumblr']) ?>"><i class="icon-tumblr-1"></i></a></li>
			<?php endif; ?>

			<?php if ( $inforward_settings['header6-social-vimeo']): ?>
				<li class="vimeo-icon"><a title="<?php echo esc_html__('Vimeo', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header6-social-vimeo']) ?>"><i class="icon-vimeo"></i></a></li>
			<?php endif; ?>

			<?php if ( $inforward_settings['header6-social-youtube']): ?>
				<li class="youtube-icon"><a title="<?php echo esc_html__('Youtube', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header6-social-youtube']) ?>"><i class="icon-youtube"></i></a></li>
			<?php endif; ?>

			<?php if ( $inforward_settings['header6-social-facebook']): ?>
				<li class="fb-icon"><a title="<?php echo esc_html__('Facebook', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header6-social-facebook']) ?>"><i class="icon-facebook"></i></a></li>
			<?php endif; ?>

			<?php if ( $inforward_settings['header6-social-twitter']): ?>
				<li class="tweet-icon"><a title="<?php echo esc_html__('Twitter', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header6-social-twitter']) ?>"><i class="icon-twitter"></i></a></li>
			<?php endif; ?>

			<?php if ( $inforward_settings['header6-social-instagram']): ?>
				<li class="insta-icon"><a title="<?php echo esc_html__('Instagram', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header6-social-instagram']) ?>"><i class="icon-instagram-4"></i></a></li>
			<?php endif; ?>

			<?php if ( $inforward_settings['header6-social-flickr']): ?>
				<li class="flickr-icon"><a title="<?php echo esc_html__('Flickr', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header6-social-flickr']) ?>"><i class="icon-flickr"></i></a></li>
			<?php endif; ?>	

			<?php if ( $inforward_settings['header-social-telegram']): ?>
				<li class="telegram-icon"><a title="<?php echo esc_html__('Telegram', 'inforward') ?>" href="<?php echo esc_url($inforward_settings['header-social-telegram']) ?>"><i class="icon-telegram"></i></a></li>
			<?php endif; ?>	
			
		</ul>
		<?php endif; ?>
		
		<?php if (defined('ICL_LANGUAGE_CODE')): ?>
		<div class="lang-section">
		 <?php echo Inforward_WC_WPML_Config::wpml_header_languages_list(); ?>
		</div>
		<?php endif; ?>
		
		</div>
	 
	</div> 
	</div> 
	<?php endif; ?>
	
	<div class="top-header">
	
		<div class="logo-wrap">
		<?php echo inforward_logo(); ?>
		</div>
	
		<div class="menu-holder">
	            
			<div class="menu-wrap">
				<div class="nav-item">
				
					<nav id="main-navigation" class="cp-nav-wrap main-navigation">
					<?php echo Inforward_Helper::main_navigation(); ?>
					</nav>
					
					 <?php if ( $inforward_settings['header-type-6-search'] ): ?>
						<div class="search-holder">
						  <button class="search-button"></button>
						</div>
					<?php endif; ?>
					
					<?php if ( $inforward_settings['header-type-6-inquire'] ): ?>
						<a class="btn btn-style-6 btn-big" href="<?php echo esc_url($inforward_settings['header-inquire-url']) ?>"><?php echo esc_html($inforward_settings['header-inquire-title']) ?></a>
					<?php endif; ?>
					
				</div>
				
	        </div>

	    </div>

    </div>	
