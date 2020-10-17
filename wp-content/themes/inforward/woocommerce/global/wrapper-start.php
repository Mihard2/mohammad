<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce_loop, $inforward_settings;

$woocommerce_columns = $inforward_settings['shop-product-cols'];

if ( inforward_is_product_category() || inforward_is_product_tax() ) {
	$woocommerce_columns = $inforward_settings['category-product-cols'];
}

$css_classes = array(
	'cp-products-holder'
);

if ( !empty( $woocommerce_columns ) ) { $css_classes[] = 'columns-' . absint($woocommerce_columns); }

$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
?>

<?php if ( !inforward_is_product() ): ?>
	<div class="<?php echo esc_attr( trim( $css_class ) ) ?>">
<?php endif; ?>