<?php
if (!function_exists('maat_unregister_post_type')) {
    function maat_unregister_post_type()
    {
        unregister_post_type('practice');
        unregister_post_type('case');
    }
}
add_action('init', 'maat_unregister_post_type', 9999);
if (!function_exists('maat_practice_areas')) {

    function maat_practice_areas()
    {

        $labels = array(
            'name'                  => _x('Practice Areas', 'Post Type General Name', 'maat'),
            'singular_name'         => _x('Practice Area', 'Post Type Singular Name', 'maat'),
            'menu_name'             => __('Practice Areas', 'maat'),
            'name_admin_bar'        => __('Practice Areas', 'maat'),
            'archives'              => __('Practice Area Archives', 'maat'),
            'attributes'            => __('Practice Area Attributes', 'maat'),
            'parent_item_colon'     => __('Parent Practice Area:', 'maat'),
            'all_items'             => __('All Practice Areas', 'maat'),
            'add_new_item'          => __('Add New Practice Area', 'maat'),
            'add_new'               => __('Add New', 'maat'),
            'new_item'              => __('New Practice Area', 'maat'),
            'edit_item'             => __('Edit Practice Area', 'maat'),
            'update_item'           => __('Update Practice Area', 'maat'),
            'view_item'             => __('View Practice Area', 'maat'),
            'view_items'            => __('View Practice Areas', 'maat'),
            'search_items'          => __('Search Practice Area', 'maat'),
            'not_found'             => __('Not found', 'maat'),
            'not_found_in_trash'    => __('Not found in Trash', 'maat'),
            'featured_image'        => __('Featured Image', 'maat'),
            'set_featured_image'    => __('Set featured image', 'maat'),
            'remove_featured_image' => __('Remove featured image', 'maat'),
            'use_featured_image'    => __('Use as featured image', 'maat'),
            'insert_into_item'      => __('Insert into item', 'maat'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'maat'),
            'items_list'            => __('Practice Areas list', 'maat'),
            'items_list_navigation' => __('Practice Areas list navigation', 'maat'),
            'filter_items_list'     => __('Filter items list', 'maat'),
        );
        $rewrite = array(
            'slug'       => 'practice-areas',
            'with_front' => false,
            'pages'      => true,
            'feeds'      => true,
        );
        $args = array(
            'label'               => __('Practice Area', 'maat'),
            'description'         => __('Post Type Description', 'maat'),
            'labels'              => $labels,
            'supports'            => array('title', 'thumbnail', 'editor'),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-admin-multisite',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => 'practice-areas',
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite'             => $rewrite,
            'capability_type'     => 'page',
        );
        register_post_type('practice_area', $args);
    }
    add_action('init', 'maat_practice_areas', 0);
}

if (!function_exists('plugin_prefix_unregister_post_type')) {
    function plugin_prefix_unregister_post_type()
    {
        unregister_post_type('practice_area');
    }
}
add_action('init', 'plugin_prefix_unregister_post_type');

// Register Custom Post Type
function maat_cpt_practice_areas()
{

    $labels = array(
        'name'                  => _x('Practice Areas', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Practice Area', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Practice Areas', 'text_domain'),
        'name_admin_bar'        => __('Practice Area', 'text_domain'),
        'archives'              => __('Practice Area Archives', 'text_domain'),
        'attributes'            => __('Practice Area Attributes', 'text_domain'),
        'parent_item_colon'     => __('Parent Practice:', 'text_domain'),
        'all_items'             => __('All Practices', 'text_domain'),
        'add_new_item'          => __('Add New Practice', 'text_domain'),
        'add_new'               => __('Add New', 'text_domain'),
        'new_item'              => __('New Practice', 'text_domain'),
        'edit_item'             => __('Edit Practice', 'text_domain'),
        'update_item'           => __('Update Practice', 'text_domain'),
        'view_item'             => __('View Practice', 'text_domain'),
        'view_items'            => __('View Practices', 'text_domain'),
        'search_items'          => __('Search Practice', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image'    => __('Use as featured image', 'text_domain'),
        'insert_into_item'      => __('Insert into practice', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
        'items_list'            => __('Practices list', 'text_domain'),
        'items_list_navigation' => __('Practices list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter practices list', 'text_domain'),
    );
    $rewrite = array(
        'slug'       => 'practice-areas',
        'with_front' => false,
        'pages'      => true,
        'feeds'      => true,
    );
    $args = array(
        'label'               => __('Practice Area', 'text_domain'),
        'description'         => __('Post Type Description', 'text_domain'),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-index-card',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => 'practice-areas',
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'page',
    );
    register_post_type('maat_practice_areas', $args);
}
add_action('init', 'maat_cpt_practice_areas', 0);

function maat_show_all_practice_areas($query)
{
    if (is_admin()) {
        return;
    }
    if ($query->is_main_query()) {

        if (is_post_type_archive('maat_practice_areas')) {

            $query->set('posts_per_page', -1);
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
        }
    }
}
add_action('pre_get_posts', 'maat_show_all_practice_areas');

function practice_areas_list()
{
    $practice_areas_list = '';

    ob_start();
    ?>
<div class="menu-container">
    <div class="menu-wrapper p-0">
        <nav class="menu-inner practice-areas-nav" aria-label="Practice Areas Nav">
            <ul class="nav nav-flush vertical" role="menu" aria-label="Practice Areas Menu">
                <?php wp_list_pages(array(
                        'title_li'    => '',
                        'sort_column' => 'post_title',
                        'post_type'   => 'maat_practice_areas',
                        'walker'      => new WP_Bootstrap_Pagewalker(),
                    )); ?>
            </ul>
        </nav>
    </div>
</div>
<?php
    $practice_areas_list = ob_get_clean();

    return $practice_areas_list;
} ?>
