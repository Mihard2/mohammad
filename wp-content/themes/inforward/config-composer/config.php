<?php

class Inforward_Vc_Config {

	public $paths = array();
	private static $_instance;

	function __construct() {

		$dir = get_theme_file_path('config-composer');

		$this->paths = array(
			'APP_ROOT' => $dir,
			'HELPERS_DIR' => $dir . '/helpers',
			'CONFIG_DIR' => $dir . '/config',
			'ASSETS_DIR_NAME' => '/assets',
			'BASE_URI' => get_theme_file_uri('config-composer'),
			'PARTS_VIEWS_DIR' => $dir . '/shortcodes/views/',
			'TEMPLATES_DIR' => $dir . '/shortcodes/',
			'MODULES_DIR' => $dir . '/modules/'
		);

		require_once $this->path( 'HELPERS_DIR', 'helpers.php' );

		// Load
		$this->autoloadLibraries($this->path('TEMPLATES_DIR'));
		$this->init();

		// Add New param
		$this->add_hooks();
		$this->ShortcodeParams();
	}

	/**
	 *
	 * @return self
	 */
	public static function getInstance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function init() {

		add_action('vc_build_admin_page', array(&$this, 'autoremoveElements'), 11);
		add_action('vc_load_shortcode', array(&$this, 'autoremoveElements'), 11);

		if ( is_admin() ) {
			add_action( 'load-post.php', array($this, 'admin_init') , 4);
			add_action( 'load-post-new.php', array($this, 'admin_init') , 4 );
		} else {
			add_action( 'wp_enqueue_scripts', array(&$this, 'front_init'), 5);
		}

	}

	public function add_hooks() {
		add_action( 'inforward_pre_import_hook', array(&$this, 'wpb_content_types') );
		add_action( 'vc_before_init', array(&$this, 'before_init'), 1 );
		add_action( 'vc_mapper_init_after', array(&$this, 'mapper_init_after'), 5 );
		add_filter( 'vc_font_container_get_allowed_tags', array(&$this, 'font_container_get_allowed_tags') );
		add_action( 'init', array(&$this, 'ajax_hooks') );
	}

	public function mapper_init_after() {
		$vc_config_path = $this->paths['CONFIG_DIR'];
		vc_lean_map( 'vc_video', null, $vc_config_path . '/content/shortcode-vc-video.php' );
	}

	public function before_init() {
		require_once( $this->path('CONFIG_DIR', 'map.php') );
		$this->autoloadLibraries( $this->path('MODULES_DIR') );
	}

	public $removeElements = array();
	public $removeParams = array();

	public function ajax_hooks() {
		add_action('wp_ajax_inforward_portfolio_ajax_isotope_items_more', array(&$this, 'portfolio_ajax_load_more'));
		add_action('wp_ajax_nopriv_inforward_portfolio_ajax_isotope_items_more', array(&$this, 'portfolio_ajax_load_more'));

		add_action('wp_ajax_inforward_products_ajax_items_more', array(&$this, 'products_ajax_load_more'));
		add_action('wp_ajax_nopriv_inforward_products_ajax_items_more', array(&$this, 'products_ajax_load_more'));

		add_action('wp_ajax_inforward_posts_ajax_isotope_items_more', array(&$this, 'posts_ajax_load_more'));
		add_action('wp_ajax_nopriv_inforward_posts_ajax_isotope_items_more', array(&$this, 'posts_ajax_load_more'));
	}

	public function portfolio_ajax_load_more() {
		$masonry_entries = new inforward_portfolio_isotope_masonry_entries($_POST);
		$output = $masonry_entries->html();
		echo '{inforward-isotope-loaded}' . $output;
		exit();
	}

	public function products_ajax_load_more() {
		$entries = new inforward_products_isotope_masonry_entries($_POST);
		$output = $entries->html();
		echo '{inforward-products-loaded}' . $output;
		exit();
	}

	public function posts_ajax_load_more() {
		$masonry_entries = new inforward_posts_isotope_masonry_entries($_POST);
		$output = $masonry_entries->html();
		echo '{inforward-isotope-loaded}' . $output;
		exit();
	}

	public function ShortcodeParams() {
		WpbakeryShortcodeParams::addField('choose_icons', array(&$this, 'param_icon_field'), $this->assetUrl('js/js_shortcode_param_icon.js'));
		WpbakeryShortcodeParams::addField('table_number', array(&$this, 'param_table_number_field'), $this->assetUrl('js/js_shortcode_tables.js'));
		WpbakeryShortcodeParams::addField('table_hidden', array(&$this, 'param_hidden_field'));
		WpbakeryShortcodeParams::addField('datetimepicker', array(&$this, 'param_datetimepicker'), $this->assetUrl('js/bootstrap-datetimepicker.min.js'));
		WpbakeryShortcodeParams::addField('number', array(&$this, 'param_number_field'));
		WpbakeryShortcodeParams::addField('get_terms', array(&$this, 'param_woocommerce_terms'), $this->assetUrl('js/js_shortcode_products.js'));
		WpbakeryShortcodeParams::addField('get_by_id', array(&$this, 'param_woocommerce_get_by_id'), $this->assetUrl('js/js_shortcode_products.js'));

		vc_add_param( 'vc_single_image', array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'CSS Animation', 'inforward' ),
			'param_name' => 'css_animation',
			'admin_label' => true,
			'value' => array(
				esc_html__( 'No', 'inforward' ) => '',
				esc_html__( 'Fade In Up', 'inforward' ) => 'fadeInUp',
				esc_html__( 'Zoom In Down', 'inforward' ) => 'zoomInDown',
				esc_html__( 'Bounce In Down', 'inforward' ) => 'bounceInDown',
				esc_html__( 'Bounce In Up', 'inforward' ) => 'bounceInUp',
				esc_html__( 'Flip In Y', 'inforward' ) => 'flipInY',
			),
			'group' => esc_html__( 'Animations', 'inforward' ),
			'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'inforward' )
		) );

		vc_remove_param( 'vc_column', 'css_animation' );

		vc_add_param( 'vc_column',
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'CSS Animation', 'inforward' ),
				'param_name' => 'css_animation',
				'admin_label' => true,
				'value' => array(
					esc_html__( 'No', 'inforward' ) => '',
					esc_html__( 'Fade In Up', 'inforward' ) => 'fadeInUp',
					esc_html__( 'Zoom In Down', 'inforward' ) => 'zoomInDown',
					esc_html__( 'Bounce In Down', 'inforward' ) => 'bounceInDown',
					esc_html__( 'Bounce In Up', 'inforward' ) => 'bounceInUp',
					esc_html__( 'Flip In Y', 'inforward' ) => 'flipInY',
				),
				'group' => esc_html__( 'Animations', 'inforward' ),
				'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'inforward' )
			)
		);

		vc_add_param( 'vc_column',
			array(
				'type' => 'number',
				'heading' => esc_html__( 'Animation delay', 'inforward' ),
				'param_name' => 'animation_delay',
				'admin_label' => true,
				'description' => esc_html__( 'Animation delay', 'inforward' ),
				'value' => 0,
				'dependency' => array(
					'element' => 'css_animation',
					'not_empty' => true
				),
				'group' => esc_html__( 'Animations', 'inforward' )
			)
		);
	}

	public function admin_init() {
		add_action('admin_enqueue_scripts', array(&$this, 'admin_extend_js_css'));
	}

	public function front_init() {
		$this->enqueue_styles();
		$this->enqueue_js();

	}

	public function admin_extend_js_css() {
		wp_enqueue_style( 'inforward-extend-admin', $this->assetUrl('css/js_composer_backend_editor.css'), false, WPB_VC_VERSION );
		wp_enqueue_style( 'inforward-admin-linear', get_template_directory_uri() . '/fonts/demo-files/demo.css', false, WPB_VC_VERSION );
		wp_enqueue_style( 'inforward-admin-linea-basic', get_template_directory_uri() . '/fonts/linea-basic/styles.css', false, WPB_VC_VERSION );
		wp_enqueue_style( 'inforward-admin-linea-ecommerce', get_template_directory_uri() . '/fonts/linea-ecommerce/styles.css', false, WPB_VC_VERSION );
		wp_enqueue_style( 'inforward-bootstrap-datetimepicker', $this->assetUrl('css/bootstrap-datetimepicker-admin.css'), false, WPB_VC_VERSION );

		wp_localize_script('jquery', 'inforward_admin_global_vars', array(
			'template_base_uri' => get_template_directory_uri() . '/'
		));
	}

	public function path( $name, $file = '' ) {
		$path = $this->paths[ $name ] . ( strlen( $file ) > 0 ? '/' . preg_replace( '/^\//', '', $file ) : '' );
		return $path;
	}

	public function enqueue_styles() {
		$front_css_file = $this->assetUrl('css/css_composer_front.css');
		wp_enqueue_style( 'inforward_js_composer_front', $front_css_file, array( 'js_composer_front' ), WPB_VC_VERSION, 'all' );
	}

	public function enqueue_js() {

		if ( is_page() ) {

			global $post;

			if ( !$post ) return false;

			$post_content = $post->post_content;

			if ( stripos( $post_content, '[vc_mad_google_map') ) {
				if ( defined('INFORWARD_DISABLE_GOOGLE_MAP_API') && (INFORWARD_DISABLE_GOOGLE_MAP_API == true || INFORWARD_DISABLE_GOOGLE_MAP_API == 'true') ) {
					$load_map_api = false;
				} else {
					$load_map_api = true;
				}

				if ( $load_map_api ) wp_enqueue_script('googleapis');
			}

		}

	}

	public function autoremoveElements() {
		foreach ( $this->removeParams as $name => $element ) {
			foreach ( $element as $attribute_name ) {
				vc_remove_param($name, $attribute_name);
			}
		}

	}

	protected function autoloadLibraries($path) {
		foreach ( glob($path. '*.php') as $file ) {
			require_once($file);
		}
	}

	public function assetUrl( $file ) {
		return preg_replace( '/\s/', '%20', $this->paths['BASE_URI'] . $this->path('ASSETS_DIR_NAME', $file));
	}

	function fieldAttachedImages( $att_ids = array() ) {
		$output = '';

		foreach ( $att_ids as $th_id ) {
			$thumb_src = wp_get_attachment_image_src( $th_id, 'thumbnail' );
			if ( $thumb_src ) {
				$thumb_src = $thumb_src[0];
				$output .= '
						<li class="added">
							<img rel="' . $th_id . '" src="' . $thumb_src . '" />
							<input type="text" name=""/>
							<a href="#" class="icon-remove"></a>
						</li>';
			}
		}
		if ( $output != '' ) {
			return $output;
		}
	}

	public function param_icon_field($settings, $value) {
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type = isset($settings['type']) ? $settings['type'] : '';
		$class = isset($settings['class']) ? $settings['class'] : '';
		$icons = apply_filters( 'inforward_param_icons', array( ' ', 'icon-basic-heart', 'icon-basic-message-txt', 'icon-basic-mail-open-text', 'icon-basic-case', 'icon-ecommerce-wallet', 'icon-basic-todo-txt', 'icon-basic-calendar', 'icon-ecommerce-megaphone', 'icon-ecommerce-banknotes', 'licon-at-sign', 'licon-baby-bottle', 'licon-baby2', 'licon-balloon', 'licon-clock3', 'licon-football', 'licon-heart', 'licon-graduation-hat', 'licon-tennis', 'licon-tie', 'licon-bow-tie', 'licon-platter', 'licon-theater', 'licon-telephone', 'licon-telephone2', 'licon-map-marker', 'licon-pen', 'licon-laundry', 'licon-sun', 'licon-moon', 'licon-city', 'licon-layers', 'licon-bullhorn', 'licon-calendar-full', 'licon-bubble', 'licon-briefcase', 'licon-gift', 'licon-brush', 'licon-spotlights', 'licon-music-note3', 'licon-rocket', 'licon-frame-contract', 'licon-earth', 'licon-thumbs-up', 'licon-unlink', 'licon-users', 'licon-chart-bars', 'licon-share2', 'licon-star', 'licon-register', 'licon-medal-empty', 'licon-cog', 'licon-question' ) );

		ob_start(); ?>

		<div id="mad-param-icon">
			<input type="hidden" name="<?php echo esc_attr($param_name) ?>" class="wpb_vc_param_value <?php echo esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) ?> " value="<?php echo esc_attr($value) ?>" id="mad-trace" />
			<div class="mad-icon-preview "><i class="<?php echo esc_attr($value) ?>"></i></div>
			<input class="mad-search" type="text" placeholder="<?php esc_html_e('Search icon', 'inforward') ?>" />
			<div id="mad-icon-dropdown">
				<ul class="mad-icon-list">

					<?php foreach ( $icons as $icon ): ?>

						<?php if ( !empty($icon) ): ?>

							<?php $selected = ($icon == $value) ? 'class="selected"' : ''; ?>

							<li <?php echo esc_attr($selected) ?> data-icon="<?php echo esc_attr($icon) ?>">
								<span class="<?php echo esc_attr($icon) ?>"></span>
							</li>

						<?php endif; ?>

					<?php endforeach; ?>

				</ul><!--/ .mad-icon-list-->
			</div><!--/ #mad-icon-dropdown-->
		</div>

		<?php return ob_get_clean();
	}

	function param_table_number_field($settings, $value) {
		ob_start(); ?>
		<div class="mad_number_block">
			<input id="<?php echo esc_attr($settings['param_name']) ?>" name="<?php echo esc_attr($settings['param_name']) ?>" class="wpb_vc_param_value wpb-number <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field'  ?>" type="number" value="<?php echo esc_attr($value) ?>"/>
		</div><!--/ .mad_number_block-->
		<?php return ob_get_clean();
	}

	function param_hidden_field($settings, $value) {
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type = isset($settings['type']) ? $settings['type'] : '';
		$class = isset($settings['class']) ? $settings['class'] : '';
		ob_start(); ?>
		<input type="hidden" name="<?php echo esc_attr($param_name) ?>" class="wpb_vc_param_value wpb_el_type_table_hidden <?php echo sanitize_html_class($param_name) . ' ' . $type . ' ' . $class ?>" value="<?php echo trim($value) ?>" />
		<?php return ob_get_clean();
	}

	function param_datetimepicker($settings, $value) {
		$dependency = '';
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type = isset($settings['type']) ? $settings['type'] : '';
		$class = isset($settings['class']) ? $settings['class'] : '';
		$uni = uniqid('datetimepicker-'.rand());
		$output = '<div id="ult-date-time' . $uni . '" class="ult-datetime"><input data-format="yyyy/MM/dd hh:mm:ss" readonly class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" style="width:258px;" value="'.$value.'" '.$dependency.'/><div class="add-on"></div></div>';
		return $output;
	}

	function param_number_field($settings, $value) {
		ob_start(); ?>
		<div class="mad_number_block">
			<input id="<?php echo esc_attr($settings['param_name']) ?>" name="<?php echo esc_attr($settings['param_name']) ?>" class="wpb_vc_param_value wpb-number <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field'  ?>" type="number" value="<?php echo esc_attr($value) ?>"/>
		</div><!--/ .mad_number_block-->
		<?php return ob_get_clean();
	}

	function get_product_terms( $term_id, $tax, $inserted_vals ) {
		$html = $selected = '';
		$args = array( 'taxonomy' => $tax, 'hide_empty' => 0, 'parent' => $term_id );
		$terms = get_terms($args);

		foreach ($terms as $term) {
			$html .= '<li><a ';

				if ( in_array($term->term_id, $inserted_vals) ) {
					$html .= ' class="selected"';
				}

				$html .= 'data-val="'. $term->term_id .'" title="'. $term->term_id .'" href="javascript:void(0);">' . $term->name . '</a>';

				if ( $list = $this->get_product_terms( $term->term_id, $tax, $inserted_vals )) {
					$html .= '<ul class="second_level">'. $list .'</ul>';
				}

			$html .= '</li>';
		}
		return $html;
	}

	function param_woocommerce_terms($settings, $value) {

		$html = '';
		$terms = get_terms(
			array(
				'taxonomy' => $settings['term'],
				'hide_empty' => 0,
				'parent' => 0
			)
		);
		$inserted_vals = explode(',', $value);

		ob_start(); ?>

		<input type="text" value="<?php echo esc_attr($value) ?>" name="<?php echo esc_attr($settings['param_name']) ?>" class="wpb_vc_param_value wpb-input mad-custom-val <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) ?>" id="<?php echo esc_attr($settings['param_name']); ?>">

		<div class="mad-custom-wrapper">

			<ul class="mad-custom">

				<?php

					foreach ($terms as $term) {
						$html .= '<li class="top_li">';

							$html .= '<a ';

							if ( in_array($term->term_id, $inserted_vals) ) {
								$html .= ' class="selected"';
							}

							$html .= 'data-val="'. $term->term_id .'" title="'. $term->term_id .'" href="javascript:void(0);">' . $term->name . '</a>';

							if ( $list = $this->get_product_terms( $term->term_id, $settings['term'], $inserted_vals )) {
								$html .= '<ul class="second_level">'. $list .'</ul>';
							}

						$html .= '</li>';
					}
					echo sprintf('%s', $html);
				?>

			</ul><!--/ .mad-custom-->

		</div><!--/ .mad-custom-wrapper-->

		<?php return ob_get_clean();
	}

	public function param_woocommerce_get_by_id($settings, $value) {

		$html = '';
		$inserted_vals = explode(',', $value);

		$args = array(
			'post_type' => $settings["post_type"],
			'numberposts' => -1
		);

		$posts = get_posts( $args );

		ob_start(); ?>

		<input type="text" value="<?php echo esc_attr($value) ?>" name="<?php echo esc_attr($settings['param_name']) ?>" class="wpb_vc_param_value wpb-input mad-custom-val <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) ?>" id="<?php echo esc_attr($settings['param_name']); ?>">

		<div class="mad-custom-wrapper">

			<ul class="mad-custom">

				<?php

				foreach ($posts as $post) {
					$html .= '<li class="top_li">';

					$html .= '<a ';

					if ( in_array($post->ID, $inserted_vals) ) {
						$html .= ' class="selected"';
					}

					$html .= 'data-val="'. $post->ID .'" title="'. $post->ID .'" href="javascript:void(0);">' . $post->post_title . '</a>';

					$html .= '</li>';
				}

				if ($html != '') { echo sprintf('%s', $html); }
				?>

			</ul><!--/ .mad-custom-->

		</div><!--/ .mad-custom-wrapper-->

		<?php return ob_get_clean();
	}

	public static function getParamTitle( $args = array() ) {

		$defaults = array(
			'title' => '',
			'tag_title' => 'h3',
			'align' => 'align-center',
			'align_des' => 'align-center',
		    'description' => '',
			'title_color' => '',
			'description_color' => ''
		);

		$args = wp_parse_args( $args, $defaults );
		$args = (object) $args;

		if ( empty($args->title) ) return;

		$style_title = $style_description = '';
		$css_classes = array( 'section-title', 'type2', $args->align );
		$desc_css_classes = array( 'cp-sub-title', 'text-size-big', $args->align_des );

		if ( $args->title_color ) {
			$style_title = 'style="' . vc_get_css_color( 'color', $args->title_color ) . '"';
		}

		if ( $args->description_color ) {
			$style_description = 'style="' . vc_get_css_color( 'color', $args->description_color ) . '"';
		}

		$css_class = implode( ' ', array_filter( $css_classes ) ); if ( $args->tag_title == 'h3' ) $css_class = '';
		$desc_css_class = implode( ' ', array_filter( $desc_css_classes ) );

		echo "<$args->tag_title {$style_title} class='". esc_attr(trim($css_class)) ."'>" . esc_html($args->title) ."</$args->tag_title>";

		if ( strlen( $args->description ) > 0 ) {
			echo "<p {$style_description} class='". esc_attr(trim($desc_css_class)) ."'>" . wpb_js_remove_wpautop($args->description) . "</p>";
		}

	}

	public static function array_number($from = 0, $to = 50, $step = 1, $array = array()) {
		for ($i = $from; $i <= $to; $i += $step) {
			$array[$i] = $i;
		}
		return $array;
	}

	public static function get_order_sort_array() {
		return array('ID' => 'ID', 'date' => 'date', 'post_date' => 'post_date', 'title' => 'title',
			'post_title' => 'post_title', 'name' => 'name', 'post_name' => 'post_name', 'modified' => 'modified',
			'post_modified' => 'post_modified', 'modified_gmt' => 'modified_gmt', 'post_modified_gmt' => 'post_modified_gmt',
			'menu_order' => 'menu_order', 'parent' => 'parent', 'post_parent' => 'post_parent',
			'rand' => 'rand', 'comment_count' => 'comment_count', 'author' => 'author', 'post_author' => 'post_author');
	}

	public function font_container_get_allowed_tags($allowed_tags) {
		array_unshift($allowed_tags, 'h1');
		return $allowed_tags;
	}

	public function wpb_content_types() {
		$wpb_content_types = array( 'post', 'page', 'portfolio', 'product', 'testimonials', 'team-members' );
		update_option('wpb_js_content_types', $wpb_content_types);
	}

	public static function create_data_string($data = array()) {
		$data_string = "";

		if (empty($data)) return;

		foreach ($data as $key => $value) {
			if (is_array($value)) $value = implode(", ", $value);
			$data_string .= " data-$key={$value} ";
		}
		return $data_string;
	}

}

/**
 * Main Visual composer manager config.
 * @var Inforward_Vc_Config $inforward_vc_config - instance of composer management.
 */
global $inforward_vc_config;
if ( ! $inforward_vc_config ) {
	$inforward_vc_config = Inforward_Vc_Config::getInstance();
}
