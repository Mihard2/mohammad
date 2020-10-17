<?php
/**
 * The main template file
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
		'loop-holder',
		'cp-type-2',
		'blog-type-list',
		'events-holder',
	);

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