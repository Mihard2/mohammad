<?php
/**
 * Inforward functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @since Inforward 1.0
 */

/**
 * Include the product registration
 */
require_once( get_template_directory() . '/includes/class-product-registration.php' );

/**
 * Include the main Inforward class.
 */
require_once( get_template_directory() . '/includes/class-inforward.php' );

function Inforward() {
	return Inforward::get_instance();
}
Inforward();

/* 	Basic Settings
/* ---------------------------------------------------------------------- */

require_once( get_theme_file_path('includes/functions.php') );

/*  Add Widgets
/* ---------------------------------------------------------------------- */

require_once( get_theme_file_path('includes/widgets/abstract-widget.php') );
require_once( get_theme_file_path('includes/widgets.php') );

/* Load Base Functions
/* ---------------------------------------------------------------------- */
require_once( get_theme_file_path('includes/helpers/theme-helper.php') );
require_once( get_theme_file_path('includes/helpers/post-format-helper.php') );
require_once( get_theme_file_path('includes/classes/register-admin-user-profile.class.php') );
require_once( get_theme_file_path('includes/functions-base.php') );

/*  Load Functions Files
/* ---------------------------------------------------------------------- */
require_once( get_theme_file_path('includes/functions-core.php') );

/*  Include Config Composer
/* ---------------------------------------------------------------------- */

if ( class_exists('Vc_Manager') ) {
	require_once( get_theme_file_path('config-composer/config.php') );
}

/*  Include Config WooCommerce
/* ---------------------------------------------------------------------- */
if (class_exists('WooCommerce')) {
	if ( ! function_exists('inforward_woo_config') ) {
		function inforward_woo_config() {
			require_once( get_theme_file_path('config-woocommerce/config.php') );
			return INFORWARD_WOOCOMMERCE_CONFIG::instance();
		}
	}

	global $inforward_woo_config;
	
	WC()->query->layered_nav_product_ids =array();	
	$inforward_woo_config = inforward_woo_config();
}

if ( ! function_exists( 'inforward_theme_add_editor_styles' ) ) {
		function inforward_theme_add_editor_styles() {
			add_editor_style( 'custom-editor-style.css' );
		}
	}
add_action( 'init', 'inforward_theme_add_editor_styles' );

/*  Theme support & Theme setup
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'inforward_setup' ) ) :
	function inforward_setup() {

		$GLOBALS['content_width'] = apply_filters( 'inforward_content_width', 1140 );

		// Load theme textdomain
		load_theme_textdomain( 'inforward', get_template_directory()  . '/lang' );
		load_child_theme_textdomain( 'inforward', get_stylesheet_directory() . '/lang' );

		/**
		 * Inforward admin options
		 */

		require_once( get_theme_file_path('admin/framework/admin.php') );
		inforward_check_theme_options();
		global $pagenow;

		// Post Formats Support
		add_theme_support('post-formats', array( 'gallery', 'quote', 'video', 'audio', 'link' ));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'search-form',
			'gallery',
			'caption',
		) );
		
		// Post Thumbnails Support
		add_theme_support('post-thumbnails');
		add_image_size( 'inforward-post-grid', 750, 450, true );
		add_image_size( 'inforward-full', 1920, 480, true );
		add_image_size( 'inforward-post-full', 1140, 600, true );
		add_image_size( 'inforward-related-posts-image', 230, 150, true );
		add_image_size( 'inforward-portfolio-small-image', 360, 260, true );
		add_image_size( 'inforward-portfolio-big-image', 555, 380, true );
		add_image_size( 'inforward-testimonial', 263, 263, true );
		add_image_size( 'inforward-events-slider', 768, 300, true );

		// Add default posts and comments RSS feed links to head
		add_theme_support('automatic-feed-links');

		add_theme_support('title-tag');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary', 'Primary Menu' );
		register_nav_menu( 'footer', 'Footer Menu' );

		add_theme_support( 'custom-header', apply_filters( 'inforward_custom_header_args', array(
				'width'                  => 1140,
			) ) );
			
		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'inforward_custom_background_args', array(
				'default-color'      => '#fff',
				'default-attachment' => 'fixed',
			) ) );

		remove_post_type_support( 'page', 'thumbnail' );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
		
		
		
	}
endif;
add_action( 'after_setup_theme', 'inforward_setup', 100 );

/*  Layouts
/* ---------------------------------------------------------------------- */
require_once( get_theme_file_path('includes/layout.php') );

/*  Load hooks
/* ---------------------------------------------------------------------- */
if ( !is_admin() ) {
	require_once( get_theme_file_path('includes/templates-hooks.php') );
}

/*  Custom template tags for this theme.
/* ---------------------------------------------------------------------- */
require_once( get_theme_file_path('includes/template-tags.php') );

/*  Include Plugins
/* ---------------------------------------------------------------------- */
require_once( get_theme_file_path('admin/plugin-bundle.php') );
require_once( get_theme_file_path('config-plugins/config.php') );

/*  Include Config Widget Meta Box
/* ---------------------------------------------------------------------- */
require_once( get_theme_file_path('config-widget-meta-box/config.php') );

/*  Include Config DHVC Forms
/* ---------------------------------------------------------------------- */

if ( defined('WPCF7_VERSION') ) {
	require_once( get_theme_file_path('config-contact-form-7/config.php') );
}

/*  Include Config WPML
/* ---------------------------------------------------------------------- */

if ( defined('ICL_SITEPRESS_VERSION') && defined('ICL_LANGUAGE_CODE') ) {
	require_once( get_theme_file_path('config-wpml/config.php') );
}

/*  Get user name
/* ---------------------------------------------------------------------- */

if ( !function_exists("inforward_get_user_name") ) {

	function inforward_get_user_name($current_user) {

		if ( !$current_user->user_firstname && !$current_user->user_lastname ) {
			$user_name = $current_user->user_nicename;
		} else {
			$user_name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
		}
		return $user_name;
	}

}

function inforward_wpcodex_add_excerpt_support_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'inforward_wpcodex_add_excerpt_support_for_pages' );


if ( ! function_exists( 'inforward_tag_cloud_widget' ) ) { 
	function inforward_tag_cloud_widget($args) {
		$args['number'] = 12; 
		$args['largest'] = 14; 
		$args['smallest'] = 14; 
		$args['unit'] = 'px'; 
		$args['format'] = 'flat'; 
		$args['separator'] = ''; 
		return $args;
	}
}
add_filter( 'widget_tag_cloud_args', 'inforward_tag_cloud_widget' );

if ( ! function_exists( 'inforward_tag_cloud_widget1' ) ) { 
	function inforward_tag_cloud_widget1($args) {
		$args['number'] = 12; 
		$args['largest'] = 14; 
		$args['smallest'] = 14; 
		$args['unit'] = 'px'; 
		$args['format'] = 'flat'; 
		$args['separator'] = ''; 
		return $args;
	}
}
add_filter( 'woocommerce_product_tag_cloud_widget_args', 'inforward_tag_cloud_widget1' );

if ( class_exists( 'Tribe__Events__Main' ) ) {
	// Changes the text labels for Google Calendar and iCal buttons on a single event page
	remove_action( 'tribe_events_single_event_after_the_content', array( tribe( 'tec.iCal' ), 'single_event_links' ) );

	add_action( 'tribe_events_single_event_after_the_content', 'customized_tribe_single_event_links' );

	if ( ! function_exists( 'customized_tribe_single_event_links' ) ) { 
		function customized_tribe_single_event_links()	{

			if ( is_single() && post_password_required() ) {
				return;
			}

			echo '<div class="tribe-events-cal-links">';
			echo '<a class="tribe-events-gcal info-btn exp-btn" href="' . tribe_get_gcal_link() . '" title="' . esc_html__( 'Google Calendar', 'inforward' ) . '">' . esc_html__( 'Google Calendar', 'inforward' ) . ' </a> &nbsp;|&nbsp;';
			echo '<a class="tribe-events-ical info-btn exp-btn" href="' . tribe_get_single_ical_link() . '">' . esc_html__( 'iCal Export', 'inforward' ) . ' </a>';
			echo '</div>';
		}
	}

	if ( ! function_exists( 'inforward_get_events_category' ) ) {
		function inforward_get_events_category($id = null){
			$categories = get_the_terms( $id, 'tribe_events_cat' );
			$res = '';
			if(!empty($categories)){
				foreach ( $categories as $val ) {
					$res .= $val->slug;
					$res .= ', ';
				}
			}
			return  $res;
		}
	}
	
	if ( class_exists( 'Tribe__Events__Pro__Main' ) ) {
		$related_events = array( Tribe__Events__Pro__Main::instance(), 'register_related_events_view' );
		remove_action('tribe_events_single_event_after_the_meta', $related_events );
		add_action('tribe_events_single_event_related', $related_events, 10 );
	}
	
}

if ( ! function_exists( 'inforward_add_to_mailchimp_list' ) ) { 

add_action('wp_ajax_add_to_mailchimp_list', 'inforward_add_to_mailchimp_list');
add_action('wp_ajax_nopriv_add_to_mailchimp_list', 'inforward_add_to_mailchimp_list');

	function inforward_add_to_mailchimp_list() {
		global $inforward_settings;
		
		check_ajax_referer('ajax-nonce', 'ajax_nonce');
		$_POST = array_map('stripslashes_deep', $_POST);

		$email = sanitize_email($_POST['newsletter-email']);
		$name = sanitize_title($_POST['name']);
		$zip = sanitize_title($_POST['zip']);
		$phone = sanitize_title($_POST['phone']);
		$gdpr = sanitize_title($_POST['form-cookies-consent']);
		
		$data_mailchimp_api = $inforward_settings['mailchimp-api']; 
		$data_mailchimp_id = $inforward_settings['mailchimp-id']; 
		$data_mailchimp_center = $inforward_settings['mailchimp-center'];
		
		$mailchimp_api = sanitize_title($_POST['mailchimp_api']);
		$mailchimp_id = sanitize_title($_POST['mailchimp_id']);
		$mailchimp_center = sanitize_title($_POST['mailchimp_center']);
			
			if($mailchimp_api != '') {
				$data_mailchimp_api = $mailchimp_api;
			}
			if($mailchimp_id != '') {
				$data_mailchimp_id = $mailchimp_id;
			}
			if($mailchimp_center != '') {
				$data_mailchimp_center = $mailchimp_center;
			}
		
		
		if (empty($name) || $name == null) $name = '';

		$url = "https://$data_mailchimp_center.api.mailchimp.com/2.0/lists/subscribe.json";
		$result = array();
		
			$request = wp_remote_post( $url, array(
				'body' => json_encode( array(
					'apikey' => $data_mailchimp_api,
					'id' => $data_mailchimp_id,
					'email' => array( 'email' => $email ),
					'merge_vars'        => array( 'FNAME' => $name, 'ZIP' => $zip )
				) )
			));
			$data = json_decode(wp_remote_retrieve_body( $request ));

			if (isset($data->error)) {
				$result['status'] = $data->status;
				$result['text'] = $data->error;
				echo json_encode($result);
				exit;
			}
			
			$result['status'] = 'success';
			$result['text']  = esc_html__('Thank you! Please check your email to confirm.', 'inforward');

			echo json_encode($result);
			wp_die();
	}
}


if ( class_exists( 'Give' ) ) {
	
remove_action('give_pre_form_output', 'give_form_content');

remove_action( 'give_single_form_summary', 'give_template_single_title', 5 ); 

add_action( 'give_before_single_form_summary', 'give_template_single_title', 5 ); 



function inforward_give_form_display_content() {

$form_id = get_the_ID();
$show_content = give_get_meta( $form_id, '_give_content_placement', true );
$content      = give_get_meta( $form_id, '_give_form_content', true );

	if ( give_is_setting_enabled( give_get_option( 'the_content_filter' ) ) ) {
		$content = apply_filters( 'the_content', $content );
	} else {
		$content = wpautop( do_shortcode( $content ) );
	}


if ( !empty( $show_content ) ) {
		
		$output = sprintf(
		'<div id="give-form-content-%s" class="give-form-content-wrap %s-content">%s</div>',
		$form_id,
		$show_content,
		$content
		);
		echo $output;
	}
	
}

add_action( 'give_single_form_summary', 'inforward_give_form_display_content', 5 );
}


function inforward_wpb_comments_privacy($arg) {
    
  $arg['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
                    '<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.' ) . '</label></p>';
      
  return $arg;
}
  
add_filter('comment_form_default_fields', 'inforward_wpb_comments_privacy');


