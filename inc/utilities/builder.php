<?php
/*
 * Copyright (c) 2018 snrankin
 *
 * @Script: functions.php
 * @Author: snrankin
 * @Email: snrankin@me.com
 * @Create At: 2018-05-29 16:19:27
 * @Last Modified By: snrankin
 * @Last Modified At: 2018-06-05 09:33:56
 * @Description: This is description.
 */

function create_layout_tab($args = array())
{

    $defaults = array(
        'label' => 'Tab',
        'item' => '',
        'key' => '',
        'class' => '',
        'placement' => 'top',
        'section' => '',
        'parent' => '',
        'parent_layout' => '',
    );

    $options = array_merge($defaults, $args);
    $label = $options['label'];
    $item = to_snake_case($options['item']);
    $section = to_snake_case($options['section']);
    $key = $section . '_' . $item . '_' . to_snake_case($label) . '_tab';
    $class = $options['class'];
    $placement = $options['placement'];
    $parent = 'field_' . $options['parent'];
    $layout = 'layout_' . $options['parent_layout'];

    $fields = array(
        'key' => $key,
        'label' => $label,
        'type' => 'tab',
        'placement' => $placement,
    );

    if (!empty($class)) {
        $fields['wrapper'] = array('class' => $class);
    }

    if (!empty($options['parent'])) {
        $fields['parent'] = $parent;
    }

    if (!empty($options['parent_layout'])) {
        $fields['parent_layout'] = $layout;
    }

    return $fields;
}

function maat_create_field($args = array())
{

    $defaults = array(
        'label' => '',
        'type' => '',
        'key' => uniqid('', true),
        'width' => '',
        'class' => '',
        'display' => 'block',
        'section' => '',
        'parent' => '',
        'layout' => '',
        'fields' => array(),
    );

    $options = array_merge($defaults, $args);
    $label = $options['label'];
    $type = $options['type'];
    $section = to_snake_case($options['section']);
    $key = to_snake_case($options['key']);
    $width = $options['width'];
    $class = $options['class'];
    $display = $options['display'];
    $parent = 'field_' . $options['parent'];
    $layout = 'layout_' . $options['layout'];
    $sub_fields = $options['fields'];


    $fields = array(
        'key' => 'field' . $section . '_' . $key,
        'label' => $label,
        'name' => $key,
        'type' => $type,
    );

    if (!empty($class)) {
        $fields['wrapper'] = array('class' => $class);
    }

    if (!empty($width)) {
        $fields['wrapper'] = array('width' => $width);
    }

    if (!empty($display)) {
        $fields['layout'] = $display;
    }

    if (!empty($options['parent'])) {
        $fields['parent'] = $parent;
    }

    if (!empty($options['layout'])) {
        $fields['parent_layout'] = $layout;
    }

    $all_fields = array_merge($fields, $sub_fields);

    return $all_fields;
}

function maat_create_layout_field($args = array())
{

    $defaults = array(
        'title' => '',
        'section' => '',
        'sub_fields' => array(),
    );

    $options = array_merge($defaults, $args);
    $title = $options['title'];
    $section = to_snake_case($options['section']);
    $key = to_snake_case($title);
    $parent_layout = $section . '_' . $key;
    $parent = $section . '_column_content';
    $fields = $options['sub_fields'];

    $all_fields = array();

    $all_fields[] = create_layout_tab(array(
        'label' => 'Content',
        'item' => $key,
        'section' => $section,
        'parent_layout' => $parent_layout,
        'parent' => $parent,
    ));

    foreach ($fields as $field) {
        $old_key = ltrim($field['key'], 'field_');
        $field['key'] = 'field_' . $section . '_' . $key . '_' . $old_key;
        $field['parent'] = 'field_' . $parent;
        $field['parent_layout'] = 'layout_' . $parent_layout;
        $all_fields[] = $field;
    }

    $settings = add_settings_options(array(
        'item' => $key,
        'section' => $section,
        'parent_layout' => $parent_layout,
        'parent' => $parent,
    ));

    foreach ($settings as $setting) {
        $all_fields[] = $setting;
    }

    // $all_fields[] = create_layout_tab(array(
    //     'label'         => 'Styles',
    //     'item'          => $key,
    //     'section'       => $section,
    //     'parent_layout' => $section . '_' . $key,
    //     'parent'        => $section . '_' . $key,
    //     'class'         => 'styles-tab',
    // ));

    return $all_fields;
}

function maat_register_layout($item, $fields)
{
    $builders = builder_locations();
    $all_fields = array();
    $layouts = array();
    $layout_fields = array();
    foreach ($fields as $field) {
        $layout_fields[] = $field;
    }
    foreach ($builders as $builder) {
        $section_key = to_snake_case($builder);
        $layout = maat_create_layout_field(array(
            'title' => $item,
            'section' => $builder,
            'sub_fields' => $layout_fields,
        ));
        $layouts[] = $layout;
    }
    foreach ($layouts as $layout) {
        $fields = $layout;
        foreach ($fields as $field) {
            $all_fields[] = $field;
        }
    }
    //return $all_fields;
    acf_add_local_field($all_fields);
}

function get_layout($layout, $item)
{
    $first = str_replace('layout_', '', $layout);
    $second = str_replace('_' . $item, '', $first);

    return $second;
}

function add_animation_options($item_name, $parent, $parent_layout)
{

    $animation = array(
        'key' => 'field_' . $item_name . '_animation',
        'label' => 'Animation',
        'name' => $item_name . '_animation',
        'type' => 'group',
        'layout' => 'block',
        'wrapper' => array(
            'class' => 'col-12',
        ),
        'sub_fields' => array(
            array(
                'key' => 'field_' . $item_name . '_animation_effect',
                'label' => 'Animation Effect',
                'name' => 'animation_effect',
                'type' => 'select',
                'wrapper' => array(
                    'class' => 'col-lg-3',
                ),
                'choices' => array(
                    'bounce' => 'Bounce',
                    'flash' => 'Flash',
                    'pulse' => 'Pulse',
                    'rubberBand' => 'Rubber Band',
                    'shake' => 'Shake',
                    'swing' => 'Swing',
                    'tada' => 'Ta Da',
                    'wobble' => 'Wobble',
                    'jello' => 'Jello',
                    'bounceIn' => 'Bounce In',
                    'bounceInDown' => 'Bounce In Down',
                    'bounceInLeft' => 'Bounce In Left',
                    'bounceInRight' => 'Bounce In Right',
                    'bounceInUp' => 'Bounce In Up',
                    'bounceOut' => 'Bounce Out',
                    'bounceOutDown' => 'Bounce Out Down',
                    'bounceOutLeft' => 'Bounce Out Left',
                    'bounceOutRight' => 'Bounce Out Right',
                    'bounceOutUp' => 'Bounce Out Up',
                    'fadeIn' => 'Fade In',
                    'fadeInDown' => 'Fade In Down',
                    'fadeInDownBig' => 'Fade In Down Big',
                    'fadeInLeft' => 'Fade In Left',
                    'fadeInLeftBig' => 'Fade In Left Big',
                    'fadeInRight' => 'Fade In Right',
                    'fadeInRightBig' => 'Fade In Right Big',
                    'fadeInUp' => 'Fade In Up',
                    'fadeInUpBig' => 'Fade In Up Big',
                    'fadeOut' => 'Fade Out',
                    'fadeOutDown' => 'Fade Out Down',
                    'fadeOutDownBig' => 'Fade Out Down Big',
                    'fadeOutLeft' => 'Fade Out Left',
                    'fadeOutLeftBig' => 'Fade Out Left Big',
                    'fadeOutRight' => 'Fade Out Right',
                    'fadeOutRightBig' => 'Fade Out Right Big',
                    'fadeOutUp' => 'Fade Out Up',
                    'fadeOutUpBig' => 'Fade Out Up Big',
                    'flipInX' => 'Flip In X Axis',
                    'flipInY' => 'Flip In Y Axis',
                    'flipOutX' => 'Flip Out X Axis',
                    'flipOutY' => 'Flip Out Y Axis',
                    'lightSpeedIn' => 'Light Speed In',
                    'lightSpeedOut' => 'Light Speed Out',
                    'rotateIn' => 'Rotate In',
                    'rotateInDownLeft' => 'Rotate In Down Left',
                    'rotateInDownRight' => 'Rotate In Down Right',
                    'rotateInUpLeft' => 'Rotate In Up Left',
                    'rotateInUpRight' => 'Rotate In Up Right',
                    'rotateOut' => 'Rotate Out',
                    'rotateOutDownLeft' => 'Rotate Out Down Left',
                    'rotateOutDownRight' => 'Rotate Out Down Right',
                    'rotateOutUpLeft' => 'Rotate Out Up Left',
                    'rotateOutUpRight' => 'Rotate Out Up Right',
                    'hinge' => 'Hinge',
                    'rollIn' => 'Roll In',
                    'rollOut' => 'Roll Out',
                    'zoomIn' => 'Zoom In',
                    'zoomInDown' => 'Zoom In Down',
                    'zoomInLeft' => 'Zoom In Left',
                    'zoomInRight' => 'Zoom In Right',
                    'zoomInUp' => 'Zoom In Up',
                    'zoomOut' => 'Zoom Out',
                    'zoomOutDown' => 'Zoom Out Down',
                    'zoomOutLeft' => 'Zoom Out Left',
                    'zoomOutRight' => 'Zoom Out Right',
                    'zoomOutUp' => 'Zoom Out Up',
                    'slideInDown' => 'Slide In Down',
                    'slideInLeft' => 'Slide In Left',
                    'slideInRight' => 'Slide In Right',
                    'slideInUp' => 'Slide In Up',
                    'slideOutDown' => 'Slide Out Down',
                    'slideOutLeft' => 'Slide Out Left',
                    'slideOutRight' => 'Slide Out Right',
                    'slideOutUp' => 'Slide Out Up',
                ),
                'ui' => 1,
                'ajax' => 1,
            ),
            array(
                'key' => 'field_' . $item_name . '_animation_duration',
                'label' => 'Animation Duration',
                'name' => 'animation_duration',
                'type' => 'number',
                'wrapper' => array(
                    'class' => 'col-lg-3',
                ),
                'append' => 'seconds',
                'min' => 0,
            ),
            array(
                'key' => 'field_' . $item_name . '_animation_delay',
                'label' => 'Animation Delay',
                'name' => 'animation_delay',
                'type' => 'number',
                'wrapper' => array(
                    'class' => 'col-lg-3',
                ),
                'append' => 'seconds',
                'min' => 0,
            ),
            array(
                'key' => 'field_' . $item_name . '_animation_offset',
                'label' => 'Animation Offset',
                'name' => 'animation_offset',
                'type' => 'number',
                'wrapper' => array(
                    'class' => 'col-lg-3',
                ),
                'append' => 'pixels',
            ),
        ),
    );

    if (!empty($parent)) {
        $animation['parent'] = 'field_' . $parent;
    }

    if (!empty($parent_layout)) {
        $animation['parent_layout'] = 'layout_' . $parent_layout;
    }

    return $animation;
}

function add_settings_options($args = array())
{

    $defaults = array(
        'item' => '',
        'parent' => '',
        'parent_layout' => '',
        'section' => '',
        'sub_fields' => array(),
    );

    $options = array_merge($defaults, $args);
    $item = to_snake_case($options['item']);
    $section = $options['section'];
    $key = $section . '_' . $item;
    $parent = 'field_' . $options['parent'];
    $layout = 'layout_' . $options['parent_layout'];
    $fields = $options['sub_fields'];

    $all_fields = array();
    $sub_fields = array();

    $settings_tab = create_layout_tab(array(
        'label' => 'Settings',
        'key' => $key . '_settings_tab',
        'item' => $item,
        'class' => 'acf-settings-tab',
        'section' => $section,
        'parent' => $options['parent'],
        'parent_layout' => $options['parent_layout'],
    ));

    $all_fields[] = $settings_tab;

    $id = maat_create_field(array(
        'label' => 'ID',
        'type' => 'text',
        'key' => $key . '_id',
        'class' => 'col',
    ));

    $sub_fields[] = $id;

    $class = maat_create_field(array(
        'label' => 'Class',
        'type' => 'text',
        'key' => $key . '_class',
        'class' => 'col',
    ));

    $sub_fields[] = $class;

    if (!empty($fields)) {
        foreach ($fields as $field) {
            $sub_fields[] = $field;
        }
    }

    $settings = maat_create_field(array(
        'label' => 'Settings',
        'type' => 'group',
        'key' => $key . '_settings',
        'fields' => array(
            'sub_fields' => $sub_fields,
        ),
    ));

    if (!empty($options['parent'])) {
        $settings_tab['parent'] = $parent;
        $settings['parent'] = $parent;
    }

    if (!empty($options['parent_layout'])) {
        $settings_tab['parent_layout'] = $layout;
        $settings['parent_layout'] = $layout;
    }

    $all_fields[] = $settings;

    return $all_fields;
}

function add_link_options($item_slug, $conditions = 1)
{

    $sub_fields = array();

    $sub_fields[] = maat_create_field(array(
        'label' => 'Link Type',
        'type' => 'select',
        'key' => $item_slug . '_link_type',
        'fields' => array(
            'choices' => array(
                'internal' => 'Internal',
                'external' => 'External',
                'anchor' => 'Page Anchor',
                'modal' => 'Modal (Pop Up)',
            ),
            'wrapper' => array(
                'class' => 'col-lg-3',
            ),
            'allow_null' => 0,
        ),
    ));

    $sub_fields[] = maat_create_field(array(
        'label' => 'Internal Link',
        'type' => 'page_link',
        'key' => $item_slug . '_internal_link',
        'fields' => array(
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_' . $item_slug . '_link_type',
                        'operator' => '==',
                        'value' => 'internal',
                    ),
                ),
            ),
            'wrapper' => array(
                'class' => 'col-lg-9',
            ),
            'allow_archives' => 1,
        ),
    ));

    $sub_fields[] = maat_create_field(array(
        'label' => 'External Link',
        'type' => 'link',
        'key' => $item_slug . '_external_link',
        'fields' => array(
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_' . $item_slug . '_link_type',
                        'operator' => '==',
                        'value' => 'external',
                    ),
                ),
            ),
            'wrapper' => array(
                'class' => 'col-lg-9',
            ),
            'return_format' => 'url',
        ),
    ));

    $sub_fields[] = maat_create_field(array(
        'label' => 'Anchor ID',
        'type' => 'text',
        'key' => $item_slug . '_anchor_link',
        'fields' => array(
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_' . $item_slug . '_link_type',
                        'operator' => '==',
                        'value' => 'anchor',
                    ),
                ),
            ),
            'wrapper' => array(
                'class' => 'col-lg-9',
            ),
            'prepend' => '#',
        ),
    ));

    $sub_fields[] = maat_create_field(array(
        'label' => 'Modal ID',
        'type' => 'post_object',
        'key' => $item_slug . '_modal_link',
        'fields' => array(
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_' . $item_slug . '_link_type',
                        'operator' => '==',
                        'value' => 'modal',
                    ),
                ),
            ),
            'post_type' => array(
                0 => 'modal',
            ),
            'return_format' => 'id',
        ),
    ));

    $fields = array(
        'sub_fields' => $sub_fields,
        'wrapper' => array(
            'class' => 'col-12',
        ),
    );

    if ($conditions = 1) {
        $fields['conditional_logic'] = array(
            array(
                array(
                    'field' => 'field_add_' . $item_slug . '_link',
                    'operator' => '==',
                    'value' => 1,
                ),
            ),
        );
    }

    $link_options = maat_create_field(array(
        'label' => 'Link Options',
        'type' => 'group',
        'key' => $item_slug . '_link',
        'layout' => $item_slug,
        'fields' => $fields,
    ));

    return $link_options;
}

function build_link_wrapper($args = array())
{

    $defaults = array(
        'id' => '',
        'parent' => '',
        'classes' => array(),
        'content' => '',
        'link_type' => '',
        'link' => '',
    );

    $options = array_merge($defaults, $args);
    $id = $options['id'];
    $parent = to_snake_case($options['parent']);
    $parent_item = $parent . '_link';
    $link_type = $options['link_type'];
    $link_value = $options['link'];
    $content = $options['content'];
    $classes = $options['classes'];

    $link = '<a ';

    if ($link_type === 'internal') {
        $link .= 'href="' . $link_value . '"';
    } else if ($link_type === 'external') {
        $link .= 'href="' . $link_value . '" target="_blank"';
    } else if ($link_type === 'anchor') {
        $link .= 'href="#' . $link_value . '"';
    } else if ($link_type === 'modal') {
        $link .= 'href data-toggle="modal" data-target="#' . $link_value . '"';
    }

    $link .= (!empty($classes)) ? ' ' . maat_add_item_classes($classes) : '';

    $link .= '>';

    $link .= $content;

    $link .= '</a>';

    return $link;
}

function add_video_options($args = array())
{
    $defaults = array(
        'item' => '',
        'parent' => '',
        'layout' => '',
        'conditions' => array(),
    );

    $options = array_merge($defaults, $args);
    $item = $options['item'];
    $key = to_snake_case($options['item']);
    $parent = 'field_' . $options['parent'];
    $layout = 'layout_' . $options['layout'];
    $conditions = array($options['conditions']);
    $sub_fields = array();

    $sub_fields[] = maat_create_field(array(
        'label' => 'Video Source',
        'type' => 'select',
        'key' => $key . '_video_source',
        'class' => 'col-lg-3',
        'fields' => array(
            'choices' => array(
                'internal' => 'Internal File',
                'external' => 'External File (YouTube, Vimeo etc)',
            ),
        ),
    ));

    $internal_files = maat_create_field(array(
        'label' => 'Source File',
        'type' => 'file',
        'key' => $key . '_src_url',
        'fields' => array(
            'return_format' => 'array',
            'mime_types' => 'mp4, webm, ogv, ogg',
        ),
    ));

    $sub_fields[] = maat_create_field(array(
        'label' => 'Internal File',
        'type' => 'repeater',
        'key' => $key . '_internal_src',
        'class' => 'col-lg-9',
        'fields' => array(
            'max' => 3,
            'button_label' => 'Add File',
            'sub_fields' => array(
                $internal_files
            ),
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_' . $key . '_video_source',
                        'operator' => '==',
                        'value' => 'internal',
                    ),
                ),
            ),
        ),
    ));

    $sub_fields[] = maat_create_field(array(
        'label' => 'Linked Video',
        'type' => 'oembed',
        'key' => $key . '_external_src',
        'class' => 'col-lg-9',
        'fields' => array(
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_' . $key . '_video_source',
                        'operator' => '==',
                        'value' => 'external',
                    ),
                ),
            ),
        ),
    ));

    $video_bg = maat_create_field(array(
        'label' => 'Background Video',
        'type' => 'group',
        'key' => $key . '_bg_video',
        'fields' => array(
            'sub_fields' => $sub_fields,
        ),
    ));

    if (!empty($options['parent'])) {
        $video_bg['parent'] = $parent;
    }

    if (!empty($options['layout'])) {
        $video_bg['layout'] = $layout;
    }

    if (!empty($options['conditions'])) {
        $video_bg['conditional_logic'] = $conditions;
    }

    return $video_bg;
}

function add_bg_color_options($args = array())
{

    $defaults = array(
        'item' => '',
        'parent' => '',
        'layout' => '',
        'conditions' => array(),
    );

    $options = array_merge($defaults, $args);
    $item = $options['item'];
    $key = to_snake_case($options['item']);
    $parent = 'field_' . $options['parent'];
    $layout = 'layout_' . $options['layout'];
    $conditions = $options['conditions'];
    $sub_fields = array();

    $theme_color = maat_create_field(array(
        'label' => 'Color',
        'type' => 'select',
        'key' => $key . '_bg_theme_color',
        'fields' => array(
            'choices' => bg_color_list(),
        ),
    ));

    $sub_fields[] = $theme_color;

    $custom_color = maat_create_field(array(
        'label' => 'Custom Color',
        'type' => 'color_picker',
        'key' => $key . '_custom_bg_color',
        'class' => 'col-md-9',
        'fields' => array(
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_' . $key . '_bg_theme_color',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ),
            ),
        )
    ));

    $sub_fields[] = $custom_color;

    $color_bg = maat_create_field(array(
        'label' => 'Background Color',
        'type' => 'group',
        'key' => $key . '_bg_color',
        'fields' => array(
            'sub_fields' => $sub_fields,
        ),
    ));

    if (!empty($options['parent'])) {
        $color_bg['parent'] = $parent;
    }

    if (!empty($options['layout'])) {
        $color_bg['layout'] = $layout;
    }

    if (!empty($options['conditions'])) {
        $color_bg['conditional_logic'] = $conditions;
    }

    return $color_bg;
}

function add_image_options($args = array())
{
    $defaults = array(
        'item' => '',
        'parent' => '',
        'layout' => '',
        'conditions' => array(),
    );

    $options = array_merge($defaults, $args);
    $item = $options['item'];
    $key = to_snake_case($options['item']);
    $parent = 'field_' . $options['parent'];
    $layout = 'layout_' . $options['layout'];
    $conditions = $options['conditions'];
    $sub_fields = array();

    $image = maat_create_field(array(
        'label' => 'Image',
        'type' => 'image',
        'key' => $key . '_image',
        'class' => 'col-lg-4'
    ));

    $sub_fields[] = $image;

    $overlay_color = maat_create_field(array(
        'label' => 'Overlay Color',
        'type' => 'color_picker',
        'key' => $key . '_overlay_color',
        'class' => 'col-lg-4'
    ));

    $sub_fields[] = $overlay_color;

    $overlay_opacity = maat_create_field(array(
        'label' => 'Overlay Color',
        'type' => 'range',
        'key' => $key . '_overlay_opacity',
        'class' => 'col-lg-4'
    ));

    $sub_fields[] = $overlay_opacity;

    $vertical_position = maat_create_field(array(
        'label' => 'Vertical Position',
        'type' => 'select',
        'key' => $key . '_vertical_position',
        'class' => 'col-md-6',
        'fields' => array(
            'choices' => array(
                'center' => 'Center',
                'top' => 'Top',
                'bottom' => 'Bottom',
            ),
        ),
    ));

    $sub_fields[] = $vertical_position;

    $horizontal_position = maat_create_field(array(
        'label' => 'Horizontal Position',
        'type' => 'select',
        'key' => $key . '_horizontal_position',
        'class' => 'col-md-6',
        'fields' => array(
            'choices' => array(
                'center' => 'Center',
                'left' => 'Left',
                'right' => 'Right',
            ),
        ),
    ));

    $sub_fields[] = $horizontal_position;

    $image_bg = maat_create_field(array(
        'label' => 'Background Image',
        'type' => 'group',
        'key' => $key . '_bg_image',
        'fields' => array(
            'sub_fields' => $sub_fields,
        ),
    ));

    if (!empty($options['parent'])) {
        $image_bg['parent'] = $parent;
    }

    if (!empty($options['layout'])) {
        $image_bg['layout'] = $layout;
    }

    if (!empty($options['conditions'])) {
        $image_bg['conditional_logic'] = $conditions;
    }

    return $image_bg;
}

function add_bg_options($args = array())
{
    $defaults = array(
        'item' => '',
        'parent' => '',
        'parent_layout' => '',
        'section' => '',
        'sub_fields' => array(),
    );

    $options = array_merge($defaults, $args);
    $item = to_snake_case($options['item']);
    $section = $options['section'];
    $key = $section . '_' . $item;
    $parent = 'field_' . $options['parent'];
    $layout = 'layout_' . $options['parent_layout'];
    $fields = $options['sub_fields'];

    $sub_fields = array();

    $sub_fields[] = maat_create_field(array(
        'label' => 'Background Type',
        'type' => 'select',
        'key' => $key . '_bg_type',
        'fields' => array(
            'allow_null' => 1,
            'choices' => array(
                'image' => 'Image',
                'color' => 'Color',
                'video' => 'Video',
                'parallax' => 'Parallax',
            ),
        ),
    ));

    $color_conditions = array(
        array(
            array(
                'field' => 'field_' . $key . '_bg_type',
                'operator' => '==',
                'value' => 'color',
            ),
        ),
    );

    $sub_fields[] = $color = add_bg_color_options(array('item' => $key, 'conditions' => $color_conditions));

    $image_conditions = array(
        array(
            array(
                'field' => 'field_' . $key . '_bg_type',
                'operator' => '==',
                'value' => 'image',
            ),
        ),
        array(
            array(
                'field' => 'field_' . $key . '_bg_type',
                'operator' => '==',
                'value' => 'video',
            ),
        ),
        array(
            array(
                'field' => 'field_' . $key . '_bg_type',
                'operator' => '==',
                'value' => 'parallax',
            ),
        ),
    );

    $sub_fields[] = add_image_options(array('item' => $key, 'conditions' => $image_conditions));

    $video_conditions = array(
        array(
            'field' => 'field_' . $key . '_bg_type',
            'operator' => '==',
            'value' => 'video',
        ),
    );

    $sub_fields[] = add_video_options(array('item' => $key, 'conditions' => $video_conditions));

    if (!empty($fields)) {
        foreach ($fields as $field) {
            $sub_fields[] = $field;
        }
    }

    $bg_options = maat_create_field(array(
        'label' => 'Background Styles',
        'type' => 'group',
        'key' => $key . '_bg',
        'fields' => array(
            'sub_fields' => $sub_fields,
        ),
    ));

    if (!empty($options['parent'])) {
        $bg_options['parent'] = $parent;
    }

    if (!empty($options['layout'])) {
        $bg_options['layout'] = $layout;
    }

    return $bg_options;
}

function add_bg($item_name)
{

    $bg_styles = get_sub_field($item_name . '_bg');

    $bg_type = $bg_styles[$item_name . '_bg_type'];

    $bg_image = $bg_styles[$item_name . '_bg_image'];
    $bg_video = $bg_styles[$item_name . '_bg_video'];
    $bg_color = $bg_styles[$item_name . '_bg_color'][$item_name . '_bg_theme_color'];
    //$bg_parallax = $bg_styles[$item_name . '_bg_parallax'];

    $bg_overlay_color = $bg_image[$item_name . '_overlay_color'];
    $bg_overlay_opacity = $bg_image[$item_name . '_overlay_opacity'];

    $bg_video_urls = array();

    $files = $bg_video[$item_name . '_internal_src'];

    $bg = array(
        'classes' => array(),
        'styles' => array(),
        'data' => array(),
        'video' => array(),
    );

    if (!empty($bg_type)) {
        array_push($bg['classes'], 'has-bg');
        if ($bg_type === 'video') {
            array_push($bg['classes'], 'bg-video');
            $src = $bg_video[$item_name . '_video_source'];

            if ($src === 'internal') {

                if (!empty($files)) :

                    foreach ($files as $file) {
                        $videos = array(
                            'url' => $file[$item_name . '_src_url']['url'],
                            'type' => $file[$item_name . '_src_url']['mime_type'],
                        );
                        array_push($bg['video'], $videos);
                    }

                endif;
            } elseif ($src === 'external') {
                $video .= '<div class="bg-video-item embed-responsive">';
                if (!empty($bg_video[$item_name . '_external_src'])) :
                    $video .= $bg_video[$item_name . '_external_src'];
                endif;
                $video .= '</div>';
            }
        }
        if ($bg_type === 'image' || $bg_type === 'video' || $bg_type === 'parallax') {
            array_push($bg['classes'], 'test');
            $src = $bg_image[$item_name . '_image'];
            if (!empty($src['url'])) {
                $bg['styles']['background-image'] = 'url(' . $src['url'] . ')';
                $bg['styles']['background-size'] = 'cover';
                $bg['styles']['background-position'] = $bg_image[$item_name . '_vertical_position'] . ' ' . $bg_image[$item_name . '_horizontal_position'];
            }
            if (!empty($bg_overlay_color)) {
                $bg['overlay'] = 'rgba(' . hex2rgba($overlay_color, $overlay_opacity) . ')';
            }
        } else if ($bg_type === 'color') {
            if ($bg_color !== 'custom') {
                array_push($bg['classes'], 'bg-' . $bg_color);
            } else {
                $$bg['styles']['background-color'] = $bg_styles[$item_name . '_bg_color'][$item_name . '_custom_bg_color'];
            }
        }
    }
    return $bg;
}

function build_item_wrapper($args = array())
{

    $defaults = array(
        'id' => '',
        'classes' => '',
        'styles' => '',
        'data' => '',
    );

    $options = array_merge($defaults, $args);
    $id = $options['id'];
    $classes = $options['classes'];
    $styles = $options['styles'];
    $data = $options['data'];

    $wrapper = '';
    $wrapper .= (!empty($id)) ? 'id="' . sanitize_html_class($id) . '" ' : '';
    $wrapper .= (!empty($classes)) ? maat_add_item_classes($classes) . ' ' : '';
    $wrapper .= (!empty($styles)) ? maat_add_item_styles($styles) . ' ' : '';

    if (!empty($data)) {
        foreach ($data as $key => $value) {
            $wrapper .= ' ' . $key . '="' . $value . '"';
        }
    }

    $all_fields = trim($wrapper);

    return $all_fields;
}

function build_video($args = array())
{
    $defaults = array(
        'id' => '',
        'classes' => array(),
        'autoplay' => 1,
        'controls' => 0,
        'mute' => 1,
        'loop' => 1,
        'srcs' => array(),
    );

    $options = array_merge($defaults, $args);
    $id = $options['id'];
    $classes = $options['classes'];
    $autoplay = $options['autoplay'];
    $controls = $options['controls'];
    $mute = $options['mute'];
    $loop = $options['loop'];
    $srcs = $options['srcs'];

    $settings = '';
    $settings .= ($autoplay == 1) ? ' autoplay' : '';
    $settings .= ($controls == 1) ? ' controls' : '';
    $settings .= ($mute == 1) ? ' mute' : '';
    $settings .= ($loop == 1) ? ' loop' : '';

    $video = '<video ';
    $video .= build_item_wrapper(array(
        'id' => $id,
        'classes' => $classes
    ));
    $video .= $settings;
    $video .= '>';

    if (!empty($srcs)) :
        $files = $srcs;
        foreach ($files as $file) {
            $video .= '<source src="' . $file['url'] . '" type="' . $file['type'] . '">';
        }
    endif;
    $video .= '</video>';

    return $video;
}

function maat_add_title_fields($item_slug)
{

    $sub_fields = array();

    $sub_fields[] = maat_create_field(array(
        'label' => 'Title HTML Wrapper',
        'type' => 'select',
        'key' => 'title_html_wrapper',
        'fields' => array(
            'choices' => array(
                'h1' => 'Heading 1',
                'h2' => 'Heading 2',
                'h3' => 'Heading 3',
                'h4' => 'Heading 4',
                'h5' => 'Heading 5',
                'h6' => 'Heading 6',
                'p' => 'Paragraph',
                'div' => 'Div Tag',
                'span' => 'Span Tag',
            ),
            'wrapper' => array(
                'class' => 'col-md-2',
            ),
        ),
    ));

    $sub_fields[] = maat_create_field(array(
        'label' => 'Title Text',
        'type' => 'text',
        'key' => 'title_text',
        'fields' => array(
            'wrapper' => array(
                'class' => 'col-md-5',
            ),
        ),
    ));

    $sub_fields[] = maat_create_field(array(
        'label' => 'Title Class',
        'type' => 'text',
        'key' => 'title_class',
        'fields' => array(
            'wrapper' => array(
                'class' => 'col-md-5',
            ),
        ),
    ));

    $fields[] = maat_create_field(array(
        'label' => 'Title',
        'type' => 'group',
        'key' => $item_slug . '_title',
        'layout' => $item_slug,
        'fields' => array(
            'sub_fields' => $sub_fields,
            'wrapper' => array(
                'class' => 'col-12',
            ),
        ),
    ));

    return $fields;
}

function maat_output_title($item_slug, $id)
{
    $key = get_sub_field($item_slug . '_title');
    $text = $key['title_text'];
    $tag = $key['title_html_wrapper'];
    $class = $key['title_class'];

    $classes = array(
        'modal',
    );
    $classes[] = (!empty($class)) ? $class : '';
    $wrapper = build_item_wrapper(array(
        'id' => $id,
        'classes' => $classes,
    ));

    $title = '<';
    $title .= $tag;
    $title .= ' ' . $wrapper;
    $title .= '>';
    $title .= $text;
    $title = '</';
    $title .= $tag;
    $title .= '>';

    return $title;
}
