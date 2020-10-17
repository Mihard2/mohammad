<?php
/**
* Countdown
*/
class WPBakeryShortCode_VC_mad_countdown extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        $this->atts = shortcode_atts(array(
            'title' => '',
            'datetime'=>'',
            'text_align' => '',
            'el_class' => '',
        ), $atts, 'vc_mad_countdown');

		wp_enqueue_script( 'jquery-countdown-plugin' );
		wp_enqueue_script( 'jquery-countdown' );
		
        return $this->html();
    }

    public function html() {

        $title = $datetime = $text_align = $el_class = $class_align = '';

        extract($this->atts);

		
        if ( $text_align == 'center' ){
            $class_align = 'align_center';
        } else if ( $text_align == 'right' ) {
            $class_align = 'align_right';
        } else if ( $text_align == 'left' ) {
            $class_align = 'align_left';
        }

        ob_start(); ?>

        <div class="cp-coming-soon-section <?php echo sanitize_html_class($class_align); ?>">
            <?php if ( $title != '' ) : ?><p class="mini_title"><?php echo esc_attr( $title ); ?></p><?php endif; ?>
			<div class="cp-countdown-holder cp-type-1 <?php echo sanitize_html_class($el_class); ?>" data-terminal_date="<?php echo esc_attr($datetime); ?>" data-time-now="<?php echo str_replace('-', '/', current_time('mysql'));?>"></div>
       
	   
	    <script>
		(function($){
			'use strict';

			$(window).on("load",function(){
		
		$('.cp-countdown-holder').each(function(){
			var $this = $(this),
				endDate = $this.data(),
				until = new Date(
					endDate.terminal_date
				);
			// initialize
			$this.countdown({
				until : until,
				format : 'dHMS',
				labels : ['Years', 'Month', 'Weeks', 'Days', 'Hours', 'Minutes', 'Seconds']
			});
		});
		
		//$('.cp-countdown-holder').countdown('pause');	
		
		});
		
		})(jQuery);
		</script>
	   
	   
		</div>

        <?php return ob_get_clean();
    }

}