<?php get_header(); ?>

<?php global $inforward_settings;
$error_content = $inforward_settings['error-content'];
?>

<div class="page-404-section" >

	<div class="inner-404">
		<h1>404</h1>
        <p class="text-size-big"><?php echo esc_html__("We're sorry, but we can't find the page you were looking for.","inforward") ?></p>
		<p class="text-size-small"><?php echo html_entity_decode($error_content); ?></p>

		<div class="join-us style-3">
        <div class="search-holder">
        <form class="join-form" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">

            <button class="btn btn-style-4 btn-big f-right" type="submit"><?php echo esc_html__("Search","inforward") ?></button>
            
            <div class="input-holder">
                <input type="text" autocomplete="off" name="s" id="s" placeholder="<?php esc_attr_e( 'Search the site', 'inforward' ) ?>" value="<?php echo get_search_query(); ?>">
            </div>
            
        </form>
        </div>
        </div>

	</div>
</div>

<?php get_footer(); ?>