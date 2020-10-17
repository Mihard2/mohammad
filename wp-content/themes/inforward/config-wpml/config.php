<?php

if (!class_exists('Inforward_WC_WPML_Config')) {

	class Inforward_WC_WPML_Config {

		public $paths = array();

		protected function path($name, $file = '') {
			return $this->paths[$name] . (strlen($file) > 0 ? '/' . preg_replace('/^\//', '', $file) : '');
		}
		protected function assetUrl($file) {
			return $this->paths['BASE_URI'] . $this->path('ASSETS_DIR_NAME', $file);
		}

		function __construct() {

			$dir = get_template_directory() . '/config-wpml';

			$this->paths = array(
				'PHP' => $dir . '/php/',
				'ASSETS_DIR_NAME' => 'assets',
				'BASE_URI' => get_template_directory_uri() . '/config-wpml/'
			);

		}

		public static function wpml_header_languages_list() {

			$languages = array();
			$my_const = ICL_LANGUAGE_CODE;

			if ( defined('ICL_LANGUAGE_CODE') && !empty($my_const) ) {
				$languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0' );
			}

			if ( 1 < count($languages) ) { ?>

				<?php
				foreach ( $languages as $l ) {
					if ($l['active']) continue;
					if(!$l['active']) echo '<a href="'. esc_url($l['url']) .'">';
					echo esc_attr($l['native_name']);
					if(!$l['active']) echo '</a>';
				}
				?>

			<?php
			}
		}

	}

	new Inforward_WC_WPML_Config();

}


