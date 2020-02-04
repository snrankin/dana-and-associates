<?php

if (!function_exists('maat_practice_locations')) {

    function maat_practice_locations()
    {

        $labels = array(
            'name'                  => _x('Practice Locations', 'Post Type General Name', 'maat'),
            'singular_name'         => _x('Practice Location', 'Post Type Singular Name', 'maat'),
            'menu_name'             => __('Locations', 'maat'),
            'name_admin_bar'        => __('Locations', 'maat'),
            'archives'              => __('Location Archives', 'maat'),
            'attributes'            => __('Location Attributes', 'maat'),
            'parent_item_colon'     => __('Parent Location:', 'maat'),
            'all_items'             => __('All Locations', 'maat'),
            'add_new_item'          => __('Add New Location', 'maat'),
            'add_new'               => __('Add New', 'maat'),
            'new_item'              => __('New Location', 'maat'),
            'edit_item'             => __('Edit Location', 'maat'),
            'update_item'           => __('Update Location', 'maat'),
            'view_item'             => __('View Location', 'maat'),
            'view_items'            => __('View Locations', 'maat'),
            'search_items'          => __('Search Location', 'maat'),
            'not_found'             => __('Not found', 'maat'),
            'not_found_in_trash'    => __('Not found in Trash', 'maat'),
            'featured_image'        => __('Featured Image', 'maat'),
            'set_featured_image'    => __('Set featured image', 'maat'),
            'remove_featured_image' => __('Remove featured image', 'maat'),
            'use_featured_image'    => __('Use as featured image', 'maat'),
            'insert_into_item'      => __('Insert into item', 'maat'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'maat'),
            'items_list'            => __('Locations list', 'maat'),
            'items_list_navigation' => __('Locations list navigation', 'maat'),
            'filter_items_list'     => __('Filter items list', 'maat'),
        );
        $args = array(
            'label'               => __('Practice Location', 'maat'),
            'description'         => __('Post Type Description', 'maat'),
            'labels'              => $labels,
            'supports'            => array('title', 'thumbnail', 'editor'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-location-alt',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type('location', $args);

    }
    add_action('init', 'maat_practice_locations', 0);

}

if (!function_exists('maat_location_categories')) {

    function maat_location_categories()
    {

        $labels = array(
            'name'                       => _x('Location Categories', 'Category General Name', 'maat'),
            'singular_name'              => _x('Location Category', 'Category Singular Name', 'maat'),
            'menu_name'                  => __('Category', 'maat'),
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
            'no_terms'                   => __('No items', 'maat'),
            'items_list'                 => __('Categories list', 'maat'),
            'items_list_navigation'      => __('Categories list navigation', 'maat'),
        );
        $rewrite = array(
            'slug'         => 'locations',
            'with_front'   => true,
            'hierarchical' => false,
        );

        $args = array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'rewrite'           => $rewrite,
        );
        register_taxonomy('location_cat', array('location'), $args);

    }
    add_action('init', 'maat_location_categories', 0);

}

include_component_partial('location', 'map');
include_component_partial('location', 'grid');
include_component_partial('location', 'category-grid');
