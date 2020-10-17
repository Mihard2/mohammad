<?php
/**
 * The template for displaying single testimonials.
 *
 * @package WordPress
 * @subpackage Inforward
 * @since Inforward 1.0
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php
	$id = get_the_ID();
	$position = get_post_meta( $id, 'inforward_tm_position', true );
	$company = get_post_meta( $id, 'inforward_tm_company', true );
	?>

	<div class="template-single">

		<?php while ( have_posts() ) : the_post(); ?>

			<div class="row">

				<div class="col-sm-1">

					<div class="post-thumbnail">
						<?php the_post_thumbnail( array(360, 360) ); ?>
					</div>

				</div>
				<div class="col-sm-11">

					<h4 class="single-title"><?php the_title() ?></h4>

					<?php if ( isset($position) && !empty($position) ): ?>
						<span class="cp-author-position"><?php echo esc_html( get_post_meta( $id, 'inforward_tm_position', true )) ?></span>
					<?php endif; ?>

					<?php if ( isset($company) && !empty($company) ): ?>
						<span class="cp-author-company"><?php echo esc_html( get_post_meta( $id, 'inforward_tm_company', true )) ?></span>
					<?php endif; ?>

					<?php the_content(); ?>

				</div>
			</div>


		<?php endwhile ?>

	</div>

<?php else:
	get_template_part( 'template-parts/content', 'none' );
endif; ?>

<?php get_footer(); ?>