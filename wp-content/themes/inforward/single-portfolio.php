<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Inforward
 * @since Inforward 1.0
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php global $inforward_settings; ?>

	<div class="cp-single-portfolio-entry-holder">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			global $post;
			$this_id = get_the_ID();
			$title = get_the_title($this_id);
			$link = get_permalink($this_id);
			$link_to_website = $inforward_settings['portfolio-link'];
			$related_items = $inforward_settings['portfolio-related'];
			?>

			<div id="<?php echo get_the_ID() ?>" <?php post_class('single-portfolio-content'); ?>>
                <div class="content-element5">
                <a href="<?php echo esc_url($link_to_website); ?>" class="info-btn prev-btn"><?php echo esc_html__( 'Back to Portfolio', 'inforward' ); ?></a>
              	</div>

				<h3 class="single-portfolio-title content-element3"><?php echo esc_html($title) ?></h3>

				<div class="event-info">
					<div class="cp-entry-content">
							<?php the_content(); ?>
					</div>	
                    
				</div>
                
 					<?php if ( $inforward_settings['portfolio-single-share'] ): ?>
							<?php if ( function_exists('inforward_content_share') ): ?>
                             <div class="content-element2">
                                <?php inforward_content_share(); ?>
                             </div>
                            <?php endif; ?>
                    <?php endif; ?>

				<?php if ( $inforward_settings['portfolio-nav'] ): ?>
					<?php get_template_part( 'template-parts/single', 'link-pages-portfolio' ) ?>
				<?php endif; ?>
				
                <?php if ( $related_items ): ?>
					<?php get_template_part( 'template-parts/single', 'related-portfolio' ); ?>
                <?php endif; ?>
				
			</div>

		<?php endwhile ?>

	</div>

<?php endif; ?>

<?php get_footer(); ?>