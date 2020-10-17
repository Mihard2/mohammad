<?php

class WPBakeryShortCode_VC_mad_facebook_widget extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'height' => '',
			'username' => '',
			'target' => '_self',
			'type' => 'type-1'
		), $atts, 'vc_mad_facebook_widget');

		return $this->html();
	}

	public function html() {
		$title = $type = $username = '';

		extract($this->atts);

		ob_start() ?>
		
			<?php  
			if($type == 'type-1' ) {?>
				<div class="vc-widget-fb type_1" style="height:<?php echo esc_attr($height) ?>">
                <h5 class="cp-widget-title"><?php echo esc_html($title); ?></h5>
                
				<?php echo do_shortcode($username); ?>
                
				</div>
                
			<?php }elseif($type == 'type-2') { ?>
				<div class="vc-widget-fb type_2" style="height:<?php echo esc_attr($height) ?>">
                <h5 class="cp-widget-title"><?php echo esc_html($title); ?></h5>
                
				<?php echo do_shortcode($username); ?>
                
				</div>
				
			<?php }elseif($type == 'type-3') { ?>
				<div class="vc-widget-fb type_3" style="height:<?php echo esc_attr($height) ?>">
                <h5 class="cp-widget-title"><?php echo esc_html($title); ?></h5>
                
				<?php echo do_shortcode($username); ?>
               
				</div>
				
			<?php } ?>
	
		<?php return ob_get_clean();
	}

}