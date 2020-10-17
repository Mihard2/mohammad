<?php

class WPBakeryShortCode_VC_mad_brands_logo extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => "",
			'tag_title' => 'h2',
			'title_color' => '',
			'description'   => '',
			'images' => "",
			'links' => "",
			'carousel' => '',
			'autoplay' => '',
			'autoplaytimeout' => 5000,
			'css_animation' => ""
		), $atts, 'vc_mad_brands_logo');

		return $this->html();
	}

	public function html() {

		$wrapper_attributes = array();
		$css_classes = array('brands-holder');
		$title = $tag_title = $title_color = $description_color = $description = $images = $links = $carousel = $autoplay = $autoplaytimeout = $css_animation = '';

		extract($this->atts);

		$links = !empty($links) ? explode('|', $links) : '';
		$images = explode( ',', $images);

		if ( $carousel ) {
			$css_classes[] = 'brands-carousel';
			$css_classes[] = 'owl-carousel';
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, 0 );
		}

		ob_start(); ?>

		<div class="carousel-type-1 brand-box">
		
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

		<div <?php echo implode( ' ', $wrapper_attributes ) ?> data-max-items="4" data-item-margin="30" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-timeout="<?php echo esc_attr($autoplaytimeout); ?>" >

			<!-- - - - - - - - - - - - - - Item- - - - - - - - - - - - - - - - -->

			<?php $i = 0; $img = array(); ?>

			<?php foreach ( $images as $id => $attach_id ): ?>

				<?php if ( $attach_id > 0 ): ?>

					<?php $img = wpb_getImageBySize( array( 'attach_id' => (int) $attach_id, 'thumb_size' => 'medium' ) ); ?>

				<?php else: ?>

					<?php $img['thumbnail'] = '<img alt="" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />'; ?>

				<?php endif; ?>

				<?php $link = ( isset($links[$i]) && !empty($links[$i]) ) ? trim($links[$i]) : ''; ?>

				<div class="item-carousel">
					<?php if ( isset($link) && !empty($link) ): ?>
						<a href="<?php echo esc_url($link) ?>" target="_blank" class="cp-brand">
					<?php endif; ?>

						<?php echo wp_kses_post( $img['thumbnail'] ); ?>

					<?php if ( isset($link) && !empty($link) ): ?>
						</a>
					<?php endif; ?>
				</div>

				<?php $i++; ?>

			<?php endforeach; ?>

			<!-- - - - - - - - - - - - - - End of Item - - - - - - - - - - - - - - - - -->

		</div><!--/ .owl_carousel-->

		</div>
		<?php return ob_get_clean();
	}

}