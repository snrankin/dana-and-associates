<?php
include_once get_template_directory() . '/vc_templates/gt3_google_fonts_render.php';
$defaults = array(
    'thumbnail' => '',
    'image_position' => '',
    'heading' => '',
    'text' => '',
    'url' => '',
    'url_text' => '',
    'new_tab' => '',
    'title_tag' => 'h3',
    'title_color' => '',
    'link_color' => '',
    'link_hover_color' => '',
    'imagebox_title_size' => '',
    'imagebox_content_size' => '',
    'text_color' => '',
    'divider_color' => '',
    'animation_class' => '',
    "add_divider" => '',
);
$atts = vc_shortcode_attribute_parse($defaults, $atts);
extract($atts);

$blank = $new_tab == 'yes' ? ' target="_blank"' : '';

$box_title = '';
$box_content = '';
$box_link = '';
$box_img = '';
$box_icon = '';

if (!empty($thumbnail)) {
    $box_img = $thumbnail;
}

if (!empty($heading)) {
    $box_title = esc_html($heading);
}

if (!empty($text)) {
    $box_content = esc_html($text);
}

if (!empty($url)) {
    $box_link = esc_html($url);
}



echo hoverBox($box_title, $box_content, $box_icon, $box_link, $box_img);
