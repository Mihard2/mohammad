<?php

class WPBakeryShortCode_VC_mad_progress_bar extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'description' => '',
			'title_color' => '',
			'description_color' => '',
			'type' => 'type-1',
			'values' => '',
			'color' => '',
			'units' => '',
			'css_animation' => ''
		), $atts, 'vc_mad_progress_bar');

		$html = $this->html();
		return $html;
	}

	public function html() {

		$title = $tag_title = $description = $title_color = $description_color = $type = $values = $units = '';

		extract($this->atts);

		$values = (array) vc_param_group_parse_atts( $values );
		$max_value = 0.0;
		$graph_lines_data = array();

		foreach ( $values as $data ) {
			$new_line = $data;
			$new_line['value'] = isset( $data['value'] ) ? $data['value'] : 0;
			$new_line['label'] = isset( $data['label'] ) ? $data['label'] : '';
			$new_line['color'] = isset( $data['color'] ) ? $data['color'] : '';

			if ( $max_value < (float) $new_line['value'] ) {
				$max_value = $new_line['value'];
			}
			$graph_lines_data[] = $new_line;
		}

		$wrapper_attributes = array();

		$css_classes = array(
			'wpb_content_element',
			'cp-progress-bars-holder',
			$type
		);


		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, '20' );
		}

		ob_start(); ?>

		<?php if ( !empty($values) ): ?>

			<?php
			echo Inforward_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'tag_title' => $tag_title,
					'description' => $description,
					'title_color' => $title_color,
					'description_color' => $description_color,
				)
			);
			?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php foreach ( $graph_lines_data as $line ): ?>

					<?php $unit = ( '' !== $units ) ? $units : ''; ?>

					<div class="pbar-wrap <?php echo esc_attr($line['color']) ?>">

						<div class="pbar-title">
							<?php echo esc_html($line['label']) ?>
							<span><?php echo esc_attr( $line['value'] ) ?><?php echo esc_attr($unit) ?></span>
						</div>

						<div class="pbar" data-unit="<?php echo esc_attr($unit) ?>" data-value="<?php echo esc_attr( $line['value'] ) ?>">
							<div class="pbar-inner" style="width: <?php echo esc_attr( $line['value'] ) ?>%" data-value="<?php echo esc_attr( $line['value'] ) ?>" data-unit="<?php echo esc_attr($unit) ?>"></div>
						</div>

					</div>

				<?php endforeach; ?>

			</div>

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}