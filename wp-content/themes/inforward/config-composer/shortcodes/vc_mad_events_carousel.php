<?php

class WPBakeryShortCode_VC_mad_events_carousel extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'title_color' => '#d2d2d2',
			'item_title_color' => '#fff',
			'items' => 3,
			'autoplay' => '',
			'autoplaytimeout' => 5000,
			'css_animation' => ''
		), $atts, 'vc_mad_events_carousel' );

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	public function query_entries() {
		$params = $this->atts;
		$tax_query = array();

		$query = array(
			'post_type' => 'tribe_events',
			'posts_per_page' => $params['items']
		);

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		global $inforward_settings;

		$title = $autoplay = $autoplaytimeout = $item_title_color = $title_color = $css_animation = '';
		$wrapper_attributes = array();
		
		extract($this->atts);

		$css_classes = array(
			'owl-carousel owl-theme'
		);
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( isset($item_title_color) && !empty($item_title_color) ) {
			$item_title_color = 'style="' . vc_get_css_color( 'color', $item_title_color ) . '"';
		}	
		if ( isset($title_color) && !empty($title_color) ) {
			$title_color = 'style="' . vc_get_css_color( 'color', $title_color ) . '"';
		}
		
		ob_start() ?>

		<div class="wpb_content_element vc_events_carousel align-center">
			
			<div class="custom-event-carousel" <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, $i, '-130' ) : '' ?>>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?> <?php echo esc_attr($autoplay); ?> data-timeout="<?php echo esc_attr($autoplaytimeout); ?>" data-max-items="1" data-center="true" data-autoplay="false" data-item-margin="0">

				<?php foreach ( $this->entries->posts as $entry ): ?>

					<?php
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$venue_details = tribe_get_venue_details($id);
						$start_day = tribe_get_start_date( $id, false, 'M d' );
						$thumbnail_atts = array(
							'alt'	=> trim(strip_tags(get_the_excerpt($id))),
							'title'	=> trim(strip_tags(get_the_title($id)))
						);
					?>

					<div class="event-item"  >
					
                        <div class="event-body" >
							<div class="event-title" <?php echo sprintf('%s', $title_color) ?>><?php echo esc_html($title); ?></div>
                          <h2 class="event-name"><a href="<?php echo esc_url($link); ?>" <?php echo sprintf('%s', $item_title_color) ?>><?php echo esc_html($name); ?></a></h2>
							  <?php if ( tribe_address_exists($id) ) { ?>
                              <div class="event-info-item" <?php echo sprintf('%s', $item_title_color) ?>><i class="icon icon-location"></i><?php echo tribe_get_full_address($id); ?></div>
                              <?php } ?>
                         
                          <a href="<?php echo esc_url($link); ?>" class="btn btn-style-6 btn-medium"><?php echo esc_html__('View Event Details', 'inforward'); ?></a>
                        </div>
                    	
					</div>
					
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>

			</div>
            </div>
	
		</div>

		<?php return ob_get_clean();
	}

}