<?php

class WPBakeryShortCode_VC_mad_services_list extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'title_align' => '',
			'values' => '',
			'columns' => 'fx-col-2'
		), $atts, 'vc_mad_services_list');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$title = $values = '';
		extract($this->atts);
		$values = (array) vc_param_group_parse_atts( $values );
		$title_color = !empty($title_color) ? $title_color : '';
		$title_align = !empty($title_align) ? $title_align : '';
		ob_start(); ?>

		<!-- - - - - - - - - - - - - - Counter - - - - - - - - - - - - - - - - -->

		<?php if ( !empty($values) ): ?>

			<div class="wpb_content_element">

			<?php
			echo Inforward_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'tag_title' => $tag_title,
					'description' => '',
					'title_color' => $title_color,
					'align' => $title_align,
					'description_color' => '',
				)
			);
			?>
			
			
				<div class="services <?php echo esc_attr($columns) ?>">

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
						
						?>

						<div class="service-col">
						<div class="service-item">

							<?php if ( absint($value['image']) ): ?>
								<img class="cp-service-image" src="<?php echo Inforward_Helper::get_post_attachment_image($value['image'], '') ?>" alt="">
							<?php endif; ?>
							
							<div class="service-inner">
								<h4 class="cp-service-title"><?php echo esc_attr($value['label']) ?></h4>

								<div class="cp-service-content"><?php echo wp_kses( $value['value'], array(
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
								)) ?></div>
								
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
					
								echo '<div class="services-btn"><a class="btn btn-style-2" ' . $attributes . '>' . $a_title . '</a></div>';
								 } ?>
								
							</div>

						</div>
						</div>

					<?php endforeach; ?>
					<?php wp_reset_postdata(); ?>

				</div>

			</div>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Counter - - - - - - - - - - - - - - - - -->

		<?php return ob_get_clean();
	}

}