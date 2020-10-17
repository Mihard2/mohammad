<?php
	/**
	 * The template for displaying Search Results pages.
	 */
	get_header();
?>

<?php if ( have_posts() ) : ?>

	<?php
	global $inforward_settings;
	$wrapper_attributes = array();
	$css_classes = array(
		'events-holder', 'cp-type-2', 'cp-type-2', 'blog-type-list', 'post-archive'
	);

	$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	?>

	<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/loop', 'search' );
			endwhile;
			?>

		<?php
		echo inforward_pagination();
		?>

	</div>
<?php else:

	// If no content, include the "No posts found" template.
	get_template_part( 'template-parts/content', 'none' );

endif; ?>

<?php get_footer(); ?>