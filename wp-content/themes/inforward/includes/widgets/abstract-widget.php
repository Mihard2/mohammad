<?php
/**
 * Abstract MAD Class
 *
 * @author   Velikorodnov
 * @category Widgets
 * @package  widgets/
 * @version  1.9
 * @extends  WP_Widget
 */
abstract class Inforward_Widget extends WP_Widget {

	/**
	 * CSS class
	 *
	 * @var string
	 */
	public $widget_cssclass;

	/**
	 * Widget description
	 *
	 * @var string
	 */
	public $widget_description;

	/**
	 * Widget ID
	 *
	 * @var string
	 */
	public $widget_id;

	/**
	 * Widget name
	 *
	 * @var string
	 */
	public $widget_name;

	/**
	 * Settings
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * Constructor
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => $this->widget_cssclass,
			'description' => $this->widget_description
		);

		parent::__construct($this->widget_id, $this->widget_name, $widget_ops);

		add_action( 'save_post', array( $this, 'widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'widget_cache' ) );
	}

	/**
	 * get_cached_widget function.
	 */
	public function get_cached_widget( $args ) {

		$cache = wp_cache_get( apply_filters( 'woocommerce_cached_widget_id', $this->widget_id ), 'widget' );

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post($cache[ $args['widget_id'] ]);
			return true;
		}

		return false;
	}

	/**
	 * Cache the widget
	 *
	 * @param  array $args
	 * @param  string $content
	 * @return string the content that was cached
	 */
	public function cache_widget( $args, $content ) {
		wp_cache_set( apply_filters( 'woocommerce_cached_widget_id', $this->widget_id ), array( $args['widget_id'] => $content ), 'widget' );

		return $content;
	}

	/**
	 * Flush the cache
	 *
	 * @return void
	 */
	public function widget_cache() {
		wp_cache_delete( apply_filters( 'woocommerce_cached_widget_id', $this->widget_id ), 'widget' );
	}

	/**
	 * Output the html at the start of a widget
	 *
	 * @param  array $args
	 * @return string
	 */
	public function widget_start( $args, $instance ) {
		
		if ( isset($instance['type']) && !empty($instance['type']) ) {
		   $args['before_widget'] = str_replace( $this->widget_cssclass, $this->widget_cssclass. ' custom_' . $instance['type'], $args['before_widget'] ); 
		}
		
		echo wp_kses_post($args['before_widget']);

		if ( isset($instance['color_title']) && !empty($instance['color_title']) ) {
			$args['before_title'] = '<h5 class="cp-widget-title wt-title" style="color: '. $instance['color_title'] .'">';
			$args['after_title'] = '</h5>';
		}
		
		if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) {
			echo wp_kses_post($args['before_title']) . $title . wp_kses_post($args['after_title']);
		}
	}

	/**
	 * Output the html at the end of a widget
	 *
	 * @param  array $args
	 * @return string
	 */
	public function widget_end( $args ) {
		echo wp_kses_post($args['after_widget']);
	}

	/**
	 * update function.
	 *
	 * @see WP_Widget->update
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		if ( ! $this->settings ) {
			return $instance;
		}

		foreach ( $this->settings as $key => $setting ) {
			if ( isset( $new_instance[ $key ] ) ) {
				$instance[ $key ] = $new_instance[ $key ];
			} elseif ( 'checkbox' === $setting['type'] ) {
				$instance[ $key ] = 0;
			}
		}

		$this->widget_cache();

		return $instance;
	}

	/**
	 * form function.
	 *
	 * @see WP_Widget->form
	 * @param array $instance
	 */
	public function form( $instance ) {

		if ( ! $this->settings ) { return; }

		foreach ( $this->settings as $key => $setting ) {

			$value = isset( $instance[ $key ] ) ? $instance[ $key ] : $setting['std'];

			switch ( $setting['type'] ) {

				case 'text' :
					?>
					<p>
						<label for="<?php echo esc_attr($this->get_field_id( $key )); ?>"><?php echo esc_attr($setting['label']); ?></label>
						<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr($this->get_field_name( $key )); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
					</p>
					<?php
				break;
				
				case 'textarea' :
					?>
					<p>
						<label for="<?php echo esc_attr($this->get_field_id( $key )); ?>"><?php echo esc_attr($setting['label']); ?></label>
						<textarea class="widefat" rows="10" cols="20" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr($this->get_field_name( $key )); ?>"><?php echo wp_kses_post($value); ?></textarea>
						
					</p>
					<?php
				break;

				case 'number' :
					?>
					<p>
						<label for="<?php echo esc_attr($this->get_field_id( $key )); ?>"><?php echo esc_attr($setting['label']); ?></label>
						<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr($this->get_field_name( $key )); ?>" type="number" step="<?php  if ( isset( $setting['step']) && !empty( $setting['step']) ) { echo esc_attr( $setting['step'] ); } ?>" min="<?php if ( isset( $setting['min']) && !empty( $setting['min']) ) { echo esc_attr( $setting['min'] ); } ?>" max="<?php if ( isset( $setting['max']) && !empty( $setting['max']) ) { echo esc_attr( $setting['max'] ); } ?>" value="<?php echo esc_attr( $value ); ?>" />
					</p>
					<?php
				break;

				case 'select' :
					?>
					<p>
						<label for="<?php echo esc_attr($this->get_field_id( $key )); ?>"><?php echo esc_attr($setting['label']); ?></label>
						<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr($this->get_field_name( $key )); ?>">
							<?php foreach ( $setting['options'] as $option_key => $option_value ) : ?>
								<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $value ); ?>><?php echo esc_html( $option_value ); ?></option>
							<?php endforeach; ?>
						</select>
						<?php if ( isset($setting['desc']) && !empty($setting['desc']) ): ?>
							<small><?php echo esc_html($setting['desc']) ?></small>
						<?php endif; ?>
					</p>
					<?php
				break;

				case 'checkbox' :
					?>
					<p>
						<input id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="checkbox" value="1" <?php checked( $value, 1 ); ?> />
						<label for="<?php echo esc_attr($this->get_field_id( $key )); ?>"><?php echo esc_attr($setting['label']); ?></label>
					</p>
					<?php
				break;

				case 'icon' :
					?>
					<p>
						<label for="<?php echo esc_attr($this->get_field_id( $key )); ?>"><?php echo esc_attr($setting['label']); ?></label>
						<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr($this->get_field_name( $key )); ?>">
							<?php 
							$setting = array();
							
							$setting['options'] = inforward_lnr_icons_list(); 
			
							foreach ( $setting['options'] as $option_key => $option_value ) : ?>
								<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $value ); ?>><?php echo esc_html( $option_value ); ?></option>
							<?php endforeach; ?>
						</select>
						<?php if ( isset($setting['desc']) && !empty($setting['desc']) ): ?>
							<small><?php echo esc_html($setting['desc']) ?></small>
						<?php endif; ?>
					</p>
					<?php
				break;				
				
				
				case 'colorpicker' :
					?>
					<p>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								$('#<?php echo esc_attr($this->get_field_id( $key )); ?>').wpColorPicker();
							});
						</script>
						<label for="<?php echo esc_attr($this->get_field_id( $key )); ?>"><?php echo esc_attr($setting['label']); ?></label><br>
						<input id="<?php echo esc_attr($this->get_field_id( $key )); ?>" type="text" name="<?php echo esc_attr($this->get_field_name( $key )); ?>" value="<?php echo esc_attr( $value ); ?>" />
					</p>
					<?php
				break;
			}
		}
	}
}