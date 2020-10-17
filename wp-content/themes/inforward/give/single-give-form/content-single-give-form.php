<?php
/**
 * The template for displaying form content in the single-give-form.php template
 *
 * Override this template by copying it to yourtheme/give/single-give-form/content-single-give-form.php
 *
 * @package       Give/Templates
 * @version       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Fires in single form template, before the form.
 *
 * Allows you to add elements before the form.
 *
 * @since 1.0
 */
do_action( 'give_before_single_form' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
?>

	<div id="give-form-<?php the_ID(); ?>-content" <?php post_class(); ?>>

		<?php
		/**
		 * Fires in single form template, before the form summary.
		 *
		 * Allows you to add elements before the form summary.
		 *
		 * @since 1.0
		 */
		 
		
		do_action( 'give_before_single_form_summary' );
		?>

		<div class="<?php echo apply_filters( 'give_forms_single_summary_classes', 'summary entry-summary' ); ?>">

			<?php
			/**
			 * Fires in single form template, to the form summary.
			 *
			 * Allows you to add elements to the form summary.
			 *
			 * @since 1.0
			 */
			 
			do_action( 'give_single_form_summary' );
			?>

		</div>
		<!-- .summary -->

		<?php
		/**
		 * Fires in single form template, after the form summary.
		 *
		 * Allows you to add elements after the form summary.
		 *
		 * @since 1.0
		 */
	 
		
		do_action( 'give_after_single_form_summary' );
		
		
		$image = wp_get_attachment_url( get_post_thumbnail_id() );
		$permalink = apply_filters('the_permalink', get_the_permalink());
		$title = get_the_title();
		$extra_attr = 'target="_blank"';
		
		?>
		<div class="share-wrap style-1">

		<span class="share-title"><?php esc_html_e('Share', 'inforward') ?>:</span>

			<ul class="social-icons share">

					<li><a class="sh-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($permalink) ?>&amp;p&#091;images&#093;&#091;0&#093;=<?php echo esc_url($image) ?>&amp;p&#091;title&#093;=<?php echo esc_attr($title) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-facebook"></i><?php echo esc_html__('Facebook', 'inforward') ?></a></li>
				
					<li><a class="sh-twitter" href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($title) ?>&amp;url=<?php echo esc_url($permalink) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-twitter"></i><?php echo esc_html__('Twitter', 'inforward') ?></a></li>
				
					<li><a class="sh-google"" href="https://plus.google.com/share?url=<?php echo esc_url($permalink) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-gplus-3"></i><?php echo esc_html__('Google Plus', 'inforward') ?></a></li>
				
					<li><a class="sh-pinterest" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url($permalink) ?>&amp;media=<?php echo esc_url($image) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-pinterest"></i><?php echo esc_html__('Pinterest', 'inforward') ?></a></li>
				
					<li><a class="sh-mail" href="mailto:?subject=<?php echo esc_attr($title) ?>&amp;body=<?php echo esc_url($permalink) ?>" <?php echo  wp_kses_post($extra_attr) ?>><i class="icon-mail"></i><?php echo esc_html__('Email to a Friend', 'inforward') ?></a></li>
				
			</ul>
			
		</div>
		

	</div><!-- #give-form-<?php the_ID(); ?> -->

<?php
/**
 * Fires in single form template, after the form.
 *
 * Allows you to add elements after the form.
 *
 * @since 1.0
 */
do_action( 'give_after_single_form' );
?>
