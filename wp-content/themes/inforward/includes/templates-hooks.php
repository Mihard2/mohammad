<?php

if (!class_exists('Inforward_Hooks')) {

	class Inforward_Hooks {

		function __construct() {
			add_action('init', array($this, 'init'));
		}

		public function init() {
			$this->add_hooks();
		}

		public function add_hooks() {

			global $inforward_settings;

			add_action('inforward_header_layout', array($this, 'template_header_layout_hook'));

			if ( $inforward_settings['show-loading-overlay'] ) {
				add_action('inforward_body_append', array( $this, 'preloader' ));
			}

			add_action( 'inforward_header_after', array( $this, 'header_after_hook' ) );
			add_action( 'inforward_footer_in_top_part', array( $this, 'template_footer_newsletter' ), 9 );
			add_action( 'inforward_footer_in_top_part', array( $this, 'template_footer_menu' ), 8 );
			add_action( 'inforward_footer_in_top_part', array( $this, 'template_footer' ) );
		}

		public function template_header_layout_hook($type) {
			get_template_part( 'template-parts/header', $type );
		}

		public function template_footer_newsletter() {
			get_template_part( 'template-parts/footer', 'newsletter' );
		}
		
		public function template_footer_menu() {
			get_template_part( 'template-parts/footer', 'menu' );
		}
		
		public function template_footer() {
			get_template_part( 'template-parts/footer', 'widgets' );
		}

		public function header_after_hook() {
			$this->page_title_and_breadcrumbs();
		}

		public function preloader() { ?><div class="loader cp-preloader"></div><?php }

		public function page_title_and_breadcrumbs() {

			global $inforward_settings, $inforward_config;
			
					$pagetitle = 'true';
					$breadcrumb = 'true';
					$page_title_align = 'left';
					$page_title_color = '';
					$breadcrumbs_bg_color = '';
					$breadcrumbs_bg_image = '';
					$breadcrumbs_bg_repeat = '';
					$breadcrumbs_bg_size = '';
					$breadcrumbs_bg_attachment = '';
					$breadcrumbs_bg_position = '';
					
			$post_id = inforward_post_id();
			$mode = 'default';
			
			if ( $post_id && get_post_meta( $post_id, 'inforward_page_title_style', true ) ) {
			$mode    = get_post_meta( $post_id, 'inforward_page_title_style', true );
			}
		
			if ( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ) {
				$mode = 'shop-default';
			}
		
			switch ( $mode ) {
				case 'shop-default':
					$breadcrumb = $inforward_settings['shop-show-breadcrumbs'];
					$pagetitle = $inforward_settings['shop-show-pagetitle'];
					$page_title_align = $inforward_settings['shop-align-breadcrumbs'];
					$page_title_color = $inforward_settings['shop-breadcrumbs-title-color'];
					$breadcrumbs_bg_color = $inforward_settings['shop-breadcrumbs-bg']['background-color'];
					$breadcrumbs_bg_image = str_replace(array('http://', 'https://'), array('//', '//'), $inforward_settings['shop-breadcrumbs-bg']['background-image']);
					$breadcrumbs_bg_repeat = $inforward_settings['shop-breadcrumbs-bg']['background-repeat'];
					$breadcrumbs_bg_size = $inforward_settings['shop-breadcrumbs-bg']['background-size'];
					$breadcrumbs_bg_attachment = $inforward_settings['shop-breadcrumbs-bg']['background-attachment'];
					$breadcrumbs_bg_position = $inforward_settings['shop-breadcrumbs-bg']['background-position'];
				break;
				case 'default':
					$breadcrumb = $inforward_settings['show-breadcrumbs'];
					$pagetitle = $inforward_settings['show-pagetitle'];
					$page_title_align = $inforward_settings['align-breadcrumbs'];
					$page_title_color = $inforward_settings['breadcrumbs-title-color'];
					$breadcrumbs_bg_color = $inforward_settings['breadcrumbs-bg']['background-color'];
					$breadcrumbs_bg_image = str_replace(array('http://', 'https://'), array('//', '//'), $inforward_settings['breadcrumbs-bg']['background-image']);
					$breadcrumbs_bg_repeat = $inforward_settings['breadcrumbs-bg']['background-repeat'];
					$breadcrumbs_bg_size = $inforward_settings['breadcrumbs-bg']['background-size'];
					$breadcrumbs_bg_attachment = $inforward_settings['breadcrumbs-bg']['background-attachment'];
					$breadcrumbs_bg_position = $inforward_settings['breadcrumbs-bg']['background-position'];
				break;
				case 'custom':
					$breadcrumb = get_post_meta( $post_id, 'inforward_hide_breadcrumb', true );
					$pagetitle = get_post_meta( $post_id, 'inforward_hide_pagetitle', true );
					$page_title_align = get_post_meta( $post_id, 'inforward_page_title_align', true );
					$page_title_color = get_post_meta( $post_id, 'inforward_page_title_color', true );
					$breadcrumbs_bg_color = get_post_meta( $post_id, 'inforward_page_title_bg_color', true );
					$breadcrumbs_bg_image = get_post_meta( $post_id, 'inforward_page_title_bg_image', true );

					if ( !empty($breadcrumbs_bg_image) && $breadcrumbs_bg_image != '' ) {
						if ( isset($breadcrumbs_bg_image) ) {
							$breadcrumbs_bg_image = wp_get_attachment_image_src($breadcrumbs_bg_image, '');

							if ( is_array($breadcrumbs_bg_image) && isset($breadcrumbs_bg_image[0]) ) {
								$breadcrumbs_bg_image = $breadcrumbs_bg_image[0];
							}
						}
					} else{
						$breadcrumbs_bg_image = '';
					}
					
					$breadcrumbs_bg_repeat = get_post_meta( $post_id, 'inforward_page_title_bg_image_repeat', true );
					$breadcrumbs_bg_size = '';
					$breadcrumbs_bg_attachment = '';
					$breadcrumbs_bg_position = get_post_meta( $post_id, 'inforward_page_title_bg_image_position', true );
				break;
				case 'custom_big':
					$breadcrumb = get_post_meta( $post_id, 'inforward_hide_breadcrumb', true );
					$pagetitle = get_post_meta( $post_id, 'inforward_hide_pagetitle', true );
					$page_title_align = get_post_meta( $post_id, 'inforward_page_title_align', true );
					$page_title_color = get_post_meta( $post_id, 'inforward_page_title_color', true );
					$breadcrumbs_bg_color = get_post_meta( $post_id, 'inforward_page_title_bg_color', true );
					$breadcrumbs_bg_image = get_post_meta( $post_id, 'inforward_page_title_bg_image', true );

					if ( !empty($breadcrumbs_bg_image) && $breadcrumbs_bg_image != '' ) {
						if ( isset($breadcrumbs_bg_image) ) {
							$breadcrumbs_bg_image = wp_get_attachment_image_src($breadcrumbs_bg_image, '');

							if ( is_array($breadcrumbs_bg_image) && isset($breadcrumbs_bg_image[0]) ) {
								$breadcrumbs_bg_image = $breadcrumbs_bg_image[0];
							}
						}
					} else{
						$breadcrumbs_bg_image = '';
					}
					
					$breadcrumbs_bg_repeat = get_post_meta( $post_id, 'inforward_page_title_bg_image_repeat', true );
					$breadcrumbs_bg_size = '';
					$breadcrumbs_bg_attachment = '';
					$breadcrumbs_bg_position = get_post_meta( $post_id, 'inforward_page_title_bg_image_position', true );
				break;
				case 'custom_big2':
					$breadcrumb = get_post_meta( $post_id, 'inforward_hide_breadcrumb', true );
					$pagetitle = get_post_meta( $post_id, 'inforward_hide_pagetitle', true );
					$page_title_align = get_post_meta( $post_id, 'inforward_page_title_align', true );
					$page_title_color = get_post_meta( $post_id, 'inforward_page_title_color', true );
					$breadcrumbs_bg_color = get_post_meta( $post_id, 'inforward_page_title_bg_color', true );
					$breadcrumbs_bg_image = get_post_meta( $post_id, 'inforward_page_title_bg_image', true );

					if ( !empty($breadcrumbs_bg_image) && $breadcrumbs_bg_image != '' ) {
						if ( isset($breadcrumbs_bg_image) ) {
							$breadcrumbs_bg_image = wp_get_attachment_image_src($breadcrumbs_bg_image, '');

							if ( is_array($breadcrumbs_bg_image) && isset($breadcrumbs_bg_image[0]) ) {
								$breadcrumbs_bg_image = $breadcrumbs_bg_image[0];
							}
						}
					} else{
						$breadcrumbs_bg_image = '';
					}
					
					$breadcrumbs_bg_repeat = get_post_meta( $post_id, 'inforward_page_title_bg_image_repeat', true );
					$breadcrumbs_bg_size = '';
					$breadcrumbs_bg_attachment = '';
					$breadcrumbs_bg_position = get_post_meta( $post_id, 'inforward_page_title_bg_image_position', true );
				break;
			}

	if( is_array($page_title_align) ) {
	$page_title_align = implode('',$page_title_align);
	}
		
			if ( $mode == 'none' || is_front_page() || is_404() || ( ! $pagetitle && !$breadcrumb) ) return; 

			?>

	<?php if ($mode == 'custom_big') { ?>
    <div class="media-holder style-4" data-bg="<?php echo esc_url($breadcrumbs_bg_image); ?>" >
    <?php } elseif ($mode == 'custom_big2') { ?>
	<div class="media-holder style-3" data-bg="<?php echo esc_url($breadcrumbs_bg_image); ?>" >
	 <?php } ?>

			<div class="breadcrumbs-wrap with-bg show_title_<?php echo esc_attr($pagetitle); ?> mode_<?php echo esc_attr($mode); ?>" style="color:<?php echo esc_attr($page_title_color) ?>;text-align:<?php echo esc_attr($page_title_align) ?>;<?php if(!empty($breadcrumbs_bg_image) && $breadcrumbs_bg_image != '' && $mode != 'custom_big' && $mode != 'custom_big2' ) { echo 'background-image:url('.$breadcrumbs_bg_image.')'; } ?>;background-repeat:<?php echo esc_attr($breadcrumbs_bg_repeat) ?>;background-size:<?php echo esc_attr($breadcrumbs_bg_size) ?>;background-attachment:<?php echo esc_attr($breadcrumbs_bg_attachment) ?>;background-position:<?php echo esc_attr($breadcrumbs_bg_position) ?>;background-color:<?php echo esc_attr($breadcrumbs_bg_color) ?>;">

			<div class="container <?php echo esc_attr($inforward_config['content-size']) ?> ">
			
				<?php if ( is_page() ): ?>

					<?php if ( $pagetitle ): ?>
						<?php echo inforward_title(array( 'heading' => 'h1', 'title_color' => $page_title_color )); ?>
					<?php endif; ?>

					<?php if ( $breadcrumb ): ?>
						<ul class="cp-breadcrumbs breadcrumbs" style="color:<?php echo esc_attr($page_title_color); ?>;">
							<?php echo inforward_breadcrumbs(array(
								'separator' => '/'
							)); ?>
						</ul>
					<?php endif; ?>

				<?php elseif ( is_single() ): ?>

					<?php if ( $pagetitle ): ?>
					<?php echo inforward_title(array( 'heading' => 'h1' )); ?>
                    <?php endif; ?>
                    
						<?php if ( $breadcrumb ): ?>
						<ul class="cp-breadcrumbs breadcrumbs">
							<?php echo inforward_breadcrumbs(array(
								'separator' => '/'
							)); ?>
						</ul>
						<?php endif; ?>

				<?php elseif ( is_search() ): global $wp_query; ?>

					<?php if ( !empty($wp_query->found_posts) ): ?>

						<?php if ($wp_query->found_posts > 1): ?>

							<?php
							echo inforward_title(
								array(
									'title' => esc_html__('Search results for:', 'inforward')." " . esc_attr(get_search_query()) . " (". $wp_query->found_posts .")"
								)
							); ?>

						<?php else: ?>

							<?php
							echo inforward_title(
								array(
									'title' => esc_html__('Search result for:', 'inforward')." " . get_search_query() . " (". $wp_query->found_posts .")"
								)
							); ?>

						<?php endif; ?>

					<?php else: ?>

						<?php if ( !empty($_GET['s']) ): ?>

							<?php
							echo inforward_title(
								array(
									'title' => esc_html__('Search results for:', 'inforward') . " " . get_search_query()
								)
							); ?>

						<?php else: ?>

							<?php
							echo inforward_title(
								array(
									'title' => esc_html__('To search the site please enter a valid term', 'inforward')
								)
							); ?>

						<?php endif; ?>

					<?php endif; ?>

				<?php else: ?>

					<?php if ( is_archive() || is_front_page() ): ?>

						<?php
						
						$title = get_the_archive_title();
						if ( is_tax( get_object_taxonomies( 'tribe_events' ) ) || is_post_type_archive('tribe_events') ) {
							$title = esc_html__('Events','inforward');
						}
						if ( is_post_type_archive('product') ) {
							if ( $pagetitle ) { 
							$title = esc_html__('Products','inforward');
							} else {
								$title = '';
							}
						}
						
							echo inforward_title(
								array(
									'title' => $title
								)
							); 
							
						?>

						<?php if ( $breadcrumb ): ?>

						<ul class="cp-breadcrumbs breadcrumbs">
							<?php echo inforward_breadcrumbs(array(
								'separator' => '/'
							)); ?>
						</ul>

						<?php endif; ?>

					<?php else: ?>

						<?php
						echo inforward_title(
							array(
								'title' => get_the_archive_title()
							)
						); ?>

					<?php endif; ?>

				<?php endif; ?>

			</div></div>
            
            <?php if ($mode == 'custom_big' || $mode == 'custom_big2') { ?>
               </div>
            <?php } ?>
    
			<?php
		}

		/* 	Get Cookie
		/* ---------------------------------------------------------------------- */

		public static function getcookie( $name ) {
			if ( isset( $_COOKIE[$name] ) )
				return maybe_unserialize( stripslashes( $_COOKIE[$name] ) );

			return array();
		}

	}

	new Inforward_Hooks();
}
