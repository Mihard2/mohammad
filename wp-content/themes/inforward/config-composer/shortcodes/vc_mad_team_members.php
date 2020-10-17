<?php

class WPBakeryShortCode_VC_mad_team_members extends WPBakeryShortCode {

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
			'enable_social' => '',
			'columns' => 2,
			'items' => -1,
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'css_animation' => ''
		), $atts, 'vc_mad_team_members' );

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
					'taxonomy' => 'team_category',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}

		$query = array(
			'post_type' => 'team-members',
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

		$title = $excerpt = $carousel = $tag_title = $description = $title_color = $description_color = $columns = $css_animation = '';
		$wrapper_attributes = array();
		
		$excerpt_count = '120';
		
		extract($this->atts);

		$css_classes = array(
			'team-holder'
		);
		
		$column_class = '';
		switch ( $columns ) {
				case '2':
				$column_class = 'col-sm-6 col-xs-6';
				break;
				
				case '3':
				$column_class = 'col-md-4 col-sm-4 col-xs-6';
				break;
				
				case '4':
				$column_class = 'col-md-3 col-sm-3 col-xs-6';
				break;
			}

		$image_size = 'full';
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
		
		$title_align = !empty($title_align) ? $title_align : '';
		$description_align = !empty($description_align) ? $description_align : '';

		ob_start() ?>

		<div class="wpb_content_element sp_team_members_section">

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
			<div class="carousel-type-2">
				
				<div class="owl-carousel team-holder" data-max-items="<?php echo absint($columns); ?>" data-item-margin="30">
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
			
					<div class="item-carousel">
					<div class="team-item">
					<div class="team-member">

						<!-- - - - - - - - - - - - - - Member Photo - - - - - - - - - - - - - - - - -->

						<?php if ( has_post_thumbnail($id) ): ?>

								<a href="<?php echo esc_url($link); ?>" class="member-photo">
									<?php echo Inforward_Helper::get_the_post_thumbnail ( $id, $image_size, false, array(), $thumbnail_atts ) ?>
								</a>

						<?php endif; ?>

						<!-- - - - - - - - - - - - - - End of Member Photo - - - - - - - - - - - - - - - - -->

						<div class="member-info">

							<h5 class="member-name">
								<a href="<?php echo esc_url($link); ?>"><?php echo esc_html($name); ?></a>
							</h5>

							<?php if ( !empty($position) ): ?>
								<h6 class="member-position"><?php echo esc_html($position) ?></h6>
							<?php endif; ?>

							<!-- - - - - - - - - - - - - - About Member - - - - - - - - - - - - - - - - -->
							<?php if ( $excerpt ): ?>

							<div class="cp-member-about"><?php echo apply_filters( 'the_content', $content ); ?></div>

							<?php endif; ?>
							<!-- - - - - - - - - - - - - - End of About Member - - - - - - - - - - - - - - - - -->

						</div>
						
                        <?php if ( $enable_social ): ?>
							<?php echo inforward_team_members_social_links($id); ?>
                        <?php endif; ?>

					</div>
					</div>
					</div>
			
				<?php endforeach; ?>
				</div>
				
			</div>
			<?php } else { ?>
			
			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>
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

					<div class="team-item <?php echo esc_attr($column_class); ?>" <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, $i, '-130' ) : '' ?>>
                    <div class="team-member">

						<!-- - - - - - - - - - - - - - Member Photo - - - - - - - - - - - - - - - - -->

						<?php if ( has_post_thumbnail($id) ): ?>

								<a href="<?php echo esc_url($link); ?>" class="member-photo">
									<?php echo Inforward_Helper::get_the_post_thumbnail ( $id, $image_size, false, array(), $thumbnail_atts ) ?>
								</a>

						<?php endif; ?>

						<!-- - - - - - - - - - - - - - End of Member Photo - - - - - - - - - - - - - - - - -->

						<div class="member-info">

							<h5 class="member-name">
								<a href="<?php echo esc_url($link); ?>"><?php echo esc_html($name); ?></a>
							</h5>

							<?php if ( !empty($position) ): ?>
								<h6 class="member-position"><?php echo esc_html($position) ?></h6>
							<?php endif; ?>

							<!-- - - - - - - - - - - - - - About Member - - - - - - - - - - - - - - - - -->
							<?php if ( $excerpt ): ?>

							<div class="cp-member-about"><?php echo apply_filters( 'the_content', $content ); ?></div>

							<?php endif; ?>
							<!-- - - - - - - - - - - - - - End of About Member - - - - - - - - - - - - - - - - -->

						</div>
						
						<?php echo inforward_team_members_social_links($id); ?>

					</div>
                    </div>

					<?php $i = $i + 100; ?>

				<?php endforeach; ?>

			</div>
            </div>
			
			<?php } ?>

		</div>

		<?php return ob_get_clean();
	}

}