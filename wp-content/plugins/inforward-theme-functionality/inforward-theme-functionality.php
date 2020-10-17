<?php
/*
Plugin Name: Inforward Theme - Functionality
Description: Adds functionality to Inforward Theme.
Version: 1.4
Author: monkeysan
Author URI: https://themeforest.net/user/monkeysan/portfolio
License:     GPL2
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if (!class_exists('Inforward_Functionality')) {

	class Inforward_Functionality {

		public $paths = array();
		public static $pathes = array();

		public $content_types_classes = array(
			'Inforward_Video_Config',
			'Inforward_Portfolio_Config',
			'Inforward_Team_Members_Config',
			'Inforward_Issues_Config',
			'Inforward_Testimonials_Config'
		);

		function __construct() {

			if ( ! defined( 'Inforward_Content_Type_Version' ) ) {
				define( 'Inforward_Content_Type_Version', '1.0' );
			}

			// Load text domain
			add_action('plugins_loaded', array( &$this, 'load_textdomain' ) );

			$dir = plugin_dir_path(__FILE__);

			$this->paths = array(
				'APP_ROOT' => $dir,
				'APP_DIR' => basename( $dir ),
				'EXT_DIR' => $dir . 'inc/extensions/',
				'BASE_URI' => plugin_dir_url(__FILE__),
				'CLASSES_PATH' => $dir . 'classes/',
				'METABOXES_PATH' => $dir . 'extensions/metaboxes/',
				'XML_PATH' => $dir . 'xml/'
			);

			add_filter( 'widget_text', 'do_shortcode' );

			self::$pathes = $this->paths;

			require_once( $this->paths['METABOXES_PATH'] . 'metaboxes.php' );

			// Include classes
			$this->include_classes();

			// Init classes
			add_action( 'admin_init', array( &$this, 'admin_init' ) );
			add_action( 'init', array( &$this, 'init_classes' ) );

			if ( class_exists('ReduxFramework') ) {
				add_action( 'redux/extensions/inforward_settings/before', array( $this, 'register_custom_extension_loader' ), 0 );

				/*  Importer
				/* ---------------------------------------------------------------------- */
				require_once( $this->paths['APP_ROOT'] . 'importer/import-class.php' );

			}
			
			add_shortcode( 'inforward_post_gallery', array( $this, 'gallery_shortcode' ) );
			add_shortcode( 'inforward_audio', array( $this, 'audio_shortcode' ) );
		}

		function register_custom_extension_loader($ReduxFramework) {
			$path    = $this->paths['EXT_DIR'];
			$folders = scandir( $path, 1 );
			foreach ( $folders as $folder ) {
				if ( $folder === '.' or $folder === '..' or ! is_dir( $path . $folder ) ) {
					continue;
				}
				$extension_class = 'ReduxFramework_Extension_' . $folder;
				if ( ! class_exists( $extension_class ) ) {
					// In case you wanted override your override, hah.
					$class_file = $path . $folder . '/extension_' . $folder . '.php';
					$class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder, $class_file );
					if ( $class_file ) {
						require_once( $class_file );
					}
				}
				if ( ! isset( $ReduxFramework->extensions[ $folder ] ) ) {
					$ReduxFramework->extensions[ $folder ] = new $extension_class( $ReduxFramework );
				}
			}
		}
		
		function admin_init() {

		}

		// include classes
		function include_classes() {
			foreach ( glob($this->paths['CLASSES_PATH'] . '*.php') as $file ) {
				require_once($file);
			}
		}

		// init classes
		function init_classes() {
			foreach ($this->content_types_classes as $content_type_class) {
				new $content_type_class;
			}
		}

		// load plugin text domain
		function load_textdomain() {
			load_plugin_textdomain( 'inforward_app_textdomain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		// Get content type labels
		function getLabels($singular_name, $name, $title = FALSE) {
			if ( !$title )
				$title = $name;

			return array(
				"name" => $title,
				"singular_name" => $singular_name,
				"add_new" => __("Add New", 'inforward_app_textdomain'),
				"add_new_item" => sprintf( __("Add New %s", 'inforward_app_textdomain'), $singular_name),
				"edit_item" => sprintf( __("Edit %s", 'inforward_app_textdomain'), $singular_name),
				"new_item" => sprintf( __("New %s", 'inforward_app_textdomain'), $singular_name),
				"view_item" => sprintf( __("View %s", 'inforward_app_textdomain'), $singular_name),
				"search_items" => sprintf( __("Search %s", 'inforward_app_textdomain'), $name),
				"not_found" => sprintf( __("No %s found", 'inforward_app_textdomain'), $name),
				"not_found_in_trash" => sprintf( __("No %s found in Trash", 'inforward_app_textdomain'), $name),
				"parent_item_colon" => ""
			);
		}

		// Get content type taxonomy labels
		function getTaxonomyLabels($singular_name, $name) {
			return array(
				"name" => $name,
				"singular_name" => $singular_name,
				"search_items" => sprintf( __("Search %s", 'inforward_app_textdomain'), $name),
				"all_items" => sprintf( __("All %s", 'inforward_app_textdomain'), $name),
				"parent_item" => sprintf( __("Parent %s", 'inforward_app_textdomain'), $singular_name),
				"parent_item_colon" => sprintf( __("Parent %s:", 'inforward_app_textdomain'), $singular_name),
				"edit_item" => sprintf( __("Edit %", 'inforward_app_textdomain'), $singular_name),
				"update_item" => sprintf( __("Update %s", 'inforward_app_textdomain'), $singular_name),
				"add_new_item" => sprintf( __("Add New %s", 'inforward_app_textdomain'), $singular_name),
				"new_item_name" => sprintf( __("New %s Name", 'inforward_app_textdomain'), $singular_name),
				'not_found' => sprintf(__('No %s found', 'inforward_app_textdomain'), $singular_name),
				'not_found_in_trash' => sprintf(__('No %s found in Trash', 'inforward_app_textdomain'), $singular_name),
				"menu_name" => $name,
			);
		}


		public function gallery_shortcode($atts) {
			$image_size = $size = $post_id = $ids = '';

			extract(shortcode_atts(array(
				'image_size' => '',
				'size' => '',
				'post_id' => '',
				'ids' => '',
			), $atts));

			$attachments = get_posts(array(
				'include' => $ids,
				'orderby' => 'post__in',
				'post_status' => 'inherit',
				'post_type' => 'attachment',
				'post_mime_type' => 'image'
			));

			$data_rel = 'data-rel=post-'. rand() .'';

			ob_start(); ?>

			<?php if ( !empty($attachments) && is_array($attachments) ): ?>

				<div class="carousel-type-2 type-2">
				<div class="owl-carousel" data-max-items="1">

					<?php foreach ( $attachments as $attachment ): ?>

						<?php
							$attachment_id = $attachment->ID;
							$title = get_the_title($attachment_id);
							$permalink = Inforward_Helper::get_post_attachment_image($attachment_id, '');
						?>

						<div class="owl-item">
							
							<?php if ( !empty($image_size) ): ?>
								<?php echo Inforward_Helper::get_the_thumbnail( $attachment_id, $image_size, true, '', array( 'alt' => '', 'class' => '' ) ) ?>
							<?php elseif( !empty($size) ): ?>
								<?php echo Inforward_Helper::get_attachment_image( $attachment_id, $size, false, array( 'alt' => '', 'class' => '' ) ) ?>
							<?php else: ?>
								<?php echo Inforward_Helper::get_the_thumbnail( $attachment_id, $image_size, true, '', array( 'alt' => '', 'class' => '' ) ) ?>
							<?php endif; ?>
							
						</div>

					<?php endforeach; ?>

				</div>
				</div>

			<?php endif; return ob_get_clean();

		}
		
		public function audio_shortcode($atts) {
			$src = '';
			$mp3 = '';
			
			extract(shortcode_atts(array(
				'src' => '',
				'mp3' => ''
			), $atts));

			ob_start(); ?>

			<?php if ( !empty($src) ): ?>
			<div class="audioplayer1">
				<audio preload="auto" controls >
				<source src="<?php echo esc_url($src) ?>">
				</audio>
			</div>	
			<?php endif; ?>
			
			<?php if ( !empty($mp3) ): ?>
			<div class="audioplayer1">
				<audio preload="auto" controls >
				<source src="<?php echo esc_url($mp3) ?>">
				</audio>
			</div>	
			<?php endif; ?>

			<?php return ob_get_clean();
		}

	}

	new Inforward_Functionality();

}
