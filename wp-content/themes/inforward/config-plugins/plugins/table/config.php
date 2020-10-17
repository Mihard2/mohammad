<?php

if ( !class_exists('Inforward_VC_Table') ) {

	class Inforward_VC_Table extends Inforward_Plugins_Config {

		function __construct() {

			if ( !defined( 'WPB_VC_TABLE_MANAGER_VERSION' ) ) return;

			$this->add_hooks();
		}

		public function add_hooks() {
			add_action('wp_enqueue_scripts', array(&$this, 'enqueue_styles_scripts'));
			
			remove_action('admin_footer', 'vc_table_param_form_field_templates');
			add_action('admin_footer', array(&$this, 'vc_table_param_form_field_templates'));
		}

		public function enqueue_styles_scripts() {
			$frontend_css = self::$pathes['BASE_URI'] . 'table/css/vc-mod-table.css';
			wp_enqueue_style( 'inforward-vc-table', $frontend_css );
		}

		public function vc_table_param_form_field_templates() {
			require_once get_template_directory() . '/config-plugins/plugins/table/templates.html.php';
		}

	}

}