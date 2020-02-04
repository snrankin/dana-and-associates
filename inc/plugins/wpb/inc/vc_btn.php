<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  6-29-19
 * Last Modified: 7-10-19 at 12:14 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */
$elem = 'vc_btn';

$removeAtts = array(
    'shape',
    'css_editor',
);
maatRemoveAtts($elem, $removeAtts);

$color_value = array_merge(array(
    // Btn1 Colors
    esc_html__('Default', 'js_composer')         => '',
    esc_html__('Primary Color', 'js_composer')   => 'primary',
    esc_html__('Secondary Color', 'js_composer') => 'secondary',
    esc_html__('Tertiary Color', 'js_composer')  => 'tertiary',
    esc_html__('Danger Color', 'js_composer')    => 'danger',
    esc_html__('Warning Color', 'js_composer')   => 'warning',
    esc_html__('Info Color', 'js_composer')      => 'info',
    esc_html__('Success Color', 'js_composer')   => 'success',
    esc_html__('Dark Color', 'js_composer')      => 'dark',
    esc_html__('Light Color', 'js_composer')     => 'light',
    esc_html__('White', 'js_composer')           => 'white',
    // + Btn2 Colors (default color set)
), vc_get_shared('colors-dashed'));

$updatedAtts = array(
    array(
        'type'               => 'dropdown',
        'heading'            => esc_html__('Color', 'js_composer'),
        'param_name'         => 'color',
        'description'        => esc_html__('Select button color.', 'js_composer'),
        // compatible with btn2, need to be converted from btn1
         'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
        'value'              => $color_value,
        'std'                => 'default',
        // must have default color grey
         'dependency'         => array(
            'element'            => 'style',
            'value_not_equal_to' => array(
                'custom',
                'outline-custom',
                'gradient',
                'gradient-custom',
            ),
        ),
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => __('Style', 'js_composer'),
        'description' => __('Select button display style.', 'js_composer'),
        'param_name'  => 'style',
        // partly compatible with btn2, need to be converted shape+style from btn2 and btn1
         'value'       => array(
            esc_html__('Solid', 'js_composer')           => '',
            esc_html__('Outline', 'js_composer')         => 'outline',
            esc_html__('Custom', 'js_composer')          => 'custom',
            esc_html__('Outline custom', 'js_composer')  => 'outline-custom',
            esc_html__('Gradient', 'js_composer')        => 'gradient',
            esc_html__('Gradient Custom', 'js_composer') => 'gradient-custom',
        ),
    ),
    array(
        'type'               => 'dropdown',
        'heading'            => esc_html__('Color', 'js_composer'),
        'param_name'         => 'color',
        'description'        => esc_html__('Select button color.', 'js_composer'),
        // compatible with btn2, need to be converted from btn1
         'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
        'value'              => $color_value,
        'std'                => 'grey',
        // must have default color grey
         'dependency'         => array(
            'element'            => 'style',
            'value_not_equal_to' => array(
                'custom',
                'outline-custom',
                'gradient',
                'gradient-custom',
            ),
        ),
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Alignment', 'js_composer'),
        'param_name'  => 'align',
        'description' => esc_html__('Select button alignment.', 'js_composer'),
        // compatible with btn2, default left to be compatible with btn1
         'value'       => array(
            esc_html__('Inline', 'js_composer') => 'd-inline-flex',
            // default as well
            esc_html__('Left', 'js_composer')   => 'left',
            // default as well
            esc_html__('Right', 'js_composer')  => 'right',
            esc_html__('Center', 'js_composer') => 'center',
        ),
    ),
    array(
        'type'        => 'dropdown',
        'heading'     => esc_html__('Icon', 'js_composer'),
        'description' => esc_html__('Select icon library or enter custom classes', 'js_composer'),
        'param_name'  => 'i_type',
        // partly compatible with btn2, need to be converted shape+style from btn2 and btn1
         'value'       => array(
            esc_html__('Font Awesome', 'js_composer') => 'fontawesome',
            esc_html__('Open Iconic', 'js_composer')  => 'openiconic',
            esc_html__('Typicons', 'js_composer')     => 'typicons',
            esc_html__('Linecons', 'js_composer')     => 'linecons',
            esc_html__('Mono Social', 'js_composer')  => 'monosocial',
            esc_html__('Material', 'js_composer')     => 'material',
            esc_html__('Pixel', 'js_composer')        => 'pixelicons',
            esc_html__('Entypo', 'js_composer')       => 'entypo',
            esc_html__('Custom Icon', 'js_composer')  => 'custom',
        ),
    ),
    array(
        'type'       => 'textfield',
        'heading'    => esc_html__('Custom Icon Class', 'js_composer'),
        'param_name' => 'custom_i_class',
        'dependency' => array(
            'element' => 'i_type',
            'value'   => array('custom'),
        ),
    ),
);
maatUpdatedAtts($elem, $updatedAtts);

$newAtts = array(
    array(
        'type'        => 'checkbox',
        'heading'     => __('Make link a popup', 'maat'),
        'param_name'  => 'fancybox',
        'description' => __('Add Fancybox to link', 'maat'),
        'value'       => array(__('Yes', 'maat') => 'yes'),
    ),
);
maatAddAtts($elem, $newAtts);
