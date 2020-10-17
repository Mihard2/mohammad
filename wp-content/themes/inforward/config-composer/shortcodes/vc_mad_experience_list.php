<?php

class WPBakeryShortCode_VC_mad_experience_list extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'values' => ''
		), $atts, 'vc_mad_experience_list');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$title = $values = '';

		extract($this->atts);
		$values = (array) vc_param_group_parse_atts( $values );
		ob_start(); ?>

		<?php if ( !empty($values) ): ?>

			<div class="wpb_content_element">

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

				<ul class="experience_list custom-list">

					<?php foreach( $values as $value ): ?>

						<li class="clearfix" >
							<div class="f-left">

								<?php if ( !empty($value['label']) ): ?>
									<div class="text-size-medium"><?php echo esc_html($value['label']) ?></div>
								<?php endif; ?>

								<?php if ( !empty($value['value']) ): ?>
									<span class="position"><?php echo esc_html($value['value']) ?></span>
								<?php endif; ?>

							</div>

							<?php if ( !empty($value['time']) ): ?>
								<div class="f-right"><?php echo esc_html($value['time']) ?></div>
							<?php endif; ?>

						</li>

					<?php endforeach; ?>

				</ul>

			</div>

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}