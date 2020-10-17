<?php

class WPBakeryShortCode_VC_mad_video_widget extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'video_w' => '',
			'height' => '',
			'video_path' => '',
			'link' => '',
		), $atts, 'vc_mad_video_widget');

		return $this->html();
	}

	public function html() {
		$title = $height = $video_path = '';

		extract($this->atts);

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
		
		$video_h = $video_w / 1.8; 
		/** @var WP_Embed $wp_embed */
		global $wp_embed;
		$embed = '';
		$enable_autoplay = 'no';
		
		$embed = wp_video_shortcode(array('src' => $video_path, 'width' => $video_w, 'height' => $video_h));

		ob_start() ?>
		
			
				<div class="vc-widget-video widget-youtube" style="height:<?php echo esc_attr($height) ?>">
                <header></header>
                
                <?php echo sprintf( '%s', $embed); ?>
                
                <h6 class="cp-widget-title"><?php echo esc_html($title); ?></h6>
                
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
					
								echo '<a class="info-btn" ' . $attributes . '>' . $a_title . '</a>';
						} ?>
                
				</div>
        
     <?php   if ( strpos($video_path, 'vimeo') > 0 && $enable_autoplay == 'yes' ): ?>

		<script src="https://player.vimeo.com/api/player.js"></script>
        <script>
            var vc_vimeo_iframe = document.querySelector('iframe');
            var vc_vimeo_player = new Vimeo.Player(vc_vimeo_iframe);
    
            if (vc_vimeo_player)
                vc_vimeo_player.play();
    
        </script>

	<?php endif; ?>
                
		<?php return ob_get_clean();
	}

}