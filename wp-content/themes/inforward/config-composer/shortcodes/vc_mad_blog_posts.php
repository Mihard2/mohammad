<?php

class WPBakeryShortCode_VC_mad_blog_posts extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'tag_title' => 'h2',
			'description' => '',
			'title_color' => '',
			'title_align' => '',
			'btn_align' => '',
			'layout' => 'cp-type-2',
			'carousel' => '',
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'columns' => 3,
			'items' => 8,
			'ignore_sticky_posts' => 0,
			'paginate' => 'none',
			'paginate_align' => '',
			'custom_links' => '',
			'css_animation' => ''
		), $atts, 'vc_mad_blog_posts');

		$this->query_entries();
		$html = $this->html();

		return $html;
	}


	public function query_entries() {

		$params = $this->atts;

		$query = array(
			'post_type' => 'post',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'ignore_sticky_posts'=> $params['ignore_sticky_posts'],
			'post_status' => array('publish')
		);

		if ( !empty($params['categories']) ) {
			$categories = explode(',', $params['categories']);
			$query['category__in'] = $categories;
		}

		$paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
		$query['paged'] = $paged;

		$this->entries = new WP_Query($query);
		$this->prepare_entries($params);
	}

	public function html() {

		if ( empty($this->loop) ) return;

		global $inforward_settings;
		$entries = $this->entries;
		$params = $this->atts;

		$post_loop = 1;
		$wrapper_attributes = array();
		$title = !empty($params['title']) ? $params['title'] : '';
		$tag_title = !empty($params['tag_title']) ? $params['tag_title'] : 'h2';
		$title_color = !empty($params['title_color']) ? $params['title_color'] : '';
		$title_align = !empty($params['title_align']) ? $params['title_align'] : '';
		$css_animation = !empty($params['css_animation']) ? $params['css_animation'] : '';

		$layout = $columns = $carousel = $custom_links = $paginate = $before_content = $content = '';

		extract($params);
		$atts = array();
		
		$custom_links = ( '||' === $custom_links ) ? '' : $custom_links;
		$custom_links = vc_build_link( $custom_links );
		$use_link = false;
		if ( strlen( $custom_links['url'] ) > 0 ) {
			$use_link = true;
			$a_href = $custom_links['url'];
			$a_title = $custom_links['title'];
			$a_target = $custom_links['target'];
			$a_rel = $custom_links['rel'];
		}

		$defaults = array(
			'id' => '', 'link' => '', 'title' => 10, 'post_format' => '', 'format_class' => '', 'item_size' => '', 'content' => '', 'image_size' => '', 'post_content' => '', 'before_content' => ''
		);

		$css_classes = array(
			'events-holder',
			$layout,
			'cp-paginate-' . $paginate
		);
		$css_container = '';

		switch ( $layout ) {
			case 'cp-type-1':
				if ( !$carousel ) {
					$css_classes[] = 'blog-type-grid';
					$css_classes[] = 'isotope';
					$css_classes[] = 'portfolio-holder';
					$css_classes[] = 'type-2';
					$css_classes[] = 'clearfix';
					$atts['isotope-options'] = '{"itemSelector" : ".item","layoutMode" : "masonry","transitionDuration":"0.7s","masonry" : {"columnWidth":".item"}}';
					switch ( $columns ) {
						case '2':
						$css_classes[] = 'two-collumn';
						break;
						
						case '3':
						$css_classes[] = 'three-collumn';
						break;
						
						case '4':
						$css_classes[] = 'fourth-collumn';
						break;
						
					}
				$btn_class= "btn type-2 btn-style-6";
					
				} else{
					$css_classes[] = 'carousel-type-2';
					$css_container = 'owl-custom';
					$btn_class= "btn no-shadow";
				}
				
				$excerpt_count_blog = $inforward_settings['excerpt-count-small-thumbs'];

				break;
			case 'cp-type-2':
				$css_classes[] = 'blog-type-list';
				$columns = 1;
				$btn_class= "btn type-2 btn-style-6";
				$excerpt_count_blog = $inforward_settings['excerpt-count-big-thumbs'];

				break;
			
			case 'cp-type-3':
				$css_classes[] = 'blog-type-widget widget-holder';
				$columns = 1;
				$btn_class= "btn type-2 btn-style-6";
				$excerpt_count_blog = 0;

				break;	
				
			case 'cp-type-4':
				$css_classes[] = 'blog-type-widget2 events-holder';
				$columns = 1;
				$btn_class= "btn align-center";
				$excerpt_count_blog = $inforward_settings['excerpt-count-small-thumbs'];

				break;	
				
				case 'cp-type-5':
				$css_classes[] = 'row';
				$columns = 1;
				$btn_class= "btn align-center";
				$excerpt_count_blog = $inforward_settings['excerpt-count-small-thumbs'];

				break;	
				
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
		$wrapper_attributes[] = inforward_create_data_string($atts);
		
		ob_start(); ?>

		<div class="wpb_content_element cp-blog-posts <?php echo esc_attr($css_container); ?>">

			<?php
			echo Inforward_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'tag_title' => $tag_title,
					'description' => '',
					'title_color' => $title_color,
					'align' => $title_align,
					'description_color' => '',
				)
			);
			?>

			<?php $i = 1; ?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				

				<?php if ( $carousel && $layout == 'cp-type-1' ): ?>
					<div class="owl-carousel owl-theme widget-holder style-3" data-max-items="<?php echo absint($columns) ?>" data-item-margin="30">
				<?php endif; ?>

					<?php foreach ( $this->loop as $entry ): extract( array_merge($defaults, $entry) ); ?>

						<?php switch ( $layout ):

							case 'cp-type-1': ?>

								<?php if ( !$carousel ) { ?>
                                <div id="post-<?php echo (int) $id; ?>" class="item <?php echo esc_attr($format_class) ?> <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, 0, '' ) : '' ?> ">
                               

										<!-- - - - - - - - - - - - - - Attachment - - - - - - - - - - - - - - - - -->

										<?php if ( !empty($before_content) && $post_format != 'link' && $post_format != 'quote' ): ?>

											<div class="entry-attachment">
												<?php echo sprintf( '%s', $before_content ) ?>
											</div>

										<?php endif; ?>

										<!-- - - - - - - - - - - - - - End of Attachment - - - - - - - - - - - - - - - - -->

										<!-- - - - - - - - - - - - - - Entry body - - - - - - - - - - - - - - - - -->
										<div class="event-info">
											<?php  if($post_format != 'link' && $post_format != 'quote') { ?>
                                            <h5 class="cp-post-title event-link">
                                                <?php if ( is_sticky($id) ): ?>
                                                    <?php printf( '<span class="sticky-post label">%s</span>', esc_html__( 'Featured', 'inforward' ) ); ?>
                                                <?php endif; ?>

                                                <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                                            </h5>
                                            <?php  } ?>

												<?php 
												if($post_format != 'link' && $post_format != 'quote') {
													
													echo inforward_blog_post_meta($id, array(
														'author' => true,
														'dates' => true,
														'cat' => true,
														'comments' => true
													));
													
												if ( has_excerpt($id) ) {
													echo inforward_get_excerpt( $post_content, $excerpt_count_blog );
												} else {
													echo apply_filters( 'the_content', $content );
													wp_link_pages(array(
														'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'inforward' ) . ':</span>',
														'after'       => '</div>',
														'link_before' => '<span>',
														'link_after'  => '</span>',
														'pagelink'    => '%',
														'separator'   => ''
													));
												}
												} 
												
												if($post_format == 'link' || $post_format == 'quote') {
													 echo sprintf( '%s', $before_content );
													 
													 echo inforward_blog_post_meta($id, array(
														'author' => true,
														'dates' => true,
														'cat' => true,
														'comments' => true
													));
													  
												}
												?>
												
												<?php if ( $post_format != 'link' && $post_format != 'quote' ) { ?>
												<a href="<?php echo esc_url($link) ?>" class="info-btn cp-continue-reading-link"><?php echo esc_html__('Read More','inforward') ?></a>
												<?php } ?>
												
										
										
										</div>

										<!-- - - - - - - - - - - - - - End of Entry body - - - - - - - - - - - - - - - - -->
			
								
                                </div>
                                <?php } else { ?>
                                 <div id="post-<?php echo (int) $id; ?>" class="item <?php echo esc_attr($format_class) ?> <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, 0, '' ) : '' ?> ">
                                
                                <?php if ( !empty($before_content) ): ?>

                                    <div class="entry-attachment">
                                        <?php echo sprintf( '%s', $before_content ) ?>
                                    </div>

                                <?php endif; ?>

                                	<div class="event-info">
											
                                            <h5 class="cp-post-title event-link">
                                                <?php if ( is_sticky($id) ): ?>
                                                    <?php printf( '<span class="sticky-post label">%s</span>', esc_html__( 'Featured', 'inforward' ) ); ?>
                                                <?php endif; ?>

                                                <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                                            </h5>
                                           
                                           <div class="entry-meta">
                                              <time class="entry-date" datetime="<?php echo esc_attr(get_the_date( 'c', $id )) ?>"><?php echo esc_attr( get_the_date( '', $id ) ); ?></time>
                                            </div>
                                                    <?php 
													
												if ( has_excerpt($id) ) {
													echo inforward_get_excerpt( $post_content, $excerpt_count_blog );
												} 
												?>
                                                
												<a href="<?php echo esc_url($link) ?>" class="info-btn cp-continue-reading-link"><?php echo esc_html__('Read More','inforward') ?></a>
												
										</div>
                                
                                  </div>
                                 <?php }  ?>

								<?php $i++; ?>

							<?php break; ?>

							
							<?php case 'cp-type-2': ?>
                            
							<div id="post-<?php echo (int) $id; ?>" class="event-item <?php echo esc_attr($format_class) ?> <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, 0, '' ) : '' ?> ">

										<!-- - - - - - - - - - - - - - Attachment - - - - - - - - - - - - - - - - -->

										<?php if ( !empty($before_content) && $post_format != 'link' && $post_format != 'quote' ): ?>

											<div class="entry-attachment">
												<?php echo sprintf( '%s', $before_content ) ?>
											</div>

										<?php endif; ?>

										<!-- - - - - - - - - - - - - - End of Attachment - - - - - - - - - - - - - - - - -->

										<!-- - - - - - - - - - - - - - Entry body - - - - - - - - - - - - - - - - -->
										
										<div class="event-info">
											<?php  if($post_format != 'link' && $post_format != 'quote') { ?>
                                            <h4 class="cp-post-title event-link">
                                                <?php if ( is_sticky($id) ): ?>
                                                    <?php printf( '<span class="sticky-post label">%s</span>', esc_html__( 'Featured', 'inforward' ) ); ?>
                                                <?php endif; ?>

                                                <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                                            </h4>
                                            <?php  } ?>

												<?php 
												if($post_format != 'link' && $post_format != 'quote') {
													
													echo inforward_blog_post_meta($id, array(
														'author' => true,
														'dates' => true,
														'cat' => true,
														'comments' => true
													));
													
												if ( has_excerpt($id) ) {
													echo inforward_get_excerpt( $post_content, $excerpt_count_blog );
												} else {
													echo apply_filters( 'the_content', $content );
													wp_link_pages(array(
														'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages', 'inforward' ) . ':</span>',
														'after'       => '</div>',
														'link_before' => '<span>',
														'link_after'  => '</span>',
														'pagelink'    => '%',
														'separator'   => ''
													));
												}
												} 
												
												if($post_format == 'link' || $post_format == 'quote') {
													 echo sprintf( '%s', $before_content );
													 
													 echo inforward_blog_post_meta($id, array(
														'author' => true,
														'dates' => true,
														'cat' => true,
														'comments' => true
													));
													  
												}
												?>
												
												<?php if ( $post_format != 'link' && $post_format != 'quote' ) { ?>
												<a href="<?php echo esc_url($link) ?>" class="info-btn cp-continue-reading-link"><?php echo esc_html__('Read More','inforward') ?></a>
												<?php } ?>
												
										
										
										</div>

										<!-- - - - - - - - - - - - - - End of Entry body - - - - - - - - - - - - - - - - -->

								</div>

								<?php $i++; ?>

							<?php break; ?>
                            
                            <?php case 'cp-type-3': ?>
                            
							<div id="post-<?php echo (int) $id; ?>" class="entry <?php echo esc_attr($format_class) ?> <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, 0, '' ) : '' ?> ">
                           
                                <div class="entry-attachment">
                                <figure class="thumbnail-attachment">
                                    <?php echo Inforward_Helper::get_the_post_thumbnail( $id, 'inforward-post-grid', true, array(), array() ); ?>
                                </figure>
                                </div>
                                
                                <div class="entry-body">

                                    <h6><?php echo esc_html__('Latest News','inforward') ?></h6>
                                    <h4 class="entry-title"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a></h4>
                                    
                                    <div class="entry-meta">
                                      <time class="entry-date" datetime="<?php echo esc_attr(get_the_date( 'c', $id )) ?>"><?php echo esc_attr(get_the_date( '', $id )) ?></time>
                                    </div>
                                    
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
										
										echo '<a class="info-btn" ' . $attributes . '>' . $a_title . '</a>';
									 }
									?>
                                   
                                  </div>

                            </div>

							<?php $i++; ?>

							<?php break; ?>
                            
                            
                            <?php case 'cp-type-4': ?>
                            
							<div id="post-<?php echo (int) $id; ?>" class="event-item <?php echo esc_attr($format_class) ?> <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, 0, '' ) : '' ?> ">

										<div class="event-date">
                                            <div class="event-month"><?php echo esc_attr(get_the_date( 'M', $id )) ?></div>
                                            <div class="event-day"><?php echo esc_attr(get_the_date( 'd', $id )) ?></div>
                                        </div>
										
										<div class="event-info">
                                            <h4 class="cp-post-title event-link">
                                                <?php if ( is_sticky($id) ): ?>
                                                    <?php printf( '<span class="sticky-post label">%s</span>', esc_html__( 'Featured', 'inforward' ) ); ?>
                                                <?php endif; ?>

                                                <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                                            </h4>
                                           
												<?php 	
												if ( has_excerpt($id) ) {
													echo inforward_get_excerpt( $post_content, $excerpt_count_blog );
												} else {
													echo apply_filters( 'the_content', $content );
												}
												?>
												<a href="<?php echo esc_url($link) ?>" class="info-btn cp-continue-reading-link"><?php echo esc_html__('Read More','inforward') ?></a>
												
										</div>

										<!-- - - - - - - - - - - - - - End of Entry body - - - - - - - - - - - - - - - - -->

								</div>

								<?php $i++; ?>

							<?php break; ?>
                            
                            <?php case 'cp-type-5':  ?>
							
							 <?php if($i == 1 ) { ?>
                             
                            <div class="col-md-6 col-sm-12">
							<div id="post-<?php echo (int) $id; ?>" class="entry  entry-big <?php echo esc_attr($format_class) ?> <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, 0, '' ) : '' ?> ">

								<div class="entry-attachment">
                                <figure class="thumbnail-attachment">
                                    <?php echo Inforward_Helper::get_the_post_thumbnail( $id, 'large', true, array(), array() ); ?>
                                </figure>
                                </div>
                                
                                <div class="entry-body">
                                    <h4 class="entry-title">
                                     <?php if ( is_sticky($id) ): ?>
                                        <?php printf( '<span class="sticky-post label">%s</span>', esc_html__( 'Featured', 'inforward' ) ); ?>
                                     <?php endif; ?>
                                    <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                                    </h4>
                                    
                                    <div class="entry-meta">
                                      <time class="entry-date" datetime="<?php echo esc_attr(get_the_date( 'c', $id )) ?>"><?php echo esc_attr(get_the_date( '', $id )) ?></time>
                                    </div>
                                    
                                    <?php 	
									if ( has_excerpt($id) ) {
										echo inforward_get_excerpt( $post_content, $excerpt_count_blog );
									} else {
										echo apply_filters( 'the_content', $content );
									}
									?>
                                     
                                  </div>
                                  
								</div>
                                </div>
                                 <?php } else { ?>
                                 <div class="col-md-6 col-sm-12">
								 <div id="post-<?php echo (int) $id; ?>" class="entry hr-type entry-small <?php echo esc_attr($format_class) ?> <?php echo ( '' !== $css_animation ) ? Inforward_Helper::create_data_string_animation( $css_animation, 0, '' ) : '' ?> ">

										<div class="entry-attachment">
                                        <figure class="thumbnail-attachment">
                                            <?php echo Inforward_Helper::get_the_post_thumbnail( $id, 'inforward-portfolio-small-image', true, array(), array() ); ?>
                                        </figure>
                                        </div>
										
										 <div class="entry-body">
                                            <h4 class="entry-title">
                                             <?php if ( is_sticky($id) ): ?>
                                                <?php printf( '<span class="sticky-post label">%s</span>', esc_html__( 'Featured', 'inforward' ) ); ?>
                                             <?php endif; ?>
                                            <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                                            </h4>
                                            
                                            <div class="entry-meta">
                                              <time class="entry-date" datetime="<?php echo esc_attr(get_the_date( 'c', $id )) ?>"><?php echo esc_attr(get_the_date( '', $id )) ?></time>
                                            </div>
                                            
                                          </div>

								</div>
                                </div>
                                 <?php } ?>

								<?php $i++; ?>

							<?php break; ?>
                            
                            
						<?php endswitch; ?>

						<?php $post_loop ++; ?>

					<?php endforeach; ?>

					<?php wp_reset_postdata(); ?>

				<?php if ( $carousel && $layout == 'cp-type-1' ): ?>
				</div>
					
				<?php endif; ?>
				
			</div>
            
            <?php 
				if ( !$carousel && $paginate == "pagination" && $inforward_pagination = inforward_pagination($entries) ) : ?>
					<?php echo '<div class="'. $paginate_align .'" >'.$inforward_pagination.'</div>'; ?>
			<?php endif; ?>

			<?php if ( $use_link && $layout != 'cp-type-3' ) { 
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
					
					echo '<div class="'. $btn_align .'" ><a class="'. $btn_class .'" ' . $attributes . '>' . $a_title . '</a></div>';
				?>
					
				<?php } ?>
			
			
		</div>

		<?php return ob_get_clean();
	}



	public function prepare_entries($params) {
		$this->loop = array();

		if ( empty($params )) $params = $this->atts;
		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		$layout = $params['layout'];
		$columns = $params['columns'];
		$carousel = $params['carousel'];

		foreach ( $this->entries->posts as $key => $entry ) {
			$this->loop[$key]['id'] = $id = $entry->ID;
			$this->loop[$key]['link'] = get_permalink($id);
			$this->loop[$key]['title'] = get_the_title($id);
			$this->loop[$key]['post_format'] = $format = get_post_format($id) ? get_post_format($id) : 'standard';

			if ( $carousel ) {
				$format = 'standard';
			}

			$this->loop[$key]['image_size'] = inforward_blog_alias( $format, $layout );
			$this->loop[$key]['content'] = $entry->post_content;
			switch ( $format ) {
				case 'standard': $format_class = 'cp-image-entry-format'; break;
				case 'gallery':  $format_class = 'cp-slideshow-entry-format'; break;
				case 'video': 	 $format_class = 'cp-video-entry-format'; break;
				case 'link': 	 $format_class = 'cp-link-entry-format'; break;
				case 'audio': 	 $format_class = 'cp-audio-entry-format'; break;
				case 'quote': 	 $format_class = 'cp-quote-entry-format'; break;
				default: 		 $format_class = 'cp-image-entry-format'; break;
			}

			$this->loop[$key]['format_class'] = $format_class;

			$this_post = apply_filters( 'inforward-entry-format-'. $format, $this->loop[$key] );

			$this->loop[$key]['post_content'] = has_excerpt( $id ) ? $entry->post_excerpt : $this_post['content'];

			if ( isset($this_post['before_content']) && !empty($this_post['before_content']) ) {
				$this->loop[$key]['before_content'] = $this_post['before_content'];
			}

		}

	}

}