<?php

class WPBakeryShortCode_VC_mad_banner_list extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'values' => ''
		), $atts, 'vc_mad_banner_list');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$title = $values = '';
		extract($this->atts);
		$values = (array) vc_param_group_parse_atts( $values );

		ob_start(); ?>

		<!-- - - - - - - - - - - - - - Counter - - - - - - - - - - - - - - - - -->

		<?php if ( !empty($values) ): ?>

			<div class="wpb_content_element sp_home_banner_list">

			<?php
			echo Inforward_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'tag_title' => 'h3',
					'description' => '',
					'title_color' => '',
					'description_color' => '',
				)
			);
			?>

				<div class="action-widget style-2 type-vr">

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

						
						<?php if ( $use_link ) { 
								$attributes = array();
								$attributes[] = 'href="' . trim( $a_href ) . '"';
								$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
								if ( ! empty( $a_target ) ) {
									$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
								}
								if ( ! empty( $a_rel ) ) {
									$attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
								}
								$attributes = implode( ' ', $attributes );
								?>
						<a href="<?php echo trim( $a_href ) ?>" target="<?php echo esc_attr($a_target); ?>" class="action-item" <?php echo sprintf('%s', $bg_color) ?> onmouseover="this.style.background='<?php echo esc_attr($value['bg_color_hover']) ?>'" onmouseout="this.style.background='<?php echo esc_attr($value['bg_color']) ?>'">
                        <?php } else { ?>
							<div class="action-item" <?php echo sprintf('%s', $bg_color) ?>  onmouseover="this.style.background='<?php echo esc_attr($value['bg_color_hover']) ?>'" onmouseout="this.style.background='<?php echo esc_attr($value['bg_color']) ?>'">
						<?php }
						?>
						
                           <?php if ( !empty($value['icon']) ) { ?>
                                  <i class="icon <?php echo esc_attr($value['icon']) ?>" ></i>
                                  <?php } ?>
                              
								<h5 class="action-title"><b><?php echo esc_attr($value['label']) ?></b></h5>

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
								
						<?php 
						if ( $use_link ) { echo '</a>'; } else { echo '</div>'; }
						?>
						
					<?php endforeach; ?>

				</div>	

			</div>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Counter - - - - - - - - - - - - - - - - -->

		<?php return ob_get_clean();
	}

}