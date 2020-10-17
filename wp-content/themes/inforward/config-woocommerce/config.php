<?php
if (!class_exists('INFORWARD_WOOCOMMERCE_CONFIG')) {

	class INFORWARD_WOOCOMMERCE_CONFIG {

		protected static $_instance = null;

		public $paths = array();
		public static $pathes = array();

		public function path($name, $file = '') {
			return $this->paths[$name] . (strlen($file) > 0 ? '/' . preg_replace('/^\//', '', $file) : '');
		}

		public function assetUrl($file) {
			return $this->paths['BASE_URI'] . $this->path('ASSETS_DIR_NAME', $file);
		}

		function __construct() {

			// Woocommerce support
			add_theme_support('woocommerce');
			add_theme_support('wc-product-gallery-slider');
			add_theme_support( 'wc-product-gallery-lightbox' );
			
			$dir = get_template_directory() . '/config-woocommerce';

			define('INFORWARD_WOO_CONFIG', true);

			$this->paths = array(
				'PHP' => $dir . '/php/',
				'ASSETS_DIR_NAME' => 'assets',
				'BASE_URI' => get_template_directory_uri() . '/config-woocommerce/'
			);
			self::$pathes = $this->paths;

			include( $this->paths['PHP'] . 'new-badge.class.php' );

			$this->woocommerce_remove_hooks();
			$this->woocommerce_add_filters();
			$this->woocommerce_add_hooks();

			add_action('wp_enqueue_scripts', array(&$this, 'add_enqueue_scripts'));
			add_action('admin_init', array(&$this, 'admin_init'));
			add_action('widgets_init', array(&$this, 'include_widgets'));
		}

		public function admin_init() {
			add_filter("manage_product_posts_columns", array(&$this, "manage_columns"));
		}

		public function include_widgets() {
			$before_widget = '<div id="%1$s" class="widget widget-bg %2$s">';

			$widget_args = array(
				'before_widget' => $before_widget,
				'after_widget' => '</div>',
				'before_title' => '<h5 class="wt-title">',
				'after_title' => '</h5>'
			);

			// Shop Widget Area
			register_sidebar(array(
				'name' => esc_html__('Shop Widget Area', 'inforward'),
				'id' => 'shop-widget-area',
				'description'   => esc_html__('For WooCommerce pages.', 'inforward'),
				'before_widget' => $widget_args['before_widget'],
				'after_widget' => $widget_args['after_widget'],
				'before_title' => $widget_args['before_title'],
				'after_title' => $widget_args['after_title']
			));
		}

		public function custom_get_option($key = false, $default = "") {

			$result = get_option('inforward_options');

			if (is_array($key)) {
				$result = $result[$key[0]];
			} else {
				$result = $result['inforward'];
			}

			if ($key === false) {
			} else if(isset($result[$key])) {
				$result = $result[$key];
			} else {
				$result = $default;
			}

			if ($result == "") { $result = $default; }
			return $result;
		}

		public function woocommerce_add_filters() {
			add_filter('woocommerce_enqueue_styles', '__return_empty_array');
			add_filter('woocommerce_general_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_page_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_catalog_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_inventory_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_shipping_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_tax_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('woocommerce_product_settings', array(&$this, 'woocommerce_general_settings_filter'));
			add_filter('loop_shop_columns', array(&$this, 'woocommerce_loop_columns'));
			add_filter('loop_shop_per_page', array(&$this, 'woocommerce_product_count'));
			add_filter( 'woocommerce_breadcrumb_defaults', array(&$this, 'inforward_woocommerce_breadcrumbs') );
		}

		function iconic_cart_count_fragments( $fragments ) {
			$fragments['div.header-cart-count'] = '<button class="sc-cart-btn dropdown-invoker"><span class="icon icon-ecommerce-basket" data-amount="' . WC()->cart->get_cart_contents_count() . '"></span></button>';
			
			return $fragments;
			
		}
		
		public function inforward_woocommerce_breadcrumbs() {
			return array(
					'delimiter'   => '/',
					'wrap_before' => '<nav class="woocommerce-breadcrumb">',
					'wrap_after'  => '</nav>',
					'before'      => '',
					'after'       => '',
					'home'        => _x( 'Home', 'breadcrumb', 'inforward' ),
				);
		}
	
		public function woocommerce_remove_hooks() {

			//template content-product
			remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); 
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );  
			remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

			//template archive-product
			remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
			
			//page shop
			remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
			remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
					
			//single product
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
			remove_action('woocommerce_review_before', 'woocommerce_review_display_gravatar', 10);
		
			//cart
//			remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
		}

		public function woocommerce_add_hooks() {

			add_action( 'init', array(&$this, 'woocommerce_clear_cart_url'));

			/* Content Product Hooks */
			add_action( 'woocommerce_before_shop_loop_item_title', array($this, 'template_loop_product_thumbnail') );
			add_action( 'woocommerce_shop_loop_item_title', array($this, 'template_loop_product_title') );
			
			////page shop
			add_action('woocommerce_archive_description', array(&$this, 'woocommerce_category_image'), 2);
			add_action('woocommerce_archive_description', array(&$this, 'woocommerce_subcategory_image'), 10);
			add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );
			add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
			
			// single product
			add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15);
			add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
			add_action( 'woocommerce_share', array(&$this, 'inforward_product_share'),10);

		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function manage_columns($columns) {
			unset($columns['wpseo-title']);
			unset($columns['wpseo-metadesc']);
			unset($columns['wpseo-focuskw']);

			return $columns;
		}

		public function woocommerce_loop_columns() {
			global $inforward_settings;

			$woocommerce_columns = $inforward_settings['shop-product-cols'];
			
			return $woocommerce_columns;
		}

		public function woocommerce_product_count() {
			global $inforward_settings;
			
			$count = $inforward_settings['shop-count-item'];
			
			if ( inforward_is_product_category() || inforward_is_product_tax() ) {
			$count = $inforward_settings['shop-count-item-category'];
			}
			
			return $count;
		}

		public function woocommerce_clear_cart_url() {
			global $woocommerce;

			if ( isset( $_GET['empty-cart'] ) ) {
				$woocommerce->cart->empty_cart();
			}
		}

		public function template_loop_product_title() {
			global $product;
			echo '<h5 class="product-name"><a href="'. esc_url(get_the_permalink()) .'">' . get_the_title() . '</a></h5>';
		}
		
		public function template_loop_product_thumbnail() {
			$this->product_thumbnail();
		}
		public function product_thumbnail() {
			$shop_catalog = wc_get_image_size( 'shop_catalog' );
			$thumb_image = Inforward_Helper::get_the_post_thumbnail( get_the_ID(), array($shop_catalog['width'] , $shop_catalog['height']), $shop_catalog['crop'], '', array( 'alt' => get_the_title() ) ); 
			?>

			<?php if ( has_post_thumbnail(get_the_ID()) && $thumb_image ): ?>
				 <div class="product-image">
                    <a href="<?php echo esc_url(get_the_permalink(get_the_ID())); ?>"><?php echo wp_kses_post($thumb_image); ?></a>
                    <div class="overlay">
                      <div class="overlay-inner">
                        <?php woocommerce_template_loop_add_to_cart(); ?>
                      </div>
                    </div>
                  </div>
			<?php else: ?>
 				<div class="product-image placeholder_img">
                    <a href="<?php echo esc_url(get_the_permalink(get_the_ID())); ?>"><?php echo wc_placeholder_img( 'shop_catalog' ); ?></a>
                    <div class="overlay">
                      <div class="overlay-inner">
                         <?php woocommerce_template_loop_add_to_cart(); ?>
                      </div>
                    </div>
                  </div>
			<?php endif;

		}
		
		public function woocommerce_button_proceed_to_checkout() {
			$checkout_url = WC()->cart->get_checkout_url();

			?>
			<a href="<?php echo esc_url($checkout_url); ?>" class="checkout-button "><?php esc_html_e( 'Proceed to Checkout', 'inforward' ); ?></a>
		<?php
		}

		public function add_enqueue_scripts() {
			$css_file = $this->assetUrl('css/woocommerce-mod.css');
			$woo_zoom_file = $this->assetUrl('js/elevatezoom.min.js');
			$woo_mod_file = $this->assetUrl('js/woocommerce-mod.js');									
			wp_enqueue_style( 'inforward-woocommerce-mod', $css_file );					
			wp_enqueue_script( 'inforward-woocommerce-mod', $woo_mod_file, array('jquery', 'inforward-plugins', 'inforward-core'), 1, true );

			$goahead = 1;
			
		}

		public static function enqueue_script($script) {
			wp_enqueue_script( 'inforward-' . $script );
		}
		
		function woocommerce_general_settings_filter($options) {
			$delete = array('woocommerce_enable_lightbox');

			foreach ($options as $key => $option) {
				if (isset($option['id']) && in_array($option['id'], $delete)) {
					unset($options[$key]);
				}
			}
			return $options;
		}

		public static function content_truncate($string, $limit, $break = ".", $pad = "...") {
			if (strlen($string) <= $limit) { return $string; }

			if (false !== ($breakpoint = strpos($string, $break, $limit))) {
				if ($breakpoint < strlen($string) - 1) {
					$string = substr($string, 0, $breakpoint) . $pad;
				}
			}
			if (!$breakpoint && strlen(strip_tags($string)) == strlen($string)) {
				$string = substr($string, 0, $limit) . $pad;
			}
			return $string;
		}

		public static function create_data_string($data = array()) {
			$data_string = "";

			foreach($data as $key => $value) {
				if (is_array($value)) $value = implode(", ", $value);
				$data_string .= " data-$key={$value} ";
			}
			return $data_string;
		}

		function woocommerce_category_image() {
			if ( is_product_category() ) {
			
				global $wp_query;
				$cat = $wp_query->get_queried_object();
				$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
				$image = wp_get_attachment_url( $thumbnail_id );
				if ( $image ) {
					echo '<figure class="term-image entry-attachment">';
						echo '<img src="' . $image . '" alt="" />';
					echo '</figure>';
				}
				
				if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
				  $description = wc_format_content( term_description() );
				  if ( $description ) {
					echo '<div class="term-description content-element3">' . $description . '</div>';
				  }
				}
			
			}
		}

		function woocommerce_subcategory_image() {
			if ( is_product_category() ) {
				global $wp_query;
				
				woocommerce_product_subcategories(array( 'before' => '<div class="product_subcategories content-element2"><ul>', 'after' => '</ul></div>'));
				
			}
		}

		function woocommerce_default_product_tabs( $tabs = array() ) {
			global $product, $post;

			// Description tab - shows product content
			if ( $post->post_excerpt ) {
				$tabs['description'] = array(
					'title'    => esc_html__( 'Description', 'inforward' ),
					'priority' => 10,
					'callback' => 'woocommerce_product_description_tab'
				);
			}

			// Additional information tab - shows attributes
			if ( $product && ( $product->has_attributes() || ( $product->enable_dimensions_display() && ( $product->has_dimensions() || $product->has_weight() ) ) ) ) {
				$tabs['additional_information'] = array(
					'title'    => esc_html__( 'Additional Information', 'inforward' ),
					'priority' => 20,
					'callback' => 'woocommerce_product_additional_information_tab'
				);
			}

			// Reviews tab - shows comments
			if ( comments_open() ) {
				$tabs['reviews'] = array(
					'title'    => sprintf( esc_html__( 'Reviews (%d)', 'inforward' ), $product->get_review_count() ),
					'priority' => 30,
					'callback' => 'comments_template'
				);
			}

			return $tabs;
		}
		
		public function inforward_product_share() {
			$post_id = get_the_ID();
			$image = esc_url(wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ));
			$permalink = esc_url( apply_filters('the_permalink', get_the_permalink( $post_id )) );
			$title = esc_attr(get_the_title( $post_id ));
			$extra_attr = 'target="_blank"';

			global $inforward_settings;

			if ( !$inforward_settings['product-single-share'] ) return;
			?>

			<div class="inforward-product-share share">

				<span class="title"><?php echo esc_html__('Share this:', 'inforward') ?></span>
				<ul class="social-icons share type3">

					<?php if ($inforward_settings['product-share-facebook']): ?>
						<li><a class="sh-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($permalink) ?>&amp;p&#091;images&#093;&#091;0&#093;=<?php echo esc_url($image) ?>&amp;p&#091;title&#093;=<?php echo esc_attr($title) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-facebook"></i></a></li>
					<?php endif; ?>

					<?php if ($inforward_settings['product-share-twitter']): ?>
						<li><a class="sh-twitter" href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($title) ?>&amp;url=<?php echo esc_url($permalink) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-twitter"></i></a></li>
					<?php endif; ?>

					<?php if ($inforward_settings['product-share-googleplus']): ?>
						<li><a class="sh-google"" href="https://plus.google.com/share?url=<?php echo esc_url($permalink) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-gplus"></i></a></li>
					<?php endif; ?>

					<?php if ($inforward_settings['product-share-pinterest']) : ?>
						<li><a class="sh-pinterest" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url($permalink) ?>&amp;media=<?php echo esc_url($image) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-pinterest"></i></a></li>
					<?php endif; ?>

					<?php if ($inforward_settings['product-share-email']) : ?>
						<li><a href="mailto:?subject=<?php echo esc_attr($title) ?>&amp;body=<?php echo esc_url($permalink) ?>" <?php echo wp_kses_post($extra_attr) ?>><i class="icon-mail"></i></a></li>
					<?php endif; ?>

				</ul>

			</div>
			<?php
		}
		
		public static function is_realy_woocommerce_page () {
			if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
					return true;
			}
			$woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
											"woocommerce_terms_page_id" ,
											"woocommerce_cart_page_id" ,
											"woocommerce_checkout_page_id" ,
											"woocommerce_pay_page_id" ,
											"woocommerce_thanks_page_id" ,
											"woocommerce_myaccount_page_id" ,
											"woocommerce_edit_address_page_id" ,
											"woocommerce_view_order_page_id" ,
											"woocommerce_change_password_page_id" ,
											"woocommerce_logout_page_id" ,
											"woocommerce_lost_password_page_id" ) ;
			foreach ( $woocommerce_keys as $wc_page_id ) {
					if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
							return true ;
					}
			}
			return false;
	}

	}
}