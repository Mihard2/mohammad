<?php

class WPBakeryShortCode_VC_mad_blockquotes extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$style = '';
		$description = '';
		$info = '';

		$this->atts = shortcode_atts(array(
			'style' => 'with-bg style-2',
			'description' => '',
			'info' => ''
		), $atts, 'vc_mad_blockquotes');

		$wrapper_attributes = array();
		extract($this->atts);

		$css_classes = array( 'cp-blockquote', $style );

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start(); ?>

		<blockquote <?php echo implode( ' ', $wrapper_attributes ) ?>>
			<?php if ( !empty($content) ): ?>
				<p><?php echo wpb_js_remove_wpautop( $content, false ) ?></p>
			<?php endif; ?>
			
			<?php if ( !empty($description) || !empty($info) ): ?>
			<div class="author"><?php echo esc_html($description); ?></div>
			
				<?php if ( !empty($info) ): ?>
				<div class="author-status"><?php echo esc_html($info); ?></div>
				<?php endif; ?>
				
			<?php endif; ?>
			
		</blockquote>	
		
		<?php return ob_get_clean();
	}

}