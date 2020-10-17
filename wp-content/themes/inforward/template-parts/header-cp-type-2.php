
<?php global $inforward_settings; ?>
    <div class="top-header">
        <div class="logo-wrap">

          <?php echo inforward_logo(); ?>

        </div>

        <div class="menu-wrap">

            <?php if (defined('ICL_LANGUAGE_CODE')): ?>
			<div class="lang-section">
				<?php echo Inforward_WC_WPML_Config::wpml_header_languages_list(); ?>
			</div>	
			<?php endif; ?>
          
        <?php if ( $inforward_settings['header-type-2-inquire'] ): ?>
			<a class="btn btn-style-6 btn-big" href="<?php echo esc_url($inforward_settings['header-inquire-url']) ?>"><?php echo esc_html($inforward_settings['header-inquire-title']) ?></a>
		<?php endif; ?>

          <button type="button" class="navbar-toggle nav-bttn"></button>

        </div>

    </div>
	
	<nav id="navbar-menu" class="navbar-menu">
	<?php echo Inforward_Helper::main_navigation(); ?>
	</nav>
		