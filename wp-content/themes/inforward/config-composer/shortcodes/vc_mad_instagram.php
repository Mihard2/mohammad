<?php

class WPBakeryShortCode_VC_mad_instagram extends WPBakeryShortCode {

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'user_id' => '',
			'access_token' => '',
			'client_id' => '',
			'tag_name' => '',
			'number' => 9,
			'target' => '_self',
			'link' => ''
		), $atts, 'vc_mad_instagram');

		wp_enqueue_script('instafeed');

		return $this->html();
	}

	function html() {

		$params = $this->atts;
		extract($this->atts);

		ob_start(); ?>
        <div class="wpb_content_element vc_insta_gallery ">
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
            
            <div class="insta-gallery content-element7">
                <div id="instafeed" class="instagram-feed" ></div>
            </div>
    
              <?php if ( $link != '' ) { ?>
               <div class="align-center">
                <button  id="instafeed-load-more" class="btn"><?php echo esc_attr__('Load More','inforward') ?></button >
               </div>
               <?php } ?>
            
         <script type="text/javascript">
		  
			  
		    jQuery(document).ready(function($){
				
				$('#instafeed').each(function(){
					var loadButton = document.getElementById('instafeed-load-more');
					
					var feed = new Instafeed({
					  target: 'instafeed',
					  tagName: '<?php echo esc_attr($tag_name) ?>',
					  limit: <?php echo esc_attr($number) ?>,
					  get: 'user',
					  userId: <?php echo esc_attr($user_id) ?>,
					  accessToken: '<?php echo esc_attr($access_token) ?>',
					  clientId: '<?php echo esc_attr($client_id) ?>',
					  resolution: 'standard_resolution',
					  template: '<div class="nv-instafeed-item"><a href="{{image}}" title="{{location}}" data-fancybox="instagram"><img src="{{image}}" /></a></div>',
					  after: function() {
							// disable button if no more results to load
							if (!this.hasNext()) {
								loadButton.setAttribute('disabled', 'disabled');
							}
						},
					});
					 
					 // bind the load more button
					loadButton.addEventListener('click', function() {
						feed.next();
					});
					
					feed.run();
				
				})
				
			 });
			  
			 </script>	
        
		</div>
	
	<?php return ob_get_clean();
	}

}