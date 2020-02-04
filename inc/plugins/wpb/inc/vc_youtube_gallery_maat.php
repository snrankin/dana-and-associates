<?php

/** ===========================================================================
 * Visual Composer Setup file for the Youtube Gallery Component
 * @package Youtube Gallery
 * @version <<version>>
 * @link http://www.wpelixir.com/how-to-create-new-element-in-visual-composer/
 * @uses WPBakeryShortCode
 * -----
 * @author Sam Rankin <you@you.you>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * ========================================================================= */

class maatYoutubeGallery extends WPBakeryShortCode
{

    // Element Init
    public function __construct()
    {
        add_action('init', array($this, 'vc_youtube_gallery_maat_mapping'));
        add_shortcode('vc_youtube_gallery_maat', array($this, 'vc_youtube_gallery_maat_html'));
    }

    // Element Mapping
    public function vc_youtube_gallery_maat_mapping()
    {

        // Stop all if VC is not enabled
        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        // Map the block with vc_map()
        vc_map(
            array(
                'name'        => __('Youtube Gallery', 'maat'),
                'base'        => 'vc_youtube_gallery_maat',
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
                        'heading'     => __('Extra class name', 'maat'),
                        'param_name'  => 'el_class',
                        'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'maat'),
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => __('Youtube Playlist ID', 'maat'),
                        'param_name' => 'playlist_id',
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => __('Number of Videos to Show', 'maat'),
                        'param_name' => 'num_videos',
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __('Video Ratio', 'maat'),
                        'param_name'  => 'video_ratio',
                        'value'       => array(
                            __('16:9', 'maat') => '16by9',
                            __('21:9', 'maat') => '21by9',
                            __('3:2', 'maat')  => '3by9',
                            __('4:3', 'maat')  => '4by3',
                        ),
                        'description' => __('Choose the number of columns to display on devices 320px and up', 'maat'),
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
                ),
            )
        );
    }

    // Element HTML
    public function vc_youtube_gallery_maat_html($atts)
    {
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'el_id'           => '',
                    'el_class'        => '',
                    'playlist_id'     => '',
                    'num_videos'      => '',
                    'video_ratio'     => '16by9',
                    'grid_type'       => '',
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

        if (empty($playlist_id)) {
            return;
        }

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

        $items = $column_classes = '';
        $carousel_opts = array();
        $responsive = array();
        $id_num = vc_random_string();
        $container_classes = array(
            'content-item',
            'maat-youtube-gallery',
        );

        if (!empty($el_id)) {
            $end_comment = '<!-- end #' . esc_attr($el_id) . '.content-item-->';
        } else {
            $end_comment = '<!-- end .content-item-->';
        }

        if ($grid_type === 'grid') {
            $column_classes = maat_item_classes($column_classes, $columns);
        }

        if ($grid_type === 'grid' || $grid_type === 'masonry') {
            $row_classes[] = 'row';
        }

        if ($grid_type === 'carousel') {
            $container_classes[] = 'maat-carousel';
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

        $container_class      = maat_item_classes($container_classes, $el_class);

        $wrapper_attributes = array(
            'id' => $el_id,
            'class' => $container_class,
        );

        $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=' . $num_videos . '&playlistId=' . $playlist_id . '&key=' . YOUTUBE_KEY;

        $playlist = json_decode(file_get_contents($api_url), true);
        $output = '<div' . maat_add_item_data($wrapper_attributes) . '>';
        if (!empty($playlist)) {
            $output .= '<div' . maat_add_item_data($wrapper_attributes) . '>';
            foreach ($playlist['items'] as $item) :

                $id = $item['snippet']['resourceId']['videoId'];

                if ($grid_type === 'grid' || $grid_type === 'masonry') {
                    $items .= (!empty($column_classes)) ? '<div class="' . $column_classes . '">' : '';
                    $items .= (!empty($column_classes)) ? '<div class="content-wrapper">' : '';
                    $items .= maat_youtube_video($id);
                    $items .= (!empty($column_classes)) ? '</div>' : '';
                    $items .= (!empty($column_classes)) ? '</div>' : '';
                } else {
                    $items .= maat_youtube_video($id);
                }

            endforeach;
        }

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

        $output .= '</div>';
        $output .= "\n" . $end_comment;

        return $output;
    }
} // End Element Class

// Element Class Init
new maatYoutubeGallery();
