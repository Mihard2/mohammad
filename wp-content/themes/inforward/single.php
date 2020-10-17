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

	<div class="cp-single-entry-holder">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			global $post;
			$this_post = array();
			$this_post['id'] = $this_id = get_the_ID();
			$title = get_the_title($this_id);
			$this_post['content'] = get_the_content();
			$this_post['post_format'] = $format = get_post_format() ? get_post_format() : 'standard';
			$this_post['url'] = $link = get_permalink($this_id);
			$this_post['image_size'] = '';
			$image_size = inforward_blog_alias( $format, '', 'cp-big-thumbs', 'cp-type-2', 1 );
			$this_post = apply_filters( 'inforward-entry-format-single', $this_post );
			$thumbnail_atts = array(
				'alt'	=> trim(strip_tags(get_the_excerpt($this_id))),
				'title'	=> trim(strip_tags(get_the_title($this_id)))
			);

			extract($this_post);
			?>

			<div id="<?php echo get_the_ID() ?>" <?php post_class('event-item single-event'); ?>>

				<h2 class="event-link">
                    <a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a>
                </h2>

					<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
						<div class="entry-attachment">
							<?php 
							$thumbnail = Inforward_Helper::get_the_post_thumbnail( $this_id, $image_size, true, '', $thumbnail_atts );
							echo wp_kses_post($thumbnail);
							?>
						</div>
					<?php endif; ?>

					<div class="event-info">
						<?php 
						echo inforward_blog_post_meta($id, array(
														'author' => true,
														'dates' => true,
														'cat' => true,
														'comments' => true
													)); 
						?>
						
							<div class="cp-entry-content">
							<?php if ( !empty($this_post['content']) ): ?>
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'inforward' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
							<?php endif; ?>
							</div>
							
							<?php if ( $inforward_settings['post-single-tag'] ): ?>
								<?php
                                    $tags_list = get_the_tag_list( '', '' );
                                    if ( $tags_list ) {
                                        echo '<div class="cp-entry-tags tagcloud"><span>' . esc_html__( 'Tags', 'inforward' ) . ':</span>' . $tags_list . '</div>';
                                    }
                                ?>
                            <?php endif; ?>
							
						<?php if ( $inforward_settings['post-single-share'] ): ?>
							<?php if ( function_exists('inforward_content_share') ): ?>
                                <?php inforward_content_share(); ?>
                            <?php endif; ?>
                        <?php endif; ?>
						
					</div>

				<?php if ( $inforward_settings['post-nav'] ): ?>
					<?php get_template_part( 'template-parts/single', 'link-pages' ) ?>
				<?php endif; ?>

				<?php if ( $inforward_settings['post-author'] ): ?>
					<?php
					get_template_part( 'template-parts/single', 'author-box' ); 
					?>
				<?php endif; ?>
				
                <?php if ( $inforward_settings['post-related'] ): ?>
					<?php get_template_part( 'template-parts/single', 'related' ); ?>
                <?php endif; ?>
				
			</div>
			
			<?php if ( $inforward_settings['post-comments'] ): ?>
				<?php if ( comments_open() || '0' != get_comments_number() ): ?>
					<?php comments_template(); ?>
				<?php endif; ?>
			<?php endif; ?>

		<?php endwhile ?>

	</div>

<?php endif; ?>

<?php get_footer(); ?>