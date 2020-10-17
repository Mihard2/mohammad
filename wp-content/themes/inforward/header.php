<!DOCTYPE html>
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" <?php language_attributes(); ?>>  <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<?php
global $inforward_config;
$page_wrapper = $inforward_config['page_wrapper'];
$header_classes = $inforward_config['header_classes'];
$header_type = $inforward_config['header_type'];
$header_bg = $inforward_config['header-bg'];
$sidebar_position = $inforward_config['sidebar_position'];
$page_content_classes = $inforward_config['page_content_classes'];
?>

<body <?php body_class(); ?>>

<?php do_action('inforward_body_append'); ?>

<div id="wrapper" class="wrapper-container sidebar_<?php echo esc_attr($sidebar_position) ?> <?php echo esc_attr($page_wrapper) ?>">

	    <nav id="mobile-advanced" class="mobile-advanced"></nav>

		<?php do_action('inforward_header_prepend') ?>
		<header id="header" class="cp-header sticky-header <?php echo esc_attr($header_classes); ?>" data-bg="<?php echo esc_url($header_bg); ?>" >
			<?php do_action( 'inforward_header_layout', $header_type ); ?>
		</header>
		<?php do_action('inforward_header_append') ?>

	<?php
		/**
		 * inforward_header_after hook
		 *
		 * @hooked page_title_and_breadcrumbs
		 */

		do_action('inforward_header_after');
	?>

	<div id="content" class="<?php echo esc_attr($page_content_classes) ?>">

		<?php if ( $sidebar_position != 'cp-no-sidebar' ): ?>

			<div class="container <?php echo esc_attr($inforward_config['content-size']) ?>">

				<div class="row">

					<main id="main" class="col-md-8 col-sm-12">

		<?php else: ?>

			<div class="container <?php echo esc_attr($inforward_config['content-size']) ?>">

				<div class="row">

					<div class="col-sm-12">

		<?php endif; ?>