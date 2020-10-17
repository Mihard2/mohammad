<?php

class WPBakeryShortCode_VC_mad_twitter_widget extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'screen_name' => '',
			'height' => '',
			'num' => 9,
			'rts' => true,
			'ats' => true,
			'target' => '_self',
			'link' => '',
			'type_widget' => 'type1'
		), $atts, 'vc_mad_twitter_widget');

		return $this->html();
	}

	public function html() {
		$title = $name_widget = $custom_link = $type_widget = $username = $height = '';

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
	
				if ($type_widget == 'type5 carousel-twitter') {
				$custom_link = '<div class="tweets_btn"><a class="btn btn-style-2" ' . $attributes . '>' . $a_title . '</a></div>';
				} elseif ($type_widget == 'type4') {
				$custom_link = '<div class="tweets_btn"><a class="cp-btn custom_btn info-btn btn-white" ' . $attributes . '>' . $a_title . '</a></div>';
				} elseif ($type_widget == 'type3') {
				$custom_link = '<div class="tweets_btn align-center"><a class="cp-btn btn" ' . $attributes . '>' . $a_title . '</a></div>';
				} elseif ($type_widget == 'type2') {
				$custom_link = '<div class="tweets_btn"><a class="cp-btn custom_btn info-btn btn-white" ' . $attributes . '>' . $a_title . '</a></div>';
				} elseif ($type_widget == 'type1') {
				$custom_link = '<div class="tweets_btn"><a class="cp-btn custom_btn info-btn btn-white" ' . $attributes . '>' . $a_title . '</a></div>';
				}
		}
		
		ob_start() ?>
		
			<?php  
			$name_widget = 'Latest_Tweets_Widget';
			
			$mad_widget_args = array(
				'before_widget' => '<div id="wp_latest_tweets_widget_vc" class="vc_latest_tweets_feed '. $type_widget .'" style="height:'. $height .'">',
				'after_widget' => $custom_link.'</div>',
				'before_title' => '<h5 class="cp-widget-title wt-title">',
				'after_title' => '</h5>'
			);
			the_widget( $name_widget, $this->atts, $mad_widget_args ); ?>
	
		<?php return ob_get_clean();
	}

}