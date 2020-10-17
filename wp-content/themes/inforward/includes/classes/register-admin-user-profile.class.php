<?php
/**
 * User profile social links for wp-admin
 *
 */
if ( !class_exists('inforward_admin_user_profile') ) {
	class inforward_admin_user_profile {

		public function __construct() {

			if ( is_admin() ) {

				add_action('show_user_profile', array($this, 'add_meta_fields'), 20);
				add_action('edit_user_profile', array($this, 'add_meta_fields'), 20);

				add_action('personal_options_update', array($this, 'save_meta_fields'));
				add_action('edit_user_profile_update', array($this, 'save_meta_fields'));
				

			}

		}

		function get_store_info($seller_id)
		{
			$info = get_user_meta($seller_id, 'inforward_profile_settings', true);
			$info = is_array($info) ? $info : array();
			$info = wp_parse_args($info, array('social' => array()));
			return $info;
		}

		function get_social_profile_fields()
		{
			$fields = array(
				'instagram' => array(
					'icon' => 'icon-instagram-5',
					'name' => 'insta-icon',
					'title' => esc_html__('Instagram', 'inforward'),
				),
				'twitter' => array(
					'icon' => 'icon-twitter',
					'name' => 'tweet-icon',
					'title' => esc_html__('Twitter', 'inforward'),
				),
				'gplus' => array(
					'icon' => 'icon-gplus-3',
					'name' => 'google-icon',
					'title' => esc_html__('Gplus', 'inforward'),
				),
				'facebook' => array(
					'icon' => 'icon-facebook',
					'name' => 'fb-icon',
					'title' => esc_html__('Facebook', 'inforward'),
				)
			);

			return apply_filters('inforward_profile_social_fields', $fields);
		}

		/**
		 * Add fields to user profile
		 *
		 * @param WP_User $user
		 *
		 * @return void|false
		 */
		function add_meta_fields($user)
		{
			$store_settings = $this->get_store_info($user->ID);
			$social_fields = $this->get_social_profile_fields();
			?>
			<h3><?php esc_html_e('Social Options', 'inforward'); ?></h3>

			<table class="form-table">
				<tbody>

				<?php foreach ( $social_fields as $key => $value ) : ?>

					<tr>
						<th><?php echo esc_html($value['title']); ?></th>
						<td>
							<input type="text" name="inforward_admin_social[<?php echo esc_attr($key); ?>]"
								   class="regular-text"
								   value="<?php echo isset($store_settings['social'][$key]) ? esc_url($store_settings['social'][$key]) : ''; ?>">
						</td>
					</tr>

				<?php endforeach; ?>

				<?php do_action('inforward_seller_meta_fields', $user); ?>

				</tbody>
			</table>
			<?php
		}

		public function output_social_links() {
			$social_fields = $this->get_social_profile_fields();
			$profile_info = $this->get_store_info(get_current_user_id());
			?>
			<ul class="cp-social-icons social-icons">

				<?php foreach ($social_fields as $key => $field) : ?>
					<?php if ( isset($profile_info['social'][$key]) && !empty($profile_info['social'][$key]) ) : ?>
						<li class="<?php echo isset($field['name']) ? $field['name'] : ''; ?>">
							<a target="_blank"
							   href="<?php echo isset($profile_info['social'][$key]) ? esc_url($profile_info['social'][$key]) : '' ?>">
								<i class="<?php echo isset($field['icon']) ? $field['icon'] : ''; ?>"></i>
							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>

			</ul>
			<?php
		}

		/**
		 * Save user data
		 *
		 * @param int $user_id
		 *
		 * @return void
		 */
		function save_meta_fields($user_id)
		{
			$store_settings = $this->get_store_info($user_id);

			$social = $_POST['inforward_admin_social'];
			$social_fields = $this->get_social_profile_fields();

			// social settings
			if (is_array($social)) {
				foreach ($social as $key => $value) {
					if (isset($social_fields[$key])) {
						$store_settings['social'][$key] = filter_var($social[$key], FILTER_VALIDATE_URL);
					}
				}
			}

			update_user_meta($user_id, 'inforward_profile_settings', $store_settings);
		}
	}
}