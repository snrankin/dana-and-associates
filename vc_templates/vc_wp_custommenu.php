<?php

if (!defined('ABSPATH')) {
    die('-1');
}

$title = $nav_menu = $el_class = $el_id = $menu_container_class = $menu_class = '';
$atts  = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$parent_class = 'content-item';
$elem         = $this->settings['base'];

$wrapper_classes = array(
    $el_class,
    $parent_class,
    $elem,
);

$wrapper_attributes = array();
// build attributes for wrapper
if (!empty($el_id)) {
    $wrapper_attributes['id'] = esc_attr($el_id);
    $end_comment              = '<!-- end #' . esc_attr($el_id) . '.' . $parent_class . '-->';
} else {
    $end_comment = '<!-- end .' . $parent_class . '-->';
}

$wrapper_class               = maatVCClasses($wrapper_classes, $elem, $atts);
$wrapper_attributes['class'] = maat_item_classes($wrapper_class);

$title = (!empty($title)) ? '<h4 class="widget-title">' . $title . '</h4>' : '';

$menu_classes = array(
    'custom-menu',
    'menu',
);

$custom_classes = explode(' ', $menu_class);

foreach ($custom_classes as $class) {
    $menu_classes[] = $class;
}

$args = array(
    'menu'            => $nav_menu,
    'container'       => 'nav',
    'container_class' => $menu_container_class,
    'menu_class'      => implode(' ', $menu_classes),
    'echo'            => false,
);

$output = '';

$output .= "\n" . '<div' . maat_add_item_data($wrapper_attributes) . '>';
$output .= "\n\t" . $title;
$output .= "\n\t" . wp_nav_menu($args);
$output .= "\n" . '</div>' . $end_comment;

echo $output;
