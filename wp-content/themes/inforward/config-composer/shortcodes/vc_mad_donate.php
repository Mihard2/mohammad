<?php

class WPBakeryShortCode_VC_mad_donate extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'text_amount1' => '',
			'text_amount2' => '',
			'text_amount3' => '',
			'text_amount4' => '',
			'url_amount' => '',
			'org_donate' => '',
			'currency_amount' => '',
			'type' => 'type_1'
		), $atts, 'vc_mad_donate');

		return $this->html();
	}

	public function html() {
		$title = $type = $info = '';

		extract($this->atts);

		ob_start() ?>
		
			<?php  
			$type_widget = 'inforward_widget_donate';
			
			$mad_widget_args = array(
				'before_widget' => '<div id="wp_donate_widget">',
				'after_widget' => '</div>',
				'before_title' => '<h5 class="cp-widget-title wt-title">',
				'after_title' => '</h5>'
			);
			the_widget( $type_widget, $this->atts, $mad_widget_args ); ?>
	
		<?php return ob_get_clean();
	}

}