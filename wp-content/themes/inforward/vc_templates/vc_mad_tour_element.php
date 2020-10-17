<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$title = $tag_title = $description = $title_color = $description_color = '';

extract( shortcode_atts( array(
	'title' => '',
	'tag_title' => 'h2',
	'description' => '',
	'title_color' => '',
	'description_color' => '',
	'type' => 'cp-type-1'
), $atts ) );

global $tabarr;
$tabarr = array();

do_shortcode( $content );

ob_start(); ?>

	<div class="wpb_content_element">

		<?php
		echo Inforward_Vc_Config::getParamTitle(
			array(
				'title' => $title,
				'tag_title' => $tag_title,
				'description' => $description,
				'title_color' => $title_color,
				'description_color' => $description_color,
			)
		);
		?>

		<div class="cp-tour-sections-holder <?php echo esc_attr($type) ?>">

			<nav class="cp-tabs-nav-wrap">

				<ul class="cp-tabs-nav">

					<?php if ( isset($tabarr) && !empty($tabarr) ): ?>

						<?php foreach( $tabarr as $key => $value ): ?>
							<li><a href="#tour-<?php echo esc_attr($value['tab_id']) ?>">
									<?php if (isset($value['icon']) && $value['icon'] != 'none'): ?>
										<span class="<?php echo esc_attr($value['icon']) ?>"></span>
									<?php endif; ?>
								<?php echo esc_html($value['title']) ?></a>
							</li>
						<?php endforeach; ?>

					<?php endif; ?>

				</ul>

			</nav>

			<div class="cp-tabs-container">
				<?php echo wpb_js_remove_wpautop( $content ) ?>
			</div>

		</div><!--/ .cp-tour-sections-holder-->

	</div>

<?php echo ob_get_clean();
