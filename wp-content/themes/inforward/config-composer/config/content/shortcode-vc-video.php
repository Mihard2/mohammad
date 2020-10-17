<?php
return array(
	'name' => esc_html__( 'Video Player', 'inforward' ),
	'base' => 'vc_video',
	'icon' => 'icon-wpb-film-youtube',
	'category' => esc_html__( 'Content', 'inforward' ),
	'description' => esc_html__( 'Embed YouTube/Vimeo player', 'inforward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Widget title', 'inforward' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'inforward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Video link', 'inforward' ),
			'param_name' => 'link',
			'value' => 'https://vimeo.com/51589652',
			'admin_label' => true,
			'description' => sprintf( wp_kses(__( 'Enter link to video (Note: read more about available formats at WordPress <a href="%s" target="_blank">codex page</a>).', 'inforward' ), 'default'), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Video width', 'inforward' ),
			'param_name' => 'el_width',
			'value' => array(
				'100%' => '100',
				'90%' => '90',
				'80%' => '80',
				'70%' => '70',
				'60%' => '60',
				'50%' => '50',
				'40%' => '40',
				'30%' => '30',
				'20%' => '20',
				'10%' => '10',
			),
			'description' => esc_html__( 'Select video width (percentage).', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Video aspect ration', 'inforward' ),
			'param_name' => 'el_aspect',
			'value' => array(
				'16:9' => '169',
				'4:3' => '43',
				'2.35:1' => '235',
			),
			'description' => esc_html__( 'Select video aspect ratio.', 'inforward' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment', 'inforward' ),
			'param_name' => 'align',
			'description' => esc_html__( 'Select video alignment.', 'inforward' ),
			'value' => array(
				esc_html__( 'Left', 'inforward' ) => 'left',
				esc_html__( 'Right', 'inforward' ) => 'right',
				esc_html__( 'Center', 'inforward' ) => 'center',
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Autoplay', 'inforward' ),
			'param_name' => 'enable_autoplay',
			'description' => esc_html__( 'Enable autoplay ( for vimeo and youtube )', 'inforward' ),
			'value' => array( esc_html__( 'Yes', 'inforward' ) => 'yes' )
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
);