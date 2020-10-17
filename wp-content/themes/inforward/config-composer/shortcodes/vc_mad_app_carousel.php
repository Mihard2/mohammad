<?php

class WPBakeryShortCode_VC_mad_app_carousel extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' 	 => '',
			'tag_title'  => 'h2',
			'description' 	 => '',
			'title_color' => '',
			'images' => '',
			'css_animation' => ''
		), $atts, 'vc_mad_app_carousel');

		return $this->html();
	}

	public function html() {

		$params = $this->atts;
		$wrapper_attributes = array();

		$description = !empty($params['description']) ? $params['description'] : '';
		$title_color = !empty($params['title_color']) ? $params['title_color'] : '';
		$description_color = !empty($params['description_color']) ? $params['description_color'] : '';
		$css_animation = !empty($params['css_animation']) ? $params['css_animation'] : '';

		extract($this->atts);

		$images = explode( ',', $images);

		$css_classes = array(
			'cp-app-carousel'
		);

		$css_classes[] = 'owl-carousel';

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, 0 );
		}

		ob_start(); ?>

		<div class="wpb_content_element">

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

				<?php if ( !empty($images) ): ?>

					<?php foreach ( $images as $attach_id ): ?>

						<?php if ( $attach_id > 0 ): ?>
							<?php $img = wpb_getImageBySize( array( 'attach_id' => (int) $attach_id, 'thumb_size' => array(314, 559) ) ); ?>
						<?php endif; ?>

						<?php if ( !empty($img['thumbnail']) ): ?>
							<div class="cp-app-item"><?php echo sprintf( '%s', $img['thumbnail'] ); ?></div>
						<?php endif; ?>

					<?php endforeach; ?>

				<?php endif; ?>

			</div><!--/ .cp-app-carousel-->

		</div>

		<?php return ob_get_clean();
	}

}