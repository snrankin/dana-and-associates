<?php
/** ===========================================================================
 * @package maat
 * @subpackage /inc/components/admin/partials/theme-settings.php
 * @created 3-13-19
 * @author Sam Rankin sam@maatlegal.com>
 * @copyright 2019 Maat Legal
 * -----
 * Last Modified: 7-9-19 at 5:20 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * Description: Item description
 * @return mixed
 * -----
 * HISTORY:
 * Date          By    Comments
 * ----------    ---    ----------------------------------------------------------
 * ========================================================================= */

/**
 * Add a settings page to the backend for all of our theme options
 *
 * @link https://www.advancedcustomfields.com/resources/acf_add_options_page/
 * @uses acf_add_options_page()
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'General Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'maat-theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'autoload'   => true,
    ));
    acf_add_options_sub_page(array(
        'page_title'  => 'Call to Action',
        'menu_title'  => 'Call to Action',
        'parent_slug' => 'maat-theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'  => 'Location Settings',
        'menu_title'  => 'Location',
        'parent_slug' => 'maat-theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'  => 'FAQ Page Settings',
        'menu_title'  => 'FAQs',
        'parent_slug' => 'maat-theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'  => 'Blog Page Settings',
        'menu_title'  => 'Blog',
        'parent_slug' => 'maat-theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'  => 'Team Settings',
        'menu_title'  => 'Team',
        'parent_slug' => 'maat-theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'  => 'Location Settings',
        'menu_title'  => 'Location',
        'parent_slug' => 'maat-theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'  => 'Error and Search Page Settings',
        'menu_title'  => 'Error and Search',
        'parent_slug' => 'maat-theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'  => 'Practice Area Settings',
        'menu_title'  => 'Practice Area',
        'parent_slug' => 'maat-theme-general-settings',
    ));

}
