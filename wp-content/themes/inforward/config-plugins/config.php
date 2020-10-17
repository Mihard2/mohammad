<?php

if (!class_exists('Inforward_Plugins_Config')) {

	class Inforward_Plugins_Config {

		public $plugin_classes = array(
			'Inforward_VC_Table'
		);

		public $options;
		public $paths = array();
		public static $pathes = array();

		protected function path($name, $file = '') {
			return $this->paths[$name] . (strlen($file) > 0 ? '/' . preg_replace('/^\//', '', $file) : '');
		}

		function __construct() {

			add_action('init', array($this, 'init'));

		}

		public function init() {

			$dir = get_template_directory() . '/config-plugins';

			$this->paths = array(
				'BASE_URI' => get_template_directory_uri() . '/config-plugins/plugins/',
				'PLUGINS' => $dir . '/plugins/',
				'WIDGETS_DIR' => $dir . '/widgets/'
			);

			self::$pathes = $this->paths;

			require($this->paths['PLUGINS'] . 'table/config.php');

			foreach ( $this->plugin_classes as $plugin ) {
				if ( class_exists($plugin) ) {
					new $plugin;
				}
			}

		}

	}

	new Inforward_Plugins_Config();
}