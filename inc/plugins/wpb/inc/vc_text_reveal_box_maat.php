<?php

/** ===========================================================================
 * Visual Composer Setup file for the Text Reveal Box Component
 * @package Text Reveal Box
 * @version <<version>>
 * @link http://www.wpelixir.com/how-to-create-new-element-in-visual-composer/
 * @uses WPBakeryShortCode
 * -----
 * @author Sam Rankin <you@you.you>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * ========================================================================= */

class maatTextRevealBox extends WPBakeryShortCode
{

    // Element Init
    public function __construct()
    {
        add_action('init', array($this, 'vc_text_reveal_box_maat_mapping'));
        add_shortcode('vc_text_reveal_box_maat', array($this, 'vc_text_reveal_box_maat_html'));
    }

    // Element Mapping
    public function vc_text_reveal_box_maat_mapping()
    {

        // Stop all if VC is not enabled
        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        // Map the block with vc_map()
        vc_map(
            array(
                'name'        => __('Text Reveal Box', 'maat'),
                'base'        => 'vc_text_reveal_box_maat',
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
                        'type'        => 'attach_image',
                        'heading'     => __('Background Image', 'maat'),
                        'param_name'  => 'image',
                        'value'       => '',
                        'description' => __('Select image from media library.', 'maat'),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => __('Background Color', 'maat'),
                        'param_name'  => 'bg_color',
                        'value'       => array(
                            __('None', 'maat')      => '',
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
                        'type'        => 'dropdown',
                        'heading'     => __('Hover Effect', 'maat'),
                        'param_name'  => 'hover_effect',
                        'value'       => array(
                            __('Lily', 'maat')    => 'effect-lily',
                            __('Sadie', 'maat')   => 'effect-sadie',
                            __('Roxy', 'maat')    => 'effect-roxy',
                            __('Bubba', 'maat')   => 'effect-bubba',
                            __('Romeo', 'maat')   => 'effect-romeo',
                            __('Layla', 'maat')   => 'effect-layla',
                            __('Honey', 'maat')   => 'effect-honey',
                            __('Oscar', 'maat')   => 'effect-oscar',
                            __('Marley', 'maat')  => 'effect-marley',
                            __('Ruby', 'maat')    => 'effect-ruby',
                            __('Milo', 'maat')    => 'effect-milo',
                            __('Dexter', 'maat')  => 'effect-dexter',
                            __('Sarah', 'maat')   => 'effect-sarah',
                            __('Zoe', 'maat')     => 'effect-zoe',
                            __('Chico', 'maat')   => 'effect-chico',
                            __('Julia', 'maat')   => 'effect-julia',
                            __('Goliath', 'maat') => 'effect-goliath',
                            __('Hera', 'maat')    => 'effect-hera',
                            __('Winston', 'maat') => 'effect-winston',
                            __('Selena', 'maat')  => 'effect-selena',
                            __('Terry', 'maat')   => 'effect-terry',
                            __('Duke', 'maat')    => 'effect-duke',
                            __('Phoebe', 'maat')  => 'effect-phoebe',
                            __('Apollo', 'maat')  => 'effect-apollo',
                            __('Kira', 'maat')    => 'effect-kira',
                            __('Steve', 'maat')   => 'effect-steve',
                            __('Moses', 'maat')   => 'effect-moses',
                            __('Jazz', 'maat')    => 'effect-jazz',
                            __('Ming', 'maat')    => 'effect-ming',
                            __('Lexi', 'maat')    => 'effect-lexi',
                        ),
                        'description' => __('Choose an effect type. See https://tympanus.net/Development/HoverEffectIdeas/', 'maat'),
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
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => __('Box Title', 'maat'),
                        'param_name' => 'title',
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => __('Box Text', 'maat'),
                        'param_name' => 'text',
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => __('Box Icon', 'maat'),
                        'param_name' => 'icon',
                    ),
                    array(
                        'type'       => 'vc_link',
                        'heading'    => __('Box Link', 'maat'),
                        'param_name' => 'link',
                    ),
                ),
            )
        );
    }

    // Element HTML
    public function vc_text_reveal_box_maat_html($atts)
    {
        $elem   = 'maat-text-reveal-box';
        $output = '';
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'el_id'        => '',
                    'bg_color'     => '',
                    'el_class'     => '',
                    'hover_effect' => '',
                    'image'        => '',
                    'link'         => '',
                    'icon'         => '',
                    'title'        => '',
                    'title_tag'    => '',
                    'text'         => '',
                ),
                $atts
            )
        );

        $classes = array(
            $elem,
            $el_class,
            $bg_color
        );

        $link = vc_build_link($link);

        $link['title'] = $title;

        if (isset($link['url'])) {
            $link['href'] = $link['url'];
            unset($link['url']);
        }

        $args = array(
            'id'           => $el_id,
            'class'        => maat_item_classes($classes),
            'title'        => $title,
            'title_tag'    => $title_tag,
            'text'         => $text,
            'icon'         => $icon,
            'link'         => $link,
            'image_id'     => $image,
            'hover_effect' => $hover_effect,
            'image_size'   => 'large',
        );

        // Fill $html var with data
        $output .= hoverBox($args);

        return $output;
    }
} // End Element Class

// Element Class Init
new maatTextRevealBox();
