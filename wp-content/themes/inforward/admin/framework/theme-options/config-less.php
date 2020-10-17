<?php $settings = inforward_check_theme_options(); ?>

// Selection Color
@selection_color: <?php echo esc_attr($settings['selection-color']) ?>;

@donate_color: <?php echo esc_attr($settings['donate-color']['regular']) ?>;
@donate_color_title: <?php echo esc_attr($settings['donate-color-title']) ?>;
@donate_color_shadow: <?php echo esc_attr($settings['donate-color-shadow']['rgba']) ?>;
@donate_color_shadow_hover: <?php echo esc_attr($settings['donate-color-shadow-hover']['rgba']) ?>;
@donate_color_hover: <?php echo esc_attr($settings['donate-color']['hover']) ?>;

// Primary Color
@primary_color: <?php echo esc_attr($settings['primary-color']) ?>;
@primary_inverse_color: <?php echo esc_attr($settings['primary-inverse-color']) ?>;

// Secondary Color
@secondary_color: <?php echo esc_attr($settings['secondary-color']) ?>;

//Accent Color
@accent_color: <?php echo esc_attr($settings['accent-color']) ?>;

//Loading Color
@loading_bg_color: <?php echo esc_attr($settings['loading-bg-color']) ?>;
@loading_line_color: <?php echo esc_attr($settings['loading-line-color']) ?>;

// Overlay Color
@overlay_color: <?php echo esc_attr($settings['overlay-color']['rgba']) ?>;

// Content Link Color
@content_link_color: <?php echo esc_attr($settings['content-link-color']['regular']) ?>;
@content_hover_color: <?php echo esc_attr($settings['content-link-color']['hover']) ?>;

// Typography
@body_font_family: <?php echo esc_attr($settings['body-font']['font-family']) ?>;
@body_font_weight: <?php echo esc_attr($settings['body-font']['font-weight']) ?>;
@body_font_size: <?php echo esc_attr($settings['body-font']['font-size']) ?>;
@body_line_height: <?php echo esc_attr($settings['body-font']['line-height']) ?>;
@body_color: <?php echo esc_attr($settings['body-font']['color']) ?>;

// Headings
@h1_font_family: <?php echo esc_attr($settings['h1-font']['font-family']) ?>;
@h1_font_weight: <?php echo esc_attr($settings['h1-font']['font-weight']) ?>;
@h1_font_size: <?php echo esc_attr($settings['h1-font']['font-size']) ?>;
@h1_line_height: <?php echo esc_attr($settings['h1-font']['line-height']) ?>;
@h1_color: <?php echo esc_attr($settings['h1-font']['color']) ?>;

@h2_font_family: <?php echo esc_attr($settings['h2-font']['font-family']) ?>;
@h2_font_weight: <?php echo esc_attr($settings['h2-font']['font-weight']) ?>;
@h2_font_size: <?php echo esc_attr($settings['h2-font']['font-size']) ?>;
@h2_line_height: <?php echo esc_attr($settings['h2-font']['line-height']) ?>;
@h2_color: <?php echo esc_attr($settings['h2-font']['color']) ?>;

@h3_font_family: <?php echo esc_attr($settings['h3-font']['font-family']) ?>;
@h3_font_weight: <?php echo esc_attr($settings['h3-font']['font-weight']) ?>;
@h3_font_size: <?php echo esc_attr($settings['h3-font']['font-size']) ?>;
@h3_line_height: <?php echo esc_attr($settings['h3-font']['line-height']) ?>;
@h3_color: <?php echo esc_attr($settings['h3-font']['color']) ?>;

@h4_font_family: <?php echo esc_attr($settings['h4-font']['font-family']) ?>;
@h4_font_weight: <?php echo esc_attr($settings['h4-font']['font-weight']) ?>;
@h4_font_size: <?php echo esc_attr($settings['h4-font']['font-size']) ?>;
@h4_line_height: <?php echo esc_attr($settings['h4-font']['line-height']) ?>;
@h4_color: <?php echo esc_attr($settings['h4-font']['color']) ?>;

@h5_font_family: <?php echo esc_attr($settings['h5-font']['font-family']) ?>;
@h5_font_weight: <?php echo esc_attr($settings['h5-font']['font-weight']) ?>;
@h5_font_size: <?php echo esc_attr($settings['h5-font']['font-size']) ?>;
@h5_line_height: <?php echo esc_attr($settings['h5-font']['line-height']) ?>;
@h5_color: <?php echo esc_attr($settings['h5-font']['color']) ?>;

@h6_font_family: <?php echo esc_attr($settings['h6-font']['font-family']) ?>;
@h6_font_weight: <?php echo esc_attr($settings['h6-font']['font-weight']) ?>;
@h6_font_size: <?php echo esc_attr($settings['h6-font']['font-size']) ?>;
@h6_line_height: <?php echo esc_attr($settings['h6-font']['line-height']) ?>;
@h6_color: <?php echo esc_attr($settings['h6-font']['color']) ?>;

// Body
@body_bg_color: <?php echo esc_attr($settings['body-bg']['background-color']) ?>;
@body_bg_repeat: <?php echo esc_attr($settings['body-bg']['background-repeat']) ?>;
@body_bg_size: <?php echo esc_attr($settings['body-bg']['background-size']) ?>;
@body_bg_attachment: <?php echo esc_attr($settings['body-bg']['background-attachment']) ?>;
@body_bg_position: <?php echo esc_attr($settings['body-bg']['background-position']) ?>;
<?php
$image = str_replace(array('http://', 'https://'), array('//', '//'), esc_attr($settings['body-bg']['background-image']));
?>
@body_bg_image: <?php echo esc_attr($image) != 'none'?'url('.esc_url($image).')':$image ?>;

// Page Content
@content_bg_color: <?php echo esc_attr($settings['content-bg-color']) ?>;

// Menu
@sticky_menu_bg_color: <?php echo esc_attr($settings['sticky-menu-bg-color']) ?>;
@menu_font_family: <?php echo esc_attr($settings['menu-font']['font-family']) ?>;
@menu_font_weight: <?php echo esc_attr($settings['menu-font']['font-weight']) ?>;
@menu_font_size: <?php echo esc_attr($settings['menu-font']['font-size']) ?>;
@menu_line_height: <?php echo esc_attr($settings['menu-font']['line-height']) ?>;
@main_menu_top_level_type1_hover_color: <?php echo esc_attr($settings['primary-toplevel-type1-link-color']['hover']) ?>;
@main_menu_top_level_type1_color: <?php echo esc_attr($settings['primary-toplevel-type1-link-color']['regular']) ?>;
@main_menu_top_level_type2_hover_color: <?php echo esc_attr($settings['primary-toplevel-type2-link-color']['hover']) ?>;
@main_menu_top_level_type2_color: <?php echo esc_attr($settings['primary-toplevel-type2-link-color']['regular']) ?>;
@header3_current_menu_bg_color: <?php echo esc_attr($settings['header3-current-menu-bg-color']) ?>;

// Mobile Menu
@mobile_menu_btn_color: <?php echo esc_attr($settings['mobile-menu-btn-color']) ?>;
@mobile_menu_bg_color: <?php echo esc_attr($settings['mobile-menu-bg-color']) ?>;
@mobile_menu_link_color: <?php echo esc_attr($settings['mobile-menu-link-color']['regular']) ?>;
@mobile_menu_link_color_hover: <?php echo esc_attr($settings['mobile-menu-link-color']['hover']) ?>;



// Sub Menu
@sub_menu_font_family: <?php echo esc_attr($settings['sub-menu-font']['font-family']) ?>;
@sub_menu_weight: <?php echo esc_attr($settings['sub-menu-font']['font-weight']) ?>;
@sub_menu_size: <?php echo esc_attr($settings['sub-menu-font']['font-size']) ?>;
@sub_menu_line_height: <?php echo esc_attr($settings['sub-menu-font']['line-height']) ?>;
@sub_menu_bg_color: <?php echo esc_attr($settings['sub-menu-bg-color']) ?>;
@sub_menu_link_color: <?php echo esc_attr($settings['sub-menu-text-color']['regular']) ?>;
@sub_menu_hover_color: <?php echo esc_attr($settings['sub-menu-text-color']['hover']) ?>;

//Header
@header_type_1_top_color: <?php echo esc_attr($settings['header-type-1-top-color']) ?>;
@header_type_2_top_color: <?php echo esc_attr($settings['header-type-2-top-color']) ?>;
@header_type_3_top_color: <?php echo esc_attr($settings['header-type-3-top-color']) ?>;
@header_type_3_menu_bg_color: <?php echo esc_attr($settings['header-type-3-menu-bg-color']) ?>;
@header_type_4_top_color: <?php echo esc_attr($settings['header-type-4-top-color']) ?>;
@header_type_4_menu_bg_color: <?php echo esc_attr($settings['header-type-4-menu-bg-color']) ?>;
@header_type_5_top_color: <?php echo esc_attr($settings['header-type-5-top-color']) ?>;


// Footer
@footer_bg_color: <?php echo esc_attr($settings['footer-bg']['background-color']) ?>;
@footer_bg_repeat: <?php echo esc_attr($settings['footer-bg']['background-repeat']) ?>;
@footer_bg_size: <?php echo esc_attr($settings['footer-bg']['background-size']) ?>;
@footer_bg_attachment: <?php echo esc_attr($settings['footer-bg']['background-attachment']) ?>;
@footer_bg_position: <?php echo esc_attr($settings['footer-bg']['background-position']) ?>;
<?php
$image = str_replace(array('http://', 'https://'), array('//', '//'), $settings['footer-bg']['background-image']);
?>
@footer_bg_image: <?php echo esc_attr($image) != 'none'?'url('.esc_url($image).')':$image ?>;


@footer_bg2_color: <?php echo esc_attr($settings['footer-bg2']['background-color']) ?>;
@footer_bg2_repeat: <?php echo esc_attr($settings['footer-bg2']['background-repeat']) ?>;
@footer_bg2_size: <?php echo esc_attr($settings['footer-bg2']['background-size']) ?>;
@footer_bg2_attachment: <?php echo esc_attr($settings['footer-bg2']['background-attachment']) ?>;
@footer_bg2_position: <?php echo esc_attr($settings['footer-bg2']['background-position']) ?>;
<?php
$image = str_replace(array('http://', 'https://'), array('//', '//'), $settings['footer-bg2']['background-image']);
?>
@footer_bg2_image: <?php echo esc_attr($image) != 'none'?'url('.esc_url($image).')':$image ?>;


@footer_bg3_color: <?php echo esc_attr($settings['footer-bg3']['background-color']) ?>;
@footer_bg3_repeat: <?php echo esc_attr($settings['footer-bg3']['background-repeat']) ?>;
@footer_bg3_size: <?php echo esc_attr($settings['footer-bg3']['background-size']) ?>;
@footer_bg3_attachment: <?php echo esc_attr($settings['footer-bg3']['background-attachment']) ?>;
@footer_bg3_position: <?php echo esc_attr($settings['footer-bg3']['background-position']) ?>;
<?php
$image = str_replace(array('http://', 'https://'), array('//', '//'), $settings['footer-bg3']['background-image']);
?>
@footer_bg3_image: <?php echo esc_attr($image) != 'none'?'url('.esc_url($image).')':$image ?>;

@footer_bg4_color: <?php echo esc_attr($settings['footer-bg4']['background-color']) ?>;
@footer_bg4_repeat: <?php echo esc_attr($settings['footer-bg4']['background-repeat']) ?>;
@footer_bg4_size: <?php echo esc_attr($settings['footer-bg4']['background-size']) ?>;
@footer_bg4_attachment: <?php echo esc_attr($settings['footer-bg4']['background-attachment']) ?>;
@footer_bg4_position: <?php echo esc_attr($settings['footer-bg4']['background-position']) ?>;
<?php
$image = str_replace(array('http://', 'https://'), array('//', '//'), $settings['footer-bg3']['background-image']);
?>
@footer_bg4_image: <?php echo esc_attr($image) != 'none'?'url('.esc_url($image).')':$image ?>;

@footer_bg5_color: <?php echo esc_attr($settings['footer-bg5']['background-color']) ?>;
@footer_bg5_repeat: <?php echo esc_attr($settings['footer-bg5']['background-repeat']) ?>;
@footer_bg5_size: <?php echo esc_attr($settings['footer-bg5']['background-size']) ?>;
@footer_bg5_attachment: <?php echo esc_attr($settings['footer-bg5']['background-attachment']) ?>;
@footer_bg5_position: <?php echo esc_attr($settings['footer-bg5']['background-position']) ?>;
<?php
$image = str_replace(array('http://', 'https://'), array('//', '//'), $settings['footer-bg5']['background-image']);
?>
@footer_bg5_image: <?php echo esc_attr($image) != 'none'?'url('.esc_url($image).')':$image ?>;

@footer_heading_color: <?php echo esc_attr($settings['footer-heading-color']) ?>;
@footer_text_color: <?php echo esc_attr($settings['footer-text-color']) ?>;
@footer_link_color: <?php echo esc_attr($settings['footer-link-color']['regular']) ?>;
@footer_hover_color: <?php echo esc_attr($settings['footer-link-color']['hover']) ?>;

@footer_bottom_text_color: <?php echo esc_attr($settings['footer-bottom-text-color']) ?>;
@footer_bottom_link_color: <?php echo esc_attr($settings['footer-bottom-link-color']['regular']) ?>;
@footer_bottom_hover_color: <?php echo esc_attr($settings['footer-bottom-link-color']['hover']) ?>;