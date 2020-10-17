
<?php
wp_reset_postdata();

global $inforward_settings, $inforward_config;
$post_id = inforward_post_id();
$custom_sidebar = $inforward_settings['sidebar'];
if ( is_singular(array('post')) ) {
	$custom_sidebar = $inforward_settings['single-post-sidebar'];
}
if ( is_archive() ) {
	$custom_sidebar = $inforward_settings['archive-post-sidebar'];
}

if (class_exists('WooCommerce')) {
	if ( inforward_is_realy_woocommerce_page() ) {
		$custom_sidebar = $inforward_settings['product-sidebar'];
	}
}

$page_sidebar = trim(get_post_meta( $post_id, 'inforward_page_sidebar', true ));

if ( $page_sidebar ) {
	$custom_sidebar = $page_sidebar;
}

if ( is_singular(array('page', 'post')) && !empty($post_id) && $page_sidebar) {
	$custom_sidebar = $page_sidebar;
}

if ( inforward_is_product() ) {
		if ( !empty($post_id) && $page_sidebar ) {
			$custom_sidebar = $page_sidebar;
		}else {
			$custom_sidebar = $inforward_settings['product-single-sidebar'];
		}
	}
?>
<aside id="sidebar" class="col-md-4 col-sm-12 cp-sidebar">
	<?php
	if ( !empty($custom_sidebar) ) {
		dynamic_sidebar($custom_sidebar);
	} else {
		if ( is_active_sidebar('general-widget-area') ) {
			dynamic_sidebar('General Widget Area');
		} else {
		 ?>
			<div class="widget widget_archive">
				<h3 class="widget_title"><?php esc_html_e('Archives', 'inforward'); ?></h3>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</div>

			<div class="widget widget_meta">
				<h3 class="widget_title"><?php esc_html_e('Meta', 'inforward'); ?></h3>
				<ul>
					<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</div>
		<?php
		}
	}
	?>
</aside>