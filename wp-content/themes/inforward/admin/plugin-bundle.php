<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Inforward for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */

require_once get_template_directory() . '/admin/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'inforward_register_required_plugins' );

if (!function_exists('inforward_added_admin_action')) {

	function inforward_added_admin_action() {
		add_action( 'admin_enqueue_scripts', 'inforward_added_plugin_style' );
	}

	function inforward_added_plugin_style() {
		wp_enqueue_style( 'inforward_admin_plugins', get_theme_file_uri('css/admin-plugin.css'), array() );
	}

	add_action( 'load-plugins.php', 'inforward_added_admin_action', 1 );

}
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function inforward_register_required_plugins() {

	// disable visual composer automatic update
	global $vc_manager;
	if ( $vc_manager ) {

		$vc_updater = $vc_manager->updater();

		if ( $vc_updater ) {
			remove_filter('upgrader_pre_download', array(&$vc_updater, 'upgradeFilterFromEnvato'));
			remove_filter('upgrader_pre_download', array(&$vc_updater, 'preUpgradeFilter'));
			remove_action('wp_ajax_nopriv_vc_check_license_key', array(&$vc_updater, 'checkLicenseKeyFromRemote'));
		}
	}

	$is_plugins_page = false;
	if ( ( isset( $_GET['page'] ) && 'inforward-plugins' === $_GET['page'] ) ||
		( isset( $_GET['page'] ) && 'install-required-plugins' === $_GET['page'] ) 
	) {
		$is_plugins_page = true;
	}

	$bundled_plugins = Inforward()->get_bundled_plugins();

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'     => esc_html__('Redux Framework', 'inforward'),
			'slug'     => 'redux-framework',
			'required' => true
		),

		array(
			'name'     => esc_html__('WooCommerce', 'inforward'),
			'slug'     => 'woocommerce',
			'required' => false
		),
		
		array(
			'name'     => esc_html__('Contact Form 7', 'inforward'),
			'slug'     => 'contact-form-7',
			'required' => false
		),

		array(
			'name' => esc_html__('Latest Tweets Widget', 'inforward'),
			'slug' => 'latest-tweets-widget',
			'required' => false
		),
		
		array(
			'name' => esc_html__('Custom Facebook Feed', 'inforward'),
			'slug' => 'custom-facebook-feed',
			'required' => false
		),

		array(
            'name'               => 'The Events Calendar', 
            'slug'               => 'the-events-calendar', 
            'required'           => false
        ),
		
		array(
            'name'               => 'Give – Donation Plugin and Fundraising Platform', 
            'slug'               => 'give', 
            'required'           => false
        ),
		array(
            'name'               => 'Instagram Feed', 
            'slug'               => 'instagram-feed', 
            'required'           => false
        ),

		// This is an example of how to include a plugin from the WordPress Plugin Repository.

		array(
            'name'               => 'Envato Market', // The plugin name.
            'slug'               => 'envato-market', // The plugin slug (typically the folder name).
            'source'             => 'http://velikorodnov.com/wordpress/sample-data/pluginusan/envato-market.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '2.0.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        ),
		
		array(
            'name'               => 'inForward Theme Functionality', // The plugin name.
            'slug'               => 'inforward-theme-functionality', // The plugin slug (typically the folder name).
            'source'             => 'http://velikorodnov.com/wordpress/sample-data/inforward/pluginus30/inforward-theme-functionality.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        ),

		array(
            'name'               => 'Revolution Slider', // The plugin name.
            'slug'               => 'revslider', // The plugin slug (typically the folder name).
            'source'             => 'http://velikorodnov.com/wordpress/sample-data/inforward/pluginus30/revslider.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '6.2.18', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        ),
		
		array(
            'name'               => 'Easy Tables', // The plugin name.
            'slug'               => 'easy_tables', // The plugin slug (typically the folder name).
            'source'             => 'http://velikorodnov.com/wordpress/sample-data/pluginusan/easy-tables-vc.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        ),

		array(
            'name'               => 'WPBakery Visual Composer', // The plugin name.
            'slug'               => 'js_composer', // The plugin slug (typically the folder name).
            'source'             => 'http://velikorodnov.com/wordpress/sample-data/pluginusan/js_composer.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '6.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        ),
		array(	
			'name'               => 'WPBE - WordPress Posts Bulk Editor Professional', 
            'slug'               => 'bulk-editor', 
            'source'             => 'http://velikorodnov.com/wordpress/sample-data/pluginusan/bulk-editor.zip',
            'required'           => false, 
            'version'            => '2.0.1.1',
            'force_activation'   => false, 
            'force_deactivation' => false
			),

	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       => 'inforward', 
		'id'           => 'inforward',                 
		'default_path' => get_theme_file_path( 'admin/plugins/' ),                      
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,                    
		'dismissable'  => true,                    
		'dismiss_msg'  => '',                     
		'is_automatic' => true,                 
		'message'      => ''
	);

	tgmpa( $plugins, $config );

}