<?php
global $inforward_settings, $inforward_config;
$result = Inforward_Widgets_Meta_Box::get_page_settings(inforward_post_id());

if ( class_exists( 'WooCommerce' ) ) {
	
	if ( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') || is_singular('product') || INFORWARD_WOOCOMMERCE_CONFIG::is_realy_woocommerce_page() ) {
		$shop_from_page_id = '';
		
		if ( !empty($inforward_settings['shop-archive-footer-sidebar']) ) {
		$shop_from_page_id = $inforward_settings['shop-archive-footer-sidebar'];
		}
	
		if ( is_singular('product') &&  !empty($inforward_settings['shop-single-footer-sidebar']) ) {
			$shop_from_page_id = $inforward_settings['shop-single-footer-sidebar'];
		}
		
		if ( $shop_from_page_id && $shop_from_page_id != '' ) {
			$result = Inforward_Widgets_Meta_Box::get_page_settings($shop_from_page_id);
		}
		
	}
}

if ( is_singular('post') &&  !empty($inforward_settings['single-footer-sidebar']) ) {
	    $post_from_page_id = $inforward_settings['single-footer-sidebar'];
		if ( $post_from_page_id ) {
		$result = Inforward_Widgets_Meta_Box::get_page_settings($post_from_page_id);
		}
	}
	
	
if ( (is_tax( get_object_taxonomies( 'tribe_events' ) ) || is_post_type_archive('tribe_events') ) &&  !empty($inforward_settings['events-footer-sidebar']) ) {
		$result = Inforward_Widgets_Meta_Box::get_page_settings($inforward_settings['events-footer-sidebar']);
	}		
	
if ( (is_tax( get_object_taxonomies( 'issues' ) ) || is_post_type_archive('issues') || is_singular('issues')) &&  !empty($inforward_settings['events-footer-sidebar']) ) {
		$result = Inforward_Widgets_Meta_Box::get_page_settings($inforward_settings['issues-footer-sidebar']);
	}

	
	if ( is_404() &&  !empty($inforward_settings['404-footer-sidebar']) ) {
	    $post_from_page_id = $inforward_settings['404-footer-sidebar'];
		if ( $post_from_page_id ) {
		$result = Inforward_Widgets_Meta_Box::get_page_settings($post_from_page_id);
		}
	}
	
extract($result);
?>

<div class="main-footer">

<?php if ( $footer_row_top_show ): ?>

	<div class="cp-fs-top">
	<?php if ( !$footer_row_top_full_width ): ?><div class="container"><?php endif; ?>
		<div class="row">

			<?php if ( !empty($footer_row_top_columns_variations) ):
				$number_of_top_columns = key( json_decode( html_entity_decode ( $footer_row_top_columns_variations ), true ) );
				$columns_top_array = json_decode( html_entity_decode ( $footer_row_top_columns_variations ), true );
				?>

				<?php for ( $i = 1; $i <= $number_of_top_columns; $i++ ): ?>

				<div class="col-sm-<?php echo esc_attr($columns_top_array[$number_of_top_columns][0][$i-1]); ?>">
					<?php if ( !dynamic_sidebar($get_sidebars_top_widgets[$i-1]) ) : endif; ?>
				</div>

			<?php endfor; ?>

			<?php endif; ?>

		</div>
	
	<?php if ( !$footer_row_top_full_width ): ?></div><?php endif; ?>
	</div>

<?php endif; ?>

<?php if ( $footer_row_middle_show ): ?>

	<div class="cp-fs-medium">
    <?php if ( !$footer_row_middle_full_width ): ?><div class="container"><?php endif; ?>
		<div class="row">

			<?php if ( !empty($footer_row_middle_columns_variations) ):
				$number_of_middle_columns = key( json_decode( html_entity_decode ( $footer_row_middle_columns_variations ), true ) );
				$columns_middle_array = json_decode( html_entity_decode ( $footer_row_middle_columns_variations ), true );
				?>

				<?php for ( $i = 1; $i <= $number_of_middle_columns; $i++ ): ?>

					<div class="col-sm-<?php echo esc_attr($columns_middle_array[$number_of_middle_columns][0][$i-1]); ?>">
						<?php if ( !dynamic_sidebar($get_sidebars_middle_widgets[$i-1]) ) : endif; ?>
					</div>

				<?php endfor; ?>

			<?php endif; ?>

		</div>

	<?php if ( !$footer_row_middle_full_width ): ?></div><?php endif; ?>
	</div>

<?php endif; ?>

<?php 
if($inforward_config['footer_type'] == 'footer-2') { 
?>

<div class="container">
<div class="copyright">

	<?php if ( !empty($inforward_settings['footer-copyright']) ): ?>
		<?php echo wpautop($inforward_settings['footer-copyright']); ?>
	<?php endif; ?>

</div>
</div>

<?php } ?>

</div>