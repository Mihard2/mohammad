<?php

class WPBakeryShortCode_VC_mad_text_block extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'image' => '',
			'alignment' => 'left'
		), $atts, 'vc_mad_text_block');

		$wrapper_attributes = array();
		$image = $alignment = '';

		extract($this->atts);

		$css_classes = array( 'text-block-holder', 'alignment-' . $alignment );

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start(); ?>

		<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

			<?php if ( $alignment == 'left' ): ?>

				<?php if ( !empty($image) ): ?>

					<!-- - - - - - - - - - - - - - Simply Image Column - - - - - - - - - - - - - - - - -->

					<div class="col half-image" style="background-image: url(<?php echo Inforward_Helper::get_post_attachment_image($image, '945*500', true, array( 'alt' => '' )) ?>);"></div>

					<!-- - - - - - - - - - - - - - End of Simply Image Column - - - - - - - - - - - - - - - - -->

				<?php endif; ?>

				<?php if ( !empty($content) ): ?>

					<div class="col half-content">
						<?php echo wpb_js_remove_wpautop( $content, false ) ?>
					</div>

				<?php endif; ?>


			<?php else: ?>

				<?php if ( !empty($content) ): ?>

					<div class="col half-content">
						<?php echo wpb_js_remove_wpautop( $content, false ) ?>
					</div>

				<?php endif; ?>

				<?php if ( !empty($image) ): ?>

					<!-- - - - - - - - - - - - - - Simply Image Column - - - - - - - - - - - - - - - - -->

					<div class="col half-image" style="background-image: url(<?php echo Inforward_Helper::get_post_attachment_image($image, '945*500', true, array( 'alt' => '' )) ?>);"></div>

					<!-- - - - - - - - - - - - - - End of Simply Image Column - - - - - - - - - - - - - - - - -->

				<?php endif; ?>

			<?php endif; ?>

		</div>

		<?php return ob_get_clean();
	}

}