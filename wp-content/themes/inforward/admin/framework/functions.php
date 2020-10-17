<?php

if ( !function_exists('inforward_check_theme_options') ) {

	function inforward_check_theme_options() {
		// check default options
		global $inforward_settings;

		ob_start();
		include( get_template_directory() . '/admin/framework/theme-options/default-theme-options.php' );
		$options = ob_get_clean();
		$default_settings = json_decode($options, true);

		foreach ( $default_settings as $key => $value ) {

			if ( is_array($value) ) {
				foreach ( $value as $key1 => $value1 ) {
					if ((!isset($inforward_settings[$key][$key1]) || !$inforward_settings[$key][$key1])) {
						$inforward_settings[$key][$key1] = $default_settings[$key][$key1];
					}
				}
			} else {
				if ( !isset($inforward_settings[$key]) ) {
					$inforward_settings[$key] = $default_settings[$key];
				}
			}
		}

		return $inforward_settings;
	}

}

if ( !function_exists('inforward_product_columns') ) {
	function inforward_product_columns() {
		return array(
			"2" => "2",
			"3" => "3",
			"4" => "4"
		);
	}
}

if ( !function_exists('inforward_options_header_types') ) {
	function inforward_options_header_types() {
		return array(
			'cp-type-1' => array('alt' => esc_html__('Header Type 1', 'inforward'), 'img' => get_theme_file_uri('admin/framework/theme-options/headers/header_1.jpg')),
			'cp-type-2' => array('alt' => esc_html__('Header Type 2', 'inforward'), 'img' => get_theme_file_uri('admin/framework/theme-options/headers/header_2.jpg')),
			'cp-type-3' => array('alt' => esc_html__('Header Type 3', 'inforward'), 'img' => get_theme_file_uri('admin/framework/theme-options/headers/header_3.jpg')),
			'cp-type-4' => array('alt' => esc_html__('Header Type 4', 'inforward'), 'img' => get_theme_file_uri('admin/framework/theme-options/headers/header_4.jpg')),
			'cp-type-5' => array('alt' => esc_html__('Header Type 5', 'inforward'), 'img' => get_theme_file_uri('admin/framework/theme-options/headers/header_5.jpg')),
			'cp-type-6' => array('alt' => esc_html__('Header Type 6', 'inforward'), 'img' => get_theme_file_uri('admin/framework/theme-options/headers/header_6.jpg')),
		);
	}
}

if ( !function_exists('inforward_options_wrapper') ) {
	function inforward_options_wrapper() {
		return array(
			"cp-wide-layout-type" => array( 'alt' => esc_html__('Wide', 'inforward'), 'img' => get_theme_file_uri('admin/framework/theme-options/layouts/layout-wide.jpg')),
			"cp-boxed-layout-type" => array( 'alt' => esc_html__('Boxed', 'inforward'), 'img' => get_theme_file_uri('admin/framework/theme-options/layouts/layout-boxed.jpg')),
		);
	}
}

if ( !function_exists('inforward_options_layouts') ) {
	function inforward_options_layouts() {
		return array(
			"cp-no-sidebar" => array( 'alt' => esc_html__('Without Sidebar', 'inforward'), 'img' => get_template_directory_uri() . '/admin/framework/theme-options/layouts/layout-full.jpg' ),
			"cp-left-sidebar" => array( 'alt' => esc_html__('Left Sidebar', 'inforward'), 'img' => get_template_directory_uri() . '/admin/framework/theme-options/layouts/layout-left.jpg' ),
			"cp-right-sidebar" => array( 'alt' => esc_html__('Right Sidebar', 'inforward'), 'img' => get_template_directory_uri() . '/admin/framework/theme-options/layouts/layout-right.jpg' )
		);
	}
}

if ( !function_exists('inforward_options_sidebars') ) {
	function inforward_options_sidebars() {
		return array(
			"cp-left-sidebar",
			"cp-right-sidebar"
		);
	}
}
if ( !function_exists('inforward_options_header_position') ) {
	function inforward_options_header_position() {
		return array(
			"relative" => "relative",
			"fixed" => "fixed"
		);
	}
}
