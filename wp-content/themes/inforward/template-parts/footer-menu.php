<?php
global $inforward_settings, $inforward_config;

if ( !$inforward_settings['show-footer-menu'] || $inforward_config['footer_classes'] == 'footer-1' || $inforward_config['footer_classes'] == 'footer-3' || $inforward_config['footer_classes'] == 'footer-4' || $inforward_config['footer_classes'] == 'footer-5') return;
?>

<div class="top-footer">       
    <div class="container">
	<?php
	echo Inforward_Helper::main_navigation( 'top-footer-menu', 'footer' );
	?>
	</div>

</div>

