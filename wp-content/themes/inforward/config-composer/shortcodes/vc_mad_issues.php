<?php

class WPBakeryShortCode_VC_mad_issues extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'excerpt' => '',
			'tag_title' => 'h2',
			'description' => '',
			'title_color' => '',
			'description_color' => '',
			'title_align' => '',
			'description_align' => '',
			'carousel' => '',
			'columns' => 3,
			'items' => 3,
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'link_more' => '',
			'css_animation' => ''
		), $atts, 'vc_mad_issues' );

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	public function query_entries() {
		$params = $this->atts;
		$tax_query = array();

		if ( !empty($params['categories']) ) {
			$categories = explode(',', $params['categories']);
			$tax_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'issues_category',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}

		$query = array(
			'post_type' => 'issues',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'tax_query' => $tax_query
		);

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		global $inforward_settings;

		$title = $link_more = $excerpt = $carousel = $tag_title = $description = $title_color = $description_color = $columns = $css_animation = '';
		$wrapper_attributes = array();
		
		$excerpt_count = '120';
		
		extract($this->atts);

		switch ( $columns ) {
			case '3':
			$css_classes[] = 'col-md-4 col-xs-6';
			break;
			
			case '4':
			$css_classes[] = 'col-md-3 col-xs-6';
			break;
			
		}

		$image_size = 'inforward-portfolio-small-image';
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
		
		$title_align = !empty($title_align) ? $title_align : '';
		$description_align = !empty($description_align) ? $description_align : '';

		$custom_links = ( '||' === $link_more ) ? '' :$link_more;
		$custom_links = vc_build_link( $link_more );
		$use_link = false;
		if ( strlen( $custom_links['url'] ) > 0 ) {
			$use_link = true;
			$a_href = $custom_links['url'];
			$a_title = $custom_links['title'];
			$a_target = $custom_links['target'];
			$a_rel = $custom_links['rel'];
		}

		ob_start() ?>

		<div class="wpb_content_element sp_issues_section">

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

			<?php if ( $carousel ) { ?>
			<div class="carousel-type-2 content-element2">
				<div class="owl-carousel content-element2" data-max-items="<?php echo absint($columns); ?>" data-item-margin="30">
			    <?php foreach ( $this->entries->posts as $entry ): ?>
				<?php
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$content = has_excerpt($id) ? $entry->post_excerpt : $entry->post_content;
						$thumbnail_atts = array(
							'alt'	=> trim(strip_tags($entry->post_title))
						);
						$content = inforward_get_excerpt( $content, $excerpt_count );
				?>
			
					<div class="item-carousel">
					<div class="issue-item">
					
					
						<?php if ( has_post_thumbnail($id) ): ?>
                        <figure>
						<a href="<?php echo esc_url($link); ?>" alt="" >
							<?php echo Inforward_Helper::get_the_post_thumbnail ( $id, $image_size, false, array(), $thumbnail_atts ) ?>
						</a>
                        </figure>
						<?php endif; ?>
						
							<h5 class="issue-name"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($name); ?></a></h5>
							
							<?php if ( $excerpt ): ?>

							<div class="cp-member-about"><?php echo apply_filters( 'the_content', $content ); ?></div>

							<?php endif; ?>
							
						<?php echo '<a href="'. esc_url($link) .'" class="info-btn">'. esc_html__('Read More','inforward') .'</a>'; ?>
					
					</div>
					</div>
			
				<?php endforeach; ?>
				</div>
				
			</div>
			<?php } else { ?>
			<div class="issues-container">
            <div class="row flex-row">

				<?php $i = 0; ?>

				<?php foreach ( $this->entries->posts as $entry ): ?>

					<?php
						$id = $entry->ID;
						$name = get_the_title($id);
						$link  = get_permalink($id);
						$position = get_post_meta($id, 'inforward_tm_position', true);
						$content = has_excerpt($id) ? $entry->post_excerpt : $entry->post_content;
						$thumbnail_atts = array(
							'alt'	=> trim(strip_tags($entry->post_title))
						);
						$content = inforward_get_excerpt( $content, $excerpt_count );
					?>

					<div <?php echo implode( ' ', $wrapper_attributes ) ?> <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, $i, '-130' ) : '' ?>>
                    <div class="issue-item">

						<!-- - - - - - - - - - - - - - Member Photo - - - - - - - - - - - - - - - - -->

						<?php if ( has_post_thumbnail($id) ): ?>
						<figure>
						<a href="<?php echo esc_url($link); ?>" alt="" >
							<?php echo Inforward_Helper::get_the_post_thumbnail ( $id, $image_size, false, array(), $thumbnail_atts ) ?>
						</a>
                        </figure>
						<?php endif; ?>

						<!-- - - - - - - - - - - - - - End of Member Photo - - - - - - - - - - - - - - - - -->
						
                        <h5 class="issue-name"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($name); ?></a></h5>
							
							<?php if ( $excerpt ): ?>

							<div class="cp-member-about"><?php echo apply_filters( 'the_content', $content ); ?></div>

							<?php endif; ?>
							
						<?php echo '<a href="'. esc_url($link) .'" class="info-btn">'. esc_html__('Read More','inforward') .'</a>'; ?>

					</div>
                    </div>
					<?php $i = $i + 100; ?>

				<?php endforeach; ?>

			</div>
            </div>
			
			<?php } ?>
            
            <?php 
			if ( $use_link ) { 
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
		
					echo '<div class="align-center"><a class="btn" ' . $attributes . '>' . $a_title . '</a></div>';
			} ?>

		</div>

		<?php return ob_get_clean();
	}

}