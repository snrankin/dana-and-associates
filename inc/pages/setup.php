<?php

/** ===========================================================================
 * This folder is for custom javascript/css/php for specific pages of a site.
 * Only enqueue these files on specific pages
 * @package Maat Legal Theme
 * @version 0.9.0
 * -----
 * @author Sam Rankin (sam@maatlegal.com>)
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  4-15-19
 * Last Modified: 8-7-19 at 5:11 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */

/**
 * Load desired components into theme
 */

function maat_load_page_assets()
{
    if (!is_admin()) {
        global $post;
        $post_slug = $post->post_name;
        $homeURL   = get_home_url();

        $scriptsURL = '/' . $post_slug . '/assets/js/' . THEME_SLUG . '-' . $post_slug;

        if (strpos($homeURL, '.local') === false) {
            $scriptsURL .= '.min.js';
        } else {
            $scriptsURL .= '.js';
        }

        $script_abs = PAGES_PATH . $scriptsURL;
        $script_rel = PAGES_PATH_URI . $scriptsURL;
        if (file_exists($script_abs)) {
            wp_enqueue_script(THEME_SLUG . '-' . $post_slug . '-scripts', $script_rel, false, filemtime($script_abs), 'all');
        }
    }
}
add_action('wp_enqueue_scripts', 'maat_load_page_assets', 150);

function maat_load_page_styles()
{
    if (!is_admin()) {
        global $post;
        $post_slug      = $post->post_name;
        $homeURL        = get_home_url();
        $stylesURL      = '/' . $post_slug . '/assets/css/' . THEME_SLUG . '-' . $post_slug . '.css';
        $stylesheet_abs = PAGES_PATH . $stylesURL;
        $stylesheet_rel = PAGES_PATH_URI . $stylesURL;
        if (file_exists($stylesheet_abs)) {
            wp_register_style(THEME_SLUG . '-' . $post_slug . '-styles', $stylesheet_rel, false, filemtime($stylesheet_abs), 'all');
            $style = file_get_contents($stylesheet_abs);
            wp_enqueue_style(THEME_SLUG . '-' . $post_slug . '-styles', $stylesheet_rel, false, filemtime($stylesheet_abs), 'all');
            //wp_add_inline_style(THEME_SLUG . '-' . $post_slug . '-styles', $style);
            //echo '<style id=' . THEME_SLUG . '-' . $post_slug . '-styles" type="text/css">' . $style . '</style>';
        }
    }
}
add_action('wp_head', 'maat_load_page_styles');

function maat_load_critical_page_styles()
{
    if (!is_admin()) {
        global $post;
        $post_ID      = $post->ID;
        $post_slug    = $post->post_name;
        $critical_css = get_field('critical_css', $post_ID);
        if (!empty($critical_css)) {
            echo '<style id=' . THEME_SLUG . '-' . $post_slug . '-critical-css" type="text/css">' . $critical_css . '</style>';
        }
    }
}
add_action('wp_head', 'maat_load_critical_page_styles', 1);
