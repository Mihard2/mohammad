<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!class_exists('Inforward_Video_Config')) {

	class Inforward_Video_Config extends Inforward_Functionality {

		public $slug = 'video';

		function __construct() {
			$this->init();
		}

		public function init() {

			$args = array(
				'labels' => $this->getLabels(
					__('Video', 'inforward_app_textdomain'),
					__('Video', 'inforward_app_textdomain')
				),
				'public' => true,
				'exclude_from_search' => false,
				'has_archive' => true,
				'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
				'rewrite' => array('slug' => $this->slug),
				'can_export' => true,
				'menu_icon' => 'dashicons-video-alt3'
			);

			register_taxonomy("video_categories", array($this->slug), array(
				"hierarchical" => true,
				"labels" => $this->getTaxonomyLabels(
					__('Video Category', 'inforward_app_textdomain'),
					__('Video Categories', 'inforward_app_textdomain')
				),
				'query_var' => true,
				'rewrite' => true
			));

			register_post_type($this->slug, $args);

			add_filter("manage_". $this->slug ."_posts_columns", array(&$this, "show_edit_columns"));
			add_action("manage_". $this->slug ."_posts_custom_column", array(&$this, "show_edit_columns_content"));

		}

		public function show_edit_columns_content($column) {
			global $post;
			switch ($column) {
				case "thumb column-comments":
					if (has_post_thumbnail($post->ID)) {
						echo get_the_post_thumbnail($post->ID, array(60, 60));
					}
					break;
				case "video_entries":
					echo get_the_term_list($post->ID, 'video_categories', '', ', ','');
					break;
			}
		}

		public function show_edit_columns($columns) {
			$newcolumns = array(
				"cb" => "<input type=\"checkbox\" />",
				"thumb column-comments" => esc_html__('Thumb', 'inforward_app_textdomain'),
				"title" => esc_html__("Name", 'inforward_app_textdomain'),
				"video_entries" => esc_html__("Categories", 'inforward_app_textdomain')
			);

			$columns = array_merge($newcolumns, $columns);
			return $columns;
		}

		public static function get_sort_class( $id ) {
			$classes = "";
			$item_categories = get_the_terms( $id, 'video_categories' );
			if (is_object($item_categories) || is_array($item_categories)) {
				foreach ($item_categories as $cat) {
					$classes .= $cat->slug . ' ';
				}
			}
			return str_replace( '%', '', $classes );
		}

		public static function get_filter() {

			$categories = get_categories(array(
				'taxonomy'	=> 'video_categories',
				'hide_empty'=> 0
			));

			if (empty($category)) return;

			ob_start(); ?>

			<!-- - - - - - - - - - - - - - Isotope Filter - - - - - - - - - - - - - - - - -->

			<div id="filter_wrap">

				<span id="filter_btn" class="si-icon toggle_box" data-width="28" data-height="28" data-event="click" data-icon-name="filter"></span>

				<ul id="filter" class="animation_box">

					<li data-filter="*"><?php esc_html_e('All', 'inforward') ?></li>

					<?php foreach ($categories as $category): ?>
						<?php $nicename = $category->category_nicename; ?>
						<li data-filter=".<?php echo esc_attr($nicename) ?>"><?php echo esc_html(trim($category->cat_name)); ?></li>
					<?php endforeach ?>

				</ul>

			</div>

			<!-- - - - - - - - - - - - - - End of Isotope Filter - - - - - - - - - - - - - - - - -->
			<?php return ob_get_clean();

		}

	}
}
