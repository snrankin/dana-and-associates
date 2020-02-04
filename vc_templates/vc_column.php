<?php
if (!defined('ABSPATH')) {
	die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_id
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $el_id = $inner_class = $offset = $width = $col_w_sm = $col_w_ms = $col_w_md = $col_w_ml = $col_w_lg = $content_v_align = $content_h_align = $bg_color = $bg_image = $bg_image_h_position = $bg_image_v_position = $parallax = $parallax_speed_bg = $parallax_speed_video = $video_bg = $video_bg_url = $video_bg_parallax = $output = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$width = maat_col_width_to_span($width);
$width = maat_col_offset_class_merge($offset, $width);

$parent_class = 'col';
$child_class = 'content-wrapper';
$elem = $this->settings['base'];

$wrapper_classes = array(
	$el_class,
	$col_w_sm,
	$col_w_ms,
	$col_w_md,
	$col_w_ml,
	$col_w_lg,
	$width,
);



$inner_classes = array(
	$child_class,
	$inner_class,
	$content_v_align,
	$content_h_align,
	$bg_color,
);

$wrapper_attributes = array(
	'id' => $el_id,
);

if (strpos($el_class, 'sidebar') !== false) {
	$wrapper_attributes['role'] = 'complementary';
	$wrapper_attributes['itemprop'] = 'WPSideBar';
}

// build attributes for wrapper
if (!empty($el_id)) {
	$end_comment = '<!-- end #' . esc_attr($el_id) . '.' . $parent_class . '-->';
} else {
	$end_comment = '<!-- end .' . $parent_class . '-->';
}

if (!empty($bg_image)) {
	$img_bg_data = maat_get_bg_lazy_sizes($bg_image);
	$wrapper_attributes = array_merge($wrapper_attributes, $img_bg_data);
	$wrapper_classes[] .= 'lazyload';
	$wrapper_classes[] .= 'bg-image';
	$wrapper_classes[] .= 'bg-image-x' . $bg_image_h_position . '-y' . $bg_image_v_position;
}
$has_video_bg = (!empty($video_bg) && !empty($video_bg_url) && vc_extract_youtube_id($video_bg_url));
$parallax_speed = $parallax_speed_bg;
if ($has_video_bg) {
	$parallax = $video_bg_parallax;
	$parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$wrapper_classes[] = 'vc_video-bg-container';
	wp_enqueue_script('vc_youtube_iframe_api_js');
}

if (!empty($parallax)) {
	wp_enqueue_script('vc_jquery_skrollr_js');
	$wrapper_attributes['data-vc-parallax'] = esc_attr($parallax_speed); // parallax speed
	$wrapper_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	$wrapper_attributes['data-vc-parallax-image'] = wp_get_attachment_image_url($bg_image, 'full');
	if (false !== strpos($parallax, 'fade')) {
		$wrapper_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes['data-vc-parallax-o-fade'] = 'on';
	} elseif (false !== strpos($parallax, 'fixed')) {
		$wrapper_classes[] = 'js-vc_parallax-o-fixed';
	}
}
if (!$parallax && $has_video_bg) {
	$wrapper_attributes['data-vc-video-bg'] = esc_attr($video_bg_url);
}

$wrapper_vc_classes = maatVCClasses($wrapper_classes, $elem, $atts);
$inner_classes = maatGenerateVCClasses($inner_classes, $elem, $atts);
$wrapper_attributes['class'] = maat_item_classes($wrapper_classes, $wrapper_vc_classes);


if (strpos($el_class, 'sidebar') !== false) {
	$output .= "\n" . '<aside' . maat_add_item_data($wrapper_attributes) . '>';
} else {
	$output .= "\n" . '<div' . maat_add_item_data($wrapper_attributes) . '>';
}
$output .= "\n\t" . '<div' . $inner_classes . '>';
$output .= "\n\t\t" . wpb_js_remove_wpautop($content);
$output .= "\n\t" . '</div><!-- end .' . $child_class . '-->';
if (strpos($el_class, 'sidebar') !== false) {
	$output .= "\n" . '</aside>' . $end_comment;
} else {
	$output .= "\n" . '</div>' . $end_comment;
}
echo $output;
