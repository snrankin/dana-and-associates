<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  6-27-19
 * Last Modified: 8-4-19 at 11:48 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */
function submenu_wrap_start($item_id = '', $menu_id = '', $parent_id = '', $depth = 0, $args)
{

    if (is_object($args)) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
    } elseif (is_array($args)) {
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
    }

    $sub_menu_container_indent = str_repeat($t, $depth + 2);
    $sub_menu_wrapper_indent   = str_repeat($t, $depth + 3);
    $sub_menu_inner_indent     = str_repeat($t, $depth + 4);

    $collapse_atts = array(
        //'href'          => '#menu-collapse-' . $item_id,
        'data-toggle'   => 'collapse',
        'aria-controls' => 'menu-collapse-' . $item_id,
        'aria-expanded' => 'false',
        'class'         => 'btn btn-link btn-toggle embed-responsive embed-responsive-1by1 p-0',
        'data-target'   => '#menu-collapse-' . $item_id,
        'aria-label'    => 'Dropdown link'
    );

    $container_atts = array(
        'id'   => 'menu-collapse-' . $item_id,
        'aria-labelledby'   => 'menu-item-' . $item_id,
    );

    if ($depth == 0 || $parent_id == 0 || empty($parent_id)) {
        $container_atts['data-parent'] = '#menu-' . $menu_id;
    } else {
        $container_atts['data-parent'] = '#menu-collapse-' . $parent_id;
    }

    $container_classes = array(
        'menu-container',
        'collapse',
        'level-' . ($depth + 2) . '-menu',
        'sub-menu'
    );
    $container_atts['class'] = maat_item_classes($container_classes);

    $output = '';
    $output .= '<button' . maat_add_item_data($collapse_atts) . '>';
    $output .= '<i class="dana embed-responsive-item"></i>';
    $output .= '</button>';
    $output .= $n . $sub_menu_container_indent . '<div' . maat_add_item_data($container_atts) . '>';
    $output .= $n . $sub_menu_wrapper_indent . '<div class="menu-wrapper">';
    $output .= $n . $sub_menu_inner_indent . '<nav class="menu-inner">';

    return $output;
}

function submenu_wrap_end($depth = 0, $args)
{

    if (is_object($args)) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
    } elseif (is_array($args)) {
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
    }

    $sub_menu_container_indent = str_repeat($t, $depth + 2);
    $sub_menu_wrapper_indent   = str_repeat($t, $depth + 3);
    $sub_menu_inner_indent     = str_repeat($t, $depth + 4);

    $output = '';
    $output .= $n . $sub_menu_inner_indent . '</nav>';
    $output .= $n . $sub_menu_wrapper_indent . '</div>';
    $output .= $n . $sub_menu_container_indent . '</div>';

    return $output;
}

function separate_linkmods_and_icons_from_classes($classes, &$linkmod_classes, &$icon_classes, $depth)
{
    foreach ($classes as $key => $class) {
        if (preg_match('/disabled|sr-only/i', $class)) {
            $linkmod_classes[] = $class;
            unset($classes[$key]);
        } elseif (preg_match('/dropdown-header|dropdown-divider|^dropdown-item-text/i', $class) && $depth > 0) {
            $linkmod_classes[] = $class;
            unset($classes[$key]);
        } elseif (preg_match('/^fa-(\S*)?|^fa(s|r|l|b)?(\s?)?$/i', $class)) {
            $icon_classes[] = $class;
            unset($classes[$key]);
        } elseif (preg_match('/^glyphicon-(\S*)?|^glyphicon(\s?)$/i', $class)) {
            $icon_classes[] = $class;
            unset($classes[$key]);
        } elseif (preg_match('/^dana-(\S*)?|^dana(\s?)$/i', $class)) {
            $icon_classes[] = $class;
            unset($classes[$key]);
        } elseif (preg_match('/^maat-(\S*)?|^maat(\s?)$/i', $class)) {
            $icon_classes[] = $class;
            unset($classes[$key]);
        }
    }

    return $classes;
}

function get_linkmod_type($linkmod_classes = array())
{
    $linkmod_type = '';
    if (!empty($linkmod_classes)) {
        foreach ($linkmod_classes as $link_class) {
            if (!empty($link_class)) {
                if ('dropdown-header' === $link_class) {
                    $linkmod_type = 'dropdown-header';
                } elseif ('dropdown-divider' === $link_class) {
                    $linkmod_type = 'dropdown-divider';
                } elseif ('dropdown-item-text' === $link_class) {
                    $linkmod_type = 'dropdown-item-text';
                }
            }
        }
    }
    return $linkmod_type;
}

function update_atts_for_linkmod_type($atts = array(), $linkmod_classes = array())
{
    if (!empty($linkmod_classes)) {
        foreach ($linkmod_classes as $link_class) {
            if (!empty($link_class)) {
                if ('sr-only' !== $link_class) {
                    $atts['class'] .= ' ' . esc_attr($link_class);
                }
                if ('disabled' === $link_class) {
                    $atts['href'] = '#';
                    unset($atts['target']);
                } elseif ('dropdown-header' === $link_class || 'dropdown-divider' === $link_class || 'dropdown-item-text' === $link_class) {
                    unset($atts['href']);
                    unset($atts['target']);
                }
            }
        }
    }
    return $atts;
}
function wrap_for_screen_reader($text = '')
{
    if ($text) {
        $text = '<span class="sr-only">' . $text . '</span>';
    }
    return $text;
}
function linkmod_element_open($linkmod_type, $attributes = '')
{
    $output = '';
    if ('dropdown-item-text' === $linkmod_type) {
        $output .= '<span class="dropdown-item-text"' . $attributes . '>';
    } elseif ('dropdown-header' === $linkmod_type) {
        $output .= '<span class="dropdown-header h6"' . $attributes . '>';
    } elseif ('dropdown-divider' === $linkmod_type) {
        $output .= '<div class="dropdown-divider"' . $attributes . '>';
    }
    return $output;
}
function linkmod_element_close($linkmod_type)
{
    $output = '';
    if ('dropdown-header' === $linkmod_type || 'dropdown-item-text' === $linkmod_type) {
        $output .= '</span>';
    } elseif ('dropdown-divider' === $linkmod_type) {
        $output .= '</div>';
    }
    return $output;
}
class WP_Bootstrap_Catwalker extends Walker_Category
{
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        if ('list' != $args['style']) {
            return;
        }

        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $sub_menu_indent = ($depth > 0) ? str_repeat($t, $depth + 5) : '';

        $menu_atts = array();

        $menu_classes = array('nav');
        $menu_classes = apply_filters('nav_menu_submenu_css_class', $menu_classes, $args, $depth);

        $menu_atts['class'] = maat_item_classes($menu_classes);

        $output .= $n . $sub_menu_indent . '<ul' . maat_add_item_data($menu_atts) . '>' ;
    }

    public function end_lvl(&$output, $depth=0, $args=array()) {
        if ('list' !=$args['style']) {
            return;
        }
        if (isset($args['item_spacing']) && 'preserve'===$args['item_spacing']) {
            $t="\t" ;
            $n="\n" ;
        } else {
            $t='' ;
            $n='' ;
        }
        $sub_menu_indent=($depth> 0) ? $n . str_repeat($t, $depth + 5) : $n;

        $output .= $sub_menu_indent . '</ul>';
    }

    public function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0){
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        $indent = ($depth) ? str_repeat($t, $depth) : $t;
        $list_item_indent = ($depth > 0) ? $n . str_repeat($t, $depth + 6) : $indent;
        $list_link_indent = $n . str_repeat($t, $depth + 1);

        $cat_name = apply_filters(
            'list_cats',
            esc_attr($category->name),
            $category
        );

        if ('' === $cat_name) {
            return;
        }

        $list_link_classes = array(
            'nav-link',
            'flex-fill'
        );

        $list_link_atts = array(
            'href'        => get_term_link($category),
            'role'        => 'menuitem',
            'data-level'  => ($depth + 1),
        );

        $list_link_atts['class'] = maat_item_classes($list_link_classes);

        if ($args['use_desc_for_title'] && !empty($category->description)) {
            $list_link_atts['title'] = strip_tags(apply_filters('category_description', $category->description, $category));
        }

        $list_link_atts = apply_filters('category_list_link_attributes', $list_link_atts, $category, $depth, $args, $id);

        $attributes = maat_add_item_data($list_link_atts);

        $link = sprintf('<a%s>%s</a>', $attributes, $cat_name);

        if (!empty($args['feed_image']) || !empty($args['feed'])) {
            $link .= ' ';

            if (empty($args['feed_image'])) {
                $link .= '(';
            }

            $link .= '<a href="' . esc_url(get_term_feed_link($category->term_id, $category->taxonomy, $args['feed_type'])) . '"';

            if (empty($args[' feed'])) {
                $alt=' alt="' . sprintf(__('Feed for all posts filed under %s'), $cat_name) . '"' ;
            } else {
                $alt=' alt="' . $args['feed'] . '"' ;
                $name=$args['feed'];
                $link .=empty($args['title']) ? '' : $args['title'];
            }
            $link .='>' ;

            if (empty($args['feed_image'])) {
                $link .=$name;
            } else {
                $link .="<img data-src='" . esc_url($args['feed_image']) . "'$alt" . ' class="lazyload" />' ;
            }
            $link .='</a>' ;
            if (empty($args['feed_image'])) {
                $link .=')' ;
            }
        }
        if (!empty($args['show_count'])) {
            $link .=' (' . number_format_i18n($category->count) . ')';
        }

        if ('list' == $args['style']) {

            $list_item_atts = array(
                'itemscope' => '',
                'itemtype' => 'https://www.schema.org/SiteNavigationElement',
                'role' => 'none',
                'id' => 'cat-item-' . $category->term_id,
            );

            $list_item_classes = array(
                'level-' . ($depth + 1) . '-menu-item',
                'nav-item'
            );

            if (!empty($args['current_category'])) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms(
                    $category->taxonomy,
                    array(
                        'include' => $args['current_category'],
                        'hide_empty' => false,
                    )
                );

                foreach ($_current_terms as $_current_term) {
                    if ($category->term_id == $_current_term->term_id) {
                        $list_item_classes[] = 'current-cat';
                        $list_item_classes[] = 'active';
                    } elseif ($category->term_id == $_current_term->parent) {
                        $list_item_classes[] = 'current-cat-parent';
                        $list_item_classes[] = 'active';
                    }
                    while ($_current_term->parent) {
                        if ($category->term_id == $_current_term->parent) {
                            $list_item_classes[] = 'current-cat-ancestor';
                            $list_item_classes[] = 'active';
                            break;
                        }
                        $_current_term = get_term($_current_term->parent, $category->taxonomy);
                    }
                }
            }

            $list_item_classes = apply_filters('category_css_class', $list_item_classes, $category, $depth, $args);

            $list_item_atts['class'] = maat_item_classes($list_item_classes);

            $output .= $list_item_indent . '<li' . maat_add_item_data($list_item_atts) . '>' . $link;
        } elseif (isset($args['separator'])) {
            $output .=$list_link_indent . $link . $args['separator'];
        } else {
            $output .=$list_link_indent . $link;
        }
        $output .='' ;
    }

    public function end_el(&$output, $page, $depth=0, $args=array()) {
        if ('list' !=$args['style']) { return; }
        if (isset($args['item_spacing']) && 'preserve'===$args['item_spacing']) {
            $t="\t" ; $n="\n" ;
        } else {
            $t='' ; $n='' ;
        }
        $indent=($depth) ? str_repeat($t, $depth) : $t; $list_item_indent=($depth> 0) ? $n . str_repeat($t, $depth + 6) : $indent;
        $output .= $list_item_indent . '</li>';
    }
}

class WP_Bootstrap_Pagewalker extends Walker_page
{

    public $tree_type = 'page';

    public $db_fields = array(
        'parent' => 'post_parent',
        'id' => 'ID',
    );
    public function start_lvl(&$output, $depth = 0, $args = array()){
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }

        $sub_menu_indent = ($depth > 0) ? str_repeat($t, $depth + 5) : '';

        $menu_atts = array();

        $menu_classes = array('nav');
        $menu_classes = apply_filters('nav_menu_submenu_css_class', $menu_classes, $args, $depth);

        $menu_atts['class'] = maat_item_classes($menu_classes);

        $output .= $n . $sub_menu_indent . '<ul' . maat_add_item_data($menu_atts) . '>' ;
    }

    public function end_lvl(&$output, $depth=0, $args=array()) {
        if (isset($args['item_spacing']) && 'preserve'===$args['item_spacing']) {
            $t="\t" ; $n="\n" ;
        } else {
            $t='' ; $n='' ;
        }
        $sub_menu_indent=($depth> 0) ? $n . str_repeat($t, $depth + 5) : $n;

        $output .= $sub_menu_indent . '</ul>';
    }

    public function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0) {

        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }

        $indent = ($depth) ? str_repeat($t, $depth) : $t;
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

        if (!empty($current_page)) {
            $_current_page = get_post($current_page);
            if ($_current_page && in_array($page->ID, $_current_page->ancestors)) {
                $list_item_classes[] = 'current_page_ancestor';
                $list_item_classes[] = 'active';
            }
            if ($page->ID == $current_page) {
                $list_item_classes[] = 'current_page_item';
                $list_item_classes[] = 'active';
            } elseif ($_current_page && $page->ID == $_current_page->post_parent) {
                $list_item_classes[] = 'current_page_parent';
                $list_item_classes[] = 'active';
            }
        } elseif ($page->ID == get_option('page_for_posts')) {
            $list_item_classes[] = 'current_page_parent';
            $list_item_classes[] = 'active';
        }

        $list_item_classes = apply_filters('page_css_class', $list_item_classes, $page, $depth, $args, $current_page);

        $list_item_atts = array(
            'itemscope' => '',
            'itemtype'  => 'https://www.schema.org/SiteNavigationElement',
            'role'      => 'none',
            'id'        => 'page-item-' . $page->ID,
            'class'     => maat_item_classes($list_item_classes),
        );

        $output .= $list_item_indent . '<li ' . maat_add_item_data($list_item_atts) . '>';

        $list_link_classes = array(
            'nav-link',
            'flex-fill'
        );

        $list_link_atts = array(
            'href'        => get_permalink($page->ID),
            'role'        => 'menuitem',
            'data-level'  => ($depth + 1),
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

        $list_link_atts['title'] = $page->post_title;

        if ('' === $title) {
            $title = sprintf(__('#%d (no title)'), $page->ID);
        } else {
            $link_atts['title'] = $title;
            $title = '<span class="nav-link-text">' . $title . '</span>';
        }

        $output .= isset($args->before) ? $args->before : '';
        $output .= $list_link_indent . '<a' . maat_add_item_data($link_atts) . '>' . $title . '</a>' ;

        if (!empty($show_date)) {
            if ('modified'==$show_date) {
                $time=$page->post_modified;
            } else {
                $time = $page->post_date;
            }

            $output .= '<span class="item-date">' . mysql2date($date_format, $time) . '</span>';
        }

        $output .= isset($args->after) ? $args->after : '';

        if (isset($pages_with_children[$page->ID]) || $has_children == true) {
            $menu_id = $post_type . '-page';
            $parent_id = $page->post_parent;

            $output .= submenu_wrap_start($page->ID, $menu_id, $parent_id, $depth, $args);
        }
    }

    public function end_el(&$output, $page, $depth = 0, $args = array()){

        extract($args, EXTR_SKIP);

        if (isset($item_spacing) && 'preserve' === $item_spacing) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }

        $indent = ($depth) ? str_repeat($t, $depth) : $t;
        $list_item_indent = ($depth > 0) ? $n . str_repeat($t, $depth + 6) : $indent;
        if (isset($pages_with_children[$page->ID]) || $has_children == true) {
            $output .= submenu_wrap_end($depth, $args);
        }
        $output .= $list_item_indent . '</li>';
    }
}

if (!class_exists('WP_Bootstrap_Navwalker')) {

    class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {

        public function start_lvl(&$output, $depth = 0, $args = array()){

            if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }

            $sub_menu_indent = ($depth > 0) ? str_repeat($t, $depth + 5) : '';

            $menu_atts = array();

            $menu_classes = array('nav');
            $menu_classes = apply_filters('nav_menu_submenu_css_class', $menu_classes, $args, $depth);

            $menu_atts['class'] = maat_item_classes($menu_classes);

            $output .= $n . $sub_menu_indent . '<ul' . maat_add_item_data($menu_atts) . '>' ;
        }

        public function end_lvl(&$output, $depth=0, $args=array()) {
            if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
                $t = "\t";
                $n = "\n";
            } else {
                $t = '';
                $n = '';
            }

            $sub_menu_indent = ($depth > 0) ? str_repeat($t, $depth + 5) : '';

            $output .= $n . $sub_menu_indent . '</ul>';
        }

        public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){

            if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = ($depth) ? str_repeat($t, $depth) : $t;
            $list_item_indent = ($depth > 0) ? $n . str_repeat($t, $depth + 6) : $indent;
            $list_link_indent = $n . str_repeat($t, $depth + 1);

            $args = apply_filters('nav_menu_item_args', $args, $item, $depth);

            $linkmod_classes = array();
            $icon_classes = array();
            $title = apply_filters('the_title', $item->title, $item->ID);

            $list_item_classes = empty($item->classes) ? array() : (array) $item->classes;
            $list_item_classes = separate_linkmods_and_icons_from_classes($list_item_classes, $linkmod_classes, $icon_classes, $depth);

            if (preg_match('/(\<i\sclass=\"([^"]+)\"\>\<\/i\>)(\V+)/', $title, $matches)) {
                $icon         = explode(' ', $matches[2]);
                $icon_classes = array_merge($icon_classes, $icon);
                $title        = ltrim($matches[3], ' ');
            }
            $icon_html = '';
            if (!empty($icon_classes)) {
                $icon_classes[] = ' nav-link-icon';
                $icon_html      = '<i ' . maat_add_item_classes($icon_classes) . ' aria-hidden="true"></i> ' ;
            }
            if (isset($args->has_children) && $args->has_children) {
                $list_item_classes[] = 'has-children';
            }
            if (in_array('current-menu-item', $list_item_classes, true) || in_array('current-menu-parent', $list_item_classes, true)) {
                $list_item_classes[] = 'active';
            }

            $list_item_classes[] = 'level-' . ($depth + 1) . '-menu-item';
            $list_item_classes[] = 'nav-item';

            $list_item_classes = apply_filters('nav_menu_css_class', array_filter($list_item_classes), $item, $args, $depth);

            $list_item_id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);

            $list_item_atts = array(
                'itemscope' => '',
                'itemtype'  => 'https://www.schema.org/SiteNavigationElement',
                'role'      => 'none',
                'id'        => esc_attr($list_item_id),
            );

            $list_item_atts['class'] = maat_item_classes($list_item_classes);

            $output .= $list_item_indent . '<li ' . maat_add_item_data($list_item_atts) . '>';

            $list_link_atts = array(
                'target'  => $item->target,
                'rel'     => $item->xfn,
                'role'    => 'menuitem',
            );
            $list_link_classes = array();

            if (empty($item->attr_title)) {
                $list_link_atts['title'] = !empty($item->title) ? strip_tags($item->title) : '';
            } else {
                $list_link_atts['title'] = $item->attr_title;
            }
            $list_link_atts['href'] = !empty($item->url) ? $item->url : '#';
            $list_link_classes[] = 'nav-link';
            $list_link_classes[] = 'flex-fill';

            if (in_array('current-menu-item', $list_item_classes, true) || in_array('current-menu-parent', $list_item_classes, true)) {
                $list_link_classes[] = 'active';
            }

            $list_link_atts['class'] = maat_item_classes($list_link_classes);

            $list_link_atts = apply_filters('nav_menu_link_attributes', $list_link_atts, $item, $args, $depth);
            $list_link_atts = update_atts_for_linkmod_type($list_link_atts, $linkmod_classes);

            $attributes = maat_add_item_data($list_link_atts);

            $linkmod_type = get_linkmod_type($linkmod_classes);

            $item_output = isset($args->before) ? $args->before : '';

            if ('' !== $linkmod_type) {
                $item_output .= linkmod_element_open($linkmod_type, $attributes);
            } else {
                $item_output .= $list_link_indent . '<a' . $attributes . '>' ;
            }
            $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

            if (in_array('sr-only', $linkmod_classes, true)) {
                $title = wrap_for_screen_reader($title);
                $keys_to_unset = array_keys($linkmod_classes, 'sr-only' );
                foreach ($keys_to_unset as $k) {
                    unset($linkmod_classes[$k]);
                }
            } else {
                $title='<span class="nav-link-text">' . $title . '</span>' ;
            }
            $item_output .= isset($args->link_before) ? $args->link_before . $icon_html . $title . $args->link_after : '';

            if ('' !== $linkmod_type) {
                $item_output .= linkmod_element_close($linkmod_type, $attributes);
            } else {
                $item_output .= '</a>';
            }

            $item_output .= isset($args->after) ? $args->after : '';

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

            // Submenu wrapper setup
            if (isset($args->has_children) && $args->has_children) {
                $list_link_atts['data-sub-menu'] = $item->ID;

                $menu_id = $args->menu_id;

                if (empty($menu_id)) {
                    $menu_id = $args->menu->slug;
                }
                $parent_id = $item->post_parent;

                $output .= submenu_wrap_start($item->ID, $menu_id, $parent_id, $depth, $args);
            }
        }

        public function end_el(&$output, $item, $depth = 0, $args = array()){
            if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = ($depth) ? str_repeat($t, $depth) : $t;
            $list_item_indent = ($depth > 0) ? $n . str_repeat($t, $depth + 6) : $indent;

            if (isset($args->has_children) && $args->has_children) {
                $output .= submenu_wrap_end($depth, $args);
            }
            $output .= $list_item_indent . '</li>';
        }

        public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output){
            if (!$element) {
                return;
            }
            $id_field = $this->db_fields['id'];
            if (is_object($args[0])) {
                $args[0]->has_children = !empty($children_elements[$element->$id_field]);
            }
            parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }

        public static function fallback($args){
            if (current_user_can('edit_theme_options')) {

                $container        = $args['container'];
                $container_id     = $args['container_id'];
                $container_class  = $args['container_class'];
                $menu_class       = $args['menu_class'];
                $menu_id          = $args['menu_id'];

                $fallback_output = '';

                if ($container) {
                    $fallback_output .= '<' . esc_attr($container);
                    $fallback_output .= ($container_id) ? ' id="' . esc_attr($container_id) . '"' : '' ;
                    $fallback_output .= ($container_class) ? ' class="' . esc_attr($container_class) . '"' : '' ;
                    $fallback_output .='>' ;
                }
                $fallback_output .='<ul' ;
                $fallback_output .= ($menu_id) ? ' id="' . esc_attr($menu_id) . '"' : '' ;
                $fallback_output .= ($menu_class) ? ' class="' . esc_attr($menu_class) . '"' : '' ;
                $fallback_output .= '>' ;
                $fallback_output .= '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '" title="' . esc_attr__('Add a menu', 'wp-bootstrap-navwalker' ) . '">' . esc_html__('Add a menu', 'wp-bootstrap-navwalker' ) . '</a></li>';
                $fallback_output .= '</ul>';
                $fallback_output .= ($container) ? '</' . esc_attr($container) . '>' : '' ;
                if (array_key_exists('echo', $args) && $args['echo']) {
                    echo $fallback_output;
                } else {
                    return $fallback_output;
                }
            }
        }
    }
}
