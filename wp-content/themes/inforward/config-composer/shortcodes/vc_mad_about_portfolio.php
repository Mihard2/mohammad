<?php

class WPBakeryShortCode_VC_mad_about_portfolio extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'output_date'   => "yes",
			'output_author' => "yes",
			'output_category' => "yes"
		), $atts, 'vc_mad_about_portfolio');

		$this->content = $content;
		
		return $this->html();
	}

	public function html() {

		global $post;

		$output_author = $output_date = $output_category = '';

		extract($this->atts);
		
		$id = get_the_author_meta('ID');
		$name  = get_the_author_meta('display_name', $id);

		ob_start(); ?>

		<div class="wpb_content_element about_portfolio content-element2">
            
            <div class="row">
              <div class="col-md-4 col-sm-12">

                <h6 class="event-detail-title"><?php _e('Details', 'inforward') ?></h6>
                <ul class="event-detail-list">
                
                 <?php if ($output_date == 'yes'): ?>
                  <li class="flex-row flex-justify">

                    <div class="detail-col">
                      <?php _e('Date', 'inforward') ?>:
                    </div>
                    <div class="detail-col">
                      <?php echo get_the_date(); ?>
                    </div>

                  </li>
                  <?php endif; ?>
                  
                  <?php if ($output_category == 'yes'): 
				  $categories = get_the_term_list($post->ID, 'portfolio_categories', '', ', ','');
				  ?>
                  <li class="flex-row flex-justify">

                    <div class="detail-col">
                      <?php _e('Category', 'inforward') ?>:
                    </div>
                    <div class="detail-col">
                     <?php echo wp_kses_post($categories); ?>
                    </div>

                  </li>
                  <?php endif; ?>
                  
                  <?php if ($output_author == 'yes'): ?>
                  <li class="flex-row flex-justify">

                    <div class="detail-col">
                      <?php _e('Author', 'inforward') ?>:
                    </div>
                    <div class="detail-col">
                    <?php
						printf( '<a href="%1$s">%2$s</a>',
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
							get_the_author()
						);
					?>
                     
                    </div>

                  </li>
                  <?php endif; ?>
                  
                </ul>

              </div>
              <div class="col-md-8 col-sm-12">
                
                <h6 class="event-detail-title"><?php _e('Description', 'inforward') ?></h6>
                <?php if (!empty($this->content)): ?>
                <?php echo wpb_js_remove_wpautop($this->content, true) ?>
                <?php endif; ?>

              </div>
            </div>

          </div>

		<?php return ob_get_clean();
	}

}