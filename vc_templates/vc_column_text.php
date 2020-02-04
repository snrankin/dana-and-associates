<?php
/** ===========================================================================
 * Visual Composer Column Text Element
 * @package Maat Legal Theme
 * @version 0.9.0
 * -----
 * @author Sam Rankin (sam@maatlegal.com>)
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $el_id
 * @var $css_animation
 * @var $css
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column_text
 * -----
 * Created Date: 4-2-19
 * Last Modified: 6-29-19 at 2:46 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */

if (!defined('ABSPATH')) {
    die('-1');
}

$el_class = $el_id = $css = $css_animation = '';
$atts     = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$parent_class = 'content-item';
$elem         = 'column-text';

$wrapper_classes = array(
    $el_class,
    $parent_class,
    $elem,
);

$wrapper_attributes = array();
// build attributes for wrapper
if (!empty($el_id)) {
    $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
    $end_comment          = '<!-- end #' . esc_attr($el_id) . '.' . $parent_class . '-->';
} else {
    $end_comment = '<!-- end .' . $parent_class . '-->';
}

$wrapper_class        = maatGenerateVCClasses($wrapper_classes, $this->settings['base'], $atts);
$wrapper_attributes[] = $wrapper_class;

$output = '';

$output .= "\n" . '<div ' . implode(' ', $wrapper_attributes) . '>';
$output .= "\n\t" . wpb_js_remove_wpautop($content, true);
$output .= "\n" . '</div>' . $end_comment;

echo $output;
