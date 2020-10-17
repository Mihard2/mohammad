<?php

class WPBakeryShortCode_VC_mad_press_list extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'link_more' => '',
			'values' => ''
		), $atts, 'vc_mad_press_list');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$title = $values = $bg_color = $bg_color_hover = $icon_color = '';
		extract($this->atts);
		
		$custom_link_more = vc_build_link( $link_more );
		$use_link_more = false;
		if ( strlen( $custom_link_more['url'] ) > 0 ) {
			$use_link_more = true;
			$a_href_more = $custom_link_more['url'];
			$a_title_more = $custom_link_more['title'];
			$a_target_more = $custom_link_more['target'];
			$a_rel_more = $custom_link_more['rel'];
		}
		
		
		$values = (array) vc_param_group_parse_atts( $values );

		ob_start(); ?>

		<!-- - - - - - - - - - - - - - Counter - - - - - - - - - - - - - - - - -->

		<?php if ( !empty($values) ): ?>

			<div class="wpb_content_element cp_press_list">

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

				
				<div class="row flex-row flex-top">

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
							
							$bg_color = 'style="' . vc_get_css_color( 'background', $value['bg_color'] ) . '"';
							
						}	
						?>

						 <div class="press-col col-md-4">
                         <div class="entry entry-small">
            
							<div class="entry-body" <?php echo sprintf('%s', $bg_color) ?> onmouseover="this.style.background='<?php echo esc_attr($value['bg_color_hover']) ?>'" onmouseout="this.style.background='<?php echo esc_attr($value['bg_color']) ?>'">
                          
                              <?php if ( !empty($value['label']) ) { ?>
                              <h4 class="entry-title"><a href="<?php echo trim( $a_href ) ?>" target="_blank" ><?php echo esc_html($value['label']) ?></a></h4>
                              <?php } ?>
                              
                              <?php if ( !empty($value['time']) ) { ?>
                              <div class="entry-meta">
                          
                                <time class="entry-date" datetime="2018-03-25"><?php echo esc_html($value['time']) ?></time>
                          
                              </div>
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
                      
                              <a href="<?php echo trim( $a_href ) ?>" class="info-btn" target="_blank" ><?php echo esc_html( $a_title ) ?></a>
                            
                            </div>
                       
						  </div>
                          </div>
				
					<?php endforeach; ?>

				</div>	

			</div>
            
            <?php if ( $use_link_more ) { ?>
            <div class="align-center">
               <a href="<?php echo trim( $a_href_more ) ?>" class="btn" target="_blank" ><?php echo esc_html( $a_title_more ) ?></a>
            </div>
            <?php } ?>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Counter - - - - - - - - - - - - - - - - -->

		<?php return ob_get_clean();
	}

}