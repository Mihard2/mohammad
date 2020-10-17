<?php
if (!class_exists('inforward_info_block')) {

	class inforward_info_block {

		function __construct() {
			add_action('vc_before_init', array($this, 'add_map'));
		}

		function add_map() {

			if ( function_exists('vc_map') ) {

				vc_map(
					array(
					   "name" => esc_html__("Infoblock(Icon Boxes)", 'inforward' ),
					   "base" => "vc_mad_info_block",
					   "class" => "vc_mad_info_block",
					   "icon" => "icon-wpb-mad-info-block",
					   "category"  => esc_html__('Inforward', 'inforward'),
					   "description" => esc_html__('Styled info blocks', 'inforward'),
					   "as_parent" => array('only' => 'vc_mad_info_block_item'),
					   "content_element" => true,
					   "show_settings_on_create" => false,
					   "params" => array(
						   array(
							   'type' => 'textfield',
							   'heading' => esc_html__( 'Title', 'inforward' ),
							   'param_name' => 'title',
							   'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
				 			   'edit_field_class' => 'vc_col-sm-6'
						   ),
						   array(
							   'type' => 'dropdown',
							   'heading' => esc_html__( 'Tag for title', 'inforward' ),
							   'param_name' => 'tag_title',
							   'value' => array(
								   'h2' => 'h2',
								   'h3' => 'h3'
							   ),
							   'std' => '',
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
							   "type" => "vc_link",
							   "heading" => esc_html__( 'Add URL to the info box (optional)', 'inforward' ),
							   "param_name" => "link",
						   ),
						   array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for title', 'inforward' ),
							   'param_name' => 'title_color',
							   'group' => esc_html__( 'Styling', 'inforward' ),
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Select custom color for title block.', 'inforward' ),
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
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for description', 'inforward' ),
							   'param_name' => 'description_color',
							   'group' => esc_html__( 'Styling', 'inforward' ),
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Select custom color for description block.', 'inforward' ),
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
							   "type" => "dropdown",
							   "heading" => esc_html__( 'Select type', 'inforward' ),
							   "param_name" => "type",
							   "value" => array(
								   esc_html__('Type 1', 'inforward') => 'type-1',
								   esc_html__('Type 2', 'inforward') => 'type-2',
								   esc_html__('Type 3', 'inforward') => 'iconbox-type-3 type-2 style-2'
							   ),
							   "std" => 'type-1',
							   "description" => esc_html__( 'Choose type for this info block.', 'inforward' )
						   ),
						   array(
							   'type' => 'dropdown',
							   'heading' => esc_html__( 'Columns', 'inforward' ),
							   'param_name' => 'columns',
							   'value' => array(
								   esc_html__( '1 Columns', 'inforward' ) => 1,
								   esc_html__( '2 Columns', 'inforward' ) => 2,
								   esc_html__( '3 Columns', 'inforward' ) => 3,
								   esc_html__( '4 Columns', 'inforward' ) => 4
							   ),
							   'std' => 1,
							   'description' => esc_html__( 'How many columns should be displayed?', 'inforward' )
						   )						),
						"js_view" => 'VcColumnView'
					));

				vc_map(
					array(
					   "name" => esc_html__("Info Block Item", 'inforward'),
					   "base" => "vc_mad_info_block_item",
					   "class" => "vc_mad_info_block_item",
					   "icon" => "icon-wpb-mad-info-block",
					   "category" => esc_html__('Infoblock', 'inforward'),
					   "content_element" => true,
					   "as_child" => array('only' => 'vc_mad_info_block'),
					   "is_container" => true,
					   "params" => array(
						   array(
							   "type" => "textarea",
							   "heading" => esc_html__( 'Title', 'inforward' ),
							   "param_name" => "title",
							   "holder" => "h4",
							   "description" => ''
						   ),
						    array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for icon item', 'inforward' ),
							   'param_name' => 'icon_color',
							   'group' => esc_html__( 'Styling', 'inforward' ),
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Select custom color for icon.', 'inforward' ),
						   ),
						   array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for title item', 'inforward' ),
							   'param_name' => 'title_item_color',
							   'group' => esc_html__( 'Styling', 'inforward' ),
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Select custom color for title item.', 'inforward' ),
						   ),
						    array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for button item', 'inforward' ),
							   'param_name' => 'btn_color',
							   'group' => esc_html__( 'Styling', 'inforward' ),
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Select custom color for button item.', 'inforward' ),
						   ),
						   array(
							   "type" => "choose_icons",
							   "heading" => esc_html__("Icon", 'inforward'),
							   "param_name" => "icon",
							   "value" => 'none',
							   "description" => esc_html__( 'Select icon from library.', 'inforward')
						   ),
						    array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Icon Number', 'inforward' ),
							   "param_name" => "icon_number",
							   "holder" => "h4",
							   "description" => ''
						   ),
						    array(
							   "type" => "vc_link",
							   "heading" => esc_html__( 'Add URL to the info block (optional)', 'inforward' ),
							   "param_name" => "link",
						   ),
						   array(
							   'type' => 'textarea_html',
							   'holder' => 'div',
							   'heading' => esc_html__( 'Text', 'inforward' ),
							   'param_name' => 'content',
							   'value' => wp_kses(__( '<p>Click edit button to change this text.</p>', 'inforward' ), array('p' => array()) )
						   ),
						   inforward_vc_map_add_css_animation(),
						   inforward_vc_map_add_animation_delay(),
						   inforward_vc_map_add_scroll_factor()
					    )
					) 
				);							

			}
		}

	}

	if (class_exists('WPBakeryShortCodesContainer')) {

		class WPBakeryShortCode_vc_mad_info_block extends WPBakeryShortCodesContainer {

			protected function content($atts, $content = null) {

				$title = $tag_title = $description = $title_color = $description_color = $type = $columns = $columns_class = '';

				extract(shortcode_atts(array(
					'title' => '',
					'tag_title' => 'h3',
					'description' => '',
					'link' => '',
					'title_color' => '',
					'description_color' => '',
					'title_align' => '',
					'description_align' => '',
					'type' => 'type-1',
					'columns' => 1
				), $atts));

				if( $columns>1 ) {
					$columns_class = 'icons-box-col-' . absint($columns);
				}

				$css_class = array(
					'icons-box', 'row flex-row', $type, $columns_class
				);

				$link = ($link == '||') ? '' : $link;
				$link = vc_build_link($link);
				$a_href = $link['url'];
				$a_title = $link['title'];
				( $link['target'] != '' ) ? $a_target = $link['target'] : $a_target = '_self';
				
				global $vc_mad_info_block_args;

				$vc_mad_info_block_args[] = array (
					'title_color' => $title_color,
					'type' => $type,
					'columns' => $columns,
					'description_color' => $description_color,
					'content' => $content
				);

				ob_start(); ?>

				<div class="wpb_content_element cp-infoblock">

					<?php
					echo Inforward_Vc_Config::getParamTitle(
						array(
							'title' => $title,
							'tag_title' => $tag_title,
							'description' => $description,
							'title_color' => $title_color,
							'description_color' => $description_color,
							'align' => $title_align,
							'align_des' => $description_align,
						)
					);
					?>

					<div class="<?php echo esc_attr( implode(' ', $css_class) ); ?>">
	
						<?php echo wpb_js_remove_wpautop ($content, false ) ?>
						
					</div>
					
					<?php if ( !empty($a_title) ): ?>
					<a href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title) ?>" target="<?php echo esc_attr($a_target) ?>" class="btn type-2 btn-style-6 btn-size"><?php echo esc_html($a_title); ?></a>
					<?php endif; ?>

				</div>

				<?php return ob_get_clean() ;

			}

		}

		class WPBakeryShortCode_vc_mad_info_block_item extends WPBakeryShortCode {

			protected function content($atts, $content = null) {

				$wrapper_attributes = array();
				$title = $style = $type = $title_item_color = $icon_color = $btn_color = $icon = $css_animation = $animation_delay = $scroll_factor = $link = '';

				extract(shortcode_atts(array(
					'title' => '',
					'icon' => '',
					'link' => '',
					'title_color' => '',
					'icon_color' => '',
					'title_item_color' => '',
					'btn_color' => '',
					'icon_number' => '',
					'css_animation' => '',
					'animation_delay' => '',
					'scroll_factor' => ''
				),$atts));

				$link = ($link == '||') ? '' : $link;
				$link = vc_build_link($link);
				$a_href = $link['url'];
				$a_title = $link['title'];
				( $link['target'] != '' ) ? $a_target = $link['target'] : $a_target = '_self';
				
				$css_classes = array(
					'cp-infoblock-item', 'icons-wrap'
				);

				if ( $content == null )
					$content = ' ';

				$title_color = '';
				$columns = 1;

				global $vc_mad_info_block_args;

				if ( isset($vc_mad_info_block_args) && is_array($vc_mad_info_block_args) ) {
					foreach ( $vc_mad_info_block_args as $info_block ) {

						if ( strpos( $info_block['content'], $content ) == true ) {
							if ( isset($info_block['title_color']) && !empty($info_block['title_color']) ) {
								$title_color = 'style="' . vc_get_css_color( 'color', $info_block['title_color'] ) . '"';
							}	
						}

					}
				}

				switch ( $info_block['columns'] ) {
						case '2':
						$css_classes[] = 'col-md-6 col-xs-6';
						break;
						
						case '3':
						$css_classes[] = 'col-md-4 col-xs-6';
						break;
						
						case '4':
						$css_classes[] = 'col-md-3 col-xs-6';
						break;
						
					}
				
				if ( isset($icon_color) && !empty($icon_color) ) {
					$icon_color = 'style="' . vc_get_css_color( 'color', $icon_color ) . '"';
				}
							
				if ( isset($title_item_color) && !empty($title_item_color) ) {
					$title_item_color = 'style="' . vc_get_css_color( 'color', $title_item_color ) . '"';
				}
							
				if ( isset($btn_color) && !empty($btn_color) ) {
					$btn_color = 'style="' . vc_get_css_color( 'color', $btn_color ) . '"';
				}

				if ( '' !== $css_animation  ) {
					$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, $animation_delay, $scroll_factor );
				}

				$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
				$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

				ob_start(); ?>

				
				<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				
					<div class="icons-item">
					<div class="item-box">

						<?php if ( $icon != '' && $info_block['type'] != 'iconbox-type-3 type-2 style-2' ): ?>

							<i class="<?php echo esc_attr($icon) ?>"  <?php echo sprintf('%s', $icon_color) ?> ></i>
							
						<?php endif; ?>
                        
                        <?php if ( $info_block['type'] == 'iconbox-type-3 type-2 style-2' ): ?>
                       <i class="number"><?php echo esc_attr($icon_number) ?></i>
                        <?php endif; ?>

						<?php 
						if ( !empty($title) ): 
						?>
							<h5 class="icons-box-title" <?php echo sprintf('%s', $title_item_color) ?>>
								<?php if ( !empty($a_href) ): ?>
									<a href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title) ?>" <?php echo sprintf('%s', $title_item_color) ?> target="<?php echo esc_attr($a_target) ?>" >
								<?php endif; ?>
									<?php echo wpautop($title); ?>
								<?php if ( !empty($a_href) ): ?>
									</a>
								<?php endif; ?>	
							</h5>
						<?php endif; ?>

						<?php if ( !empty($content) ): ?>
							
								<?php if ( !empty($a_href) ): ?>
									<a href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title) ?>" <?php echo sprintf('%s', $title_item_color) ?> target="<?php echo esc_attr($a_target) ?>" >
								<?php endif; ?>
								
							<?php echo wpb_js_remove_wpautop( $content, true ) ?>
							
								<?php if ( !empty($a_href) ): ?>
									</a>
								<?php endif; ?>	
							
						<?php endif; ?>
						
						<?php if ( !empty($a_title) ): ?>
							<a href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title) ?>" target="<?php echo esc_attr($a_target) ?>" class="info-btn" <?php echo sprintf('%s', $btn_color) ?> ><?php echo esc_html($a_title); ?></a>
						<?php endif; ?>

					</div>
					</div>

				</div>

				<?php return ob_get_clean();
			}

		}

	}

	new inforward_info_block();
}