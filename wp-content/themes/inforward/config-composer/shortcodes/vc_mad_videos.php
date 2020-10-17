<?php

class WPBakeryShortCode_VC_mad_videos extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';
	public $settings = array();

	protected function content($atts, $content = null) {

		global $inforward_config;
		$sidebar_position = isset($inforward_config['sidebar_position']) ? $inforward_config['sidebar_position'] : 'cp-no-sidebar';

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'description' => '',
			'title_color' => '',
			'description_color' => '',
			'layout' => 'cp-type-1',
			'sort' => '',
			'align_sort' => 'align-left',
			'align_pagination' => 'align-left',
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'items' 	=> -1,
			'columns' 	=> 2,
			'paginate' => 'none',
			'css_animation' => '',
			'animation_delay' => 0,
			'offset' => 0
		), $atts, 'vc_mad_videos');

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	protected function sort_links( $entries, $params ) {

		$categories = get_categories(array(
			'taxonomy'	=> 'video_categories',
			'hide_empty'=> 0
		));
		$current_cats = array();
		$display_cats = is_array($params['categories']) ? $params['categories'] : array_filter(explode(',', $params['categories']));
		$align_sort = !empty($params['align_sort']) ? $params['align_sort'] : 'align-left';

		foreach ( $entries as $entry ) {
			if ( $current_item_cats = get_the_terms( $entry->ID, 'portfolio_categories' ) ) {
				if ( !empty($current_item_cats) ) {
					foreach ($current_item_cats as $current_item_cat) {
						if (empty($display_cats) || in_array($current_item_cat->term_id, $display_cats)) {
							$current_cats[$current_item_cat->term_id] = $current_item_cat->term_id;
						}
					}
				}
			}
		}

		$css_classes = array(
			'cp-filter', $align_sort
		);

		$wrapper_attributes = array();
		if ( '' !== $params['css_animation'] ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $params['css_animation'], 0, '-80' );
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

		ob_start(); ?>

		<!-- - - - - - - - - - - - - - Filter - - - - - - - - - - - - - - - - -->

		<div id="options" class="<?php echo esc_attr( trim($css_class) ) ?>" <?php echo implode( ' ', $wrapper_attributes ) ?>>
			<div id="filters" class="isotope-nav">
			    <button class="is-checked" data-filter="*"><?php esc_html_e('All', 'inforward') ?></button>

				<?php foreach ( $categories as $category ): ?>
					<?php if ( in_array($category->term_id, $current_cats) ): ?>
						<?php $nicename = str_replace('%', '', $category->category_nicename); ?>
						<button data-filter=".<?php echo esc_attr($nicename) ?>"><?php echo esc_html(trim($category->cat_name)); ?></button>
					<?php endif; ?>

				<?php endforeach ?>

			</div>
		</div>

		<!-- - - - - - - - - - - - - - End of Filter - - - - - - - - - - - - - - - - -->

		<?php return ob_get_clean();
	}

	public function get_sort_class( $id ) {
		$classes = "";
		$item_categories = get_the_terms( $id, 'video_categories' );
		if ( is_object($item_categories) || is_array($item_categories) ) {
			foreach ( $item_categories as $cat ) {
				$classes .= $cat->slug . ' ';
			}
		}
		return str_replace( '%', '', $classes );
	}

	public function query_entries($params = array()) {

		if ( empty($params) ) $params = $this->atts;

		$tax_query = array();

		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
		if ( !$page || $params['paginate'] == 'none' ) $page = 1;

		if ( !empty($params['categories']) ) {
			$categories = explode(',', $params['categories']);
			$tax_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'video_categories',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}

		$query = array(
			'post_type' => 'video',
			'post_status'  => 'publish',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'paged' => $page,
			'tax_query' => $tax_query
		);

		$this->entries = new WP_Query($query);
		$this->prepare_entries($params);
	}

	public function html() {

		if ( empty($this->loop) ) return;

		$atts = $this->atts;
		$attributes = $wrapper_attributes = array();
		$title = !empty($atts['title']) ? $atts['title'] : '';
		$tag_title = !empty($atts['tag_title']) ? $atts['tag_title'] : 'h2';
		$description = !empty($atts['description']) ? $atts['description'] : '';
		$title_color = !empty($atts['title_color']) ? $atts['title_color'] : '';
		$description_color = !empty($atts['description_color']) ? $atts['description_color'] : '';
		$sort = $atts['sort'] == 'yes' ? true : false;
		$css_animation = !empty($atts['css_animation']) ? $atts['css_animation'] : '';
		$paginate = !empty($atts['paginate']) ? $atts['paginate'] : 'pagination';
		$show_cat = !empty($atts['show_cat']) ? $atts['show_cat'] : 'show';
		$data_rel = 'data-fancybox=group';
		$columns = !empty($atts['columns']) ? $atts['columns'] : 2;
		$excerpt_length = !empty($atts['excerpt']) ? $atts['excerpt'] : 0;
		$title_length = !empty($atts['title_length']) ? $atts['title_length'] : 0;
		$align_pagination = !empty($atts['align_pagination']) ? $atts['align_pagination'] : 'align-left';
		$position_info = !empty($atts['position_info']) ? $atts['position_info'] : 'bottom';
		$image_size = '';
		$layout = !empty($atts['layout']) ? $atts['layout'] : 'cp-type-1';

		$defaults = array(
			'id' => '',
			'link' => '',
			'sort_classes' => '',
			'cur_terms' => ''
		);

		$css_classes = array(
			'isotope',
			'clearfix',
			'portfolio-holder',
			'video-holder',
			'cp-paginate-' . $paginate
		);
		
		switch ( $columns ) {
				case '2':
				$css_classes[] = 'two-collumn';
				$image_size = array(555, 380);
				break;
				
				case '3':
				$css_classes[] = 'three-collumn';
				$image_size = array(555, 380);
				break;
				
				case '4':
				$css_classes[] = 'fourth-collumn';
				$image_size = array(555, 380);
				break;
				
			}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

		if ( '' !== $css_animation ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $css_animation, 0, '20' );
		}

		ob_start(); ?>

		<div class="wpb_content_element portfolio_block">

			<?php
			echo Inforward_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'tag_title' => $tag_title,
					'description' => $description,
					'title_color' => $title_color,
					'description_color' => $description_color,
				)
			);
			?>

			<?php if ($layout == 'cp-type-1' ) { ?>

				<?php echo ( $sort ) ? $this->sort_links( $this->entries->posts, $atts ) : ""; ?>
			
			<div class="<?php echo esc_attr( trim($css_class) ) ?>" data-isotope-options='{"itemSelector" : ".item","layoutMode" : "fitRows","transitionDuration":"0.7s","fitRows" : {"columnWidth":".item"}}'>

				<?php $i = 1; ?>

					<?php foreach ( $this->loop as $entry ): extract(array_merge($defaults, $entry)); ?>

						<!-- - - - - - - - - - - - - - Project - - - - - - - - - - - - - - - - -->

						<div class="item  <?php echo esc_attr($sort_classes) ?> ">

							<div class="project">

								<div class="project-image">
									
                                        <?php echo sprintf( '%s', $before_content ) ?>
                                       
								</div>
                                 
							</div>

						</div>

						<!-- - - - - - - - - - - - - - End of Project - - - - - - - - - - - - - - - - -->

						<?php $i++; ?>

					<?php endforeach; ?>

					<?php wp_reset_postdata(); ?>

				

			</div>
			
				<?php if ( $paginate == "pagination" && $inforward_pagination = inforward_pagination($this->entries) ) : ?>
                <div class="<?php echo esc_attr( $align_pagination ) ?>">
                    <?php echo  wp_kses_post($inforward_pagination); ?>
                </div>
                <?php endif; ?>
			
            <?php } elseif ($layout == 'cp-type-2' ) { ?>
            
            <?php $i = 1; ?>
			<div class="row videos_tab_list">
				
                <?php foreach ( $this->loop as $entry ): extract(array_merge($defaults, $entry)); ?>
				
					<?php if($i == 1 ) { ?>
                    <div class="col-md-8 col-sm-12">
                    <div class="entry entry-big">
                    
                    	<div class="entry-attachment">
                         <?php echo sprintf( '%s', $before_content ) ?>
                        </div>
                        
                        <div class="entry-body">
                            <h4 class="entry-title">
                            <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                            </h4>
                            
                            <div class="entry-meta">
                              <time class="entry-date" datetime="<?php echo esc_attr(get_the_date( 'c', $id )) ?>"><?php echo esc_attr(get_the_date( 'M d, Y', $id )) ?></time>
                            </div>
                            
                        </div>
                    
                    </div>
                    </div>
                    <?php } else { ?>
                    <div class="col-md-4 col-sm-12">
                    <div class="entry entry-small">
                
                		<div class="entry-attachment">
                         <?php echo sprintf( '%s', $before_content ) ?>
                        </div>
                        <div class="entry-body">
                            <h4 class="entry-title">
                            <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                            </h4>
                            
                            <div class="entry-meta">
                              <time class="entry-date" datetime="<?php echo esc_attr(get_the_date( 'c', $id )) ?>"><?php echo esc_attr(get_the_date( 'M d, Y', $id )) ?></time>
                            </div>
                            
                        </div>
                        
                     </div>
                     </div>
					<?php } ?>
                    
                    <?php $i++; ?>
                    <?php endforeach; ?>

				<?php wp_reset_postdata(); ?>
                    
            </div>
			<?php } ?>

		</div>

		<?php return ob_get_clean();
	}

	public function prepare_entries($params) {
		$this->loop = array();

		if ( empty($params )) $params = $this->atts;
		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		foreach ($this->entries->posts as $key => $entry) {
			$this->loop[$key]['id'] = $id = $entry->ID;
			$this->loop[$key]['link'] = get_permalink($id);
			$this->loop[$key]['title'] = get_the_title($id);
			$this->loop[$key]['sort_classes'] = $this->get_sort_class($id);
			$this->loop[$key]['content'] = $entry->post_content;
			$this->loop[$key]['cur_terms'] = get_the_terms( $id, 'video_categories' );
			$format = 'video';
			$this_post = apply_filters( 'inforward-entry-format-'. $format, $this->loop[$key] );
			$this->loop[$key]['post_content'] = $this_post['content'];
			if ( isset($this_post['before_content']) && !empty($this_post['before_content']) ) {
				$this->loop[$key]['before_content'] = $this_post['before_content'];
			}
		}

	}

}