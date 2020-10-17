<?php

/*  Base Function Class
/* ---------------------------------------------------------------------- */

if (!class_exists('Inforward_Base')) {

	class Inforward_Base {

		public $action_search = 'inforward_action_search';
		public $action_post_share = 'inforward_action_post_share';
		public $paths = array();
		public $directory_uri;
		private static $_instance;
		protected $used_fonts = array();
		protected $fontlist = array();

		/* 	Instance
		/* ---------------------------------------------------------------------- */

		public static function getInstance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			$this->directory_uri = get_theme_file_uri('css');

			add_action( 'template_redirect', array($this, 'predefined_config'), 1 );
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_styles_scripts' ), 100 );
			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles_scripts' ) );
			add_filter( 'body_class', array(&$this, 'body_class'), 5 );

			new inforward_admin_user_profile();

			/*  Load Textdomain
			/* --------------------------------------------- */
			$this->load_textdomain();
		}

		/* 	Initialization
		/* ---------------------------------------------------------------------- */

		function body_class($classes) {
			global $inforward_config, $inforward_settings;

			if ( isset($inforward_config['header_type']) ) {
				$classes[] = 'cp-header-' . str_replace('cp-', '', $inforward_config['header_type']);
			}
			if ( isset($inforward_settings['show-loading-overlay']) ) {
				$classes[] = 'loading-overlay-'. $inforward_settings['show-loading-overlay'];
			}

			return $classes;
		}

		public function admin_enqueue_styles_scripts() {
			$this->admin_enqueue_styles();
			$this->admin_enqueue_scripts();
		}

		public function enqueue_styles_scripts() {

			global $inforward_settings;

			/* Vendor CSS */
			wp_enqueue_style( 'fancybox', get_theme_file_uri('js/fancybox/jquery.fancybox.css') );
			wp_enqueue_style( 'owlcarousel', get_theme_file_uri('js/owlcarousel/owl.carousel.css') );
			wp_enqueue_style( 'linea-basic', get_theme_file_uri('fonts/linea-basic/styles.css') );
			wp_enqueue_style( 'linea-ecommerce', get_theme_file_uri('fonts/linea-ecommerce/styles.css') );
			wp_enqueue_style( 'linea-arrows', get_theme_file_uri('fonts/linea-arrows/styles.css') );
			wp_register_style( 'justifiedGallery', get_theme_file_uri('js/justifiedGallery/justifiedGallery.min.css') );
			
			/* Theme CSS */
			wp_enqueue_style( 'fontello', get_theme_file_uri('css/fontello.css'), array(), null );
			wp_enqueue_style( 'inforward-demo', get_theme_file_uri('fonts/demo-files/demo.css'), array(), null );
			wp_enqueue_style( 'bootstrap', get_theme_file_uri('css/bootstrap.min.css'), array(), null );
			wp_register_style( 'audioplayer', get_theme_file_uri('css/audioplayer.css'), array(), null );
			wp_enqueue_style( 'inforward-style', get_stylesheet_uri(), array(), null );

			// Skin Styles
			wp_deregister_style( 'inforward-skin' );
			$prefix_name = 'skin_' . inforward_get_blog_id() . '.css';
			$wp_upload_dir = wp_upload_dir();
			$stylesheet_dynamic_dir = $wp_upload_dir['basedir'] . '/dynamic_inforward_dir';
			$stylesheet_dynamic_dir = str_replace('\\', '/', $stylesheet_dynamic_dir);
			$filename = trailingslashit($stylesheet_dynamic_dir) . $prefix_name;
			
			$version = get_option( 'inforward_stylesheet_version' . $prefix_name );
			if ( empty($version) ) $version = '1';

			$demo = get_option( 'inforward_demo' );
			if ( empty($demo) ) $demo = 'wbc-import-1';
			
			if ( file_exists($filename) ) {
				if ( is_ssl() ) {
					$wp_upload_dir['baseurl'] = str_replace("http://", "https://", $wp_upload_dir['baseurl']);
				}
				wp_register_style( 'inforward-skin', $wp_upload_dir['baseurl'] . '/dynamic_inforward_dir/' . $prefix_name, null, $version );
			} 
			
			wp_enqueue_style( 'inforward-skin' );

			if ( is_rtl() ) {
				wp_enqueue_style( 'inforward-rtl',  get_theme_file_uri('css/rtl.css'), array( 'inforward-style' ), '1', 'all' );
			}

			wp_enqueue_style( 'inforward-layout', get_theme_file_uri('css/responsive.css'), array(), null );

			// Load Google Fonts
			$google_fonts = array();
			$fonts = array( 'body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'menu', 'sub-menu' );
			foreach ( $fonts as $option ) {
				if ( isset($inforward_settings[$option.'-font']['google']) && $inforward_settings[$option.'-font']['google'] !== 'false' ) {
					$font = $inforward_settings[$option.'-font']['font-family'];
					if ( !in_array($font, $google_fonts) ) {
						$google_fonts[] = $font;
					}
				}
			}

			$font_family = array();
			foreach ( $google_fonts as $font ) {
				
				/*
				Translators: If there are characters in your language that are not supported
				by chosen font(s), translate this to 'off'. Do not translate into your own language.
				 */
				$f = sprintf( _x( 'on', '%s font: on or off', 'inforward' ), $font );
				if ( 'off' !== $f ) {
				$font_family[] .= $font . ':300,300italic,400,400italic,500,600,600italic,700,700italic,800,800italic%7C,900,900italic';
				}
			}

			if ( $font_family ) {
				$charsets = '';

				if ( isset($inforward_settings['select-google-charset']) && $inforward_settings['select-google-charset'] && isset($inforward_settings['google-charsets']) && $inforward_settings['google-charsets']) {
					$i = 0;
					foreach ( $inforward_settings['google-charsets'] as $charset ) {
						if ( $i == 0 ) {
							$charsets .= $charset;
						} else {
							$charsets .= ",".$charset;
						}
						$i++;
					}
				}

				$fonts_url = add_query_arg( array(
					'family' => urlencode( implode('|', $font_family) ),
					'subset' => urlencode( $charsets )
				), '//fonts.googleapis.com/css' );

				wp_enqueue_style( 'inforward-google-fonts', esc_url_raw($fonts_url) . $charsets );
			}

			// Enqueue scripts
			
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			$google_maps_key = $inforward_settings['gmap-api'];

			if ( ! empty( $google_maps_key ) ) {
				$google_maps_key = '&key=' . $google_maps_key;
			} else {
				$google_maps_key = '';
			}
			
			$scripts_deps = array('jquery');

			wp_register_script( 'google-maps', '//maps.google.com/maps/api/js?v=3.exp&amp;libraries=places' . $google_maps_key, array(), null, true );
			
			/* Include Libs & Plugins */
			wp_register_script( 'audioplayer', get_theme_file_uri('js/audioplayer.js'), array('jquery'));
			wp_register_script( 'jquery-countdown-plugin', get_theme_file_uri('js/jquery.countdown.plugin.min.js'), array('jquery') );
			wp_register_script( 'jquery-countdown', get_theme_file_uri('js/jquery.countdown.min.js'), array('jquery') );
			wp_register_script( 'instafeed', get_theme_file_uri('js/instafeed.min.js'), array('jquery') );
			wp_register_script( 'flickr', get_theme_file_uri('js/flickr.js'), array('jquery') );
			wp_register_script( 'query-justifiedgallery', get_theme_file_uri('js/justifiedGallery/jquery.justifiedGallery.min.js'), array('jquery') );
			
			wp_enqueue_script( 'modernizr', get_theme_file_uri('js/libs/jquery.modernizr.js') );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script('jquery-form');
			wp_enqueue_script( 'jquery-fancybox', get_theme_file_uri('js/fancybox/jquery.fancybox.min.js'), array('jquery'), '', true);
			
			wp_enqueue_script( 'jquery-scrollTo', get_theme_file_uri('js/jquery.scrollTo.min.js'), array('jquery'), '', true );
			wp_enqueue_script( 'jquery-localScroll', get_theme_file_uri('js/jquery.localScroll.min.js'), array('jquery'), '', true );
			wp_enqueue_script( 'owl-carousel', get_theme_file_uri('js/owlcarousel/owl.carousel.min.js'), array('jquery'), '', true );
			wp_enqueue_script( 'jquery-queryloader2', get_theme_file_uri('js/jquery.queryloader2.min.js'), array('jquery'), '', true );
			wp_enqueue_script( 'isotope', get_theme_file_uri('js/isotope.pkgd.min.js'), array('jquery'), '', true);

			/* Theme files */
			wp_enqueue_script( 'inforward-plugins', get_theme_file_uri('js/inforward.plugins' . ( WP_DEBUG ? '' : '' ) .'.js'), array('jquery'), '', true );
			wp_enqueue_script( 'inforward-core', get_theme_file_uri('js/inforward.core' . ( WP_DEBUG ? '' : '' ) .'.js'), $scripts_deps, '', true );

			if ( isset($inforward_settings['js-code-head']) && $inforward_settings['js-code-head']) {
				wp_add_inline_script( 'inforward-core', $inforward_settings['js-code-head'] );
			}

			wp_localize_script('inforward-core', 'inforward_global_vars', array(
				'template_base_uri' => get_template_directory_uri() . '/',
				'site_url' => esc_url(get_home_url('/')),
				'ajax_nonce' => wp_create_nonce('ajax-nonce'),
				'ajaxurl' => admin_url('admin-ajax.php'),
				'load_color' => $inforward_settings['loading-line-color'],
				'load_bg_color' => $inforward_settings['loading-bg-color'],
				'ajax_loader_url' => get_template_directory_uri() . '/images/ajax-loader.gif',
				'countdown_labels' => [esc_html__('years', 'inforward'), esc_html__('month', 'inforward'), esc_html__('weeks', 'inforward'), esc_html__('days', 'inforward'), esc_html__('hours', 'inforward'), esc_html__('minutes', 'inforward'), esc_html__('seconds', 'inforward')],
				'countdown_labels1' => [esc_html__('year', 'inforward'), esc_html__('month', 'inforward'), esc_html__('week', 'inforward'), esc_html__('day', 'inforward'), esc_html__('hour', 'inforward'), esc_html__('min', 'inforward'), esc_html__('sec', 'inforward')],
				'rtl' => is_rtl() ? 1 : 0
			));

		}

		/* 	Enqueue Admin Styles
		/* ---------------------------------------------------------------------- */

		public function admin_enqueue_styles() {
			wp_enqueue_style( 'inforward_admin', $this->directory_uri . '/admin.css', false);
		}

		/*  Enqueue Admin Scripts
		/* ---------------------------------------------------------------------- */

		public function admin_enqueue_scripts() {
			if ( function_exists('add_thickbox') )
				add_thickbox();

			wp_enqueue_media();
			wp_enqueue_script( 'inforward_admin', get_template_directory_uri() . '/js/admin.js' );
		}

		/* 	Load Textdomain
		/* ---------------------------------------------------------------------- */

		public function load_textdomain () {
			load_theme_textdomain( 'inforward', get_template_directory()  . '/lang' );
		}

		/*	Check page wrapper
		/* ---------------------------------------------------------------------- */

		public function check_page_wrapper() {
			global $inforward_config, $inforward_settings;

			$post_id = inforward_post_id();

			$page_wrapper = $inforward_settings['wrapper'];
			$post_meta_page_wrapper = trim(get_post_meta( $post_id, 'inforward_wrapper', true ));

			if ( $post_meta_page_wrapper ) {
				$page_wrapper = $post_meta_page_wrapper;
			}

			if ( !$page_wrapper ) {
				$page_wrapper = 'cp-wide-layout-type';
			}

			$inforward_config['page_wrapper'] = $page_wrapper;
		}

		/*	Check page layout
		/* ---------------------------------------------------------------------- */

		public function check_page_layout () {
			global $inforward_config, $inforward_settings;

			$result = false;
			$sidebar_position = 'page-layout';

			$post_id = inforward_post_id();

			if ( is_page() ) { $sidebar_position = 'page-layout'; }

			if ( is_archive() || is_front_page() || is_search() || is_attachment() ) { $sidebar_position = 'post-archive-layout'; }

			if ( is_single() ) { $sidebar_position = 'post-single-layout'; }

			if ( is_singular() ) {
				$result = trim(get_post_meta( $post_id, 'inforward_page_sidebar_position', true ));
			}

			if ( is_404() ) { $result = 'cp-no-sidebar'; }

			if ( inforward_is_shop_installed() ) {

				if ( inforward_is_realy_woocommerce_page(false) || inforward_is_shop() || inforward_is_product_category() || inforward_is_product_tax() ) 				{

					if ( inforward_is_realy_woocommerce_page(false) ) {

						$result = 'cp-no-sidebar';

					} elseif ( inforward_is_product_category() ) {

						$result = $inforward_settings['product-archive-layout'];
						
					} elseif ( inforward_is_shop() ) {
						$result_sidebar_position = trim(get_post_meta( $post_id, 'inforward_page_sidebar_position', true ));
						if ( empty($result_sidebar_position) ) {
						$result = $inforward_settings['product-archive-layout'];
						} else {
							$result = $result_sidebar_position;
						}
					} else {
						$result = $inforward_settings['product-archive-layout'];
					}
				}

				if ( inforward_is_product() ) {
					$result_sidebar_position = trim(get_post_meta( $post_id, 'inforward_page_sidebar_position', true ));

					if ( empty($result_sidebar_position) ) {
						$result = $inforward_settings['product-single-layout'];
					} else {
						$result = $result_sidebar_position;
					}
				}

			}
			
			if ( is_post_type_archive('testimonials') || is_singular('testimonials') || is_tax('testimonials_category') ) {
				$result = 'cp-no-sidebar';
			}
			if ( is_post_type_archive('team-members') || is_singular('team-members') || is_tax('team_category') ) {
				$result = 'cp-no-sidebar';
			}
			if ( is_post_type_archive('tribe_events') || is_singular('tribe_events') || is_tax('tribe_events_cat') ) {
				$result = 'cp-no-sidebar';
			}
			if ( !$result ) {
				$result = $inforward_settings[$sidebar_position];
			}

			if ( !$result ) {
				$result = 'cp-right-sidebar';
			}

			if ( $result ) {
				$inforward_config['sidebar_position'] = $result;
			}

		}

		public function check_header_classes() {
			global $inforward_config, $inforward_settings;

			$result = array();
			$post_id = inforward_post_id();
			
			$inforward_config['content-size'] = '';
			$post_meta_content_size = trim(get_post_meta( $post_id, 'inforward_content_size', true ));
			if ( $post_meta_content_size ) {
				$inforward_config['content-size'] = $post_meta_content_size;
			}
			
			$header_sticky = 'header-sticky-0';
			if ( !empty($inforward_settings['header-sticky']) ) $header_sticky = 'header-sticky-'.$inforward_settings['header-sticky'];
			
			$header_type = 'cp-type-1';
			if ( !empty($inforward_settings['header-type']) ) $header_type = $inforward_settings['header-type'];
			
			$post_meta_header_type = trim(get_post_meta( $post_id, 'inforward_header_type', true ));
			
			if ( $post_meta_header_type ) {
				$header_type = $post_meta_header_type;
			}
			
			$header_position = 'relative';
			if ( !empty($inforward_settings['header-position']) ) $header_position = $inforward_settings['header-position'];
			
			$post_meta_header_position = trim(get_post_meta( $post_id, 'inforward_header_position', true ));
			
			if ( $post_meta_header_position ) {
				$header_position = $post_meta_header_position;
			}

			$result['header_type'] = $header_type;
			$result[] = $header_sticky;
			$result[] = $header_position.'-header';

			if ( $header_type ) {

				switch( $result['header_type'] ) {
					case 'cp-type-1':
						$result[] = 'header-style-1';
						break;
					case 'cp-type-2':
						$result[] = 'header-2';
						break;
					case 'cp-type-3':
						$result[] = 'header-3';
						break;
					case 'cp-type-4':
						$result[] = 'header-4';
						break;
					case 'cp-type-5':
						$result[] = 'header-style-5';
						break;
					case 'cp-type-6':
						$result[] = 'header-style-6';
						break;		
				}
			}
			
			$inforward_config['header-bg'] = '';
			if ( !empty($inforward_settings['header-bg']['url']) ) {
				$inforward_config['header-bg'] = $inforward_settings['header-bg']['url'];
			}
			$post_meta_header_bg = trim(get_post_meta( $post_id, 'inforward_header_bg_image', true ));
			if ( $post_meta_header_bg ) {
				$post_meta_header_bg = wp_get_attachment_image_src($post_meta_header_bg, '');
				if ( is_array($post_meta_header_bg) && isset($post_meta_header_bg[0]) ) {
				$inforward_config['header-bg'] = $post_meta_header_bg[0];
				}
			}		
			if(!empty($inforward_config['header-bg'])) {
				$result[] = 'with-bg-img';
			}

			$inforward_config['header_classes'] = implode( ' ', array_values($result) );
			$inforward_config['header_type'] = $result['header_type'];
			
		}

		public function check_footer_classes() {
			global $inforward_config, $inforward_settings;
			$classes = array();
			$post_id = inforward_post_id();
			
			$footer_type = 'footer-1';
			if( !empty($inforward_settings['footer-type']) ) {
			$footer_type = $inforward_settings['footer-type'];
			}
			
			$post_meta_footer_type = trim(get_post_meta( $post_id, 'inforward_footer_type', true ));
			if ( $post_meta_footer_type ) {
				$footer_type = $post_meta_footer_type;
			}
			
			if( is_404() ) {
				if( !empty($inforward_settings['footer-type-404']) ) {
				$footer_type = $inforward_settings['footer-type-404'];
				}
			}

			if ( !empty($footer_type) ) {
				$classes[] = $footer_type;
			}
			
			$inforward_config['footer_classes'] = implode( ' ', array_values($classes) );
			$inforward_config['footer_type'] = $footer_type;
		}

		public function check_page_content_classes() {
			global $inforward_config;

			$result = array();
			$result[] = 'cp-page-content-wrap';
			$result[] = $inforward_config['sidebar_position'];

			$inforward_config['page_content_classes'] = implode( ' ', array_filter(array_values($result)) );
		}

		public function predefined_config() {
			$this->check_page_wrapper();
			$this->check_header_classes();
			$this->check_page_layout();
			$this->check_page_content_classes();
			$this->check_footer_classes();
		}

		/* 	Instance
		/* ---------------------------------------------------------------------- */

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

	}

	if ( ! function_exists('inforward_base') ) {

		function inforward_base() {
			// Load required classes and functions
			return Inforward_Base::getInstance();
		}

		inforward_base();

	}

}