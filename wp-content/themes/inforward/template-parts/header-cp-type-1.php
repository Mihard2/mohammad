
<?php global $inforward_settings; ?>
    
	<div class="searchform-wrap">
		<div class="vc-child h-inherit relative">

		  <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="text" name="s" id="s" placeholder="<?php esc_attr_e( 'Start typing...', 'inforward' ) ?>" value="<?php echo get_search_query(); ?>">
		  </form>
		   <button class="close-search-form"></button>

		</div>

	</div>
	
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
					<div class="search-holder">
					  <button class="search-button"></button>
					</div>
					<div class="lang-section">
					 <?php echo Inforward_WC_WPML_Config::wpml_header_languages_list(); ?>
					</div>
					
					<?php if ( $inforward_settings['header-type-1-inquire'] ): ?>
						<a class="btn btn-style-6 btn-big" href="<?php echo esc_url($inforward_settings['header-inquire-url']) ?>"><?php echo esc_html($inforward_settings['header-inquire-title']) ?></a>
					<?php endif; ?>
					
				</div>
				
	        </div>

	    </div>

    </div>
