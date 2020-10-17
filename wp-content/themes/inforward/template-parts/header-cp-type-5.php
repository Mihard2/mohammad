
<?php global $inforward_settings; ?>

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
					
					<?php if ( $inforward_settings['header-type-5-inquire'] ): ?>
						<a class="btn btn-style-6 btn-big" href="<?php echo esc_url($inforward_settings['header-inquire-url']) ?>"><?php echo esc_html($inforward_settings['header-inquire-title']) ?></a>
					<?php endif; ?>
					
				</div>
				
	        </div>

	    </div>

    </div>	
