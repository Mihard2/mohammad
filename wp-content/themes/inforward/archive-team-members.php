<?php
/**
 * The template for displaying Team Members Archive area.
 */

get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php
	global $inforward_settings;

	$layout = $inforward_settings['team-members-archive-layout'];
	$columns = $inforward_settings['team-members-archive-columns'];
	$excerpt_count = $inforward_settings['team-member-excerpt-count'];
	$desc_pos = $inforward_settings['team-members-archive-position-desc'];
	$css_classes = array(
		'cp-team-holder', $layout,
		'cp-cols-' . absint($columns),
		'cp-' . $desc_pos,
		'cp-paginate-pagination'
	);

	switch ( $layout ):
		case 'cp-type-1': $image_size = '330*330'; break;
		case 'cp-type-2': $image_size = '270*330'; break;
		default: 		  $image_size = '330*330'; break;
	endswitch;

	$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	?>

	<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
				$id = get_the_ID();
				$name = get_the_title();
				$link  = get_permalink();
				$position = get_post_meta($id, 'inforward_tm_position', true);
				$content = has_excerpt() ? get_the_excerpt() : get_the_content();
				$thumbnail_atts = array(
					'alt'	=> trim(strip_tags(get_the_title()))
				);
				$content = inforward_get_excerpt( $content, $excerpt_count );

			?>

			<div class="cp-team-member">
				<?php if ( has_post_thumbnail($id) ): ?>

					<div class="cp-member-photo">
						<a href="<?php echo esc_url($link); ?>" class="cp-member-link">
							<?php echo Inforward_Helper::get_the_post_thumbnail ($id, $image_size, false, array(), $thumbnail_atts ) ?>
						</a>

						<?php if ( $desc_pos == 'hover' ):  ?>

							<div class="cp-member-about"><?php echo apply_filters( 'the_content', $content ); ?></div>

						<?php endif; ?>

					</div>

				<?php endif; ?>

				<div class="cp-member-holder">

					<h4 class="cp-member-name">
						<a href="<?php echo esc_url($link); ?>"><?php echo esc_html($name); ?></a>
					</h4>

					<?php if ( !empty($position) ): ?>
						<div class="cp-member-position"><?php echo esc_html($position) ?></div>
					<?php endif; ?>

					<?php echo inforward_team_members_social_links($id); ?>

					<?php if ( $desc_pos == 'bottom' ):  ?>

						<div class="cp-member-about"><?php echo apply_filters( 'the_content', $content ); ?></div>

					<?php endif; ?>

				</div>

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