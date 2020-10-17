<?php

class WPBakeryShortCode_VC_mad_dropcap extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'type' => 'type-1',
			'css_animation' => '',
			'animation_delay' => 0,
			'scroll_factor' => ''
		), $atts, 'vc_mad_dropcap');

		$this->content = $content;
		$html = $this->html();

		return $html;
	}

	public function html() {

		$type = $style = $letter = $output = $class = $dropcap = $css_animation = $animation = $animation_delay = $scroll_factor = "";

		extract($this->atts);

		if ( '' !== $this->content ) {

			if ( '' !== $css_animation  ) {
				$animation = Inforward_Helper::create_data_string_animation( $css_animation, $animation_delay, $scroll_factor );
			}

			$output .= "<div class='wpb_content_element dropcap_element' ". $animation .">";
			$output .= '<div class="dropcap '. esc_attr($type) .'" >';
			$output .= wpb_js_remove_wpautop($this->content, true);
			$output .= '</div>';
			$output .= '</div>';
		}

		return $output;
	}

}