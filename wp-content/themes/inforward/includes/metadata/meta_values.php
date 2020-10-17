<?php
if (!function_exists('inforward_cat_sidebars')) {

	function inforward_cat_sidebars() {

		$registered_sidebars = INFORWARD_HELPER::get_registered_sidebars(array());
		$registered_custom_sidebars = array();

		if (!empty($registered_sidebars)) {
			foreach($registered_sidebars as $key => $value) {
				if (strpos($key, 'Footer Row') === false) {
					$registered_custom_sidebars[$key] = $value;
				}
			}
		}

		return $registered_custom_sidebars;

	}

}

if (!function_exists('inforward_cat_meta_view')) {

	function inforward_cat_meta_view() {

		$sidebar_options = inforward_cat_sidebars();

		return array(
			'sidebar_position' => array(
				'name' => 'sidebar_position',
				'title' => esc_html__('Sidebar Position', 'inforward'),
				'desc' => esc_html__('Choose sidebar position', 'inforward'),
				'type' => 'select',
				'default' => '',
				'options' => array(
					'' => esc_html__('Default Sidebar Position', 'inforward'),
					'no_sidebar' => esc_html__('No Sidebar', 'inforward'),
					'sbl' => esc_html__('Left Sidebar', 'inforward'),
					'sbr' => esc_html__('Right Sidebar', 'inforward')
				)
			),
			'sidebar' => array(
				'name' => 'sidebar',
				'title' => esc_html__('Sidebar Setting', 'inforward'),
				'desc' => esc_html__('Select the sidebar you would like to display.', 'inforward'),
				'type' => 'select',
				'default' => '',
				'options' => $sidebar_options
			),
			'page_layout' => array(
				'name' => 'page_layout',
				'title' => esc_html__('Page Layout', 'inforward'),
				'desc' => esc_html__('Choose page layout style', 'inforward'),
				'type' => 'select',
				'default' => '',
				'options' => array(
					'' => esc_html__('Default Layout', 'inforward'),
					'boxed-layout' => esc_html__('Boxed Layout', 'inforward'),
					'wide-layout' => esc_html__('Wide Layout', 'inforward')
				)
			),
			'shop_view' => array(
				'name' => 'shop_view',
				'title' => esc_html__('Shop View', 'inforward'),
				'desc' => esc_html__('Choose shop view layout - grid or list', 'inforward'),
				'type' => 'select',
				'default' => 'view-grid',
				'options' => array(
					'view-grid' => esc_html__('Grid View', 'inforward'),
					'list_view_products' => esc_html__('List View', 'inforward')
				)
			),
			'overview_column_count' => array(
				'name' => 'overview_column_count',
				'title' => esc_html__('Column Count', 'inforward'),
				'desc' => esc_html__('This controls how many columns should be appeared on overview pages.', 'inforward'),
				'type' => 'select',
				'default' => '',
				'options' => array(
					'' => esc_html__('Default', 'inforward'),
					3 => 3,
					4 => 4
				)
			)
		);

	}
}