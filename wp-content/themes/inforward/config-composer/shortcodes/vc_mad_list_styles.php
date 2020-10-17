<?php

class WPBakeryShortCode_VC_mad_list_styles extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'values' => '',
			'layout' => 'type-1'
		), $atts, 'vc_mad_list_styles');

		return $this->html();
	}

	public function html() {

	 	$list_items = $layout = $list_styles = $values = $style = '';

		extract($this->atts);

		ob_start(); ?>

		<?php if ( !empty($values) ): ?>

			<?php $values = explode('|', $values); ?>

			<?php if ( is_array($values) ): ?>

				<?php foreach( $values as $value ) {
					$value = trim($value);
					if( preg_match("/ul/i", $value) ) {
						$list_items .= "<li>{$value}</li>";
					} else {
						$list_items .= "<li>{$value}</li>";
					}
				} ?>

			<?php endif; ?>

			<div class="wpb_content_element">
				<?php if ( $layout !== 'type-6' ): ?>
					<ul class="cp-list custom-list <?php echo esc_attr($layout) ?>"><?php echo wp_kses( $list_items,
							array(
								'a' => array(
									'href' => true,
									'title' => true,
								),
								'li' => array(),
								'ul' => array(),
								'i' => array(
									'class' => true,
									'style' => true
								),
								'strong' => array()
							)
						) ?></ul>
				<?php else: ?>
					<ol class="cp-list custom-list <?php echo esc_attr($layout) ?>"><?php echo wp_kses( $list_items,
							array(
								'a' => array(
									'href' => true,
									'title' => true,
								),
								'li' => array(),
								'ul' => array(),
								'ol' => array(),
								'i' => array(
									'class' => true,
									'style' => true
								),
								'strong' => array()
							)
						) ?></ol>
				<?php endif; ?>
			</div><!--/ .wpb_content_element-->

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}