<?php

class WPBakeryShortCode_VC_mad_newsletter extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'info' => '',
			'type_input' => 'email',
			'type' => 'type_1'
		), $atts, 'vc_mad_newsletter');

			global $inforward_settings; 
			$data_mailchimp_api = $inforward_settings['mailchimp-api']; 
			if ( $data_mailchimp_api == '' ) {
				//echo esc_html__('Please enter your MailChimp API KEY in the theme options pannel prior of using this widget.','inforward');
				return;
			}
			
		return $this->html();
	}

	public function html() {
		$title = $type = $info = '';

		extract($this->atts);

		ob_start() ?>
		
			<?php  
			$type_widget = 'inforward_widget_mailchimp';
			
			$mad_widget_args = array(
				'before_widget' => '<div id="wp_newsletter_widget">',
				'after_widget' => '</div>',
				'before_title' => '<h5 class="cp-widget-title wt-title">',
				'after_title' => '</h5>'
			);
			the_widget( $type_widget, $this->atts, $mad_widget_args ); ?>
	
		<?php return ob_get_clean();
	}

}