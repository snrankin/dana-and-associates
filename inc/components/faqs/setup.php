<?php

if (!function_exists('maat_faqs')) {

    function maat_faqs()
    {

        $labels = array(
            'name'                  => _x('FAQs', 'Post Type General Name', 'maat'),
            'singular_name'         => _x('FAQ', 'Post Type Singular Name', 'maat'),
            'menu_name'             => __('FAQs', 'maat'),
            'name_admin_bar'        => __('FAQs', 'maat'),
            'archives'              => __('FAQ Archives', 'maat'),
            'attributes'            => __('FAQ Attributes', 'maat'),
            'parent_item_colon'     => __('Parent FAQ:', 'maat'),
            'all_items'             => __('All FAQs', 'maat'),
            'add_new_item'          => __('Add New FAQ', 'maat'),
            'add_new'               => __('Add New', 'maat'),
            'new_item'              => __('New FAQ', 'maat'),
            'edit_item'             => __('Edit FAQ', 'maat'),
            'update_item'           => __('Update FAQ', 'maat'),
            'view_item'             => __('View FAQ', 'maat'),
            'view_items'            => __('View FAQs', 'maat'),
            'search_items'          => __('Search FAQ', 'maat'),
            'not_found'             => __('Not found', 'maat'),
            'not_found_in_trash'    => __('Not found in Trash', 'maat'),
            'featured_image'        => __('Featured Image', 'maat'),
            'set_featured_image'    => __('Set featured image', 'maat'),
            'remove_featured_image' => __('Remove featured image', 'maat'),
            'use_featured_image'    => __('Use as featured image', 'maat'),
            'insert_into_item'      => __('Insert into item', 'maat'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'maat'),
            'items_list'            => __('FAQs list', 'maat'),
            'items_list_navigation' => __('FAQs list navigation', 'maat'),
            'filter_items_list'     => __('Filter items list', 'maat'),
        );
        $args = array(
            'label'               => __('FAQ', 'maat'),
            'description'         => __('Post Type Description', 'maat'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'page-attributes'),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-feedback',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type('faqs', $args);
    }
    add_action('init', 'maat_faqs', 0);
}
if (!function_exists('custom_faq_categories')) {

    // Register Custom Taxonomy
    function custom_faq_categories()
    {

        $labels = array(
            'name'                       => _x('FAQ Categories', 'Taxonomy General Name', 'maat'),
            'singular_name'              => _x('FAQ Category', 'Taxonomy Singular Name', 'maat'),
            'menu_name'                  => __('FAQ Category', 'maat'),
            'all_items'                  => __('All Categories', 'maat'),
            'parent_item'                => __('Parent Category', 'maat'),
            'parent_item_colon'          => __('Parent Category:', 'maat'),
            'new_item_name'              => __('New Category Name', 'maat'),
            'add_new_item'               => __('Add New Category', 'maat'),
            'edit_item'                  => __('Edit Category', 'maat'),
            'update_item'                => __('Update Category', 'maat'),
            'view_item'                  => __('View Category', 'maat'),
            'separate_items_with_commas' => __('Separate categories with commas', 'maat'),
            'add_or_remove_items'        => __('Add or remove categories', 'maat'),
            'choose_from_most_used'      => __('Choose from the most used', 'maat'),
            'popular_items'              => __('Popular Categories', 'maat'),
            'search_items'               => __('Search Categories', 'maat'),
            'not_found'                  => __('Not Found', 'maat'),
            'no_terms'                   => __('No Categories', 'maat'),
            'items_list'                 => __('Categories list', 'maat'),
            'items_list_navigation'      => __('Categories list navigation', 'maat'),
        );
        $args = array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
        );
        register_taxonomy('faq_cats', array('faqs'), $args);
    }
    add_action('init', 'custom_faq_categories', 0);
}

function maat_show_all_faqs($query)
{
    if (is_admin()) {return;}

    if ($query->is_main_query()) {

        if (is_post_type_archive('faqs')) {

            $query->set('posts_per_page', -1);
            $query->set('order', 'ASC');
            $query->set('orderby', 'menu_order');
        }
    }
}
add_action('pre_get_posts', 'maat_show_all_faqs');

if (is_post_type_archive('faqs')) {
    $post_slug      = 'faqs';
    $stylesheet_abs = PAGES_PATH . '/' . $post_slug . '/assets/css/' . THEME_SLUG . '-' . $post_slug . '.css';
    $stylesheet_rel = PAGES_PATH_URI . '/' . $post_slug . '/assets/css/' . THEME_SLUG . '-' . $post_slug . '.css';
    $script_abs     = PAGES_PATH . '/' . $post_slug . '/assets/js/' . THEME_SLUG . '-' . $post_slug . '.js';
    $script_rel     = PAGES_PATH_URI . '/' . $post_slug . '/assets/js/' . THEME_SLUG . '-' . $post_slug . '.js';
    wp_enqueue_style(THEME_SLUG . '-' . $post_slug . '-styles', $stylesheet_rel, false, filemtime($stylesheet_abs), 'all');
    wp_enqueue_script(THEME_SLUG . '-' . $post_slug . '-scripts', $script_rel, false, filemtime($script_abs), 'all');
}

function maat_load_faq_page_assets()
{
    if (is_post_type_archive('faqs')) {
        $post_slug      = 'faqs';
        $stylesheet_abs = PAGES_PATH . '/' . $post_slug . '/assets/css/' . THEME_SLUG . '-' . $post_slug . '.css';
        $stylesheet_rel = PAGES_PATH_URI . '/' . $post_slug . '/assets/css/' . THEME_SLUG . '-' . $post_slug . '.css';
        $script_abs     = PAGES_PATH . '/' . $post_slug . '/assets/js/' . THEME_SLUG . '-' . $post_slug . '.js';
        $script_rel     = PAGES_PATH_URI . '/' . $post_slug . '/assets/js/' . THEME_SLUG . '-' . $post_slug . '.js';
        wp_enqueue_style(THEME_SLUG . '-' . $post_slug . '-styles', $stylesheet_rel, false, filemtime($stylesheet_abs), 'all');
        wp_enqueue_script(THEME_SLUG . '-' . $post_slug . '-scripts', $script_rel, false, filemtime($script_abs), 'all');
    }
}
add_action('wp_enqueue_scripts', 'maat_load_faq_page_assets');

get_component_partial('faqs', 'menu-walker');

function filter_wp_link_query($results, $query)
{
    print_r2($results);

    foreach ($results as $result) {
        if ($result['info'] === 'FAQ') {
            $id                  = $result['ID'];
            $slug                = get_the_slug($id);
            $result['permalink'] = get_post_type_archive_link('faqs') . '#' . $slug;
        }
    }

    return $results;
};

// add the filter
// add_filter('wp_link_query', 'filter_wp_link_query', 1, 2);

function remove_custom_service_slug($post_link, $post)
{
    if ('faqs' === $post->post_type && 'publish' === $post->post_status) {
        $slug      = $post->post_name;
        $post_link = get_post_type_archive_link('faqs') . urldecode('%23') . $slug;

    }
    return $post_link;
}
add_filter('post_type_link', 'remove_custom_service_slug', 10, 2);
