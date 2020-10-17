<?php

/*	String Truncate
/* ---------------------------------------------------------------------- */

if ( !function_exists('inforward_string_truncate')) {
	function inforward_string_truncate($string, $limit, $break=".", $pad="...", $stripClean = false, $excludetags = '<strong><em><span>', $safe_truncate = false) {
		if ( empty($limit) ) return $string;

		if ( $stripClean ) {
			$string = strip_shortcodes(strip_tags($string, $excludetags));
		}

		if ( strlen($string) <= $limit ) return $string;

		if ( false !== ($breakpoint = strpos($string, $break, $limit)) ) {
			if ($breakpoint < strlen($string) - 1) {
				if ($safe_truncate || is_rtl()) {
					$string = mb_strimwidth($string, 0, $breakpoint) . $pad;
				} else {
					$string = substr($string, 0, $breakpoint) . $pad;
				}
			}
		}

		// if there is no breakpoint an no tags we could accidentaly split split inside a word
		if ( !$breakpoint && strlen(strip_tags($string)) == strlen($string) ) {
			if ( $safe_truncate || is_rtl() ) {
				$string = mb_strimwidth($string, 0, $limit) . $pad;
			} else {
				$string = substr($string, 0, $limit) . $pad;
			}
		}

		return $string;
	}
}

/*	Get Site Icon
/* ---------------------------------------------------------------------- */

if (!function_exists('inforward_get_site_icon_url')) {

	function inforward_get_site_icon_url( $size = 512, $url = '' ) {

		global $inforward_settings;

		$site_icon_id = '';
		$favicon_url = $inforward_settings['favicon']['url'];
		if ( isset($inforward_settings['favicon']['id']) ) {
			$site_icon_id = $inforward_settings['favicon']['id'];
		}

		if ( $site_icon_id ) {
			if ( $size >= 512 ) {
				$size_data = 'full';
			} else {
				$size_data = array( $size, $size );
			}

			$url_data = wp_get_attachment_image_src( $site_icon_id, $size_data );
			if ( $url_data ) {
				$url = $url_data[0];
			}
		} elseif( $favicon_url ) {
			return $favicon_url;
		}

		return $url;
	}
}

/*	Site Icon
/* ---------------------------------------------------------------------- */

if (!function_exists('inforward_wp_site_icon')) {

	function inforward_wp_site_icon() {

		if ( !function_exists('wp_site_icon') && !has_site_icon() ) {

			global $inforward_settings;
			$favicon = $inforward_settings['favicon'];

			if ( ! $favicon ) { return; }

			$meta_tags = array(
				sprintf( '<link rel="icon" href="%s" sizes="32x32" />', esc_url( inforward_get_site_icon_url( 32 ) ) ),
				sprintf( '<link rel="icon" href="%s" sizes="192x192" />', esc_url( inforward_get_site_icon_url( 192 ) ) ),
				sprintf( '<link rel="apple-touch-icon-precomposed" href="%s">', esc_url( inforward_get_site_icon_url( 180 ) ) ),
				sprintf( '<meta name="msapplication-TileImage" content="%s">', esc_url( inforward_get_site_icon_url( 270 ) ) ),
			);

			$meta_tags = array_filter( $meta_tags );

			foreach ( $meta_tags as $meta_tag ) {
				echo "$meta_tag\n";
			}

		}

	}
}
add_action( 'wp_head', 'inforward_wp_site_icon', 99 );

/*	Blog Post Meta
/* ---------------------------------------------------------------------- */

if ( !function_exists('inforward_blog_post_meta') ) {

	function inforward_blog_post_meta( $id = 0, $args = array() ) {

		global $inforward_settings;
		$defaults = array(
			'container' => 'div', 'author' => true, 'dates' => true, 'cat' => true, 'comments' => true, 'tag' => false
		);
		$args = wp_parse_args( $args, $defaults );
		$args = (object) $args;

		$commentCount = get_comments_number($id);
		$link = get_permalink($id);

		ob_start(); ?>

		<?php if ( is_single() ): ?>

			<?php if ( $args->container ): ?><div class="cp-entry-meta entry-meta"><?php endif; ?>

			<?php if ( in_array('date', $inforward_settings['single-post-metas']) && $args->dates ): ?>
				<time class="entry-date" datetime="<?php echo esc_attr(get_the_date( 'c', $id )) ?>">
				<?php echo esc_attr( get_the_date('', $id) ); ?>
                </time>
			<?php endif; ?>

			<?php if ( in_array('comments', $inforward_settings['single-post-metas']) && $args->comments ): ?>
				<?php if ( comments_open($id) ): ?>
					<a href="<?php echo esc_url($link) ?>" class="entry-comments-link"><?php echo sprintf( _n( '%s Comment', '%s Comments', $commentCount, 'inforward' ), number_format_i18n( $commentCount ) ); ?></a>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( in_array('author', $inforward_settings['single-post-metas']) && $args->author ): ?>
				<?php
					printf( '<span class="entry-byline">%1$s<a href="%2$s">%3$s</a></span>',
						esc_attr__('by ','inforward'),
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					);
				?>
			<?php endif; ?>
			
			<?php if ( in_array('cats', $inforward_settings['single-post-metas']) && $args->cat ): ?>
				<?php $categories = get_the_category_list(' ', '', $id); ?>
				<?php if ( !empty($categories) ): ?>
				<span class="entry-cat">
					<?php echo esc_attr__('in ','inforward').$categories; ?>
				</span>		
				<?php endif; ?>
			<?php endif; ?>
			
			<?php if ( $inforward_settings['post-single-tag']  && $args->tag ): ?>
				<?php $tag_list = get_the_tag_list( '', ', ', '', $id ); ?>
				<?php if ( !empty($tag_list) ): ?>
				<span class="entry-tags">
					<?php echo esc_attr__('in ','inforward').$tag_list; ?>
				</span>	
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( $args->container ): ?></div><?php endif; ?>

		<?php else: ?>

			<?php if ( $args->container ): ?><div class="cp-entry-meta entry-meta"><?php endif; ?>

					<?php if ( in_array('date', $inforward_settings['post-metas']) && $args->dates ): ?>
						<time class="entry-date" datetime="<?php echo esc_attr(get_the_date( 'c', $id )) ?>">
						<?php echo esc_attr( get_the_date('', $id) ); ?>
						</time>
                    <?php endif; ?>
					
                    <?php if ( in_array('comments', $inforward_settings['post-metas']) && $args->comments ): ?>
						<?php if ( comments_open($id) ): ?>
							<a href="<?php echo esc_url($link) ?>" class="entry-comments-link"><?php echo sprintf( _n( '%s Comment', '%s Comments', $commentCount, 'inforward' ), number_format_i18n( $commentCount ) ); ?></a>
						<?php endif; ?>
					<?php endif; ?>
                    
					<?php if ( in_array('author', $inforward_settings['post-metas']) && $args->author ): ?>
						<?php
							printf( '<span class="entry-byline">%1$s<a href="%2$s">%3$s</a></span>',
								esc_attr__('by ','inforward'),
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								get_the_author()
							);
						?>
					<?php endif; ?>

					<?php if ( in_array('cats', $inforward_settings['post-metas']) && $args->cat ): ?>
						<?php $categories = get_the_category_list(' ', '', $id); ?>
						<?php if ( !empty($categories) ): ?>
						<span class="entry-cat">
							<?php echo esc_attr__('in ','inforward').$categories; ?>
						</span>		
						<?php endif; ?>
					<?php endif; ?>				

			<?php if ( $args->container ): ?></div><?php endif; ?>

		<?php endif; 
		?>

		<?php return ob_get_clean();
	}
}

/* 	Regex
/* ---------------------------------------------------------------------- */

if (!function_exists('inforward_regex')) {

	/*
	*	Regex for url: http://mathiasbynens.be/demo/url-regex
	*/
	function inforward_regex($string, $pattern = false, $start = "^", $end = "") {
		if (!$pattern) return false;

		if ($pattern == "url") {
			$pattern = "!$start((https?|ftp)://(-\.)?([^\s/?\.#-]+\.?)+(/[^\s]*)?)$end!";
		} else if ($pattern == "link") {
			$pattern = '/(((http|ftp|https):\/{2})+(([0-9a-z_-]+\.)+(aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv|cx|cy|cz|cz|de|dj|dk|dm|do|dz|ec|ee|eg|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mn|mn|mo|mp|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|nom|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ra|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw|arpa)(:[0-9]+)?((\/([~0-9a-zA-Z\#\+\%@\.\/_-]+))?(\?[0-9a-zA-Z\+\%@\/&\[\];=_-]+)?)?))\b/imuS';
		} else if ($pattern == "mail") {
			$pattern = "!$start\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$end!";
		} else if ($pattern == "image") {
			$pattern = "!$start(https?(?://([^/?#]*))?([^?#]*?\.(?:jpg|gif|png)))$end!";
		} else if ($pattern == "mp4") {
			$pattern = "!$start(https?(?://([^/?#]*))?([^?#]*?\.(?:mp4)))$end!";
		} else if (strpos($pattern,"<") === 0) {
			$pattern = str_replace('<',"",$pattern);
			$pattern = str_replace('>',"",$pattern);

			if (strpos($pattern,"/") !== 0) { $close = "\/>"; $pattern = str_replace('/',"",$pattern); }
			$pattern = trim($pattern);
			if (!isset($close)) $close = "<\/".$pattern.">";

			$pattern = "!$start\<$pattern.+?$close!";
		}

		preg_match($pattern, $string, $result);

		if (empty($result[0])) {
			return false;
		} else {
			return $result;
		}
	}
}

/*	Search Query Filter
/* ---------------------------------------------------------------------- */

if(!function_exists('inforward_search_query_filter')) {
	function inforward_search_query_filter($query) {
		if( is_admin() ) return;

		if ( isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query() && empty($query->queried_object) ) {
			foreach( $query as $key => &$query_attr ) {
				if( strpos($key, 'is_') === 0 ) $query_attr = false;
			}

			$query->is_search = true;
			$query->set( 'post_type', 'fake_search_no_results' );
		}

		return $query;

	}
	add_filter( 'pre_get_posts', 'inforward_search_query_filter' );
}

/*	Tag Archive Page
/* ---------------------------------------------------------------------- */

if (!function_exists('inforward_tag_archive_page')) {

	function inforward_tag_archive_page($query) {
		$post_types = get_post_types();
		global $inforward_settings;

		if ( is_category() || is_tag() ) {
			if ( !is_admin() && $query->is_main_query() ) {

				$post_type = get_query_var(get_post_type());

				if ($post_type) {
					$post_type = $post_type;
				} else {
					$post_type = $post_types;
				}
				$query->set('post_type', $post_type);
			}
		}

		if ( $query->is_main_query() ) {

			if ( $query->is_post_type_archive('portfolio') ) {
				$query->query_vars['posts_per_page'] = 10;
			} elseif ( $query->is_post_type_archive('testimonials') ) {
				$query->query_vars['posts_per_page'] = 10;
			} elseif ( $query->is_post_type_archive('team-members') ) {
				$query->query_vars['posts_per_page'] = 10;
			}

		}

		return $query;
	}
	add_filter('pre_get_posts', 'inforward_tag_archive_page');
}

/* 	Filter Hook for Comments
/* --------------------------------------------------------------------- */

if ( !function_exists('inforward_output_comments')) {

	function inforward_output_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>

		<li class="cp-comment comment" id="comment-<?php echo comment_ID() ?>">

			<article>
				<div class="cp-gravatar gravatar">
					<?php echo get_avatar($comment, 100, '', esc_html(get_comment_author())); ?>
				</div>
				<div class="cp-comment-body comment-body">

					<header class="cp-comment-meta comment-meta">

						<h6 class="cp-comment-author comment-author">
							<?php
							$author = '<span>' . get_comment_author() . '</span>';
							$link = get_comment_author_url();
							if ( !empty($link) ) {
								$author = '<a href="' . esc_url($link) . '">' . $author . '</a>';
							}
							echo sprintf( '%s', $author );
							?>
						</h6>

						<div class="comment-info">
							<?php echo sprintf( '<time class="cp-comment-date comment-date">%s</time>', get_comment_date(get_option('date_format')) ); ?>
    
                            <?php edit_comment_link(' ' . esc_html__('Edit', 'inforward'),'  ','') ?>
    
                            <?php
                            echo get_comment_reply_link(array_merge(
                                array( 'reply_text' => esc_html__('Reply', 'inforward') ),
                                array( 'depth' => $depth, 'max_depth' => $args['max_depth'] )
                            ));
                            ?>
                        </div>

					</header>

					<?php comment_text(); ?>

				</div>

			</article>

		</li>

	<?php
	}
}

/* 	Filter Hooks for Respond
/* ---------------------------------------------------------------------- */

if ( !function_exists('inforward_comments_form_hook')) {

	function inforward_comments_form_hook ($defaults) {

		$commenter = wp_get_current_commenter();

		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html_req = ( $req ? " required='required'" : '' );
		$class_req = ( $req ? "required" : '' );
		
		$required_text = sprintf( ' ' . esc_html__('Required fields are marked %s', 'inforward'), esc_html__('(required)', 'inforward') );

		$defaults['fields']['author'] = '<div class="row flex-row"><div class="col-sm-12"><label class="' . esc_attr( $class_req ) . '">'. esc_html__( 'Name', 'inforward' ) .'</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></div></div>';

		$defaults['fields']['email'] = '<div class="row flex-row"><div class="col-sm-12"><label class="' . esc_attr( $class_req ) . '">'. esc_html__( 'Email', 'inforward' ) .'</label><input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></div></div>';

		$defaults['fields']['url'] = '<div class="row flex-row"><div class="col-sm-12"><label>'. esc_html__( 'Website', 'inforward' ) .'</label><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>';

		$defaults['comment_notes_before'] = '<p class="comment-notes"><span id="email-notes">' . esc_html__( 'Your email address will not be published.', 'inforward' ) . '</span>'. ( $req ? $required_text : '' ) . '</p>';

		$defaults['comment_field'] = '<div class="row flex-row"><div class="col-sm-12"><label>'. esc_html__( 'Comment', 'inforward' ) .'</label><textarea id="comment" name="comment" rows="6" aria-describedby="form-allowed-tags" aria-required="true" required="required"></textarea></div></div>';

		$defaults['cancel_reply_link'] = ' - ' . esc_html__('Cancel reply', 'inforward');

		$defaults['title_reply_before'] =  '<h4 id="reply-title" class="comment-reply-title">';
		$defaults['title_reply_after'] =  '</h4>';
		$defaults['class_submit'] = 'btn btn-style-3 btn-big';
		$defaults['class_form'] = 'contact-form join-form';

		return $defaults;
	}
	add_filter('comment_form_defaults', 'inforward_comments_form_hook');
}

if ( !function_exists('inforward_comments_form_fields') ) {

	function inforward_comments_form_fields($comment_fields) {
		$a = $comment_fields;
		$a = array_reverse($a);
		$b = array_pop($a);
		$a = array_reverse($a);
		$a['comment'] = $b;

		return $a;
	}

	add_filter('comment_form_fields', 'inforward_comments_form_fields');

}

/*	Array to data string
/* ---------------------------------------------------------------------- */

if ( !function_exists('inforward_create_data_string') ) {
	function inforward_create_data_string($data = array()) {
		$data_string = "";

		if ( empty($data) ) return;

		foreach ( $data as $key => $value ) {
			if ( is_array($value) ) $value = implode(", ", $value);
			$data_string .= " data-$key='$value' ";
		}
		return $data_string;
	}
}

/*	Inline CSS
/* ---------------------------------------------------------------------- */

if (!function_exists('inforward_inline_css')) {

	function inforward_inline_css() {
		$post_id = inforward_post_id();
		$content_padding = array();
		$css = $body_css = $footer_css = $inline_css = array();
		$body_bg_color = get_post_meta( $post_id, 'inforward_body_bg_color', true );
		$image = get_post_meta( $post_id, 'inforward_bg_image', true );
		$footer_bg_color = get_post_meta( $post_id, 'inforward_footer_bg_color', true );
		$hide_content_bg = get_post_meta( $post_id, 'inforward_hide_content_bg', true );

		$image_repeat     = get_post_meta( $post_id, 'inforward_bg_image_repeat', true );
		$image_position   = get_post_meta( $post_id, 'inforward_bg_image_position', true );
		$image_attachment = get_post_meta( $post_id, 'inforward_bg_image_attachment', true );
		
		if ( !empty($image) && $image > 0 ) {
			
			if ( isset($image) ) {
				$image = wp_get_attachment_image_src($image, '');
				if ( is_array($image) && isset($image[0]) ) {
					$image = $image[0];
				}
			}

			if ( !empty( $image ) && $image != 'none') { $css[] = "background-image: url('$image') !important;"; }
			if ( !empty( $image ) && !empty( $image_attachment ) ) { $css[] = "background-attachment: $image_attachment !important;"; }
			if ( !empty( $image ) && !empty( $image_position ) )   { $css[] = "background-position: $image_position !important;"; }
			if ( !empty( $image ) && !empty( $image_repeat ) )     { $css[] = "background-repeat: $image_repeat !important;"; }

		}

		

		$page_content_padding = array();

		if ( $post_id )
			$content_padding = get_post_meta( $post_id, 'inforward_page_content_padding', true );

		if ( $content_padding && is_array($content_padding) ) {
			$page_content_padding = array_filter(get_post_meta( $post_id, 'inforward_page_content_padding',  true ));
		}

		

		if ( !empty( $body_bg_color ) ) { $body_css[] = "background-color: $body_bg_color;"; }
		if ( !empty( $footer_bg_color ) ) { $footer_css[] = "background-color: $footer_bg_color;"; }

		if ( !empty( $page_content_padding ) && is_array($page_content_padding) ) {
			if ( isset($page_content_padding[0]) && !empty($page_content_padding[0]) ) {
				$padding_top = $page_content_padding[0];
				$inline_css[] = "padding-top: $padding_top;";
			}

			if ( isset($page_content_padding[1]) && !empty($page_content_padding[1]) ) {
				$padding_bottom = $page_content_padding[1];
				$inline_css[] = "padding-bottom: $padding_bottom;";
			}
		
		}
		
		if($hide_content_bg) {
				$inline_css[] = "background-color: transparent !important;";
		}
		

		?>
		<style type="text/css">
			<?php if ( $body_css ): ?>
				body { <?php echo implode( ' ', $body_css ) ?> }
			<?php endif; ?>

			<?php if ( $footer_css ): ?>
				#footer .main-footer { <?php echo implode( ' ', $footer_css ) ?> }
			<?php endif; ?>

			<?php if ( $css ): ?>
				body { <?php echo implode( ' ', $css ) ?>}
			<?php endif; ?>

			<?php if ( $inline_css ): ?>
				.cp-page-content-wrap { <?php echo implode( ' ', $inline_css ) ?>}
			<?php endif; ?>
		</style>

	<?php
	}

	add_filter('wp_head', 'inforward_inline_css');
}

/*	Title
/* ---------------------------------------------------------------------- */

if ( !function_exists('inforward_title') ) {

	function inforward_title( $args = false, $id = false ) {

		if ( empty($id) ) $id = inforward_post_id();

		$defaults = array(
			'title' 	  => get_the_title($id),
			'subtitle'    => "",
			'output_html' => "<{heading} {attributes} {title_color} class='cp-page-title page-title {class}'>{title}</{heading}>{additions}",
			'attributes'  => '',
			'class'		  => '',
			'heading'	  => 'h1',
			'title_color' => '',
			'additions'	  => ""
		);
		$style_title = '';
		
		$args = wp_parse_args($args, $defaults);
		extract($args, EXTR_SKIP);

		if ( $title_color ) {
			$style_title = 'style="color:' . $title_color . '"';
		}
		
		if ( !empty($subtitle) ) {
			$class .= ' cp-with-subtitle';
			$additions .= "<div class='cp-title-meta'>" . do_shortcode(wpautop($subtitle)) . "</div>";
		}

		$output_html = str_replace('{class}', $class, $output_html);
		$output_html = str_replace('{attributes}', $attributes, $output_html);
		$output_html = str_replace('{title_color}', $style_title, $output_html);
		$output_html = str_replace('{heading}', $heading, $output_html);
		$output_html = str_replace('{title}', $title, $output_html);
		$output_html = str_replace('{additions}', $additions, $output_html);
		return $output_html;
	}
}

/*	Which Archive
/* ---------------------------------------------------------------------- */

if (!function_exists('inforward_which_archive')) {

	function inforward_which_archive() {

		ob_start(); ?>

		<?php if ( is_category() ): ?>

			<?php echo esc_html__('Archive for Category:', 'inforward') . " " . single_cat_title('', false); ?>

		<?php elseif ( is_day() ): ?>

			<?php echo esc_html__('Daily Archives:', 'inforward') . " " . get_the_time( esc_html__('F jS, Y', 'inforward')); ?>

		<?php elseif ( is_month() ): ?>

			<?php echo esc_html__('Monthly Archives:', 'inforward') . " " . get_the_time( esc_html__('F, Y', 'inforward')); ?>

		<?php elseif ( is_year() ): ?>

			<?php echo esc_html__('Yearly Archives:', 'inforward') . " " . get_the_time( esc_html__('Y', 'inforward')); ?>

		<?php elseif ( is_search() ): global $wp_query; ?>

			<?php if ( !empty($wp_query->found_posts) ): ?>

				<?php if ( $wp_query->found_posts > 1 ): ?>

					<?php echo esc_html__('Search results for:', 'inforward')." " . esc_attr(get_search_query()) . " (". $wp_query->found_posts .")"; ?>

				<?php else: ?>

					<?php echo esc_html__('Search result for:', 'inforward')." " . esc_attr(get_search_query()) . " (". $wp_query->found_posts .")"; ?>

				<?php endif; ?>

			<?php else: ?>

				<?php if ( !empty($_GET['s']) ): ?>

					<?php echo esc_html__('Search results for:', 'inforward') . " " . esc_attr(get_search_query()); ?>

				<?php else: ?>

					<?php echo esc_html__('To search the site please enter a valid term', 'inforward'); ?>

				<?php endif; ?>

			<?php endif; ?>

		<?php elseif ( is_author() ): ?>

			<?php $auth = ( get_query_var('author_name') ) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); ?>

			<?php if ( isset($auth->nickname) && isset($auth->ID) ): ?>

				<?php $name = $auth->nickname; ?>

				<?php echo esc_html__('Author Archive', 'inforward'); ?>
				<?php echo esc_html__('for:', 'inforward') . " " . $name; ?>

			<?php endif; ?>

		<?php elseif ( is_tag() ): ?>

			<?php echo esc_html__('Posts tagged &ldquo;', 'inforward') . " " . single_tag_title('', false) . '&rdquo;'; ?>

			<?php
			$term_description = term_description();
			if ( ! empty( $term_description ) ) {
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			}
			?>

		<?php elseif ( is_tax() ): ?>

			<?php $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); ?>

			<?php if ( inforward_is_product_tag() ): ?>
				<?php echo esc_html__('Products by:', 'inforward') . ' "' . $term->name . '" tag'; ?>
			<?php elseif( inforward_is_product_category() ): ?>
				<?php echo esc_html__('Archive for category:', 'inforward') . " " . single_cat_title('', false); ?>
			<?php else: ?>
				<?php echo esc_html__('Archive for:', 'inforward') . " " . $term->name; ?>
			<?php endif; ?>

		<?php else: ?>

			<?php if ( is_post_type_archive() ): ?>
				<?php echo sprintf(__('Archive %s', 'inforward'), get_query_var('post_type')); ?>
			<?php else: ?>
				<?php echo esc_html__('Archive', 'inforward'); ?>
			<?php endif; ?>

		<?php endif; ?>

		<?php return ob_get_clean();
	}
}

if ( !function_exists('inforward_breadcrumbs') ) {

	function inforward_breadcrumbs( $args = array() ) {
		global $wp_query, $wp_rewrite;

		$trail = array();
		$path = '';
		$breadcrumb = '';

		$defaults = array(
			'after' => false,
			'separator' => '&raquo;',
			'front_page' => true,
			'show_home' => esc_html__( 'Home', 'inforward' ),
			'show_posts_page' => true,
			'truncate' => 80
		);

		if (is_singular()) {
			$defaults["singular_{$wp_query->post->post_type}_taxonomy"] = false;
		}
		extract( wp_parse_args( $args, $defaults ) );

		if (!is_front_page() && $show_home) {
			$trail[] = '<li><a href="' . esc_url(home_url('/')) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . $show_home . '</a></li>';
		}

		if (is_front_page()) {
			if (!$front_page) {
				$trail = false;
			} elseif ($show_home) {
				$trail['end'] = "{$show_home}";
			}
		} elseif (is_home()) {
			$home_page = get_page( $wp_query->get_queried_object_id() );
			$trail = array_merge( $trail, inforward_breadcrumbs_get_parents( $home_page->post_parent, '' ) );
			$trail['end'] = get_the_title( $home_page->ID );
		} elseif (is_singular()) {
			$post = $wp_query->get_queried_object();
			$post_id = absint( $wp_query->get_queried_object_id() );
			$post_type = $post->post_type;
			$parent = $post->post_parent;

			if ('page' !== $post_type && 'post' !== $post_type) {
				$post_type_object = get_post_type_object( $post_type );

				if (!empty( $post_type_object->rewrite['slug'] ) ) {
					$path .= $post_type_object->rewrite['slug'];
				}
				if (!empty($path)) {
					$trail = array_merge( $trail, inforward_breadcrumbs_get_parents( '', $path ) );
				}
				if (!empty( $post_type_object->has_archive) && function_exists( 'get_post_type_archive_link' ) ) {
					$trail[] = '<li><a href="' . esc_url( get_post_type_archive_link( $post_type ) ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . $post_type_object->labels->name . '</a></li>';
				}
			}

			if (empty($path) && 0 !== $parent || 'attachment' == $post_type) {
				$trail = array_merge($trail, inforward_breadcrumbs_get_parents($parent, ''));
			}

			if ( 'post' == $post_type && $show_posts_page == true && 'page' == get_option('show_on_front')) {
				$posts_page = get_option('page_for_posts');
				if ($posts_page != '' && is_numeric($posts_page)) {
					$trail = array_merge( $trail, inforward_breadcrumbs_get_parents($posts_page, '' ));
				}
			}

			if ('post' == $post_type) {
				$category = get_the_category();

				foreach ($category as $cat)  {
					if (!empty($cat->parent))  {
						$parents = get_category_parents($cat->cat_ID, TRUE, '$$$', FALSE);
						$parents = explode("$$$", $parents);
						foreach ($parents as $parent_item) {
							if ($parent_item) $trail[] = $parent_item;
						}
						break;
					}
				}

				if (isset($category[0]) && empty($parents)) {
					$trail[] = '<li><a href="'. esc_url(get_category_link($category[0]->term_id )) .'">'.$category[0]->cat_name.'</a></li>';
				}

			}

			if (isset( $args["singular_{$post_type}_taxonomy"]) && $terms = get_the_term_list( $post_id, $args["singular_{$post_type}_taxonomy"], '', ', ', '' ) ) {
				$trail[] = $terms;
			}

			$post_title = get_the_title($post_id);

			if (!empty($post_title)) {
				$trail['end'] = $post_title;
			}

		} elseif (is_archive()) {

			if (is_tax() || is_category() || is_tag()) {
				$term = $wp_query->get_queried_object();
				$taxonomy = get_taxonomy( $term->taxonomy );

				if ( is_category() ) {
					$path = get_option( 'category_base' );
				} elseif ( is_tag() ) {
					$path = get_option( 'tag_base' );
				} else {
					if ($taxonomy->rewrite['with_front'] && $wp_rewrite->front) {
						$path = trailingslashit($wp_rewrite->front);
					}
					$path .= $taxonomy->rewrite['slug'];
				}

				if ($path) {
					$trail = array_merge($trail, inforward_breadcrumbs_get_parents( '', $path ));
				}

				if (is_taxonomy_hierarchical($term->taxonomy) && $term->parent) {
					$trail = array_merge($trail, inforward_get_term_parents( $term->parent, $term->taxonomy ) );
				}

				$trail['end'] = $term->name;

			} elseif (function_exists( 'is_post_type_archive' ) && is_post_type_archive()) {

				$post_type_object = get_post_type_object(get_query_var('post_type'));

				if (!empty($post_type_object->rewrite['archive'])) {
					$path .= $post_type_object->rewrite['archive'];
				}

				if (!empty($path)) {
					$trail = array_merge( $trail, inforward_breadcrumbs_get_parents( '', $path ));
				}

				$trail['end'] = $post_type_object->labels->name;

			} elseif (is_author()) {
				if (!empty($wp_rewrite->front)) {
					$path .= trailingslashit($wp_rewrite->front);
				}
				if (!empty($wp_rewrite->author_base)) {
					$path .= $wp_rewrite->author_base;
				}
				if (!empty($path)) {
					$trail = array_merge( $trail, inforward_breadcrumbs_get_parents( '', $path ));
				}
				$trail['end'] =  apply_filters('inforward_author_name', get_the_author_meta('display_name', get_query_var('author')), get_query_var('author'));
			} elseif ( is_time()) {
				if (get_query_var( 'minute' ) && get_query_var('hour')) {
					$trail['end'] = get_the_time( esc_html__('g:i a', 'inforward' ));
				} elseif ( get_query_var( 'minute' ) ) {
					$trail['end'] = sprintf( esc_html__('Minute %1$s', 'inforward' ), get_the_time( esc_html__( 'i', 'inforward' ) ) );
				} elseif ( get_query_var( 'hour' ) ) {
					$trail['end'] = get_the_time( esc_html__( 'g a', 'inforward'));
				}
			} elseif (is_date()) {

				if ($wp_rewrite->front) {
					$trail = array_merge($trail, inforward_breadcrumbs_get_parents('', $wp_rewrite->front));
				}

				if (is_day()) {
					$trail[] = '<li><a href="' . esc_url(get_year_link( get_the_time( 'Y' ) )) . '" title="' . get_the_time( esc_attr__( 'Y', 'inforward' ) ) . '">' . get_the_time( esc_html__( 'Y', 'inforward' ) ) . '</a></li>';
					$trail[] = '<li><a href="' . esc_url(get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) )) . '" title="' . get_the_time( esc_attr__( 'F', 'inforward' ) ) . '">' . get_the_time( esc_html__( 'F', 'inforward' ) ) . '</a></li>';
					$trail['end'] = get_the_time( esc_html__( 'j', 'inforward' ) );
				} elseif ( get_query_var( 'w' ) ) {
					$trail[] = '<li><a href="' . esc_url(get_year_link( get_the_time( 'Y' ) )) . '" title="' . get_the_time( esc_attr__( 'Y', 'inforward' ) ) . '">' . get_the_time( esc_html__( 'Y', 'inforward' ) ) . '</a></li>';
					$trail['end'] = sprintf( esc_html__( 'Week %1$s', 'inforward' ), get_the_time( esc_attr__( 'W', 'inforward' ) ) );
				} elseif ( is_month() ) {
					$trail[] = '<li><a href="' . esc_url(get_year_link( get_the_time( 'Y' ) )) . '" title="' . get_the_time( esc_attr__( 'Y', 'inforward' ) ) . '">' . get_the_time( esc_html__( 'Y', 'inforward' ) ) . '</a></li>';
					$trail['end'] = get_the_time( esc_html__( 'F', 'inforward' ) );
				} elseif ( is_year() ) {
					$trail['end'] = get_the_time( esc_html__( 'Y', 'inforward' ) );
				}
			}
		} elseif ( is_search() ) {
			$trail['end'] = sprintf( esc_html__( 'Search results for &quot;%1$s&quot;', 'inforward' ), esc_attr( get_search_query() ) );
		} elseif ( is_404() ) {
			$trail['end'] = esc_html__( '404 Not Found', 'inforward' );
		}

		if (is_array($trail)) {
			if (!empty($trail['end'])) {
				if (!is_search()) {
					$trail['end'] = $trail['end'];
				}
				$trail['end'] = '<span class="trail-end">' . $trail['end'] . '</span>';
			}
			if (!empty($separator)) {
				$separator = '<span class="separate">'. $separator .'</span>';
			}
			$breadcrumb = join(" {$separator} ", $trail);

			if (!empty($after)) {
				$breadcrumb .= ' <span class="breadcrumb-after">' . $after . '</span>';
			}
		}
		return $breadcrumb;
	}
}

if (!function_exists('inforward_breadcrumbs_get_parents')) {

	function inforward_breadcrumbs_get_parents($post_id = '', $path = '') {
		$trail = array();

		if (empty($post_id) && empty($path)) {
			return $trail;
		}

		if (empty($post_id)) {
			$parent_page = get_page_by_path($path);

			if (empty($parent_page)) {
				$parent_page = get_page_by_title($path);
			}
			if (empty($parent_page)) {
				$parent_page = get_page_by_title (str_replace( array('-', '_'), ' ', $path));
			}
			if (!empty($parent_page)) {
				$post_id = $parent_page->ID;
			}
		}

		if ($post_id == 0 && !empty($path )) {
			$path = trim( $path, '/' );
			preg_match_all( "/\/.*?\z/", $path, $matches );

			if ( isset( $matches ) ) {
				$matches = array_reverse( $matches );
				foreach ( $matches as $match ) {

					if ( isset( $match[0] ) ) {
						$path = str_replace( $match[0], '', $path );
						$parent_page = get_page_by_path( trim( $path, '/' ) );

						if ( !empty( $parent_page ) && $parent_page->ID > 0 ) {
							$post_id = $parent_page->ID;
							break;
						}
					}
				}
			}
		}

		while ( $post_id ) {
			$page = get_page($post_id);
			$parents[]  = '<a href="' . esc_url(get_permalink( $post_id )) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';
			if(is_object($page)) {
				$post_id = $page->post_parent;
			} else {
				$post_id = "";
			}
		}
		if (isset($parents)) {
			$trail = array_reverse($parents);
		}
		return $trail;
	}

}

if (!function_exists('inforward_get_term_parents')) {

	function inforward_get_term_parents($parent_id = '', $taxonomy = '') {
		$trail = array();
		$parents = array();

		if (empty( $parent_id ) || empty($taxonomy)) {
			return $trail;
		}
		while ($parent_id) {
			$parent = get_term( $parent_id, $taxonomy );
			$parents[] = '<a href="' . esc_url(get_term_link( $parent, $taxonomy )) . '" title="' . esc_attr($parent->name) . '">' . $parent->name . '</a>';
			$parent_id = $parent->parent;
		}
		if (!empty($parents)) {
			$trail = array_reverse($parents);
		}
		return $trail;
	}

}

if ( !function_exists('inforward_maps_key_for_plugins') ) {

	add_filter( 'script_loader_src', 'inforward_maps_key_for_plugins', 10 , 99, 2 );

	function inforward_maps_key_for_plugins ( $url, $handle  ) {

		global $inforward_settings;

		$key = $inforward_settings['gmap-api'];

		if ( ! $key ) { return $url; }

		if ( strpos( $url, "maps.google.com/maps/api/js" ) !== false || strpos( $url, "maps.googleapis.com/maps/api/js" ) !== false ) {
			if ( strpos( $url, "key=" ) === false ) {
				$url = "http://maps.google.com/maps/api/js?v=3.24";
				$url = esc_url( add_query_arg( 'key', $key, $url) );
			}
		}

		return $url;
	}
}