<?php
/**
 * The template for displaying Testimonials Archive area.
 */

get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php
	global $inforward_settings;

	$layout = $inforward_settings['testimonials-archive-layout'];
	$columns = $inforward_settings['testimonials-archive-columns'];
	$css_classes = array(
		'cp-testimonials-holder',
		'cp-paginate-pagination',
		$layout
	);

	if ( $layout == 'cp-type-2' || $layout == 'cp-type-3' ) {
		$css_classes[] = 'cp-cols-' . absint($columns);
	}

	$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	?>

	<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

		<?php while ( have_posts() ) : the_post(); ?>

				<?php
				$id = get_the_ID();
				$name = get_the_title();
				$link  = get_permalink();
				$company = get_post_meta( $id, 'inforward_tm_company', true );
				$content = has_excerpt($id) ? apply_filters( 'the_excerpt', get_the_excerpt() ) : '';
				$alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
				if ( empty($alt) ) {
					$attachment = get_post($id);
					$alt = trim(strip_tags($attachment->post_title));
				}
				$thumbnail_atts = array(
					'title'	=> trim(strip_tags(get_the_title())),
					'alt' => $alt
				);
				?>

				<div class="cp-testimonial">
					<div class="cp-author-box">

						<?php if ( has_post_thumbnail() ): ?>

							<a href="<?php echo esc_url($link) ?>" class="cp-avatar">
								<?php echo Inforward_Helper::get_the_post_thumbnail( $id, '70*70', true, $thumbnail_atts ) ?>
							</a>

						<?php endif; ?>

						<div class="cp-author-info">

							<a href="<?php echo esc_url($link) ?>" class="cp-author-name"><?php echo esc_html($name) ?></a>
							<span class="cp-author-company"><?php echo esc_html($company) ?></span>

						</div>

					</div>

					<blockquote><?php echo do_shortcode($content); ?></blockquote>

				</div>

		<?php endwhile; ?>

	</div>

	<?php
		echo inforward_pagination();
		?>

	<?php wp_reset_postdata(); ?>

<?php else:
	get_template_part( 'template-parts/content', 'none' );

endif; ?>

<?php get_footer(); ?>