<?php

/**
 * Component: Admin Functions
 * Description: Functions to change/edit admin styles
 *
 * @package maat
 */

// =============================================================================
// Add Styles and Scripts to Admin
// =============================================================================

function maat_admin_styles()
{
    $stylesheet_abs = ADMIN_PATH . '/assets/css/' . THEME_SLUG . '-admin.css';
    $stylesheet_rel = ADMIN_PATH_URI . '/assets/css/' . THEME_SLUG . '-admin.css';
    if (file_exists($stylesheet_abs)) {
        wp_register_style(THEME_SLUG . '-admin-styles', $stylesheet_rel, false, filemtime($stylesheet_abs), 'all');
        wp_enqueue_style(THEME_SLUG . '-admin-styles');
    }
    wp_enqueue_style('maat-font-awesome');
    wp_register_script('lazy-sizes', get_stylesheet_directory_uri() . '/build/js/vendor/10-lazy-sizes.js', false, '', true);
    wp_enqueue_script('lazy-sizes');
    $script_abs = ADMIN_PATH . '/assets/js/' . THEME_SLUG . '-admin.js';
    $script_rel = ADMIN_PATH_URI . '/assets/js/' . THEME_SLUG . '-admin.js';
    if (file_exists($script_abs)) {
        wp_register_script(THEME_SLUG . '-admin-scripts', $script_rel, false, filemtime($script_abs), true);
        wp_enqueue_script(THEME_SLUG . '-admin-scripts');
    }
}
add_action('admin_enqueue_scripts', 'maat_admin_styles', 999);

include_once ADMIN_PATH . '/partials/editor-styles.php';
include_once ADMIN_PATH . '/partials/theme-settings.php';
