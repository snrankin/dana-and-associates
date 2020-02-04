<?php

function print_r2($val)
{
    echo '<pre>';
    print_r($val);
    echo '</pre>';
}

function format_phone($number)
{
    // Allow only Digits, remove all other characters.
    $number = preg_replace("/[^\d]/", "", $number);

    // get number length.
    $length = strlen($number);

    if (ctype_digit($number) && $length == 10) {
        $number = substr($number, 0, 3) . '-' . substr($number, 3, 3) . '-' . substr($number, 6);
    } else {
        if (ctype_digit($number) && $length == 7) {
            $number = substr($number, 0, 3) . '-' . substr($number, 3, 4);
        }
    }
    return $number;
}

/**
 * Calculate the ratio between two numbers.
 *
 * @param int $num1 The first number.
 * @param int $num2 The second number.
 * @return string A string containing the ratio.
 */
function getRatio($num1, $num2, $divider = ':')
{
    for ($i = $num2; $i > 1; $i--) {
        if (($num1 % $i) == 0 && ($num2 % $i) == 0) {
            $num1 = $num1 / $i;
            $num2 = $num2 / $i;
        }
    }
    return $num1 . $divider . $num2;
}

/**
 * Load component partial file
 *
 * Loads a file from a specific compontent. The component must be
 * located in the components folder and the file must be located in the
 * partials sub folder. To be used for locating templates for a specific
 * component
 *
 * @param string $component Name of folder where the partial is located.
 * (subfolder of components)
 * @param string $partial Name of file to load.
 * @uses get_template_part()
 */
function get_component_partial($component, $partial)
{
    $file = COMPONENT_PATH . '/' . $component . '/partials/' . $partial . '.php';
    $path = 'inc/components/' . $component . '/partials/' . $partial;
    if (file_exists($file)) {
        get_template_part($path);
    }
}

/**
 * Load component partial file
 *
 * Loads a file from a specific compontent. The component must be
 * located in the components folder and the file must be located in the
 * partials sub folder. To be used for locating templates for a specific
 * component
 *
 * @param string $component Name of folder where the partial is located.
 * (subfolder of components)
 * @param string $partial Name of file to load.
 * @uses get_template_part()
 */
function get_component_template($component)
{
    $file = COMPONENT_PATH . '/' . $component . '/template.php';
    $path = 'inc/components/' . $component . '/template';
    if (file_exists($file)) {
        get_template_part($path);
    }
}

/**
 * Include component partial file
 *
 * Includes a file from a specific compontent. The component must be
 * located in the components folder and the file must be located in the
 * partials sub folder. To be used for adding functionality for a specific
 * component
 *
 * @param string $component Name of folder where the partial is located.
 * (subfolder of components)
 * @uses include_once()
 */
function include_component_partial($component, $partial)
{
    $path = COMPONENT_PATH . '/' . $component . '/partials/' . $partial . '.php';
    if (file_exists($path)) {
        include_once $path;
    }
}

/**
 * Formats the string to title case
 *
 * @param string $string
 *
 * @return string
 */
function to_title_case($string)
{
    $string = str_replace("_", " ", $string);
    $string = str_replace("-", " ", $string);
    /* Words that should be entirely lower-case */
    $articles_conjunctions_prepositions = array(
        'a', 'an', 'the',
        'and', 'but', 'or', 'nor',
        'if', 'then', 'else', 'when',
        'at', 'by', 'from', 'for', 'in',
        'off', 'on', 'out', 'over', 'to', 'into', 'with',
    );
    /* Words that should be entirely upper-case (need to be lower-case in this list!) */
    $acronyms_and_such = array(
        'asap', 'unhcr', 'wpse', 'wtf',
    );
    /* split title string into array of words */
    $words = explode(' ', mb_strtolower($string));
    /* iterate over words */
    foreach ($words as $position => $word) {
        /* re-capitalize acronyms */
        if (in_array($word, $acronyms_and_such)) {
            $words[$position] = mb_strtoupper($word);
            /* capitalize first letter of all other words, if... */
        } elseif (
            /* ...first word of the title string... */
            0 === $position ||
            /* ...or not in above lower-case list*/
            !in_array($word, $articles_conjunctions_prepositions)
        ) {
            $words[$position] = ucwords($word);
        }
    }
    /* re-combine word array */
    $string = implode(' ', $words);
    /* return title string in title case */
    return $string;
}
/**
 * Formats the string to Snake Case (snake_case)
 *
 * @param string $str
 *
 * @return string
 */
function to_snake_case($str)
{
    $str = sanitize_title_with_dashes($str);
    $str = str_replace("-", "_", $str);
    return $str;
}
/**
 * Formats the string to Kebab Case (kebab-case)
 *
 * @param string $str
 *
 * @return string
 */
function to_kebab_case($str)
{
    $str = sanitize_title_with_dashes($str);
    $str = str_replace("_", "-", $str);
    return $str;
}

/**
 * Returns a sanitized array of classes
 *
 * @param array $new_classes
 *
 * @return array
 */
function maat_classes($new_classes, $other_classes = '')
{
    $classes = array();
    if (is_array($new_classes)) {
        $classes = array_merge($classes, $new_classes);
    } else {
        $new_classes = explode(' ', $new_classes);
        $classes = array_merge($classes, $new_classes);
    }
    if (!empty($other_classes)) {
        if (is_array($other_classes)) {
            $classes = array_merge($classes, $other_classes);
        } else {
            $other_classes = explode(' ', $other_classes);
            $classes = array_merge($classes, $other_classes);
        }
    }
    if (!empty($classes)) {
        $classes = array_unique($classes);
        foreach ($classes as $key => $value) {
            if (empty($value)) {
                unset($classes[$key]);
            } else {
                $classes[$key] = sanitize_html_class($value);
            }
        }
    }
    return $classes;
}

/**
 * Add html markup for classes from array
 *
 * @param array $classes
 *
 * @return string
 */
function maat_item_classes($new_classes, $other_classes = '')
{

    if (!empty($other_classes)) {
        $classes = maat_classes($new_classes, $other_classes);
    } else {
        $classes = maat_classes($new_classes);
    }
    $all_classes = '';
    if (!empty($classes)) {
        $all_classes = implode(' ', $classes);
    }
    return $all_classes;
}

/**
 * Add html markup for classes from array
 *
 * @param array $classes
 *
 * @return string
 */
function maat_add_item_classes($classes = '', $other_classes = '')
{

    if (!empty($classes)) {
        return ' class="' . maat_item_classes($classes, $other_classes) . '"';
    } else {
        return false;
    }
}
/**
 * Add html markup for inline styles from array
 *
 * @param array $styles
 *
 * @return string
 */

function maat_add_item_styles($styles = array())
{
    $styles_list = ' style="';

    $all_styles = '';
    if (!empty($styles)) {
        foreach ($styles as $property => $value) {
            if ($property === 'background-image') {
                $all_styles .= $property . ': url(' . $value . '); ';
            } else {
                $all_styles .= $property . ': ' . $value . '; ';
            }
        }
        $styles_list .= trim($all_styles) . '"';
        return $styles_list;
    } else {
        return '';
    }
}

function add_item_data($data = array())
{

    $all_data = '';
    foreach ($data as $property => $value) {
        if (!empty($value)) {
            $value = ('href' === $property) ? esc_url($value) : esc_attr($value);
            $all_data .= ' ' . esc_attr($property) . '="' . $value . '"';
        }
    }
    return $all_data;
}

function maat_add_item_data($data = array())
{
    $empty_atts = array(
        'data-fancybox',
        'itemscope',
    );

    $all_data = '';
    foreach ($data as $property => $value) {
        if (empty($value) && in_array($property, $empty_atts)) {
            $all_data .= ' ' . esc_attr($property);
        } elseif (!empty($value)) {
            if ('href' === $property) {
                $protocols = '';
                $url       = $value;
                if (preg_match('/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/', $value)) {
                    $value = format_phone($value);
                    $protocols = 'tel';
                    $url       = 'tel:' . $value;
                } elseif (is_email($value)) {
                    $protocols = 'mailto';
                    $value = sanitize_email($value);
                    $url       = 'mailto:' . antispambot($value);
                }
                $value = esc_url($url, $protocols);
            } else {
                $value = esc_attr__($value);
            }
            $all_data .= ' ' . esc_attr($property) . '="' . $value . '"';
        }
    }
    return $all_data;
}

function acf_divider($item_name)
{
    $fields = array(
        'key'     => 'field_' . $item_name . '_divider',
        'label'   => 'Divider',
        'type'    => 'message',
        'wrapper' => array(
            'class' => 'acf-divider w-100',
        ),
    );

    return $fields;
}

function content_class()
{
    if (is_single()) {
        $content_class = 'post-page';
    } elseif (is_page()) {
        $content_class = 'content-page';
    } elseif (is_singular()) {
        $content_class = get_post_type() . '-page';
    } elseif (is_archive() || is_author() || is_category() || is_home() || is_tag()) {
        $content_class = 'archive-page';
    } elseif (is_404()) {
        $content_class = 'error-page';
    } elseif (is_search()) {
        $content_class = 'search-page';
    }
    return $content_class;
}

// Get page ID with page slugs
function get_id_by_slug($page_slug)
{
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

/**
 * Turn hex values into rgb values
 *
 * @param string $hex
 * @param string $opacity
 *
 * @return string rgba(r,g,b,a)
 */
function hex2rgba($hex, $opacity)
{
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }

    $a = intval($opacity) * 0.01;

    $rgba = array($r, $g, $b, $a);

    $Final_Rgb_color = implode(", ", $rgba);

    return $Final_Rgb_color;
}
/**
 * Function to see if the current page is a posts page
 *
 * @return bool
 */
function is_blog()
{
    global $post;
    $posttype = get_post_type($post);
    return (((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ($posttype == 'post')) ? true : false;
}

// Time Elapsed Function
function time_elapsed_string($datetime, $full = false)
{
    $now  = new DateTime;
    $ago  = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function get_the_slug($post_id = '')
{
    $slug   = '';
    $object = '';
    if (!empty($post_id)) {
        $post = get_post($post_id);
        if (!empty($post)) {
            $object = $post;
            $slug   = $object->post_name;
        } else {
            global $wp_query;
            $object = $wp_query->get_queried_object();
            $slug   = $object->name;
        }
    }

    return $slug;
}

function the_slug($post_id = '')
{
    $slug = '';
    if (empty($post_id)) {
        $slug = get_post_type();
    } else {
        global $wp_query;
        $item = $wp_query->get_queried_object();
        $slug = $item->name;
    }
    echo $slug;
}

function get_post_id_by_slug($slug, $type)
{
    $item = get_page_by_path($slug, object, $type);
    if ($item) {
        return $item->ID;
    } else {
        return null;
    }
}

function bootstrap_translateColumnWidthToSpan($width)
{
    $output = $width;
    preg_match('/(\d+)\/(\d+)/', $width, $matches);

    if (!empty($matches)) {
        $part_x = (int) $matches[1];
        $part_y = (int) $matches[2];
        if ($part_x > 0 && $part_y > 0) {
            $value = ceil($part_x / $part_y * 12);
            if ($value > 0 && $value <= 12) {
                $output = 'col-ml-' . $value;
            }
        }
    }
    if (preg_match('/\d+\/5$/', $width)) {
        $output = 'col-ml-20';
    }

    return apply_filters('vc_translate_column_width_class', $output, $width);
}

function bs_column_offset_class_merge($column_offset, $width)
{
    // Remove offset settings if
    if ('1' === vc_settings()->get('not_responsive_css')) {
        $column_offset = preg_replace('/col\-(lg|md|xs)[^\s]*/', '', $column_offset);
    }
    if (preg_match('/col\-sm\-\d+/', $column_offset)) {
        return $column_offset;
    }

    return $width . (empty($column_offset) ? '' : ' ' . $column_offset);
}

function item_title($item)
{
    $item = to_kebab_case($item);
    return $item;
}
function maat_item_title($id = '')
{
    if (is_admin()) {
        return;
    }
    $item_id     = (!empty($id)) ? $id : get_the_ID();
    $item_object = $item_single = $item_plural = '';
    if (!empty($item_id)) {
        $item_object = get_post_type_object(get_post_type($item_id));
    } else {
        global $wp_query;
        $item_object = $wp_query->get_queried_object();
    }
    $item_single = $item_object->labels->singular_name;
    $item_plural = $item_object->labels->name;

    if (is_blog() || get_post_type($item_id) === 'post') {
        $item_title = 'Blog';
    } elseif (is_singular() && get_post_type($item_id) !== 'post') {
        if ($item_single === 'Practice Location') {
            $item_single = 'Location';
        } elseif ($item_single === 'Team Member') {
            $item_single = 'team';
        }
        $item_title = $item_single;
    } elseif (is_post_type_archive() || is_tax()) {
        if ($item_plural === 'Practice Locations') {
            $item_plural = 'Locations';
        } elseif ($item_plural === 'Team Members') {
            $item_plural = 'team';
        }
        $item_title = $item_plural;
    } elseif (is_404()) {
        $item_title = 'Error 404';
    } elseif (is_search()) {
        $item_title = 'Search';
    } else {
        $item_title = 'Error no title';
    }

    return $item_title;
}
function maat_item_type($id = '')
{
    if (is_admin()) {
        return;
    }

    $item_type = maat_item_title($id);
    $item_type = to_kebab_case($item_type);
    return $item_type;
}

/**
 * Archive Navigation
 *
 * @author Bill Erickson
 * @see https://www.billerickson.net/custom-pagination-links/
 *
 */
function ea_archive_navigation()
{

    $settings = array(
        'count'     => 7,
        'prev_text' => '<span aria-hidden="true">&lsaquo;</span> <span class="sr-only">Previous Page</span>',
        'next_text' => '<span aria-hidden="true">&rsaquo;</span> <span class="sr-only">Next Page</span>',
    );

    global $wp_query;
    $current = max(1, get_query_var('paged'));
    $total   = $wp_query->max_num_pages;
    $links   = array();

    // Offset for next link
    if ($current < $total) {
        $settings['count']--;
    }

    // Previous
    if ($current > 1) {
        $settings['count']--;
        $links[] = ea_archive_navigation_link($current - 1, 'prev', $settings['prev_text']);
    }

    // Current
    $links[] = ea_archive_navigation_link($current, 'current');

    // Next Pages
    for ($i = 1; $i < $settings['count']; $i++) {
        $page = $current + $i;
        if ($page <= $total) {
            $links[] = ea_archive_navigation_link($page);
        }
    }

    // Next
    if ($current < $total) {
        $links[] = ea_archive_navigation_link($current + 1, 'next', $settings['next_text']);
    }

    $output = '';

    $output .= '<nav class="navigation posts-navigation" role="navigation">';
    $output .= '<ul class="pagination">' . join('', $links) . '</ul>';
    $output .= '</nav>';

    return $output;
}

/**
 * Archive Navigation Link
 *
 * @author Bill Erickson
 * @see https://www.billerickson.net/custom-pagination-links/
 *
 * @param int $page
 * @param string $class
 * @param string $label
 * @return string $link
 */
function ea_archive_navigation_link($page = false, $class = '', $label = '')
{

    if (!$page) {
        return;
    }

    $classes = array('page-link');
    if (!empty($class)) {
        $classes[] = $class;
    }

    $classes = array_map('sanitize_html_class', $classes);

    $label = $label ? $label : $page;
    $link  = esc_url_raw(get_pagenum_link($page));

    return '<li class="page-item"><a class="' . join(' ', $classes) . '" href="' . $link . '">' . $label . '</a></li>';
}

/**
 * Function to create all the image sizes for lazy loading background images
 * @param $id Image ID
 *
 * @return array HTML data attributes
 */
function maat_get_lazy_sizes($id = '', $size = '')
{
    if (is_admin() || empty($id)) {
        return;
    }
    if (empty($size)) {
        $size = 'full';
    }

    $available_sizes = array('thumbnail', 'medium_sm', 'medium', 'medium_lg', 'large', 'large_lg', 'full');
    $sizes           = array();
    $lrg_size        = '';
    if (in_array($size, $available_sizes)) {
        $index     = array_search($size, $available_sizes);
        $new_sizes = array_chunk($available_sizes, $index + 1, true);
        $new_sizes = $new_sizes[0];
        foreach ($new_sizes as $new_size) {
            $img_size = wp_get_attachment_image_src($id, $new_size);
            $sizes[]  = $img_size;
        }
    } else {
        $img_size = wp_get_attachment_image_src($id, $size);
        $lrg_size  = $img_size;
    }
    $new_srcset = '';
    if (!empty($sizes)) {
        foreach ($sizes as $size) {
            $new_srcset .= $size[0] . ' ' . $size[1] . 'w, ';
        }
        $lrg_size = end($sizes);
    }

    $srcset = rtrim($new_srcset, ', ');

    $lazy_sizes = array(
        'data-sizes' => 'auto',
        'data-src'   => $lrg_size[0],
    );
    if (!empty($new_srcset)) {
        $lazy_sizes['data-srcset'] = $srcset;
    }
    $img_width  = intval($lrg_size[1]);
    $img_height = intval($lrg_size[2]);
    if (!empty($img_width) && !empty($img_height)) {
        $lazy_sizes['data-ratio']       = getRatio($img_width, $img_height, 'by');
        $lazy_sizes['data-aspectratio'] = getRatio($img_width, $img_height, '/');
        $lazy_sizes['aspectratio']      = (($img_height / $img_width) * 100);
    }

    return $lazy_sizes;
}

function maat_get_bg_lazy_sizes($id = '', $size = '')
{
    if (is_admin() || empty($id)) {
        return;
    }
    $lazy_sizes = maat_get_lazy_sizes($id, $size);

    if (!empty($lazy_sizes)) {
        if (isset($lazy_sizes['data-src'])) {
            $lazy_sizes['data-bg'] = 'url(' . $lazy_sizes['data-src'] . ')';
            unset($lazy_sizes['data-src']);
        }
        if (isset($lazy_sizes['data-srcset'])) {
            $lazy_sizes['data-bgset'] = $lazy_sizes['data-srcset'];
            unset($lazy_sizes['data-srcset']);
        }
    }

    return $lazy_sizes;
}

function maat_lazy_sizes($id = '', $size = '')
{
    if (is_admin() || empty($id)) {
        return;
    }
    $img_meta = maat_get_lazy_sizes($id, $size);

    $lazy_sizes = maat_add_item_data($img_meta);
    return $lazy_sizes;
}

function maat_bg_lazy_sizes($id = '', $size = '')
{
    if (is_admin() || empty($id)) {
        return;
    }
    $img_meta = maat_get_bg_lazy_sizes($id, $size);

    $lazy_sizes = maat_add_item_data($img_meta);
    return $lazy_sizes;
}

function maat_register_post_type($slug, $single, $plural, $options = array())
{
    $labels = array(
        'name'                  => _x($plural, 'Post Type General Name', 'maat'),
        'singular_name'         => _x($single, 'Post Type Singular Name', 'maat'),
        'menu_name'             => __($plural, 'maat'),
        'name_admin_bar'        => __($plural, 'maat'),
        'archives'              => __($single . ' Archives', 'maat'),
        'attributes'            => __($single . ' Attributes', 'maat'),
        'parent_item_colon'     => __('Parent ' . $single . ':', 'maat'),
        'all_items'             => __('All ' . $plural, 'maat'),
        'add_new_item'          => __('Add New ' . $single, 'maat'),
        'new_item'              => __('New ' . $single, 'maat'),
        'edit_item'             => __('Edit ' . $single, 'maat'),
        'update_item'           => __('Update ' . $single, 'maat'),
        'view_item'             => __('View ' . $single, 'maat'),
        'view_items'            => __('View ' . $plural, 'maat'),
        'search_items'          => __('Search ' . $plural, 'maat'),
        'insert_into_item'      => __('Insert into ' . $single, 'maat'),
        'uploaded_to_this_item' => __('Uploaded to this' . $single, 'maat'),
        'items_list'            => __($plural . ' list', 'maat'),
        'items_list_navigation' => __($plural . ' list navigation', 'maat'),
        'filter_items_list'     => __('Filter' . $plural . 'list', 'maat'),
    );
    $defaults = array(
        'label'  => __($single, 'maat'),
        'labels' => $labels,
    );
    $args = wp_parse_args($options, $defaults);
    register_post_type('maat_' . $slug, $args);
}

function maat_add_stylesheet($handle, $stylesheet_path, $abs, $rel, $min = 1)
{
    $homeURL = get_home_url();
    $path    = $stylesheet_path;

    if ($min == 1 && strpos($homeURL, '.local') === false) {
        $path .= '.min.css';
    } else {
        $path .= '.css';
    }

    $file_rel = $rel . $path;
    $file_abs = $abs . $path;

    $mod_time = filemtime($file_abs);

    if (!is_admin()) {

        if (file_exists($file_abs)) {
            wp_register_style($handle, $file_rel, false, $mod_time, 'all');
            wp_enqueue_style($handle);
        }
    }
}

function maat_num_col($cols, $total = '')
{
    if (empty($total)) {
        $total = 12;
    } else {
        $total = intval($total);
    }
    $bs_cols = array(
        '1'  => 0.0833,
        '2'  => 0.1667,
        '20' => 0.2000,
        '3'  => 0.2500,
        '4'  => 0.3333,
        '40' => 0.4000,
        '5'  => 0.4167,
        '6'  => 0.5000,
        '7'  => 0.5833,
        '60' => 0.6000,
        '8'  => 0.6667,
        '9'  => 0.7500,
        '10' => 0.8333,
        '11' => 0.9167,
        '12' => 1.0000,
    );

    $cols  = intval($cols);
    $width = intdiv($cols, $total);
    $width = number_format($width, 4);

    $col_class = array_search($width, $bs_cols);
}

function maat_col_num($class = '')
{
    $class = preg_replace('/\D+/', '', $class);

    $bs_cols = array(
        '1'  => 12,
        '2'  => 6,
        '20' => 5,
        '3'  => 4,
        '4'  => 3,
        '40' => 3,
        '5'  => 2,
        '6'  => 2,
        '7'  => 2,
        '60' => 2,
        '8'  => 1,
        '9'  => 1,
        '10' => 1,
        '11' => 1,
        '12' => 1,
    );

    if (array_key_exists($class, $bs_cols)) {
        $cols = $bs_cols[$class];
        return $cols;
    } else {
        return NULL;
    }
}

function maat_custom_logo($class = '', $link = 1)
{
    $full_logo = '';

    if (has_custom_logo()) {
        $custom_logo_id = get_theme_mod('custom_logo');
        $image          = get_attached_file($custom_logo_id);
        $image_type     = wp_check_filetype($image);

        $link_atts = array(
            'href'  => get_bloginfo('url'),
            'title' => get_bloginfo('name'),
            'class' => $class,
            'role'  => 'image',
        );
        $link_atts['class'] .= ' custom-logo';
        if ($image_type['ext'] === 'svg') {
            $logo = file_get_contents($image);
        } else {
            $logo = wp_get_attachment_image($custom_logo_id, 'medium', false, array('alt' => get_bloginfo('name'), 'class' => 'img-fluid custom-logo'));
        }

        $full_logo = ($link == 1) ? '<a' . maat_add_item_data($link_atts) . '>' : '<div class="custom-logo ' . $class . '"  role="img">';
        $full_logo .= $logo;
        $full_logo .= ($link == 1) ? '</a>' : '</div>';
    }
    return $full_logo;
}

function togglerButton($target, $class = '', $label = 'Toggle navigation', $show_label = 0, $icon = '')
{

    $classes = array(
        'navbar-toggler',
        $class,
    );

    $atts = array(
        'aria-controls' => $target,
        'data-target'   => '#' . $target,
        'aria-expanded' => 'false',
        'aria-label'    => $label,
        'data-toggle'   => 'collapse',
    );

    $atts['class'] = maat_item_classes($classes);

    $output = '<button' . maat_add_item_data($atts) . '>';
    $output .= (!empty($icon)) ? $icon : '<span class="navbar-toggler-icon"><span class="menu-bar bar-1"></span><span class="menu-bar bar-2"></span><span class="menu-bar bar-3"></span><span class="menu-bar bar-4"></span></span>';
    $output .= ($show_label == 1) ? '<span class="navbar-toggler-text">' . $label . '</span>' : '<span class="navbar-toggler-text sr-only">' . $label . '</span>';
    $output .= '</button>';

    return $output;
}

function team_name($team_id)
{
    $prefix = get_field('prefix', $team_id);
    $prefix = (!empty($prefix)) ? '<span itemprop="honorificPrefix">' . $prefix . '</span> ' : '';
    $suffix = get_field('suffix', $team_id);
    $suffix = (!empty($suffix)) ? ', <span itemprop="honorificSuffix">' . $suffix . '</span>' : '';
    $name   = get_the_title($team_id);
    $name   = sprintf('<span class="team-name" itemprop="name">%s%s%s</span>', $prefix, $name, $suffix);
    return $name;
}

function team_job($team_id)
{
    $job_title = get_field('job_title', $team_id);
    $title     = (!empty($job_title)) ? sprintf('<span class="team-job" itemprop="jobTitle">%s</span>', $job_title) : '';
    return $title;
}

function maat_img_structure($id, $size, $attr = array())
{
    if (is_admin() || empty($id)) {
        return;
    }
    $image_meta      = wp_get_attachment_metadata($id);
    $lazysizes_data  = maat_get_lazy_sizes($id, $size);
    $wrapper_classes = array(
        'image-wrapper',
    );
    if (isset($attr['wrapper_class'])) {
        $wrapper_classes = maat_item_classes($wrapper_classes, $attr['wrapper_class']);
        unset($attr['wrapper_class']);
    }

    $wrapper_atts = array(
        'itemprop'  => 'image',
        'itemscope' => '',
        'itemtype'  => 'http://schema.org/ImageObject',
        'class'     => maat_item_classes(
            $wrapper_classes
        ),
    );

    if (isset($attr['img_bg']) && $attr['img_bg'] == 1) {
        $bg = maat_get_bg_lazy_sizes($id, $size);
        $wrapper_atts = array_merge($wrapper_atts, $bg);
        unset($attr['img_bg']);
    }

    if (isset($attr['parent-fit'])) {
        $wrapper_atts['data-parent-fit'] = $attr['parent-fit'];
        unset($attr['parent-fit']);
    }

    $attr['itemprop'] = 'contentUrl';
    $attr['class'] = $attr['class'] . ' lazyload';
    $attr['class'] = $attr['class'] . ' img-fluid';

    $img_attr = wp_parse_args($attr, $lazysizes_data);

    $output = '<div' . maat_add_item_data($wrapper_atts) . '>';
    $output .= '<img ' . maat_add_item_data($img_attr) . '/>';
    $output .= '<meta itemprop="url" content="' . wp_get_attachment_image_url($id, 'full') . '">';
    $output .= '<meta itemprop="width" content="' . $image_meta['width'] . '">';
    $output .= '<meta itemprop="height" content="' . $image_meta['height'] . '">';
    $output .= '<meta itemprop="thumbnail" content="' . wp_get_attachment_image_url($id, 'thumbnail') . '">';
    $output .= '</div><!-- .post-thumbnail -->';
    return $output;
}
