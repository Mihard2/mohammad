<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop, $inforward_settings;

// Get visble related products then sort them at random.
$related_products = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $inforward_settings['product-related-count'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

// Handle orderby.
$related_products = wc_products_array_orderby( $related_products, 'rand', 'desc' );

if ( $related_products  && $inforward_settings['product-related'] ) : ?>

	<section class="related products widget widget-bg">

		<h5 class="wt-title"><?php esc_html_e( 'Related products', 'inforward' ); ?></h5>

		<ul class="products-holder">

			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
				 	$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'widget-product' ); ?>

			<?php endforeach; ?>

		</ul>

	</section>

<?php endif;

wp_reset_postdata();
