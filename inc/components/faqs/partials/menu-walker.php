<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  6-20-19
 * Last Modified: 8-1-19 at 12:52 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */

/* Check if Class Exists. */

class WP_Bootstrap_Pagewalker_FAQs extends WP_Bootstrap_Pagewalker
{

    public function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0)
    {

        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }

        $indent           = ($depth) ? str_repeat($t, $depth) : $t;
        $list_item_indent = ($depth > 0) ? $n . str_repeat($t, $depth + 6) : $indent;
        $list_link_indent = $n . str_repeat($t, $depth + 1);

        extract($args, EXTR_SKIP);

        $list_item_classes = array(
            'level-' . ($depth + 1) . '-nav-item',
            'nav-item',
        );

        if (isset($pages_with_children[$page->ID]) || $has_children == true) {
            $list_item_classes[] = 'has-children';
        }


        $list_item_classes = apply_filters('page_css_class', $list_item_classes, $page, $depth, $args, $current_page);

        $list_item_atts = array(
            'id'        => 'page-item-' . $page->ID,
            'class'     => maat_item_classes($list_item_classes),
        );

        $output .= $list_item_indent . '<li ' . maat_add_item_data($list_item_atts) . '>';

        $list_link_classes = array(
            'nav-link',
            'flex-fill'
        );

        $list_link_atts  = array(
            'href' => '#' . $page->post_name,
            'role' => 'menuitem',
            'data-level' => ($depth + 1),
        );

        $title = $page->post_title;


        $list_link_atts['aria-current'] = ($page->ID == $current_page) ? 'page' : '';

        if ($depth == 0) {
            $list_link_atts['tabindex'] = '0';
        } else {
            $list_link_atts['tabindex'] = '-1';
        }

        $list_link_atts['class'] = maat_item_classes($list_link_classes);

        $link_atts = apply_filters('page_menu_link_attributes', $list_link_atts, $page, $depth, $args, $current_page);

        $list_link_atts['title']        = $page->post_title;
        if ('' === $title) {
            $title = sprintf(__('#%d (no title)'), $page->ID);
        } else {
            $link_atts['title']        = $title;
            $title = '<span class="nav-link-text">' . $title . '</span>';
        }

        $output .= isset($args->before) ? $args->before : '';
        $output .= $list_link_indent . '<a' . maat_add_item_data($link_atts) . '>' . $title . '</a>';

        $output .= isset($args->after) ? $args->after : '';

        if (isset($pages_with_children[$page->ID]) || $has_children == true) {
            $menu_id = $post_type . '-page';
            $parent_id = $page->post_parent;

            $output .= submenu_wrap_start($page->ID, $menu_id, $parent_id, $depth, $args);
        }
    }
}

class WP_Bootstrap_Navwalker_FAQs_Mobile extends Walker_page
{

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $ul_indent = ($depth) ? str_repeat($t, $depth + 5) : '';
        $classes   = array('menu', 'custom-menu');
        $classes   = maat_add_item_classes($classes);
        $menu_id   = '';

        preg_match_all('/(<a.*?id=\"|\')(.*?)\"|\'.*?>/im', $output, $matches);
        if (end($matches[2])) {
            $menu_id = ' id="sub-' . end($matches[2]) . '"';
        }
        $output .= "{$n}{$ul_indent}<ul$menu_id $classes role=\"menu\">";
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        $sub_menu_container_indent = str_repeat($t, $depth + 2);
        $sub_menu_wrapper_indent   = str_repeat($t, $depth + 3);
        $sub_menu_inner_indent     = str_repeat($t, $depth + 4);
        $ul_indent                 = ($depth > 0) ? str_repeat($t, $depth + 5) : '';

        $output .= "{$n}{$ul_indent}</ul>";
        $output .= "{$n}{$sub_menu_inner_indent}</nav>";
        $output .= "{$n}{$sub_menu_wrapper_indent}</div>";
        $output .= "{$n}{$sub_menu_container_indent}</div>";
    }

    public function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0)
    {

        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $indent                    = ($depth) ? str_repeat($t, $depth) : $t;
        $a_indent                  = str_repeat($t, $depth + 1);
        $sub_menu_container_indent = str_repeat($t, $depth + 2);
        $sub_menu_wrapper_indent   = str_repeat($t, $depth + 3);
        $sub_menu_inner_indent     = str_repeat($t, $depth + 4);
        $li_indent                 = ($depth > 0) ? str_repeat($t, $depth + 6) : $indent;

        extract($args, EXTR_SKIP);

        $css_class   = array('nav-item');
        $css_class[] = 'nav-item-' . $page->ID;
        $css_class[] = 'level-' . ($depth + 2) . '-menu-item';

        $collapseAtts = array();

        $parent = $page->post_parent;

        if (isset($args['pages_with_children'][$page->ID])) {
            $css_class[]                   = 'has-children';
            $collapseAtts['data-toggle']   = 'collapse';
            $collapseAtts['aria-controls'] = 'menu-collapse-' . $page->ID;
            $collapseAtts['aria-expanded'] = 'false';
            $collapseAtts['class']         = 'dropdown-toggle';
            if ($depth > 0) {
                $collapseAtts['data-parent'] = '#menu-collapse-' . $parent;
            } else {
                $collapseAtts['data-parent'] = '#menu-faqs';
            }
        }
        if (!empty($current_page)) {
            $current_page = get_post($current_page);
            if (in_array($page->ID, $current_page->ancestors)) {
                $css_class[] = 'current_page_ancestor';
            }

            if ($page->ID == $current_page) {
                $css_class[] = 'current_page_item';
            } elseif ($current_page && $page->ID == $current_page->post_parent) {
                $css_class[] = 'current_page_parent';
            }
        } elseif ($page->ID == get_option('page_for_posts')) {
            $css_class[] = 'current_page_parent';
        }

        $item_id     = ' id="page-item-' . esc_attr($page->ID) . '"';
        $css_classes = implode(' ', apply_filters('page_css_class', $css_class, $page, $depth, $args, $current_page));
        $css_classes = $css_classes ? ' class="' . esc_attr($css_classes) . '"' : '';

        $url = '#' . $page->post_name;

        $output .= "{$n}{$li_indent}";
        $output .= '<option';
        $output .= ' value="' . $url . '"';
        $output .= '>' . $n;
        $atts  = array();
        $title = $page->post_title;
        if ('' === $title) {
            $title = sprintf(__('#%d (no title)'), $page->ID);
        }

        $item_output = isset($args->before) ? $args->before : '';

        $attributes = add_item_data($atts);

        $item_output .= "{$n}{$a_indent}" . $title . $n;
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= $item_output;

        if (!empty($show_date)) {
            if ('modified' == $show_date) {
                $time = $page->post_modified;
            } else {
                $time = $page->post_date;
            }

            $output .= " " . mysql2date($date_format, $time);
        }
    }

    public function end_el(&$output, $page, $depth = 0, $args = array())
    {
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        $output .= "</option>{$n}";
    }
}
