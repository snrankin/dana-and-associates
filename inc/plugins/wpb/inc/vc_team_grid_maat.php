<?php

/** ===========================================================================
 * Visual Composer Setup file for the Team Grid Component
 * @package Team Grid
 * @version <<version>>
 * @link http://www.wpelixir.com/how-to-create-new-element-in-visual-composer/
 * @uses WPBakeryShortCode
 * -----
 * @author Sam Rankin <you@you.you>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * ========================================================================= */

class maatTeamGrid extends WPBakeryShortCode
{

    // Element Init
    function __construct()
    {
        add_action('init', array($this, 'vc_team_grid_maat_mapping'));
        add_shortcode('vc_team_grid_maat', array($this, 'vc_team_grid_maat_html'));
    }

    // Element Mapping
    public function vc_team_grid_maat_mapping()
    {

        // Stop all if VC is not enabled
        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        $team_cats = array(
            __('Default', 'maat') => '',
        );

        $args = array(
            'taxonomy' => 'team-category',
            'orderby' => 'name',
            'order'   => 'ASC'
        );

        $cats = get_categories($args);

        foreach ($cats as $cat) {
            $team_cats[$cat->name] = $cat->slug;
        }

        // Map the block with vc_map()
        vc_map(
            array(
                'name' => __('Team Grid', 'maat'),
                'base' => 'vc_team_grid_maat',
                'description' => __('', 'maat'),
                'category' => __('Maat Components', 'maat'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Element ID', 'maat'),
                        'param_name' => 'el_id',
                        'description' => sprintf(__('Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'maat'), 'http://www.w3schools.com/tags/att_global_id.asp'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Extra class name', 'maat'),
                        'param_name' => 'el_class',
                        'description' => __('Style particular content element differently - add a class name and refer to it in custom CSS.', 'maat'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Team Category', 'maat'),
                        'param_name' => 'team_category',
                        'value' => $team_cats,
                        'description' => __('Choose a category of team members to show (or leave blank to show them all)', 'maat'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Add Team Bio', 'maat'),
                        'param_name' => 'add_bios',
                        'value' => array(__('Yes', 'maat') => 'yes'),
                        'description' => __('Make items such as address, email and telephone clickable', 'maat'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Bio Type', 'maat'),
                        'param_name' => 'bio_type',
                        'value' => array(
                            __('Popup', 'maat') => 'popup',
                            __('Page', 'maat') => 'page',
                        ),
                        'description' => __('Choose whether the bio shows as a popup or opens a new page', 'maat'),
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
                    ),
                ),
            )
        );
    }

    // Element HTML
    public function vc_team_grid_maat_html(
        $atts
    ) {
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'el_id' => '',
                    'el_class' => '',
                    'team_category' => '',
                    'add_bios' => '',
                    'bio_type' => 'popup',
                    'col_w_sm' => '',
                    'col_w_ms' => '',
                    'col_w_md' => '',
                    'col_w_ml' => '',
                    'col_w_lg' => '',
                    'col_w_xl' => ''
                ),
                $atts
            )
        );

        $wrapper_attributes = array();
        if (!empty($el_id)) {
            $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
        }

        if (!empty($el_id)) {
            $end_comment = '
    <!-- end #' . esc_attr($el_id) . '.container-->';
        } else {
            $end_comment = '
    <!-- end .container-->';
        }

        $container_classes = array(
            'content-item',
            'maat-team-grid'
        );

        $custom_classes = explode(' ', $el_class);

        foreach ($custom_classes as $class) {
            $container_classes[] = $class;
        }

        $container_class = maat_add_item_classes($container_classes);
        $wrapper_attributes[] = $container_class;

        $column_classes = array(
            'col-xs-12',
            $col_w_sm,
            $col_w_ms,
            $col_w_md,
            $col_w_ml,
            $col_w_lg,
        );

        $column_class = maat_add_item_classes($column_classes);

        // Fill $html var with data
        $output = '';
        $output .= "\n" . '<div ' . implode(' ', $wrapper_attributes) . '>';
        $output .= "\n\t" . '<div class="container-fluid">';
        $output .= "\n\t\t" . '<div class="row card-deck justify-content-center">';
        global $post; // required
        $args = array(
            'post_type' => array('team'),
            'posts_per_page' => '-1',
            'order' => 'ASC',
            'orderby' => 'menu_order',
        );
        if (!empty($team_category)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'team-category',
                    'field' => 'slug',
                    'terms' => array($team_category),
                ),
            );
        }
        $team_members = get_posts($args);
        $bios = '';
        foreach ($team_members as $post) {
            setup_postdata($post);
            $bios .= ($add_bios === 'yes' && $bio_type === 'popup') ? get_team_popups($post->ID) : '';
            $add_bio = ($add_bios === 'yes') ? 1 : 0;
            $team_member  = "\n\t\t\t" . '<div ' . $column_class . '>';
            $team_member .= "\n\t\t\t\t" . '<div class="content-wrapper">';
            $team_member .= "\n\t\t\t\t\t" . '<div class="content-item">';
            $team_member .= "\n\t\t\t\t\t\t" . team_grid_item($post->ID, $add_bio, $bio_type);
            $team_member .= "\n\t\t\t\t\t" . '</div>';
            $team_member .= "\n\t\t\t\t" . '</div>';
            $team_member .= "\n\t\t\t" . '</div>';

            $output .= $team_member;
        }
        $output .= (!empty($bios)) ? "\n\t\t\t" . '<div class="d-none">' . $bios . '</div><!-- end .team-bios-->' : '';
        $output .= "\n\t\t" . '</div><!-- end .row-->';
        $output .= "\n\t" . '</div><!-- end .container-fluid-->';
        $output .= "\n" . '</div>' . $end_comment;

        wp_reset_postdata();
        return $output;
    }
} // End Element Class

// Element Class Init
new maatTeamGrid();
