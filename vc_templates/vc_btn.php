<?php
if (!defined('ABSPATH')) {
    die('-1');
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $style
 * @var $shape
 * @var $color
 * @var $custom_background
 * @var $custom_text
 * @var $size
 * @var $align
 * @var $link
 * @var $title
 * @var $button_block
 * @var $el_id
 * @var $el_class
 * @var $outline_custom_color
 * @var $outline_custom_hover_background
 * @var $outline_custom_hover_text
 * @var $add_icon
 * @var $i_align
 * @var $i_type
 * @var $i_icon_fontawesome
 * @var $i_icon_openiconic
 * @var $i_icon_typicons
 * @var $i_icon_entypo
 * @var $i_icon_linecons
 * @var $i_icon_pixelicons
 * @var $css_animation
 * @var $css
 * @var $gradient_color_1
 * @var $gradient_color_2
 * @var $gradient_custom_color_1 ;
 * @var $gradient_custom_color_2 ;
 * @var $gradient_text_color ;
 * Shortcode class
 * @var WPBakeryShortCode_Vc_Btn $this
 */
$style          = $shape          = $color          = $size          = $custom_background          = $custom_text          = $align          = $link          = $title          = $button_block          = $el_class          = $outline_custom_color          = $outline_custom_hover_background          = $outline_custom_hover_text          = $add_icon          = $i_align          = $i_type          = $i_icon_entypo          = $i_icon_fontawesome          = $i_icon_linecons          = $i_icon_pixelicons          = $i_icon_typicons          = $css          = $css_animation          = $gradient_color_1          = $gradient_color_2          = $gradient_custom_color_1          = $gradient_custom_color_2          = $gradient_text_color          = $custom_onclick          = $custom_onclick_code          = $a_href          = $a_title          = $a_target          = $a_rel          = $fancybox          = $custom_i_class          = '';
$styles         = array();
$icon_wrapper   = false;
$icon_html      = false;
$btn_attributes = array();

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$parent_class = 'content-item';
$elem         = $this->settings['base'];

$wrapper_classes = array(
    $el_class,
    $parent_class,
    'text-' . $align,
);

$wrapper_attributes = array();

// parse link
$link     = trim($link);
$link     = ('||' === $link) ? '' : $link;
$link     = vc_build_link($link);
$use_link = false;
if (strlen($link['url']) > 0) {
    $use_link      = true;
    $link['href']  = apply_filters('vc_btn_a_href', $link['url']);
    $link['title'] = apply_filters('vc_btn_a_title', $link['title']);
    unset($link['url']);
    $btn_attributes = array_merge($btn_attributes, $link);
}

$button_classes = array(
    'btn',
    'btn-' . $size,
);

$wrapper_attributes = array();
// build attributes for wrapper
if (!empty($el_id)) {
    $wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
    $end_comment          = '<!-- end #' . esc_attr($el_id) . '.' . $parent_class . '-->';
} else {
    $end_comment = '<!-- end .' . $parent_class . '-->';
}

if ('outline' === $style) {
    $button_classes[] = 'btn-' . $style . '-' . $color;
} else {
    $button_classes[] = 'btn-' . $color;
}

if (!empty($title)) {
    $button_html             = '<span class="btn-txt">' . $title . '</span>';
    $btn_attributes['title'] = esc_attr($title);

} elseif (!empty($link['title'])) {
    $button_html = '<span class="btn-txt">' . $link['title'] . '</span>';

} else {
    $button_classes[] = 'vc_btn3-o-empty';
    $button_html      = '<span class="btn-txt">&nbsp;</span>';

}

if ('true' === $button_block && 'inline' !== $align) {
    $button_classes[] = 'btn-block';
}
if ('true' === $add_icon) {
    $button_classes[] = 'has-icon';

    $icon_class = $i_align . '-icon';

    if ($i_type === 'custom' && isset($custom_i_class)) {
        $icon_class .= ' ' . $custom_i_class;
    }

    if (isset(${'i_icon_' . $i_type})) {
        if ('pixelicons' === $i_type) {
            $icon_wrapper = true;
        }
        $icon_class .= ' ' . ${'i_icon_' . $i_type};
    }

    if ($icon_wrapper) {
        $icon_html = '<i class="btn-icon"><span class="vc_btn3-icon-inner ' . esc_attr($icon_class) . '"></span></i>';
    } else {
        $icon_html = '<i class="btn-icon ' . esc_attr($icon_class) . '"></i>';
    }

    if ('left' === $i_align) {
        $button_html = $icon_html . ' ' . $button_html;
    } else {
        $button_html .= ' ' . $icon_html;
    }
}

if ('custom' === $style) {
    if ($custom_background) {
        $styles[] = vc_get_css_color('background-color', $custom_background);
    }

    if ($custom_text) {
        $styles[] = vc_get_css_color('color', $custom_text);
    }

    if (!$custom_background && !$custom_text) {
        $button_classes[] = 'vc_btn3-color-grey';
    }
} elseif ('outline-custom' === $style) {
    if ($outline_custom_color) {
        $styles[]                       = vc_get_css_color('border-color', $outline_custom_color);
        $styles[]                       = vc_get_css_color('color', $outline_custom_color);
        $btn_attributes['onmouseleave'] = 'this.style.borderColor=\'' . $outline_custom_color . '\'; this.style.backgroundColor=\'transparent\'; this.style.color=\'' . $outline_custom_color . '\'';
    } else {
        $btn_attributes['onmouseleave'] = 'this.style.borderColor=\'\'; this.style.backgroundColor=\'transparent\'; this.style.color=\'\'';
    }

    $onmouseenter = array();
    if ($outline_custom_hover_background) {
        $onmouseenter[] = 'this.style.borderColor=\'' . $outline_custom_hover_background . '\';';
        $onmouseenter[] = 'this.style.backgroundColor=\'' . $outline_custom_hover_background . '\';';
    }
    if ($outline_custom_hover_text) {
        $onmouseenter[] = 'this.style.color=\'' . $outline_custom_hover_text . '\';';
    }
    if ($onmouseenter) {
        $btn_attributes['onmouseenter'] = implode(' ', $onmouseenter);
    }

    if (!$outline_custom_color && !$outline_custom_hover_background && !$outline_custom_hover_text) {
        $button_classes[] = 'vc_btn3-color-inverse';

        foreach ($button_classes as $k => $v) {
            if ('vc_btn3-style-outline-custom' === $v) {
                unset($button_classes[$k]);
                break;
            }
        }
        $button_classes[] = 'vc_btn3-style-outline';
    }
} elseif ('gradient' === $style || 'gradient-custom' === $style) {

    $gradient_color_1 = vc_convert_vc_color($gradient_color_1);
    $gradient_color_2 = vc_convert_vc_color($gradient_color_2);

    $button_text_color = '#fff';
    if ('gradient-custom' === $style) {
        $gradient_color_1  = $gradient_custom_color_1;
        $gradient_color_2  = $gradient_custom_color_2;
        $button_text_color = $gradient_text_color;
    }

    $gradient_css   = array();
    $gradient_css[] = 'color: ' . $button_text_color;
    $gradient_css[] = 'border: none';
    $gradient_css[] = 'background-color: ' . $gradient_color_1;
    $gradient_css[] = 'background-image: -webkit-linear-gradient(left, ' . $gradient_color_1 . ' 0%, ' . $gradient_color_2 . ' 50%,' . $gradient_color_1 . ' 100%)';
    $gradient_css[] = 'background-image: linear-gradient(to right, ' . $gradient_color_1 . ' 0%, ' . $gradient_color_2 . ' 50%,' . $gradient_color_1 . ' 100%)';
    $gradient_css[] = '-webkit-transition: all .2s ease-in-out';
    $gradient_css[] = 'transition: all .2s ease-in-out';
    $gradient_css[] = 'background-size: 200% 100%';

    // hover css
    $gradient_css_hover   = array();
    $gradient_css_hover[] = 'color: ' . $button_text_color;
    $gradient_css_hover[] = 'background-color: ' . $gradient_color_2;
    $gradient_css_hover[] = 'border: none';
    $gradient_css_hover[] = 'background-position: 100% 0';

    $uid = uniqid();
    echo '<style type="text/css">.vc_btn3-style-' . esc_attr($style) . '.vc_btn-gradient-btn-' . esc_attr($uid) . ':hover{' . esc_attr(implode(';', $gradient_css_hover)) . ';' . '}</style>';
    echo '<style type="text/css">.vc_btn3-style-' . esc_attr($style) . '.vc_btn-gradient-btn-' . esc_attr($uid) . '{' . esc_attr(implode(';', $gradient_css)) . ';' . '}</style>';
    $button_classes[]                     = 'vc_btn-gradient-btn-' . $uid;
    $btn_attributes['data-vc-gradient-1'] = $gradient_color_1;
    $btn_attributes['data-vc-gradient-2'] = $gradient_color_2;
} elseif ('outline' === $style) {
    $button_classes[] = 'btn-' . $style . '-' . $color;
} else {
    $button_classes[] = 'btn-' . $color;
}

if ($styles) {
    $btn_attributes['style'] = implode(' ', $styles);
}

if ('yes' === $fancybox) {
    $btn_attributes['data-fancybox'] = '';
}

if ($button_classes) {
    $btn_attributes['class'] = implode(' ', maatVCClasses($button_classes, $elem, $atts));

}

if (!empty($custom_onclick) && $custom_onclick_code) {
    $btn_attributes['onclick'] = esc_attr($custom_onclick_code);
}

$wrapper_attributes['class'] = implode(' ', maatVCClasses($wrapper_classes, $elem, $atts));

$output = '';
$output .= "\n" . '<div' . maat_add_item_data($wrapper_attributes) . '>';
$output .= "\n\t";
$output .= ($use_link) ? '<a' . maat_add_item_data($btn_attributes) . '>' . $button_html . '</a>' : '<button ' . maat_add_item_data($btn_attributes) . '>' . $button_html . '</button>';
$output .= "\n" . '</div>' . $end_comment;

echo $output;
