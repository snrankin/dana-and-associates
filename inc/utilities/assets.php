<?php
function add_maat_critical_styles()
{
    if (!is_admin()) {
        $stylesURL      = '/css/' . THEME_SLUG . '-critical.min.css';
        $stylesheet_abs = ASSETS_PATH . $stylesURL;
        $stylesheet_rel = ASSETS_PATH_URI . $stylesURL;

        if (file_exists($stylesheet_abs)) {
            wp_register_style(THEME_SLUG . '-critical-styles', $stylesheet_rel, false, filemtime($stylesheet_abs), 'all');
            $style = file_get_contents($stylesheet_abs);
            wp_add_inline_style(THEME_SLUG . '-critical-styles', $style);
            echo '<style id=' . THEME_SLUG . '-critical-styles" type="text/css">' . $style . '</style>';
        }
    }
}
add_action('wp_head', 'add_maat_critical_styles', 1);

function add_maat_scripts()
{

    $homeURL        = get_home_url();
    $mainScriptsURL = '/js/' . THEME_SLUG . '-scripts';

    if (strpos($homeURL, '.local') === false) {
        $mainScriptsURL .= '.min.js';
    } else {
        $mainScriptsURL .= '.js';
    }

    $main_js          = ASSETS_PATH_URI . $mainScriptsURL;
    $main_js_mod_time = filemtime(ASSETS_PATH . $mainScriptsURL);
    wp_register_script(THEME_SLUG . '-scripts', $main_js, array('jquery'), $main_js_mod_time, true);
    wp_enqueue_script(THEME_SLUG . '-scripts');
}
add_action('wp_enqueue_scripts', 'add_maat_scripts', 100);

function maat_remove_extra_styles()
{
    $styles = array(
        'cf-front-css',
        'default-style',
        'gt3-theme',
        'font-awesome',
        'gt3-composer',
        'gt3-responsive',
        'theme-icon',
        'select2',
        'js_composer_front',
        'wp-block-library',
        'vc_lte_ie9',

    );

    foreach ($styles as $style) {
        wp_dequeue_style($style);
    }
    $scripts = array(
        'gt3-waypoint',
        'select2',
        'gt3-theme',
        'jquery-form',
        'cookie',
        'event-swipe',
        'easing',
        'wpb_composer_front_js',

    );

    foreach ($scripts as $script) {
        wp_dequeue_script($script);
    }
}
add_action('wp_enqueue_scripts', 'maat_remove_extra_styles', 9999);
add_action('wp_print_styles', 'maat_remove_extra_styles', 9999);

add_action("print_styles_array", function ($styles) {
    $my_handle = "gt3-responsive-inline-css"; // your custom handle here, the one declared as $style in question
    if (!empty($styles)) {
        foreach ($styles as $i => $style) {
            if ($my_handle === $style) {
                unset($styles[$i]);
            }
        }
    }
    return $styles;
});

function maat_add_favicon()
{
    $folder      = ASSETS_PATH . '/imgs';
    $url         = ASSETS_PATH_URI . '/imgs';
    $version     = 'xQdJjNyL52';
    $theme_color = '#3C92A6';
    if (file_exists($folder)) {
        $output = '';
        ob_start(); ?>
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $url; ?>/apple-touch-icon.png?v=<?php echo $version; ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $url; ?>/favicon-32x32.png?v=<?php echo $version; ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $url; ?>/favicon-16x16.png?v=<?php echo $version; ?>">
<link rel="manifest" href="<?php echo $url; ?>/site.webmanifest?v=<?php echo $version; ?>">
<link rel="mask-icon" href="<?php echo $url; ?>/safari-pinned-tab.svg?v=<?php echo $version; ?>" color="<?php echo $theme_color; ?>">
<link rel="shortcut icon" href="<?php echo $url; ?>/favicon.ico?v=<?php echo $version; ?>">
<meta name="msapplication-TileColor" content="<?php echo $theme_color; ?>">
<meta name="msapplication-TileImage" content="<?php echo $url; ?>/mstile-144x144.png?v=<?php echo $version; ?>">
<meta name="theme-color" content="<?php echo $theme_color; ?>">
<?php $output = ob_get_clean();
        echo $output;
    }
}
add_action('wp_head', 'maat_add_favicon');
add_action('login_head', 'maat_add_favicon');
add_action('admin_head', 'maat_add_favicon');

function prefix_add_footer_styles()
{
    maat_add_stylesheet(THEME_SLUG . '-icons', '/css/' . THEME_SLUG . '-icons.min', ASSETS_PATH, ASSETS_PATH_URI, $min = 0);

    maat_add_stylesheet(THEME_SLUG . '-main', '/css/' . THEME_SLUG . '-main', ASSETS_PATH, ASSETS_PATH_URI, $min = 1);
};
add_action('get_footer', 'prefix_add_footer_styles');
