<?php

class WPBakeryShortCode_VC_mad_events_countdown extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'type' => 'type-1',
			'image' => '',
			'items' => 3,
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'autoplay' => '',
			'autoplaytimeout' => 5000,
			'link' => '',
			'css_animation' => ''
		), $atts, 'vc_mad_events_countdown' );

		$this->query_entries();
		$html = $this->html();

		wp_enqueue_script( 'jquery-countdown-plugin' );
		wp_enqueue_script( 'jquery-countdown' );
		
		return $html;
	}

	public function query_entries($params = array()) {
		if ( empty($params) ) $params = $this->atts;
		
		$tax_query = array();

		if ( !empty($params['categories']) ) {
			$categories = explode(',', $params['categories']);
			$tax_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'tribe_events_cat',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}
		
		$query = array(
			'post_type' => 'tribe_events',
			'post_status'  => 'publish',
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'posts_per_page' => $params['items'],
			'tax_query' => $tax_query
		);

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		global $inforward_settings;

		$title = $tag_title = $description = $title_color = $description_color = $columns = $autoplay = $autoplaytimeout = $css_animation = '';
		$wrapper_attributes = array();
		$excerpt_count = 20;

		extract($this->atts);

		$css_classes = array();
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

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


		<?php if ( $type == 'type-1' ): ?>

		<div class="wpb_content_element events-countdown countdown-area align-center" <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, $i, '-130' ) : '' ?>>

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

			<div class= "carousel-type-1" >
			<div class="owl-carousel" data-max-items="1" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-timeout="<?php echo esc_attr($autoplaytimeout); ?>">

				<?php foreach ( $this->entries->posts as $entry ): ?>

					<?php
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$venue_details = tribe_get_venue_details($id);
						$start_minutes = tribe_get_start_date( $id, false, 'i' );
						$start_hours = tribe_get_start_date( $id, false, 'h' );
						$start_day = tribe_get_start_date( $id, false, 'd' );
						$start_month = tribe_get_start_date( $id, false, 'm' );
						$start_year = tribe_get_start_date( $id, false, 'Y' );
						$event_day = tribe_get_start_date( $id, false, 'M d, Y \a\t\ g:i a' );
						$event_day_time = tribe_get_start_date( $id, false, DATE_W3C );
					?>

					<div class="item-carousel">
						<h6 class="section-pre-title"><?php echo esc_html__('Upcoming Events','inforward'); ?></h6>
						<h2 class="section-title"><?php echo esc_html($name); ?></h2>
				        <time datetime="<?php echo esc_attr($event_day_time) ?>"><?php echo esc_attr($event_day) ?></time>
					
						<div class="countdown" data-year="<?php echo esc_attr($start_year); ?>" data-month="<?php echo esc_attr($start_month-1); ?>" data-day="<?php echo esc_attr($start_day); ?>" data-hours="<?php echo esc_attr($start_hours); ?>" data-minutes="<?php echo esc_attr($start_minutes); ?>" data-seconds="0"></div>
					
						<a href="<?php echo esc_url($link); ?>" class="btn btn-big"><?php echo esc_html__('Join Now!','inforward'); ?></a>
					
					</div>
					
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>

			</div>
			</div>
			
		</div>
        
        <?php elseif( $type == 'type-2' ): ?>
        
      <div class="page-section-bg4 type4 half-bg-col">

        <div class="img-col-right">
        <?php echo sprintf('<div class="col-bg" data-bg="%s"></div>', $img_large); ?>
        </div>
        
        <div class="container extra-size2">
          <div class="row">
            <div class="col-md-6">
              
              <?php foreach ( $this->entries->posts as $entry ): ?>
             
             		<?php
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$venue_details = tribe_get_venue_details($id);
						$venue_address = tribe_get_address($id);
						$start_minutes = tribe_get_start_date( $id, false, 'i' );
						$start_hours = tribe_get_start_date( $id, false, 'h' );
						$start_day = tribe_get_start_date( $id, false, 'd' );
						$start_month = tribe_get_start_date( $id, false, 'm' );
						$start_year = tribe_get_start_date( $id, false, 'Y' );
						$event_day = tribe_get_start_date( $id, false, 'M d, Y \a\t\ g:i a' );
						$event_day_time = tribe_get_start_date( $id, false, DATE_W3C );
						$address_delimiter = empty( $venue_address ) ? ' ' : ', ';
					?>
             
              <h6 class="section-sub-title"><?php echo esc_html__('Upcoming Events','inforward'); ?></h6>
              <h2 class="section-title"><?php echo esc_html($name); ?></h2>

              <div class="event-info content-element3">
                <div class="event-info-item"><i class="icon icon-location"></i><?php echo tribe_get_full_address($id); ?></div>
              </div>

              <div class="countdown content-element2" data-year="<?php echo esc_attr($start_year); ?>" data-month="<?php echo esc_attr($start_month-1); ?>" data-day="<?php echo esc_attr($start_day); ?>" data-hours="<?php echo esc_attr($start_hours); ?>" data-minutes="<?php echo esc_attr($start_minutes); ?>" data-seconds="0"></div>

              <a href="<?php echo esc_url($link); ?>" class="btn btn-style-4 type-2"><?php echo esc_html__('View Event Details','inforward'); ?></a>

			  <?php endforeach; ?>
			  <?php wp_reset_postdata(); ?>

            </div>
            <div class="col-md-6"></div>
          </div>
        </div>

      </div>
        
        <?php endif; ?>

		<?php return ob_get_clean();
	}

}