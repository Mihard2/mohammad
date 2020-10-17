<?php global $post; ?>

<?php if ( post_password_required() ) : ?>
	<div class="content-element">
		<p class="no-comments"><?php echo esc_html__('This post is password protected. Enter the password to view comments.', 'inforward'); ?></p>
	</div>
<?php return; endif; ?>

<?php if ( have_comments() ): ?>

	<div id="comments" class="content-element">

		<h4>
			<?php
			printf( _nx( 'Comment (1)', 'Comments (%1$s)', get_comments_number(), 'comments title', 'inforward' ),
				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h4>

		<ol class="cp-comments-list comments-list">
			<?php wp_list_comments('avatar_size=100&callback=inforward_output_comments'); ?>
		</ol>

		<?php if (get_comment_pages_count() > 1 && get_option( 'page_comments' )): ?>
			<nav class="comments-pagination">
				<?php paginate_comments_links(); ?>
			</nav>
		<?php endif; ?>

		<?php if (! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' )): ?>
			<p class="nocomments"><?php esc_html_e('Comments are closed.', 'inforward'); ?></p>
		<?php endif; ?>

	</div>

<?php endif; ?>

<?php if ( comments_open() ): ?>

	<?php comment_form(); ?>

<?php elseif ( get_comments_number() ): ?>

	<h3 class="commentsclosed"><?php esc_html_e( 'Comments are closed.', 'inforward' ) ?></h3>

<?php endif; ?>
