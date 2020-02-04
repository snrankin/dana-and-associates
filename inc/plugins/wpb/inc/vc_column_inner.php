<?php

/** ===========================================================================
 * Description
 * @package Maat Legal Theme
 * @version 0.9.0
 * -----
 * @author Sam Rankin (sam@maatlegal.com>)
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date: 4-10-19
 * Last Modified: 6-14-19 at 6:14 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * @link https://kb.wpbakery.com/docs/inner-api/vc_map/
 * -----
 * HISTORY:
 * Date    	By	Comments
 * --------	--	--------------------------------------------------------------
 * ========================================================================= */

$elem = 'vc_column_inner';

// $removeAtts = array(
//     'gap',
//     'columns_placement',
//     'equal_height',
//     'rtl_reverse',
//     'content_placement',
//     'full_width',
//     'full_height',
//     'css_editor'
// );
// maatRemoveAtts($elem, $removeAtts);

$newAtts = array(
    array(
        'type' => 'textfield',
        'heading' => 'Column Inner Class',
        'param_name' => 'inner_class',
        'value' => '',
        'weight' => '3',
        'description' => __('Class for the inner container of a column', 'maat')
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
    array(
        'type' => 'attach_image',
        'heading' => __('Background Image', 'maat'),
        'param_name' => 'bg_image',
        'value' => '',
        'description' => __('Select image from media library.', 'maat'),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __('Background Image Horizontal Position', 'maat'),
        'param_name' => 'bg_image_h_position',
        'value' => array(
            __('Center', 'maat') => 'center',
            __('Left', 'maat') => 'left',
            __('Right', 'maat') => 'right',
        ),
        'description' => __('Background position along x-axis', 'maat'),
        'dependency' => array(
            'element' => 'bg_image',
            'not_empty' => true,
        ),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __('Background Image Vertical Position', 'maat'),
        'param_name' => 'bg_image_v_position',
        'value' => array(
            __('Center', 'maat') => 'center',
            __('Bottom', 'maat') => 'bottom',
            __('Top', 'maat') => 'top',
        ),
        'description' => __('Background position along y-axis', 'maat'),
        'dependency' => array(
            'element' => 'bg_image',
            'not_empty' => true,
        ),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __('Background Color', 'maat'),
        'param_name' => 'bg_color',
        'value' => array(
            __('None', 'maat')         => '',
            __('Primary', 'maat')   => 'bg-primary',
            __('Secondary', 'maat') => 'bg-secondary',
            __('Tertiary', 'maat')  => 'bg-tertiary',
            __('Success', 'maat')   => 'bg-success',
            __('Danger', 'maat')    => 'bg-danger',
            __('Warning', 'maat')   => 'bg-warning',
            __('Info', 'maat')      => 'bg-info',
            __('Light', 'maat')     => 'bg-light',
            __('Dark', 'maat')      => 'bg-dark',
            __('Gray 100', 'maat')  => 'bg-gray-100',
            __('Gray 200', 'maat')  => 'bg-gray-200',
            __('Gray 300', 'maat')  => 'bg-gray-300',
            __('Gray 400', 'maat')  => 'bg-gray-400',
            __('Gray 500', 'maat')  => 'bg-gray-500',
            __('Gray 600', 'maat')  => 'bg-gray-600',
            __('Gray 700', 'maat')  => 'bg-gray-700',
            __('Gray 800', 'maat')  => 'bg-gray-800',
            __('Gray 900', 'maat')  => 'bg-gray-900',
            __('Custom', 'maat')    => 'custom',

        ),
        'description' => __('Choose a background color from the theme colors', 'maat'),
    ),
    array(
        'type' => 'textfield',
        'heading' => __('Background Color Opacity', 'maat'),
        'param_name' => 'bg_opacity',
        'value' => '100%',
        'description' => __('Enter background color opacity from 1 - 100%', 'maat'),
        'dependency' => array(
            'element' => 'bg_color',
            'not_empty' => true,
        ),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __('Content Vertical Alignment', 'maat'),
        'param_name' => 'content_v_align',
        'value' => array(
            __('Default', 'maat') => '',
            __('Top', 'maat') => 'justify-content-start',
            __('Middle', 'maat') => 'justify-content-center',
            __('Bottom', 'maat') => 'justify-content-end',
            __('Distributed with space', 'maat') => 'justify-content-around',
            __('Distributed with no space', 'maat') => 'justify-content-between',
        ),
        'description' => __('Flexbox property: justify-content', 'maat'),
    ),
    array(
        'type' => 'dropdown',
        'heading' => __('Content Horizontal Alignment', 'maat'),
        'param_name' => 'content_h_align',
        'value' => array(
            __('Default', 'maat') => '',
            __('Left', 'maat') => 'align-items-start',
            __('Right', 'maat') => 'align-items-end',
            __('Middle', 'maat') => 'align-items-center',
            __('Full Width', 'maat') => 'align-items-stretch',
        ),
        'description' => __('Flexbox property: align-items', 'maat'),
    ),
);
maatAddAtts($elem, $newAtts);

$updatedAtts = array(
    array(
        'param_name' => 'el_class',
        'heading' => __('Column Outer Class', 'maat'),
        'weight' => '2',
    ),
    array(
        'param_name' => 'el_id',
        'weight' => '1',
    ),
);
maatUpdatedAtts($elem, $updatedAtts);
