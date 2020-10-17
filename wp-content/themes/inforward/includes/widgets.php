<?php

/*  Register Widget Areas
/* ----------------------------------------------------------------- */

if (!function_exists('inforward_widgets_register')) {

	function inforward_widgets_register () {

		$before_widget = '<div id="%1$s" class="widget %2$s">';

		$widget_args_footer = array(
			'before_widget' => $before_widget,
			'after_widget' => '</div>',
			'before_title' => '<h6 class="cp-footer-widget-title widget-title">',
			'after_title' => '</h6>'
		);
		$widget_args_sidebar = array(
			'before_widget' => $before_widget,
			'after_widget' => '</div>',
			'before_title' => '<h5 class="cp-widget-title wt-title">',
			'after_title' => '</h5>'
		);

		// General Widget Area
		register_sidebar(array(
			'name' => 'General Widget Area',
			'id' => 'general-widget-area',
			'description'   => esc_html__('For all pages and posts.', 'inforward'),
			'before_widget' => $widget_args_sidebar['before_widget'],
			'after_widget' => $widget_args_sidebar['after_widget'],
			'before_title' => $widget_args_sidebar['before_title'],
			'after_title' => $widget_args_sidebar['after_title']
		));

		for ($i = 1; $i <= 20; $i++) {
			register_sidebar(array(
				'name' => 'Footer Row - widget ' . $i,
				'id' => 'footer-row-' . $i,
				'before_widget' => $widget_args_footer['before_widget'],
				'after_widget' => $widget_args_footer['after_widget'],
				'before_title' => $widget_args_footer['before_title'],
				'after_title' => $widget_args_footer['after_title']
			));
		}
	}

	add_action( 'widgets_init', 'inforward_widgets_register' );

}

/*	Include Widgets
/* ----------------------------------------------------------------- */

if (!function_exists('inforward_unregistered_widgets')) {
	function inforward_unregistered_widgets () {
		unregister_widget( 'LayerSlider_Widget' );
	}
	add_action('widgets_init', 'inforward_unregistered_widgets', 1);
}

/*	Widget Facebook Like Box
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_like_box_facebook')) {

	class inforward_like_box_facebook extends WP_Widget {

		private static $id_of_like_box = 0;

		function __construct() {
			$widget_ops = array( 'classname' => 'like_box_facebook', 'description' => 'Like box Facebook' ); // Widget Settings
			$control_ops = array( 'id_base' => 'like_box_facebook' ); // Widget Control Settings

			parent::__construct( 'like_box_facebook', 'Like box Facebook', $widget_ops, $control_ops ); // Create the widget
		}

		function widget($args, $instance) {
			self::$id_of_like_box++;
			extract( $args );
			$title = $instance['title'];
			$profile_id = $instance['profile_id'];
			$facebook_likebox_theme = $instance['facebook_likebox_theme'];
			$width = $instance['width'];
			$height = $instance['height'];
			$connections = $instance['connections'];
			$header = ($instance['header'] == 'yes') ? 'true' : 'false';

			// Before widget //
			echo wp_kses_post($before_widget);

			// Title of widget //
			if ( $title ) { echo wp_kses_post($before_title) . $title . wp_kses_post($after_title); }

			// Widget output //
			$protocol = is_ssl() ? 'https' : 'http';
			
			echo '<iframe id="like_box_widget_'. self::$id_of_like_box .'" src="'. $protocol .'://www.facebook.com/plugins/likebox.php?href='. $profile_id .'&amp;colorscheme='. $facebook_likebox_theme .'&amp;width='. $width .'&amp;height='. $height .'&amp;connections='. $connections .'&amp;stream=false&amp;show_border=false&amp;header='. $header .'&amp;" scrolling="no" frameborder="0" allowTransparency="true" style="width:'. $width .'px; height:'. $height .'px;"></iframe>';

			echo wp_kses_post($after_widget);
		}

		// Update Settings //
		function update ($new_instance, $old_instance) {
			$instance = $old_instance;

			$instance['title'] = strip_tags($new_instance['title']);
			$instance['profile_id'] = $new_instance['profile_id'];
			$instance['facebook_likebox_theme'] = $new_instance['facebook_likebox_theme'];
			$instance['width'] = $new_instance['width'];
			$instance['height'] = $new_instance['height'];
			$instance['connections'] = $new_instance['connections'];
			$instance['header'] =  $new_instance['header'];
			return $instance;
		}

		/* admin page opions */
		function form($instance) {

			$defaults = array(
				'title' => esc_html__('Like Us on Facebook', 'inforward'),
				'profile_id' => '',
				'facebook_likebox_theme' => 'light',
				'width' => '235',
				'height' => '345',
				'connections' => 10,
				'header' => 'yes'
			);
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<p class="flb_field">
				<label for="title"><?php esc_html_e('Title', 'inforward') ?>:</label><br>
				<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" class="widefat">
			</p>

			<p class="flb_field">
				<label for="<?php echo esc_attr($this->get_field_id('profile_id')); ?>"><?php esc_html_e('Page ID', 'inforward') ?>:</label><br>
				<input id="<?php echo esc_attr($this->get_field_id('profile_id')); ?>" name="<?php echo esc_attr($this->get_field_name('profile_id')); ?>" type="text" value="<?php echo esc_attr($instance['profile_id']); ?>" class="widefat">
			</p>

			<p>
				<label><?php esc_html_e('Facebook Like box Theme', 'inforward'); ?>:</label><br>
				<select name="<?php echo esc_attr($this->get_field_name('facebook_likebox_theme')); ?>">
					<option selected="selected" value="light"><?php esc_html_e('Light', 'inforward') ?></option>
					<option value="dark"><?php esc_html_e('Dark', 'inforward') ?></option>
				</select>
			</p>

			<p class="flb_field">
				<label for="<?php echo esc_attr($this->get_field_id('width')); ?>"><?php esc_html_e('Like box Width', 'inforward') ?>:</label>
				<br>
				<input id="<?php echo esc_attr($this->get_field_id('width')); ?>" name="<?php echo esc_attr($this->get_field_name('width')); ?>" type="text" value="<?php echo esc_attr($instance['width']); ?>" class="" size="3">
				<small>(<?php esc_html_e('px', 'inforward') ?>)</small>
			</p>

			<p class="flb_field">
				<label for="<?php echo esc_attr($this->get_field_id('height')); ?>"><?php esc_html_e("Like box Height", 'inforward') ?>:</label>
				<br>
				<input id="<?php echo esc_attr($this->get_field_id('height')); ?>" name="<?php echo esc_attr($this->get_field_name('height')); ?>" type="text" value="<?php echo esc_attr($instance['height']); ?>" class="" size="3">
				<small>(<?php esc_html_e('px', 'inforward') ?>)</small>
			</p>

			<p class="flb_field">
				<label for="<?php echo esc_attr($this->get_field_id('connections')); ?>"><?php esc_html_e('Number of connections', 'inforward') ?>:</label>
				<br>
				<input id="<?php echo esc_attr($this->get_field_id('connections')); ?>" name="<?php echo esc_attr($this->get_field_name('connections')); ?>" type="text" value="<?php echo esc_attr($instance['connections']); ?>" class="" size="3">
				<small>(<?php esc_html_e("Max. 100", 'inforward') ?>)</small>
			</p>

			<p class="flb_field">
				<label><?php esc_html_e('Show Header', 'inforward') ?>:</label><br>
				<input name="<?php echo esc_attr($this->get_field_name('header')); ?>" type="radio" value="yes" <?php checked( $instance[ 'header' ], 'yes' ); ?>><?php esc_html_e("Yes", 'inforward') ?>
				<input name="<?php echo esc_attr($this->get_field_name('header')); ?>" type="radio" value="no" <?php checked( $instance[ 'header' ], 'no'); ?>><?php esc_html_e("No", 'inforward') ?>
			</p>

			<?php
		}
	}

}

if (!class_exists('inforward_widget_popular_widget')) {

	class inforward_widget_popular_widget extends WP_Widget {

		public $defaults = array();
		public $version = "1.0.1";

		function __construct() {

			parent::__construct( 'popular-widget', esc_html__('Inforward Popular and Latest Posts', 'inforward'),
				array(
					'classname' => 'widget_popular_posts',
					'description' => esc_html__("Display most popular and latest posts", 'inforward')
				)
			);

			define('INFORWARD_POPWIDGET_URL', get_template_directory_uri() . '/includes/widgets/popular-widget/');
			define('INFORWARD_POPWIDGET_ABSPATH', str_replace("\\", "/", get_template_directory() . '/includes/widgets/popular-widget'));

			$this->defaults = array(
				'title' => '',
				'link' => '',
				'counter' => false,
				'excerptlength' => 5,
				'meta_key' => '_popular_views',
				'calculate' => 'visits',
				'limit' => 3,
				'thumb' => false,
				'excerpt' => false,
				'type' => 'popular'
			);

			add_action('admin_enqueue_scripts', array(&$this, 'load_admin_styles'));
			add_action('wp_enqueue_scripts', array(&$this, 'load_scripts_styles'), 1);
			add_action('wp_ajax_popwid_page_view_count', array(&$this, 'set_post_view'));
			add_action('wp_ajax_nopriv_popwid_page_view_count', array(&$this, 'set_post_view'));

		}

		function widget($args, $instance) {
			if (file_exists(INFORWARD_POPWIDGET_ABSPATH . '/inc/widget.php')) {
				include(INFORWARD_POPWIDGET_ABSPATH . '/inc/widget.php');
			}
		}

		function form($instance) {
			if (file_exists(INFORWARD_POPWIDGET_ABSPATH . '/inc/form.php')) {
				include(INFORWARD_POPWIDGET_ABSPATH . '/inc/form.php');
			}
		}

		function update($new_instance, $old_instance) {
			foreach ($new_instance as $key => $val) {
				if (is_array($val)) {
					$new_instance[$key] = $val;
				} elseif (in_array($key, array('limit', 'excerptlength'))) {
					$new_instance[$key] = intval($val);
				} elseif (in_array($key, array('calculate'))) {
					$new_instance[$key] = trim($val, ',');
				}
			}
			if (empty($new_instance['meta_key'])) {
				$new_instance['meta_key'] = $this->defaults['meta_key'];
			}
			return $new_instance;
		}

		function load_admin_styles() {
			global $pagenow;
			if ($pagenow != 'widgets.php' ) return;

			wp_enqueue_style( 'inforward_popular-admin', INFORWARD_POPWIDGET_URL . 'css/admin.css', NULL, $this->version );
			wp_enqueue_script( 'inforward_popular-admin', INFORWARD_POPWIDGET_URL . 'js/admin.js', array('jquery',), $this->version, true );
		}

		function load_scripts_styles(){

			if (! is_admin() || is_active_widget( false, false, $this->id_base, true )) {
				wp_enqueue_script( 'inforward_popular-widget', INFORWARD_POPWIDGET_URL . 'js/pop-widget.js', array('jquery'), $this->version, true);
			}

			if (! is_singular() && ! apply_filters( 'pop_allow_page_view', false )) return;

			global $post;
			
			wp_localize_script('inforward_popular-widget', 'inforward_global_vars', array(
				'ajaxurl' => admin_url('admin-ajax.php')
			));
			
			wp_localize_script ( 'inforward_popular-widget', 'popwid', apply_filters( 'pop_localize_script_variables', array(
				'postid' => $post->ID
			), $post ));
		}

		function field_id($field) {
			echo wp_kses_post($this->get_field_id($field));
		}

		function field_name($field) {
			echo wp_kses_post($this->get_field_name($field));
		}

		function limit_words($string, $word_limit) {
			$words = explode(" ", wp_strip_all_tags(strip_shortcodes($string)));

			if ($word_limit && (str_word_count($string) > $word_limit)) {
				return $output = implode(" ",array_splice( $words, 0, $word_limit )) ."...";
			} else if( $word_limit ) {
				return $output = implode(" ", array_splice( $words, 0, $word_limit ));
			} else {
				return $string;
			}
		}

		function get_post_image($post_id, $size) {

			if (has_post_thumbnail($post_id) && function_exists('has_post_thumbnail')) {
				return get_the_post_thumbnail($post_id, $size);
			}

			$images = get_children(array(
				'order' => 'ASC',
				'numberposts' => 1,
				'orderby' => 'menu_order',
				'post_parent' => $post_id,
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
			), $post_id, $size);

			if (empty($images)) return false;

			foreach($images as $image) {
				return wp_get_attachment_image($image->ID, $size);
			}
		}

		function set_post_view() {

			if (empty($_POST['postid'])) return;
			if (!apply_filters('pop_set_post_view', true)) return;

			global $wp_registered_widgets;

			$meta_key_old = false;
			$postid = (int) $_POST['postid'];
			$widgets = get_option($this->option_name);

			foreach ((array) $widgets as $number => $widget) {
				if (!isset($wp_registered_widgets["popular-widget-{$number}"])) continue;

				$instance = $wp_registered_widgets["popular-widget-{$number}"];
				$meta_key = isset( $instance['meta_key'] ) ? $instance['meta_key'] : '_popular_views';

				if ($meta_key_old == $meta_key) continue;

				do_action( 'pop_before_set_pos_view', $instance, $number );

				if (isset($instance['calculate']) && $instance['calculate'] == 'visits') {
					if (!isset( $_COOKIE['popular_views_'.COOKIEHASH])) {
						setcookie( 'popular_views_' . COOKIEHASH, "$postid|", 0, COOKIEPATH );
						update_post_meta( $postid, $meta_key, get_post_meta( $postid, $meta_key, true ) +1 );
					} else {
						$views = explode("|", $_COOKIE['popular_views_' . COOKIEHASH]);
						foreach( $views as $post_id ){
							if( $postid == $post_id ) {
								$exist = true;  break;
							}
						}
					}
					if (empty($exist)) {
						$views[] = $postid;
						setcookie( 'popular_views_' . COOKIEHASH, implode( "|", $views ), 0 , COOKIEPATH );
						update_post_meta( $postid, $meta_key, get_post_meta( $postid, $meta_key, true ) +1 );
					}
				} else {
					update_post_meta( $postid, $meta_key, get_post_meta( $postid, $meta_key, true ) +1 );
				}
				$meta_key_old = $meta_key;
				do_action( 'pop_after_set_pos_view', $instance, $number );
			}
			die();
		}

		function get_latest_posts() {
			extract($this->instance);
			$posts = wp_cache_get("pop_latest_{$number}", 'pop_cache');

			if ($posts == false) {
				$args = array(
					'suppress_fun' => true,
					'post_type' => 'post',
					'posts_per_page' => $limit
				);
				$posts = get_posts(apply_filters('pop_get_latest_posts_args', $args));
				wp_cache_set("pop_latest_{$number}", $posts, 'pop_cache');

			}
			return $this->display_posts($posts);
		}

		function get_most_viewed() {
			extract($this->instance);
			$viewed = wp_cache_get("pop_viewed_{$number}", 'pop_cache');

			if ($viewed == false) {
				global $wpdb;  
				$join = $where = '';
				$viewed = $wpdb->get_results( $wpdb->prepare( "SELECT SQL_CALC_FOUND_ROWS p.*, meta_value as views FROM $wpdb->posts p " .
					"JOIN $wpdb->postmeta pm ON p.ID = pm.post_id AND meta_key = %s AND meta_value != '' " .
					"WHERE 1=1 AND p.post_status = 'publish' AND post_date >= '{$this->time}' AND p.post_type IN ( 'post' )" .
					"GROUP BY p.ID ORDER BY ( meta_value+0 ) DESC LIMIT $limit", $meta_key));
				wp_cache_set( "pop_viewed_{$number}", $viewed, 'pop_cache');
			}
			return $this->display_posts($viewed);
		}

		function display_posts($posts) {

			if (empty ($posts) && !is_array($posts)) return;

			extract( $this->instance );

			ob_start(); ?>

			<?php foreach ($posts as $key => $post) :
				$commentCount = get_comments_number($post->ID);
				$link = get_permalink($post->ID);
			?>
			<div class="event-item">

				<?php if ( !empty($thumb) ) { ?>

					<?php if ( has_post_thumbnail($post->ID) ): ?>

						<?php $image = Inforward_Helper::get_the_post_thumbnail($post->ID, '68*68', true, array('title' => esc_attr( $post->post_title ), 'alt' => esc_attr( $post->post_title ))); ?>

						<?php if (isset($image)): ?>
						<div class="entry-attachment">
							<a class="cp-entry-image" href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>" title="<?php echo esc_attr( $post->post_title ); ?>">
								<?php echo wp_kses_post($image); ?>
							</a>
						</div>
						<?php endif; ?>

					<?php endif; ?>

				<?php } else { ?>
				<div class="event-date type-2"></div>
				<?php }  ?>

				<div class="event-info">
				
					<h6 class="event-link">
						<a href="<?php echo esc_url(get_permalink($post->ID)) ?>"><b><?php echo esc_html($post->post_title) ?></b></a>
						<?php if ( !empty($counter) && isset($post->views) ): ?>
							<span class="cp-widget-counter">(<?php echo preg_replace( "/(?<=\d)(?=(\d{3})+(?!\d))/", ",", $post->views) ?>)</span>
						<?php endif; ?>
					</h6>
				
						<?php
						$time_string = '<time class="cp-entry-date entry-date published updated" datetime="%1$s">%2$s</time>';
						$time_string = sprintf( $time_string,
							esc_attr( get_the_date( get_the_date( 'c' ), $post->ID ) ),
							get_the_date('j F, Y', $post->ID)
						);

						printf( '%1$s', $time_string );
						?>
					
					<?php if (!empty($excerpt)): ?>
						<?php if ($post->post_excerpt): ?>
							<p class="cp-entry-post-summary"><?php echo wp_kses_post($this->limit_words( ( $post->post_excerpt ), $excerptlength )); ?></p>
						<?php else: ?>
							<p class="cp-entry-post-summary"><?php echo wp_kses_post($this->limit_words( ( $post->post_content ), $excerptlength )); ?></p>
						<?php endif; ?>
					<?php endif; ?>
		
				</div>
				
			</div>

			<?php endforeach; return ob_get_clean();
		}

	}
}

/*	Widget Social Links
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_widget_social_links')) {

	class inforward_widget_social_links extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_social_links';
			$this->widget_description =  esc_html__('Displays website social links', 'inforward');
			$this->widget_id          = 'widget-social-links';
			$this->widget_name        = esc_html__('Inforward Social Links', 'inforward');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title', 'inforward' ),
					'std'   => esc_html__( 'Follow Us', 'inforward' )
				),
				'type' => array(
					'type'  => 'select',
					'std'   => 'type1',
					'label' => esc_html__( 'Style', 'inforward' ),
					'options' => array(
						'type1' => esc_html__('Left Align', 'inforward'),
						'type2' => esc_html__('Right Align', 'inforward')
					),
					'desc' => esc_html__( 'Style widget', 'inforward' )
				),
				'linkedin_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('LinkedIn Link', 'inforward'),
					'std'   => ''
				),
				'tumblr_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Tumblr Link', 'inforward'),
					'std'   =>''
				),
				'vimeo_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Vimeo Link', 'inforward'),
					'std'   => ''
				),
				'facebook_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Facebook Link', 'inforward'),
					'std'   => ''
				),
				'flickr_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Flickr Link', 'inforward'),
					'std'   => ''
				),
				'twitter_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Twitter Link', 'inforward'),
					'std'   => ''
				),
				'gplus_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Google Plus Link', 'inforward'),
					'std'   => ''
				),
				'pinterest_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Pinterest Link', 'inforward'),
					'std'   => ''
				),
				'instagram_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Instagram Link', 'inforward'),
					'std'   => ''
				),
				'youtube_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Youtube Link', 'inforward'),
					'std'   => ''
				),
				'telegram_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Telegram Link', 'inforward'),
					'std'   => ''
				),
				'donate_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Donate Link', 'inforward'),
					'std'   => ''
				),
				'action_links'  => array(
					'type'  => 'text',
					'label' => esc_html__('Action Link', 'inforward'),
					'std'   => ''
				)
			);
			parent::__construct();
		}

		function widget($args, $instance) {
			$data = array();
			$title = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
			
			$type = isset( $instance['type'] ) ? $instance['type'] : $this->settings['type']['std'];
			$data['linkedin_links'] = isset( $instance['linkedin_links'] ) ? $instance['linkedin_links'] : $this->settings['linkedin_links']['std'];
			$data['tumblr_links'] = isset( $instance['tumblr_links'] ) ? $instance['tumblr_links'] : $this->settings['tumblr_links']['std'];
			$data['vimeo_links'] = isset( $instance['vimeo_links'] ) ? $instance['vimeo_links'] : $this->settings['vimeo_links']['std'];
			$data['facebook_links'] = isset( $instance['facebook_links'] ) ? $instance['facebook_links'] : $this->settings['facebook_links']['std'];
			$data['flickr_links'] = isset( $instance['flickr_links'] ) ? $instance['flickr_links'] : $this->settings['flickr_links']['std'];
			$data['youtube_links'] = isset( $instance['youtube_links'] ) ? $instance['youtube_links'] : $this->settings['youtube_links']['std'];
			$data['telegram_links'] = isset( $instance['telegram_links'] ) ? $instance['telegram_links'] : $this->settings['telegram_links']['std'];
			$data['twitter_links'] = isset( $instance['twitter_links'] ) ? $instance['twitter_links'] : $this->settings['twitter_links']['std'];
			$data['gplus_links'] = isset( $instance['gplus_links'] ) ? $instance['gplus_links'] : $this->settings['gplus_links']['std'];
			$data['pinterest_links'] = isset( $instance['pinterest_links'] ) ? $instance['pinterest_links'] : $this->settings['pinterest_links']['std'];
			$data['instagram_links'] = isset( $instance['instagram_links'] ) ? $instance['instagram_links'] : $this->settings['instagram_links']['std'];
			
			$data['donate_links'] = isset( $instance['donate_links'] ) ? $instance['donate_links'] : $this->settings['donate_links']['std'];
			$data['action_links'] = isset( $instance['action_links'] ) ? $instance['action_links'] : $this->settings['action_links']['std'];

			$this->widget_start( $args, $instance );
			echo '<div class="widget_social_with_icon">';
				
				echo Inforward_Helper::output_widgets_html('social_links', $data);
				
			echo '</div>';
			
			if( $data['donate_links'] != '' || $data['action_links'] != '' ) {
			echo '<div class="button-holder">';
				if($data['donate_links'] != '') {
					echo '<a href="'. esc_url($data['donate_links']) .'" class="btn btn-style-6 btn-big">'. esc_html__('Donate','inforward') .'</a>';
				}
				if($data['action_links'] != '') {
					echo '<a href="'. esc_url($data['action_links']) .'" class="btn btn-style-3 btn-big">'. esc_html__('Take Action','inforward') .'</a>';
				}
			echo '</div>';
			}
			
			$this->widget_end($args);
		}

	}
}

/*	Widget copyright
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_widget_custom_copyright')) {

	class inforward_widget_custom_copyright extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_copyright';
			$this->widget_description =  esc_html__('Displays website copyright', 'inforward');
			$this->widget_id          = 'widget-custom-copyright';
			$this->widget_name        = esc_html__('Inforward Copyright', 'inforward');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title', 'inforward' ),
					'std'   => ''
				),
				'address'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Address', 'inforward' ),
					'std'   => ''
				),
				'phone'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Phone', 'inforward' ),
					'std'   => ''
				),
				'mail'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'E-mail', 'inforward' ),
					'std'   => ''
				),
				'paid_by'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Paid by', 'inforward' ),
					'std'   => ''
				),
				'copyright'  => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Copyright', 'inforward' ),
					'std'   => ''
				)
			);
			parent::__construct();
		}

		function widget($args, $instance) {
			$title = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
			$paid_by = isset( $instance['paid_by'] ) ? $instance['paid_by'] : $this->settings['paid_by']['std'];
			$copyright = isset( $instance['copyright'] ) ? $instance['copyright'] : $this->settings['copyright']['std'];
			
			$address = isset( $instance['address'] ) ? $instance['address'] : $this->settings['address']['std'];
			$phone = isset( $instance['phone'] ) ? $instance['phone'] : $this->settings['phone']['std'];
			$mail = isset( $instance['mail'] ) ? $instance['mail'] : $this->settings['mail']['std'];
			
			$this->widget_start( $args, $instance );
				
			echo '<div class="copyright">';
				if( $address != '') {
                echo '<p class="copyright_address">'.esc_html($address).' &nbsp;|&nbsp; '.esc_html__('Phone:', 'inforward').' <span>'.esc_html($phone).'</span> &nbsp;|&nbsp; '.esc_html__('E-mail:', 'inforward').' <a href="mailto:'.antispambot($mail, 1).'" class="link-text">'.esc_html($mail).'</a></p>';
				}
				if( $paid_by != '') {
                echo '<div class="paid-by">'.esc_html($paid_by).'</div>';
				}
				if( $copyright != '' ) {
                echo wpautop($copyright);
				}  
            echo '</div>';	
				
			$this->widget_end($args);
		}

	}
}

/*	Widget Advertising Area
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_widget_advertising_area')) {

	class inforward_widget_advertising_area extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_advertising_area';
			$this->widget_description = esc_html__('An advertising widget that displays image', 'inforward');
			$this->widget_id          = __CLASS__;
			$this->widget_name        = esc_html__('Inforward Advertising Area', 'inforward');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Title', 'inforward' )
				),
				'image_url'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Image URL', 'inforward' )
				),
				'ref_url'  => array(
					'type'  => 'text',
					'std'   => '#',
					'label' => esc_html__( 'Referal URL', 'inforward' )
				),
			);

			parent::__construct();
		}

		function widget($args, $instance) {
			$title = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
			$image_url = isset( $instance['image_url'] ) ? $instance['image_url'] : $this->settings['image_url']['std'];
			$ref_url = isset( $instance['ref_url'] ) ? $instance['ref_url'] : $this->settings['ref_url']['std'];

			if (empty($image_url)) {
				$image_url = '<span>'.esc_html__('Advertise here', 'inforward').'</span>';
			} else {
				$image_url = '<img class="advertise-image" src="' . esc_url($image_url) . '" title="" alt=""/>';
			}

			ob_start(); ?>

			<?php $this->widget_start( $args, $instance ); ?>
				<a target="_blank" href="<?php echo esc_url($ref_url); ?>"><?php echo sprintf('%s', $image_url); ?></a>
			<?php $this->widget_end($args);

			echo ob_get_clean();
		}

	}
}

/*	Widget Contact Us
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_widget_contact_us')) {

	class inforward_widget_contact_us extends WP_Widget {

		function __construct() {
			$settings = array('classname' => 'widget_contact_us', 'description' => esc_html__('Displays contact us', 'inforward'));

			parent::__construct(__CLASS__, esc_html__('Inforward Contact Us', 'inforward'), $settings);
		}

		function widget($args, $instance) {
			extract($args, EXTR_SKIP);

			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$address = empty($instance['address']) ? '' : $instance['address'];
			$privacy_url = empty($instance['privacy_url']) ? '' : $instance['privacy_url'];
			$donate_url = empty($instance['donate_url']) ? '' : $instance['donate_url'];
			$phone = empty($instance['phone']) ? '' : $instance['phone'];
			$email = empty($instance['email']) ? '' : $instance['email'];
			$skype = empty($instance['skype']) ? '' : $instance['skype'];
			$align_widget = empty($instance['align_widget']) ? '' : $instance['align_widget'];

			ob_start(); ?>

			<?php echo wp_kses_post($before_widget); ?>
			<div class="align-<?php echo esc_attr($align_widget); ?>">

			<?php if ($title !== ''): ?>
				<?php echo wp_kses_post($before_title) . $title . wp_kses_post($after_title); ?>
			<?php endif; ?>

				<?php if (!empty($donate_url)): ?>
				<div class="content-element3">
                  <a href="<?php echo esc_url($donate_url); ?>" target="_blank" class="btn btn-style-6 btn-big"><?php esc_html_e('Donate', 'inforward');?></a>
                </div>
				<?php endif; ?>
			
				<p class="contact-info">

					<?php if (!empty($address)): ?>
						
						<?php echo wpautop($address); ?>
						
					<?php endif; ?>
				</p>

				<p class="contact-info-btns">
					<?php if (!empty($phone)): ?>
						<?php esc_html_e('Phone: ', 'inforward');?><span><?php echo sprintf('%s', $phone) ?></span><br>
					<?php endif; ?>

					<?php if (!empty($email)): ?>
						<?php esc_html_e('E-mail: ', 'inforward');?><a target="_blank" class="link-text" href="mailto:<?php echo antispambot($email, 1); ?>"><?php echo esc_html($email) ?></a>
					<?php endif; ?>

					<?php if (!empty($skype)): ?>
						<?php esc_html_e('Skype: ', 'inforward');?><span><?php echo sprintf('%s', $skype) ?></span>
					<?php endif; ?>
				</p>	

				<?php if (!empty($privacy_url)): ?>
				<a href="<?php echo esc_url($privacy_url); ?>"  target="_blank" class="link-text"><?php esc_html_e('Privacy Policy', 'inforward');?></a>
				<?php endif; ?>
			
			</div>
			<?php echo wp_kses_post($after_widget); ?>

			<?php echo ob_get_clean();
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			foreach($new_instance as $key => $value) {
				$instance[$key]	= strip_tags($new_instance[$key]);
			}
			return $instance;
		}

		function form($instance) {
			$defaults = array(
				'title' => esc_html__('Contact Us', 'inforward'),
				'address' => esc_html__('Adam Russell for Congress PO Box 3740, Austin, TX, 78741', 'inforward'),
				'privacy_url' => '',
				'donate_url' => '',
				'align_widget' => 'left',
				'phone' => '(932) 733-3390',
				'email' => 'info@adamrussell.com',
				'skype' => 'companyname'
			);
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<p>
				<label><?php esc_html_e('Title', 'inforward');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" type="text" />
				</label>
			</p>

			<p>
				<label><?php esc_html_e('Align', 'inforward'); ?>:</label><br>
				<select name="<?php echo esc_attr($this->get_field_name('align_widget')); ?>">
					<option <?php selected( $instance['align_widget'], 'left' ); ?>  value="left"><?php esc_html_e('Left', 'inforward') ?></option>
					<option <?php selected( $instance['align_widget'], 'right' ); ?> value="right"><?php esc_html_e('Right', 'inforward') ?></option>
				</select>
			</p>
			
			<p>
				<label><?php esc_html_e('Address', 'inforward');?>:
				<textarea class="widefat" rows="10" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr($this->get_field_name( 'address' )); ?>"><?php echo wp_kses_post($instance['address']); ?></textarea>
				</label>
			</p>
			
			<p>
				<label><?php esc_html_e('Privacy Policy URL', 'inforward');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'privacy_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'privacy_url' )); ?>" value="<?php echo esc_url($instance['privacy_url']); ?>" class="widefat" type="text"/>
				</label>
			</p>
			
			<p>
				<label><?php esc_html_e('Donate URL', 'inforward');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'donate_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'donate_url' )); ?>" value="<?php echo esc_url($instance['donate_url']); ?>" class="widefat" type="text"/>
				</label>
			</p>

			<p>
				<label><?php esc_html_e('Phone', 'inforward');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone' )); ?>" value="<?php echo wp_kses_post($instance['phone']); ?>" class="widefat" type="text"/>
				</label>
			</p>

			<p>
				<label><?php esc_html_e('E-mail', 'inforward');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'email' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'email' )); ?>" value="<?php echo wp_kses_post($instance['email']); ?>" class="widefat" type="text"/>
				</label>
			</p>

			<p>
				<label><?php esc_html_e('Skype', 'inforward');?>:
					<input id="<?php echo esc_attr($this->get_field_id( 'skype' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'skype' )); ?>" value="<?php echo wp_kses_post($instance['skype']); ?>" class="widefat" type="text"/>
				</label>
			</p>

		<?php
		}

	}
}

/*	Widget Testimonials
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_widget_testimonials')) {

	class inforward_widget_testimonials extends Inforward_Widget {

		public $entries = '';

		public function __construct() {
			$this->widget_cssclass    = 'widget_testimonials';
			$this->widget_description = esc_html__('Use this widget to add a testimonials to your site.', 'inforward');
			$this->widget_id          = 'widget-testimonials';
			$this->widget_name        = esc_html__('Inforward Testimonials', 'inforward');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Testimonials', 'inforward' ),
					'label' => esc_html__( 'Title', 'inforward' )
				),
				'count' => array(
					'type'  => 'select',
					'std'   => '-1',
					'label' => esc_html__( 'Count', 'inforward' ),
					'options' => $this->array_number(1, 11, 1, array('-1' => 'All')),
					'desc' => esc_html__( 'How many items should be displayed per page?', 'inforward' )
				),
				'type' => array(
					'type'  => 'select',
					'std'   => 'list',
					'label' => esc_html__( 'Type', 'inforward' ),
					'options' => array(
						'widgets_list' => esc_html__('List', 'inforward'),
						'widgets_carousel' => esc_html__('Carousel', 'inforward')
					),
					'desc' => esc_html__( 'How many items should be displayed per page?', 'inforward' )
				),
				'orderby' => array(
					'type'  => 'select',
					'std'   => 'date',
					'label' => esc_html__( 'Order by', 'inforward' ),
					'options' => $this->get_order_sort_array()
				)
			);

			parent::__construct();
		}

		function widget($args, $instance) {
			$count = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
			$type = isset( $instance['type'] ) ? $instance['type'] : $this->settings['type']['std'];
			$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];

			$query = array(
				'post_type' => 'testimonials',
				'orderby' => $orderby,
				'posts_per_page' => $count
			);

			$this->entries = new WP_Query($query);

			if (empty($this->entries) || empty($this->entries->posts)) return;

			$this->widget_start( $args, $instance ); ?>

			<div class="<?php echo esc_attr($type) ?>">

				<?php foreach ($this->entries->posts as $entry):
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$place = get_post_meta( $id, 'inforward_tm_place', true);
					?>
					<blockquote>
						<div class="author_info"><a href="<?php echo esc_url($link); ?>"><b><?php echo esc_html($name) ?>, <?php echo esc_html($place) ?></b></a></div>
						<p><?php echo wp_kses_post($entry->post_content); ?></p>
					</blockquote>
				<?php endforeach; ?>

			</div>

			<footer class="bottom_box">
				<a href="<?php echo esc_url(get_post_type_archive_link('testimonials')); ?>" class="button_grey middle_btn">
					<?php esc_html_e('View All Testimonials', 'inforward') ?>
				</a>
			</footer>

			<?php $this->widget_end($args);
		}

		public function array_number($from = 0, $to = 50, $step = 1, $array = array()) {
			for ($i = $from; $i <= $to; $i += $step) {
				$array[$i] = $i;
			}
			return $array;
		}

		public function get_order_sort_array() {
			return array('ID' => 'ID', 'date' => 'date', 'post_date' => 'post_date', 'title' => 'title',
				'post_title' => 'post_title', 'name' => 'name', 'post_name' => 'post_name', 'modified' => 'modified',
				'post_modified' => 'post_modified', 'modified_gmt' => 'modified_gmt', 'post_modified_gmt' => 'post_modified_gmt',
				'menu_order' => 'menu_order', 'parent' => 'parent', 'post_parent' => 'post_parent',
				'rand' => 'rand', 'comment_count' => 'comment_count', 'author' => 'author', 'post_author' => 'post_author');
		}

	}
}

/*	Widget Instagram
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_instagram_widget')) {

	class inforward_instagram_widget extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'inforward_instagram-feed';
			$this->widget_description = esc_html__( 'Displays your latest Instagram photos', 'inforward' );
			$this->widget_id          = 'inforward_instagram-feed';
			$this->widget_name        = esc_html__('Inforward Instagram', 'inforward');
			$this->settings = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Instagram', 'inforward' ),
					'label' => esc_html__( 'Title', 'inforward' )
				),
				'username'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Username', 'inforward' )
				),
				'number'  => array(
					'type'  => 'text',
					'std'   => 9,
					'label' => esc_html__( 'Number of photos', 'inforward' )
				),
				'target' => array(
					'type'  => 'select',
					'std'   => '_self',
					'label' => esc_html__( 'Open links in', 'inforward' ),
					'options' => array(
						'_self' => esc_html__('Current window (_self)', 'inforward'),
						'_blank' => esc_html__('New window (_blank)', 'inforward')
					)
				),
				'type' => array(
					'type'  => 'select',
					'std'   => 'list',
					'label' => esc_html__( 'Type', 'inforward' ),
					'options' => array(
						'list' => esc_html__('Grid Type1', 'inforward'),
						'list2' => esc_html__('Grid Type2', 'inforward'),
						'carousel' => esc_html__('Carousel', 'inforward')
					),
					'desc' => esc_html__( 'Select type', 'inforward' )
				),
				'link'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Follow Me!', 'inforward' ),
					'label' => esc_html__( 'Link text', 'inforward' )
				)
			);

			parent::__construct();
		}

		function widget( $args, $instance ) {

			$username = empty( $instance['username'] ) ? '' : $instance['username'];
			$limit = empty( $instance['number'] ) ? $this->settings['number']['std'] : $instance['number'];
			$target = empty( $instance['target'] ) ? $this->settings['target']['std'] : $instance['target'];
			$link = empty( $instance['link'] ) ? '' : $instance['link'];
			$type = empty( $instance['type'] ) ? 'list' : $instance['type'];

			$this->widget_start( $args, $instance );

			if ( $username != '' ) {

				$media_array = $this->scrape_instagram( $username, $limit );

				if ( is_wp_error( $media_array ) ) {

					echo wp_kses_post( $media_array->get_error_message() );

				} elseif($type == 'list') {

					// filter for images only?
					if ( $images_only = apply_filters( 'inforward_wpiw_images_only', FALSE ) )
						$media_array = array_filter( $media_array, array( $this, 'images_only' ) );

					// filters for custom classes
					$ulclass = apply_filters( 'inforward_wpiw_list_class', 'instagram-feed two-cols' );
					$liclass = apply_filters( 'inforward_wpiw_item_class', 'nv-instafeed-item' );
					$aclass = apply_filters( 'inforward_wpiw_a_class', 'fancybox' );
					$imgclass = apply_filters( 'inforward_wpiw_img_class', '' );

					?><div class="<?php echo esc_attr( $ulclass ); ?>"><?php
					foreach ( $media_array as $item ) {
						echo '<div class="'. esc_attr( $liclass ) .'"><a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  data-fancybox="instagram" class="'. esc_attr( $aclass ) .'"><img src="'. esc_url( $item['large'] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"  class="'. esc_attr( $imgclass ) .'"/></a></div>';
					}
					?></div>
                    
					 <?php if ( $link != '' ) {
				?><p class="clear"><a href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" class="info-btn" rel="me" target="<?php echo esc_attr( $target ); ?>"><?php echo wp_kses_post( $link ); ?></a></p><?php
			}?>
            
					<?php
				} elseif($type == 'list2') {

					// filter for images only?
					if ( $images_only = apply_filters( 'inforward_wpiw_images_only', FALSE ) )
						$media_array = array_filter( $media_array, array( $this, 'images_only' ) );

					// filters for custom classes
					$ulclass = apply_filters( 'inforward_wpiw_list_class', 'instagram-feed two-cols' );
					$liclass = apply_filters( 'inforward_wpiw_item_class', 'nv-instafeed-item' );
					$aclass = apply_filters( 'inforward_wpiw_a_class', 'fancybox' );
					$imgclass = apply_filters( 'inforward_wpiw_img_class', '' );

					?>
                    <div class="widget-instagram instagram_grid_type2">

              			<header></header>
              
                    <div class="<?php echo esc_attr( $ulclass ); ?>"><?php
					foreach ( $media_array as $item ) {
						echo '<div class="'. esc_attr( $liclass ) .'"><a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  data-fancybox="instagram" class="'. esc_attr( $aclass ) .'"><img src="'. esc_url( $item['large'] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"  class="'. esc_attr( $imgclass ) .'"/></a></div>';
					}
					?>
					
					
                    </div>
                    
                     <?php if ( $link != '' ) {
						?><p class="clear"><a href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" class="info-btn" rel="me" target="<?php echo esc_attr( $target ); ?>"><?php echo wp_kses_post( $link ); ?></a></p><?php
					}?>
					
                    </div>
					
					<?php	
				} elseif($type == 'carousel') {

					// filter for images only?
					if ( $images_only = apply_filters( 'inforward_wpiw_images_only', FALSE ) )
						$media_array = array_filter( $media_array, array( $this, 'images_only' ) );

					// filters for custom classes
					$ulclass = apply_filters( 'inforward_wpiw_list_class', 'instagram-feed instagram-carousel' );
					$liclass = apply_filters( 'inforward_wpiw_item_class', 'nv-instafeed-item' );
					$aclass = apply_filters( 'inforward_wpiw_a_class', 'fancybox' );
					$imgclass = apply_filters( 'inforward_wpiw_img_class', '' );

					?><div class="carousel-type-2 type-2"><div class="owl-carousel <?php echo esc_attr( $ulclass ); ?>"><?php
					foreach ( $media_array as $item ) {
						echo '<div class="'. esc_attr( $liclass ) .'"><a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  data-fancybox="instagram" class="'. esc_attr( $aclass ) .'"><img src="'. esc_url( $item['large'] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"  class="'. esc_attr( $imgclass ) .'"/></a></div>';
					}
					?></div></div>
					
                    <?php if ( $link != '' ) {
				?><p class="clear"><a href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" class="info-btn" rel="me" target="<?php echo esc_attr( $target ); ?>"><?php echo wp_kses_post( $link ); ?></a></p><?php
			}?>
					<?php
				}
			}

			$this->widget_end($args);
		}

		function scrape_instagram( $username, $slice = 9 ) {

			global $wp_version;
			$proxies = array(
				'https://boomproxy.com/browse.php?u=',
				'https://us.hidester.com/proxy.php?u=',
				'https://proxy-us1.toolur.com/browse.php?u=',
				'https://proxy-fr1.toolur.com/browse.php?u=',
			);
			$username = trim( strtolower( $username ) );
			switch ( substr( $username, 0, 1 ) ) {
				case '#':
					$url              = 'https://www.instagram.com/explore/tags/' . str_replace( '#', '', $username ) . '?__a=1';
					$transient_prefix = 'h';
					break;
				default:
					$url              = 'https://www.instagram.com/' . str_replace( '@', '', $username ) . '?__a=1';
					$transient_prefix = 'u';
					break;
			}
			if ( $proxy = apply_filters( 'wpiw_proxy', false ) ) {
				$url = $proxies[ array_rand( $proxies ) ] . urlencode( $url );
			}

			if ( false === ( $instagram = get_transient( 'wpiw-01-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) ) ) ) {

				$remote = wp_remote_get( $url, array(
					'user-agent' => 'Instagram/' . $wp_version . '; ' . home_url()
				) );
				

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'inforward' ) );
				}

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'inforward' ) );
				}

				$insta_array = json_decode( $remote['body'], true );
				if ( ! $insta_array ) {
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data1.', 'inforward' ) );
				}
				if ( isset( $insta_array['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
					$images = $insta_array['graphql']['user']['edge_owner_to_timeline_media']['edges'];
				} elseif ( isset( $insta_array['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
					$images = $insta_array['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
				} else {
					return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data2.', 'inforward' ) );
				}
				if ( ! is_array( $images ) ) {
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data3.', 'inforward' ) );
				}
				$instagram = array();
				
				

				foreach ( $images as $image ) {

					$image['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_src'] );
					$image['display_src'] = preg_replace( '/^https?\:/i', '', $image['node']['display_url'] );

					if ( (strpos( $image['thumbnail_src'], 's640x640' ) !== false ) ) {
						$image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
						$image['small'] = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
					} else {
						$urlparts = wp_parse_url( $image['thumbnail_src'] );
						$pathparts = explode( '/', $urlparts['path'] );
						array_splice( $pathparts, 3, 0, array( 's160x160' ) );
						$image['thumbnail'] = '//' . $urlparts['host'] . implode('/', $pathparts);
						$pathparts[3] = 's320x320';
						$image['small'] = '//' . $urlparts['host'] . implode('/', $pathparts);
					}

					$image['large'] = $image['thumbnail_src'];

					if ( $image['node']['is_video'] == true ) {
						$type = 'video';
					} else {
						$type = 'image';
					}

					$caption = esc_html__( 'Instagram Image', 'inforward' );
					if ( ! empty( $image['node']['caption'] ) ) {
						$caption = $image['node']['caption'];
					}

					$instagram[] = array(
						'description'   => $caption,
						'link'		  	=> '//instagram.com/p/' . $image['node']['shortcode'],
						'thumbnail'	 	=> $image['thumbnail'],
						'small'			=> $image['small'],
						'large'			=> $image['large'],
						'original'		=> $image['display_src'],
						'type'		  	=> $type
					);
				}

				// do not set an empty transient - should help catch private or empty accounts
				if ( ! empty( $instagram ) ) {
					$instagram = base64_encode( serialize( $instagram ) );
					set_transient( 'wpiw-01-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 3 ) );
					} else {
						$instagram = base64_encode( serialize( array() ) );
						set_transient( 'wpiw-01-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', MINUTE_IN_SECONDS * 10 ) );
					}
			}

			if ( ! empty( $instagram ) ) {

				$instagram = unserialize( base64_decode( $instagram ) );
				return array_slice( $instagram, 0, $slice );

			} else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'inforward' ) );

			}
		}

		function images_only( $media_item ) {
			if ( $media_item['type'] == 'image' )
				return true;

			return false;
		}
	}

}


/*	Widget Instagram
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_instagram_widget2')) {

	class inforward_instagram_widget2 extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'inforward_instagram-feed';
			$this->widget_description = esc_html__( 'Displays your latest Instagram photos', 'jogasana' );
			$this->widget_id          = 'inforward_instagram-feed';
			$this->widget_name        = esc_html__('Inforward Instagram', 'jogasana');
			$this->settings = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Instagram', 'jogasana' ),
					'label' => esc_html__( 'Title', 'jogasana' )
				),
				'cols'  => array(
					'type'  => 'text',
					'std'   => 3,
					'label' => esc_html__( 'Number of columns', 'jogasana' )
				),
				'number'  => array(
					'type'  => 'text',
					'std'   => 9,
					'label' => esc_html__( 'Number of photos', 'jogasana' )
				),
				'type' => array(
					'type'  => 'select',
					'std'   => 'list',
					'label' => esc_html__( 'Type', 'inforward' ),
					'options' => array(
						'list' => esc_html__('Grid Type1', 'inforward'),
						'list2' => esc_html__('Grid Type2', 'inforward')
					),
					'desc' => esc_html__( 'Select type', 'inforward' )
				),
				'link'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Follow Me!', 'jogasana' ),
					'label' => esc_html__( 'Link text', 'jogasana' )
				)
			);

			parent::__construct();
		}

		function widget( $args, $instance ) {

			$username = empty( $instance['username'] ) ? '' : $instance['username'];
			
			$type = empty( $instance['type'] ) ? 'list' : $instance['type'];
			$tag_name = empty( $instance['tag_name'] ) ? '' : $instance['tag_name'];
			$user_id = empty( $instance['user_id'] ) ? '' : $instance['user_id'];
			$access_token = empty( $instance['access_token'] ) ? '' : $instance['access_token'];
			$client_id = empty( $instance['client_id'] ) ? '' : $instance['client_id'];
			
			$cols = empty( $instance['cols'] ) ? $this->settings['cols']['std'] : $instance['cols'];
			$limit = empty( $instance['number'] ) ? $this->settings['number']['std'] : $instance['number'];
			$target = empty( $instance['target'] ) ? $this->settings['target']['std'] : $instance['target'];
			$link = empty( $instance['link'] ) ? '' : $instance['link'];
			
			$this->widget_start( $args, $instance );
			?>

				<?php if($type == 'list') { ?>
				
				<?php echo do_shortcode('[instagram-feed cols='.$cols.' num='.$limit.' followtext="'.$link.'" ]'); ?>
				
				<?php } elseif($type == 'list2') { ?>
				
				<div class="widget-instagram instagram_grid_type2">
				<header></header>
				
				<?php echo do_shortcode('[instagram-feed cols='.$cols.' num='.$limit.' followtext="'.$link.'" ]'); ?>
				
				</div>
				
				<?php } ?>

			
			<?php $this->widget_end($args);
		}

	}

}




/*	Widget Flickr
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_widget_flickr')) {

	class inforward_widget_flickr extends WP_Widget {

		function __construct() {
			$settings = array('classname' => 'widget_flickr', 'description' => esc_html__('Flickr feed widget', 'inforward'));
			parent::__construct(__CLASS__,  esc_html__('Inforward Flickr feed', 'inforward'), $settings);
		}

		function widget($args, $instance) {
			extract($args, EXTR_SKIP);

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$unique_id = rand(0, 300);

			echo wp_kses_post($before_widget);

			if ($title !== '') {
				echo wp_kses_post($before_title) . $title . wp_kses_post($after_title);
			}

			?>

			<ul id="flickr_feed_<?php echo absint($unique_id) ?>" class="flickr_feed"></ul>

			<script type="text/javascript">
				jQuery(function () {
					jQuery('#flickr_feed_<?php echo absint($unique_id) ?>').jflickrfeed({
						limit: <?php echo absint($instance['imagescount']) ?>,
						qstrings: { id: '<?php echo esc_attr($instance['username']) ?>' },
						itemTemplate: '<li><a class="fancybox" target="_blank" href="{{image_b}}"><img width="100" height="100" src="{{image_s}}" alt="{{title}}" /></a></li>'
					}, function() {
						jQuery(this).find('.fancybox').fancybox();
					});
				});
			</script>

			<?php echo wp_kses_post($after_widget);
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['username'] = $new_instance['username'];
			$instance['imagescount'] = (int) $new_instance['imagescount'];
			return $instance;
		}

		function form($instance) {
			$defaults = array(
				'title' => 'Flickr Feed',
				'username' => '76745153@N04',
				'imagescount' => '8',
			);
			$instance = wp_parse_args((array) $instance, $defaults); ?>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'inforward') ?>:</label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('username')); ?>"><?php esc_html_e('Flickr Username', 'inforward') ?>:</label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('username')); ?>" name="<?php echo esc_attr($this->get_field_name('username')); ?>" value="<?php echo esc_attr($instance['username']); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('imagescount')); ?>"><?php esc_html_e('Number of images', 'inforward') ?>:</label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('imagescount')); ?>" name="<?php echo esc_attr($this->get_field_name('imagescount')); ?>" value="<?php echo esc_attr($instance['imagescount']); ?>" />
			</p>

		<?php
		}

	}
}

/*	Widget text with icon
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_widget_text_icon')) {

	class inforward_widget_text_icon extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_text_icon';
			$this->widget_description = esc_html__('Widget text with icon', 'inforward');
			$this->widget_id          = __CLASS__;
			$this->widget_name        = esc_html__('Inforward Text With Icon', 'inforward');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Title', 'inforward' )
				),
				'info'  => array(
					'type'  => 'textarea',
					'std'   => '',
					'label' => esc_html__( 'Info', 'inforward' )
				),
				'icon'  => array(
					'type'  => 'icon',
					'std'   => 'licon-map-marker',
					'label' => esc_html__( 'Icon', 'inforward' )
				),
				'btn_url'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Button URL', 'inforward' )
				),
				'target' => array(
					'type'  => 'select',
					'std'   => '_blank',
					'label' => esc_html__( 'Open link', 'inforward' ),
					'options' => array(
						'_blank' => esc_html__('Open in new window', 'inforward'),
						'_self' => esc_html__('Open in current', 'inforward'),
					)
				),
				'm_bottom'  => array(
					'type'  => 'number',
					'std'   => 0,
					'label' => esc_html__( 'Margin Bottom(px)', 'inforward' )
				),
				'type' => array(
					'type'  => 'select',
					'std'   => 'default',
					'label' => esc_html__( 'Type', 'inforward' ),
					'options' => array(
						'default' => esc_html__('Type 1', 'inforward'),
						'register' => esc_html__('Type 2', 'inforward'),
						'event' => esc_html__('Type 3', 'inforward'),
						'get-involved' => esc_html__('Type 4', 'inforward'),
						'donate' => esc_html__('Type 5', 'inforward')
					)
				),
			);

			parent::__construct();
		}

		function widget($args, $instance) {
			$title = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
			$info = isset( $instance['info'] ) ? $instance['info'] : $this->settings['info']['std'];
			$icon = isset( $instance['icon'] ) ? $instance['icon'] : $this->settings['icon']['std'];
			$btn_url = isset( $instance['btn_url'] ) ? $instance['btn_url'] : $this->settings['btn_url']['std'];
			$type = isset( $instance['type'] ) ? $instance['type'] : $this->settings['type']['std'];
			$m_bottom = isset( $instance['m_bottom'] ) ? $instance['m_bottom'] : $this->settings['m_bottom']['std'];
			$target = isset( $instance['target'] ) ? $instance['target'] : $this->settings['target']['std'];

			ob_start(); ?>

			<div class="widget_text_with_icon action-widget type-vr" style="margin-bottom: <?php echo esc_attr($m_bottom); ?>px">
            <a href="<?php echo esc_url($btn_url); ?>" target="<?php echo esc_attr($target); ?>" class="action-item <?php echo esc_attr($type); ?>">
                <i class="icon <?php echo esc_attr($icon); ?>"></i>
                <h5 class="action-title"><b><?php echo esc_html($title); ?></b></h5>
                <?php echo wpautop($info); ?>
              </a>
			</div>
			<?php 

			echo ob_get_clean();
		}

	}
}


/*	Widget banner with icon
/* ----------------------------------------------------------------- */

if (!class_exists('inforward_widget_banner_icon')) {

	class inforward_widget_banner_icon extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_banner_icon';
			$this->widget_description = esc_html__('Widget Banner with icon', 'inforward');
			$this->widget_id          = __CLASS__;
			$this->widget_name        = esc_html__('Inforward Banner With Icon', 'inforward');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Title', 'inforward' )
				),
				'info'  => array(
					'type'  => 'textarea',
					'std'   => '',
					'label' => esc_html__( 'Info', 'inforward' )
				),
				'btn_title'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Button Title', 'inforward' )
				),
				'btn_url'  => array(
					'type'  => 'text',
					'std'   => '',
					'label' => esc_html__( 'Button URL', 'inforward' )
				),
				'icon'  => array(
					'type'  => 'icon',
					'std'   => 'licon-map-marker',
					'label' => esc_html__( 'Icon', 'inforward' )
				),
			);

			parent::__construct();
		}

		function widget($args, $instance) {
			$title = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
			$btn_title = isset( $instance['btn_title'] ) ? $instance['btn_title'] : $this->settings['btn_title']['std'];
			$btn_url = isset( $instance['btn_url'] ) ? $instance['btn_url'] : $this->settings['btn_url']['std'];
			$info = isset( $instance['info'] ) ? $instance['info'] : $this->settings['info']['std'];
			$icon = isset( $instance['icon'] ) ? $instance['icon'] : $this->settings['icon']['std'];

			ob_start(); ?>

			<div class="widget">
		        			
				<a href="<?php echo esc_url($btn_url); ?>" target="_blank" class="banner-item">
					<div class="banner-inner">
						<i class="<?php echo esc_attr($icon); ?>"></i>
						<h5 class="banner-title"><?php echo wp_kses_post($title); ?></h5>
						<?php echo wpautop($info); ?>
						<div class="btn btn-small"><?php echo esc_html($btn_title); ?></div>
					</div>
				</a>

			</div>
				
			<?php 

			echo ob_get_clean();
		}

	}
}

/*	Widget Custom Pages
/* ----------------------------------------------------------------- */
if (!class_exists('inforward_widget_custom_pages')) {

	class inforward_widget_custom_pages extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => esc_html__('Add a custom menu to your footer sidebar.', 'inforward') );
		parent::__construct( 'popular_categories_custom', esc_html__('Inforward Custom Menu Bottom', 'inforward'), $widget_ops );
	}
	function widget($args, $instance) {

		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$args1 = array(
			'sort_order'   => 'ASC',
			'sort_column'  => 'post_title',
			'hierarchical' => 1,
			'exclude'      => '',
			'include'      =>  $instance['nav_menu'],
			'meta_key'     => '',
			'meta_value'   => '',
			'authors'      => '',
			'child_of'     => 0,
			'parent'       => -1,
			'exclude_tree' => '',
			'number'       => '',
			'offset'       => 0,
			'post_type'    => 'page',
			'post_status'  => 'publish',
			);
		$categories = get_pages( $args1 );
		
		
		
		$args2 = array(
			'sort_order'   => 'ASC',
			'sort_column'  => 'post_title',
			'hierarchical' => 1,
			'exclude'      => '',
			'include'      =>  $instance['nav_menu2'],
			'meta_key'     => '',
			'meta_value'   => '',
			'authors'      => '',
			'child_of'     => 0,
			'parent'       => -1,
			'exclude_tree' => '',
			'number'       => '',
			'offset'       => 0,
			'post_type'    => 'page',
			'post_status'  => 'publish',
			);
		$categories2 = get_pages( $args2 );
		
		echo wp_kses_post($args['before_widget']);
		
		if ( !empty($instance['title']) ) {
			echo wp_kses_post($args['before_title']) . esc_attr($instance['title']) . wp_kses_post($args['after_title']);
		}
		
        echo '<div class="row">';	
		
		
		if( $categories ){
				
				echo '<div class="col-xs-6"><ul class="info-links">';
				foreach( $categories as $page ){
					
					
					echo '<li><a href="' . get_page_link( $page->ID ) . '">'. $page->post_title .'</a></li>';
				}
				echo '</ul></div>';
			}
		
		if( $categories2 ){
				
				echo '<div class="col-xs-6"><ul class="info-links">';
				foreach( $categories2 as $page ){
					echo '<li><a href="' . get_page_link( $page->ID ) . '">'. $page->post_title .'</a></li>';
				}
				echo '</ul></div>';
			}
		
		 echo '</div>';	
		
		echo wp_kses_post($args['after_widget']);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['nav_menu'] =  $new_instance['nav_menu'];
		$instance['nav_menu2'] =  $new_instance['nav_menu2'];
		
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'nav_menu' => '', 'nav_menu2' => '') );
		$title = esc_attr( $instance['title'] );
		$nav_menu = esc_attr($instance['nav_menu'] ); 
		$nav_menu2 = esc_attr($instance['nav_menu2'] );

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'inforward') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<p>
				<label for="<?php echo esc_attr($this->get_field_id('nav_menu')); ?>"><?php esc_html_e('Include pages ID in left part', 'inforward') ?>:</label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('nav_menu')); ?>" name="<?php echo esc_attr($this->get_field_name('nav_menu')); ?>" value="<?php echo esc_attr($instance['nav_menu']); ?>" />
		</p>
			
		<p>
				<label for="<?php echo esc_attr($this->get_field_id('nav_menu2')); ?>"><?php esc_html_e('Include pages ID in right part', 'inforward') ?>:</label>
				<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('nav_menu2')); ?>" name="<?php echo esc_attr($this->get_field_name('nav_menu2')); ?>" value="<?php echo esc_attr($instance['nav_menu2']); ?>" />
		</p>

		<?php
	}
	}
}


/*	Widget footer banners
/* ----------------------------------------------------------------- */
if (!class_exists('inforward_widget_footer_banners')) {

	class inforward_widget_footer_banners extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_footer_banners';
			$this->widget_description =  esc_html__('Displays footer banners', 'inforward');
			$this->widget_id          = 'widget-footer-banners';
			$this->widget_name        = esc_html__('Inforward footer banners', 'inforward');
			$this->settings           = array(
				'title1'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title 1', 'inforward' ),
					'std'   => ''
				),
				'url1'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'URL 1', 'inforward' ),
					'std'   => ''
				),
				'title2'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title 2', 'inforward' ),
					'std'   => ''
				),
				'url2'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'URL 2', 'inforward' ),
					'std'   => ''
				),
				'title3'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title 3', 'inforward' ),
					'std'   => ''
				),
				'url3'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'URL 3', 'inforward' ),
					'std'   => ''
				),
				
			);
			parent::__construct();
		}

		function widget($args, $instance) {
			$title1 = isset( $instance['title1'] ) ? $instance['title1'] : $this->settings['title1']['std'];
			$title2 = isset( $instance['title2'] ) ? $instance['title2'] : $this->settings['title2']['std'];
			$title3 = isset( $instance['title3'] ) ? $instance['title3'] : $this->settings['title3']['std'];
			$url1 = isset( $instance['url1'] ) ? $instance['url1'] : $this->settings['url1']['std'];
			$url2 = isset( $instance['url2'] ) ? $instance['url2'] : $this->settings['url2']['std'];
			$url3 = isset( $instance['url3'] ) ? $instance['url3'] : $this->settings['url3']['std'];
			?>
			
			<div class="action-widget style-2 action-col-3">
      
				<div class="container">
				  
				  <div class="action-col">
					
					<a href="<?php echo esc_url($url1);?>" class="action-item register">
					  <i class="icon icon-basic-todo-txt"></i>
					  <h5 class="action-title"><?php echo esc_html($title1);?></h5>
					</a>
					
				  </div>

				  <div class="action-col">
					
					<a href="<?php echo esc_url($url2);?>" class="action-item get-involved">
					  <i class="icon icon-ecommerce-megaphone"></i>
					  <h5 class="action-title"><?php echo esc_html($title2);?></h5>
					</a>
					
				  </div>

				  <div class="action-col">
					
					<a href="<?php echo esc_url($url3);?>" class="action-item event">
					  <i class="icon icon-basic-calendar"></i>
					  <h5 class="action-title"><?php echo esc_html($title3);?></h5>
					</a>
					
				  </div>

				</div>

			</div>
			
			<?php	
			
		}

	}
}

/*	Widget Mailchimp
/* ----------------------------------------------------------------- */
if (!class_exists('inforward_widget_mailchimp')) {

	class inforward_widget_mailchimp extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_mailchimp';
			$this->widget_description =  esc_html__('Use this widget to add a mailchimp newsletter to your site.', 'inforward');
			$this->widget_id          = 'widget-mailchimp';
			$this->widget_name        = esc_html__('Inforward Newsletter', 'inforward');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title', 'inforward' ),
					'std'   => esc_html__( 'Newsletter', 'inforward' )
				),
				'info'  => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Info', 'inforward' ),
					'std'   => ''
				),
				'mailchimp_api'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Mailchimp api', 'inforward' ),
					'std'   => ''
				),
				'mailchimp_id'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Mailchimp id', 'inforward' ),
					'std'   => ''
				),
				'mailchimp_center'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Mailchimp center', 'inforward' ),
					'std'   => ''
				),
				'type_input' => array(
					'type'  => 'select',
					'std'   => 'email',
					'label' => esc_html__( 'Type', 'inforward' ),
					'options' => array(
						'email' => esc_html__('E-mail', 'inforward'),
						'tel' => esc_html__('Phone', 'inforward')
					)
				), 
				'type' => array(
					'type'  => 'select',
					'std'   => 'type_1',
					'label' => esc_html__( 'Type', 'inforward' ),
					'options' => array(
						'type_1' => esc_html__('Type 1', 'inforward'),
						'type_2' => esc_html__('Type 2', 'inforward'),
						'type_3' => esc_html__('Type 3', 'inforward'),
						'type_4' => esc_html__('Type 4', 'inforward'),
						'type_5' => esc_html__('Type 5', 'inforward')
					)
				),
			);
			parent::__construct();
		}

		function widget($args, $instance) {
			global $inforward_settings;
			
			$title = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
			$info = isset( $instance['info'] ) ? $instance['info'] : $this->settings['info']['std'];
			
			$mailchimp_api = isset( $instance['mailchimp_api'] ) ? $instance['mailchimp_api'] : $this->settings['mailchimp_api']['std'];
			$mailchimp_id = isset( $instance['mailchimp_id'] ) ? $instance['mailchimp_id'] : $this->settings['mailchimp_id']['std'];
			$mailchimp_center = isset( $instance['mailchimp_center'] ) ? $instance['mailchimp_center'] : $this->settings['mailchimp_center']['std'];
			
			$type = isset( $instance['type'] ) ? $instance['type'] : $this->settings['type']['std'];
			$type_input = isset( $instance['type_input'] ) ? $instance['type_input'] : $this->settings['type_input']['std'];
			
			$input_text = '';
			$btn_text = '';
			
			
			
			if($type_input == 'tel') {
				$input_text = '<input type="email" name="newsletter-email" placeholder="'. esc_html__('Email','inforward') .'">';
				$input_text .= '<input type="tel" name="phone" placeholder="'. esc_html__('Phone','inforward') .'">';
				$btn_text = esc_html__('Submit','inforward');
			} else {
				$input_text = '<input type="email" name="newsletter-email" placeholder="'. esc_html__('Email address','inforward') .'">';
				$btn_text = esc_html__('Sign Up','inforward');
			}
			
			$data_mailchimp_api = $inforward_settings['mailchimp-api']; 
			$data_mailchimp_id = $inforward_settings['mailchimp-id']; 
			$data_mailchimp_center = $inforward_settings['mailchimp-center'];
			
			if($mailchimp_api != '') {
				$data_mailchimp_api = $mailchimp_api;
			}
			if($mailchimp_id != '') {
				$data_mailchimp_id = $mailchimp_id;
			}
			if($mailchimp_center != '') {
				$data_mailchimp_center = $mailchimp_center;
			}
			
			if ( $data_mailchimp_api == '' ) {
				return;
			}
			
			$input_text .= '<input type="hidden" name="mailchimp_api" value="'.$data_mailchimp_api.'">';
			$input_text .= '<input type="hidden" name="mailchimp_id" value="'.$data_mailchimp_id.'">';
			$input_text .= '<input type="hidden" name="mailchimp_center" value="'.$data_mailchimp_center.'">';
			?>
            
            
           <?php if ($type == 'type_1') { ?>
            <div class="widget widget_mailchimp widget_mailchimp_type_1">
			<?php 
			if ($title !== '') {
				echo wp_kses_post($args['before_title']) . $title . wp_kses_post($args['after_title']);
			}
			?>
			
			<div class="join-us style-2">
			
				<?php 
				if ($info !== '') {
					echo '<p class="cp-newsletter-info">' . $info . '</p>';
				}
				?>
				
				<form class="join-form cp_newsletter type_<?php echo esc_attr($type_input); ?>" action="#" method="POST">

					
					<div class="input-holder">
						<?php echo sprintf('%s', $input_text); ?>
						<input type="text" name="zip" placeholder="<?php echo esc_html__('Zip code','inforward') ?>">
					</div>
					<button type="submit" name="signup_submit" class="cp_newsletter-submit signup_submit btn btn-style-4 btn-big" data-type="submit"><span class="ajax-loader"></span><?php echo esc_html($btn_text); ?></button>
					
<?php if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>						
					<div class="comment-form-cookies-consent"><input id="form-cookies-consent1" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-consent1"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>
					
					<div class="message-container-subscribe"></div>
						
				</form>
			</div>
            </div>
            <?php } elseif ($type == 'type_2') { ?>	
			
            <div class="widget widget_mailchimp widget_mailchimp_type_2 widget-bg2">
			<?php 
			if ($title !== '') {
				echo wp_kses_post($args['before_title']) . $title . wp_kses_post($args['after_title']);
			}
			?>
			
			<div class="join-us style-4">
			
				<?php 
				if ($info !== '') {
					echo '<p class="cp-newsletter-info">' . $info . '</p>';
				}
				?>
			
				<form class="join-form cp_newsletter type_<?php echo esc_attr($type_input); ?>" action="#" method="POST">

					<?php echo sprintf('%s', $input_text); ?>
					<input type="text" name="zip" placeholder="<?php echo esc_html__('Zip code','inforward') ?>">
				
					<button type="submit" name="signup_submit" class="cp_newsletter-submit signup_submit btn btn-style-6 btn-big" data-type="submit"><span class="ajax-loader"></span><?php echo esc_html($btn_text); ?></button>
					
<?php if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>						
					<div class="comment-form-cookies-consent"><input id="form-cookies-consent2" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-consent2"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>

					<div class="message-container-subscribe"></div>
						
				</form>
			</div>
            </div>
            
            <?php } elseif ($type == 'type_3') { ?>	
			
            <div class="widget widget_mailchimp widget_mailchimp_type_3">
			<?php 
			if ($title !== '') {
				echo wp_kses_post($args['before_title']) . $title . wp_kses_post($args['after_title']);
			}
			?>
			
			<div class="join-us">
			
				<?php 
				if ($info !== '') {
					echo '<p class="cp-newsletter-info">' . $info . '</p>';
				}
				?>
				
				<form class="join-form cp_newsletter type_<?php echo esc_attr($type_input); ?>" action="#" method="POST">

					<button type="submit" name="signup_submit" class="cp_newsletter-submit signup_submit btn btn-style-6 btn-big f-right" data-type="submit"><span class="ajax-loader"></span><?php echo esc_html($btn_text); ?></button>
					<div class="input-holder">
						<?php echo sprintf('%s', $input_text); ?>
						<input type="text" name="zip" placeholder="<?php echo esc_html__('Zip code','inforward') ?>">
					</div>
				
<?php if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>				
					<div class="comment-form-cookies-consent"><input id="form-cookies-consent3" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-consent3"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>
					
					<div class="message-container-subscribe"></div>
						
				</form>
			</div>
            
            </div>
            
            <?php } elseif ($type == 'type_4') { ?>	
			
            <div class="widget widget_mailchimp widget_mailchimp_type_4 land-item">
            <i class="icon icon-basic-mail"></i>
			<?php 
			if ($title !== '') {
				echo '<h6 class="land-item-title">' . $title . '</h6>';
			}
			?>
			
			<div class="join-us style-3">
			
				<?php 
				if ($info !== '') {
					echo '<p class="cp-newsletter-info">' . $info . '</p>';
				}
				?>
				
				<form class="join-form cp_newsletter type_<?php echo esc_attr($type_input); ?>" action="#" method="POST">

					<button type="submit" name="signup_submit" class="cp_newsletter-submit signup_submit btn btn-style-4 btn-big f-right" data-type="submit"><span class="ajax-loader"></span><?php echo esc_html($btn_text); ?></button>
					<div class="input-holder">
						<?php echo sprintf('%s', $input_text); ?>
						<input type="text" name="zip" placeholder="<?php echo esc_html__('Zip code','inforward') ?>">
					</div>

<?php if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>						
					<div class="comment-form-cookies-consent"><input id="form-cookies-consent4" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-consent4"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>
					
					<div class="message-container-subscribe"></div>
						
				</form>
			</div>
            
            </div>
            
             <?php } elseif ($type == 'type_5') { ?>	
			<div class="get-mobile-section align-center">
        
            <div class="get-mobile">
              
              <div class="container">
                <div class="row">
                  <div class="col-sm-6">
                    <?php 
					if ($title !== '') {
						echo '<h3 class="cp-widget-title"><b>' . $title . '</b></h3>';
					}
					?>
                    <?php 
					if ($info !== '') {
						echo '<p class="cp-newsletter-info">' . $info . '</p>';
					}
					?>
                  </div>
                  
                  <div class="col-sm-6">
                    
                        <div class="search-holder">
                          <form class="join-form cp_newsletter type_<?php echo esc_attr($type_input); ?>" action="#" method="POST">
                            <button type="submit" name="signup_submit" class="cp_newsletter-submit signup_submit btn btn-style-6 btn-big f-right" data-type="submit"><span class="ajax-loader"></span><?php echo esc_html($btn_text); ?></button>
                            <div class="input-holder">
                            <?php echo sprintf('%s', $input_text); ?>
                            </div>

<?php if ( $inforward_settings['show-mailchimp-gdpr'] ): ?>								
							<div class="comment-form-cookies-consent"><input id="form-cookies-consent5" name="form-cookies-consent" type="checkbox" value="yes" />
<label for="form-cookies-consent5"><?php echo esc_html__('I agree with storage and handling of my data by this website.','inforward') ?></label>
</div>
<?php endif; ?>

                            <div class="message-container-subscribe"></div>
                          </form>
                        </div>
                        
                      </div>
                    </div>
                  </div>
        
                </div>
        
              </div>
            
            <?php }  ?>	
            
			<?php	
		}

	}
}

/*	Widget Donate
/* ----------------------------------------------------------------- */
if (!class_exists('inforward_widget_donate')) {

	class inforward_widget_donate extends Inforward_Widget {

		function __construct() {
			$this->widget_cssclass    = 'widget_donate action-widget type-vr';
			$this->widget_description =  esc_html__('Displays Banner Donate', 'inforward');
			$this->widget_id          = 'widget-donate';
			$this->widget_name        = esc_html__('Inforward Banner Donate', 'inforward');
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Title', 'inforward' ),
					'std'   => ''
				),
				'text_amount1'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Amount1', 'inforward' ),
					'std'   => '5'
				),
				'text_amount2'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Amount2', 'inforward' ),
					'std'   => '25'
				),
				'text_amount3'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Amount3', 'inforward' ),
					'std'   => ''
				),
				'text_amount4'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Amount4', 'inforward' ),
					'std'   => ''
				),
				'url_amount'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'PayPal Email Address', 'inforward' ),
					'std'   => ''
				),
				'org_donate'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Organization', 'inforward' ),
					'std'   => ''
				),
				'currency_amount' => array(
					'type'  => 'select',
					'std'   => 'USD',
					'label' => esc_html__( 'Currency Amount', 'inforward' ),
					'options' => inforward_currency_code_options(inforward_get_currencies())
				),
				'type' => array(
					'type'  => 'select',
					'std'   => 'type_1',
					'label' => esc_html__( 'Type', 'inforward' ),
					'options' => array(
						'type_1' => esc_html__('Type 1', 'inforward'),
						'type_2' => esc_html__('Type 2', 'inforward'),
						'type_3' => esc_html__('Type 3', 'inforward'),
						'type_4' => esc_html__('Type 4', 'inforward'),
						'type_5' => esc_html__('Type 5', 'inforward')
					)
				),
				'shadow' => array(
					'type'  => 'checkbox',
					'std'   => '',
					'label' => esc_html__( 'Box Shadow', 'inforward' )
				),
			);
			parent::__construct();
		}

		function widget($args, $instance) {
			$title = isset( $instance['title'] ) ? $instance['title'] : $this->settings['title']['std'];
			$text_amount1 = isset( $instance['text_amount1'] ) ? $instance['text_amount1'] : $this->settings['text_amount1']['std'];
			$text_amount2 = isset( $instance['text_amount2'] ) ? $instance['text_amount2'] : $this->settings['text_amount2']['std'];
			$text_amount3 = isset( $instance['text_amount3'] ) ? $instance['text_amount3'] : $this->settings['text_amount3']['std'];
			$text_amount4 = isset( $instance['text_amount4'] ) ? $instance['text_amount4'] : $this->settings['text_amount4']['std'];
			$url_amount = isset( $instance['url_amount'] ) ? $instance['url_amount'] : $this->settings['url_amount']['std'];
			$org_donate = isset( $instance['org_donate'] ) ? $instance['org_donate'] : $this->settings['org_donate']['std'];
			$type = isset( $instance['type'] ) ? $instance['type'] : 'type_1';
			$currency = isset( $instance['currency_amount'] ) ? $instance['currency_amount'] : $this->settings['currency_amount']['std'];
			$shadow = isset( $instance['shadow'] ) ? $instance['shadow'] : '';
			if ( empty( $currency ) ) {
				$currency = 'USD';
			}
			$currency_code_symbol = inforward_get_currency_symbol( $currency );	 
			
			if( $type == 'type_1' ) {
			?>	
            <div class="widget widget_donate action-widget type-vr widget-bg sh-<?php echo esc_attr($shadow) ?>">
            	<?php 
				if ($title !== '') {
					echo '<h5 class="cp-widget-title wt-title">' . $title . '</h5>';
				}
				?>	
				<form name="_xclick" id="sd_paypalform"  action="https://www.paypal.com/uk/cgi-bin/webscr" method="post">
                <div id="chose-donate" class="chose-donate">
                
                       <?php if ($text_amount1 != '' && $text_amount1 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount1 ) ?>" class="chose-item sd_object sd_usermod active"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount1 ?></button>
                        <?php } elseif($text_amount2 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <?php if ($text_amount2 != '' && $text_amount2 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount2 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount2 ?></button>
                         <?php } elseif($text_amount2 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                         
                         <?php if ($text_amount3 != '' && $text_amount3 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount3 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount3 ?></button>
                         <?php } elseif($text_amount3 == 'other') { ?>
                         <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                          <?php if ($text_amount4 != '' && $text_amount4 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount4 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount4 ?></button>
                         <?php } elseif($text_amount4 == 'other') { ?>
                         <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <input type="hidden" name="cmd" value="_donations" id="cmd"/>
						<input type="hidden" name="no_shipping" value="2"/>
                        <input type="hidden" name="no_note" value="1"/>
                        <input type="hidden" name="tax" value="0"/>
                        <input type="hidden" name="business" value="<?php echo esc_attr($url_amount); ?>" class="sd_object paypal_object" />
                        <input type="hidden" name="bn" value="<?php echo esc_attr($org_donate); ?>" class="sd_object paypal_object"/>
                        <input type="hidden" name="currency_code" value="<?php echo esc_attr($currency); ?>" class="sd_object paypal_object"/>
                        <input type="submit" name="submit"  value="<?php echo esc_attr__( "Donate", 'inforward' ) ?>" class="sd_object btn btn-style-4" id="sd_submit"  >		
				
                
                 </div>
                </form>	
                
                <?php 
				echo '<script type="text/javascript">';
				echo 'jQuery(document).ready(function($){	
					$("#sd_paypalform #sd_submit").before(\'<input type="hidden" name="amount" value="\' + $(".sd_usermod.active").val() + \'" class="sd_object paypal_object" id="paypal_amount" />\');
							$(".chose-item.sd_object.sd_usermod").on("click",function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});
							
							$("input.chose-item.sd_object.sd_usermod").change(function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});';
							
				echo '});
					</script>';
				?>
                
              </div>  
			<?php	
			} elseif ( $type == 'type_2' ) {
				?>
                
                <div class="land-item"><i class="icon icon-ecommerce-banknotes"></i>
				<?php 
				if ($title !== '') {
					echo '<h6 class="land-item-title">' . $title . '</h6>';
				}
				?>
				
				<form name="_xclick" id="sd_paypalform"  action="https://www.paypal.com/uk/cgi-bin/webscr" method="post">
                <div id="chose-donate" class="chose-donate style-2">
                
                       <?php if ($text_amount1 != '' && $text_amount1 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount1 ) ?>" class="chose-item sd_object sd_usermod active"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount1 ?></button>
                         <?php } elseif($text_amount1 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <?php if ($text_amount2 != '' && $text_amount2 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount2 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount2 ?></button>
                         <?php } elseif($text_amount2 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                         
                         <?php if ($text_amount3 != '' && $text_amount3 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount3 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount3 ?></button>
                         <?php } elseif($text_amount3 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                         <?php if ($text_amount4 != '' && $text_amount4 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount4 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount4 ?></button>
                         <?php } elseif($text_amount4 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <input type="hidden" name="cmd" value="_donations" id="cmd"/>
						<input type="hidden" name="no_shipping" value="2"/>
                        <input type="hidden" name="no_note" value="1"/>
                        <input type="hidden" name="tax" value="0"/>
                        <input type="hidden" name="business" value="<?php echo esc_attr($url_amount) ?>" class="sd_object paypal_object" />
                        <input type="hidden" name="bn" value="<?php echo esc_attr($org_donate) ?>" class="sd_object paypal_object"/>
                        <input type="hidden" name="currency_code" value="<?php echo esc_attr($currency) ?>" class="sd_object paypal_object"/>
                        <input type="submit" name="submit"  value="<?php echo esc_attr__( "Donate", 'inforward' ) ?>" class="sd_object btn btn-style-4 btn-big" id="sd_submit"  >		
				
                 </div>
                </form>	
                
                <?php 
				echo '<script type="text/javascript">';
				echo 'jQuery(document).ready(function($){	
					$("#sd_paypalform #sd_submit").before(\'<input type="hidden" name="amount" value="\' + $(".sd_usermod.active").val() + \'" class="sd_object paypal_object" id="paypal_amount" />\');
							$(".chose-item.sd_object.sd_usermod").on("click",function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});
							
							$("input.chose-item.sd_object.sd_usermod").change(function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});';
							
				echo '});
					</script>';
				?>
				</div>
				
				<?php
				} elseif ( $type == 'type_3' ) {
				?>
                <div class="action-widget donate_type_3">
                <div class="action-item donate">
                <div class="action-inner">
				
				<?php 
				if ($title !== '') {
					echo '<h3 class="action-title size-2"><b>' . $title . '</b></h3>';
				}
				?>
				
				<form name="_xclick" id="sd_paypalform"  action="https://www.paypal.com/uk/cgi-bin/webscr" method="post">
                <div id="chose-donate" class="chose-donate align-center">
                
                       <?php if ($text_amount1 != '' && $text_amount1 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount1 ) ?>" class="chose-item sd_object sd_usermod active"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount1 ?></button>
                         <?php } elseif($text_amount1 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <?php if ($text_amount2 != '' && $text_amount2 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount2 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount2 ?></button>
                         <?php } elseif($text_amount2 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                         
                         <?php if ($text_amount3 != '' && $text_amount3 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount3 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount3 ?></button>
                         <?php } elseif($text_amount3 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                         <?php if ($text_amount4 != '' && $text_amount4 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount4 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount4 ?></button>
                         <?php } elseif($text_amount4 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        
                        <input type="hidden" name="cmd" value="_donations" id="cmd"/>
						<input type="hidden" name="no_shipping" value="2"/>
                        <input type="hidden" name="no_note" value="1"/>
                        <input type="hidden" name="tax" value="0"/>
                        <input type="hidden" name="business" value="<?php echo esc_attr($url_amount) ?>" class="sd_object paypal_object" />
                        <input type="hidden" name="bn" value="<?php echo esc_attr( $org_donate ) ?>" class="sd_object paypal_object"/>
                        <input type="hidden" name="currency_code" value="<?php echo esc_attr($currency) ?>" class="sd_object paypal_object"/>
                        <input type="submit" name="submit"  value="<?php echo esc_attr__( "Donate", 'inforward' ) ?>" class="sd_object btn btn-style-4 btn-big" id="sd_submit"  >		
				
                
                 </div>
                </form>	
                
                <?php 
				echo '<script type="text/javascript">';
				echo 'jQuery(document).ready(function($){	
					$("#sd_paypalform #sd_submit").before(\'<input type="hidden" name="amount" value="\' + $(".sd_usermod.active").val() + \'" class="sd_object paypal_object" id="paypal_amount" />\');
							$(".chose-item.sd_object.sd_usermod").on("click",function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});
							
							$("input.chose-item.sd_object.sd_usermod").change(function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});';
							
				echo '});
					</script>';
				?>
                </div>
				</div>
				</div>
				<?php
				} elseif ( $type == 'type_4' ) {
				?>
                <div class="action-widget donate_type_4">
                <div class="action-item type-2 donate">
                <div class="container">
                <div class="action-inner">
				
				<?php 
				if ($title !== '') {
					echo '<h5 class="action-title"><i class="icon-ecommerce-banknotes"></i>' . $title . '</h5>';
				}
				?>
				
				<form name="_xclick" id="sd_paypalform"  action="https://www.paypal.com/uk/cgi-bin/webscr" method="post">
                <div id="chose-donate" class="chose-donate">
                
                       <?php if ($text_amount1 != '' && $text_amount1 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount1 ) ?>" class="chose-item sd_object sd_usermod active"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount1 ?></button>
                         <?php } elseif($text_amount1 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <?php if ($text_amount2 != '' && $text_amount2 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount2 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount2 ?></button>
                         <?php } elseif($text_amount2 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                         
                         <?php if ($text_amount3 != '' && $text_amount3 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount3 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount3 ?></button>
                         <?php } elseif($text_amount3 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                         <?php if ($text_amount4 != '' && $text_amount4 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount4 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount4 ?></button>
                         <?php } elseif($text_amount4 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        
                        <input type="hidden" name="cmd" value="_donations" id="cmd"/>
						<input type="hidden" name="no_shipping" value="2"/>
                        <input type="hidden" name="no_note" value="1"/>
                        <input type="hidden" name="tax" value="0"/>
                        <input type="hidden" name="business" value="<?php echo esc_attr($url_amount) ?>" class="sd_object paypal_object" />
                        <input type="hidden" name="bn" value="<?php echo esc_attr( $org_donate ) ?>" class="sd_object paypal_object"/>
                        <input type="hidden" name="currency_code" value="<?php echo esc_attr($currency) ?>" class="sd_object paypal_object"/>
                        <input type="submit" name="submit"  value="<?php echo esc_attr__( "Donate", 'inforward' ) ?>" class="sd_object btn btn-style-4 btn-big" id="sd_submit"  >		
				
                
                 </div>
                </form>	
                
                <?php 
				echo '<script type="text/javascript">';
				echo 'jQuery(document).ready(function($){	
					$("#sd_paypalform #sd_submit").before(\'<input type="hidden" name="amount" value="\' + $(".sd_usermod.active").val() + \'" class="sd_object paypal_object" id="paypal_amount" />\');
							$(".chose-item.sd_object.sd_usermod").on("click",function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});
							
							$("input.chose-item.sd_object.sd_usermod").change(function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});';
							
				echo '});
					</script>';
				?>
                </div>
                </div>
				</div>
				</div>
				<?php
				} elseif( $type == 'type_5' ) {
			?>	
            <div class="widget widget_donate widget_donate_type_5 action-widget style-2 type-vr">
            <div class="action-item donate">
            <div class="action-inner">
            	<?php 
				if ($title !== '') {
					echo '<h5 class="cp-widget-title wt-title">' . $title . '</h5>';
				}
				?>	
				<form name="_xclick" id="sd_paypalform"  action="https://www.paypal.com/uk/cgi-bin/webscr" method="post">
                <div id="chose-donate" class="chose-donate">
                
                       <?php if ($text_amount1 != '' && $text_amount1 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount1 ) ?>" class="chose-item sd_object sd_usermod active"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount1 ?></button>
                        <?php } elseif($text_amount2 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <?php if ($text_amount2 != '' && $text_amount2 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount2 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount2 ?></button>
                         <?php } elseif($text_amount2 == 'other') { ?>
                        <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                         
                         <?php if ($text_amount3 != '' && $text_amount3 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount3 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount3 ?></button>
                         <?php } elseif($text_amount3 == 'other') { ?>
                         <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                          <?php if ($text_amount4 != '' && $text_amount4 != 'other') { ?>
                        <button name="sd_radio" value="<?php echo esc_attr( $text_amount4 ) ?>" class="chose-item sd_object sd_usermod"><?php echo wp_kses_post($currency_code_symbol).''. (int)$text_amount4 ?></button>
                         <?php } elseif($text_amount4 == 'other') { ?>
                         <input type="text" size="3" min="1" inputmode="numeric" pattern="[0-9]*" name="sd_radio" placeholder="<?php echo esc_attr__( "Other", 'inforward' ) ?>" class="chose-item sd_object sd_usermod">
                        <?php } ?>
                        
                        <input type="hidden" name="cmd" value="_donations" id="cmd"/>
						<input type="hidden" name="no_shipping" value="2"/>
                        <input type="hidden" name="no_note" value="1"/>
                        <input type="hidden" name="tax" value="0"/>
                        <input type="hidden" name="business" value="<?php echo esc_attr($url_amount) ?>" class="sd_object paypal_object" />
                        <input type="hidden" name="bn" value="<?php echo esc_attr( $org_donate ) ?>" class="sd_object paypal_object"/>
                        <input type="hidden" name="currency_code" value="<?php echo esc_attr($currency) ?>" class="sd_object paypal_object"/>
                        <input type="submit" name="submit"  value="<?php echo esc_attr__( "Donate", 'inforward' ) ?>" class="sd_object btn btn-style-4" id="sd_submit"  >		
				
                
                 </div>
                </form>	
                
                <?php 
				echo '<script type="text/javascript">';
				echo 'jQuery(document).ready(function($){	
					$("#sd_paypalform #sd_submit").before(\'<input type="hidden" name="amount" value="\' + $(".sd_usermod.active").val() + \'" class="sd_object paypal_object" id="paypal_amount" />\');
							$(".chose-item.sd_object.sd_usermod").on("click",function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});
							
							$("input.chose-item.sd_object.sd_usermod").change(function() {
								$(this).addClass("active").siblings().removeClass("active");
								$("#sd_paypalform #paypal_amount").val($(this).val()); 
								return false;
							});';
							
				echo '});
					</script>';
				?>
                
              </div>
              </div> 
              </div>   
			<?php	
			} 
			
		}

	}
}

function inforward_currency_code_options( $inforward_currency_code_options = array() ) {	
	foreach ( $inforward_currency_code_options as $code => $name ) {
		$inforward_currency_code_options[ $code ] = $name . " (" . $code . ")";
	}	
	return $inforward_currency_code_options;
}

function inforward_get_currencies() {
	return array(
				'AED' => esc_html__( 'United Arab Emirates Dirham', 'inforward' ),
				'AUD' => esc_html__( 'Australian Dollars', 'inforward' ),
				'BDT' => esc_html__( 'Bangladeshi Taka', 'inforward' ),
				'BRL' => esc_html__( 'Brazilian Real', 'inforward' ),
				'BGN' => esc_html__( 'Bulgarian Lev', 'inforward' ),
				'CAD' => esc_html__( 'Canadian Dollars', 'inforward' ),
				'CLP' => esc_html__( 'Chilean Peso', 'inforward' ),
				'CNY' => esc_html__( 'Chinese Yuan', 'inforward' ),
				'COP' => esc_html__( 'Colombian Peso', 'inforward' ),
				'CZK' => esc_html__( 'Czech Koruna', 'inforward' ),
				'DKK' => esc_html__( 'Danish Krone', 'inforward' ),
				'DOP' => esc_html__( 'Dominican Peso', 'inforward' ),
				'EUR' => esc_html__( 'Euros', 'inforward' ),
				'HKD' => esc_html__( 'Hong Kong Dollar', 'inforward' ),
				'HRK' => esc_html__( 'Croatia kuna', 'inforward' ),
				'HUF' => esc_html__( 'Hungarian Forint', 'inforward' ),
				'ISK' => esc_html__( 'Icelandic krona', 'inforward' ),
				'IDR' => esc_html__( 'Indonesia Rupiah', 'inforward' ),
				'INR' => esc_html__( 'Indian Rupee', 'inforward' ),
				'NPR' => esc_html__( 'Nepali Rupee', 'inforward' ),
				'ILS' => esc_html__( 'Israeli Shekel', 'inforward' ),
				'JPY' => esc_html__( 'Japanese Yen', 'inforward' ),
				'KIP' => esc_html__( 'Lao Kip', 'inforward' ),
				'KRW' => esc_html__( 'South Korean Won', 'inforward' ),
				'MYR' => esc_html__( 'Malaysian Ringgits', 'inforward' ),
				'MXN' => esc_html__( 'Mexican Peso', 'inforward' ),
				'NGN' => esc_html__( 'Nigerian Naira', 'inforward' ),
				'NOK' => esc_html__( 'Norwegian Krone', 'inforward' ),
				'NZD' => esc_html__( 'New Zealand Dollar', 'inforward' ),
				'PYG' => esc_html__( 'Paraguayan Guaraní', 'inforward' ),
				'PHP' => esc_html__( 'Philippine Pesos', 'inforward' ),
				'PLN' => esc_html__( 'Polish Zloty', 'inforward' ),
				'GBP' => esc_html__( 'Pounds Sterling', 'inforward' ),
				'RON' => esc_html__( 'Romanian Leu', 'inforward' ),
				'RUB' => esc_html__( 'Russian Ruble', 'inforward' ),
				'SGD' => esc_html__( 'Singapore Dollar', 'inforward' ),
				'ZAR' => esc_html__( 'South African rand', 'inforward' ),
				'SEK' => esc_html__( 'Swedish Krona', 'inforward' ),
				'CHF' => esc_html__( 'Swiss Franc', 'inforward' ),
				'TWD' => esc_html__( 'Taiwan New Dollars', 'inforward' ),
				'THB' => esc_html__( 'Thai Baht', 'inforward' ),
				'TRY' => esc_html__( 'Turkish Lira', 'inforward' ),
				'UAH' => esc_html__( 'Ukrainian Hryvnia', 'inforward' ),
				'USD' => esc_html__( 'US Dollars', 'inforward' ),
				'VND' => esc_html__( 'Vietnamese Dong', 'inforward' ),
				'EGP' => esc_html__( 'Egyptian Pound', 'inforward' ),
	);
}

function inforward_get_currency_symbol( $currency = '' ) {
	switch ( $currency ) {
		case 'AED' :
			$currency_symbol = 'د.إ';
			break;
		case 'AUD' :
		case 'CAD' :
		case 'CLP' :
		case 'COP' :
		case 'HKD' :
		case 'MXN' :
		case 'NZD' :
		case 'SGD' :
		case 'USD' :
			$currency_symbol = '&#36;';
			break;
		case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
		case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
		case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
		case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
		case 'CNY' :
		case 'JPY' :
		case 'RMB' :
			$currency_symbol = '&yen;';
			break;
		case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
		case 'DKK' :
			$currency_symbol = 'kr.';
			break;
		case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
		case 'EGP' :
			$currency_symbol = 'EGP';
			break;
		case 'EUR' :
			$currency_symbol = '&euro;';
			break;
		case 'GBP' :
			$currency_symbol = '&pound;';
			break;
		case 'HRK' :
			$currency_symbol = 'Kn';
			break;
		case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
		case 'IDR' :
			$currency_symbol = 'Rp';
			break;
		case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
		case 'INR' :
			$currency_symbol = 'Rs.';
			break;
		case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
		case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
		case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
		case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
		case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
		case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
		case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
		case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
		case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
		case 'RON' :
			$currency_symbol = 'lei';
			break;
		case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
		case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
		case 'THB' :
			$currency_symbol = '&#3647;';
			break;
		case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
		case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
		case 'UAH' :
			$currency_symbol = '&#8372;';
			break;
		case 'VND' :
			$currency_symbol = '&#8363;';
			break;
		case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
		default :
			$currency_symbol = '';
			break;
	}

	return $currency_symbol;
}	

/*	Custom Options for Widgets 
/* ----------------------------------------------------------------- */
function inforward_add_link_option( $widget, $return, $instance ) {
 
    // Are we dealing with a nav menu widget?
    if ( 'media_video' == $widget->id_base ) {
        $view_url = isset( $instance['view_url'] ) ? $instance['view_url'] : '';
        ?>
		
		<p>
			<label><?php esc_html_e('View All URL', 'inforward');?>:
				<input id="<?php echo esc_attr($widget->get_field_id( 'view_url' )); ?>" name="<?php echo esc_attr($widget->get_field_name( 'view_url' )); ?>" value="<?php echo esc_url($view_url); ?>" class="widefat" type="text"/>
			</label>
		</p>
        <?php
    }
	
	if ( 'latest_tweets_widget' == $widget->id_base ) {
		$type_widget = isset( $instance['type_widget'] ) ? $instance['type_widget'] : '';
		?>
			<p>
				<label><?php esc_html_e('Style Widget', 'inforward'); ?>:</label><br>
				<select name="<?php echo esc_attr($widget->get_field_name('type_widget')); ?>">
					<option <?php selected( $type_widget, 'type1' ); ?>  value="type1"><?php esc_html_e('Type1', 'inforward') ?></option>
					<option <?php selected( $type_widget, 'type2' ); ?> value="type2"><?php esc_html_e('Type2', 'inforward') ?></option>
				</select>
			</p>
            <?php
	}
	
}
add_filter('in_widget_form', 'inforward_add_link_option', 10, 3 );

function inforward_save_option( $instance, $new_instance ) {

    if ( isset( $new_instance['media_video'] ) && !empty( $new_instance['view_url'] ) ) {
        $new_instance['view_url'] = $instance['view_url'];
    }
	
    return $new_instance;
}
add_filter( 'widget_update_callback', 'inforward_save_option', 10, 2 );

function inforward_get_widget_link( $id, $link = NULL, $before = '', $after = '', $link_class = '', $view_url = '' ) {
    if ( NULL === $link ) {
        $link = esc_html__( 'View All', 'inforward' );
    }
    if ( !empty( $link_class ) ) {
        $link_class = ' ' . esc_attr( $link_class );
    }

    $link = '<a href="' . $view_url . '" title="' . $link . '" target="_blank" class="' . $link_class . '">' . $link . '</a>';
    return $before . apply_filters( 'view_widget_link', $link, $id ) . $after;
}
function inforward_option_widgets($instance, $widget, $args) {
    if ($widget->id_base == 'media_video') { 
		$view_url = isset( $instance['view_url'] ) ? $instance['view_url'] : '';
		if( !empty($view_url) ) {
        $args[ 'after_widget' ] = inforward_get_widget_link( $widget->id, esc_html__( 'View All Videos', 'inforward' ), '', '', 'info-btn', $view_url ) . $args[ 'after_widget' ];
		}
		$widget->widget($args, $instance);
        return FALSE;
    }
	
	if ($widget->id_base == 'latest_tweets_widget') { 
		$type_widget = isset( $instance['type_widget'] ) ? $instance['type_widget'] : 'type1';
		if($type_widget == 'type2') {
		$args[ 'before_widget' ] = '<div class="widget_latest_tweets_widget_type_2 ">'. $args[ 'before_widget' ];
		$args[ 'after_widget' ] = $args[ 'after_widget' ].'</div>';
		}
		if($type_widget == 'type1') {
		$args[ 'before_widget' ] = '<div class="widget_latest_tweets_widget_type_1 ">'. $args[ 'before_widget' ];
		$args[ 'after_widget' ] = $args[ 'after_widget' ].'</div>';
		}
		$widget->widget($args, $instance);
        return FALSE;
	}
	
	return $instance;
}
add_filter('widget_display_callback', 'inforward_option_widgets', 10, 3);

add_filter('latest_tweets_render_date', function( $created_at ){
    $date = DateTime::createFromFormat('D M d H:i:s O Y', $created_at );
    return $date->format('F d, Y');
}, 10 , 1 );

add_filter('latest_tweets_render_tweet', function( $html, $date, $link, array $tweet ){
	$id = $tweet['id_str'];
    return '<p class="my-tweet">'.$html.'</p><p class="my-date"><a href="'.$link.'">'.$date.'</a><span class="slash-list f-right"><a href="https://twitter.com/intent/retweet?tweet_id='. $id .'">'. esc_html__('Retweet','inforward') .'</a><a href="https://twitter.com/intent/favorite?tweet_id='. $id .'">'. esc_html__('Favorite','inforward') .'</a></span></p>';
}, 10, 4 );

add_action('widgets_init', function(){return register_widget("inforward_widget_custom_pages");});
add_action('widgets_init', function(){return register_widget("inforward_widget_text_icon");});
add_action('widgets_init', function(){return register_widget("inforward_like_box_facebook");});
add_action('widgets_init', function(){return register_widget("inforward_widget_donate");});
add_action('widgets_init', function(){return register_widget("inforward_widget_popular_widget");});
//add_action('widgets_init', function(){return register_widget("inforward_instagram_widget");});
add_action('widgets_init', function(){return register_widget("inforward_instagram_widget2");});
add_action('widgets_init', function(){return register_widget("inforward_widget_custom_copyright");});
add_action('widgets_init', function(){return register_widget("inforward_widget_social_links");});
add_action('widgets_init', function(){return register_widget("inforward_widget_contact_us");});
add_action('widgets_init', function(){return register_widget("inforward_widget_mailchimp");});
add_action('widgets_init', function(){return register_widget("inforward_widget_footer_banners");});

?>