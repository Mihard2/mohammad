<?php

class WPBakeryShortCode_VC_mad_events_slider extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'tag_title' => 'h2',
			'title_color' => '',
			'item_title_color' => '#fff',
			'item_bg_color' => '#bf0d3e',
			'btn_bg_color' => '#bf0d3e',
			'btn_title_color' => '#bf0d3e',
			'title_align' => 'align-left',
			'items' => 3,
			'css_animation' => ''
		), $atts, 'vc_mad_events_slider' );

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

		$title = $tag_title = $description = $item_title_color = $item_bg_color = $btn_bg_color = $btn_title_color = $title_color = $description_color = $columns = $css_animation = '';
		$wrapper_attributes = array();
		$excerpt_count = 20;

		extract($this->atts);

		$css_classes = array(
			'owl-carousel owl-theme ls_none'
		);
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( isset($item_title_color) && !empty($item_title_color) ) {
			$item_bg_color_opacity = Inforward_Helper::hex2rgba( $item_bg_color, '0.8' );
			$item_bg_color = 'style="' . vc_get_css_color( 'color', $item_title_color ) . '' . vc_get_css_color( 'background', $item_bg_color_opacity ) .'"';
			$item_title_color = 'style="' . vc_get_css_color( 'color', $item_title_color ) . '"';
		}		
		$btn_shadow_opacity = Inforward_Helper::hex2rgba( $btn_bg_color, '0.4' );
		ob_start() ?>

		<div class="wpb_content_element vc_events_slider">

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

			<style>
				.vc_events_slider .event-carousel .owl-dots .owl-dot.active {
					background: <?php echo $btn_bg_color ?>;
					color: #fff;
				}
				.vc_events_slider .event-carousel .owl-dots .owl-dot {
					color: <?php echo $btn_title_color ?>;
				}
				.event-carousel .owl-dots .owl-dot.active, .event-carousel .owl-carousel .owl-nav > *:hover{
					background: <?php echo $btn_bg_color ?>;
					color: #fff;
					webkit-box-shadow: 0px 10px 25px -5px <?php echo $btn_shadow_opacity ?>;
					-moz-box-shadow: 0px 10px 25px -5px <?php echo $btn_shadow_opacity ?>;
					box-shadow: 0px 10px 25px -5px <?php echo $btn_shadow_opacity ?>;
				}
				.event-carousel .owl-dots .owl-dot, .event-carousel .owl-nav > *{
					color: <?php echo $btn_bg_color ?>;
				}
			</style>
			
			<div class="event-carousel" <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, $i, '-130' ) : '' ?>>

			<ul <?php echo implode( ' ', $wrapper_attributes ) ?> data-max-items="1" data-dots="item_dots" data-autoplay="true" >

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

					<li class="event-item" data-dot="<?php echo esc_attr($start_day); ?>"  >
					
                    	<?php if ( has_post_thumbnail($id) ) { ?>
                            <?php 
							$thumbnail = Inforward_Helper::get_the_post_thumbnail( $id, 'inforward-post-grid', true, '', $thumbnail_atts );
							echo wp_kses_post($thumbnail);
							?>
                        <?php } else { 
						$default_src = vc_asset_url( 'vc/no_image.png' );
						echo '<img width="768" height="300" class="vc_img-placeholder" src="' . $default_src . '" />';
						}
						?>
                        
                        <div class="event-body" <?php echo sprintf('%s', $item_bg_color) ?>>
                          <h5 class="event-link"><a href="<?php echo esc_url($link); ?>" <?php echo sprintf('%s', $item_title_color) ?>><?php echo esc_html($name); ?></a></h5>
							  <?php if ( tribe_address_exists($id) ) { ?>
                              <div class="event-info-item"><i class="icon icon-location"></i><?php echo tribe_get_full_address($id); ?></div>
                              <?php } ?>
                          <div class="event-info-item"><i class="icon icon-clock"></i><?php echo tribe_events_event_schedule_details($id); ?></div>
                          <a href="<?php echo esc_url($link); ?>" <?php echo sprintf('%s', $item_title_color) ?> class="info-btn"><?php echo esc_html__('View Event Details', 'inforward'); ?></a>
                        </div>
                    	
					</li>
					
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>

			</ul>
            </div>
	
		</div>

		<?php return ob_get_clean();
	}

}