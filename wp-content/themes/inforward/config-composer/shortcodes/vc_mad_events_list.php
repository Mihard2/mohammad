<?php

class WPBakeryShortCode_VC_mad_events_list extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'item_title_color' => '',
			'title_align' => 'align-left',
			'items' => 3,
			'link' => '',
			'css_animation' => ''
		), $atts, 'vc_mad_events_list' );

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

		if ( ! class_exists( 'Tribe__Events__Main' ) ) {
			echo '<p>'. esc_html__('Install plugin The Events Calendar','inforward').'</p>'; 
			return;
		}
		
		global $inforward_settings;

		$title = $tag_title = $description = $item_title_color = $title_color = $description_color = $columns = $css_animation = '';
		$wrapper_attributes = array();
		$excerpt_count = 20;

		extract($this->atts);

		$css_classes = array(
			'news-list'
		);
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
		
		if ( isset($item_title_color) && !empty($item_title_color) ) {
			$item_title_color = 'style="' . vc_get_css_color( 'color', $item_title_color ) . '"';
		}
		$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
		
		ob_start() ?>

		<div class="wpb_content_element vc_events_list">

			<?php
			echo Inforward_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'tag_title' => $tag_title,
					'description' => '',
					'align' => $title_align,
					'title_color' => $title_color,
					'description_color' => '',
				)
			);
			?>

			<?php if ( empty($this->entries) || empty($this->entries->posts) ) {
				
				echo '<p>'. esc_html__('No matching events listed under Public. Please try viewing the full calendar for a complete list of events.','inforward').'</p>'; 
				
			} else { ?>
			
			<ul <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php foreach ( $this->entries->posts as $entry ): ?>

					<?php
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$venue_details = tribe_get_venue_details($id);
						$start_day = tribe_get_start_date( $id, false, 'd' );
						$start_month = tribe_get_start_date( $id, false, 'M' );
						
						$start_time = tribe_get_start_date( $id, false, $time_format );
						$end_time = tribe_get_end_date( $id, false, $time_format );
					?>

					<li class="event-item" <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, $i, '-130' ) : '' ?>>
					<div class="event-date">
                      <div class="event-month"><?php echo esc_attr($start_month) ?></div>
                      <div class="event-day"><?php echo esc_attr($start_day) ?></div>
                    </div>
                    
                    <div class="event-info">
                        <h6 class="tribe-event-title event-link">
                            <a href="<?php echo esc_url($link); ?>" rel="bookmark" <?php echo sprintf('%s', $item_title_color) ?>><?php echo esc_html($name); ?></a>
                        </h6>
        
                        <?php do_action( 'tribe_events_list_widget_after_the_event_title' ); ?>
                        <!-- Event Time -->
        
                        <?php do_action( 'tribe_events_list_widget_before_the_meta' ) ?>
        
						 <div class="event-info-item">
                            <i class="icon icon-location" <?php echo sprintf('%s', $item_title_color) ?>></i><span><?php echo tribe_get_full_address($id); ?></span>
                        </div>
		
                        <div class="tribe-event-duration event-info-item">
                            <i class="icon icon-clock" <?php echo sprintf('%s', $item_title_color) ?>></i><span><?php echo esc_attr($start_time); ?> - <?php echo esc_attr($end_time); ?></span>
                        </div>
                    </div>
                    	
					</li>
					
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>

			</ul>
			
			<?php } ?>
			
			<?php if ( $use_link ) { 
					$attributes = array();
					$attributes[] = 'href="' . trim( $a_href ) . '"';
					$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
					if ( ! empty( $a_target ) ) {
						$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
					}
					if ( ! empty( $a_rel ) ) {
						$attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
					}
					$attributes = implode( ' ', $attributes );
		
					echo '<a class="info-btn" '. sprintf('%s', $item_title_color) . ' ' . $attributes . '>' . $a_title . '</a>';
			} ?>

		</div>

		<?php return ob_get_clean();
	}

}