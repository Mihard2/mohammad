<?php
global $inforward_config;
$sidebar_position = $inforward_config['sidebar_position'];
?>

		<?php if ( $sidebar_position != 'cp-no-sidebar' ): ?>

			</main>

			<?php get_sidebar(); ?>

				</div>

				<?php do_action( 'inforward_after_main_content' ) ?>

			</div>

		<?php else: ?>

					</div>
				</div>
			</div>

		<?php endif; ?>

	</div>

	<div class="cp-footer-holder">

		<footer id="footer" class="cp-footer footer <?php echo esc_attr($inforward_config['footer_classes']) ?>">

			<?php
			/**
			 * inforward_footer_in_top_part hook
			 *
			 */

			do_action('inforward_footer_in_top_part');
			?>

		</footer>

		 <div id="footer-scroll"></div>

	</div>

</div>

<?php
	/**
	 * inforward_after_footer_ hook
	 *
	 */

	do_action('inforward_after_footer');
	?>

<?php wp_footer(); ?>

</body>
</html>