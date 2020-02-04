<?php

/** ===========================================================================
 * Setup file for Visual Composer
 * @package Maat Legal Theme
 * @version 0.9.0
 * -----
 * @author Sam Rankin (sam@maatlegal.com>)
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date: 4-3-19
 * Last Modified: 7-22-19 at 6:54 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */

if (is_plugin_active('js_composer/js_composer.php')) {
    vc_disable_frontend();
}

$components = array(
    'functions',
    'section',
    'row',
    'row_inner',
    'column',
    'column_inner',
    'btn',
    'social_links_maat',
    'contact_info_maat',
    'twitter_feed_maat',
    'custom_shortcode_maat',
    'team_grid_maat',
    'youtube_gallery_maat',
    'text_reveal_box_maat',
    'wp_custommenu',
    'blog_grid_maat',
);
foreach ($components as $component) {
    $path = PLUGINS_PATH . '/wpb/inc/vc_' . $component . '.php';
    if (file_exists($path)) {
        include_once $path;
    }
}
