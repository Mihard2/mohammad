<?php
if ( !class_exists('inforward_pricing_box') ) {

	class inforward_pricing_box {

		function __construct() {
			add_action('vc_before_init', array($this, 'add_map_pricing_box'));
		}
		
		function add_map_pricing_box() {

			if ( function_exists('vc_map') ) {

				vc_map(
					array(
					   "name" => esc_html__("Pricing Box", 'inforward' ),
					   "base" => "vc_mad_pricing_box",
					   "class" => "vc_mad_pricing_box",
					   "icon" => "icon-wpb-mad-pricing-box",
					   "category"  => esc_html__('Inforward', 'inforward'),
					   "description" => esc_html__('Styled pricing tables', 'inforward'),
					   "as_parent" => array('only' => 'vc_mad_pricing_box_item'),
					   "content_element" => true,
					   "show_settings_on_create" => true,
					   "params" => array(
						   array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Title', 'inforward' ),
								'param_name' => 'title',
								'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
								'edit_field_class' => 'vc_col-sm-6',
						   ),
						   array(
							   'type' => 'dropdown',
							   'heading' => esc_html__( 'Tag for title', 'inforward' ),
							   'param_name' => 'tag_title',
							   'value' => array(
								   'h2' => 'h2',
								   'h3' => 'h3'
							   ),
							   'std' => 'h2',
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Choose tag for title.', 'inforward' )
						   ),
						   array(
							   'type' => 'textarea',
							   'heading' => esc_html__( 'Description', 'inforward' ),
							   'param_name' => 'description',
							   'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
						   ),
						   array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for title', 'inforward' ),
							   'param_name' => 'title_color',
							   'group' => esc_html__( 'Styling', 'inforward' ),
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
						   ),
						   array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for description', 'inforward' ),
							   'param_name' => 'description_color',
							   'group' => esc_html__( 'Styling', 'inforward' ),
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Select custom color for description.', 'inforward' ),
						   ),
						   array(
								"type" => "dropdown",
								"class" => "",
								"heading" => esc_html__("Title align", 'inforward'),
								"param_name" => "title_align",
								'group' => esc_html__( 'Styling', 'inforward' ),
								"value" => array(
									esc_html__("Left",'inforward') => "align-left",
									esc_html__("Right",'inforward') => "align-right",
									esc_html__("Center",'inforward') => "align-center"
								)
							),
							array(
								"type" => "dropdown",
								"class" => "",
								"heading" => esc_html__("Description align", 'inforward'),
								"param_name" => "description_align",
								'group' => esc_html__( 'Styling', 'inforward' ),
								"value" => array(
									esc_html__("Left",'inforward') => "align-left",
									esc_html__("Right",'inforward') => "align-right",
									esc_html__("Center",'inforward') => "align-center"
								)
							),
						   array(
							   "type" => "vc_link",
							   "heading" => esc_html__( 'Add URL to the whole box (optional)', 'inforward' ),
							   "param_name" => "link",
						   ),
						   array(
							   'type' => 'dropdown',
							   'heading' => esc_html__( 'Columns', 'inforward' ),
							   'param_name' => 'columns',
							   'value' => array(
								   esc_html__( '3 Columns', 'inforward' ) => 3,
								   esc_html__( '4 Columns', 'inforward' ) => 4,
							   ),
							   'std' => 3,
							   'description' => esc_html__( 'How many columns should be displayed?', 'inforward' )
						   )
						),
						"js_view" => 'VcColumnView'
					));

				vc_map(
					array(
					   "name" => esc_html__("Pricing Box Item", 'inforward'),
					   "base" => "vc_mad_pricing_box_item",
					   "class" => "vc_mad_pricing_box_item",
					   "icon" => "icon-wpb-mad-pricing-box",
					   "category" => esc_html__('Pricing Box', 'inforward'),
					   "content_element" => true,
					   "as_child" => array('only' => 'vc_mad_pricing_box'),
					   "is_container" => false,
					   "params" => array(
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Package Name / Title', 'inforward' ),
							   "param_name" => "title",
							   "holder" => "h4",
							   "description" => esc_html__( 'Enter the package name or table heading.', 'inforward' ),
							   "value" => '',
						   ),
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Label', 'inforward' ),
							   "param_name" => "label",
							   "holder" => "h4",
							   "description" => esc_html__( 'Enter the table label.', 'inforward' ),
							   "value" => '',
						   ),
						   array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for label /  price', 'inforward' ),
							   'param_name' => 'label_color',
							   'group' => esc_html__( 'Styling', 'inforward' ),
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Select custom color for label.', 'inforward' ),
						   ),
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Package Price', 'inforward' ),
							   "param_name" => "price",
							   "holder" => "span",
							   "description" => esc_html__( 'Enter the price for this package', 'inforward' ),
							   "value" => ''
						   ),
						   array(
							   "type" => "textarea",
							   "heading" => esc_html__( 'Features', 'inforward' ),
							   "param_name" => "features",
							   "holder" => "span",
							   "description" => esc_html__( 'Create the features list using un-ordered list elements. Divide values with linebreaks (Enter). Example: Up to 50 users|Limited team members', 'inforward' ),
							   "value" => esc_html__('1 user | No VPN access | 2 Gb allowed', 'inforward')
						   ),
						   array(
							   "type" => "vc_link",
							   "heading" => esc_html__( 'Add URL to the whole box (optional)', 'inforward' ),
							   "param_name" => "link",
						   ),
						   array(
							   'type' => 'checkbox',
							   'heading' => esc_html__( 'Featured', 'inforward' ),
							   'param_name' => 'add_label',
							   'description' => esc_html__( 'Adds a nice label to your pricing box.', 'inforward' ),
							   'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
						   ),
						   inforward_vc_map_add_css_animation(false),
						   inforward_vc_map_add_animation_delay(),
						   inforward_vc_map_add_scroll_factor()
					    )
					)
				);

			}
		}

	}

	if ( class_exists('WPBakeryShortCodesContainer') ) {

		class WPBakeryShortCode_vc_mad_pricing_box extends WPBakeryShortCodesContainer {

			protected function content($atts, $content = null) {

				$title = $tag_title = $description = $title_color = $description_color = $layout = $columns = '';

				extract(shortcode_atts(array(
					'title' => '',
					'tag_title' => 'h2',
					'description' => '',
					'title_color' => '',
					'description_color' => '',
					'title_align' => '',
					'description_align' => '',
					'link' => '',
					'columns' => 3
				), $atts));

				$css_class = array(
					'pricing-tables-holder',
					'cols-' . absint($columns)
				);
				
				$link = ($link == '||') ? '' : $link;
				$link = vc_build_link($link);
				$a_href = $link['url'];
				$a_title = $link['title'];
				( $link['target'] != '' ) ? $a_target = $link['target'] : $a_target = '_self';

				$title_align = !empty($title_align) ? $title_align : '';
				$description_align = !empty($description_align) ? $description_align : '';
		
				ob_start(); ?>

				<div class="wpb_content_element cp-pricing-tables">

					<?php
					echo Inforward_Vc_Config::getParamTitle(
						array(
							'title' => $title,
							'tag_title' => $tag_title,
							'description' => $description,
							'title_color' => $title_color,
							'align' => $title_align,
							'align_des' => $description_align,
							'description_color' => $description_color,
						)
					);
					?>

					<div class="<?php echo esc_attr(implode(' ', $css_class)); ?>">
						<?php echo wpb_js_remove_wpautop( $content, false ) ?>
					</div>

					<?php if ( !empty($a_title) ): ?>
					<div class="align-center">
						<a href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title) ?>" target="<?php echo esc_attr($a_target) ?>" class="btn btn-size type-2 btn-style-6" ><?php echo esc_html($a_title); ?></a>
					</div>
					<?php endif; ?>

				</div>

				<?php return ob_get_clean() ;
			}

		}

		class WPBakeryShortCode_vc_mad_pricing_box_item extends WPBakeryShortCode {

			protected function content($atts, $content = null) {
				$title = $price = $features = $add_label = $link = $label_color_bg = "";

				extract( shortcode_atts(array(
					'title' => esc_html__('Free', 'inforward'),
					'price' => '',
					'label' => '',
					'label_color' => '',
					'features' => '',
					'link' => '',
					'add_label' => false,
					'css_animation' => '',
					'animation_delay' => 0,
					'scroll_factor' => ''
				),$atts) );

				$link = ($link == '||') ? '' : $link;
				$link = vc_build_link($link);
				$a_href = $link['url'];
				$a_title = $link['title'];
				( $link['target'] != '' ) ? $a_target = $link['target'] : $a_target = '_self';

				$wrapper_attributes = array();
				$css_classes = array( 'pricing-table' );
				
				if ( $add_label ){
					$css_classes[] = 'selected';
				}

				if ( '' !== $css_animation  ) {
					$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, $animation_delay, $scroll_factor );
				}

				$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
				$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

				ob_start(); ?>
				
				<?php  if ( isset($label_color) && !empty($label_color) ) {
					$label_color_opacity = Inforward_Helper::hex2rgba( $label_color, '0.35' );
					
					$label_color_bg = 'style="' . vc_get_css_color( 'background', $label_color ) . 'box-shadow:0px 5px 25px 0px '. $label_color_opacity .'"';
					$label_color = 'style="' . vc_get_css_color( 'color', $label_color ) . '"';
				} 
				?>

				<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

					<?php if ( $add_label ): ?>
						<div class="label"><?php echo esc_html__('RECOMMENDED', 'inforward') ?></div>
					<?php endif; ?>

					<header class="pt-header">

						<div class="pt-type"><?php echo esc_html($title); ?></div>
						<div class="pt-price" <?php echo sprintf('%s', $label_color) ?> ><?php echo esc_html($price); ?></div>
						<div class="pt-period" <?php echo sprintf('%s', $label_color) ?> ><?php echo esc_html($label); ?></div>
                        
					</header>

					<ul class="pt-features-list">
						<?php
						$features = explode( '|', wp_strip_all_tags($features) );
						$feature_list = '';
						if ( is_array($features) ) {
							foreach ( $features as $feature ) {
								$feature_list .= "<li>{$feature}</li>";
							}
						}
						?>
						<?php echo wp_kses( $feature_list, array(
							'a' => array(
								'href' => true,
								'title' => true,
							),
							'li' => array()
						)); ?>
					</ul><!--/ .cp-features-list -->

					<?php if ( !empty($a_title) ): ?>

						<footer class="pt-footer">
							<a href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title) ?>" target="<?php echo esc_attr($a_target) ?>" class="cp-pricing-button btn btn-style-6" <?php echo sprintf('%s', $label_color_bg) ?>><?php echo esc_html($a_title); ?></a>
						</footer><!--/ .cp-pt-footer -->

					<?php endif; ?>

				</div>

				<?php return ob_get_clean() ;
			}

		}
	}

	new inforward_pricing_box();

}