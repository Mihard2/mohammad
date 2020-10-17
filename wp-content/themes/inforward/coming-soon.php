<?php
/*
Template Name: Coming soon
*/
?>

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

<body <?php body_class(); ?>>
<div id="wrapper" class="wrapper-container">
<div class="landing">
<div class="media-holder" >
<?php global $inforward_settings; ?>

 	<header>
          <div class="align-center">
            <?php echo inforward_logo(); ?>
          </div>
    </header>

	<div class="landing-container">    
     <div class="coming-soon">
	<?php if(have_posts()): ?>
		<?php while(have_posts()): the_post(); ?>
			<?php if(has_post_thumbnail()):
				$page_bg = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
			endif; ?>
			<div class="stm-coming-soon-centered">
				<div class="container">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
    </div>
    </div>
    
<?php if(!empty($page_bg[0])): ?>
	<style>
		.media-holder {
			background-image: url("<?php echo esc_url($page_bg[0]); ?>");
		}
	</style>
<?php endif; ?>

 <footer class="footer">
          
          <div class="container">
            <div class="flex-row flex-justify">

              <div class="copyright">
                  
                <?php if ( !empty($inforward_settings['coming-soon-copyright']) ): ?>
					<?php echo wpautop($inforward_settings['coming-soon-copyright']); ?>
                <?php endif; ?>
                
              </div>
              <div class="widget">
                <?php if ( !empty($inforward_settings['coming-soon-donate-url']) ): ?>
                <p class="align-right"><a target="_blank" href="<?php echo esc_url($inforward_settings['coming-soon-donate-url']) ?>" class="btn btn-style-6 btn-big"><?php echo esc_attr__('Donate','inforward') ?></a></p>
                <?php endif; ?>

				<?php if ( !empty($inforward_settings['coming-soon-social']) && $inforward_settings['coming-soon-social'] ): ?>
                <ul class="social-icons">

                  <?php if ( $inforward_settings['coming-soon-social-linkedin']): ?>
                  <li><a href="<?php echo esc_url($inforward_settings['coming-soon-social-linkedin']) ?>"><i class="icon-facebook"></i></a></li>
                  <?php endif; ?>
                  
                   <?php if ( $inforward_settings['coming-soon-social-linkedin']): ?>
                  <li><a href="<?php echo esc_url($inforward_settings['coming-soon-social-linkedin']) ?>"><i class="icon-twitter"></i></a></li>
                  <?php endif; ?>
                  
                   <?php if ( $inforward_settings['coming-soon-social-linkedin']): ?>
                  <li><a href="<?php echo esc_url($inforward_settings['coming-soon-social-linkedin']) ?>"><i class="icon-instagram-5"></i></a></li>
                  <?php endif; ?>
                   <?php if ( $inforward_settings['coming-soon-social-linkedin']): ?>
                  
                  <li><a href="<?php echo esc_url($inforward_settings['coming-soon-social-linkedin']) ?>"><i class="icon-youtube-play"></i></a></li>
                  
                  <?php endif; ?>
                   <?php if ( $inforward_settings['coming-soon-social-linkedin']): ?>
                  <li><a href="<?php echo esc_url($inforward_settings['coming-soon-social-linkedin']) ?>"><i class="icon-flickr"></i></a></li>
                  
                  <?php endif; ?>
                   <?php if ( $inforward_settings['coming-soon-social-linkedin']): ?>
                  <li><a href="<?php echo esc_url($inforward_settings['coming-soon-social-linkedin']) ?>"><i class="icon-snapchat-ghost"></i></a></li>
                  <?php endif; ?>

                </ul>
                <?php endif; ?>

              </div>
            </div>
          </div>

</footer>

<div id="footer-scroll"></div>
</div>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>