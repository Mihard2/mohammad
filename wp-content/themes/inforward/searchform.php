<form class="cp-lineform join-form" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<button class="btn btn-style-4 f-right btn-search" type="submit"></button>
	
	<div class="input-holder">
		<input type="text" autocomplete="off" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'inforward' ) ?>" value="<?php echo get_search_query(); ?>">
	</div>
</form>