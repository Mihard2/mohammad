<?php

class WPBakeryShortCode_VC_mad_instagram_widget extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'cols' => 3,
			'height' => '',
			'number' => 9,
			'link' => '',
			'type' => 'list'
		), $atts, 'vc_mad_instagram_widget');

		return $this->html();
	}

	public function html() {
		$title = $type = $username = $tag_name = $user_id = $access_token = $client_id = $height = '';

		extract($this->atts);

		ob_start() ?>
		
			<?php  
			$type_widget = 'inforward_instagram_widget2';
			
			$mad_widget_args = array(
				'before_widget' => '<div id="wp_instagram_widget_vc" class="inforward_instagram-feed type_'. $type .'" style="height:'. $height .'">',
				'after_widget' => '</div>',
				'before_title' => '<h5 class="cp-widget-title wt-title">',
				'after_title' => '</h5>'
			);
			the_widget( $type_widget, $this->atts, $mad_widget_args ); ?>
	
		<?php return ob_get_clean();
	}

}