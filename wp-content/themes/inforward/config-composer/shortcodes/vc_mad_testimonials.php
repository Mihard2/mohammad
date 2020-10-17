<?php

class WPBakeryShortCode_VC_mad_testimonials extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' 	 => '',
			'tag_title'  => 'h2',
			'description' 	 => '',
			'title_color' => '',
			'description_color' => '',
			'text_color' => '',
			'company_color' => '',
			'title_align' => '',
			'description_align' => '',
			'link' => '',
			'layout' => 'type-1',
			'items' => -1,
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'pagination' => 'no',
			'autoplay' => '',
			'autoplaytimeout' => 5000,
			'css_animation' => ''
		), $atts, 'vc_mad_testimonials');

		$this->query_entries();
		return $this->html();
	}

	public function query_entries() {
		$params = $this->atts;
		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
		if (!$page || $params['pagination'] == 'no') $page = 1;

		$tax_query = array();

		if ( !empty($params['categories']) ) {
			$categories = explode(',', $params['categories']);
			$tax_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'testimonials_category',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}

		$query = array(
			'post_type' => 'testimonials',
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'paged' => $page,
			'posts_per_page' => $params['items'],
			'tax_query' 	 => $tax_query
		);

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		$params = $this->atts;
		$wrapper_attributes = array();
		$layout = $items = $categories = $orderby = $order = $style = $autoplay = $autoplaytimeout = $style_for_company = '';

		$title = $tag_title = $type = $columns = $filter = $pagination = '';
		$description = !empty($params['description']) ? $params['description'] : '';
		$title_color = !empty($params['title_color']) ? $params['title_color'] : '';
		$description_color = !empty($params['description_color']) ? $params['description_color'] : '';
		$text_color = !empty($params['text_color']) ? $params['text_color'] : '';
		$company_color = !empty($params['company_color']) ? $params['company_color'] : '';
		$css_animation = !empty($params['css_animation']) ? $params['css_animation'] : '';
		
		$title_align = !empty($params['title_align']) ? $params['title_align'] : '';
		$description_align = !empty($params['description_align']) ? $params['description_align'] : '';

		extract($this->atts);

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
		
		
		$css_classes = array(
			'testimonial', $layout
		);
		if ( $layout == 'type-1' || $layout == 'type-2' ) {
			$css_classes[] = 'testimonial-single';
		}

		if ( $text_color ) {
			$style = 'style="' . vc_get_css_color( 'color', $text_color ) . '"';
		}

		if ( $company_color ) {
			$style_for_company = 'style="' . vc_get_css_color( 'color', $company_color ) . '"';
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, 0 );
		}

		ob_start(); ?>

		<div class="wpb_content_element">

			<?php
			echo Inforward_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'tag_title' => $tag_title,
					'description' => $description,
					'title_color' => $title_color,
					'align' => $title_align,
					'align_des' => $description_align,
					'description_color' => $description_color,
				)
			);
			
			?>

				<?php if ( $layout == 'type-1' ): 
				$testimonials_btn_class = 'btn type-2 btn-style-6 btn-size';
				?>

					<?php foreach ( $this->entries->posts as $entry ):
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$company = get_post_meta( $id, 'inforward_tm_company', true );
						$content = has_excerpt($id) ? apply_filters( 'the_excerpt', $entry->post_excerpt ) : $entry->post_content;
						$alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
						if ( empty($alt) ) {
							$attachment = get_post($id);
							$alt = trim(strip_tags($attachment->post_title));
						}
						$thumbnail_atts = array(
							'title'	=> trim(strip_tags($entry->post_title)),
							'alt' => $alt
						);
						?>

						<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

							<div class="author-box">

								<?php if ( has_post_thumbnail($id) ): ?>

									<a href="<?php echo esc_url($link) ?>" class="avatar">
										<?php echo Inforward_Helper::get_the_post_thumbnail( $id, 'inforward-testimonial', true, '', $thumbnail_atts ) ?>
									</a>

								<?php endif; ?>

								

							</div>

							<div class="testimonial-holder">
							<blockquote <?php echo sprintf('%s', $style) ?>><?php echo do_shortcode($content); ?></blockquote>
                            	<div class="author-info">

									<h6 class="author-name" <?php echo sprintf('%s', $style) ?> ><?php echo esc_html($name) ?></h6>
									<span class="author-position" <?php echo sprintf('%s', $style_for_company) ?>><?php echo esc_html($company) ?></span>

								</div>
							</div>

						</div>

					<?php endforeach; ?>

				<?php elseif ( $layout == 'type-2' ): 
				$testimonials_btn_class = 'btn';
				?>

				<div class="carousel-type-1 testimonial-type-2">
				<div class="owl-carousel" data-max-items="1" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-timeout="<?php echo esc_attr($autoplaytimeout); ?>" >
				
					<?php foreach ( $this->entries->posts as $entry ):
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$company = get_post_meta( $id, 'inforward_tm_company', true );
						$content = has_excerpt($id) ? apply_filters( 'the_excerpt', $entry->post_excerpt ) : $entry->post_content;
						$alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
						if ( empty($alt) ) {
							$attachment = get_post($id);
							$alt = trim(strip_tags($attachment->post_title));
						}
						$thumbnail_atts = array(
							'title'	=> trim(strip_tags($entry->post_title)),
							'alt' => $alt
						);
						?>
						<div class="item-carousel">
                        <div class="testimonial testimonial-single">
						
							<div class="author-box">
								<?php if ( has_post_thumbnail($id) ): ?>

									<a href="<?php echo esc_url($link) ?>" class="avatar">
										<?php echo Inforward_Helper::get_the_post_thumbnail( $id, 'inforward-testimonial', true, '', $thumbnail_atts ) ?>
									</a>

								<?php endif; ?>
							</div>
                            
                            <div class="testimonial-holder">
								<blockquote <?php echo sprintf('%s', $style) ?>><?php echo do_shortcode($content); ?></blockquote>
								
								<div class="author-info">
									<h6 class="author-name" <?php echo sprintf('%s', $style) ?> ><?php echo esc_html($name) ?></h6>
									<span class="author-position" <?php echo sprintf('%s', $style_for_company) ?>><?php echo esc_html($company) ?></span>
								</div>
							</div>

						</div>
                        </div>

					<?php endforeach; ?>
					
					</div>
					</div>
					
				<?php elseif ( $layout == 'type-3' ): 
				$testimonials_btn_class = 'btn';
				?>

				<div class="carousel-type-1 testimonial-type-3">
				<div class="owl-carousel" data-max-items="2" data-item-margin="80" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-timeout="<?php echo esc_attr($autoplaytimeout); ?>" >
				
					<?php foreach ( $this->entries->posts as $entry ):
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$company = get_post_meta( $id, 'inforward_tm_company', true );
						$content = has_excerpt($id) ? apply_filters( 'the_excerpt', $entry->post_excerpt ) : $entry->post_content;
						$alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
						if ( empty($alt) ) {
							$attachment = get_post($id);
							$alt = trim(strip_tags($attachment->post_title));
						}
						$thumbnail_atts = array(
							'title'	=> trim(strip_tags($entry->post_title)),
							'alt' => $alt,
							'width' => '90',
							'height' => '90'
						);
						?>
						<div class="item-carousel">
                        <div class="testimonial">
						
							<div class="testimonial-holder">
								<blockquote <?php echo sprintf('%s', $style) ?>><?php echo do_shortcode($content); ?></blockquote>
							</div>

							<div class="author-box">
								<?php if ( has_post_thumbnail($id) ): ?>

									<a href="<?php echo esc_url($link) ?>" class="avatar">
										<?php echo Inforward_Helper::get_the_post_thumbnail( $id, 'thumbnail', true, '', $thumbnail_atts ) ?>
									</a>

								<?php endif; ?>

								<div class="author-info">
									<h6 class="author-name" <?php echo sprintf('%s', $style) ?> ><?php echo esc_html($name) ?></h6>
									<span class="author-position" <?php echo sprintf('%s', $style_for_company) ?>><?php echo esc_html($company) ?></span>
								</div>

							</div>

						</div>
                        </div>

					<?php endforeach; ?>
					
					</div>
					</div>
					
					<?php endif; ?>

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
					
								echo '<div class="testimonials-btn testimonials-btn-'. $layout .' '. $title_align .'"><a class="'. $testimonials_btn_class .'" ' . $attributes . '>' . $a_title . '</a></div>';
						} ?>
				
		</div>		

		<?php return ob_get_clean();
	}

}