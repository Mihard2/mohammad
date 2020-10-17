<?php

class WPBakeryShortCode_VC_mad_products extends WPBakeryShortCode {

	public $atts = array();
	public $products = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' 	 => '',
			'tag_title' 	 => 'h2',
			'description' 	 => '',
			'title_color' => '',
			'title_align' => '',
			'description_align' => '',
			'description_color' => '',
			'type' 		 => 'gt-view-grid',
			'columns' 	 => 4,
			'items' 	 => 8,
			'show' => '',
			'orderby' => 'menu_order',
			'order' => '',
			'by_id' => '',
			'categories' => '',
			'paginate' => 'none',
			'link' => '',
			'taxonomy' => 'product_cat',
			'css_animation' => '',
			'link' => '',
			'offset' => 0
		), $atts, 'vc_mad_products');

		global $woocommerce;
		if (!is_object($woocommerce) || !is_object($woocommerce->query)) return;

		$this->query();
		return $this->html();
	}

	protected function stringToArray( $value ) {
		$valid_values = array();
		$list = preg_split( '/\,[\s]*/', $value );
		foreach ( $list as $v ) {
			if ( strlen( $v ) > 0 ) {
				$valid_values[] = $v;
			}
		}
		return $valid_values;
	}

	public function query() {

		global $woocommerce;

		$params = $this->atts;
		$number = $params['items'];
		$orderby = sanitize_title( $params['orderby'] );
		$order = sanitize_title( $params['order'] );
		$show = $params['show'];

		// Meta query
		$meta_query = $tax_query = array();
		$meta_query[] = $woocommerce->query->visibility_meta_query();
		$meta_query[] = $woocommerce->query->stock_status_meta_query();
		$meta_query = array_filter($meta_query);

		if ( !empty($params['categories']) ) {

			$categories = explode(',', $params['categories']);

			if (is_array($categories)) {
				$categories = $categories;
			} else {
				$categories = array($categories);
			}

			$tax_query = array(
				'relation' => 'AND',
					array(
						'taxonomy' => 'product_cat',
						'field' => 'id',
						'terms' => $categories
					)
			);
		}

		$query = array(
			'post_type' 	 => 'product',
			'post_status' 	 => 'publish',
			'ignore_sticky_posts'	=> 1,
			'order'   		 => $order == 'asc' ? 'asc' : 'desc',
			'meta_query' 	 => $meta_query,
			'tax_query' 	 => $tax_query,
			'posts_per_page' => $number
		);

		if ( !empty($params['by_id']) ) {
			$in = $not_in = array();
			$by_ids = $params['by_id'];
			$ids = $this->stringToArray( $by_ids );

			foreach ( $ids as $id ) {
				$id = (int) $id;
				if ( $id < 0 ) {
					$not_in[] = abs( $id );
				} else {
					$in[] = $id;
				}
			}
			$query['post__in'] = $in;
			$query['post__not_in'] = $not_in;
		}

		if ( $params['paginate'] == 'pagination' ) {
			$paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
			$query['paged'] = $paged;
		}

		if ( $orderby != '' ) {
			switch ( $orderby ) {
				case 'rand' :
					$query['orderby']  = 'rand';
					break;
				case 'date' :
					$query['orderby']  = 'date ID';
					$query['order']    = $order == 'ASC' ? 'ASC' : 'DESC';
					break;
				case 'price' :
					$query['orderby']  = "meta_value_num ID";
					$query['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
					$query['meta_key'] = '_price';
					break;
				case 'popularity' :
					$query['meta_key'] = 'total_sales';

					// Sorting handled later though a hook
					add_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
					break;
				case 'rating' :
					// Sorting handled later though a hook
					add_filter( 'posts_clauses', array( $this, 'order_by_rating_post_clauses' ) );
					break;
				case 'title' :
					$query['orderby']  = 'title';
					$query['order']    = $order == 'DESC' ? 'DESC' : 'ASC';
					break;
				default :
					$query['orderby']  = $params['orderby'];
					break;
			}
		} else {
			$query['orderby'] = get_option('woocommerce_default_catalog_orderby');
		}

		switch ( $show ) {
			case 'featured' :
				$query['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
				break;
			case 'onsale' :
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query['post__in'] = $product_ids_on_sale;
				break;
			case 'bestselling':
				$query['ignore_sticky_posts'] = 1;
				$query['meta_key'] = 'total_sales';
				$query['orderby'] = 'meta_value_num';
				break;
			case 'toprated' :
				$query['ignore_sticky_posts'] = 1;
				$query['no_found_rows'] = 1;
				break;
			case 'new':
				add_filter( 'posts_where', array(&$this, 'filter_where') );
				break;
		}

		if ( $show == 'toprated' ) {
			add_filter( 'posts_clauses', array( WC()->query , 'order_by_rating_post_clauses' ) );
		}

		$this->products = new WP_Query( $query );

		if ( $show == 'new' ) {
			remove_filter( 'posts_where', array(&$this, 'filter_where') );
		}

		global $woocommerce_loop;
		$woocommerce_loop['loop'] = 0;

		if ( $show == 'toprated' ) {
			remove_filter( 'posts_clauses', array( WC()->query , 'order_by_rating_post_clauses' ) );
		}

	}

	public function order_by_popularity_post_clauses( $args ) {
		global $wpdb;
		$args['orderby'] = "$wpdb->postmeta.meta_value+0 DESC, $wpdb->posts.post_date DESC";
		return $args;
	}

	public function order_by_rating_post_clauses( $args ) {
		global $wpdb;

		$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";
		$args['where']  .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";
		$args['join']   .= "
			LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";
		$args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";
		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}

	public function filter_where( $where = '' ) {
		$newness = get_option( 'wc_nb_newness' );
		$where .= " AND post_date > '" . date(wc_date_format(), strtotime('-'. $newness .' days')) . "'";
		return $where;
	}

	protected function sort_cat_links( $products, $params ) {

		$get_categories = get_categories(array(
			'taxonomy'	 => $params['taxonomy'],
			'hide_empty' => 1
		));

		$type_sort = !empty($params['type_sort']) ? $params['type_sort'] : 'gt-type-1';
		$align_sort = !empty($params['align_sort']) ? $params['align_sort'] : 'align-left';

		$current_cats = $current_parents = array();
		$display_cats = is_array($params['categories']) ? $params['categories'] : array_filter(explode(',', $params['categories']));

		foreach ($products->posts as $entry) {

			if ($current_item_cats = get_the_terms( $entry->ID, $params['taxonomy'] )) {

				if (isset($current_item_cats) && !empty($current_item_cats)) {
					foreach ($current_item_cats as $current_item_cat) {

						if (in_array($current_item_cat->term_id, $display_cats)) {

							$current_parents[$current_item_cat->term_id] = $current_item_cat->term_id;

							if(!isset($current_cats[$current_item_cat->term_id] )) {
								$current_cats[$current_item_cat->term_id] = 0;
							}

							$current_cats[$current_item_cat->term_id] ++;
						}

						if (in_array($current_item_cat->parent, $display_cats)) {

							$current_parents[$current_item_cat->parent] = $current_item_cat->parent;

							if(!isset($current_cats[$current_item_cat->parent] )) {
								$current_cats[$current_item_cat->parent] = 0;
							}

							$current_cats[$current_item_cat->parent] ++;
						}

					}
				}
			}

		}

		$current_cats = array_merge($current_cats, $current_parents);

		$css_classes = array(
			'gt-filter', $type_sort, $align_sort
		);

		$wrapper_attributes = array();
		if ( '' !== $params['css_animation'] ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $params['css_animation'], 0, '-80' );
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

		ob_start(); ?>

		<nav class="<?php echo esc_attr( trim($css_class) ) ?>" <?php echo implode( ' ', $wrapper_attributes ) ?>>
			<ul>

				<li><a href="javascript:void(0)" class="gt-active" data-filter="*"><?php esc_html_e('All', 'inforward') ?></a></li>

				<?php foreach ( $get_categories as $category ): ?>
					<?php if ( in_array($category->term_id, $current_cats) ): ?>
						<?php $nicename = str_replace('%', '', $category->category_nicename); ?>
						<li><a href="javascript:void(0)" data-filter=".<?php echo esc_attr($nicename) ?>"><?php echo esc_html(trim($category->cat_name)); ?></a></li>
					<?php endif; ?>

				<?php endforeach ?>

			</ul>
		</nav><!--/ .gt-filter-->

		<?php return ob_get_clean();
	}

	protected function sort_choose_links($params) {

		$type_sort = !empty($params['type_sort']) ? $params['type_sort'] : 'gt-type-1';
		$align_sort = !empty($params['align_sort']) ? $params['align_sort'] : 'align-left';

		$css_classes = array(
			'gt-filter', $type_sort, $align_sort
		);

		$wrapper_attributes = array();
		if ( '' !== $params['css_animation'] ) {
			$wrapper_attributes[] = Inforward_Helper::create_data_string_animation( $params['css_animation'], 0, '-80' );
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

		ob_start(); ?>

		<nav class="<?php echo esc_attr( trim($css_class) ) ?>" <?php echo implode( ' ', $wrapper_attributes ) ?>>
			<ul>
				<?php if ( $params['add_new'] ): ?>
					<li><a href="javascript:void(0)" data-filter="gt-new-badge"><?php esc_html_e('New', 'inforward'); ?></a></li>
				<?php endif; ?>

				<?php if ( $params['add_featured'] ): ?>
					<li><a href="javascript:void(0)" data-filter="featured"><?php esc_html_e('Featured', 'inforward'); ?></a></li>
				<?php endif; ?>

				<?php if ( $params['add_sale'] ): ?>
					<li><a href="javascript:void(0)" data-filter="sale"><?php esc_html_e('Sale', 'inforward'); ?></a></li>
				<?php endif; ?>
			</ul>
		</nav><!--/ .gt-filter-->

		<?php return ob_get_clean();
	}

	public function add_filter_classes($params) {
		if ( $params['sort'] == 'yes' ) {
			add_filter('post_class', array(&$this, 'post_class_filter'));
		}
	}

	public function post_class_filter($classes) {
		$classes[] = str_replace('%', '', self::getTermsCat(get_the_ID()));
		return $classes;
	}

	public function getTermsCat($id) {
		$classes = "";
		$item_categories = get_the_terms($id, 'product_cat');
		if ( is_object($item_categories) || is_array($item_categories) ) {
			foreach ( $item_categories as $cat ) {
				$classes .= $cat->slug . ' ';
			}
		}
		return $classes;
	}

	public function post_new_filter($classes) {
		$postdate 		= get_the_time( 'Y-m-d' );
		$postdatestamp 	= strtotime( $postdate );
		$newness 		= get_option( 'wc_nb_newness' );
		if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) {
			$classes[] = 'gt-new-badge';
		}
		return $classes;
	}

	protected function html() {

		if ( empty($this->products) || empty($this->products->posts) ) return;

		global $inforward_config;

		$products = $this->products;
		$params = $this->atts;
		$css_animation = !empty($params['css_animation']) ? $params['css_animation'] : '';
		$title = $tag_title = $columns = '';
		$paginate = !empty($params['paginate']) ? $params['paginate'] : 'pagination';
		$description = !empty($params['description']) ? $params['description'] : '';
		$title_color = !empty($params['title_color']) ? $params['title_color'] : '';
		$description_color = !empty($params['description_color']) ? $params['description_color'] : '';

		extract($params);

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

		ob_start(); ?>

		<div class="wpb_content_element custom_products">

			<?php if ( $products->have_posts() ) : ?>

				<?php
				$css_classes = array(
					'cp-products-holder', $type, 'columns-' . absint($columns), 'cp-paginate-' . $paginate
				);

				if ( '' !== $css_animation  ) {
					$wrapper_attributes[] = Inforward_Helper::create_data_string_animation($css_animation, 0, 0);
				}

				$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
				$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
				?>

				<?php
				echo Inforward_Vc_Config::getParamTitle(
					array(
						'title' => $title,
						'tag_title' => $tag_title,
						'description' => $description,
						'title_color' => $title_color,
						'description_color' => $description_color,
						'align' => $title_align,
						'align_des' => $description_align,
					)
				);
				?>
                
                <?php if ( $type == 'cp-view-grid' ) { ?>

				<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

					<?php woocommerce_product_loop_start(); ?>

					<?php $delay = 0; ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php $classes = array( 'cp_col' ); ?>

						<div <?php post_class( $classes ); ?>>

							<div class="cp-product">

								<?php
								/**
								 * woocommerce_before_shop_loop_item hook.
								 *
								 * @hooked woocommerce_template_loop_product_link_open - 10
								 */
								do_action( 'woocommerce_before_shop_loop_item' );

								/**
								 * woocommerce_before_shop_loop_item_title hook.
								 *
								 * @hooked woocommerce_show_product_loop_sale_flash - 10
								 * @hooked woocommerce_template_loop_product_thumbnail - 10
								 */
								do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

								<div class="cp-product-description">

									<?php
									/**
									 * woocommerce_shop_loop_item_title hook.
									 *
									 * @hooked woocommerce_template_loop_product_title - 10
									 */
									do_action( 'woocommerce_shop_loop_item_title' );

									/**
									 * woocommerce_after_shop_loop_item_title hook.
									 *
									 * @hooked woocommerce_template_loop_rating - 5
									 * @hooked woocommerce_template_loop_price - 10
									 */
									do_action( 'woocommerce_after_shop_loop_item_title' );

									/**
									 * woocommerce_after_shop_loop_item hook.
									 *
									 * @hooked woocommerce_template_loop_product_link_close - 5
									 * @hooked woocommerce_template_loop_add_to_cart - 10
									 */
									do_action( 'woocommerce_after_shop_loop_item' );
									?>

								</div><!--/ .gt-product-description-->

							</div><!--/ .gt-product-->

						</div><!--/ .gt-col-->

						<?php $delay = $delay + 100; ?>

					<?php endwhile; // end of the loop. ?>

					<?php woocommerce_product_loop_end(); ?>
                    
                    </div>
                    
                    <?php } elseif ( $type == 'cp-view-carousel' ) { ?>
                    
                    <div class="carousel-type-2 products_carousel">
                    <div class="owl-carousel content-element2" data-max-items="<?php echo absint($columns) ?>" data-item-margin="30">
                    
					<?php $delay = 0; ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php $classes = array( 'item-carousel' ); ?>

						<div <?php post_class( $classes ); ?>>

							<div class="product">

								<?php
								/**
								 * woocommerce_before_shop_loop_item hook.
								 *
								 * @hooked woocommerce_template_loop_product_link_open - 10
								 */
								do_action( 'woocommerce_before_shop_loop_item' );

								/**
								 * woocommerce_before_shop_loop_item_title hook.
								 *
								 * @hooked woocommerce_show_product_loop_sale_flash - 10
								 * @hooked woocommerce_template_loop_product_thumbnail - 10
								 */
								do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

								<div class="cp-product-description">

									<?php
									/**
									 * woocommerce_shop_loop_item_title hook.
									 *
									 * @hooked woocommerce_template_loop_product_title - 10
									 */
									do_action( 'woocommerce_shop_loop_item_title' );

									/**
									 * woocommerce_after_shop_loop_item_title hook.
									 *
									 * @hooked woocommerce_template_loop_rating - 5
									 * @hooked woocommerce_template_loop_price - 10
									 */
									do_action( 'woocommerce_after_shop_loop_item_title' );

									/**
									 * woocommerce_after_shop_loop_item hook.
									 *
									 * @hooked woocommerce_template_loop_product_link_close - 5
									 * @hooked woocommerce_template_loop_add_to_cart - 10
									 */
									do_action( 'woocommerce_after_shop_loop_item' );
									?>

								</div><!--/ .gt-product-description-->

							</div><!--/ .gt-product-->

						</div><!--/ .gt-col-->

						<?php $delay = $delay + 100; ?>

					<?php endwhile; // end of the loop. ?>
                    
                    </div>
                     </div>
                    
                    <?php }  ?>

					<?php if ( $paginate == "pagination" && $inforward_pagination = inforward_pagination($this->products) ) : ?>
						<?php echo  wp_kses_post($inforward_pagination); ?>
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
					
								echo '<div class="products-btn '. $title_align .'"><a class="btn" ' . $attributes . '>' . $a_title . '</a></div>';
						} ?>

				

			<?php else : ?>

				<?php if ( !woocommerce_product_subcategories(array('before' => '<ul class="products">', 'after' => '</ul>' )) ) : ?>
					<div class="woocommerce-error">
						<div class="messagebox_text">
							<p><?php esc_html_e( 'No products found which match your selection.', 'inforward' ) ?></p>
						</div><!--/ .messagebox_text-->
					</div><!--/ .woocommerce-error-->
				<?php endif; ?>

			<?php endif; ?>

		</div>

		<?php
			woocommerce_reset_loop();
			wp_reset_postdata();
		?>

		<?php return ob_get_clean();
	}


}