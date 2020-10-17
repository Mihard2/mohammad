<?php

class WPBakeryShortCode_VC_mad_counter extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'description' => '',
			'title_color' => '',
			'number_color' => '',
			'label_color' => '',
			'icon_color' => '',
			'description_color' => '',
			'type' => 'type-1',
			'values' => '',
			'css_animation' => ''
		), $atts, 'vc_mad_counter');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$title = $tag_title = $description = $title_color = $number_color = $label_color = $icon_color = $description_color = $type = $values = $icon = $css_animation = '';

		extract($this->atts);
		$values = (array) vc_param_group_parse_atts( $values );

		$css_classes = array(
			'cp-counters-holder',
			$type
		);
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, '20' );
		}

		ob_start(); ?>

		<!-- - - - - - - - - - - - - - Counter - - - - - - - - - - - - - - - - -->

		<?php if ( !empty($values) ): ?>

			<div class="wpb_content_element">

				<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

					
					
					
					<?php if ( $type == 'type-1' ) { ?>
					
					<div class="row table-row">
						<div class="col-md-4">
							
							<h6 class="section-pre-title" style="color:<?php echo esc_attr($description_color); ?>"><?php echo esc_html($description); ?></h6>
							<<?php echo esc_attr($tag_title); ?> style="color:<?php echo esc_attr($title_color); ?>" class="section-title"><?php echo esc_html($title); ?></<?php echo esc_attr($tag_title); ?> >

						</div>
						
						<div class="col-md-8">
						<div class="row">
					<?php foreach( $values as $value ): ?>

						<?php if ( isset($value['icon']) ): ?>
							<?php $icon = trim($value['icon']); ?>
						<?php endif; ?>

						<div class="col-md-3 col-xs-6">
						<div class="counter <?php if ( !empty($icon)): ?>cp-with-icon<?php endif; ?>" >
						<div class="counter-inner">

							<?php if ( !empty($icon) ): ?>
								<span style="color:<?php echo esc_attr($icon_color); ?>"  class="<?php echo trim($value['icon']) ?>"></span>
							<?php endif; ?>

							<h3 class="timer count-number" style="color:<?php echo esc_attr($number_color); ?>"  data-to="<?php echo esc_attr($value['value']) ?>" data-speed="1500">0</h3>
							
							<p style="color:<?php echo esc_attr($label_color); ?>" ><?php echo esc_html($value['label']) ?></p>
							
						</div>
						</div>
						</div>

					<?php endforeach; ?>
						</div>
						</div>
					</div>
					
					<?php } elseif ( $type == 'type-2' ) { ?>
					<div class="section_counter_type_2">
						<h6 class="section-pre-title" style="color:<?php echo esc_attr($description_color); ?>"><?php echo esc_html($description); ?></h6>
						<<?php echo esc_attr($tag_title); ?> style="color:<?php echo esc_attr($title_color); ?>" class="section-title"><?php echo esc_html($title); ?></<?php echo esc_attr($tag_title); ?> >
						
                        <div class="row counter-wrap">
						<?php foreach( $values as $value ): ?>

						<?php if ( isset($value['icon']) ): ?>
							<?php $icon = trim($value['icon']); ?>
						<?php endif; ?>

						<div class="col-lg-3 col-md-6 col-xs-6">
						<div class="counter <?php if ( !empty($icon)): ?>cp-with-icon<?php endif; ?>" >
						
							<?php if ( !empty($icon) ): ?>
								<span style="color:<?php echo esc_attr($icon_color); ?>"  class="<?php echo trim($value['icon']) ?>"></span>
							<?php endif; ?>
							<div class="counter-inner">
								<h3 style="color:<?php echo esc_attr($number_color); ?>"  class="timer count-number" data-to="<?php echo esc_attr($value['value']) ?>" data-speed="1500">0</h3>
								
								<p style="color:<?php echo esc_attr($label_color); ?>" ><?php echo esc_html($value['label']) ?></p>
							</div>
							
						</div>
						</div>

						<?php endforeach; ?>
						</div>

					</div>	
					<?php } ?>	
						
					
					
				</div>

			</div>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Counter - - - - - - - - - - - - - - - - -->

		<?php return ob_get_clean();
	}

}