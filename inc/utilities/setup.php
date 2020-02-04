<?php
function maat_setup()
{
    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    /**
     * Add theme support for selective refresh for widgets.
     */
    add_theme_support('customize-selective-refresh-widgets');
    /**
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    /**
     * Add small thumbnail size for admin usage
     *
     * @link https://developer.wordpress.org/reference/functions/add_image_size/
     */
    add_image_size('admin-thumb', 160, 160, true);
    update_option('thumbnail_size_w', 320);
    update_option('thumbnail_crop', 0);
    add_image_size('medium_sm', 576, 576);
    update_option('medium_size_w', 768);
    add_image_size('medium_lg', 1024, 1024);
    update_option('large_size_w', 1280);
    add_image_size('large_lg', 1440, 1440);
    function my_custom_sizes($sizes)
    {
        return array_merge($sizes, array(
            'admin-thumb' => __('Admin Thumbnail'),
            'medium_sm'   => __('Large Phone (576px)'),
            'medium_lg'   => __('Tablet Landscape (1024px)'),
            'large_lg'    => __('Large Desktop (1440px)'),
        ));
    }
}
add_action('after_setup_theme', 'maat_setup');

function acf_json_save_point($path)
{

    // update path
    $path = ASSETS_PATH . '/json';

    // return
    return $path;
}
add_filter('acf/settings/save_json', 'acf_json_save_point');

function acf_json_load_point($paths)
{

    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = ASSETS_PATH . '/json';

    // return
    return $paths;
}

add_filter('acf/settings/load_json', 'acf_json_load_point');

function prefix_modify_nav_menu_args($args)
{
    if (!isset($args['walker']) || empty($args['walker'])) {
        $args['walker'] = new WP_Bootstrap_Navwalker();
    }
    $args['menu_class'] .= ' nav';
    return $args;
}
add_filter('wp_nav_menu_args', 'prefix_modify_nav_menu_args');
function remove_plugin_image_sizes()
{
    remove_image_size('gt3-admin-post-featured-image');
    remove_image_size('medium_large');
}
add_action('init', 'remove_plugin_image_sizes', 9999);

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function maat_body_classes($classes)
{
    $classes[] = get_the_slug(get_the_ID());
    $classes[] = maat_item_type() . '-page';
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'maat_body_classes');

/**
 * Load desired components into theme
 */
$components = glob(COMPONENT_PATH . '/*', GLOB_ONLYDIR);

$blog = get_stylesheet_directory() . '/inc/components/blog';

if (in_array($blog, $components)) {
    $i = array_search($blog, $components);
    unset($components[$i]);
    $components[] = $blog;
}

$components = array(
    'schema',
    'carousel',
    'cta',
    'error-404',
    'faqs',
    'footer',
    'header',
    'hover-box',
    'location',
    'modal',
    'page-header',
    'page-loader',
    'pagination',
    'practice-areas',
    'search',
    'social',
    'team',
    'video',
    'blog',
    'reviews',
);

foreach ($components as $component) {
    $path = COMPONENT_PATH . '/' . $component . '/setup.php';
    if (file_exists($path)) {
        require_once $path;
    }
}

function change_logo_class($html)
{
    $html = str_replace('custom-logo-link', 'd-block theme-logo', $html);
    $html = str_replace('custom-logo', 'img-fluid style-svg', $html);

    return $html;
}
add_filter('get_custom_logo', 'change_logo_class');
// Comment functions
function enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

// Ping functions
function maat_theme_custom_pings($comment)
{
    $GLOBALS['comment'] = $comment;
    echo '<li ' . comment_class() . ' id="li-comment-' . comment_ID() . '">' . comment_author_link() . '</li>';
}

/**
 * Filters the wp_calculate_image_sizes function so that is returns an array
 * instead of a string to make it compatible with lazysizes.js
 *
 * @param mixed $sizes
 * @param array $size Returns integers for width and height
 * @param string $image_src Url of the specific image size
 * @param array $image_meta Meta array from the full size image, @uses `wp_get_attachment_metadata()`;
 * @param integer $attachment_id
 *
 * @return array $sizes [0] => $width [1] => $url
 */

function filter_wp_calculate_image_sizes($sizes, $size, $image_src, $image_meta, $attachment_id)
{
    $sizes   = array();
    $sizes[] = $size[0] . 'w';
    $sizes[] = $image_src;
    return $sizes;
};

// add the filter
add_filter('wp_calculate_image_sizes', 'filter_wp_calculate_image_sizes', 10, 5);

function add_lazyloading_to_images($attr, $attachment, $size)
{
    $id = $attachment->ID;
    $attr['class'] .= ' img-fluid';
    $ratio = maat_get_bg_lazy_sizes($id);
    if ($attachment->post_mime_type !== 'image/svg+xml') {
        $attr['class'] .= ' lazyload';
        $attr['data-aspectratio'] = $ratio['data-aspectratio'];
        if (isset($attr['src'])) {
            $attr['data-src'] = $attr['src'];
            $attr['src']      = '';
            unset($attr['src']);
        }
        if (isset($attr['srcset'])) {
            $attr['data-srcset'] = $attr['srcset'];
            $attr['srcset']      = '';
            unset($attr['srcset']);
        }
        if (isset($attr['sizes'])) {
            $attr['data-sizes'] = 'auto';
            $attr['sizes']      = '';
            unset($attr['sizes']);
        } else {
            $attr['data-sizes'] = 'auto';
        }
    } else {
        $attr['class'] .= ' style-svg';
    }
    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'add_lazyloading_to_images', 15, 3);

/**
 *
 * Modified from: Sunyatasattva
 * @link https://wordpress.stackexchange.com/questions/81522/change-html-structure-of-all-img-tags-in-wordpress
 * @param $the_content
 *
 * @return string
 */

function gs_add_img_lazy_markup($the_content)
{

    libxml_use_internal_errors(true);

    $post = new DOMDocument();

    $post->loadHTML($the_content);

    $imgs = $post->getElementsByTagName('img');

    // Iterate each img tag
    foreach ($imgs as $img) {

        if ($img->hasAttribute('data-src')) {
            continue;
        }

        if ($img->parentNode->tagName == 'noscript') {
            continue;
        }

        $clone = $img->cloneNode();

        $src      = $img->getAttribute('src');
        $svg      = preg_match('/\.(svg)$/', $src);
        $imgClass = $img->getAttribute('class');
        if ($svg != 0) {
            $img->setAttribute('class', $imgClass . ' lazyload');
        }
        $img->removeAttribute('src');
        $img->setAttribute('data-src', $src);

        $srcset = $img->getAttribute('srcset');
        $img->removeAttribute('srcset');
        if (!empty($srcset)) {
            $img->setAttribute('data-srcset', $srcset);
        }

        $img->setAttribute('data-sizes', 'auto');

        $no_script = $post->createElement('noscript');
        $no_script->appendChild($clone);
        $img->parentNode->insertBefore($no_script, $img);
    };

    return $post->saveHTML();
}
//add_filter('the_content', 'gs_add_img_lazy_markup', 20);

function image_tag_class($class, $id, $align, $size)
{
    $img_meta = get_post_mime_type($id);
    if ($img_meta !== 'image/svg+xml') {
        return $class . ' lazyload';
    }
}
//add_filter('get_image_tag_class', 'image_tag_class', 30, 4);

/** Add wrapper for post thumbnail **/
function filter_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr)
{

    if (is_admin() || empty($post_thumbnail_id)) {
        return;
    }

    $alt = the_title_attribute(
        array(
            'echo' => false,
            'post' => $post_id
        )
    );
    $title = the_title_attribute(
        array(
            'echo' => false,
            'post' => $post_id
        )
    );

    if (isset($attr['parent-fit'])) {
        $attr['data-parent-fit'] = $attr['parent-fit'];
        unset($attr['parent-fit']);
    }

    if (!isset($attr['title']) || !array_key_exists('title', $attr)) {
        $attr['title'] = $title;
    }
    if (!isset($attr['alt']) || !array_key_exists('alt', $attr)) {
        $attr['alt'] = $alt;
    }

    $html = maat_img_structure($post_thumbnail_id, $size, $attr);
    return $html;
};

add_filter('post_thumbnail_html', 'filter_post_thumbnail_html', 10, 5);

function schemaPageType()
{
    $item       = maat_item_type();
    $slug       = get_the_slug(get_the_id());
    $schemaType = 'itemscope itemtype="https://schema.org/';
    if ($item === 'blog') {
        $schemaType .= 'Blog';
    } elseif ($item === 'faqs') {
        if (is_singular()) {
            $schemaType .= 'ItemPage';
        } else {
            $schemaType .= 'FAQPage';
        }
    } elseif ($item === 'team') {
        if (is_singular()) {
            $schemaType .= 'ProfilePage';
        } else {
            $schemaType .= 'CollectionPage';
        }
    } elseif ($item === 'page') {
        if (strpos($slug, 'about') !== false) {
            $schemaType .= 'AboutPage';
        } elseif (strpos($slug, 'contact') !== false) {
            $schemaType .= 'ContactPage';
        } else {
            $schemaType .= 'WebPage';
        }
    } elseif (is_post_type_archive()) {
        $schemaType .= 'CollectionPage';
    } elseif (is_singular()) {
        $schemaType .= 'ItemPage';
    } elseif (is_search()) {
        $schemaType .= 'SearchResultsPage';
    } else {
        $schemaType .= 'WebPage';
    }
    return $schemaType . '"';
}
