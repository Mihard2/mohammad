<?php

class WPBakeryShortCode_VC_mad_text_with_image extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'image' => '',
			'box_type' => 'type-1',
			'link' => '',
			'css_animation' => '',
		), $atts, 'vc_mad_text_with_image');

		return $this->html($content);
	}

	public function html($content) {

		$wrapper_attributes = array();
		$image = $css_animation = '';

		extract($this->atts);

		$attach_id = preg_replace('/[^\d]/', '', $image);
		$alt = trim( strip_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) ) );
		$img = wpb_getImageBySize(array(
			'attach_id' => $attach_id,
			'thumb_size' => '',
		));

		if ( $img['p_img_large'] == null ) {
			$img_large =  vc_asset_url( 'vc/no_image.png' );
		} else {
			$img_large = esc_url($img['p_img_large'][0]);
		}

		$custom_links = ( '||' === $link ) ? '' :$link;
		$custom_links = vc_build_link( $link );
		$use_link = false;
		if ( strlen( $custom_links['url'] ) > 0 ) {
			$use_link = true;
			$a_href = $custom_links['url'];
			$a_title = $custom_links['title'];
			$a_target = $custom_links['target'];
			$a_rel = $custom_links['rel'];
		}

		$css_classes = array(
			'cp-text-with-image-area'
		);

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, '20' );
		}

		ob_start(); ?>

		<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

		
			<?php if ( $box_type == 'type-1' ): ?>
			
			<div class="page-section type5 half-bg-col">
				
				<?php if ( $img_large != '' ): ?>
				<div class="img-col-left">
				<?php echo sprintf('<div class="col-bg" data-bg="%s"></div>', $img_large); ?>
				</div>
				<?php endif; ?>
               
                <div class="container extra-size">
                <div class="row">
                
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
						<?php echo wpb_js_remove_wpautop( $content, true ); ?>
                        
                         <?php 
							if ( $use_link ) { 
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
						
									echo '<a class="btn" ' . $attributes . '>' . $a_title . '</a>';
							} ?>
                        
                    </div>
                    
                </div>
                </div>
				
			</div>
			
			<?php elseif( $box_type == 'type-2' ): ?>
			<div class="page-section-bg type5 half-bg-col">
		
				<?php if ( $img_large != '' ): ?>
				<div class="img-col-right">
				<?php echo sprintf('<div class="col-bg" data-bg="%s"></div>', $img_large); ?>
				</div>
				<?php endif; ?>
				
				<div class="container extra-size">
                <div class="row">
                   
                    <div class="col-md-6">
						<?php echo wpb_js_remove_wpautop( $content, true ); ?>
                        
                         <?php 
							if ( $use_link ) { 
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
						
									echo '<a class="btn btn-style-3" ' . $attributes . '>' . $a_title . '</a>';
							} ?>
                        
                    </div>
                    <div class="col-md-6"></div>
                    
                </div>
                </div>
		
			</div>
			<?php endif; ?>


		</div>

		<?php return ob_get_clean();
	}

}