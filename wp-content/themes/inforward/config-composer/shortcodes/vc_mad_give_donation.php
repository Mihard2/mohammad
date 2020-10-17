<?php

class WPBakeryShortCode_VC_mad_give_donation extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'image' => '',
			'donation_id' => array(),
			'css_animation' => ''
		), $atts, 'vc_mad_give_donation' );

		$this->query_entries();
		$html = $this->html();
		
		return $html;
	}

	public function query_entries($params = array()) {
		if ( empty($params) ) $params = $this->atts;
		
		$tax_query = array();
		$donation_id_arr = array();

		if ( !empty($params['donation_id']) ) {
			$donation_id_arr = explode(',', $params['donation_id']);
		}
		
		$query = array(
			'post_type' => 'give_forms',
			'post_status'  => 'publish',
			'posts_per_page' => 1,
			'tax_query' => $tax_query,
			'post__in' 	 => $donation_id_arr,
		);

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		global $inforward_settings;

		$title = $css_animation = '';
		$wrapper_attributes = array();
		$excerpt_count = '160';

		extract($this->atts);

		$css_classes = array();
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

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
		
		
		ob_start() ?>

        
      <div class="page-section-bg4 type4 half-bg-col vc_give_donations">

        <div class="img-col-left">
        <?php echo sprintf('<div class="col-bg" data-bg="%s"></div>', $img_large); ?>
        </div>
        
        <div class="container extra-size2">
          <div class="row">
            <div class="col-md-6"></div>
			
			<div class="col-md-6">
              
              <?php foreach ( $this->entries->posts as $entry ): ?>
             
             		<?php
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$content = has_excerpt($id) ? $entry->post_excerpt : give_get_meta( $id, '_give_form_content', true );
						$content = inforward_get_excerpt( $content, $excerpt_count );
					?>
             
              <h6 class="section-sub-title"><?php echo esc_html($title); ?></h6>
              <h2 class="section-title"><?php echo esc_html($name); ?></h2>

              <div class="event-info content-element3">
                <div class="donation-about content-element3"><?php echo apply_filters( 'the_content', $content ); ?></div>
				
				<?php
				echo do_shortcode('[give_goal id="'. $id .'" show_text="true" show_bar="true"]');
				?>
				
              </div>

              <a href="<?php echo esc_url($link); ?>" class="btn btn-style-4 type-2"><?php echo esc_html__('Donate Now','inforward'); ?></a>

			  <?php endforeach; ?>
			  
			  <?php wp_reset_postdata(); ?>

            </div>
            
          </div>
        </div>

      </div>
        

		<?php return ob_get_clean();
	}

}