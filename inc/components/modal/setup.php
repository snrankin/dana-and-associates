<?php
// Register Custom Post Type
function maat_global_modals() {

	$labels = array(
		'name'                  => _x( 'Popups', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Popup', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Popups', 'text_domain' ),
		'name_admin_bar'        => __( 'Popup', 'text_domain' ),
		'archives'              => __( 'Popup Archives', 'text_domain' ),
		'attributes'            => __( 'Popup Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Popup:', 'text_domain' ),
		'all_items'             => __( 'All Popups', 'text_domain' ),
		'add_new_item'          => __( 'Add New Popup', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Popup', 'text_domain' ),
		'edit_item'             => __( 'Edit Popup', 'text_domain' ),
		'update_item'           => __( 'Update Popup', 'text_domain' ),
		'view_item'             => __( 'View Popup', 'text_domain' ),
		'view_items'            => __( 'View Popups', 'text_domain' ),
		'search_items'          => __( 'Search Popup', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into popup', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this popup', 'text_domain' ),
		'items_list'            => __( 'Popups list', 'text_domain' ),
		'items_list_navigation' => __( 'Popups list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter popups list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Popup', 'text_domain' ),
		'description'           => __( 'Global popups that can be referenced anywhere using a shortcode', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-external',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'maat_modal', $args );

}
add_action( 'init', 'maat_global_modals', 0 );

include_component_partial('modal', 'template');

add_action( 'vc_before_init', 'vc_add_modal' );
function vc_add_modal() {
    vc_map(array(
        'name' => __('Maat Popup'),
        'base' => 'maat_modal',
        'category' => __('Content'),
        'params' => array(
            array(
                'type' => 'loop',
                'holder' => 'div',
                'class' => '',
                'heading' => __('Maat Popup'),
                'param_name' => 'popup_id',
                'value' => __('Default params value'),
                'description' => __('Choose a popup')
            )
        )
    ));
}
