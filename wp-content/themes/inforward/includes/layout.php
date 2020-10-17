<?php

if ( !function_exists('inforward_logo') ) {

	function inforward_logo() {
		global $inforward_settings, $inforward_config;

		if ( is_404()) {
			$logo = $inforward_settings['logo']['url'];
		} elseif ( $inforward_config['header_type'] == 'cp-type-1' ) {
			$logo = $inforward_settings['logo']['url'];
		} elseif ( $inforward_config['header_type'] == 'cp-type-2' ) {
			$logo = $inforward_settings['logo2']['url'];	
		} elseif ( $inforward_config['header_type'] == 'cp-type-3' ) {
			$logo = $inforward_settings['logo3']['url'];	
		} elseif ( $inforward_config['header_type'] == 'cp-type-4' ) {
			$logo = $inforward_settings['logo4']['url'];
		} elseif ( $inforward_config['header_type'] == 'cp-type-5' ) {
			$logo = $inforward_settings['logo5']['url'];
		} elseif ( $inforward_config['header_type'] == 'cp-type-6' ) {
			$logo = $inforward_settings['logo6']['url'];		
		} else {
			$logo = $inforward_settings['logo']['url'];
		}

		ob_start();

		if ( !$logo ): ?>

			<h1 class="cp-logo"><?php else : ?><?php endif; ?>

				<a class="cp-logo logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
					<?php if ( $logo ) {
						echo '<img class="cp-standard-logo" src="' . esc_url(str_replace( array( 'http:', 'https:' ), '', $logo)) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />';
					} else {
						bloginfo( 'name' );
					} ?>
				</a>

		<?php if ( !$logo ) : ?></h1><?php else : ?><?php endif;

		return apply_filters( 'inforward_logo', ob_get_clean() );
	}

}
