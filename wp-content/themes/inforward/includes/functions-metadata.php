<?php
require_once( get_theme_file_path('includes/metadata/meta_values.php') );
require_once( get_theme_file_path('includes/metadata/functions-types.php') );
require_once( get_theme_file_path('includes/metadata/product.php') );

if (!function_exists('inforward_get_meta_value')) {

	function inforward_get_meta_value($meta_key) {

		$value = '';

		if (inforward_is_product_category()) {
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

			if ($term) {
				$value = get_metadata($term->taxonomy, $term->term_id, $meta_key, true);
			}
		}

		return $value;
	}

}
