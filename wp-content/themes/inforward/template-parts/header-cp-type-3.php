
<!-- - - - - - - - - - - - - - Header Section - - - - - - - - - - - - - - - - -->
<?php global $inforward_settings; ?>

<div class="top-header">

    <div class="container">
          
        <div class="row">
            
            <div class="col-lg-3">
              
              <div class="logo-wrap">

               <?php echo inforward_logo(); ?>

              </div>

            </div>
			
			<div class="col-lg-9">
				<div class="page-options">
					
					<div class="join-us style-3">

						<?php if ( $inforward_settings['header-type-3-form'] ): ?>
						<div class="newslatter">
							<h6><?php esc_attr_e( 'Join Us', 'inforward' ) ?></h6>
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
						<?php endif; ?>
						  
						  <?php if ( $inforward_settings['header-type-3-search'] ): ?>
						  <div class="search-holder">
							<h6><?php esc_attr_e( 'Search', 'inforward' ) ?></h6>
							<form method="get" id="searchform" class="join-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							  <button type="submit" class="btn btn-style-4 f-right"><?php esc_attr_e( 'Search', 'inforward' ) ?></button>
							  <div class="input-holder">
								<input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search the site', 'inforward' ) ?>">
							  </div>
							</form>
						  </div>
						  <?php endif; ?>
						  
					</div>
					
					<?php if (defined('ICL_LANGUAGE_CODE')): ?>
					<div class="lang-section">
					 <?php echo Inforward_WC_WPML_Config::wpml_header_languages_list(); ?>
					</div>
					<?php endif; ?>
					
					<?php if ( $inforward_settings['header-type-3-search'] ): ?>
					<div class="search-holder">
					  <button id="search-btn" class="search-button"></button>
					</div>
					<?php endif; ?>
					
					<?php if( inforward_is_shop_installed() ) { ?>
						  
							  <?php if ( is_woocommerce() || is_post_type_archive('product') || is_cart() || is_checkout() || is_account_page() ): ?>
							  
							  <?php
									global $woocommerce;
									$count = count( $woocommerce->cart->get_cart() );
									$cart_url = wc_get_cart_url();
								?>
								
							  <div class="shop-cart">
							  
								<button class="sc-cart-btn dropdown-invoker"><span class="icon icon-ecommerce-basket" data-amount="<?php echo esc_attr($count); ?>"></span></button>
							  
							    <div class="shopping-cart dropdown-window reverse">
								<div class="widget_shopping_cart_content products-holder"></div>
								</div>
							  
							  </div>
							  
							  <?php endif; ?>
							  
					<?php } ?>
						  
					
				</div>

				<div class="menu-holder">
					
					<div class="menu-wrap">

						<div class="nav-item">
				
						<nav id="main-navigation" class="main-navigation">
						<?php echo Inforward_Helper::main_navigation(); ?>
						</nav>

						</div>

					</div>

				</div>

			</div>

		</div>	
	</div>	

	 <?php if ( $inforward_settings['header-type-2-inquire'] ): ?>
	<a class="btn btn-style-6 btn-big" href="<?php echo esc_url($inforward_settings['header-inquire-url']) ?>"><?php echo esc_html($inforward_settings['header-inquire-title']) ?></a>
	<?php endif; ?>

</div>
