<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The main theme class.
 */
class Inforward {

	/**
	 * The template directory URL.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $template_dir_url = '';

	/**
	 * The one, true instance of the Inforward object.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * The theme version.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $version = '1.0';

	/**
	 * Determine if we're currently upgrading/migration options.
	 *
	 * @static
	 * @access public
	 * @var bool
	 */
	public static $is_updating  = false;

	/**
	 * Bundled Plugins.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $bundled_plugins = array();

	/**
	 * Inforward_Product_registration
	 *
	 * @access public
	 * @var object Inforward_Product_registration.
	 */
	public $registration;

	/**
	 * Access the single instance of this class.
	 *
	 * @return Inforward
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Inforward();
		}
		return self::$instance;
	}

	/**
	 * The class constructor
	 */
	private function __construct() {

		// Initialize bundled plugins array.
		self::$bundled_plugins = array(
			'revolution' => array( 'slug' => 'revslider', 'name' => esc_html__('Slider Revolution', 'inforward'), 'source' => 'revslider.zip', 'version' => '5.3.1.5' ),
			'theme_functionality' => array( 'slug' => 'inforward-theme-functionality', 'name' => esc_html__('Inforward Theme Functionality', 'inforward'), 'source' => 'inforward-theme-functionality.zip', 'version' => '1.0' ),
			'easy_tables' => array( 'slug' => 'easy-tables-vc', 'name' => esc_html__('Easy Tables (vc)', 'inforward'), 'source' => 'easy-tables-vc.zip', 'version' => '1.0.10' ),
			'composer' => array( 'slug' => 'js_composer', 'name' => esc_html__('WPBakery Visual Composer', 'inforward'), 'source' => 'js_composer.zip', 'version' => '5.2.1' ),
		);

		// Instantiate secondary classes.
		$this->registration = new Inforward_Product_Registration();
	}

	/**
	 * Gets the theme version.
	 *
	 * @since 5.0
	 *
	 * @return string
	 */
	public static function get_theme_version() {
		return self::$version;
	}

	/**
	 * Gets the bundled plugins.
	 *
	 * @since 5.0
	 *
	 * @return array Array of bundled plugins.
	 */
	public static function get_bundled_plugins() {
		return self::$bundled_plugins;
	}

}