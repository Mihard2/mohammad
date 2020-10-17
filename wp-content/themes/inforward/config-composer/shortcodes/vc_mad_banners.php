<?php

class WPBakeryShortCode_VC_mad_banners extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'image' => '',
			'link' => "",
			'css_animation' => '',
		), $atts, 'vc_mad_banners');

		$this->content = $content;

		return $this->html();
	}

	public function html() {

		$wrapper_attributes = array();
		$image = $link = $css_animation = '';

		extract($this->atts);

		$attach_id = preg_replace('/[^\d]/', '', $image);
		$alt = trim( strip_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) ) );
		$img = wpb_getImageBySize(array(
			'attach_id' => $attach_id,
			'thumb_size' => '',
		));

		if ( $img['p_img_large'] == null ) {
			$img_large = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
		} else {
			$img_large = '<img alt="' . esc_attr($alt) . '" src="' . esc_attr($img['p_img_large'][0]) . '" />';
		}

		$link = ($link == '||') ? '' : $link;
		$link = vc_build_link($link);
		$a_href = $link['url'];
		$a_title = $link['title'];
		( $link['target'] != '' ) ? $a_target = $link['target'] : $a_target = '_self';

		$css_classes = array(
			'cp-banner-area'
		);

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, '20' );
		}

		ob_start(); ?>

		<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

			<?php if ( $img_large != '' ): ?>

				<?php if ( !empty($a_href) ): ?>
					<a class="cp-banner-button" title="<?php echo esc_attr($a_title) ?>" target="<?php echo esc_attr($a_target) ?>" href="<?php echo esc_url($a_href) ?>">
				<?php endif; ?>

					<div class="cp-banner-image">
						<?php echo sprintf('%s', $img_large); ?>
					</div><!--/ .cp-banner-image-->

				<?php if ( !empty($a_href) ): ?>
					</a>
				<?php endif; ?>

			<?php endif; ?>

		</div><!--/ .cp-banner-area-->

		<?php return ob_get_clean();
	}

}