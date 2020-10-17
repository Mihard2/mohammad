<?php

class WPBakeryShortCode_VC_mad_portfolio extends WPBakeryShortCode {

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
			'sort' => '',
			'align_sort' => 'align-left',
			'align_pagination' => 'align-left',
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'items' 	=> -1,
			'columns' 	=> 2,
			'title_length' 	=> 50,
			'excerpt' 	=> 50,
			'position_info' => 'bottom',
			'show_cat' => 'show',
			'paginate' => 'none',
			'css_animation' => '',
			'animation_delay' => 0,
			'offset' => 0
		), $atts, 'vc_mad_portfolio');

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	protected function sort_links( $entries, $params ) {

		$categories = get_categories(array(
			'taxonomy'	=> 'portfolio_categories',
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
		$item_categories = get_the_terms( $id, 'portfolio_categories' );
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
					'taxonomy' => 'portfolio_categories',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}

		$query = array(
			'post_type' => 'portfolio',
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

			<?php echo ( $sort ) ? $this->sort_links( $this->entries->posts, $atts ) : ""; ?>
			
			<div class="<?php echo esc_attr( trim($css_class) ) ?>" data-isotope-options='{"itemSelector" : ".item","layoutMode" : "fitRows","transitionDuration":"0.7s","fitRows" : {"columnWidth":".item"}}'>

				<?php $i = 1; ?>

					<?php foreach ( $this->loop as $entry ): extract(array_merge($defaults, $entry)); ?>

						<!-- - - - - - - - - - - - - - Project - - - - - - - - - - - - - - - - -->

						<div class="item  <?php echo esc_attr($sort_classes) ?> ">

							<div class="project">

								<div class="project-image">
									<?php echo Inforward_Helper::get_the_post_thumbnail( $id, $image_size, true, array(), array( 'alt' => esc_attr($title) ) ); ?>
										<a title="<?php echo esc_attr($title) ?>"  class="project-link project-action fancybox" <?php echo esc_attr($data_rel) ?> href="<?php echo Inforward_Helper::get_post_featured_image( $id, '' ) ?>" ></a>
                                        <div class="overlay">
                                            <div class="share-wrap style-2">
                                            
                                              <span class="share-title"><?php echo esc_html__('Share this', 'inforward'); ?>:</span>
                                              <ul class="social-icons share">
                                            
                                                <li><a href="<?php echo Inforward_Helper::get_post_featured_image( $id, '' ) ?>" class="sh-facebook share-facebook" target="_blank" title="<?php if(isset($title)) echo esc_attr($title); ?>"><i class="icon-facebook"></i>Facebook</a></li>
                                                <li><a href="<?php echo Inforward_Helper::get_post_featured_image( $id, '' ) ?>" class="sh-twitter share-twitter" target="_blank" title="<?php if(isset($title)) echo esc_attr($title); ?>"><i class="icon-twitter"></i>Twitter</a></li>
                        
                                              </ul>
                        
                                            </div>
                                         </div>
                                         
                                          <?php if ($position_info == 'inner') { ?>
                                            <div class="project-description" >
            
                                              <div class="description-inner">
                                                <?php if($title_length != 0) { ?>
                                                <h5 class="project-title"><a href="<?php echo esc_url($link) ?>"><?php echo inforward_get_excerpt( $title, $title_length ) ?></a></h5>
                                                <?php } ?>
                            
                                                <?php if ( !empty($cur_terms) && $show_cat != 'hide' ): ?>
                                                <ul class="project-cats">
                                                  <?php foreach($cur_terms as $cur_term): ?>
                                                  <li><a href="<?php echo get_term_link( (int) $cur_term->term_id, $cur_term->taxonomy ) ?>"><?php echo esc_html($cur_term->name) ?></a></li>
                                                  <?php endforeach; ?>
                                                </ul>
                                                <?php endif; ?>
                            
                                                <?php 
                                                if($excerpt_length != 0) {
                                                echo inforward_get_excerpt( $post_content, $excerpt_length ); 
                                                }
                                                ?>
                            
                                              </div>
                            
                                            </div>
                                           <?php } ?>
								</div>
                                
                              <?php if ($position_info == 'bottom') { ?>
                                <div class="project-description portfolio_des" >

                                  <div class="description-inner">
                                    
                                     <?php if($title_length != 0) { ?>
                                        <h5 class="project-title"><a href="<?php echo esc_url($link) ?>"><?php echo inforward_get_excerpt( $title, $title_length ) ?></a></h5>
                                     <?php } ?>
                
                					<?php if ( !empty($cur_terms)  && $show_cat != 'hide' ): ?>
                                    <ul class="project-cats">
                                      <?php foreach($cur_terms as $cur_term): ?>
                                      <li><a href="<?php echo get_term_link( (int) $cur_term->term_id, $cur_term->taxonomy ) ?>"><?php echo esc_html($cur_term->name) ?></a></li>
                                      <?php endforeach; ?>
                                    </ul>
                                    <?php endif; ?>
                
                                    <?php 
									if($excerpt_length != 0) {
									echo inforward_get_excerpt( $post_content, $excerpt_length ); 
									}
									?>
                
                                  </div>
                
                                </div>
                               <?php } ?>
                                
							</div>

						</div>

						<!-- - - - - - - - - - - - - - End of Project - - - - - - - - - - - - - - - - -->

						<?php $i++; ?>

					<?php endforeach; ?>

					<?php wp_reset_postdata(); ?>

				

			</div>
			
			<?php if ( $paginate == "pagination" && $inforward_pagination = inforward_pagination($this->entries) ) : ?>
            <div class="<?php echo esc_attr( $align_pagination ) ?>">
				<?php echo wp_kses_post($inforward_pagination); ?>
            </div>
			<?php endif; ?>
			

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
			$this->loop[$key]['cur_terms'] = get_the_terms( $id, 'portfolio_categories' );
			$this->loop[$key]['post_content'] = has_excerpt($id) ? $entry->post_excerpt : '';
		}

	}

}