<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The Metaboxes class.
 */
class Inforward_Theme_Metaboxes {

	/**
	 * The settings.
	 *
	 * @access public
	 * @var array
	 */
	public $data;

	/**
	 * The class constructor.
	 *
	 * @access public
	 */
	public function __construct() {
		require_once plugin_dir_path( __FILE__ ) . 'inc/loader.php';
		$loader = new MAD_Loader;
		$loader->init();

		add_filter( 'mad_meta_boxes', array($this, 'meta_boxes_array') );
	}

	public function meta_boxes_array($meta_boxes) {

		/*	Meta Box Definitions
		/* ---------------------------------------------------------------------- */

		$prefix = 'inforward_';

		/*	Layout Settings
		/* ---------------------------------------------------------------------- */

		$pages = get_pages('title_li=&orderby=name');
		$list_pages = array('' => 'None');
		foreach ( $pages as $key => $entry ) {
			$list_pages[$entry->ID] = $entry->post_title;
		}
		
		$registered_custom_sidebars = array();
		if ( class_exists('Inforward_Helper') ) {
			$registered_sidebars = Inforward_Helper::get_registered_sidebars(array(' ' => 'Default Sidebar'), array('General Widget Area'));
			
			foreach( $registered_sidebars as $key => $value ) {
				if ( strpos($key, 'Footer Row') === false ) {
					$registered_custom_sidebars[$key] = $value;
				}
			}
		}

		$meta_boxes[] = array(
			'id'       => 'layout-settings',
			'title'    => esc_html__('Inforward Page Options', 'inforward'),
			'pages'    => array( 'post', 'page', 'product', 'portfolio', 'tribe_events', 'issues', 'give_forms' ),
			'context'  => 'normal',
			'priority' => 'low',
			'fields'   => array(
				array(
					'name'    => esc_html__('Header Type', 'inforward'),
					'id'      => $prefix . 'header_type',
					'type'    => 'select',
					'std'     => '',
					'js_options' => array(
						'width' => '100%',
						'minimumResultsForSearch' => '-1',
						'placeholder' => esc_html__('Default Header Type', 'inforward')
					),
					'desc'    => esc_html__('Choose your header type', 'inforward'),
					'options' => array(
						' ' => esc_html__('Default Header Type', 'inforward'),
						'cp-type-1' => esc_html__('Type 1', 'inforward'),
						'cp-type-2' => esc_html__('Type 2', 'inforward'),
						'cp-type-3' => esc_html__('Type 3', 'inforward'),
						'cp-type-4' => esc_html__('Type 4', 'inforward'),
						'cp-type-5' => esc_html__('Type 5', 'inforward'),
						'cp-type-6' => esc_html__('Type 6', 'inforward'),
					)
				),
				array(
					'name'    => esc_html__('Header Position', 'inforward'),
					'id'      => $prefix . 'header_position',
					'type'    => 'select',
					'std'     => '',
					'js_options' => array(
						'width' => '100%',
						'minimumResultsForSearch' => '-1',
						'placeholder' => esc_html__('Default Header Position', 'inforward')
					),
					'desc'    => esc_html__('Choose your header position', 'inforward'),
					'options' => array(
						' ' => esc_html__('Default Header Position', 'inforward'),
						'relative' => esc_html__('relative', 'inforward'),
						'fixed' => esc_html__('fixed', 'inforward'),
					)
				),
				array(
						'name'    => esc_html__('Header Background Image', 'inforward'),
						'id'      => $prefix . 'header_bg_image',
						'type'    => 'thickbox_image',
						'std'     => '',
						'desc'    => esc_html__('Select the header background image', 'inforward')
					),	
				array(
					'name'    => esc_html__('Footer Type', 'inforward'),
					'id'      => $prefix . 'footer_type',
					'type'    => 'select',
					'std'     => '',
					'js_options' => array(
						'width' => '100%',
						'minimumResultsForSearch' => '-1',
						'placeholder' => esc_html__('Default Footer Type', 'inforward')
					),
					'desc'    => esc_html__('Choose your footer type', 'inforward'),
					'options' => array(
						' ' => esc_html__('Default Footer Type', 'inforward'),
						'footer-1' => esc_html__('Type 1', 'inforward'),
						'footer-2' => esc_html__('Type 2', 'inforward'),
						'footer-3' => esc_html__('Type 3', 'inforward'),
						'footer-4' => esc_html__('Type 4', 'inforward'),
						'footer-5' => esc_html__('Type 5', 'inforward'),
					)
				),	
				array(
						'name'    => esc_html__('Page Title Style', 'inforward'),
						'id'      => $prefix . 'page_title_style',
						'type'    => 'select',
						'std'     => '',
						'desc'    => esc_html__('Choose page title style', 'inforward'),
						'options' => array(
							'default' => esc_html__('Default', 'inforward'),
							'custom' => esc_html__('Custom', 'inforward'),
							'custom_big' => esc_html__('Custom large', 'inforward'),
							'custom_big2' => esc_html__('Custom extra', 'inforward'),
							'none' => esc_html__('None', 'inforward')
						)
				),
				array(
					'name'    => esc_html__('Page Title', 'inforward'),
					'id'      => $prefix . 'hide_pagetitle',
					'type'    => 'checkbox',
					'std'     => 0,
					'desc'    => esc_html__('Display the Page Title?', 'inforward'),
				),
				array(
					'name'    => esc_html__('Breadcrumb Navigation', 'inforward'),
					'id'      => $prefix . 'hide_breadcrumb',
					'type'    => 'checkbox',
					'std'     => 0,
					'desc'    => esc_html__('Display the Breadcrumb Navigation?', 'inforward'),
				),
				array(
						'name'    => esc_html__('Title Align', 'inforward'),
						'id'      => $prefix . 'page_title_align',
						'type'    => 'select',
						'std'     => 'left',
						'desc'    => esc_html__('Choose page title align', 'inforward'),
						'options' => array(
							'center' => esc_html__('Center', 'inforward'),
							'left' => esc_html__('Left', 'inforward'),
							'right' => esc_html__('Right', 'inforward')
						)
					),
				array(
					'name'    => esc_html__('Color Page Title', 'inforward'),
					'id'      => $prefix . 'page_title_color',
					'type'    => 'color',
					'std'     => '',
					'desc'    => esc_html__('Select the color of the page title', 'inforward')
				),		
				array(
					'name'    => esc_html__('Color Background Page Title', 'inforward'),
					'id'      => $prefix . 'page_title_bg_color',
					'type'    => 'color',
					'std'     => '',
					'desc'    => esc_html__('Select the background color of the page title', 'inforward')
				),	
				array(
						'name'    => esc_html__('Background Image Page Title', 'inforward'),
						'id'      => $prefix . 'page_title_bg_image',
						'type'    => 'thickbox_image',
						'std'     => '',
						'desc'    => esc_html__('Select the background image', 'inforward')
					),	
				array(
					'name'    => esc_html__('Page Title Background Repeat', 'inforward'),
					'id'      => $prefix . 'page_title_bg_image_repeat',
					'type'    => 'select',
					'std'     => '',
					'desc'    => esc_html__('Select the repeat mode for the background image', 'inforward'),
					'options' => array(
						'' => esc_html__('Default', 'inforward'),
						'repeat' => esc_html__('Repeat', 'inforward'),
						'no-repeat' => esc_html__('No Repeat', 'inforward'),
						'repeat-x' => esc_html__('Repeat Horizontally', 'inforward'),
						'repeat-y' => esc_html__('Repeat Vertically', 'inforward')
					)
				),
				array(
					'name'    => esc_html__('Page Title Background Position', 'inforward'),
					'id'      => $prefix . 'page_title_bg_image_position',
					'type'    => 'select',
					'std'     => '',
					'desc'    => esc_html__('Select the position for the background image', 'inforward'),
					'options' => array(
						'' => esc_html__('Default', 'inforward'),
						'top left' => esc_html__('Top left', 'inforward'),
						'top center' => esc_html__('Top center', 'inforward'),
						'top right' => esc_html__('Top right', 'inforward'),
						'bottom left' => esc_html__('Bottom left', 'inforward'),
						'bottom center' => esc_html__('Bottom center', 'inforward'),
						'bottom right' => esc_html__('Bottom right', 'inforward')
					)
				),	
				array(
					'name'    => esc_html__('Page Wrapper', 'inforward'),
					'id'      => $prefix . 'wrapper',
					'type'    => 'select',
					'std'     => '',
					'js_options' => array(
						'width' => '100%',
						'minimumResultsForSearch' => '-1',
						'placeholder' => esc_html__('Default Page Wrapper', 'inforward')
					),
					'desc'    => esc_html__('Choose page wrapper', 'inforward'),
					'options' => array(
						' ' => esc_html__('Default Page Wrapper', 'inforward'),
						'cp-wide-layout-type' => esc_html__('Wide', 'inforward'),
						'cp-boxed-layout-type' => esc_html__('Boxed', 'inforward')
					)
				),
				array(
					'name'    => esc_html__('Content Size', 'inforward'),
					'id'      => $prefix . 'content_size',
					'type'    => 'select',
					'std'     => '',
					'desc'    => esc_html__('Choose Your Content Size', 'inforward'),
					'options' => array(
						'' => esc_html__('Normal', 'inforward'),
						'medium-size' => esc_html__('Medium', 'inforward'),
						'extra-size2' => esc_html__('Large', 'inforward'),
						'extra-size' => esc_html__('Extra', 'inforward'),
					)
				),
				array(
					'name'    => esc_html__('Sidebar Position', 'inforward'),
					'id'      => $prefix . 'page_sidebar_position',
					'type'    => 'select',
					'std'     => '',
					'js_options' => array(
						'width' => '100%',
						'minimumResultsForSearch' => '-1',
						'placeholder' => esc_html__('Default Sidebar Position', 'inforward')
					),
					'desc'    => esc_html__('Choose page sidebar position', 'inforward'),
					'options' => array(
						' ' => esc_html__('Default Sidebar Position', 'inforward'),
						'cp-no-sidebar' => esc_html__('Without Sidebar', 'inforward'),
						'cp-left-sidebar' => esc_html__('Left Sidebar', 'inforward'),
						'cp-right-sidebar' => esc_html__('Right Sidebar', 'inforward')
					)
				),
				array(
					'name'    => esc_html__('Sidebar Setting', 'inforward'),
					'id'      => $prefix . 'page_sidebar',
					'type'    => 'select',
					'std'     => '',
					'js_options' => array(
						'width' => '100%',
						'minimumResultsForSearch' => '-1',
						'placeholder' => esc_html__('Choose a custom sidebar', 'inforward')
					),
					'desc'    => esc_html__('Choose a custom sidebar', 'inforward'),
					'options' => $registered_custom_sidebars
				),
				array(
					'name'    => esc_html__('Page Content Padding', 'inforward'),
					'id'      => $prefix . 'page_content_padding',
					'type'    => 'dimension',
					'std'     => '',
					'desc'    => esc_html__('In pixels ex: 50px. Leave empty for default value of 100, 100px.', 'inforward'),
					'options' => array(
						'top', 'bottom'
					),
				),
			)
		);

		/*	Team Settings
		/* ---------------------------------------------------------------------- */

		$meta_boxes[] = array(
			'id'       => 'team-settings',
			'title'    => esc_html__('Team Settings', 'inforward'),
			'pages'    => array( 'team-members' ),
			'context'  => 'normal',
			'priority' => 'low',
			'fields'   => array(
				array(
					'name' => esc_html__('Position', 'inforward'),
					'id'   => $prefix . 'tm_position',
					'type' => 'text',
					'std'  => '',
					'desc' => ''
				),
				array(
					'name' => esc_html__('LinkedIn', 'inforward'),
					'id'   => $prefix . 'tm_linkedin',
					'type' => 'text',
					'std'  => '',
					'desc' => ''
				),
				array(
					'name' => esc_html__('Tumblr', 'inforward'),
					'id'   => $prefix . 'tm_tumblr',
					'type' => 'text',
					'std'  => '',
					'desc' => ''
				),
				array(
					'name' => esc_html__('Gplus', 'inforward'),
					'id'   => $prefix . 'tm_gplus',
					'type' => 'text',
					'std'  => '',
					'desc' => ''
				),
				array(
					'name' => esc_html__('Twitter', 'inforward'),
					'id'   => $prefix . 'tm_twitter',
					'type' => 'text',
					'std'  => '',
					'desc' => ''
				),
				array(
					'name' => esc_html__('Instagram', 'inforward'),
					'id'   => $prefix . 'tm_instagram',
					'type' => 'text',
					'std'  => '',
					'desc' => ''
				),
				array(
					'name' => esc_html__('Facebook', 'inforward'),
					'id'   => $prefix . 'tm_facebook',
					'type' => 'text',
					'std'  => '',
					'desc' => ''
				),
				array(
					'name' => esc_html__('E-mail', 'inforward'),
					'id'   => $prefix . 'tm_mail',
					'type' => 'text',
					'std'  => '',
					'desc' => ''
				),
				array(
					'name'    => esc_html__('Page Content Padding', 'inforward'),
					'id'      => $prefix . 'page_content_padding',
					'type'    => 'dimension',
					'std'     => '',
					'desc'    => esc_html__('In pixels ex: 50px. Leave empty for default value of 120, 120px.', 'inforward'),
					'options' => array(
						'top', 'bottom'
					),
				)
			)
		);
		
		/*	Testimonials Settings
		/* ---------------------------------------------------------------------- */

		$meta_boxes[] = array(
			'id'       => 'testimonials-settings',
			'title'    => esc_html__('Testimonials Settings', 'inforward'),
			'pages'    => array('testimonials'),
			'context'  => 'normal',
			'priority' => 'low',
			'fields'   => array(
				array(
					'name' => esc_html__('Company', 'inforward'),
					'id'   => $prefix . 'tm_company',
					'type' => 'text',
					'std'  => '',
					'desc' => ''
				),
			)
		);

		/*	Backgrounds
		/* ---------------------------------------------------------------------- */

		$meta_boxes[] = array(
			'id'       => 'page-backgrounds',
			'title'    => esc_html__('Backgrounds', 'inforward'),
			'pages'    => array('page','post'),
			'context'  => 'normal',
			'priority' => 'default',
			'fields'   => array(
				array(
					'name'    => esc_html__('Body Background color', 'inforward'),
					'id'      => $prefix . 'body_bg_color',
					'type'    => 'color',
					'std'     => '',
					'desc'    => esc_html__('Select the background color of the body', 'inforward')
				),
				array(
					'name'    => esc_html__('Content Background Transparent', 'inforward'),
					'id'      => $prefix . 'hide_content_bg',
					'type'    => 'checkbox',
					'std'     => 0,
					'desc'    => esc_html__('Content Background Transparent?', 'inforward'),
				),
				array(
					'name'    => esc_html__('Background image', 'inforward'),
					'id'      => $prefix . 'bg_image',
					'type'    => 'thickbox_image',
					'std'     => '',
					'desc'    => esc_html__('Select the background image', 'inforward')
				),
				array(
					'name'    => esc_html__('Background repeat', 'inforward'),
					'id'      => $prefix . 'bg_image_repeat',
					'type'    => 'select',
					'std'     => '',
					'desc'    => esc_html__('Select the repeat mode for the background image', 'inforward'),
					'options' => array(
						'' => esc_html__('Default', 'inforward'),
						'repeat' => esc_html__('Repeat', 'inforward'),
						'no-repeat' => esc_html__('No Repeat', 'inforward'),
						'repeat-x' => esc_html__('Repeat Horizontally', 'inforward'),
						'repeat-y' => esc_html__('Repeat Vertically', 'inforward')
					)
				),
				array(
					'name'    => esc_html__('Background position', 'inforward'),
					'id'      => $prefix . 'bg_image_position',
					'type'    => 'select',
					'std'     => '',
					'desc'    => esc_html__('Select the position for the background image', 'inforward'),
					'options' => array(
						'' => esc_html__('Default', 'inforward'),
						'top left' => esc_html__('Top left', 'inforward'),
						'top center' => esc_html__('Top center', 'inforward'),
						'top right' => esc_html__('Top right', 'inforward'),
						'bottom left' => esc_html__('Bottom left', 'inforward'),
						'bottom center' => esc_html__('Bottom center', 'inforward'),
						'bottom right' => esc_html__('Bottom right', 'inforward')
					)
				),
				array(
					'name'    => esc_html__('Background attachment', 'inforward'),
					'id'      => $prefix . 'bg_image_attachment',
					'type'    => 'select',
					'std'     => '',
					'desc'    => esc_html__('Select the attachment for the background image ', 'inforward'),
					'options' => array(
						'' => esc_html__('Default', 'inforward'),
						'scroll' => esc_html__('Scroll', 'inforward'),
						'fixed' => esc_html__('Fixed', 'inforward')
					)
				),
				array(
					'name'    => esc_html__('Footer Background color', 'inforward'),
					'id'      => $prefix . 'footer_bg_color',
					'type'    => 'color',
					'std'     => '',
					'desc'    => esc_html__('Select the background color of the footer', 'inforward')
				),
			)
		);

		return $meta_boxes;
	}

}

new Inforward_Theme_Metaboxes;
