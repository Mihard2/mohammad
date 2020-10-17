<?php

if ( !class_exists('inforward_importer') ) {

	class inforward_importer {

		public $home_pages = array();

		function __construct() {
			add_action( 'import_start', array( $this, 'pre_import_start') );
			add_filter( 'wbc_importer_description', array( $this, 'importer_description' ), 10 );
			add_action( 'wbc_importer_after_content_import', array( $this , 'after_content_import' ), 10, 2 );
		}

		function pre_import_start() {
			$this->pre_woocommerce_settings();
		}

		public function pre_woocommerce_settings() {

			$catalog = array(
				'width' 	=> '263',
				'height'	=> '263'
			);

			$single = array(
				'width' 	=> '555',
				'height'	=> '555'
			);

			$thumbnail = array(
				'width' 	=> '100',
				'height'	=> '100'
			);

			update_option('shop_catalog_image_size', $catalog);
			update_option('shop_single_image_size', $single);
			update_option('shop_thumbnail_image_size', $thumbnail);

		}
		
		function after_content_import( $demo_active_import , $demo_directory_path ) {
			reset( $demo_active_import );

			$this->menu_install();
			$this->import_sliders();
			$this->reading_install( $demo_active_import );
			$this->import_widgets( $demo_directory_path );
			$this->save_settings( $demo_active_import, $demo_directory_path );
			$this->import_woocommerce_settings();
		}

		function importer_description( $description ) {
			$description .= '<p class="description">'. esc_html__( 'Images are for demo purpose only.', 'inforward_app_textdomain' ) .'</p>';
			$description .= '
				<h3>What if the Import fails or stalls?</h3>

				<p>
				If the import stalls and fails to respond after a few minutes You are suffering from PHP configuration limits that are set too low to complete the process. You should contact your hosting provider and ask them to increase those limits to a minimum as follows:
				</p>
				<ul style="margin-left: 55px">
					<li>max_execution_time 600</li>
					<li>memory_limit 128M</li>
					<li>post_max_size 32M</li>
					<li>upload_max_filesize 32M</li>
				</ul>
				<p>You can verify your PHP configuration limits by installing a simple plugin found here: <a href="http://wordpress.org/extend/plugins/wordpress-php-info" target="_blank">http://wordpress.org/extend/plugins/wordpress-php-info</a>. And you can also check your PHP error logs to see the exact error being returned.</p>
				<p>If you were not able to import demo, please contact on our <a target="_blank" href="https://velikorodnov.ticksy.com"><b>support forum</b></a>, our technical staff will import demo for you.</p>
        ';

			return $description;
		}

		function save_settings( $demo_active_import, $demo_directory_path ) {

			$current_key = key( $demo_active_import );

			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) ) {

				$option_file = $demo_directory_path . '/settings.php';

				if ( $option_file ) {

					include_once($option_file);

					if ( !empty($sidebar_settings) ) {
						$sidebar_settings = json_decode($sidebar_settings, true);

						if ( !empty($sidebar_settings) && is_array($sidebar_settings) ) {
							update_option( 'inforward_sidebars', $sidebar_settings );
						}
					}

					if ( !empty($meta_settings) ) {
						$meta_settings = json_decode($meta_settings, true);
						if ( !empty($meta_settings) ) {
							$this->import_woocommerce_metadata($meta_settings);
						}
					}

				}

				update_option( 'inforward_demo', $current_key );

			}

		}

		public function import_sliders() {

			if ( defined('RS_PLUGIN_PATH') ) {

				$sliders_needle_revolution = array(
					'slider1.zip',
					'slider2.zip'
				);

				if ( !empty($sliders_needle_revolution) ) {
					foreach ($sliders_needle_revolution as $zip_path) {
						$slider = new RevSlider();
						$slider->importSliderFromPost(true, true, RS_PLUGIN_PATH . 'demo/' . $zip_path);
					}
				}

			}

		}
		
		public function import_woocommerce_metadata($meta_settings) {
			global $wpdb;

			if ( is_array($meta_settings) ) {
				foreach($meta_settings as $meta) {
					$wpdb->insert($wpdb->prefix . 'product_catmeta', $meta, array('%d', '%d', '%s', '%s' ) );
				}
			}

		}

		public function import_woocommerce_settings() {
			// Set WooCommerce pages
			$woopages = array(
				'woocommerce_default_country' => 'US:CA',
				'woocommerce_default_catalog_orderby' => 'menu_order',
				'woocommerce_currency' => 'USD',
				'woocommerce_enable_myaccount_registration' => 1,
				'woocommerce_shop_page_id' => 'Shop',
				'woocommerce_cart_page_id' => 'Cart',
				'woocommerce_terms_page_id' => 'Terms and conditions',
				'woocommerce_checkout_page_id' => 'Checkout',
				'woocommerce_myaccount_page_id' => 'My Account'
			);

			foreach ( $woopages as $woo_page_name => $woo_page_title ) {
				$woopage = get_page_by_title( $woo_page_title );
				if ( isset($woopage) && $woopage->ID ) {
					update_option($woo_page_name, $woopage->ID);
				}
			}

			// We no longer need to install pages
			$notices = array_diff( get_option( 'woocommerce_admin_notices', array() ), array( 'install', 'update' ) );
			update_option( 'woocommerce_admin_notices', $notices );
			delete_option( '_wc_needs_pages' );
			delete_transient( '_wc_activation_redirect' );
		}
		
		function import_widgets ( $demo_directory_path ) {

			ob_start();
			include( $demo_directory_path . '/widget-data.json' );
			$widget_data = ob_get_clean();

			if ( !empty($widget_data) ) {
				$widget_settings = json_decode($widget_data, true);
				if ( !empty($widget_settings) ) {
					foreach( $widget_settings as $key => $setting ) {
						update_option( $key, $setting );
					}
				}
			}

		}

		public function menu_install() {

			$locations = array();
			$get_menus = wp_get_nav_menus();

			if ( !empty($get_menus) ) {

				$nav_needle = array(
					'primary' => 'Main Menu',
					'footer' => 'footer'
				);

				foreach ( $get_menus as $menu ) {
					if ( is_object($menu) && in_array($menu->name, $nav_needle) ) {
						$key = array_search($menu->name, $nav_needle);
						if ( $key ) {
							$locations[$key] = $menu->term_id;
						}
					}
				}

				if ( $locations ) {
					set_theme_mod( 'nav_menu_locations', $locations );
				}

			}

		}
		
		public function reading_install( $demo_active_import ) {
			$current_key = key( $demo_active_import );
			
			// Set reading options
			$homepage = get_page_by_title( 'Header 1' );
			$posts_page = get_page_by_title( 'Blog' );
			if ( ($homepage && $homepage->ID) || ($posts_page && $posts_page->ID) ) {
				update_option('show_on_front', 'page');
				if ( $homepage && $homepage->ID ) {
					update_option('page_on_front', $homepage->ID);
				}
				if ( $posts_page && $posts_page->ID ) {
					update_option('page_for_posts', $posts_page->ID);
				}
			}

			 wp_delete_post( 1, true );
			 
			// update visual composer content types
			update_option( 'wpb_js_content_types', array( 'post', 'page', 'portfolio', 'team-members' ) );
			
		}

	}

	new inforward_importer();

}


