<?php

$target_arr = array(
	esc_html__( 'Same window', 'inforward' ) => '_self',
	esc_html__( 'New window', 'inforward' ) => '_blank',
);

function inforward_vc_map_add_css_animation( $label = true ) {
	$data = array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'CSS Animation', 'inforward' ),
		'param_name' => 'css_animation',
		'admin_label' => $label,
		'value' => array(
			esc_html__( 'No', 'inforward' ) => '',
			esc_html__( 'Fade In Up', 'inforward' ) => 'fadeInUp',
			esc_html__( 'Zoom In Down', 'inforward' ) => 'zoomInDown',
			esc_html__( 'Bounce In Down', 'inforward' ) => 'bounceInDown',
			esc_html__( 'Bounce In Up', 'inforward' ) => 'bounceInUp',
			esc_html__( 'Flip In Y', 'inforward' ) => 'flipInY',
		),
		'group' => esc_html__( 'Animations', 'inforward' ),
		'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'inforward' )
	);

	return apply_filters( 'inforward_vc_map_add_css_animation', $data, $label );
}

function inforward_vc_map_add_animation_delay( $label = true ) {
	$data = array(
		'type' => 'number',
		'heading' => esc_html__( 'Animation delay', 'inforward' ),
		'param_name' => 'animation_delay',
		'admin_label' => $label,
		'description' => '',
		'value' => 0,
		'dependency' => array(
			'element' => 'css_animation',
			'not_empty' => true
		),
		'group' => esc_html__( 'Animations', 'inforward' )
	);

	return apply_filters( 'inforward_vc_map_add_animation_delay', $data, $label );
}

function inforward_vc_map_add_scroll_factor( $label = true ) {
	$data = array(
		'type' => 'number',
		'heading' => esc_html__( 'Scroll factor', 'inforward' ),
		'param_name' => 'scroll_factor',
		'admin_label' => $label,
		'description' => esc_html__( 'Scroll factor', 'inforward' ),
		'value' => '-80',
		'dependency' => array(
			'element' => 'css_animation',
			'not_empty' => true
		),
		'group' => esc_html__( 'Animations', 'inforward' )
	);

	return apply_filters( 'inforward_vc_map_add_scroll_factor', $data, $label );
}

function inforward_vc_map_add_short_css_animation( $label = true ) {
	$data = array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'CSS Animation', 'inforward' ),
		'param_name' => 'css_animation',
		'admin_label' => $label,
		'value' => array(
			esc_html__( 'No', 'inforward' ) => '',
			esc_html__( 'Yes', 'inforward' ) => 'yes'
		),
		'group' => esc_html__( 'Animations', 'inforward' ),
		'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'inforward' )
	);

	return apply_filters( 'inforward_vc_map_add_short_css_animation', $data, $label );
}

/* Default Custom Shortcodes
/* --------------------------------------------------------------------- */

/* Row
----------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Row' , 'inforward' ),
	'base' => 'vc_row',
	'is_container' => true,
	'icon' => 'icon-wpb-row',
	'show_settings_on_create' => false,
	'category' => esc_html__( 'Content', 'inforward' ),
	'description' => esc_html__( 'Place content elements inside the row', 'inforward' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Row stretch', 'inforward' ),
			'param_name' => 'full_width',
			'value' => array(
				esc_html__( 'Default', 'inforward' ) => '',
				esc_html__( 'Stretch row', 'inforward' ) => 'stretch_row',
				esc_html__( 'Stretch row and content', 'inforward' ) => 'stretch_row_content',
				esc_html__( 'Stretch row and content (no paddings)', 'inforward' ) => 'stretch_row_content_no_spaces',
			),
			'description' => esc_html__( 'Select stretching options for row and content (Note: stretched may not work properly if parent container has "overflow: hidden" CSS property).', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns gap', 'inforward' ),
			'param_name' => 'gap',
			'value' => array(
				'0px' => '0',
				'1px' => '1',
				'2px' => '2',
				'3px' => '3',
				'4px' => '4',
				'5px' => '5',
				'10px' => '10',
				'15px' => '15',
				'20px' => '20',
				'25px' => '25',
				'30px' => '30',
				'35px' => '35',
			),
			'std' => '0',
			'description' => esc_html__( 'Select gap between columns in row.', 'inforward' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Full height row?', 'inforward' ),
			'param_name' => 'full_height',
			'description' => esc_html__( 'If checked row will be set to full height.', 'inforward' ),
			'value' => array( esc_html__( 'Yes', 'inforward' ) => 'yes' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns position', 'inforward' ),
			'param_name' => 'columns_placement',
			'value' => array(
				esc_html__( 'Middle', 'inforward' ) => 'middle',
				esc_html__( 'Top', 'inforward' ) => 'top',
				esc_html__( 'Bottom', 'inforward' ) => 'bottom',
				esc_html__( 'Stretch', 'inforward' ) => 'stretch',
			),
			'description' => esc_html__( 'Select columns position within row.', 'inforward' ),
			'dependency' => array(
				'element' => 'full_height',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Equal height', 'inforward' ),
			'param_name' => 'equal_height',
			'description' => esc_html__( 'If checked columns will be set to equal height.', 'inforward' ),
			'value' => array( esc_html__( 'Yes', 'inforward' ) => 'yes' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Content position', 'inforward' ),
			'param_name' => 'content_placement',
			'value' => array(
				esc_html__( 'Default', 'inforward' ) => '',
				esc_html__( 'Top', 'inforward' ) => 'top',
				esc_html__( 'Middle', 'inforward' ) => 'middle',
				esc_html__( 'Bottom', 'inforward' ) => 'bottom',
			),
			'description' => esc_html__( 'Select content position within columns.', 'inforward' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Use video background?', 'inforward' ),
			'param_name' => 'video_bg',
			'description' => esc_html__( 'If checked, video will be used as row background.', 'inforward' ),
			'value' => array( esc_html__( 'Yes', 'inforward' ) => 'yes' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Use scrolldown icon?', 'inforward' ),
			'param_name' => 'scrolldown_icon',
			'description' => esc_html__( 'If checked, scrolldown icon will be used as icon in bottom.', 'inforward' ),
			'value' => array( esc_html__( 'Yes', 'inforward' ) => 'yes' ),
			'dependency' => array(
				'element' => 'full_height',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'YouTube link', 'inforward' ),
			'param_name' => 'video_bg_url',
			'value' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
			'description' => esc_html__( 'Add YouTube link.', 'inforward' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Parallax', 'inforward' ),
			'param_name' => 'video_bg_parallax',
			'value' => array(
				esc_html__( 'None', 'inforward' ) => '',
				esc_html__( 'Simple', 'inforward' ) => 'content-moving'
			),
			'description' => esc_html__( 'Add parallax type background for row.', 'inforward' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Parallax', 'inforward' ),
			'param_name' => 'parallax',
			'value' => array(
				esc_html__( 'None', 'inforward' ) => '',
				esc_html__( 'Simple', 'inforward' ) => 'content-moving',
			),
			'description' => esc_html__( 'Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', 'inforward' ),
			'dependency' => array(
				'element' => 'video_bg',
				'is_empty' => true,
			)
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'inforward' ),
			'param_name' => 'parallax_image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'inforward' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
			'group' => esc_html__( 'Parallax', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Overlay background color', 'inforward' ),
			'param_name' => 'overlay_color',
			'description' => esc_html__( 'Select custom overlay color for background.', 'inforward' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
			'group' => esc_html__( 'Parallax', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Parallax opacity', 'inforward' ),
			'param_name' => 'parallax_opacity',
			'value' => '1',
			'description' => esc_html__( 'The opacity property can take a value from 0.0 - 1.0. The lower value, the more transparent. (Note: Default value is 0.5, min value 0 max value is 1)', 'inforward' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true
			),
			'group' => esc_html__( 'Parallax', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Parallax speed', 'inforward' ),
			'param_name' => 'parallax_speed_video',
			'value' => '1.5',
			'description' => esc_html__( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'inforward' ),
			'dependency' => array(
				'element' => 'video_bg_parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Parallax speed', 'inforward' ),
			'param_name' => 'parallax_speed_bg',
			'value' => '1.5',
			'description' => esc_html__( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'inforward' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'el_id',
			'heading' => esc_html__( 'Row ID', 'inforward' ),
			'param_name' => 'el_id',
			'description' => sprintf( wp_kses(__( 'Enter row ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'inforward' ), 'default'), 'http://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Disable row', 'inforward' ),
			'param_name' => 'disable_element', // Inner param name.
			'description' => esc_html__( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'inforward' ),
			'value' => array( esc_html__( 'Yes', 'inforward' ) => 'yes' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'inforward' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'inforward' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'inforward' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'inforward' ),
		),
	),
	'js_view' => 'VcRowView',
) );

vc_map(
	array(
		'name' => esc_html__( 'Text Block', 'inforward' ),
		'base' => 'vc_column_text',
		'icon' => 'icon-wpb-layer-shape-text',
		'wrapper_class' => 'clearfix',
		'category' => esc_html__( 'Content', 'inforward' ),
		'description' => esc_html__( 'A block of text with WYSIWYG editor', 'inforward' ),
		'params' => array(
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Text', 'inforward' ),
				'param_name' => 'content',
				'value' => esc_html__( 'I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'inforward' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'inforward' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'inforward' ),
			),
			array(
				'type' => 'css_editor',
				'heading' => esc_html__( 'CSS box', 'inforward' ),
				'param_name' => 'css',
				'group' => esc_html__( 'Design Options', 'inforward' ),
			),
			inforward_vc_map_add_css_animation(),
			inforward_vc_map_add_animation_delay(),
			inforward_vc_map_add_scroll_factor(),
		),
	)
);

/* Custom Heading element
----------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Custom Heading', 'inforward' ),
	'base' => 'vc_custom_heading',
	'icon' => 'icon-wpb-ui-custom_heading',
	'show_settings_on_create' => true,
	'category' => esc_html__( 'Content', 'inforward' ),
	'description' => esc_html__( 'Text with Google fonts', 'inforward' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Text source', 'inforward' ),
			'param_name' => 'source',
			'value' => array(
				esc_html__( 'Custom text', 'inforward' ) => '',
				esc_html__( 'Post or Page Title', 'inforward' ) => 'post_title',
			),
			'std' => '',
			'description' => esc_html__( 'Select text source.', 'inforward' ),
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Text', 'inforward' ),
			'param_name' => 'text',
			'admin_label' => true,
			'value' => esc_html__( 'This is custom heading element', 'inforward' ),
			'description' => esc_html__( 'Note: If you are using non-latin characters be sure to activate them under Settings/Visual Composer/General Settings.', 'inforward' ),
			'dependency' => array(
				'element' => 'source',
				'is_empty' => true,
			),
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'inforward' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to custom heading.', 'inforward' ),
		),
		array(
			'type' => 'font_container',
			'param_name' => 'font_container',
			'value' => 'tag:h2|text_align:left',
			'settings' => array(
				'fields' => array(
					'tag' => 'h2', // default value h2
					'text_align',
					'font_size',
					'line_height',
					'color',
					'tag_description' => esc_html__( 'Select element tag.', 'inforward' ),
					'text_align_description' => esc_html__( 'Select text alignment.', 'inforward' ),
					'font_size_description' => esc_html__( 'Enter font size.', 'inforward' ),
					'line_height_description' => esc_html__( 'Enter line height.', 'inforward' ),
					'color_description' => esc_html__( 'Select heading color.', 'inforward' ),
				),
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Use theme default font family?', 'inforward' ),
			'param_name' => 'use_theme_fonts',
			'value' => array( esc_html__( 'Yes', 'inforward' ) => 'yes' ),
			'description' => esc_html__( 'Use font family from the theme.', 'inforward' ),
			'std' => 'yes'
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'google_fonts',
			'value' => 'font_family:Droid Serif:regular,italic,700,700italic',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select font family.', 'inforward' ),
					'font_style_description' => esc_html__( 'Select font styling.', 'inforward' ),
				),
			),
			'dependency' => array(
				'element' => 'use_theme_fonts',
				'value_not_equal_to' => 'yes',
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'With border?', 'inforward' ),
			'param_name' => 'with_border',
			'value' => array( esc_html__( 'Yes', 'inforward' ) => true ),
			'description' => esc_html__( 'Use border bottom.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'inforward' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'inforward' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'inforward' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'inforward' ),
		),
		inforward_vc_map_add_css_animation(),
		inforward_vc_map_add_animation_delay(),
		inforward_vc_map_add_scroll_factor()
	),
) );

/* Theme Shortcodes
/* ---------------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Home Block Social Buttons', 'inforward' ),
	'base' => 'vc_mad_social_buttons',
	'icon' => '',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Block Social Buttons', 'inforward' ),
	'params' => array(
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Show Form', 'inforward' ),
			'param_name' => 'show_form',
			'description' => esc_html__( 'Show Form.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Message text', 'inforward' ),
			'param_name' => 'content',
			'value' => esc_html__( 'I am message box. Click edit button to change this text.', 'inforward' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Show Social Buttons', 'inforward' ),
			'param_name' => 'show_social',
			'description' => esc_html__( 'Show Social Buttons.', 'inforward' ),
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Facebook URL', 'inforward' ),
			'param_name' => 'facebook_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter Facebook URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Twitter URL', 'inforward' ),
			'param_name' => 'twitter_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter twitter URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Instagram URL', 'inforward' ),
			'param_name' => 'instagram_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter instagram URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Youtube URL', 'inforward' ),
			'param_name' => 'youtube_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter youtube URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Flickr URL', 'inforward' ),
			'param_name' => 'flickr_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter flickr URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Snapchat URL', 'inforward' ),
			'param_name' => 'snapchat_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter snapchat URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Telegram URL', 'inforward' ),
			'param_name' => 'telegram_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter telegram URL.', 'inforward' ),
		),
	),
));

/* Home Block Media Holder
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Home Block Media Holder', 'inforward' ),
	'base' => 'vc_mad_media_holder',
	'icon' => 'icon-wpb-mad-team-members',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Block Media Holder', 'inforward' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'box_type',
			'value' => array(
				esc_html__('Type 1', 'inforward') => 'style-1',
				esc_html__('Type 2', 'inforward') => 'style-2',
			),
			'description' => esc_html__( 'Select type design.', 'inforward' ),
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'inforward' ),
			'param_name' => 'image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'inforward' )
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Message text', 'inforward' ),
			'param_name' => 'content',
			'value' => esc_html__( 'I am message box. Click edit button to change this text.', 'inforward' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Show Form', 'inforward' ),
			'param_name' => 'show_form',
			'description' => esc_html__( 'Show Form.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Show Social Buttons', 'inforward' ),
			'param_name' => 'show_social',
			'description' => esc_html__( 'Show Social Buttons.', 'inforward' ),
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Facebook URL', 'inforward' ),
			'param_name' => 'facebook_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter Facebook URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Twitter URL', 'inforward' ),
			'param_name' => 'twitter_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter twitter URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Instagram URL', 'inforward' ),
			'param_name' => 'instagram_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter instagram URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Youtube URL', 'inforward' ),
			'param_name' => 'youtube_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter youtube URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Flickr URL', 'inforward' ),
			'param_name' => 'flickr_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter flickr URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Snapchat URL', 'inforward' ),
			'param_name' => 'snapchat_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter snapchat URL.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Telegram URL', 'inforward' ),
			'param_name' => 'telegram_link',
			'dependency' => array(
				'element' => 'box_type',
				'value' => 'style-2',
			),
			'description' => esc_html__( 'Enter telegram URL.', 'inforward' ),
		),
	),
));

/* Button
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Button', 'inforward' ),
	'base' => 'vc_mad_btn',
	'icon' => 'icon-wpb-mad-button',
	'category' => array( esc_html__( 'Inforward', 'inforward' ) ),
	'description' => esc_html__( 'Eye catching button', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Text', 'inforward' ),
			'param_name' => 'title',
			'value' => esc_html__( 'Text on the button', 'inforward' ),
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'inforward' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to button.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'inforward' ),
			'param_name' => 'style',
			'description' => esc_html__( 'Select style color.', 'inforward' ),
			'value' => array(
				esc_html__( 'White', 'inforward' ) => 'btn-style-2',
				esc_html__( 'White Small', 'inforward' ) => 'info-btn btn-white',
				esc_html__( 'Gray', 'inforward' ) => '',
				esc_html__( 'Theme Blue1', 'inforward' ) => 'btn-style-3',
				esc_html__( 'Theme Blue2', 'inforward' ) => 'btn-style-4',
				esc_html__( 'Theme Blue3', 'inforward' ) => 'btn-style-5',
				esc_html__( 'Theme Blue4', 'inforward' ) => 'info-btn',
				esc_html__( 'Theme Red', 'inforward' ) => 'btn-style-6',
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Size', 'inforward' ),
			'param_name' => 'size',
			'description' => esc_html__( 'Select button display size.', 'inforward' ),
			'std' => 'kw-small',
			'value' => array(
				esc_html__('Small', 'inforward') => 'btn-small',
				esc_html__('Medium', 'inforward') => 'btn-medium',
				esc_html__('Big', 'inforward') => 'btn-big',
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment', 'inforward' ),
			'param_name' => 'align',
			'description' => esc_html__( 'Select button alignment.', 'inforward' ),
			'value' => array(
				esc_html__( 'Inline', 'inforward' ) => 'cp-inline',
				esc_html__( 'Left', 'inforward' ) => 'cp-left',
				esc_html__( 'Right', 'inforward' ) => 'cp-right',
				esc_html__( 'Center', 'inforward' ) => 'cp-center',
			),
		),
		array(
			"type" => "choose_icons",
			"heading" => esc_html__("Icon", 'inforward'),
			"param_name" => "icon",
			"value" => 'none',
			"description" => esc_html__('Select icon from library.', 'inforward')
		),
	),
));

/* Home Block Action List
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Home Block Action List", 'inforward' ),
	"base"=> 'vc_mad_action_list',
	"icon" => 'icon-mad-info-list',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Action List', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'inforward' ),
			'param_name' => 'type',
			'description' => esc_html__( 'Select style.', 'inforward' ),
			'value' => array(
				esc_html__( 'Type 1', 'inforward' ) => 'style-1',
				esc_html__( 'Type 2', 'inforward' ) => 'style-2',
				esc_html__( 'Type 3', 'inforward' ) => 'style_3 style-2 type-vr',
			),
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'inforward' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values - value, image and title.', 'inforward' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => '',
					'value' => '',
					'icon' => '',
					'bg_color' => '',
					'icon_color' => '',
					'title_color' => '',
				),
				array(
					'label' => '',
					'value' => '',
					'icon' => '',
					'bg_color' => '',
					'icon_color' => '',
					'title_color' => '',
				)
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'inforward' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( 'Add URL to the button', 'inforward' ),
					"param_name" => "link"
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Description', 'inforward' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter description.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					   'type' => 'colorpicker',
					   'heading' => esc_html__( 'Color for item', 'inforward' ),
					   'param_name' => 'bg_color',
					   'description' => esc_html__( 'Select custom color for item.', 'inforward' ),
				   ),
				array(
					   'type' => 'colorpicker',
					   'heading' => esc_html__( 'Color for item hover', 'inforward' ),
					   'param_name' => 'bg_color_hover',
					   'description' => esc_html__( 'Select custom color for item hover.', 'inforward' ),
				   ),   
				array(
					   'type' => 'colorpicker',
					   'heading' => esc_html__( 'Color for icon', 'inforward' ),
					   'param_name' => 'icon_color',
					   'description' => esc_html__( 'Select custom color for icon.', 'inforward' ),
				   ),
				array(
					   'type' => 'colorpicker',
					   'heading' => esc_html__( 'Color for title', 'inforward' ),
					   'param_name' => 'title_color',
					   'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
				   ),
				array(
				   "type" => "choose_icons",
				   "heading" => esc_html__("Icon", 'inforward'),
				   "param_name" => "icon",
				   "value" => 'none',
				   "description" => esc_html__( 'Select icon from library.', 'inforward')
			    )
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'inforward' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( 'Columns 1', 'inforward' ) => 'action-col-1',
				esc_html__( 'Columns 2', 'inforward' ) => 'action-col-2',
				esc_html__( 'Columns 3', 'inforward' ) => 'action-col-3',
				esc_html__( 'Columns 4', 'inforward' ) => 'action-col-4'
			),
			'std' => 'action-col-4',
			'description' => esc_html__( 'Choose the columns for services.', 'inforward' )
		)
	)
));

/* Home Block Press List
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Home Block Press List", 'inforward' ),
	"base"=> 'vc_mad_press_list',
	"icon" => '',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Press List', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => ''
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__( 'Add URL to the button', 'inforward' ),
			"param_name" => "link_more"
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'inforward' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values - value, image and title.', 'inforward' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => '',
					'value' => '',
					'time' => '',
					'bg_color' => '',
					'bg_color_hover' => '',
					'link' => '',
				),
				array(
					'label' => '',
					'value' => '',
					'time' => '',
					'bg_color' => '',
					'bg_color_hover' => '',
					'link' => '',
				)
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'inforward' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Time', 'inforward' ),
					'param_name' => 'time',
					'description' => esc_html__( 'Enter time.', 'inforward' ),
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( 'Add URL to the button', 'inforward' ),
					"param_name" => "link"
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Description', 'inforward' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter description.', 'inforward' ),
				),
				array(
					   'type' => 'colorpicker',
					   'heading' => esc_html__( 'Color for item', 'inforward' ),
					   'param_name' => 'bg_color',
					   'description' => esc_html__( 'Select custom color for item.', 'inforward' ),
				   ),
				array(
					   'type' => 'colorpicker',
					   'heading' => esc_html__( 'Color for item hover', 'inforward' ),
					   'param_name' => 'bg_color_hover',
					   'description' => esc_html__( 'Select custom color for item hover.', 'inforward' ),
				   )
			)
		)
	)
));

/* Issues
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Issues', 'inforward' ),
	'base' => 'vc_mad_issues',
	'icon' => 'icon-wpb-mad-team-members',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Issues post type', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Description', 'inforward' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for description', 'inforward' ),
			'param_name' => 'description_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for description.', 'inforward' ),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Title align", 'inforward'),
			"param_name" => "title_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Description align", 'inforward'),
			"param_name" => "description_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'inforward' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '3 Columns', 'inforward' ) => 3,
				esc_html__( '4 Columns', 'inforward' ) => 4
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 30, 1, array('All' => '-1')),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'inforward' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable excerpt', 'inforward' ),
			'param_name' => 'excerpt',
			'description' => esc_html__( 'Enable excerpt.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable carousel', 'inforward' ),
			'param_name' => 'carousel',
			'description' => esc_html__( 'Enable carousel.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			"type" => "get_terms",
			"term" => "team_category",
			'heading' => esc_html__( 'Which categories should be used for the team?', 'inforward' ),
			"param_name" => "categories",
			"holder" => "div",
			'description' => esc_html__('The Page will then show team from only those categories.', 'inforward'),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'inforward' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'inforward' ) => 'date',
				esc_html__( 'ID', 'inforward' ) => 'ID',
				esc_html__( 'Author', 'inforward' ) => 'author',
				esc_html__( 'Title', 'inforward' ) => 'title',
				esc_html__( 'Modified', 'inforward' ) => 'modified',
				esc_html__( 'Random', 'inforward' ) => 'rand',
				esc_html__( 'Comment count', 'inforward' ) => 'comment_count',
				esc_html__( 'Menu order', 'inforward' ) => 'menu_order'
			),
			'description' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'inforward' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'inforward' ) => 'DESC',
				esc_html__( 'ASC', 'inforward' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'inforward' )
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__( 'Add URL to the button', 'inforward' ),
			"param_name" => "link_more"
		),
		inforward_vc_map_add_css_animation()
	)
) );

/* Home Banner List
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Home Banner List", 'inforward' ),
	"base"=> 'vc_mad_banner_list',
	"icon" => 'icon-mad-info-list',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Home Banner list', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'inforward' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values - value, image and title.', 'inforward' ),
			'value' => urlencode( json_encode( array(
				array(
					'icon' => '',
					'label' => '',
					'value' => '',
					'link' => '',
					'bg_color' => '',
					'bg_color_hover' => '',
				),
				array(
					'icon' => '',
					'label' => '',
					'value' => '',
					'link' => '',
					'bg_color' => '',
					'bg_color_hover' => '',
				)
			) ) ),
			'params' => array(
				array(
				   "type" => "choose_icons",
				   "heading" => esc_html__("Icon", 'inforward'),
				   "param_name" => "icon",
				   "value" => 'none',
				   "description" => esc_html__( 'Select icon from library.', 'inforward')
			    ),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'inforward' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as label.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( 'Add URL to the button', 'inforward' ),
					"param_name" => "link"
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Description', 'inforward' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter description.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					   'type' => 'colorpicker',
					   'heading' => esc_html__( 'Color for item', 'inforward' ),
					   'param_name' => 'bg_color',
					   'description' => esc_html__( 'Select custom color for item.', 'inforward' ),
				   ),
				   array(
					   'type' => 'colorpicker',
					   'heading' => esc_html__( 'Color for item hover', 'inforward' ),
					   'param_name' => 'bg_color_hover',
					   'description' => esc_html__( 'Select custom color for item hover.', 'inforward' ),
				   )
			)
		)
	)
));

/* Share
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Share buttons', 'inforward' ),
	'base' => 'vc_mad_share',
	'icon' => '',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Share buttons', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Label', 'inforward' ),
			'param_name' => 'label',
			'description' => '',
			'value' => ''
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Facebook', 'inforward' ),
			'param_name' => 'show_facebook',
			'description' => esc_html__( 'Enable facebook.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Twitter', 'inforward' ),
			'param_name' => 'show_twitter',
			'description' => esc_html__( 'Enable twitter.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Google +', 'inforward' ),
			'param_name' => 'show_google',
			'description' => esc_html__( 'Enable google.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Pinterest', 'inforward' ),
			'param_name' => 'show_pinterest',
			'description' => esc_html__( 'Enable pinterest.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Mail', 'inforward' ),
			'param_name' => 'show_mail',
			'description' => esc_html__( 'Enable mail.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'inforward' ),
			'param_name' => 'type',
			'value' => array(
				'style-1' => 'style-1',
				'style-2' => 'style-2'
			),
			'std' => 'style-1',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose style.', 'inforward' )
		),
		inforward_vc_map_add_css_animation()
	)
) );

/* Blog Posts
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Blog Posts', 'inforward' ),
	'base' => 'vc_mad_blog_posts',
	'icon' => 'icon-wpb-mad-blog-posts',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Blog posts', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Title align", 'inforward'),
			"param_name" => "title_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Button align", 'inforward'),
			"param_name" => "btn_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Blog Layout', 'inforward' ),
			'param_name' => 'layout',
			'value' => array(
				esc_html__( 'Grid', 'inforward' ) => 'cp-type-1',
				esc_html__( 'List', 'inforward' ) => 'cp-type-2',
				esc_html__( 'Widget Image', 'inforward' ) => 'cp-type-3',
				esc_html__( 'Widget List', 'inforward' ) => 'cp-type-4',
				esc_html__( 'Tab List', 'inforward' ) => 'cp-type-5',
			),
			'std' => 'cp-type-2',
			'description' => esc_html__( 'Choose the default blog layout here.', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'inforward' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '2 Columns', 'inforward' ) => 2,
				esc_html__( '3 Columns', 'inforward' ) => 3,
				esc_html__( '4 Columns', 'inforward' ) => 4,
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'inforward' ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'cp-type-1' )
			),
			'std' => 3,
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable carousel', 'inforward' ),
			'param_name' => 'carousel',
			'description' => esc_html__( 'Enable carousel.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'cp-type-1' )
			)
		),
		array(
			"type" => "get_terms",
			"term" => "category",
			'heading' => esc_html__( 'Which categories should be used for the blog?', 'inforward' ),
			"param_name" => "categories",
			"holder" => "div",
			'description' => esc_html__('The Page will then show entries from only those categories.', 'inforward'),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'inforward' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'inforward' ) => 'date',
				esc_html__( 'ID', 'inforward' ) => 'ID',
				esc_html__( 'Author', 'inforward' ) => 'author',
				esc_html__( 'Title', 'inforward' ) => 'title',
				esc_html__( 'Modified', 'inforward' ) => 'modified',
				esc_html__( 'Random', 'inforward' ) => 'rand',
				esc_html__( 'Comment count', 'inforward' ) => 'comment_count',
				esc_html__( 'Menu order', 'inforward' ) => 'menu_order'
			),
			'std' => 'date',
			'description' => esc_html__( 'Sort retrieved posts by parameter', 'inforward' ),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'inforward' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'inforward' ) => 'DESC',
				esc_html__( 'ASC', 'inforward' ) => 'ASC'
			),
			'description' => esc_html__( 'In what direction order?', 'inforward' ),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Posts Count', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 50, 1, array('-1' => 'All')),
			'std' => 8,
			'description' => esc_html__( 'How many items should be displayed per page?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Ignore sticky posts', 'inforward' ),
			'param_name' => 'ignore_sticky_posts',
			'value' => array(
				esc_html__( 'No', 'inforward' ) => 0,
				esc_html__( 'Yes', 'inforward' ) => 1
			),
			'description' => esc_html__( 'Ignore sticky posts', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Pagination', 'inforward' ),
			'param_name' => 'paginate',
			'value' => array(
				esc_html__( 'Display Pagination', 'inforward' ) => 'pagination',
				esc_html__( 'Hide Pagination', 'inforward' ) => 'none'
			),
			'std' => 'none',
			'description' => esc_html__( 'Should a pagination be displayed?', 'inforward' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Pagination align", 'inforward'),
			"param_name" => "paginate_align",
			"value" => array(
				esc_html__("Left",'inforward') => "",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'inforward' ),
			'param_name' => 'custom_links',
			'description' => esc_html__( 'Add link to button.', 'inforward' ),
		),
		inforward_vc_map_add_css_animation()
	)
) );

/* Portfolio
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Portfolio', 'inforward' ),
	'base' => 'vc_mad_portfolio',
	'icon' => 'icon-wpb-mad-portfolio',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Displayed for portfolio items', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'inforward' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for description', 'inforward' ),
			'param_name' => 'description_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for description.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Filter', 'inforward' ),
			'param_name' => 'sort',
			'value' => array(
				esc_html__( 'No', 'inforward' ) => '',
				esc_html__( 'Yes', 'inforward' ) => 'yes'
			),
			'description' => esc_html__( 'Should the sorting options based on categories be displayed?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment Filter', 'inforward' ),
			'param_name' => 'align_sort',
			'description' => esc_html__( 'Select filter alignment.', 'inforward' ),
			'group' => esc_html__( 'Filter', 'inforward' ),
			'value' => array(
				esc_html__( 'Left', 'inforward' ) => 'align-left',
				esc_html__( 'Right', 'inforward' ) => 'align-right',
				esc_html__( 'Center', 'inforward' ) => 'align-center',
			),
			'dependency' => array(
				'element' => 'sort',
				'not_empty' => true
			)
		),
		array(
			"type" => "get_terms",
			"term" => "portfolio_categories",
			'heading' => esc_html__( 'Which categories should be used for the portfolio?', 'inforward' ),
			"param_name" => "categories",
			'description' => esc_html__('The Page will then show portfolio from only those categories.', 'inforward'),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'inforward' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'inforward' ) => 'date',
				esc_html__( 'ID', 'inforward' ) => 'ID',
				esc_html__( 'Author', 'inforward' ) => 'author',
				esc_html__( 'Title', 'inforward' ) => 'title',
				esc_html__( 'Modified', 'inforward' ) => 'modified',
				esc_html__( 'Random', 'inforward' ) => 'rand',
				esc_html__( 'Comment count', 'inforward' ) => 'comment_count',
				esc_html__( 'Menu order', 'inforward' ) => 'menu_order'
			),
			'description' => esc_html__( 'Sort retrieved items by parameter', 'inforward' ),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'inforward' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'inforward' ) => 'DESC',
				esc_html__( 'ASC', 'inforward' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'inforward' ),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'inforward' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '2 Columns', 'inforward' ) => 2,
				esc_html__( '3 Columns', 'inforward' ) => 3,
				esc_html__( '4 Columns', 'inforward' ) => 4,
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'inforward' ),
			'std' => 2,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 60, 1, array('All' => '-1')),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Display Category', 'inforward' ),
			'param_name' => 'show_cat',
			'value' => array(
				esc_html__( 'show', 'inforward' ) => 'show',
				esc_html__( 'hide', 'inforward' ) => 'hide'
			),
			'std' => 'show',
			'description' => esc_html__( 'Display Category', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Title length', 'inforward' ),
			'param_name' => 'title_length',
			'value' => Inforward_Vc_Config::array_number(0, 100, 1),
			'std' => 50,
			'description' => esc_html__( 'Title length', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Excerpt length', 'inforward' ),
			'param_name' => 'excerpt',
			'value' => Inforward_Vc_Config::array_number(0, 200, 1),
			'std' => 50,
			'description' => esc_html__( 'Excerpt length', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Position info', 'inforward' ),
			'param_name' => 'position_info',
			'value' => array(
				esc_html__( 'bottom', 'inforward' ) => 'bottom',
				esc_html__( 'inner', 'inforward' ) => 'inner'
			),
			'std' => 'bottom',
			'description' => esc_html__( 'Position info', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Pagination', 'inforward' ),
			'param_name' => 'paginate',
			'value' => array(
				esc_html__( 'Display Pagination', 'inforward' ) => 'pagination',
				esc_html__( 'No Pagination', 'inforward' ) => 'none'
			),
			'std' => 'none',
			'description' => esc_html__( 'Should a pagination be displayed?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment Pagination', 'inforward' ),
			'param_name' => 'align_pagination',
			'description' => esc_html__( 'Select pagination alignment.', 'inforward' ),
			'value' => array(
				esc_html__( 'Left', 'inforward' ) => 'align-left',
				esc_html__( 'Right', 'inforward' ) => 'align-right',
				esc_html__( 'Center', 'inforward' ) => 'align-center',
			),
			'dependency' => array(
				'element' => 'paginate',
				'value' => array( 'pagination' )
			)
		),
		inforward_vc_map_add_css_animation(),
	)
) );

/* About Portfolio
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'About Portfolio', 'inforward' ),
	'base' => 'vc_mad_about_portfolio',
	'icon' => 'icon-wpb-single-image',
	'category' => esc_html__( 'Inforward', 'inforward'),
	'description' => esc_html__( 'To display the detailed portfolio page', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'inforward' ),
			'param_name' => 'content',
			'value' => wp_kses(__( '<p>Click edit button to change this text.</p>', 'inforward' ), 'default')
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Date', 'inforward' ),
			'param_name' => 'output_date',
			'description' => esc_html__( 'output date', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => 'yes' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Category', 'inforward' ),
			'param_name' => 'output_category',
			'description' => esc_html__( 'output category', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => 'yes' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Author', 'inforward' ),
			'param_name' => 'output_author',
			'description' => esc_html__( 'output author', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => 'yes' )
		),
	)
) );

/* Instagram gallery
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Instagram gallery', 'inforward' ),
	'base' => 'vc_mad_instagram',
	'icon' => 'icon-wpb-mad-instagram',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Instagram gallery', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'User id', 'inforward' ),
			'param_name' => 'user_id',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Access Token', 'inforward' ),
			'param_name' => 'access_token',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Client Id', 'inforward' ),
			'param_name' => 'client_id',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Tag Name', 'inforward' ),
			'param_name' => 'tag_name',
		),
		array(
			'type' => 'number',
			'heading' => esc_html__( 'Number', 'inforward' ),
			'param_name' => 'number',
			'description' => esc_html__( 'Number of photos', 'inforward' ),
			'value' => 9,
		),
	)
) );

/* Flickr gallery
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Flickr gallery', 'inforward' ),
	'base' => 'vc_mad_flickr_gallery',
	'icon' => 'icon-wpb-mad-flickr',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Flickr gallery', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Api key', 'inforward' ),
			'param_name' => 'api_key',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'User id', 'inforward' ),
			'param_name' => 'user_id',
		),
		array(
			'type' => 'number',
			'heading' => esc_html__( 'Number', 'inforward' ),
			'param_name' => 'number',
			'description' => esc_html__( 'Number of photos', 'inforward' ),
			'value' => 6,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Open links in', 'inforward' ),
			'param_name' => 'target',
			'value' => array(
				esc_html__( 'Current window (_self)', 'inforward' ) => '_self',
				esc_html__( 'New window (_blank)', 'inforward' ) => '_blank'
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Link url', 'inforward' ),
			'param_name' => 'link',
			'std' => ''
		),
	)
) );

/* Video
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Video', 'inforward' ),
	'base' => 'vc_mad_videos',
	'icon' => 'icon-wpb-mad-video',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Displayed for video items', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'inforward' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for description', 'inforward' ),
			'param_name' => 'description_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for description.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Video Layout', 'inforward' ),
			'param_name' => 'layout',
			'value' => array(
				esc_html__( 'Grid', 'inforward' ) => 'cp-type-1',
				esc_html__( 'List for tab', 'inforward' ) => 'cp-type-2',
			),
			'std' => 'cp-type-1',
			'description' => esc_html__( 'Choose the default video layout here.', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Filter', 'inforward' ),
			'param_name' => 'sort',
			'value' => array(
				esc_html__( 'No', 'inforward' ) => '',
				esc_html__( 'Yes', 'inforward' ) => 'yes'
			),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'cp-type-1' )
			),
			'description' => esc_html__( 'Should the sorting options based on categories be displayed?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment Filter', 'inforward' ),
			'param_name' => 'align_sort',
			'description' => esc_html__( 'Select filter alignment.', 'inforward' ),
			'group' => esc_html__( 'Filter', 'inforward' ),
			'value' => array(
				esc_html__( 'Left', 'inforward' ) => 'align-left',
				esc_html__( 'Right', 'inforward' ) => 'align-right',
				esc_html__( 'Center', 'inforward' ) => 'align-center',
			),
			'dependency' => array(
				'element' => 'sort',
				'not_empty' => true
			)
		),
		array(
			"type" => "get_terms",
			"term" => "video_categories",
			'heading' => esc_html__( 'Which categories should be used for the portfolio?', 'inforward' ),
			"param_name" => "categories",
			'description' => esc_html__('The Page will then show portfolio from only those categories.', 'inforward'),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'inforward' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'inforward' ) => 'date',
				esc_html__( 'ID', 'inforward' ) => 'ID',
				esc_html__( 'Author', 'inforward' ) => 'author',
				esc_html__( 'Title', 'inforward' ) => 'title',
				esc_html__( 'Modified', 'inforward' ) => 'modified',
				esc_html__( 'Random', 'inforward' ) => 'rand',
				esc_html__( 'Comment count', 'inforward' ) => 'comment_count',
				esc_html__( 'Menu order', 'inforward' ) => 'menu_order'
			),
			'description' => esc_html__( 'Sort retrieved items by parameter', 'inforward' ),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'inforward' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'inforward' ) => 'DESC',
				esc_html__( 'ASC', 'inforward' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'inforward' ),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'inforward' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '2 Columns', 'inforward' ) => 2,
				esc_html__( '3 Columns', 'inforward' ) => 3,
				esc_html__( '4 Columns', 'inforward' ) => 4,
			),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'cp-type-1' )
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'inforward' ),
			'std' => 2,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 60, 1, array('All' => '-1')),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Pagination', 'inforward' ),
			'param_name' => 'paginate',
			'value' => array(
				esc_html__( 'Display Pagination', 'inforward' ) => 'pagination',
				esc_html__( 'No Pagination', 'inforward' ) => 'none'
			),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'cp-type-1' )
			),
			'std' => 'none',
			'description' => esc_html__( 'Should a pagination be displayed?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment Pagination', 'inforward' ),
			'param_name' => 'align_pagination',
			'description' => esc_html__( 'Select pagination alignment.', 'inforward' ),
			'value' => array(
				esc_html__( 'Left', 'inforward' ) => 'align-left',
				esc_html__( 'Right', 'inforward' ) => 'align-right',
				esc_html__( 'Center', 'inforward' ) => 'align-center',
			),
			'dependency' => array(
				'element' => 'paginate',
				'value' => array( 'pagination' )
			)
		),
		inforward_vc_map_add_css_animation(),
	)
) );

if ( class_exists('WooCommerce') ) {

	/* Product Grid
	---------------------------------------------------------- */

	vc_map( array(
		'name' => esc_html__( 'Products', 'inforward' ),
		'base' => 'vc_mad_products',
		'icon' => 'icon-wpb-mad-woocommerce',
		'category' => esc_html__( 'Inforward', 'inforward' ),
		'description' => esc_html__( 'Displayed for product grid', 'inforward' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'inforward' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Tag for title', 'inforward' ),
				'param_name' => 'tag_title',
				'value' => array(
					'h2' => 'h2',
					'h3' => 'h3'
				),
				'std' => 'h2',
				'edit_field_class' => 'vc_col-sm-6',
				'description' => esc_html__( 'Choose tag for title.', 'inforward' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Description', 'inforward' ),
				'param_name' => 'description',
				'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Color for title', 'inforward' ),
				'param_name' => 'title_color',
				'group' => esc_html__( 'Styling', 'inforward' ),
				'edit_field_class' => 'vc_col-sm-6',
				'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Color for description', 'inforward' ),
				'param_name' => 'description_color',
				'group' => esc_html__( 'Styling', 'inforward' ),
				'edit_field_class' => 'vc_col-sm-6',
				'description' => esc_html__( 'Select custom color for description.', 'inforward' ),
			),
			array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Title align", 'inforward'),
			"param_name" => "title_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Description align", 'inforward'),
				"param_name" => "description_align",
				'group' => esc_html__( 'Styling', 'inforward' ),
				"value" => array(
					esc_html__("Left",'inforward') => "align-left",
					esc_html__("Right",'inforward') => "align-right",
					esc_html__("Center",'inforward') => "align-center"
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Type View', 'inforward' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Grid', 'inforward') => 'cp-view-grid',
					esc_html__('Carousel', 'inforward') => 'cp-view-carousel'
				),
				'std' => 'cp-view-grid',
				'description' => esc_html__('Choose the type style.', 'inforward')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'inforward' ),
				'param_name' => 'columns',
				'value' => array(
					esc_html__( '2 Columns', 'inforward' ) => 2,
					esc_html__( '3 Columns', 'inforward' ) => 3,
					esc_html__( '4 Columns', 'inforward' ) => 4,
				),
				'std' => 4,
				'description' => esc_html__( 'How many columns should be displayed?', 'inforward' ),
				'param_holder_class' => ''
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Count Items', 'inforward' ),
				'param_name' => 'items',
				'value' => Inforward_Vc_Config::array_number(1, 50, 1, array('All' => -1)),
				'std' => 8,
				'description' => esc_html__( 'How many items should be displayed per page?', 'inforward' )
			),
			array(
				"type" => "get_terms",
				"term" => "product_cat",
				'heading' => esc_html__( 'Which categories should be used for the products?', 'inforward' ),
				"param_name" => "categories",
				'admin_label' => true,
				'group' => esc_html__( 'Data Settings', 'inforward' ),
				'description' => esc_html__('The Page will then show products from only those categories.', 'inforward')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show', 'inforward' ),
				'param_name' => 'show',
				'value' => array(
					esc_html__( 'All Products', 'inforward' ) => '',
					esc_html__( 'Featured Products', 'inforward' ) => 'featured',
					esc_html__( 'On-sale Products', 'inforward' ) => 'onsale',
					esc_html__( 'Best Selling Products', 'inforward' ) => 'bestselling',
					esc_html__( 'Top Rated Products', 'inforward' ) => 'toprated',
					esc_html__( 'New', 'inforward' ) => 'new'
				),
				'description' => '',
				'std' => '',
				'group' => esc_html__( 'Data Settings', 'inforward' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Order by', 'inforward' ),
				'param_name' => 'orderby',
				'value' => array(
					esc_html__('Default sorting', 'inforward' ) => 'menu_order',
					esc_html__('Sort by popularity', 'inforward' ) => 'popularity',
					esc_html__('Sort by average rating', 'inforward' ) => 'rating',
					esc_html__('Sort by newness', 'inforward' ) => 'date',
					esc_html__('Sort by price: low to high', 'inforward' ) => 'price',
					esc_html__('Sort by price: high to low', 'inforward' ) => 'price-desc'
				),
				'description' => esc_html__( 'Here you can choose how to display the products', 'inforward' ),
				'group' => esc_html__( 'Data Settings', 'inforward' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Sorting Order', 'inforward' ),
				'param_name' => 'order',
				'value' => array(
					esc_html__( 'ASC', 'inforward' ) => 'asc',
					esc_html__( 'DESC', 'inforward' ) => 'desc'
				),
				'description' => esc_html__( 'Here you can choose how to display the products', 'inforward' ),
				'std' => 'desc',
				'group' => esc_html__( 'Data Settings', 'inforward' )
			),
			array(
				'type' => 'autocomplete',
				'settings' => array(
					'multiple' => true,
					'min_length' => 2,
					'groups' => true,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 500,
					'auto_focus' => true,
				),
				'heading' => esc_html__( 'Select identificators', 'inforward' ),
				'param_name' => 'by_id',
				'admin_label' => true,
				'group' => esc_html__( 'Data Settings', 'inforward' ),
				'description' => esc_html__('Input product ID or product SKU or product title to see suggestions', 'inforward')
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Pagination', 'inforward' ),
				'param_name' => 'paginate',
				'value' => array(
					esc_html__( 'Display Pagination', 'inforward' ) => 'pagination',
					esc_html__( 'No option to view additional entries', 'inforward' ) => 'none'
				),
				'std' => 'none',
				'description' => esc_html__( 'Should a pagination be displayed?', 'inforward' )
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'URL (Link)', 'inforward' ),
				'param_name' => 'link',
				'description' => esc_html__( 'Add link to button.', 'inforward' ),
				'group' => esc_html__( 'Button', 'inforward' ),
			),
			inforward_vc_map_add_css_animation()
		)
	) );

	$Vc_Vendor_Woocommerce = new Vc_Vendor_Woocommerce();

	add_filter( 'vc_autocomplete_vc_mad_products_by_id_callback', array($Vc_Vendor_Woocommerce, 'productIdAutocompleteSuggester' ), 10, 1 );
	add_filter( 'vc_autocomplete_vc_mad_products_by_id_render', array($Vc_Vendor_Woocommerce, 'productIdAutocompleteRender' ), 10, 1 );
	add_filter( 'vc_form_fields_render_field_vc_mad_products_by_id_param_value', array($Vc_Vendor_Woocommerce, 'productIdDefaultValue' ), 10, 4 );

}

/* Widget Newsletter
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Inforward Newsletter(mailchimp)', 'inforward' ),
	'base' => 'vc_mad_newsletter',
	'category' => esc_html__( 'Inforward', 'inforward'),
	'icon' => '',
	'description' => esc_html__( 'Widget Newsletter', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' )
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Text', 'inforward' ),
			'param_name' => 'info',
			'value'=> '',
			'description' => esc_html__( 'Enter text.', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type input', 'inforward' ),
			'param_name' => 'type_input',
			'description' => esc_html__( 'Select type input.', 'inforward' ),
			'value' => array(
				esc_html__( 'Email', 'inforward' ) => 'email',
				esc_html__( 'Phone', 'inforward' ) => 'tel',
			)
		), 
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'type',
			'description' => esc_html__( 'Select type.', 'inforward' ),
			'value' => array(
				esc_html__( 'Type 1', 'inforward' ) => 'type_1',
				esc_html__( 'Type 2', 'inforward' ) => 'type_2',
				esc_html__( 'Type 3', 'inforward' ) => 'type_3',
				esc_html__( 'Type 4', 'inforward' ) => 'type_4',
				esc_html__( 'Type 5', 'inforward' ) => 'type_5',
			)
		),
	)
) );

/* Widget Donate
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Inforward Donate', 'inforward' ),
	'base' => 'vc_mad_donate',
	'category' => esc_html__( 'Inforward', 'inforward'),
	'icon' => '',
	'description' => esc_html__( 'Widget Donate', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Amount1', 'inforward' ),
			'param_name' => 'text_amount1',
			'description' => esc_html__( 'Enter Amount.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Amount2', 'inforward' ),
			'param_name' => 'text_amount2',
			'description' => esc_html__( 'Enter Amount.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Amount3', 'inforward' ),
			'param_name' => 'text_amount3',
			'description' => esc_html__( 'Enter Amount.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Amount4', 'inforward' ),
			'param_name' => 'text_amount4',
			'description' => esc_html__( 'Enter Amount.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'PayPal Email Address', 'inforward' ),
			'param_name' => 'url_amount',
			'value'=> '',
			'description' => esc_html__( 'Enter PayPal Email Address.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Organization', 'inforward' ),
			'param_name' => 'org_donate',
			'value'=> '',
			'description' => esc_html__( 'Enter Organization.', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Currency Amount', 'inforward' ),
			'param_name' => 'currency_amount',
			'description' => esc_html__( 'Select Currency Amount.', 'inforward' ),
			'std'   => 'USD',
			'value' => array_flip (inforward_currency_code_options(inforward_get_currencies()))
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'type',
			'description' => esc_html__( 'Select type.', 'inforward' ),
			'value' => array(
				esc_html__( 'Type 1', 'inforward' ) => 'type_1',
				esc_html__( 'Type 2', 'inforward' ) => 'type_2',
				esc_html__( 'Type 3', 'inforward' ) => 'type_3',
				esc_html__( 'Type 4', 'inforward' ) => 'type_4',
				esc_html__( 'Type 5', 'inforward' ) => 'type_5',
			)
		),
	)
) );

/* Widget Instagram
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Inforward Instagram widget', 'inforward' ),
	'base' => 'vc_mad_instagram_widget',
	'category' => esc_html__( 'Inforward', 'inforward'),
	'icon' => '',
	'description' => esc_html__( 'Widget Instagram', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Link Title', 'inforward' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'inforward' ),
			'param_name' => 'cols',
			'value' => Inforward_Vc_Config::array_number(1, 4, 1),
			'std' => 3,
			'description' => esc_html__( 'How many column be displayed?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'number',
			'value' => Inforward_Vc_Config::array_number(1, 30, 1),
			'std' => 9,
			'description' => esc_html__( 'How many items should be displayed?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'type',
			'description' => esc_html__( 'Select type.', 'inforward' ),
			'value' => array(
				esc_html__( 'Grid Type1', 'inforward' ) => 'list',
				esc_html__( 'Grid Type2', 'inforward' ) => 'list2',
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Height', 'inforward' ),
			'param_name' => 'height',
			'value'=> '',
			'description' => esc_html__( 'Enter height (px)', 'inforward' )
		),
	)
) );

/* Widget Twitter
---------------------------------------------------------- */
 if( class_exists('Latest_Tweets_Widget') ){
	 
vc_map( array(
	'name' => esc_html__( 'Inforward Twitter widget', 'inforward' ),
	'base' => 'vc_mad_twitter_widget',
	'category' => esc_html__( 'Inforward', 'inforward'),
	'icon' => '',
	'description' => esc_html__( 'Widget Twitter', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Username', 'inforward' ),
			'param_name' => 'screen_name',
			'value'=> '',
			'description' => esc_html__( 'Enter username.', 'inforward' )
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'inforward' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to button.', 'inforward' ),
			'group' => esc_html__( 'Button', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'num',
			'value' => Inforward_Vc_Config::array_number(1, 30, 1),
			'std' => 9,
			'description' => esc_html__( 'How many items should be displayed?', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'type_widget',
			'description' => esc_html__( 'Select type.', 'inforward' ),
			'value' => array(
				esc_html__( 'type1', 'inforward' ) => 'type1',
				esc_html__( 'type2', 'inforward' ) => 'type2',
				esc_html__( 'type3', 'inforward' ) => 'type3',
				esc_html__( 'type4', 'inforward' ) => 'type4',
				esc_html__( 'type5', 'inforward' ) => 'type5 carousel-twitter',
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Height', 'inforward' ),
			'param_name' => 'height',
			'value'=> '',
			'description' => esc_html__( 'Enter height (px)', 'inforward' )
		),
	)
) );

 }

/* Widget Facebook
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Inforward Facebook widget', 'inforward' ),
	'base' => 'vc_mad_facebook_widget',
	'category' => esc_html__( 'Inforward', 'inforward'),
	'icon' => '',
	'description' => esc_html__( 'Widget Facebook', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' )
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Shortcode', 'inforward' ),
			'param_name' => 'username',
			'value'=> '',
			'description' => esc_html__( 'Enter shortcode.([custom-facebook-feed num=1 height=500px])', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'type',
			'description' => esc_html__( 'Select type.', 'inforward' ),
			'value' => array(
				esc_html__( 'Type 1', 'inforward' ) => 'type-1',
				esc_html__( 'Type 2', 'inforward' ) => 'type-2',
				esc_html__( 'Type 3', 'inforward' ) => 'type-3',
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Height', 'inforward' ),
			'param_name' => 'height',
			'value'=> '',
			'description' => esc_html__( 'Enter height (px)', 'inforward' )
		),
	)
) );

/* Widget Video
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Inforward Video widget', 'inforward' ),
	'base' => 'vc_mad_video_widget',
	'category' => esc_html__( 'Inforward', 'inforward'),
	'icon' => '',
	'description' => esc_html__( 'Widget Video', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'URL video', 'inforward' ),
			'param_name' => 'video_path',
			'value'=> '',
			'description' => esc_html__( 'Enter url  video', 'inforward' )
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'inforward' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to button.', 'inforward' ),
			'group' => esc_html__( 'Button', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Video width', 'inforward' ),
			'param_name' => 'video_w',
			'value'=> '',
			'description' => esc_html__( 'Enter width', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Widget Height', 'inforward' ),
			'param_name' => 'height',
			'value'=> '',
			'description' => esc_html__( 'Enter height (px)', 'inforward' )
		),
	)
) );

/* Testimonials
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Testimonials', 'inforward' ),
	'base' => 'vc_mad_testimonials',
	'icon' => 'icon-wpb-mad-testimonials',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Testimonials post type', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => '',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Description', 'inforward' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for description', 'inforward' ),
			'param_name' => 'description_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for description.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for content', 'inforward' ),
			'param_name' => 'text_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for content.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for author company', 'inforward' ),
			'param_name' => 'company_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for author company.', 'inforward' ),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Title align", 'inforward'),
			"param_name" => "title_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Description align", 'inforward'),
			"param_name" => "description_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Layout', 'inforward' ),
			'param_name' => 'layout',
			'value' => array(
				esc_html__( 'List', 'inforward' ) => 'type-1',
				esc_html__( 'Carousel 1', 'inforward' ) => 'type-2',
				esc_html__( 'Carousel 2', 'inforward' ) => 'type-3',
			),
			'std' => 'type-1',
			'description' => esc_html__( 'Choose the default blog layout here.', 'inforward' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Autoplay', 'inforward' ),
			'param_name' => 'autoplay',
			'description' => esc_html__( 'Enables autoplay mode.', 'inforward' ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'type-2', 'type-3' )
			),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => 'yes' )
		),
		array(
			'type' => 'number',
			'heading' => esc_html__( 'Autoplay timeout', 'inforward' ),
			'param_name' => 'autoplaytimeout',
			'description' => esc_html__( 'Autoplay interval timeout', 'inforward' ),
			'value' => 5000,
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array( 'yes' )
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 30, 1, array('All' => '-1')),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'inforward' )
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'inforward' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to button.', 'inforward' ),
			'group' => esc_html__( 'Button', 'inforward' ),
		),
		array(
			"type" => "get_terms",
			"term" => "testimonials_category",
			'heading' => esc_html__( 'Which categories should be used for the testimonials?', 'inforward' ),
			"param_name" => "categories",
			"holder" => "div",
			'description' => esc_html__('The Page will then show testimonials from only those categories.', 'inforward'),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'inforward' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'inforward' ) => 'date',
				esc_html__( 'ID', 'inforward' ) => 'ID',
				esc_html__( 'Author', 'inforward' ) => 'author',
				esc_html__( 'Title', 'inforward' ) => 'title',
				esc_html__( 'Modified', 'inforward' ) => 'modified',
				esc_html__( 'Random', 'inforward' ) => 'rand',
				esc_html__( 'Comment count', 'inforward' ) => 'comment_count',
				esc_html__( 'Menu order', 'inforward' ) => 'menu_order'
			),
			'description' => esc_html__( 'Sort retrieved items by parameter', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'inforward' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'inforward' ) => 'DESC',
				esc_html__( 'ASC', 'inforward' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		inforward_vc_map_add_css_animation()
	)
) );

/* Brands Logo
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Brands Logo', 'inforward' ),
	'base' => 'vc_mad_brands_logo',
	'icon' => 'icon-wpb-mad-brands-logo',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Brands logo', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'inforward' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for description', 'inforward' ),
			'param_name' => 'description_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for description.', 'inforward' ),
		),
		array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Images', 'inforward' ),
			'param_name' => 'images',
			'value' => '',
			'description' => esc_html__( 'Select images from media library.', 'inforward' )
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__( 'Links', 'inforward' ),
			"param_name" => "links",
			"holder" => "span",
			"description" => esc_html__( 'Input links values. Divide values with linebreaks (|). Example: http://brand.com | http://brand2.com', 'inforward' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable carousel', 'inforward' ),
			'param_name' => 'carousel',
			'description' => esc_html__( 'Enable carousel.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Autoplay', 'inforward' ),
			'param_name' => 'autoplay',
			'description' => esc_html__( 'Enables autoplay mode.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => 'yes' )
		),
		array(
			'type' => 'number',
			'heading' => esc_html__( 'Autoplay timeout', 'inforward' ),
			'param_name' => 'autoplaytimeout',
			'description' => esc_html__( 'Autoplay interval timeout', 'inforward' ),
			'value' => 5000,
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array( 'yes' )
			)
		),
		inforward_vc_map_add_css_animation()
	)
) );

/* Blockquotes
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Blockquotes', 'inforward' ),
	'base' => 'vc_mad_blockquotes',
	'icon' => 'icon-wpb-mad-testimonials',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Blockquotes styles', 'inforward' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'inforward' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__( 'Style 1', 'inforward' ) => 'with-bg style-2',
				esc_html__( 'Style 2', 'inforward' ) => 'with-bg-2',
			),
			'std' => 'with-bg style-2',
			'description' => esc_html__( 'Choose the default style for blockquote.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Author', 'inforward' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as author description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Status', 'inforward' ),
			'param_name' => 'info',
			'description' => esc_html__( 'Enter text which will be used as author description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'inforward' ),
			'param_name' => 'content',
			'value' => esc_html__( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'inforward' ),
		)

	)
));

/* Text with image
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Text with image', 'inforward' ),
	'base' => 'vc_mad_text_with_image',
	'icon' => '',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Text with image', 'inforward' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'box_type',
			'value' => array(
				esc_html__('Type 1', 'inforward') => 'type-1',
				esc_html__('Type 2', 'inforward') => 'type-2',
			),
			'description' => esc_html__( 'Select message box type design.', 'inforward' ),
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'inforward' ),
			'param_name' => 'image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'inforward' )
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Message text', 'inforward' ),
			'param_name' => 'content',
			'value' => esc_html__( 'I am message box. Click edit button to change this text.', 'inforward' ),
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'inforward' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to button.', 'inforward' ),
			'group' => esc_html__( 'Button', 'inforward' ),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'button', 'button_bottom' )
			),
		),
	),
));

/* Team Members
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Team Members', 'inforward' ),
	'base' => 'vc_mad_team_members',
	'icon' => 'icon-wpb-mad-team-members',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Team Members post type', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Description', 'inforward' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for description', 'inforward' ),
			'param_name' => 'description_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for description.', 'inforward' ),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Title align", 'inforward'),
			"param_name" => "title_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Description align", 'inforward'),
			"param_name" => "description_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'inforward' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '2 Columns', 'inforward' ) => 2,
				esc_html__( '3 Columns', 'inforward' ) => 3,
				esc_html__( '4 Columns', 'inforward' ) => 4
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 30, 1, array('All' => '-1')),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'inforward' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable excerpt', 'inforward' ),
			'param_name' => 'excerpt',
			'description' => esc_html__( 'Enable excerpt.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable social', 'inforward' ),
			'param_name' => 'enable_social',
			'description' => esc_html__( 'Enable social.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable carousel', 'inforward' ),
			'param_name' => 'carousel',
			'description' => esc_html__( 'Enable carousel.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			"type" => "get_terms",
			"term" => "team_category",
			'heading' => esc_html__( 'Which categories should be used for the team?', 'inforward' ),
			"param_name" => "categories",
			"holder" => "div",
			'description' => esc_html__('The Page will then show team from only those categories.', 'inforward'),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'inforward' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'inforward' ) => 'date',
				esc_html__( 'ID', 'inforward' ) => 'ID',
				esc_html__( 'Author', 'inforward' ) => 'author',
				esc_html__( 'Title', 'inforward' ) => 'title',
				esc_html__( 'Modified', 'inforward' ) => 'modified',
				esc_html__( 'Random', 'inforward' ) => 'rand',
				esc_html__( 'Comment count', 'inforward' ) => 'comment_count',
				esc_html__( 'Menu order', 'inforward' ) => 'menu_order'
			),
			'description' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'inforward' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'inforward' ) => 'DESC',
				esc_html__( 'ASC', 'inforward' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'inforward' )
		),
		inforward_vc_map_add_css_animation()
	)
) );

/* Gallery/Slideshow
---------------------------------------------------------- */
vc_map( array(
	'name' => esc_html__( 'Image Gallery', 'inforward' ),
	'base' => 'vc_gallery',
	'icon' => 'icon-wpb-images-stack',
	'category' => esc_html__( 'Content', 'inforward' ),
	'description' => esc_html__( 'Responsive image gallery', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Widget title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Image source', 'inforward' ),
			'param_name' => 'source',
			'value' => array(
				esc_html__( 'Media library', 'inforward' ) => 'media_library',
				esc_html__( 'External links', 'inforward' ) => 'external_link',
			),
			'std' => 'media_library',
			'description' => esc_html__( 'Select image source.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'inforward' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '2 Columns', 'inforward' ) => 2,
				esc_html__( '3 Columns', 'inforward' ) => 3,
				esc_html__( '4 Columns', 'inforward' ) => 4,
				esc_html__( '5 Columns', 'inforward' ) => 5,
				esc_html__( '6 Columns', 'inforward' ) => 6
			),
			'std' => 4,
			'description' => esc_html__( 'How many columns should be displayed?', 'inforward' )
		),
		array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Images', 'inforward' ),
			'param_name' => 'images',
			'value' => '',
			'description' => esc_html__( 'Select images from media library.', 'inforward' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'media_library',
			),
		),
		array(
			'type' => 'exploded_textarea',
			'heading' => esc_html__( 'External links', 'inforward' ),
			'param_name' => 'custom_srcs',
			'description' => esc_html__( 'Enter external link for each gallery image (Note: divide links with linebreaks (Enter)).', 'inforward' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'external_link',
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Image size', 'inforward' ),
			'param_name' => 'img_size',
			'value' => 'thumbnail',
			'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'inforward' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'media_library',
			),
			'std' => '275x275'
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Image size', 'inforward' ),
			'param_name' => 'external_img_size',
			'value' => '',
			'description' => esc_html__( 'Enter image size in pixels. Example: 200x100 (Width x Height).', 'inforward' ),
			'dependency' => array(
				'element' => 'source',
				'value' => 'external_link',
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Enable carousel', 'inforward' ),
			'param_name' => 'carousel',
			'description' => esc_html__( 'Enable carousel.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'On click action', 'inforward' ),
			'param_name' => 'onclick',
			'value' => array(
				esc_html__( 'Open lightbox', 'inforward' ) => 'link_image',
				esc_html__( 'Open custom link', 'inforward' ) => 'custom_link',
			),
			'description' => esc_html__( 'Select action for click action.', 'inforward' ),
			'std' => 'link_image',
		),
		array(
			'type' => 'exploded_textarea',
			'heading' => esc_html__( 'Custom links', 'inforward' ),
			'param_name' => 'custom_links',
			'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'inforward' ),
			'dependency' => array(
				'element' => 'onclick',
				'value' => array( 'custom_link' ),
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Custom link target', 'inforward' ),
			'param_name' => 'custom_links_target',
			'description' => esc_html__( 'Select where to open  custom links.', 'inforward' ),
			'dependency' => array(
				'element' => 'onclick',
				'value' => array( 'custom_link', 'img_link_large' ),
			),
			'value' => $target_arr,
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'inforward' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'inforward' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'inforward' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'inforward' ),
		),
	),
) );

/* Message
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Message Box', 'inforward' ),
	'base' => 'vc_mad_message',
	'icon' => 'icon-wpb-mad-message-box',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Notification boxes', 'inforward' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'inforward' ),
			'param_name' => 'message_box_style',
			'value' => array(
				esc_html__('Success', 'inforward') => 'alert-success',
				esc_html__('Warning', 'inforward') => 'alert-warning',
				esc_html__('Info', 'inforward') => 'alert-info',
				esc_html__('Fail', 'inforward') => 'alert-fail',
			),
			'description' => esc_html__( 'Select message box style.', 'inforward' ),
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'class' => 'messagebox_text',
			'heading' => esc_html__( 'Message text', 'inforward' ),
			'param_name' => 'content',
			'value' => wp_kses(__( '<p>I am message box. Click edit button to change this text.</p>', 'inforward' ), 'default'),
		)
	),
));

/* List Styles
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'List Styles', 'inforward' ),
	'base' => 'vc_mad_list_styles',
	'icon' => 'icon-wpb-mad-list-styles',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'List styles', 'inforward' ),
	'params' => array(
		array(
			'type' => 'exploded_textarea',
			'heading' => esc_html__( 'List Items', 'inforward' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Input list items values. Divide values with (|). Example: Development|Design', 'inforward' ),
			'value' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Layout', 'inforward' ),
			'param_name' => 'layout',
			'value' => array(
				esc_html__('Type 1', 'inforward') => 'type-1',
				esc_html__('Type 2', 'inforward') => 'type-2',
				esc_html__('Type 3', 'inforward') => 'type-3',
				esc_html__('Type 4', 'inforward') => 'type-4',
				esc_html__('Type 5', 'inforward') => 'type-5',
				esc_html__('Type 6', 'inforward') => 'type-6'
			),
			'std' => '',
			'description' => esc_html__('Choose layout style.', 'inforward')
		),
	)
) );

/* Countdown
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__( "Countdown", 'inforward' ),
	"base" => "vc_mad_countdown",
	"icon" => "icon-wpb-mad-countdown",
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Countdown', 'inforward' ),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Title", 'inforward' ),
			"param_name" => "title",
			"value" => '',
		),
		array(
			"type" => "datetimepicker",
			"class" => "",
			"heading" => esc_html__("Target Time For Countdown", 'inforward'),
			"param_name" => "datetime",
			"value" => "",
			"description" => esc_html__("Date and time format (yyyy/mm/dd hh:mm:ss).", 'inforward'),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Text align", 'inforward'),
			"param_name" => "text_align",
			"value" => array(
				esc_html__("Left",'inforward') => "left",
				esc_html__("Right",'inforward') => "right",
				esc_html__("Center",'inforward') => "center"
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'inforward' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'inforward' )
		)
	)
) );

/* Call to Action
---------------------------------------------------------- */

$wysija_forms = array();

if ( defined('WYSIJA') ) {
	$model_forms = WYSIJA::get( 'forms', 'model' );
	$model_forms->reset();
	$forms = $model_forms->getRows( array( 'form_id', 'name' ) );
	if ( $forms ) {
		foreach( $forms as $form ) {
			if ( isset($form) )
				$wysija_forms[$form['name']] = $form['form_id'];
		}
	}
}

vc_map( array(
	'name' => esc_html__( 'Call to Action', 'inforward' ),
	'base' => 'vc_mad_cta',
	'icon' => 'icon-wpb-mad-cta',
	'category' => array( esc_html__( 'Inforward', 'inforward' ) ),
	'description' => esc_html__( 'Catch visitors attention with CTA block', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Heading', 'inforward' ),
			'admin_label' => true,
			'param_name' => 'h2',
			'value' => esc_html__( 'Hey! I am first heading line feel free to change me', 'inforward' ),
			'description' => esc_html__( 'Enter text for heading line. \n = LF (Line Feed) - Used as a new line character', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-9',
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Text color', 'inforward' ),
			'param_name' => 'custom_text',
			'description' => esc_html__( 'Select custom text color.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Subheading', 'inforward' ),
			'param_name' => 'p',
			'value' => '',
			'description' => esc_html__( 'Enter text for subheading line.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-9',
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Subheading Text color', 'inforward' ),
			'param_name' => 'subheading_text',
			'description' => esc_html__( 'Select custom text color.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type Style', 'inforward' ),
			'param_name' => 'type',
			'value' => array(
				esc_html__( 'Default Style', 'inforward' ) => '',
				esc_html__( 'White Style', 'inforward' ) => 'cp-type-3',
				esc_html__( 'Black Style', 'inforward' ) => 'cp-type-4',
			),
			'description' => esc_html__( 'Choose the style here', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Add button or form?', 'inforward' ),
			'param_name' => 'add',
			'value' => array(
				esc_html__( 'No', 'inforward' ) => '',
				esc_html__( 'Button Right', 'inforward' ) => 'button',
				esc_html__( 'Button Bottom', 'inforward' ) => 'button_bottom',
				esc_html__( 'Subscribe Form', 'inforward' ) => 'form',
			),
			'description' => esc_html__( 'Add button or form for call to action.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Select a form', 'inforward' ),
			'param_name' => 'select_form',
			'value' => $wysija_forms,
			'group' => esc_html__( 'Form', 'inforward' ),
			'description' => esc_html__( 'Select a form.', 'inforward' ),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'form' )
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Form alignment', 'inforward' ),
			'param_name' => 'position_form',
			'value' => array(
				esc_html__( 'Right', 'inforward' ) => '',
				esc_html__( 'Bottom', 'inforward' ) => 'bottom'
			),
			'group' => esc_html__( 'Form', 'inforward' ),
			'description' => esc_html__( 'Select form alignment.', 'inforward' ),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'form' )
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'CSS Animation', 'inforward' ),
			'param_name' => 'css_form_animation',
			'admin_label' => true,
			'value' => array(
				esc_html__( 'No', 'inforward' ) => '',
				esc_html__( 'Fade In Up', 'inforward' ) => 'fadeInUp',
				esc_html__( 'Zoom In Down', 'inforward' ) => 'zoomInDown',
				esc_html__( 'Bounce In Down', 'inforward' ) => 'bounceInDown',
				esc_html__( 'Bounce In Up', 'inforward' ) => 'bounceInUp',
				esc_html__( 'Flip In Y', 'inforward' ) => 'flipInY',
			),
			'group' => esc_html__( 'Form', 'inforward' ),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'form' )
			),
			'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'inforward' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Add Phone', 'inforward' ),
			'param_name' => 'add_second_button',
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => true ),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'button' )
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'CSS Animation', 'inforward' ),
			'param_name' => 'css_animation',
			'admin_label' => true,
			'value' => array(
				esc_html__( 'No', 'inforward' ) => '',
				esc_html__( 'Fade In Up', 'inforward' ) => 'fadeInUp',
				esc_html__( 'Zoom In Down', 'inforward' ) => 'zoomInDown',
				esc_html__( 'Bounce In Down', 'inforward' ) => 'bounceInDown',
				esc_html__( 'Bounce In Up', 'inforward' ) => 'bounceInUp',
				esc_html__( 'Flip In Y', 'inforward' ) => 'flipInY',
			),
			'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'inforward' )
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'inforward' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to button.', 'inforward' ),
			'group' => esc_html__( 'Button', 'inforward' ),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'button', 'button_bottom' )
			),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Text', 'inforward' ),
			'param_name' => 'custom_button_color',
			'description' => esc_html__( 'Select custom text color for button.', 'inforward' ),
			'group' => esc_html__( 'Button', 'inforward' ),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'button', 'button_bottom' )
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'CSS Animation', 'inforward' ),
			'param_name' => 'css_button_animation',
			'admin_label' => true,
			'value' => array(
				esc_html__( 'No', 'inforward' ) => '',
				esc_html__( 'Fade In Up', 'inforward' ) => 'fadeInUp',
				esc_html__( 'Zoom In Down', 'inforward' ) => 'zoomInDown',
				esc_html__( 'Bounce In Down', 'inforward' ) => 'bounceInDown',
				esc_html__( 'Bounce In Up', 'inforward' ) => 'bounceInUp',
				esc_html__( 'Flip In Y', 'inforward' ) => 'flipInY',
			),
			'group' => esc_html__( 'Button', 'inforward' ),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'button', 'button_bottom' )
			),
			'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Phone', 'inforward' ),
			'param_name' => 'second_link',
			'description' => esc_html__( 'Enter text for phone.', 'inforward' ),
			'group' => esc_html__( 'Phone', 'inforward' ),
			'dependency' => array(
				'element' => 'add_second_button',
				'not_empty' => true
			),
		)
	),
	'js_view' => 'VcCallToActionView3',
));

/* Progress Bar
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Progress Bar', 'inforward' ),
	'base' => 'vc_mad_progress_bar',
	'icon' => 'icon-wpb-mad-progress-bar',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Animated progress bar', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'inforward' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for description', 'inforward' ),
			'param_name' => 'description_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for description.', 'inforward' ),
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'inforward' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values for graph - value, title and color.', 'inforward' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'Development', 'inforward' ),
					'value' => '90',
				),
				array(
					'label' => esc_html__( 'Design', 'inforward' ),
					'value' => '80',
				),
				array(
					'label' => esc_html__( 'Marketing', 'inforward' ),
					'value' => '70',
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'inforward' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as title of bar.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Value', 'inforward' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter value of bar.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Color', 'inforward' ),
					'param_name' => 'color',
					'value' => array(
							esc_html__( 'Default', 'inforward' ) => '',
						) + array(
							esc_html__( 'Blue', 'inforward' ) => 'bar_blue',
							esc_html__( 'Green', 'inforward' ) => 'bar_green',
							esc_html__( 'Orange', 'inforward' ) => 'bar_orange'
						),
					'description' => esc_html__( 'Select single bar background color.', 'inforward' ),
					'admin_label' => true,
					'param_holder_class' => 'vc_colored-dropdown',
				),
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Units', 'inforward' ),
			'param_name' => 'units',
			'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'inforward' ),
		),
		inforward_vc_map_add_css_animation(),
	),
));

/* Banners
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Banners', 'inforward' ),
	'base' => 'vc_mad_banners',
	'icon' => 'icon-wpb-mad-banners',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'banners', 'inforward' ),
	'params' => array(
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'inforward' ),
			'param_name' => 'image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'inforward' )
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__( 'Add URL to the button', 'inforward' ),
			"param_name" => "link"
		),
		inforward_vc_map_add_css_animation()
	)
) );

/* Video Button
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Video Button", 'inforward' ),
	"base"=> 'vc_mad_video_button',
	"icon" => 'icon-wpb-mad-video-button',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Video Button', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Video link', 'inforward' ),
			'param_name' => 'link',
			'value' => 'https://vimeo.com/51589652',
			'admin_label' => true,
			'description' => sprintf( wp_kses(__( 'Enter link to video (Note: read more about available formats at WordPress <a href="%s" target="_blank">codex page</a>).', 'inforward' ), 'default'), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'inforward' ),
			'param_name' => 'image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment', 'inforward' ),
			'param_name' => 'align',
			'description' => esc_html__( 'Select video button alignment.', 'inforward' ),
			'value' => array(
				esc_html__( 'Left', 'inforward' ) => 'left',
				esc_html__( 'Right', 'inforward' ) => 'right',
				esc_html__( 'Center', 'inforward' ) => 'center',
			),
		),
	)
));

/* Counter Bar
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Counter", 'inforward' ),
	"base"=> 'vc_mad_counter',
	"icon" => 'icon-wpb-mad-counter',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Animated counter', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'inforward' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title block.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for description', 'inforward' ),
			'param_name' => 'description_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for description block.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for count number', 'inforward' ),
			'param_name' => 'number_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for count number.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for count label', 'inforward' ),
			'param_name' => 'label_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for count label.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for count icon', 'inforward' ),
			'param_name' => 'icon_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for count icon.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'type',
			'value' => array(
				esc_html__( 'Type 1', 'inforward' ) => 'type-1',
				esc_html__( 'Type 2', 'inforward' ) => 'type-2'
			),
			'description' => esc_html__('Choose the counters style.', 'inforward')
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'inforward' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values - value and title.', 'inforward' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'Successful projects', 'inforward' ),
					'value' => '135',
					'icon'  => ''
				),
				array(
					'label' => esc_html__( 'Talanted Professionals', 'inforward' ),
					'value' => '12',
				),
				array(
					'label' => esc_html__( 'Awards Winned', 'inforward' ),
					'value' => '42',
					'icon'  => ''
				),
				array(
					'label' => esc_html__( 'Years of Hardwork', 'inforward' ),
					'value' => '9',
					'icon'  => ''
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'inforward' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as title.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Value', 'inforward' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter value.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					"type" => "choose_icons",
					"heading" => esc_html__("Icon", 'inforward'),
					"param_name" => "icon",
					"value" => 'none',
					"description" => esc_html__( 'Select icon from library.', 'inforward')
				)
			)
		),
		inforward_vc_map_add_css_animation()
	)
));

/* Services List
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Services List", 'inforward' ),
	"base"=> 'vc_mad_services_list',
	"icon" => 'icon-mad-info-list',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Services list', 'inforward' ),
	"params" => array(
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'inforward' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values - value and title.', 'inforward' ),
			'value' => urlencode( json_encode( array(
				array(
					'image' => '',
					'label' => '',
					'value' => '',
					'link' => '',
				),
				array(
					'image' => '',
					'label' => '',
					'value' => '',
					'link' => '',
				)
			) ) ),
			'params' => array(
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'inforward' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'inforward' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'inforward' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as label.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__( 'Add URL to the button', 'inforward' ),
					"param_name" => "link"
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Description', 'inforward' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter description.', 'inforward' ),
					'admin_label' => true,
				)
			)
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'edit_field_class' => 'vc_col-sm-6',
			'description' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Title align", 'inforward'),
			"param_name" => "title_align",
			'group' => esc_html__( 'Styling', 'inforward' ),
			"value" => array(
				esc_html__("Left",'inforward') => "align-left",
				esc_html__("Right",'inforward') => "align-right",
				esc_html__("Center",'inforward') => "align-center"
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'inforward' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( 'Columns 1', 'inforward' ) => 'fx-col-1',
				esc_html__( 'Columns 2', 'inforward' ) => 'fx-col-2',
				esc_html__( 'Columns 3', 'inforward' ) => 'fx-col-3',
			),
			'std' => 'fx-col-2',
			'description' => esc_html__( 'Choose the columns for services.', 'inforward' )
		)
	)
));

/* Info List
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Experience List", 'inforward' ),
	"base"=> 'vc_mad_experience_list',
	"icon" => 'icon-mad-info-list',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Team member experience list', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'inforward' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values - value and title.', 'inforward' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => '',
					'value' => '',
					'time' => '',
				),
				array(
					'label' => '',
					'value' => '',
					'time' => '',
				)
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'inforward' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as name.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Value', 'inforward' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter value.', 'inforward' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Time', 'inforward' ),
					'param_name' => 'time',
					'description' => esc_html__( 'Enter time.', 'inforward' ),
					'admin_label' => true,
				)
			)
		)
	)
));

/* Dropcap
---------------------------------------------------------- */
vc_map( array(
	'name' => esc_html__( 'Dropcap', 'inforward' ),
	'base' => 'vc_mad_dropcap',
	'icon' => 'icon-wpb-mad-dropcap',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	'description' => esc_html__( 'Dropcap', 'inforward' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'type',
			'value' => array(
				esc_html__( 'Type 1', 'inforward' ) => 'type-1',
				esc_html__( 'Type 2', 'inforward' ) => 'type-2'
			),
			'description' => esc_html__('Choose the first letter style.', 'inforward')
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'inforward' ),
			'param_name' => 'content',
			'value' => ''
		),
		inforward_vc_map_add_css_animation(),
		inforward_vc_map_add_animation_delay(),
		inforward_vc_map_add_scroll_factor()
	)
));

/* Events carousel
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Events Carousel", 'inforward' ),
	"base"=> 'vc_mad_events_carousel',
	"icon" => '',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Events carousel', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std' => '#d2d2d2',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for item text', 'inforward' ),
			'param_name' => 'item_title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std' => '#fff',
			'description' => esc_html__( 'Select custom color for item title.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 30, 1, array('All' => '-1')),
			'std' => 3,
			'description' => esc_html__( 'How many items should be displayed?', 'inforward' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Autoplay', 'inforward' ),
			'param_name' => 'autoplay',
			'description' => esc_html__( 'Enables autoplay mode.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => 'yes' )
		),
		array(
			'type' => 'number',
			'heading' => esc_html__( 'Autoplay timeout', 'inforward' ),
			'param_name' => 'autoplaytimeout',
			'description' => esc_html__( 'Autoplay interval timeout', 'inforward' ),
			'value' => 5000,
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array( 'yes' )
			)
		),
		inforward_vc_map_add_css_animation()
	)
));
/* Events Slider
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Events Slider", 'inforward' ),
	"base"=> 'vc_mad_events_slider',
	"icon" => '',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Events Slider', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for item text', 'inforward' ),
			'param_name' => 'item_title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std' => '#fff',
			'description' => esc_html__( 'Select custom color for item title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for item background', 'inforward' ),
			'param_name' => 'item_bg_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std' => '#bf0d3e',
			'description' => esc_html__( 'Select custom color for item background.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for button background', 'inforward' ),
			'param_name' => 'btn_bg_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std' => '#bf0d3e',
			'description' => esc_html__( 'Select custom color for button background.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for button title', 'inforward' ),
			'param_name' => 'btn_title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std' => '#bf0d3e',
			'description' => esc_html__( 'Select custom color for button title.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 30, 1, array('All' => '-1')),
			'std' => 3,
			'description' => esc_html__( 'How many items should be displayed?', 'inforward' )
		),
		inforward_vc_map_add_css_animation()
	)
));

/* Events List
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Events List", 'inforward' ),
	"base"=> 'vc_mad_events_list',
	"icon" => 'icon-mad-info-list',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Events list', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag for title', 'inforward' ),
			'param_name' => 'tag_title',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6'
			),
			'std' => 'h2',
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Choose tag for title.', 'inforward' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for title', 'inforward' ),
			'param_name' => 'title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for title.', 'inforward' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for item title', 'inforward' ),
			'param_name' => 'item_title_color',
			'group' => esc_html__( 'Styling', 'inforward' ),
			'edit_field_class' => 'vc_col-sm-6',
			'description' => esc_html__( 'Select custom color for item title.', 'inforward' ),
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__( 'Add URL to the button', 'inforward' ),
			"param_name" => "link"
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 30, 1, array('All' => '-1')),
			'std' => 3,
			'description' => esc_html__( 'How many items should be displayed?', 'inforward' )
		),
		inforward_vc_map_add_css_animation()
	)
));

/* Events Countdown
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Events Countdown", 'inforward' ),
	"base"=> 'vc_mad_events_countdown',
	"icon" => 'icon-mad-info-list',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Events countdown', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Type', 'inforward' ),
			'param_name' => 'type',
			'value' => array(
				esc_html__( 'Carousel', 'inforward' ) => 'type-1',
				esc_html__( 'List with image', 'inforward' ) => 'type-2'
			),
			'description' => esc_html__('Choose the counters style.', 'inforward')
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'inforward' ),
			'param_name' => 'image',
			'value' => '',
			'dependency' => array(
				'element' => 'type',
				'value' => array( 'type-2' ),
			),
			'description' => esc_html__( 'Select image from media library.', 'inforward' )
		),
		array(
			"type" => "get_terms",
			"term" => "tribe_events_cat",
			'heading' => esc_html__( 'Which categories should be used for the classes?', 'inforward' ),
			"param_name" => "categories",
			'description' => esc_html__('The Page will then show classes from only those categories.', 'inforward'),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'inforward' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'inforward' ) => 'date',
				esc_html__( 'ID', 'inforward' ) => 'ID',
				esc_html__( 'Author', 'inforward' ) => 'author',
				esc_html__( 'Title', 'inforward' ) => 'title',
				esc_html__( 'Modified', 'inforward' ) => 'modified',
				esc_html__( 'Random', 'inforward' ) => 'rand',
				esc_html__( 'Menu order', 'inforward' ) => 'menu_order'
			),
			'description' => esc_html__( 'Sort retrieved items by parameter', 'inforward' ),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'inforward' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'inforward' ) => 'DESC',
				esc_html__( 'ASC', 'inforward' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'inforward' ),
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'inforward' ),
			'param_name' => 'items',
			'value' => Inforward_Vc_Config::array_number(1, 30, 1, array('All' => '-1')),
			'std' => 3,
			'description' => esc_html__( 'How many items should be displayed?', 'inforward' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Autoplay', 'inforward' ),
			'param_name' => 'autoplay',
			'dependency' => array(
				'element' => 'type',
				'value' => array( 'type-1' ),
			),
			'description' => esc_html__( 'Enables autoplay mode.', 'inforward' ),
			'value' => array( esc_html__( 'Yes, please', 'inforward' ) => 'yes' )
		),
		array(
			'type' => 'number',
			'heading' => esc_html__( 'Autoplay timeout', 'inforward' ),
			'param_name' => 'autoplaytimeout',
			'description' => esc_html__( 'Autoplay interval timeout', 'inforward' ),
			'value' => 5000,
			'dependency' => array(
				'element' => 'type',
				'value' => array( 'type-1' ),
			),
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array( 'yes' )
			)
		),
		inforward_vc_map_add_css_animation()
	)
));


/* Give Donation
---------------------------------------------------------- */
if ( class_exists( 'Give' ) ) {
vc_map( array(
	"name" => esc_html__("Give Donation", 'inforward' ),
	"base"=> 'vc_mad_give_donation',
	"icon" => 'icon-mad-info-list',
	'category' => esc_html__( 'Inforward', 'inforward' ),
	"description" => esc_html__( 'Give Donation', 'inforward' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'inforward' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'inforward' ),
			'param_name' => 'image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'inforward' )
		),
		array(
			"type" => "get_by_id",
			"post_type" => "give_forms",
			'heading' => esc_html__( 'Select donation', 'inforward' ),
			"param_name" => "donation_id",
			"holder" => "div",
			'description' => '',
			'group' => esc_html__( 'Data Settings', 'inforward' )
		),
		inforward_vc_map_add_css_animation()
	)
));
}

/*** Visual Composer Content elements refresh ***/
class inforwardVcSharedLibrary {

	private static $colors = array(
		'Blue' => 'blue',
		'Turquoise' => 'turquoise',
		'Pink' => 'pink',
		'Violet' => 'violet',
		'Peacoc' => 'peacoc',
		'Chino' => 'chino',
		'Mulled Wine' => 'mulled_wine',
		'Vista Blue' => 'vista_blue',
		'Black' => 'black',
		'Grey' => 'grey',
		'Orange' => 'orange',
		'Sky' => 'sky',
		'Green' => 'green',
		'Juicy pink' => 'juicy_pink',
		'Sandy brown' => 'sandy_brown',
		'Purple' => 'purple',
		'White' => 'white'
	);

	/**
	 * @var array
	 */
	public static $icons = array(
		'Glass' => 'glass',
		'Music' => 'music',
		'Search' => 'search'
	);

	/**
	 * @var array
	 */
	public static $sizes = array(
		'Mini' => 'xs',
		'Small' => 'sm',
		'Normal' => 'md',
		'Large' => 'lg'
	);

	/**
	 * @var array
	 */
	public static $button_styles = array(
		'Rounded' => 'rounded',
		'Square' => 'square',
		'Round' => 'round',
		'Outlined' => 'outlined',
		'3D' => '3d',
		'Square Outlined' => 'square_outlined'
	);

	/**
	 * @var array
	 */
	public static $message_box_styles = array(
		'Standard' => 'standard',
		'Solid' => 'solid',
		'Solid icon' => 'solid-icon',
		'Outline' => 'outline',
		'3D' => '3d',
	);

	/**
	 * Toggle styles
	 * @var array
	 */
	public static $toggle_styles = array(
		'Default' => 'default',
		'Simple' => 'simple',
		'Round' => 'round',
		'Round Outline' => 'round_outline',
		'Rounded' => 'rounded',
		'Rounded Outline' => 'rounded_outline',
		'Square' => 'square',
		'Square Outline' => 'square_outline',
		'Arrow' => 'arrow',
		'Text Only' => 'text_only',
	);

	/**
	 * Animation styles
	 * @var array
	 */
	public static $animation_styles = array(
		'Bounce' => 'easeOutBounce',
		'Elastic' => 'easeOutElastic',
		'Back' => 'easeOutBack',
		'Cubic' => 'easeinOutCubic',
		'Quint' => 'easeinOutQuint',
		'Quart' => 'easeOutQuart',
		'Quad' => 'easeinQuad',
		'Sine' => 'easeOutSine'
	);

	/**
	 * @var array
	 */
	public static $cta_styles = array(
		'Rounded' => 'rounded',
		'Square' => 'square',
		'Round' => 'round',
		'Outlined' => 'outlined',
		'Square Outlined' => 'square_outlined'
	);

	/**
	 * @var array
	 */
	public static $txt_align = array(
		'Left' => 'left',
		'Right' => 'right',
		'Center' => 'center',
		'Justify' => 'justify'
	);

	/**
	 * @var array
	 */
	public static $el_widths = array(
		'100%' => '',
		'90%' => '90',
		'80%' => '80',
		'70%' => '70',
		'60%' => '60',
		'50%' => '50'
	);

	/**
	 * @var array
	 */
	public static $sep_widths = array(
		'1px' => '',
		'2px' => '2',
		'3px' => '3',
		'4px' => '4',
		'5px' => '5',
		'6px' => '6',
		'7px' => '7',
		'8px' => '8',
		'9px' => '9',
		'10px' => '10'
	);

	/**
	 * @var array
	 */
	public static $sep_styles = array(
		'Border' => '',
		'Dashed' => 'dashed',
		'Dotted' => 'dotted',
		'Double' => 'double'
	);

	/**
	 * @var array
	 */
	public static $box_styles = array(
		'Default' => '',
		'Rounded' => 'vc_box_rounded',
		'Border' => 'vc_box_border',
		'Outline' => 'vc_box_outline',
		'Shadow' => 'vc_box_shadow',
		'Bordered shadow' => 'vc_box_shadow_border',
		'3D Shadow' => 'vc_box_shadow_3d',
		'Round' => 'vc_box_circle', //new
		'Round Border' => 'vc_box_border_circle', //new
		'Round Outline' => 'vc_box_outline_circle', //new
		'Round Shadow' => 'vc_box_shadow_circle', //new
		'Round Border Shadow' => 'vc_box_shadow_border_circle', //new
		'Circle' => 'vc_box_circle_2', //new
		'Circle Border' => 'vc_box_border_circle_2', //new
		'Circle Outline' => 'vc_box_outline_circle_2', //new
		'Circle Shadow' => 'vc_box_shadow_circle_2', //new
		'Circle Border Shadow' => 'vc_box_shadow_border_circle_2' //new
	);

	/**
	 * @return array
	 */
	public static function getColors() {
		return self::$colors;
	}

	/**
	 * @return array
	 */
	public static function getIcons() {
		return self::$icons;
	}

	/**
	 * @return array
	 */
	public static function getSizes() {
		return self::$sizes;
	}

	/**
	 * @return array
	 */
	public static function getButtonStyles() {
		return self::$button_styles;
	}

	/**
	 * @return array
	 */
	public static function getMessageBoxStyles() {
		return self::$message_box_styles;
	}

	/**
	 * @return array
	 */
	public static function getToggleStyles() {
		return self::$toggle_styles;
	}

	/**
	 * @return array
	 */
	public static function getAnimationStyles() {
		return self::$animation_styles;
	}

	/**
	 * @return array
	 */
	public static function getCtaStyles() {
		return self::$cta_styles;
	}

	/**
	 * @return array
	 */
	public static function getTextAlign() {
		return self::$txt_align;
	}

	/**
	 * @return array
	 */
	public static function getBorderWidths() {
		return self::$sep_widths;
	}

	/**
	 * @return array
	 */
	public static function getElementWidths() {
		return self::$el_widths;
	}

	/**
	 * @return array
	 */
	public static function getSeparatorStyles() {
		return self::$sep_styles;
	}

	/**
	 * @return array
	 */
	public static function getBoxStyles() {
		return self::$box_styles;
	}

	public static function getColorsDashed() {
		$colors = array(
			esc_html__( 'Blue', 'inforward' ) => 'blue',
			esc_html__( 'Turquoise', 'inforward' ) => 'turquoise',
			esc_html__( 'Pink', 'inforward' ) => 'pink',
			esc_html__( 'Violet', 'inforward' ) => 'violet',
			esc_html__( 'Peacoc', 'inforward' ) => 'peacoc',
			esc_html__( 'Chino', 'inforward' ) => 'chino',
			esc_html__( 'Mulled Wine', 'inforward' ) => 'mulled-wine',
			esc_html__( 'Vista Blue', 'inforward' ) => 'vista-blue',
			esc_html__( 'Black', 'inforward' ) => 'black',
			esc_html__( 'Grey', 'inforward' ) => 'grey',
			esc_html__( 'Orange', 'inforward' ) => 'orange',
			esc_html__( 'Sky', 'inforward' ) => 'sky',
			esc_html__( 'Green', 'inforward' ) => 'green',
			esc_html__( 'Juicy pink', 'inforward' ) => 'juicy-pink',
			esc_html__( 'Sandy brown', 'inforward' ) => 'sandy-brown',
			esc_html__( 'Purple', 'inforward' ) => 'purple',
			esc_html__( 'White', 'inforward' ) => 'white'
		);

		return $colors;
	}
}

/**
 * @param string $asset
 *
 * @return array
 */
function inforwardgetVcShared( $asset = '' ) {
	switch ( $asset ) {
		case 'colors':
			return inforwardVcSharedLibrary::getColors();
			break;

		case 'colors-dashed':
			return inforwardVcSharedLibrary::getColorsDashed();
			break;

		case 'icons':
			return inforwardVcSharedLibrary::getIcons();
			break;

		case 'sizes':
			return inforwardVcSharedLibrary::getSizes();
			break;

		case 'button styles':
		case 'alert styles':
			return inforwardVcSharedLibrary::getButtonStyles();
			break;
		case 'message_box_styles':
			return inforwardVcSharedLibrary::getMessageBoxStyles();
			break;
		case 'cta styles':
			return inforwardVcSharedLibrary::getCtaStyles();
			break;

		case 'text align':
			return inforwardVcSharedLibrary::getTextAlign();
			break;

		case 'cta widths':
		case 'separator widths':
			return inforwardVcSharedLibrary::getElementWidths();
			break;

		case 'separator styles':
			return inforwardVcSharedLibrary::getSeparatorStyles();
			break;

		case 'separator border widths':
			return inforwardVcSharedLibrary::getBorderWidths();
			break;

		case 'single image styles':
			return inforwardVcSharedLibrary::getBoxStyles();
			break;

		case 'toggle styles':
			return inforwardVcSharedLibrary::getToggleStyles();
			break;

		case 'animation styles':
			return inforwardVcSharedLibrary::getAnimationStyles();
			break;

		default:
			# code...
			break;
	}

	return '';
}