<?php

if (!class_exists('Inforward_Team_Members_Config')) {

	class Inforward_Team_Members_Config extends Inforward_Functionality {

		public $slug = 'team-members';

		function __construct() {
			$this->init();
		}

		public function init() {

			$args = array(
				'labels' => $this->getLabels(
					esc_html__('Team Member', 'inforward_app_textdomain'),
					esc_html__('Team Members', 'inforward_app_textdomain')
				),
				'public' => true,
				'archive' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => true,
				'menu_position' => null,
				'taxonomies' => array('team_category'),
				'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
				'rewrite' => array('slug' => $this->slug),
				'show_in_admin_bar' => true,
				'menu_icon' => 'dashicons-businessman'
			);

			register_post_type($this->slug, $args);

			register_taxonomy('team_category', $this->slug, array(
				'hierarchical' => true,
				"label" => "Categories",
				'query_var' => true,
				'rewrite' => true,
				'public' => true,
				'show_admin_column' => true
			) );

			flush_rewrite_rules(false);

			add_action("manage_" . $this->slug . "_posts_columns", array(&$this, "show_edit_columns"));
			add_action("manage_" . $this->slug . "_posts_custom_column", array(&$this, "show_edit_columns_content"));
		}

		public function show_edit_columns($columns) {
			$new_columns = array(
				'cb'    => '<input type="checkbox" />',
				"thumb column-comments" => esc_html__('Thumb', 'inforward_app_textdomain'),
				"title" => esc_html__("Name", 'inforward_app_textdomain'),
				"position" => esc_html__("Position", 'inforward_app_textdomain'),
				"linkedin" => esc_html__("LinkedIn", 'inforward_app_textdomain'),
				"tumblr" => esc_html__("Tumblr", 'inforward_app_textdomain'),
				"gplus" => esc_html__("Gplus", 'inforward_app_textdomain'),
				"twitter" => esc_html__("Twitter", 'inforward_app_textdomain'),
				"instagram" => esc_html__("Instagram", 'inforward_app_textdomain'),
				"facebook" => esc_html__("Facebook", 'inforward_app_textdomain')
			);
			$columns = array_merge($new_columns, $columns);
			return $columns;
		}

		public function show_edit_columns_content($column) {
			global $post;

			switch ($column) {
				case "thumb column-comments":
					if (has_post_thumbnail($post->ID)) {
						echo get_the_post_thumbnail($post->ID, array(60, 60));
					}
					break;
				case "position":
					echo get_post_meta($post->ID, 'inforward_tm_position', true);
					break;
				case "linkedin":
					echo get_post_meta($post->ID, 'inforward_tm_linkedin', true);
					break;
				case "tumblr":
					echo get_post_meta($post->ID, 'inforward_tm_tumblr', true);
					break;
				case "gplus":
					echo get_post_meta($post->ID, 'inforward_tm_gplus', true);
					break;
				case "twitter":
					echo get_post_meta($post->ID, 'inforward_tm_twitter', true);
					break;
				case "instagram":
					echo get_post_meta($post->ID, 'inforward_tm_instagram', true);
					break;
				case "facebook":
					echo get_post_meta($post->ID, 'inforward_tm_facebook', true);
					break;
			}

		}

	}

}