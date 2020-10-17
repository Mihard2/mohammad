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

	<div class="cp-team-member cp-single">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php echo apply_filters('the_content', get_the_content()); ?>

		<?php endwhile ?>

	</div>

<?php else:
	get_template_part( 'template-parts/content', 'none' );

endif; ?>

<?php get_footer(); ?>