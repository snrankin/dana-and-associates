<?php
define('INCLUDES_PATH', get_stylesheet_directory() . '/inc');
define('INCLUDES_PATH_URI', get_stylesheet_directory_uri() . '/inc');
define('CONFIG_PATH', get_stylesheet_directory() . '/config');
define('CONFIG_PATH_URI', get_stylesheet_directory_uri() . '/config');
define('ASSETS_PATH', get_stylesheet_directory() . '/assets');
define('ASSETS_PATH_URI', get_stylesheet_directory_uri() . '/assets');
define('THEME_CONFIG_PATH', CONFIG_PATH . '/theme-config.json');
define('THEME_CONFIG_PATH_URI', CONFIG_PATH_URI . '/theme-config.json');
define('COMPONENT_PATH', INCLUDES_PATH . '/components');
define('COMPONENT_PATH_URI', INCLUDES_PATH_URI . '/components');
define('UTILITIES_PATH', INCLUDES_PATH . '/utilities');
define('UTILITIES_PATH_URI', INCLUDES_PATH_URI . '/utilities');
define('ADMIN_PATH', INCLUDES_PATH . '/admin');
define('ADMIN_PATH_URI', INCLUDES_PATH_URI . '/admin');
define('PAGES_PATH', INCLUDES_PATH . '/pages');
define('PAGES_PATH_URI', INCLUDES_PATH_URI . '/pages');
define('PLUGINS_PATH', INCLUDES_PATH . '/plugins');
define('PLUGINS_PATH_URI', INCLUDES_PATH_URI . '/plugins');
define('FA_VER', '5.9.0');
define('THEME_SLUG', 'dana');
define('YOUTUBE_KEY', 'AIzaSyAoig2BNilZxH7h-pLj5HhZbTAVuKfWqL4');
define('GRID_SM', '375');
define('GRID_MS', '576');
define('GRID_MD', '768');
define('GRID_ML', '1024');
define('GRID_LG', '1280');
define('GRID_XL', '1440');
define('DESKTOP_BP', GRID_ML);
/**
 * Implement the Theme Utility functions.
 */

require_once UTILITIES_PATH . '/utilities.php';
//require_once UTILITIES_PATH . '/class-wp-bootstrap-navwalker.php';
require_once UTILITIES_PATH . '/bootstrap-menu-walkers.php';
require_once UTILITIES_PATH . '/setup.php';
require_once UTILITIES_PATH . '/assets.php';
require_once UTILITIES_PATH . '/settings.php';
require_once UTILITIES_PATH . '/shortcodes.php';
require_once ADMIN_PATH . '/setup.php';
require_once PLUGINS_PATH . '/wpb/setup.php';
require_once PAGES_PATH . '/setup.php';
