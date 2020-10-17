<?php

if ( ! function_exists('inforward_vc_manager') ) {
	function inforward_vc_manager() {
		return Inforward_Vc_Config::getInstance();
	}
}

if ( ! function_exists('inforward_vc_asset_url') ) {
	function inforward_vc_asset_url( $file ) {
		return inforward_vc_manager()->assetUrl( $file );
	}
}

if ( ! function_exists('inforward_get_sort_classes') ) {
	function inforward_get_sort_classes() {
		$classes = "";
		$item_categories = get_the_terms( get_the_ID(), 'portfolio_categories' );
		if ( is_object($item_categories) || is_array($item_categories) ) {
			foreach ($item_categories as $cat) {
				$classes .= $cat->slug . ' ';
			}
		}
		return str_replace( '%', '', $classes );
	}
}

