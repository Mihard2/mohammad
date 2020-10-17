<?php
/**
 * Custom Inforward template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Inforward
 * @since Inforward 1.0
 */

if ( ! function_exists('inforward_excerpt') ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own twentysixteen_excerpt() function to override in a child theme.
	 *
	 * @since Inforward 1.0
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function inforward_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) : ?>
			<div class="<?php echo sanitize_html_class($class); ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo sanitize_html_class($class); ?> -->
		<?php endif;
	}
endif;

if ( ! function_exists( 'inforward_post_thumbnail' ) ) :
function inforward_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

		<div class="cp-post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>

	<?php else : ?>

		<a class="cp-post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
		</a>

	<?php endif; 
}
endif;

if ( ! function_exists('inforward_single_page_links') ) :
	/**
	* Displays the .
	*
	*/
	function inforward_single_page_links() {
		$next_post = get_next_post();
		$prev_post = get_previous_post();
		$next_post_url = $prev_post_url = "";
		$next_post_title = $prev_post_title = "";

		if ( is_object($next_post) ) {
			$next_post_url = get_permalink($next_post->ID);
			$next_post_title = $next_post->post_title;
		}
		if ( is_object($prev_post) ) {
			$prev_post_url = get_permalink($prev_post->ID);
			$prev_post_title = $prev_post->post_title;
		}

		if ( !empty($prev_post_url) || !empty($next_post_url) ): ?>

			<?php if ( !empty($prev_post_url) ): ?>
				<a class="btn rd-black nav_prev" href="<?php echo esc_url($prev_post_url) ?>" title="<?php echo esc_attr($prev_post_title) ?>"></a>
			<?php endif; ?>

			<?php if ( !empty($next_post_url) ): ?>
				<a class="btn rd-black nav_next" href="<?php echo esc_url($next_post_url) ?>" title="<?php echo esc_attr($next_post_title) ?>"></a>
			<?php endif; ?>

		<?php endif;

	}
endif;

if ( ! function_exists('inforward_entry_date') ) :
	/**
	 * Prints HTML with date information for current post.
	 *
	 */
	function inforward_entry_date( $id, $full_date = false, $comments = false, $comments_without_text = false ) {
		$time_string = '<time class="cp-entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( $full_date ) {
			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c', $id ) ),
				esc_attr( get_the_date( 'j F Y', $id ) )
			);
		} else {

			if ( get_the_time( 'U', $id ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="cp-entry-date published" datetime="%1$s">%2$s<span class="cp-entry-month">%3$s</span></time><time class="updated" datetime="%4$s">%5$s</time>';
			}

			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c', $id ) ),
				esc_attr( get_the_date( 'd', $id) ),
				esc_attr( get_the_date( 'M', $id) ),
				esc_attr( get_the_modified_date( 'c' ) ),
				get_the_modified_date()
			);
		}

		if ( is_single($id) ) {
			printf( '<span class="posted-on">%1$s</span> ',
				$time_string
			);
		} else {
			printf( '<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span> ',
				esc_url( get_permalink($id) ),
				$time_string
			);
		}

		if ( $comments ) {

			if ( $comments_without_text ) {
				inforward_comments_popup_link( $id, true );
			} else {
				inforward_comments_popup_link( $id );
			}

	    }
	}
endif;

if ( ! function_exists('inforward_comments_popup_link') ) :

	function inforward_comments_popup_link( $id = false, $comments_without_text = false, $zero = false, $one = false, $more = false, $css_class = 'cp-entry-comments-link' ) {
		$number = get_comments_number( $id );

		if ( post_password_required() ) {
			esc_html_e( 'Enter your password to view comments.', 'inforward' );
			return;
		}

		echo '<a href="';
			echo apply_filters( 'inforward_respond_link', get_permalink($id) . '#respond', $id );
		echo '"';

		if ( !empty( $css_class ) ) {
			echo ' class="'. $css_class .'" ';
		}

		echo '>';

		if ( false === $more ) {

			if ( $comments_without_text ) {
				$output = sprintf( '%s', number_format_i18n( $number ) );
			} else {
				$output = sprintf( _n( '%s Comment', '%s Comments', $number, 'inforward' ), number_format_i18n( $number ) );
			}

		} else {
			// % Comments
			/* translators: If comment number in your language requires declension,
			 * translate this to 'on'. Do not translate into your own language.
			 */
			if ( 'on' === _x( 'off', 'Comment number declension: on or off', 'inforward' ) ) {
				$text = preg_replace( '#<span class="screen-reader-text">.+?</span>#', '', $more );
				$text = preg_replace( '/&.+?;/', '', $text ); // Kill entities
				$text = trim( strip_tags( $text ), '% ' );

				// Replace '% Comments' with a proper plural form
				if ( $text && ! preg_match( '/[0-9]+/', $text ) && false !== strpos( $more, '%' ) ) {
					/* translators: %s: number of comments */
					$new_text = _n( '%s Comment', '%s Comments', $number, 'inforward' );
					$new_text = trim( sprintf( $new_text, '' ) );

					$more = str_replace( $text, $new_text, $more );
					if ( false === strpos( $more, '%' ) ) {
						$more = '% ' . $more;
					}
				}
			}

			$output = str_replace( '%', number_format_i18n( $number ), $more );
		}
		echo wp_kses_post($output);
		echo '</a>';
	}
endif;

if ( ! function_exists('inforward_get_excerpt') ) :
	/**
	 * Displays the get excerpt.
	 *
	 */
	function inforward_get_excerpt( $post_content, $limit = 150 ) {
		$content = inforward_string_truncate( $post_content, $limit, ' ', "...", true, '' );
		$content = apply_filters( 'the_content', $content );
		$content = do_shortcode($content);
		return $content;
	}
endif;


if ( ! function_exists('inforward_get_search_excerpt') ) :
	/**
	 * Displays the get excerpt for search.
	 *
	 */
	function inforward_get_search_excerpt( $limit = 150, $more_link = true ) {

		if ( !$limit ) { $limit = 45; }

		if ( has_excerpt() ) {
			$content = strip_tags( strip_shortcodes(get_the_excerpt()) );
		} else {
			$content = strip_tags( strip_shortcodes(get_the_content()) );
		}

		$content = explode(' ', $content, $limit);

		if ( count($content) >= $limit ) {
			array_pop($content);
			if ($more_link)
				$content = implode(" ",$content).'... ';
			else
				$content = implode(" ",$content).' [...]';
		} else {
			$content = implode(" ",$content);
		}

		$content = apply_filters('the_content', $content);
		$content = do_shortcode($content);
		return $content;
	}
endif;

if ( ! function_exists( 'inforward_team_members_social_links' ) ) :
	/**
	 * Displays the social links for team members post type.
	 *
	 */
	function inforward_team_members_social_links( $id = '' ) {
		$post_id = inforward_post_id();

		if ( absint($id) ) $post_id = $id;

		$linkedin = get_post_meta( $post_id, 'inforward_tm_linkedin', true );
		$tumblr = get_post_meta( $post_id, 'inforward_tm_tumblr', true );
		$gplus = get_post_meta( $post_id, 'inforward_tm_gplus', true );
		$twitter = get_post_meta( $post_id, 'inforward_tm_twitter', true );
		$instagram = get_post_meta( $post_id, 'inforward_tm_instagram', true );
		$facebook = get_post_meta( $post_id, 'inforward_tm_facebook', true );
		$mail = get_post_meta( $post_id, 'inforward_tm_mail', true );

		ob_start(); ?>

		<ul class="social-icons">
			<?php if ( !empty($linkedin) ): ?>
				<li class="linkedin-icon" ><a href="<?php echo esc_url($linkedin) ?>"><i class="icon-linkedin"></i></a></li>
			<?php endif; ?>

			<?php if ( !empty($tumblr) ): ?>
				<li class="tumblr-icon" ><a href="<?php echo esc_url($tumblr) ?>"><i class="icon-tumblr"></i></a></li>
			<?php endif; ?>

			<?php if ( !empty($gplus) ): ?>
				<li class="google-icon" ><a href="<?php echo esc_url($gplus) ?>"><i class="icon-gplus"></i></a></li>
			<?php endif; ?>
			
			<?php if ( !empty($twitter) ): ?>
				<li class="tweet-icon" ><a href="<?php echo esc_url($twitter) ?>"><i class="icon-twitter"></i></a></li>
			<?php endif; ?>
			
			<?php if ( !empty($instagram) ): ?>
				<li class="insta-icon" ><a href="<?php echo esc_url($instagram) ?>"><i class="icon-instagram-4"></i></a></li>
			<?php endif; ?>
			
			<?php if ( !empty($facebook) ): ?>
				<li class="fb-icon" ><a href="<?php echo esc_url($facebook) ?>"><i class="icon-facebook"></i></a></li>
			<?php endif; ?>
            
            <?php if ( !empty($mail) ): ?>
				<li class="fb-icon" ><a href="mailto:<?php echo sanitize_email($mail) ?>"><i class="icon-mail"></i></a></li>
			<?php endif; ?>
		</ul>

		<?php return ob_get_clean();
	}
endif;
