<?php

class WPBakeryShortCode_VC_mad_action_list extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'values' => '',
			'type' => 'style-1',
			'columns' => 'action-col-4'
		), $atts, 'vc_mad_action_list');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$title = $values = $bg_color = $bg_color_hover = $icon_color = $item_title_color =  '';
		extract($this->atts);
		$values = (array) vc_param_group_parse_atts( $values );

		ob_start(); ?>

		<!-- - - - - - - - - - - - - - Counter - - - - - - - - - - - - - - - - -->

		<?php if ( !empty($values) ): ?>

			<div class="wpb_content_element cp_action_list">

			<?php
			echo Inforward_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'tag_title' => 'h2',
					'description' => '',
					'title_color' => '',
					'description_color' => '',
				)
			);
			?>

				
				<div class="action-widget <?php echo esc_attr($type) ?> <?php echo esc_attr($columns) ?>">

					<?php foreach( $values as $value ): 
					
						$custom_links = ( '||' === $value['link'] ) ? '' : $value['link'];
						$custom_links = vc_build_link( $value['link'] );
						$use_link = false;
						if ( strlen( $custom_links['url'] ) > 0 ) {
							$use_link = true;
							$a_href = $custom_links['url'];
							$a_title = $custom_links['title'];
							$a_target = $custom_links['target'];
							$a_rel = $custom_links['rel'];
						}
						
						if ( isset($value['bg_color']) && !empty($value['bg_color']) ) {
							
							$btn_color_opacity = Inforward_Helper::hex2rgba( $value['bg_color'], '0.43' );
							$bg_color = 'style="' . vc_get_css_color( 'background', $value['bg_color'] ) . 'box-shadow:0px 12px 25px 0px '. $btn_color_opacity .'"';
							
						}
						if ( isset($value['icon_color']) && !empty($value['icon_color']) ) {
							$icon_color = 'style="' . vc_get_css_color( 'color', $value['icon_color'] ) . '"';
						}
						if ( isset($value['title_color']) && !empty($value['title_color']) ) {
							$item_title_color = 'style="' . vc_get_css_color( 'color', $value['title_color'] ) . '"';
						}
						
						?>

						 <div class="action-col">
            
							<a href="<?php echo trim( $a_href ) ?>" target="<?php echo esc_attr($a_target); ?>" class="action-item" <?php echo sprintf('%s', $bg_color) ?> onmouseover="this.style.background='<?php if( !empty($value['bg_color_hover']) ) { echo esc_attr($value['bg_color_hover']); } ?>'" onmouseout="this.style.background='<?php if( !empty($value['bg_color']) ) { echo esc_attr($value['bg_color']); } ?>'">
							  
							  <?php if ( !empty($value['icon']) ) { ?>
							  <i class="icon <?php echo esc_attr($value['icon']) ?>" <?php echo sprintf('%s', $icon_color) ?>></i>
							  <?php } ?>
                              
                               <?php if ( !empty($value['label']) ) { ?>
							  <h5 class="action-title" <?php echo sprintf('%s', $item_title_color) ?> ><?php echo esc_attr($value['label']) ?></h5>
                              <?php } ?>
							 
                             <?php if ( !empty($value['value']) ) { ?>
                              <p><?php echo wp_kses( $value['value'], array(
									'ul' => array(),
									'li' => array(),
									'a' => array(
										'href' => array(),
										'title' => array()
									),
									'br' => array(),
									'em' => array(),
									'strong' => array(),
									'p' => array()
								)) ?></p>
                                <?php } ?>
                                
							</a>
							
						  </div>
				
					<?php endforeach; ?>

				</div>	

			</div>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Counter - - - - - - - - - - - - - - - - -->

		<?php return ob_get_clean();
	}

}