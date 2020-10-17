<?php

class WPBakeryShortCode_VC_mad_flickr_gallery extends WPBakeryShortCode {

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'api_key' => '',
			'user_id' => '',
			'number' => 6,
			'target' => '_self',
			'link' => ''
		), $atts, 'vc_mad_flickr_gallery');
		
		wp_enqueue_style('justifiedGallery');
		wp_enqueue_script('flickr');
		wp_enqueue_script('query-justifiedgallery');

		return $this->html();
	}

	function html() {

		$params = $this->atts;
		extract($this->atts);

			ob_start(); ?>
			
			<div class="wpb_content_element flickr_gallery ">
			
            <?php
			echo Inforward_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'tag_title' => 'h3',
					'description' => '',
					'title_color' => '',
					'description_color' => '',
				)
			);
			?>
            
              <div class="content-element7">
                <div id="flickr"></div>
              </div>
              <?php if ( $link != '' ) { ?>
               <div class="align-center">
                <a href="<?php echo esc_url($link) ?>" target="<?php echo esc_attr($target) ?>" class="btn"><?php echo esc_attr__('Load More','inforward') ?></a>
               </div>
               <?php } ?>
          
          <script type="text/javascript">
		  
			  
		    jQuery(document).ready(function($){
				
					/* ---------------------------------------------------- */
					/*	flickr Gallery									    */
					/* ---------------------------------------------------- */
					var $this = $(this);
					var flickr =  $this.find('#flickr');
					
					if (flickr.length) {
							flickr.photostream({
							api_key: '<?php echo esc_attr($api_key) ?>',
							user_id: '<?php echo esc_attr($user_id) ?>',
							image_count: <?php echo esc_attr($number) ?>
						});
			
						flickr.on('ps.complete', function () {
							$(this).justifiedGallery({
								rowHeight: 260,
								maxRowHeight: 400,
								lastRow: 'hide',
								captions: false,
								randomize: true,
								margins: 4
							});
						});
			
					}
			  });
			  
			 </script>
          
			</div>

	<?php return ob_get_clean();
	}

}