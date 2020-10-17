<?php
/**
 * Inforward Settings Options
 */

if ( !class_exists('inforward_redux_settings') ) {

	class inforward_redux_settings {
		public $args = array();
		public $sections = array();
		public $theme;
		public $version;
		public $ReduxFramework;

		public function __construct() {

			if ( !class_exists('ReduxFramework') ) {
				return;
			}

			$this->initSettings();

		}

		public function initSettings() {

			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Create the sections and fields
			$this->setSections();

			if ( !isset($this->args['opt_name']) ) { return; }

			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);

		}

		public function arrayNumber($from = 0, $to = 50, $step = 1, $array = array()) {
			for ($i = $from; $i <= $to; $i += $step) {
				$array[$i] = $i;
			}
			return $array;
		}

		public function setSections() {

			$page_wrapper = inforward_options_wrapper();
			$page_layouts = inforward_options_layouts();
			$sidebars = inforward_options_sidebars();
			$header_type = inforward_options_header_types();
			$header_position = inforward_options_header_position();
			
			$this->sections[] = array(
				'icon' => 'el-icon-dashboard',
				'icon_class' => 'icon',
				'title' => esc_html__('General', 'inforward'),
				'fields' => array(
					array(
						'id' => 'show-loading-overlay',
						'type' => 'switch',
						'title' => esc_html__( 'Loading Overlay', 'inforward' ),
						'default' => true,
						'on' => esc_html__('Show', 'inforward'),
						'off' => esc_html__('Hide', 'inforward'),
					),
					array(
						'id' => 'wrapper',
						'type' => 'image_select',
						'title' => esc_html__('Page Wrapper', 'inforward'),
						'options' => $page_wrapper,
						'default' => 'cp-wide-layout-type'
					),
					array(
						'id' => 'page-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'inforward'),
						'options' => $page_layouts,
						'default' => 'cp-right-sidebar'
					),
					array(
						'id' => 'sidebar',
						'type' => 'select',
						'title' => esc_html__('Select Sidebar', 'inforward'),
						'required' => array( 'page-layout','equals', $sidebars ),
						'data' => 'sidebars',
						'default' => 'general-widget-area'
					),
					array(
						'id' => '101',
						'type' => 'info',
						'title' => esc_html__('Mailchimp api', 'inforward'),
						'notice' => false
					),
					array(
						'id' => "mailchimp-api",
						'type' => 'text',
						'title' => esc_html__('Enter your Mailchimp Api', 'inforward'),
						'default' => ''
					),
					array(
						'id' => "mailchimp-id",
						'type' => 'text',
						'title' => esc_html__('Enter your Mailchimp Id', 'inforward'),
						'default' => ''
					),
					array(
						'id' => "mailchimp-center",
						'type' => 'text',
						'title' => esc_html__('Enter your Mailchimp data center(e.g. us4)', 'inforward'),
						'default' => ''
					),
					array(
						'id' => 'show-mailchimp-gdpr',
						'type' => 'switch',
						'title' => esc_html__( 'GDPR', 'inforward' ),
						'default' => false,
						'on' => esc_html__('Show', 'inforward'),
						'off' => esc_html__('Hide', 'inforward'),
					),
					
				)
			);

			// Logo
			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Logo', 'inforward'),
				'fields' => array(
				    array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 1', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'logo',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo', 'inforward'),
						'default' => array(
							'url' => get_template_directory_uri() . '/images/logo2.png'
						)
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 2', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'logo2',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo', 'inforward'),
						'default' => array(
							'url' => get_template_directory_uri() . '/images/logo6.png'
						)
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 3', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'logo3',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo', 'inforward'),
						'default' => array(
							'url' => get_template_directory_uri() . '/images/logo4.png'
						)
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 4', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'logo4',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo', 'inforward'),
						'default' => array(
							'url' => get_template_directory_uri() . '/images/logo5.png'
						)
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 5', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'logo5',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo', 'inforward'),
						'default' => array(
							'url' => get_template_directory_uri() . '/images/logo.png'
						)
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 6', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'logo6',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo', 'inforward'),
						'default' => array(
							'url' => get_template_directory_uri() . '/images/logo4.png'
						)
					),
					array(
						'id' => 'favicon',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Favicon', 'inforward'),
						'default' => array(
							'url' => get_template_directory_uri() . '/images/favicon.png'
						)
					)
				)
			);

			// Skin Styling
			$this->sections[] = array(
				'icon' => 'el-icon-broom',
				'icon_class' => 'icon',
				'title' => esc_html__('Skin', 'inforward'),
				'fields' => array(
					array(
						'id' => 'primary-color',
						'type' => 'color',
						'title' => esc_html__('Primary Color', 'inforward'),
						'desc' => esc_html__('Color for buttons and other', 'inforward'),
						'default' => '#14468c',
						'validate' => 'color',
					),
					array(
						'id' => 'primary-inverse-color',
						'type' => 'color',
						'title' => esc_html__('Primary Inverse Color', 'inforward'),
						'desc' => esc_html__('Color for link hover and other', 'inforward'),
						'default' => '#bf0d3e',
						'validate' => 'color',
					),
					array(
						'id' => 'secondary-color',
						'type' => 'color',
						'title' => esc_html__('Secondary Color', 'inforward'),
						'default' => '#0d2f5d',
						'validate' => 'color',
					),
					array(
						'id' => 'accent-color',
						'type' => 'color',
						'title' => esc_html__('Accent Color', 'inforward'),
						'desc' => esc_html__('Color for button to top, blockquote and other', 'inforward'),
						'default' => '#eee',
						'validate' => 'color',
					),
					array(
						'id' => 'overlay-color',
						'type' => 'color_rgba',
						'title' => esc_html__('Overlay Color', 'inforward'),
						'desc' => esc_html__('Color for portfolio hover overlay and other', 'inforward'),
						'default'   => array(
							'color'     => '#051640',
							'alpha'     => .5
						),
					),
					array(
						'id' => 'selection-color',
						'type' => 'color',
						'desc' => esc_html__('The ::selection selector matches the portion of an element that is selected by a user.', 'inforward'),
						'title' => esc_html__('Selection Background Color', 'inforward'),
						'default'   => '#333',
					),
					array(
						'id' => 'content-link-color',
						'type' => 'link_color',
						'active' => false,
						'title' => esc_html__('Link Color', 'inforward'),
						'default' => array(
							'regular' => '#333',
							'hover' => '#333'
						)
					),
					array(
						'id' => 'loading-line-color',
						'type' => 'color',
						'title' => esc_html__('Loading Color', 'inforward'),
						'desc' => esc_html__('Color for loading line color', 'inforward'),
						'default' => '#bf0d3e',
						'validate' => 'color',
					),
					array(
						'id' => 'loading-bg-color',
						'type' => 'color',
						'title' => esc_html__('Loading Background Color', 'inforward'),
						'desc' => esc_html__('Color for loading background color', 'inforward'),
						'default' => '#0d2f5d',
						'validate' => 'color',
					),
					array(
						'id' => 'donate-color-title',
						'type' => 'color',
						'title' => esc_html__('Donate Color Title', 'inforward'),
						'desc' => '',
						'default' => '#fff',
						'validate' => 'color',
					),
					array(
						'id' => 'donate-color',
						'type' => 'link_color',
						'active' => false,
						'title' => esc_html__('Donate Color Background', 'inforward'),
						'default' => array(
							'regular' => '#bf0d3e',
							'hover' => '#ac0c38'
						)
					),
					array(
						'id' => 'donate-color-shadow',
						'type' => 'color_rgba',
						'title' => esc_html__('Donate Color Shadow', 'inforward'),
						'desc' => '',
						'default'   => array(
							'color'     => '#bf0d3e',
							'alpha'     => .43
						),
					),
					array(
						'id' => 'donate-color-shadow-hover',
						'type' => 'color_rgba',
						'title' => esc_html__('Donate Color Shadow Hover', 'inforward'),
						'desc' => '',
						'default'   => array(
							'color'     => '#ac0c38',
							'alpha'     => .43
						),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Typography', 'inforward'),
				'fields' => array(
					array(
						'id' => 'select-google-charset',
						'type' => 'switch',
						'title' => esc_html__('Select Google Font Character Sets', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'google-charsets',
						'type' => 'button_set',
						'title' => esc_html__('Google Font Character Sets', 'inforward'),
						'multi' => true,
						'required' => array('select-google-charset', 'equals', true),
						'options'=> array(
							'cyrillic' => 'Cyrrilic',
							'cyrillic-ext' => 'Cyrrilic Extended',
							'greek' => 'Greek',
							'greek-ext' => 'Greek Extended',
							'khmer' => 'Khmer',
							'latin' => 'Latin',
							'latin-ext' => 'Latin Extneded',
							'vietnamese' => 'Vietnamese'
						),
						'default' => array('latin','greek-ext','cyrillic','latin-ext','greek','cyrillic-ext','vietnamese','khmer')
					),
					array(
						'id' => 'body-font',
						'type' => 'typography',
						'title' => esc_html__('Body Font', 'inforward'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Open Sans',
							'font-size' => '16px',
							'line-height' => '28px'
						),
					),
					array(
						'id' => 'h1-font',
						'type' => 'typography',
						'title' => esc_html__('H1 Font', 'inforward'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Lato',
							'font-size' => '60px',
							'line-height' => '68px'
						),
					),
					array(
						'id' => 'h2-font',
						'type' => 'typography',
						'title' => esc_html__('H2 Font', 'inforward'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Lato',
							'font-size' => '48px',
							'line-height' => '52px'
						),
					),
					array(
						'id' => 'h3-font',
						'type' => 'typography',
						'title' => esc_html__('H3 Font', 'inforward'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Lato',
							'font-size' => '36px',
							'line-height' => '40px'
						),
					),
					array(
						'id'=>'h4-font',
						'type' => 'typography',
						'title' => esc_html__('H4 Font', 'inforward'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Lato',
							'font-size' => '30px',
							'line-height' => '34px'
						),
					),
					array(
						'id' => 'h5-font',
						'type' => 'typography',
						'title' => esc_html__('H5 Font', 'inforward'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Lato',
							'font-size' => '24px',
							'line-height' => '28px'
						),
					),
					array(
						'id' => 'h6-font',
						'type' => 'typography',
						'title' => esc_html__('H6 Font', 'inforward'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Lato',
							'font-size' => '18px',
							'line-height' => '24px'
						),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Backgrounds', 'inforward'),
				'fields' => array(
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('Body Background', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'body-bg',
						'type' => 'background',
						'title' => esc_html__('Background', 'inforward')
					),
					array(
						'id'=>'1',
						'type' => 'info',
						'title' => esc_html__('Page Content Background', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'content-bg-color',
						'type' => 'color',
						'title' => esc_html__('Content Background Color', 'inforward'),
						'default' => '#ffffff',
						'validate' => 'color',
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Main Menu', 'inforward'),
				'fields' => array(
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('Sticky Menu', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'sticky-menu-bg-color',
						'type' => 'color',
						'title' => esc_html__('Background Color', 'inforward'),
						'default' => '#0d2f5d',
						'validate' => 'color',
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__( 'Top Level Menu Item', 'inforward' ),
						'notice' => false
					),
					array(
						'id' => 'menu-font',
						'type' => 'typography',
						'title' => esc_html__('Menu Font', 'inforward'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'color' => false,
						'default'=> array(
							'google' => true,
							'font-weight' => '400',
							'font-family'=> 'Open Sans',
							'font-size' => '16px',
							'line-height' => '24px'
						),
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If menu type is like 3,4', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'header3-current-menu-bg-color',
						'type' => 'color',
						'title' => esc_html__('Hover Background Color', 'inforward'),
						'default' => '#0d2f5d',
						'validate' => 'color',
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If menu type is like 1,3,4', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'primary-toplevel-type1-link-color',
						'type' => 'link_color',
						'active' => false,
						'title' => esc_html__('Link Color', 'inforward'),
						'default' => array(
							'regular' => '#fff',
							'hover' => '#fff'
						)
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If menu type is like 2', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'primary-toplevel-type2-link-color',
						'type' => 'link_color',
						'active' => false,
						'title' => esc_html__('Link Color', 'inforward'),
						'default' => array(
							'regular' => '#333',
							'hover' => '#325794'
						)
					),
					array(
						'id'=>'1',
						'type' => 'info',
						'title' => esc_html__('Sub Menu', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'sub-menu-font',
						'type' => 'typography',
						'title' => esc_html__('Sub Menu Font', 'inforward'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'color' => false,
						'default'=> array(
							'google' => true,
							'font-weight' => '400',
							'font-family'=> 'Open Sans',
							'font-size' => '16px',
							'line-height' => '16px'
						),
					),
					array(
						'id' => 'sub-menu-bg-color',
						'type' => 'color',
						'title' => esc_html__('Background Color', 'inforward'),
						'default' => '#14468c',
						'validate' => 'color',
					),
					array(
						'id' => 'sub-menu-text-color',
						'type' => 'link_color',
						'active' => false,
						'title' => esc_html__('Link Color', 'inforward'),
						'default' => array(
							'regular' => '#333',
							'hover' => '#fff',
						)
					),
					array(
						'id'=>'1',
						'type' => 'info',
						'title' => esc_html__('Mobile Menu', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'mobile-menu-btn-color',
						'type' => 'color',
						'title' => esc_html__('Button Color', 'inforward'),
						'default' => '#bf0d3e',
						'validate' => 'color',
					),
					array(
						'id' => 'mobile-menu-bg-color',
						'type' => 'color',
						'title' => esc_html__('Background Color', 'inforward'),
						'default' => '#fff',
						'validate' => 'color',
					),
					array(
						'id' => 'mobile-menu-link-color',
						'type' => 'link_color',
						'active' => false,
						'title' => esc_html__('Text Color', 'inforward'),
						'default' => array(
							'regular' => '#333',
							'hover' => '#fff',
						)
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Header', 'inforward'),
				'fields' => array(
					array(
						'id' => 'header-type-1-top-color',
						'type' => 'color',
						'title' => esc_html__('Background Color for Top Header1', 'inforward'),
						'default' => '#0d2f5d',
						'validate' => 'color',
					),
					array(
						'id' => 'header-type-2-top-color',
						'type' => 'color',
						'title' => esc_html__('Background Color for Top Header2', 'inforward'),
						'default' => '',
						'validate' => 'color',
					),
					array(
						'id' => 'header-type-3-top-color',
						'type' => 'color',
						'title' => esc_html__('Background Color for Top Header3', 'inforward'),
						'default' => '#fff',
						'validate' => 'color',
					),
					array(
						'id' => 'header-type-3-menu-bg-color',
						'type' => 'color',
						'title' => esc_html__('Background Color for Menu Header3', 'inforward'),
						'default' => '#0d2f5d',
						'validate' => 'color',
					),
					array(
						'id' => 'header-type-4-top-color',
						'type' => 'color',
						'title' => esc_html__('Background Color for Top Header4', 'inforward'),
						'default' => '#0e1e40',
						'validate' => 'color',
					),
					array(
						'id' => 'header-type-4-menu-bg-color',
						'type' => 'color',
						'title' => esc_html__('Background Menu Color for Header4', 'inforward'),
						'default' => '#14468c',
						'validate' => 'color',
					),
					array(
						'id' => 'header-type-5-top-color',
						'type' => 'color',
						'title' => esc_html__('Background Color for Top Header5', 'inforward'),
						'default' => '#fff',
						'validate' => 'color',
					),
					array(
						'id' => 'header-bg',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Background Image', 'inforward'),
						'default' => array(
							'url' => ''
						)
					),
				)
			);
			
			
			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Footer', 'inforward'),
				'fields' => array(
					array(
						'id' => 'footer-bg',
						'type' => 'background',
						'title' => esc_html__('Background for Type 1', 'inforward'),
						'default' => array(
							'background-color' => '#0e1e40',
							'background-image' => ''
						)
					),
					array(
						'id' => 'footer-bg2',
						'type' => 'background',
						'title' => esc_html__('Background for Type 2', 'inforward'),
						'default' => array(
							'background-color' => '#0e1e40',
							'background-image' => ''
						)
					),
					array(
						'id' => 'footer-bg3',
						'type' => 'background',
						'title' => esc_html__('Background for Type 3', 'inforward'),
						'default' => array(
							'background-color' => '#f6f6f6',
							'background-image' => ''
						)
					),
					array(
						'id' => 'footer-bg4',
						'type' => 'background',
						'title' => esc_html__('Background for Type 4', 'inforward'),
						'default' => array(
							'background-color' => '#0e1e40',
							'background-image' => ''
						)
					),
					
					array(
						'id' => 'footer-bg5',
						'type' => 'background',
						'title' => esc_html__('Background for Type 5', 'inforward'),
						'default' => array(
							'background-color' => '#0e1e40',
							'background-image' => get_template_directory_uri() . '/images/footer5.jpg'
						)
					),
					array(
						'id' => 'footer-heading-color',
						'type' => 'color',
						'title' => esc_html__('Heading Color', 'inforward'),
						'default' => '#fff',
						'validate' => 'color'
					),
					array(
						'id' => 'footer-text-color',
						'type' => 'color',
						'title' => esc_html__('Text Color', 'inforward'),
						'default' => '#d2d2d2',
						'validate' => 'color'
					),
					array(
						'id' => 'footer-link-color',
						'type' => 'link_color',
						'active' => false,
						'title' => esc_html__('Link Color', 'inforward'),
						'default' => array(
							'regular' => '#bf0d3e',
							'hover' => '#bf0d3e'
						)
					),
					array(
						'id'=>'1',
						'type' => 'info',
						'title' => esc_html__('Footer Bottom(for header type 2, 4)', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'footer-bottom-link-color',
						'type' => 'link_color',
						'active' => false,
						'title' => esc_html__('Link Color', 'inforward'),
						'default' => array(
							'regular' => '#fff',
							'hover' => '#fff',
						)
					),
					array(
						'id' => 'footer-bottom-text-color',
						'type' => 'color',
						'title' => esc_html__('Text Color', 'inforward'),
						'default' => '#999',
						'validate' => 'color'
					),
				)
			);

			// Header Settings
			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'icon_class' => 'icon',
				'title' => esc_html__('Header', 'inforward'),
				'fields' => array(
				    array(
						'id' => 'header-sticky',
						'type' => 'switch',
						'title' => esc_html__('Header Sticky', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'header-position',
						'type' => 'select',
						'title' => esc_html__('Header position', 'inforward'),
						'options' => $header_position,
						'default' => 'relative'
					),
				    array(
						'id' => "header-inquire-url",
						'type' => 'text',
						'title' => esc_html__('Donate URL', 'inforward'),
						'default' => ''
					),
					array(
						'id' => "header-inquire-title",
						'type' => 'text',
						'title' => esc_html__('Donate title', 'inforward'),
						'default' => esc_html__('Donate', 'inforward')
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 1', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'header-type-1-inquire',
						'type' => 'switch',
						'title' => esc_html__('Show Donate Button', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 2', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'header-type-2-inquire',
						'type' => 'switch',
						'title' => esc_html__('Show Donate Button', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 3', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'header-type-3-search',
						'type' => 'switch',
						'title' => esc_html__('Show Search', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),	
					array(
						'id' => 'header-type-3-form',
						'type' => 'switch',
						'title' => esc_html__('Show Form', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),	
					array(
						'id' => 'header-type-3-inquire',
						'type' => 'switch',
						'title' => esc_html__('Show Donate Button', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 4', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'header-type-4-search',
						'type' => 'switch',
						'title' => esc_html__('Show Search', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'header-type-4-form',
						'type' => 'switch',
						'title' => esc_html__('Show Form', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'header-type-4-inquire',
						'type' => 'switch',
						'title' => esc_html__('Show Donate Button', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'show-header4-top-bar',
						'type' => 'switch',
						'title' => esc_attr__('Show Top Bar', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'header-type-4-social',
						'type' => 'switch',
						'title' => esc_html__('Show Social Buttons', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),	
					array(
						'id' => "header-social-linkedin",
						'type' => 'text',
						'title' => esc_html__('LinkedIn', 'inforward'),
						'required' => array('header-type-4-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header-social-tumblr",
						'type' => 'text',
						'title' => esc_html__('Tumblr', 'inforward'),
						'required' => array('header-type-4-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header-social-vimeo",
						'type' => 'text',
						'title' => esc_html__('Vimeo', 'inforward'),
						'required' => array('header-type-4-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header-social-youtube",
						'type' => 'text',
						'title' => esc_html__('Youtube', 'inforward'),
						'required' => array('header-type-4-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header-social-facebook",
						'type' => 'text',
						'title' => esc_html__('Facebook', 'inforward'),
						'required' => array('header-type-4-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header-social-twitter",
						'type' => 'text',
						'title' => esc_html__('Twitter', 'inforward'),
						'required' => array('header-type-4-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header-social-instagram",
						'type' => 'text',
						'title' => esc_html__('Instagram', 'inforward'),
						'required' => array('header-type-4-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header-social-flickr",
						'type' => 'text',
						'title' => esc_html__('Flickr', 'inforward'),
						'required' => array('header-type-4-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header-social-telegram",
						'type' => 'text',
						'title' => esc_html__('Telegram', 'inforward'),
						'required' => array('header-type-4-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 5', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'header-type-5-inquire',
						'type' => 'switch',
						'title' => esc_html__('Show Donate Button', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header type is like 6', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'header-type-6-inquire',
						'type' => 'switch',
						'title' => esc_html__('Show Donate Button', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'header-type-6-search',
						'type' => 'switch',
						'title' => esc_html__('Show Search', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'show-header6-top-bar',
						'type' => 'switch',
						'title' => esc_attr__('Show Top Bar', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => "header6-topbar-info",
						'type' => 'text',
						'title' => esc_html__('Top Bar Text', 'inforward'),
						'required' => array('show-header6-top-bar','equals',true),
						'default' => ''
					),
					array(
						'id' => 'header-type-6-social',
						'type' => 'switch',
						'title' => esc_html__('Show Social Buttons', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),	
					array(
						'id' => "header6-social-linkedin",
						'type' => 'text',
						'title' => esc_html__('LinkedIn', 'inforward'),
						'required' => array('header-type-6-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header6-social-tumblr",
						'type' => 'text',
						'title' => esc_html__('Tumblr', 'inforward'),
						'required' => array('header-type-6-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header6-social-vimeo",
						'type' => 'text',
						'title' => esc_html__('Vimeo', 'inforward'),
						'required' => array('header-type-6-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header6-social-youtube",
						'type' => 'text',
						'title' => esc_html__('Youtube', 'inforward'),
						'required' => array('header-type-6-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header6-social-facebook",
						'type' => 'text',
						'title' => esc_html__('Facebook', 'inforward'),
						'required' => array('header-type-6-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header6-social-twitter",
						'type' => 'text',
						'title' => esc_html__('Twitter', 'inforward'),
						'required' => array('header-type-6-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header6-social-instagram",
						'type' => 'text',
						'title' => esc_html__('Instagram', 'inforward'),
						'required' => array('header-type-6-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "header6-social-flickr",
						'type' => 'text',
						'title' => esc_html__('Flickr', 'inforward'),
						'required' => array('header-type-6-social','equals',true),
						'default' => '#'
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Page Header Type', 'inforward'),
				'fields' => array(
					array(
						'id' => 'header-type',
						'type' => 'image_select',
						'full_width' => true,
						'title' => esc_html__('Header Type', 'inforward'),
						'options' => $header_type,
						'default' => 'cp-type-1'
					),
				)
			);

			// Breadcrumbs
			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'icon_class' => 'icon',
				'title' => esc_html__('Breadcrumbs', 'inforward'),
				'fields' => array(

				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Pages & Posts', 'inforward'),
				'fields' => array(
					array(
						'id' => 'show-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'show-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'align-breadcrumbs',
						'type' => 'select',
						'title' => esc_html__('Title Align', 'inforward'),
						'options' => array(
							'center' => esc_html__('center', 'inforward'),
							'left' => esc_html__('left', 'inforward'),
							'right' => esc_html__('right', 'inforward')
						),
						'default' => array( 'left' )
					),
					array(
						'id' => 'breadcrumbs-title-color',
						'type' => 'color',
						'title' => esc_html__('Title Color', 'inforward'),
						'desc' => esc_html__('Color for title', 'inforward'),
						'default' => '#333',
						'validate' => 'color',
					),
					array(
						'id' => 'breadcrumbs-bg',
						'type' => 'background',
						'title' => esc_html__('Background', 'inforward'),
						'default' => array(
							'background-color' => '#f6f6f6',
							'background-image' => ' '
						)
					),
				)
			);
			
			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Shop', 'inforward'),
				'fields' => array(
					array(
						'id' => 'shop-show-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'shop-align-breadcrumbs',
						'type' => 'select',
						'title' => esc_html__('Title Align', 'inforward'),
						'options' => array(
							'center' => esc_html__('center', 'inforward'),
							'left' => esc_html__('left', 'inforward'),
							'right' => esc_html__('right', 'inforward')
						),
						'default' => array( 'left' )
					),
					array(
						'id' => 'shop-show-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'shop-breadcrumbs-title-color',
						'type' => 'color',
						'title' => esc_html__('Title Color', 'inforward'),
						'desc' => esc_html__('Color for title', 'inforward'),
						'default' => '#333',
						'validate' => 'color',
					),
					array(
						'id' => 'shop-breadcrumbs-bg',
						'type' => 'background',
						'title' => esc_html__('Background', 'inforward'),
						'default' => array(
							'background-color' => '#f6f6f6',
							'background-image' => ''
						)
					),
				)
			);
			

			// Blog
			$this->sections[] = array(
				'icon' => 'el-icon-file',
				'icon_class' => 'icon',
				'title' => esc_html__('Blog', 'inforward'),
				'fields' => array(
					array(
						'id' => 'post-metas',
						'type' => 'button_set',
						'title' => esc_html__('Post Meta', 'inforward'),
						'multi' => true,
						'options'=> array(
							'date' => esc_html__('Date', 'inforward'),
							'author' => esc_html__('Author', 'inforward'),
							'cats' => esc_html__('Categories', 'inforward'),
							'comments' => esc_html__('Comments', 'inforward'),
							'-' => esc_html__('None', 'inforward')
						),
						'default' => array( 'date', 'author','cats','comments', '-' )
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Blog Post', 'inforward'),
				'fields' => array(
					array(
						'id' => 'excerpt-count-big-thumbs',
						'type' => 'text',
						'title' => esc_html__( 'Excerpt Length', 'inforward' ),
						'desc' => esc_html__( 'The number of words for style Count Big Thumbs ', 'inforward' ),
						'default' => '300'
					),
					array(
						'id' => 'excerpt-count-small-thumbs',
						'type' => 'text',
						'title' => esc_html__( 'Excerpt Length', 'inforward' ),
						'desc' => esc_html__( 'The number of words for style Count Small Thumbs ', 'inforward' ),
						'default' => '300'
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Post Archive', 'inforward'),
				'fields' => array(
					array(
						'id' => 'post-archive-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'inforward'),
						'options' => $page_layouts,
						'default' => 'cp-no-sidebar'
					),
					array(
						'id' => 'archive-post-sidebar',
						'type' => 'select',
						'title' => esc_html__('Select Sidebar', 'inforward'),
						'required' => array( 'post-archive-layout','equals', $sidebars ),
						'data' => 'sidebars',
						'default' => 'general-widget-area'
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Single Post', 'inforward'),
				'fields' => array(
					array(
						'id' => 'post-single-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'inforward'),
						'options' => $page_layouts,
						'default' => 'cp-right-sidebar'
					),
					array(
						'id' => 'single-post-sidebar',
						'type' => 'select',
						'title' => esc_html__('Select Sidebar', 'inforward'),
						'required' => array( 'post-single-layout','equals', $sidebars ),
						'data' => 'sidebars',
						'default' => 'general-widget-area'
					),
					array(
						'id' => 'single-footer-sidebar',
						'type' => 'select',
						'title' => esc_html__('Get widgets for footer from page', 'inforward'),
						'data' => 'page',
						'default' => ''
					),
					array(
						'id' => 'single-post-metas',
						'type' => 'button_set',
						'title' => esc_html__('Post Meta', 'inforward'),
						'multi' => true,
						'options'=> array(
							'cats' => esc_html__('Categories', 'inforward'),
							'author' => esc_html__('Author', 'inforward'),
							'date' => esc_html__('Date', 'inforward'),
							'comments' => esc_html__('Comments', 'inforward'),
							'-' => esc_html__('None', 'inforward')
						),
						'desc' => esc_html__('Located at the top of the post', 'inforward'),
						'default' => array( 'cats','author','date','comments', '-' )
					),
					array(
						'id' => 'post-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-single-tag',
						'type' => 'switch',
						'title' => esc_html__('Show Tags', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-nav',
						'type' => 'switch',
						'title' => esc_html__('Prev/Next Navigation', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-author',
						'type' => 'switch',
						'title' => esc_html__('Show Author Info Box', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-related',
						'type' => 'switch',
						'title' => esc_html__('Show Related Posts', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-comments',
						'type' => 'switch',
						'title' => esc_html__('Show Comments', 'inforward'),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('Social Links', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'post-single-share',
						'type' => 'switch',
						'title' => esc_html__('Show Social Links', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-share-facebook',
						'type' => 'switch',
						'title' => esc_html__('Enable Facebook Share', 'inforward'),
						'required' => array('post-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-share-twitter',
						'type' => 'switch',
						'title' => esc_html__('Enable Twitter Share', 'inforward'),
						'required' => array('post-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-share-googleplus',
						'type' => 'switch',
						'title' => esc_html__('Enable Google Plus Share', 'inforward'),
						'required' => array('post-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-share-pinterest',
						'type' => 'switch',
						'title' => esc_html__('Enable Pinterest Share', 'inforward'),
						'required' => array('post-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'post-share-email',
						'type' => 'switch',
						'title' => esc_html__('Enable Email Share', 'inforward'),
						'required' => array('post-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
				)
			);

			// Javascript Code
			$this->sections[] = array(
				'icon_class' => 'el-icon-edit',
				'title' => esc_html__('Javascript Code', 'inforward'),
				'fields' => array(
					array(
						'id' => 'js-code-head',
						'type' => 'ace_editor',
						'title' => esc_html__('Javascript Code Before &lt;/head&gt;', 'inforward'),
						'subtitle' => esc_html__('Paste your JS code here.', 'inforward'),
						'mode' => 'javascript',
						'theme' => 'monokai',
						'default' => ""
					)
				)
			);

			// Footer Settings
			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'icon_class' => 'icon',
				'title' => esc_html__('Footer', 'inforward'),
				'fields' => array(
					array(
						'id' => 'footer-type',
						'type' => 'button_set',
						'title' => esc_html__('Footer Type', 'inforward'),
						'options' => array(
							'footer-1' => esc_html__('Type 1', 'inforward'),
							'footer-2' => esc_html__('Type 2', 'inforward'),
							'footer-3' => esc_html__('Type 3', 'inforward'),
							'footer-4' => esc_html__('Type 4', 'inforward'),
							'footer-5' => esc_html__('Type 5', 'inforward')
						),
						'default' => 'footer-1'
					),
					array(
						'id' => "footer-copyright",
						'type' => 'textarea',
						'title' => esc_html__('Copyright', 'inforward'),
						'default' => sprintf( esc_html__('Copyright © %s Linda Russell for Congress. All Rights Reserved.', 'inforward'), date('Y') )
					),
					array(
						'id' => 'show-footer-menu',
						'type' => 'switch',
						'title' => esc_html__('Show Footer Menu(for header type 2)', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'show-footer-newsletter',
						'type' => 'switch',
						'title' => esc_html__('Show Newsletter(for header type 1)', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
							'id' => 'footer-newsletter-donate-url',
							'type' => 'text',
							'title' => esc_html__('Donate URL(for header type 1)', 'inforward'),
							'desc' => esc_html__('Enter Donate URL.', 'inforward'),
							'default' => ''
						),
					array(
						'id' => 'show-footer-row-top',
						'type' => 'switch',
						'title' => esc_html__('Show Row Top widgets ?', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
					array(
						'id' => 'show-footer-row-middle',
						'type' => 'switch',
						'title' => esc_html__('Show Row Middle widgets ?', 'inforward'),
						'default' => false,
						'on' => esc_html__('Yes', 'inforward'),
						'off' => esc_html__('No', 'inforward'),
					),
				)
			);

			// 404 Page
			$this->sections[] = array(
				'icon' => 'el-icon-error',
				'icon_class' => 'icon',
				'title' => esc_html__('404 Page', 'inforward'),
				'fields' => array(
					array(
						'id' => 'error-content',
						'type' => 'textarea',
						'title' => esc_html__('Error text', 'inforward'),
						'validate' => 'html_custom',
						'default' => "It's probably some thing we've done wrong but now we know about it and we'll try to fix it.<br>Go <a href='#'>Home</a> or try to search:",
						'allowed_html' => array(
							'a' => array(
								'href' => array(),
								'title' => array()
							),
							'br' => array(),
							'p' => array(),
							'em' => array(),
							'strong' => array()
						)
					),
					array(
						'id' => '404-footer-sidebar',
						'type' => 'select',
						'title' => esc_html__('Get widgets for footer from page', 'inforward'),
						'data' => 'page',
						'default' => ''
					),
					array(
						'id' => 'footer-type-404',
						'type' => 'button_set',
						'title' => esc_html__('Footer Type', 'inforward'),
						'options' => array(
							'footer-1' => esc_html__('Type 1', 'inforward'),
							'footer-2' => esc_html__('Type 2', 'inforward'),
							'footer-3' => esc_html__('Type 3', 'inforward'),
							'footer-4' => esc_html__('Type 4', 'inforward')
						),
						'default' => 'footer-1'
					),
				)
			);
			
			// coming-soon
			$this->sections[] = array(
				'icon' => 'el-icon-error',
				'icon_class' => 'icon',
				'title' => esc_html__('Coming-soon Page', 'inforward'),
				'fields' => array(
					array(
						'id' => 'coming-soon-copyright',
						'type' => 'textarea',
						'title' => esc_html__('Error text', 'inforward'),
						'validate' => 'html_custom',
						'default' => "<div class='paid-by'>Paid for by Friends of Adam Russell</div>
                <p>Copyright © 2017 Adam Russell for Congress. <br> All Rights Reserved.</p>",
					),
					 array(
						'id' => "coming-soon-donate-url",
						'type' => 'text',
						'title' => esc_html__('Donate URL', 'inforward'),
						'default' => ''
					),
					array(
							'id' => 'coming-soon-social',
							'type' => 'switch',
							'title' => esc_html__('Show Social Links', 'inforward'),
							'default' => false,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
						'id' => "coming-soon-social-linkedin",
						'type' => 'text',
						'title' => esc_html__('LinkedIn', 'inforward'),
						'required' => array('coming-soon-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "coming-soon-social-tumblr",
						'type' => 'text',
						'title' => esc_html__('Tumblr', 'inforward'),
						'required' => array('coming-soon-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "coming-soon-social-vimeo",
						'type' => 'text',
						'title' => esc_html__('Vimeo', 'inforward'),
						'required' => array('coming-soon-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "coming-soon-social-youtube",
						'type' => 'text',
						'title' => esc_html__('Youtube', 'inforward'),
						'required' => array('coming-soon-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "coming-soon-social-facebook",
						'type' => 'text',
						'title' => esc_html__('Facebook', 'inforward'),
						'required' => array('coming-soon-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "coming-soon-social-twitter",
						'type' => 'text',
						'title' => esc_html__('Twitter', 'inforward'),
						'required' => array('coming-soon-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "coming-soon-social-instagram",
						'type' => 'text',
						'title' => esc_html__('Instagram', 'inforward'),
						'required' => array('coming-soon-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "coming-soon-social-flickr",
						'type' => 'text',
						'title' => esc_html__('Flickr', 'inforward'),
						'required' => array('coming-soon-social','equals',true),
						'default' => '#'
					),
				)
			);

			// landing
			$this->sections[] = array(
				'icon' => 'el-icon-error',
				'icon_class' => 'icon',
				'title' => esc_html__('Landing Page', 'inforward'),
				'fields' => array(
					array(
						'id' => 'landing-copyright',
						'type' => 'textarea',
						'title' => esc_html__('Copyright text', 'inforward'),
						'validate' => 'html_custom',
						'default' => "<div class='paid-by'>Paid for by Friends of Adam Russell</div>
                <p>Copyright © 2018 Adam Russell for Congress. <br> All Rights Reserved.</p>",
					),
					 array(
						'id' => "landing-social-text",
						'type' => 'text',
						'title' => esc_html__('Social text', 'inforward'),
						'default' => ''
					),
					array(
							'id' => 'landing-social',
							'type' => 'switch',
							'title' => esc_html__('Show Social Links', 'inforward'),
							'default' => false,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
						'id' => "landing-social-linkedin",
						'type' => 'text',
						'title' => esc_html__('LinkedIn', 'inforward'),
						'required' => array('landing-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "landing-social-tumblr",
						'type' => 'text',
						'title' => esc_html__('Tumblr', 'inforward'),
						'required' => array('landing-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "landing-social-vimeo",
						'type' => 'text',
						'title' => esc_html__('Vimeo', 'inforward'),
						'required' => array('landing-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "landing-social-youtube",
						'type' => 'text',
						'title' => esc_html__('Youtube', 'inforward'),
						'required' => array('landing-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "landing-social-facebook",
						'type' => 'text',
						'title' => esc_html__('Facebook', 'inforward'),
						'required' => array('landing-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "landing-social-twitter",
						'type' => 'text',
						'title' => esc_html__('Twitter', 'inforward'),
						'required' => array('landing-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "landing-social-instagram",
						'type' => 'text',
						'title' => esc_html__('Instagram', 'inforward'),
						'required' => array('landing-social','equals',true),
						'default' => '#'
					),
					array(
						'id' => "landing-social-flickr",
						'type' => 'text',
						'title' => esc_html__('Flickr', 'inforward'),
						'required' => array('landing-social','equals',true),
						'default' => '#'
					),
				)
			);


			if ( class_exists( 'Inforward_Portfolio_Config' ) ) {
			
				// Portfolio
				$this->sections[] = array(
					'icon' => 'el-icon-gallery',
					'icon_class' => 'icon',
					'title' => esc_html__('Portfolio', 'inforward'),
					'fields' => array(
						array(
							'id' => 'portfolio-related',
							'type' => 'switch',
							'title' => esc_html__('Show "Related" on single portfolio', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => "portfolio-link",
							'type' => 'text',
							'title' => esc_html__('Link to portfolio', 'inforward'),
							'default' => ''
						),
						array(
							'id' => 'portfolio-single-share',
							'type' => 'switch',
							'title' => esc_html__('Show Social Links', 'inforward'),
							'default' => false,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'portfolio-nav',
							'type' => 'switch',
							'title' => esc_html__('Prev/Next Navigation', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
					)
				);
			
			}


			if ( class_exists( 'WooCommerce' ) ) {

				// Shop
				$this->sections[] = array(
					'icon' => 'el-icon-shopping-cart',
					'icon_class' => 'icon',
					'title' => esc_html__('Shop', 'inforward'),
					'fields' => array(
						array(
							'id' => '1',
							'type' => 'info',
							'title' => esc_html__('Label Status', 'inforward'),
							'notice' => false
						),
						array(
							'id' => 'product-stock',
							'type' => 'switch',
							'title' => esc_html__('Show "Out of stock" Status', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-featured',
							'type' => 'switch',
							'title' => esc_html__('Show "Featured" Status', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-sale',
							'type' => 'switch',
							'title' => esc_html__('Show "Sale" Status', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-sale-percent',
							'type' => 'switch',
							'title' => esc_html__('Show saved sale price percentage', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
							'required' => array( 'product-sale', 'equals', true ),
						),
						array(
							'id' => 'product-new',
							'type' => 'switch',
							'title' => esc_html__('Show "New" Status', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward')
						),
					)
				);
				
				$this->sections[] = array(
					'icon_class' => 'icon',
					'subsection' => true,
					'title' => esc_html__('Product Archives', 'inforward'),
					'fields' => array(
						array(
							'id' => 'product-archive-layout',
							'type' => 'image_select',
							'title' => esc_html__('Page Layout', 'inforward'),
							'options' => $page_layouts,
							'default' => 'cp-right-sidebar'
						),
						array(
							'id' => 'product-sidebar',
							'type' => 'select',
							'title' => esc_html__('Select Sidebar', 'inforward'),
							'required' => array('product-archive-layout', 'equals', $sidebars),
							'data' => 'sidebars',
							'default' => 'shop-widget-area'
						),
						array(
							'id' => 'shop-archive-footer-sidebar',
							'type' => 'select',
							'title' => esc_html__('Get widgets for footer from page', 'inforward'),
							'data' => 'page',
							'default' => ''
						),
						array(
							'id' => 'shop-count-item',
							'type' => 'text',
							'title' => esc_html__('Products per Page', 'inforward'),
							'desc' => esc_html__('Product counts.', 'inforward'),
							'default' => '12'
						),
						array(
							'id' => 'shop-product-cols',
							'type' => 'button_set',
							'title' => esc_html__('Shop Page Product Columns', 'inforward'),
							'options' => inforward_product_columns(),
							'default' => '3',
						),
						array(
							'id' => 'category-product-cols',
							'type' => 'button_set',
							'title' => esc_html__('Category Product Columns', 'inforward'),
							'options' => inforward_product_columns(),
							'default' => '3',
						),
						array(
							'id' => 'shop-count-item-category',
							'type' => 'text',
							'title' => esc_html__('Category Products per Page', 'inforward'),
							'desc' => esc_html__('Product counts.', 'inforward'),
							'default' => '12'
						),
					)
				);
				
				$this->sections[] = array(
					'icon_class' => 'icon',
					'subsection' => true,
					'title' => esc_html__('Single Product', 'inforward'),
					'fields' => array(
						array(
							'id' => 'product-single-layout',
							'type' => 'image_select',
							'title' => esc_html__('Single Layout', 'inforward'),
							'options' => $page_layouts,
							'default' => 'cp-right-sidebar'
						),
						array(
							'id' => 'product-single-sidebar',
							'type' => 'select',
							'title' => esc_html__('Select Sidebar', 'inforward'),
							'required' => array('product-single-layout', 'equals', $sidebars),
							'data' => 'sidebars',
							'default' => 'shop-widget-area'
						),
						array(
							'id' => 'shop-single-footer-sidebar',
							'type' => 'select',
							'title' => esc_html__('Get widgets for footer from page', 'inforward'),
							'data' => 'page',
							'default' => ''
						),
						array(
							'id' => 'product-short-description',
							'type' => 'switch',
							'title' => esc_html__('Show Short Description', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-metas',
							'type' => 'button_set',
							'title' => esc_html__('Product Meta', 'inforward'),
							'multi' => true,
							'options' => array(
								'tags' => esc_html__('Tags', 'inforward'),
								'cats' => esc_html__('Categories', 'inforward'),
								'-' => esc_html__('None', 'inforward'),
							),
							'default' => array('tags', '-')
						),
						array(
							'id' => 'product-related',
							'type' => 'switch',
							'title' => esc_html__('Show Related Products', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-related-count',
							'type' => 'text',
							'required' => array('product-related', 'equals', true),
							'title' => esc_html__('Related Count items', 'inforward'),
							'default' => '3'
						),
						array(
							'id' => 'product-upsells',
							'type' => 'switch',
							'title' => esc_html__('Show Up-Sells', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-upsells-count',
							'type' => 'text',
							'required' => array('product-upsells', 'equals', true),
							'title' => esc_html__('Up-Sells Columns', 'inforward'),
							'default' => '3'
						),
						array(
							'id' => '1',
							'type' => 'info',
							'title' => esc_html__('Social Links', 'inforward'),
							'notice' => false
						),
						array(
							'id' => 'product-single-share',
							'type' => 'switch',
							'title' => esc_html__('Show Social Links', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-share-facebook',
							'type' => 'switch',
							'title' => esc_html__('Enable Facebook Share', 'inforward'),
							'required' => array('product-single-share', 'equals', true),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-share-twitter',
							'type' => 'switch',
							'title' => esc_html__('Enable Twitter Share', 'inforward'),
							'required' => array('product-single-share', 'equals', true),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-share-googleplus',
							'type' => 'switch',
							'title' => esc_html__('Enable Google Plus Share', 'inforward'),
							'required' => array('product-single-share', 'equals', true),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-share-pinterest',
							'type' => 'switch',
							'title' => esc_html__('Enable Pinterest Share', 'inforward'),
							'required' => array('product-single-share', 'equals', true),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-share-email',
							'type' => 'switch',
							'title' => esc_html__('Enable Email Share', 'inforward'),
							'required' => array('product-single-share', 'equals', true),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						)
					)
				);
				
				$this->sections[] = array(
					'icon_class' => 'icon',
					'subsection' => true,
					'title' => esc_html__('Cart', 'inforward'),
					'fields' => array(
						array(
							'id' => 'product-crossell',
							'type' => 'switch',
							'title' => esc_html__('Show Cross-Sells', 'inforward'),
							'default' => true,
							'on' => esc_html__('Yes', 'inforward'),
							'off' => esc_html__('No', 'inforward'),
						),
						array(
							'id' => 'product-crossell-count',
							'type' => 'text',
							'required' => array('product-crossell', 'equals', true),
							'title' => esc_html__('Cross Sells Columns', 'inforward'),
							'default' => '2'
						),
					)
				);
				
			}
			
			
		// Events
		if ( class_exists( 'Tribe__Events__Main' ) ) {
			$this->sections[] = array(
				'icon' => 'el-icon-file',
				'icon_class' => 'icon',
				'title' => esc_html__('Events', 'inforward'),
				'fields' => array(
				array(
						'id' => 'events-footer-sidebar',
						'type' => 'select',
						'title' => esc_html__('Get widgets for footer from page', 'inforward'),
						'data' => 'page',
						'default' => ''
					),
				)
			);
		}
		
		// Issues
		if ( class_exists( 'Inforward_Issues_Config' ) ) {
			$this->sections[] = array(
				'icon' => 'el-icon-file',
				'icon_class' => 'icon',
				'title' => esc_html__('Issues', 'inforward'),
				'fields' => array(
				array(
						'id' => 'issues-footer-sidebar',
						'type' => 'select',
						'title' => esc_html__('Get widgets for footer from page', 'inforward'),
						'data' => 'page',
						'default' => ''
					),
				)
			);
		}
			
			// Google
			$this->sections[] = array(
				'icon' => 'el-googleplus',
				'icon_class' => 'el',
				'title' => esc_html__('Google', 'inforward'),
				'fields' => array(
					array(
						'id' => '1',
						'type' => 'info',
						'style' => 'normal',
						'title' => esc_html__('Google recently changed the way their map service works. New pages which want to use Google Maps need to register an API key for their website. Older pages should  work fine without this API key. If the google map elements of this theme do not work properly you need to register a new API key.', 'inforward'),
						'notice' => false
					),
					array(
						'id' => 'gmap-api',
						'type' => 'textarea',
						'title' => esc_html__('Google Maps API Key', 'inforward'),
						'desc' => esc_html__('Enter a valid Google Maps API Key to use all map related theme functions.', 'inforward'),
						'default' => ''
					),
				)
			);

		}

		public function setArguments() {

			$theme = $this->theme;

			$this->args = array(
				'opt_name'          => 'inforward_settings',
				'display_name'      => $theme->get('Name') . ' ' . esc_html__('Theme Options', 'inforward'),
				'display_version'   => esc_html__('Theme Version: ', 'inforward') . strtolower($theme->get('Version')),
				'menu_type'         => 'submenu',
				'allow_sub_menu'    => true,
				'menu_title'        => esc_html__('Theme Options', 'inforward'),
				'page_title'        => esc_html__('Theme Options', 'inforward'),
				'footer_credit'     => esc_html__('Theme Options', 'inforward'),

				'google_api_key' => 'AIzaSyBQft4vTUGW75YPU6c0xOMwLKhxCEJDPwg',
				'disable_google_fonts_link' => true,

				'async_typography'  => false,
				'admin_bar'         => false,
				'admin_bar_icon'       => 'dashicons-admin-generic',
				'admin_bar_priority'   => 50,
				'global_variable'   => '',
				'dev_mode'          => false,
				'customizer'        => false,
				'compiler'          => false,

				'page_priority'     => null,
				'page_parent'       => 'themes.php',
				'page_permissions'  => 'manage_options',
				'menu_icon'         => '',
				'last_tab'          => '',
				'page_icon'         => 'icon-themes',
				'page_slug'         => 'inforward_settings',
				'save_defaults'     => true,
				'default_show'      => false,
				'default_mark'      => '',
				'show_import_export' => true,
				'show_options_object' => false,

				'transient_time'    => 60 * MINUTE_IN_SECONDS,
				'output'            => false,
				'output_tag'        => false,

				'database'              => '',
				'system_info'           => false,

				'hints' => array(
					'icon'          => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color'    => 'lightgray',
					'icon_size'     => 'normal',
					'tip_style'     => array(
						'color'         => 'light',
						'shadow'        => true,
						'rounded'       => false,
						'style'         => '',
					),
					'tip_position'  => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'    => array(
						'show'          => array(
							'effect'        => 'slide',
							'duration'      => '500',
							'event'         => 'mouseover',
						),
						'hide'      => array(
							'effect'    => 'slide',
							'duration'  => '500',
							'event'     => 'click mouseleave',
						),
					),
				),
				'ajax_save'                 => false,
				'use_cdn'                   => true,
			);

		}

	}

	global $inforward_redux_settings;
	$inforward_redux_settings = new inforward_redux_settings();

}