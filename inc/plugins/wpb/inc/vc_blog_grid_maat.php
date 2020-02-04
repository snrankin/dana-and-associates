<?php

/** ===========================================================================
 * Visual Composer Setup file for the Blog Grid Component
 * @package Blog Grid
 * @version <<version>>
 * @link http://www.wpelixir.com/how-to-create-new-element-in-visual-composer/
 * @uses WPBakeryShortCode
 * -----
 * @author Sam Rankin <you@you.you>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * ========================================================================= */

class maatBlogGrid extends WPBakeryShortCode
{

    // Element Init
    function __construct()
    {
        add_action('init', array($this, 'vc_blog_grid_maat_mapping'));
        add_shortcode('vc_blog_grid_maat', array($this, 'vc_blog_grid_maat_html'));
    }

    // Element Mapping
    public function vc_blog_grid_maat_mapping()
    {

        // Stop all if VC is not enabled
        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        // Map the block with vc_map()
        vc_map(
            array(
                'name'        => __('Blog Grid', 'maat'),
                'base'        => 'vc_blog_grid_maat',
                'description' => __('', 'maat'),
                'category'    => __('Maat Components', 'maat'),
                'params'      => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Element ID', 'maat'),
                        'param_name'  => 'el_id',
                        'description' => sprintf(__('Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'maat'), 'http://www.w3schools.com/tags/att_global_id.asp'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Grid Wrapper Class', 'maat'),
                        'param_name'  => 'el_class',
                        'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'maat'),
                    ),
                    array(
                        'type'        => 'loop',
                        'heading'     => __('Blog Loop', 'maat'),
                        'param_name'  => 'blog_loop',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Grid Type', 'maat'),
                        'param_name' => 'grid_type',
                        'value' => array(
                            __('List',   'maat')       => 'list',
                            __('Equal Grid', 'maat')   => 'grid',
                            __('Masonry Grid', 'maat') => 'masonry',
                            __('Carousel', 'maat')     => 'carousel',
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Remove Gutters?', 'maat'),
                        'param_name' => 'remove_gutters',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Loop the Carousel', 'maat'),
                        'param_name' => 'loop_carousel',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                        'dependency' => array(
                            'element' => 'grid_type',
                            'value' => array('carousel'),
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Add arrow nav', 'maat'),
                        'param_name' => 'arrow_nav',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                        'dependency' => array(
                            'element' => 'grid_type',
                            'value' => array('carousel'),
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Add Dots Nav', 'maat'),
                        'param_name' => 'dots_nav',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                        'dependency' => array(
                            'element' => 'grid_type',
                            'value' => array('carousel'),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Column Span on Mobile Portrait', 'maat'),
                        'param_name' => 'col_w_sm',
                        'value' => array(
                            __('Default',   'maat')                => '',
                            __('Auto',      'maat')                => 'col-sm-auto',
                            __('12 columns or full width', 'maat') => 'col-sm-12',
                            __('11 columns', 'maat')               => 'col-sm-11',
                            __('10 columns or 5/6', 'maat')        => 'col-sm-10',
                            __('80% column',  'maat')              => 'col-sm-80',
                            __('9 columns or 3/4', 'maat')         => 'col-sm-9',
                            __('8 columns or 2/3', 'maat')         => 'col-sm-8',
                            __('60% column',  'maat')              => 'col-sm-60',
                            __('7 columns', 'maat')                => 'col-sm-7',
                            __('6 columns or 1/2', 'maat')         => 'col-sm-6',
                            __('5 columns', 'maat')                => 'col-sm-5',
                            __('40% column',  'maat')              => 'col-sm-40',
                            __('4 columns or 1/3', 'maat')         => 'col-sm-4',
                            __('3 columns or 1/4', 'maat')         => 'col-sm-3',
                            __('20% column',  'maat')              => 'col-sm-20',
                            __('2 columns or 1/6', 'maat')         => 'col-sm-2',
                            __('1 column',  'maat')                => 'col-sm-1',
                        ),
                        'description' => __('Choose the number of columns to display on devices 320px and up', 'maat'),
                        'dependency' => array(
                            'element' => 'grid_type',
                            'value_not_equal_to' => array('list'),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Column Span on Mobile Landscape', 'maat'),
                        'param_name' => 'col_w_ms',
                        'value' => array(
                            __('Default',   'maat')                => '',
                            __('Auto',      'maat')                => 'col-ms-auto',
                            __('12 columns or full width', 'maat') => 'col-ms-12',
                            __('11 columns', 'maat')               => 'col-ms-11',
                            __('10 columns or 5/6', 'maat')        => 'col-ms-10',
                            __('80% column',  'maat')              => 'col-ms-80',
                            __('9 columns or 3/4', 'maat')         => 'col-ms-9',
                            __('8 columns or 2/3', 'maat')         => 'col-ms-8',
                            __('60% column',  'maat')              => 'col-ms-60',
                            __('7 columns', 'maat')                => 'col-ms-7',
                            __('6 columns or 1/2', 'maat')         => 'col-ms-6',
                            __('5 columns', 'maat')                => 'col-ms-5',
                            __('40% column',  'maat')              => 'col-ms-40',
                            __('4 columns or 1/3', 'maat')         => 'col-ms-4',
                            __('3 columns or 1/4', 'maat')         => 'col-ms-3',
                            __('20% column',  'maat')              => 'col-ms-20',
                            __('2 columns or 1/6', 'maat')         => 'col-ms-2',
                            __('1 column',  'maat')                => 'col-ms-1',
                        ),
                        'description' => __('Choose the number of columns to display on devices 576px and up', 'maat'),
                        'dependency' => array(
                            'element' => 'grid_type',
                            'value_not_equal_to' => array('list'),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Column Span on Tablet Portrait', 'maat'),
                        'param_name' => 'col_w_md',
                        'value' => array(
                            __('Default',   'maat')                => '',
                            __('Auto',      'maat')                => 'col-md-auto',
                            __('12 columns or full width', 'maat') => 'col-md-12',
                            __('11 columns', 'maat')               => 'col-md-11',
                            __('10 columns or 5/6', 'maat')        => 'col-md-10',
                            __('80% column',  'maat')              => 'col-md-80',
                            __('9 columns or 3/4', 'maat')         => 'col-md-9',
                            __('8 columns or 2/3', 'maat')         => 'col-md-8',
                            __('60% column',  'maat')              => 'col-md-60',
                            __('7 columns', 'maat')                => 'col-md-7',
                            __('6 columns or 1/2', 'maat')         => 'col-md-6',
                            __('5 columns', 'maat')                => 'col-md-5',
                            __('40% column',  'maat')              => 'col-md-40',
                            __('4 columns or 1/3', 'maat')         => 'col-md-4',
                            __('3 columns or 1/4', 'maat')         => 'col-md-3',
                            __('20% column',  'maat')              => 'col-md-20',
                            __('2 columns or 1/6', 'maat')         => 'col-md-2',
                            __('1 column',  'maat')                => 'col-md-1',
                        ),
                        'description' => __('Choose the number of columns to display on devices 768px and up', 'maat'),
                        'dependency' => array(
                            'element' => 'grid_type',
                            'value_not_equal_to' => array('list'),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Column Span on Tablet Landscape', 'maat'),
                        'param_name' => 'col_w_ml',
                        'value' => array(
                            __('Default',   'maat')                => '',
                            __('Auto',      'maat')                => 'col-ml-auto',
                            __('12 columns or full width', 'maat') => 'col-ml-12',
                            __('11 columns', 'maat')               => 'col-ml-11',
                            __('10 columns or 5/6', 'maat')        => 'col-ml-10',
                            __('80% column',  'maat')              => 'col-ml-80',
                            __('9 columns or 3/4', 'maat')         => 'col-ml-9',
                            __('8 columns or 2/3', 'maat')         => 'col-ml-8',
                            __('60% column',  'maat')              => 'col-ml-60',
                            __('7 columns', 'maat')                => 'col-ml-7',
                            __('6 columns or 1/2', 'maat')         => 'col-ml-6',
                            __('5 columns', 'maat')                => 'col-ml-5',
                            __('40% column',  'maat')              => 'col-ml-40',
                            __('4 columns or 1/3', 'maat')         => 'col-ml-4',
                            __('3 columns or 1/4', 'maat')         => 'col-ml-3',
                            __('20% column',  'maat')              => 'col-ml-20',
                            __('2 columns or 1/6', 'maat')         => 'col-ml-2',
                            __('1 column',  'maat')                => 'col-ml-1',
                        ),
                        'description' => __('Choose the number of columns to display on devices 1024px and up', 'maat'),
                        'dependency' => array(
                            'element' => 'grid_type',
                            'value_not_equal_to' => array('list'),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Number of Columns on Small Desktops', 'maat'),
                        'param_name' => 'col_w_lg',
                        'value' => array(
                            __('Default',   'maat')                => '',
                            __('Auto',      'maat')                => 'col-lg-auto',
                            __('12 columns or full width', 'maat') => 'col-lg-12',
                            __('11 columns', 'maat')               => 'col-lg-11',
                            __('10 columns or 5/6', 'maat')        => 'col-lg-10',
                            __('80% column',  'maat')              => 'col-lg-80',
                            __('9 columns or 3/4', 'maat')         => 'col-lg-9',
                            __('8 columns or 2/3', 'maat')         => 'col-lg-8',
                            __('60% column',  'maat')              => 'col-lg-60',
                            __('7 columns', 'maat')                => 'col-lg-7',
                            __('6 columns or 1/2', 'maat')         => 'col-lg-6',
                            __('5 columns', 'maat')                => 'col-lg-5',
                            __('40% column',  'maat')              => 'col-lg-40',
                            __('4 columns or 1/3', 'maat')         => 'col-lg-4',
                            __('3 columns or 1/4', 'maat')         => 'col-lg-3',
                            __('20% column',  'maat')              => 'col-lg-20',
                            __('2 columns or 1/6', 'maat')         => 'col-lg-2',
                            __('1 column',  'maat')                => 'col-lg-1',
                        ),
                        'description' => __('Choose the number of columns to display on devices 1280px and up', 'maat'),
                        'dependency' => array(
                            'element' => 'grid_type',
                            'value_not_equal_to' => array('list'),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Column Span on Large Desktop', 'maat'),
                        'param_name' => 'col_w_xl',
                        'value' => array(
                            __('Default',   'maat')                => '',
                            __('Auto',      'maat')                => 'col-xl-auto',
                            __('12 columns or full width', 'maat') => 'col-xl-12',
                            __('11 columns', 'maat')               => 'col-xl-11',
                            __('10 columns or 5/6', 'maat')        => 'col-xl-10',
                            __('80% column',  'maat')              => 'col-xl-80',
                            __('9 columns or 3/4', 'maat')         => 'col-xl-9',
                            __('8 columns or 2/3', 'maat')         => 'col-xl-8',
                            __('60% column',  'maat')              => 'col-xl-60',
                            __('7 columns', 'maat')                => 'col-xl-7',
                            __('6 columns or 1/2', 'maat')         => 'col-xl-6',
                            __('5 columns', 'maat')                => 'col-xl-5',
                            __('40% column',  'maat')              => 'col-xl-40',
                            __('4 columns or 1/3', 'maat')         => 'col-xl-4',
                            __('3 columns or 1/4', 'maat')         => 'col-xl-3',
                            __('20% column',  'maat')              => 'col-xl-20',
                            __('2 columns or 1/6', 'maat')         => 'col-xl-2',
                            __('1 column',  'maat')                => 'col-xl-1',
                        ),
                        'description' => __('Choose the number of columns to display on devices 1440px and up', 'maat'),
                        'dependency' => array(
                            'element' => 'grid_type',
                            'value_not_equal_to' => array('list'),
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Item Wrapper Classes', 'maat'),
                        'param_name'  => 'wrapper_classes',
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Item Body Classes', 'maat'),
                        'param_name'  => 'body_classes',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Display Featured Image', 'maat'),
                        'param_name' => 'add_image',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Image Wrapper Classes', 'maat'),
                        'param_name'  => 'image_wrapper_classes',
                        'dependency' => array(
                            'element' => 'add_image',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Image Classes', 'maat'),
                        'param_name'  => 'image_classes',
                        'dependency' => array(
                            'element' => 'add_image',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Image Size', 'maat'),
                        'param_name'  => 'image_size',
                        'dependency' => array(
                            'element' => 'add_image',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Display Post Title', 'maat'),
                        'param_name' => 'add_title',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => __('Title Tag', 'maat'),
                        'param_name' => 'title_tag',
                        'value'      => array(
                            __('Paragraph', 'maat') => 'p',
                            __('Heading 1', 'maat') => 'h1',
                            __('Heading 2', 'maat') => 'h2',
                            __('Heading 3', 'maat') => 'h3',
                            __('Heading 4', 'maat') => 'h4',
                            __('Heading 5', 'maat') => 'h5',
                            __('Heading 6', 'maat') => 'h6',

                        ),
                        'dependency' => array(
                            'element' => 'add_title',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type'        => 'textarea_raw_html',
                        'heading'     => __('Text Before Title', 'maat'),
                        'param_name'  => 'before_title',
                        'dependency' => array(
                            'element' => 'add_title',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type'        => 'textarea_raw_html',
                        'heading'     => __('Text After Title', 'maat'),
                        'param_name'  => 'after_title',
                        'dependency' => array(
                            'element' => 'add_title',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Post Title Classes', 'maat'),
                        'param_name'  => 'title_classes',
                        'dependency' => array(
                            'element' => 'add_title',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Display Excerpt', 'maat'),
                        'param_name' => 'add_excerpt',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Excerpt Classes', 'maat'),
                        'param_name'  => 'excerpt_classes',
                        'dependency' => array(
                            'element' => 'add_excerpt',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Display Link Button', 'maat'),
                        'param_name' => 'add_link',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Link Button Classes', 'maat'),
                        'param_name'  => 'link_classes',
                        'dependency' => array(
                            'element' => 'add_link',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Meta Classes', 'maat'),
                        'param_name'  => 'meta_classes',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Display Date', 'maat'),
                        'param_name' => 'add_date',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Date Classes', 'maat'),
                        'param_name'  => 'date_classes',
                        'dependency' => array(
                            'element' => 'add_date',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Display Author', 'maat'),
                        'param_name' => 'add_author',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Author Classes', 'maat'),
                        'param_name'  => 'author_classes',
                        'dependency' => array(
                            'element' => 'add_author',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Display Tags', 'maat'),
                        'param_name' => 'add_tags',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Tag Classes', 'maat'),
                        'param_name'  => 'tag_classes',
                        'dependency' => array(
                            'element' => 'add_tags',
                            'value' => array('yes'),
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Display Categories', 'maat'),
                        'param_name' => 'add_cats',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => __('Category Classes', 'maat'),
                        'param_name'  => 'cat_classes',
                        'dependency' => array(
                            'element' => 'add_cats',
                            'value' => array('yes'),
                        ),
                    ),
                ),
            )
        );
    }

    // Element HTML
    public function vc_blog_grid_maat_html($atts)
    {
        foreach ($atts as $key => $value) {
            if ($value === 'yes') {
                $atts[$key] = 1;
            }
        }
        extract(
            shortcode_atts(
                array(
                    'wrapper_classes' => '',
                    'el_id'           => '',
                    'before_title'    => '',
                    'after_title'     => '',
                    'el_class'        => '',
                    'grid_type'       => '',
                    'blog_loop'       => '',
                    'remove_gutters'  => '',
                    'loop_carousel'   => '',
                    'arrow_nav'       => '',
                    'dots_nav'        => '',
                    'col_w_sm'        => '',
                    'col_w_ms'        => '',
                    'col_w_md'        => '',
                    'col_w_ml'        => '',
                    'col_w_lg'        => '',
                    'col_w_xl'        => '',
                ),
                $atts
            )
        );

        $defaults = array(
            'wrapper_classes'       => '',
            'body_classes'          => '',
            'add_image'             => 0,
            'image_wrapper_classes' => '',
            'image_classes'         => '',
            'image_size'            => 'medium',
            'before_title'          => '',
            'add_title'             => 1,
            'title_tag'             => 'h4',
            'title_classes'         => '',
            'after_title'           => '',
            'add_excerpt'           => 0,
            'excerpt_classes'       => '',
            'add_link'              => 0,
            'link_classes'          => '',
            'add_meta'              => 0,
            'meta_classes'          => '',
            'add_author'            => 0,
            'author_classes'        => '',
            'add_date'              => 0,
            'date_classes'          => '',
            'add_tags'              => 0,
            'tag_classes'           => '',
            'add_cats'              => 0,
            'cat_classes'           => '',
        );
        $columns = array(
            $col_w_sm,
            $col_w_ms,
            $col_w_md,
            $col_w_ml,
            $col_w_lg,
            $col_w_xl,
        );
        $breakpoints = array(
            GRID_SM,
            GRID_MS,
            GRID_MD,
            GRID_ML,
            GRID_LG,
            GRID_XL
        );

        $post_args = array_replace($defaults, $atts);
        if (!empty($before_title)) {
            $before_title = rawurldecode(base64_decode(wp_strip_all_tags($before_title)));
            $before_title = wpb_js_remove_wpautop(apply_filters('vc_raw_html_module_content', $before_title));

            $post_args['before_title'] = wpb_js_remove_wpautop($before_title);
        }
        if (!empty($after_title)) {

            $after_title = rawurldecode(base64_decode(wp_strip_all_tags($after_title)));
            $after_title = wpb_js_remove_wpautop(apply_filters('vc_raw_html_module_content', $after_title));

            $post_args['after_title'] = wpb_js_remove_wpautop($after_title);
        }

        $items = $column_classes = '';
        $carousel_opts = array();
        $responsive = array();
        $id_num = vc_random_string();
        $loop_args = vc_parse_multi_attribute($blog_loop);

        if (isset($loop_args['size'])) {
            $loop_args['numberposts'] = $loop_args['size'];
            unset($loop_args['size']);
        }
        if (isset($loop_args['categories'])) {
            $loop_args['cat'] = $loop_args['categories'];
            unset($loop_args['categories']);
        }

        global $post;
        $custom_posts = get_posts($loop_args);

        $item_wrapper_classes = array(
            'content-item',
            'maat-blog-' . $grid_type,
        );

        $wrapper_attributes = array(
            'id' => $el_id,
            'class' => maat_item_classes($item_wrapper_classes, $el_class),
        );

        if (empty($el_id)) : $el_id = 'maat-blog-' . $id_num;
        endif;

        if (!empty($el_id)) {
            $end_comment = '<!-- end #' . esc_attr($el_id) . '.content-item-->';
        } else {
            $end_comment = '<!-- end .content-item-->';
        }

        if ($grid_type === 'grid') {
            $column_classes = maat_item_classes($column_classes, $columns);
        }

        if (strpos($wrapper_classes, 'card') !== false) {
            $item_wrapper_classes[] = 'card-grid';
        }

        if ($grid_type === 'grid' || $grid_type === 'masonry') {
            $row_classes[] = 'row';
        }

        if ($grid_type === 'carousel') {
            $item_wrapper_classes[] = 'maat-carousel';
        }

        if ($remove_gutters == 1) {
            $row_classes[] = 'no-gutters';
        }

        foreach ($columns as $index => $column) {
            $item = maat_col_num($column);
            $breakpoint = $breakpoints[$index];
            if (!is_null($item)) {
                $responsive[$breakpoint] = $item;
            }
        }

        if (count($responsive) > 1) {
            $carousel_opts['responsive'] = $responsive;
        } else {
            $carousel_opts['items'] = $responsive[0];
        }

        if ($loop_carousel == 1) {
            $carousel_opts['loop'] = 'true';
        }
        if ($arrow_nav == 1) {
            $carousel_opts['nav'] = 'true';
        }
        if ($dots_nav == 1) {
            $carousel_opts['dots'] = 'true';
        }

        $output .= '<div' . maat_add_item_data($wrapper_attributes) . '>';


        foreach ($custom_posts as $post) : setup_postdata($post);
            if (($grid_type === 'grid' && count($custom_posts) > 1) || ($grid_type === 'masonry' && count($custom_posts) > 1)) {
                $items .= (!empty($column_classes)) ? '<div class="' . $column_classes . '">' : '';
                $items .= (!empty($column_classes)) ? '<div class="content-wrapper">' : '';
                $items .= maat_blog_grid_item(get_the_ID(), $post_args);
                $items .= (!empty($column_classes)) ? '</div>' : '';
                $items .= (!empty($column_classes)) ? '</div>' : '';
            } else {
                $items .= maat_blog_grid_item(get_the_ID(), $post_args);
            }
        endforeach;

        if (count($custom_posts) > 1) {

            if ($grid_type === 'grid' || $grid_type === 'masonry') {
                $output .= '<div class="container-fluid">';
                $output .= '<div class="row">';
                $output .= $items;
                $output .= '</div>';
                $output .= '</div>';
            } elseif ($grid_type === 'carousel') {
                $output .= maat_carousel('carousel-' . $id_num, $items, $wrapper_class = 'maat-carousel owl-carousel', $carousel_opts);
            } else {
                $output .= $items;
            }
        } else {
            $output .= $items;
        }

        $output .= '</div>';
        $output .= "\n" . $end_comment;
        wp_reset_postdata();
        return $output;
    }
} // End Element Class

// Element Class Init
new maatBlogGrid();
