<?php
/**
 * The template for displaying Archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Inforward
 * @since Inforward 1.0
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

	<?php
	global $inforward_settings;
	$wrapper_attributes = array();
	$css_classes = array(
		'cp-entries-holder', 'cp-type-2', 'type-2', 'style-2', 'blog-type'
	);
	$excerpt_count_blog = $inforward_settings['excerpt-count-big-thumbs'];
	$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	?>

	<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/loop', 'index' );
			endwhile;
			?>

		<?php
		echo inforward_pagination();
		?>

	</div>

<?php else:
	get_template_part( 'template-parts/content', 'none' );
endif; ?>

<?php get_footer(); ?>