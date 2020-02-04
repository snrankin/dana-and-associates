<?php
function broadly_reviews_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'reviews' => '',
        ),
        $atts
    );

    return broadlyReviews();
}
add_shortcode('company_reviews', 'broadly_reviews_shortcode');

function maat_icon_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(
            'icon'  => '',
            'class' => '',
        ),
        $atts
    );

    $icon = '<i class="maat maat-' . $atts['icon'] . ' ' . $atts['class'] . '"></i>';

    return $icon;
}
add_shortcode('maat_icon', 'maat_icon_shortcode');

function maat_badge_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(
            'link'  => 0,
            'class' => '',
        ),
        $atts
    );

    $link = 'https://maatlegal.com';

    $img  = file_get_contents(ASSETS_PATH . '/imgs/maat-badge.svg');
    $logo = ($atts['link'] == 1) ? '<a href="' . $link . '" class="maat-logo-wrapper ' . $atts['class'] . '" title="' . get_bloginfo('name') . ' is part of the Maat Legal Network" target="_blank" rel="nofollow">' . $img . '</a>' : '<div class="maat-logo-wrapper ' . $atts['class'] . '">' . $img . '</div>';

    return $logo;
}
add_shortcode('maat_badge', 'maat_badge_shortcode');

function maat_bbb_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(
            'link'  => '',
            'class' => '',
        ),
        $atts
    );

    $img = file_get_contents(ASSETS_PATH . '/imgs/BBB.svg');

    $logo = (!empty($atts['link'])) ? '<a href="' . $atts['link'] . '" class="maat-bbb-wrapper ' . $atts['class'] . '" title="' . get_bloginfo('name') . ' BBB Business Review" target="_blank" rel="nofollow">' . $img . '</a>' : '<div class="maat-bbb-wrapper ' . $atts['class'] . '">' . $img . '</div>';

    return $logo;
}
add_shortcode('maat_bbb', 'maat_bbb_shortcode');

function maat_location_grid_shortcode()
{

    return get_locations_grid();
}
add_shortcode('locations_grid', 'maat_location_grid_shortcode');

function maat_location_cat_list_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'location' => '',
        ),
        $atts
    );
    return get_location_cat_list($atts['location']);
}
add_shortcode('locations_cat_list', 'maat_location_cat_list_shortcode');

function maat_info_shortcode($atts)
{
    extract(
        shortcode_atts(
            array(
                'location'           => '',
                'wrapper'            => 'div',
                'class'              => '',
                'title'              => '',
                'show_parent'        => 1,
                'address_display'    => 1,
                'address_wrapper'    => 1,
                'address_class'      => '',
                'address_title'      => '',
                'address_directions' => 0,
                'address_link'       => 1,
                'address_icon'       => 1,
                'phone_display'      => 1,
                'phone_wrapper'      => 1,
                'phone_class'        => '',
                'phone_title'        => '',
                'phone_link'         => 1,
                'phone_icon'         => 1,
                'fax_display'        => 1,
                'fax_wrapper'        => 1,
                'fax_class'          => '',
                'fax_title'          => '',
                'fax_link'           => 1,
                'fax_icon'           => 1,
                'email_display'      => 1,
                'email_wrapper'      => 1,
                'email_class'        => '',
                'email_title'        => '',
                'email_link'         => 1,
                'email_icon'         => 1,
                'hob_display'        => 1,
                'hob_wrapper'        => 1,
                'hob_class'          => '',
                'hob_title'          => '',
                'hob_icon'           => 1,
            ),
            $atts
        )
    );

    $args = array(
        'wrapper'     => $wrapper,
        'class'       => $class,
        'title'       => $title,
        'show_parent' => $show_parent,
        'address'     => array(
            'display'    => $address_display,
            'wrapper'    => $address_wrapper,
            'class'      => $address_class,
            'title'      => $address_title,
            'directions' => $address_directions,
            'link'       => $address_link,
            'icon'       => $address_icon,
        ),
        'phone'       => array(
            'display' => $phone_display,
            'wrapper' => $phone_wrapper,
            'class'   => $phone_class,
            'title'   => $phone_title,
            'link'    => $phone_link,
            'icon'    => $phone_icon,
        ),
        'fax'         => array(
            'display' => $fax_display,
            'wrapper' => $fax_wrapper,
            'class'   => $fax_class,
            'title'   => $fax_title,
            'link'    => $fax_link,
            'icon'    => $fax_icon,
        ),
        'email'       => array(
            'display' => $email_display,
            'wrapper' => $email_wrapper,
            'class'   => $email_class,
            'title'   => $email_title,
            'link'    => $email_link,
            'icon'    => $email_icon,
        ),
        'hob'         => array(
            'display' => $hob_display,
            'wrapper' => $hob_wrapper,
            'class'   => $hob_class,
            'title'   => $hob_title,
            'icon'    => $hob_icon,
        ),

    );

    $location = get_post_id_by_slug($location, 'location');

    $info = displayLocationInfo($location, $args);

    return $info;
}
add_shortcode('company_info', 'maat_info_shortcode');

function maat_address_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(
            'location'    => '',
            'wrapper'     => '',
            'class'       => '',
            'title'       => '',
            'add_icons'   => 0,
            'add_links'   => 1,
            'show_parent' => 1,
        ),
        $atts
    );

    $args = array(
        'wrapper'      => $atts['wrapper'],
        'class'        => $atts['class'],
        'title'        => $atts['title'],
        'add_icons'    => $atts['add_icons'],
        'add_links'    => $atts['add_links'],
        'show_parent'  => $atts['show_parent'],
        'show_address' => 1,
    );

    $location = get_post_id_by_slug($atts['location'], 'location');

    $info = displayLocationInfo($location, $args);

    return $info;
}
add_shortcode('company_address', 'maat_address_shortcode');

function maat_phone_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(
            'location'    => '',
            'wrapper'     => '',
            'class'       => '',
            'title'       => '',
            'icon'        => 0,
            'link'        => 0,
            'show_parent' => 1,
        ),
        $atts
    );
    extract($atts);

    $item_id = '';
    $location_ID = get_post_id_by_slug($location, 'location');
    $parent_ID = get_field('parent_location', 'options');
    $parent_ID = intval($parent_ID);

    if (!empty($location_ID)) {
        $item_id = $location_ID;
    } elseif ($show_parent == 1) {
        $item_id = $parent_ID;
    } else {
        return;
    }
    $phone         = get_field('location_phone', $item_id);

    $args = array(
        'content' => $phone,
    );

    $args = array_merge($atts, $args);

    $info = displayPhone($args);

    return $info;
}
add_shortcode('company_phone', 'maat_phone_shortcode');

function maat_fax_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(
            'location'    => '',
            'wrapper'     => '',
            'class'       => '',
            'title'       => '',
            'add_icons'   => 0,
            'add_links'   => 0,
            'show_parent' => 1,
        ),
        $atts
    );

    $args = array(
        'wrapper'     => $atts['wrapper'],
        'class'       => $atts['class'],
        'title'       => $atts['title'],
        'add_icons'   => $atts['add_icons'],
        'add_links'   => $atts['add_links'],
        'show_parent' => $atts['show_parent'],
        'show_fax'    => 1,
    );

    $location = get_post_id_by_slug($atts['location'], 'location');

    $info = displayLocationInfo($location, $args);

    return $info;
}
add_shortcode('company_fax', 'maat_fax_shortcode');

function maat_email_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(
            'location'    => '',
            'wrapper'     => '',
            'class'       => '',
            'title'       => '',
            'icon'        => 0,
            'link'        => 1,
            'show_parent' => 1,
        ),
        $atts
    );
    extract($atts);

    $item_id = '';
    $location_ID = get_post_id_by_slug($location, 'location');
    $parent_ID = get_field('parent_location', 'options');
    $parent_ID = intval($parent_ID);

    if (!empty($location_ID)) {
        $item_id = $location_ID;
    } elseif ($show_parent == 1) {
        $item_id = $parent_ID;
    } else {
        return;
    }
    $email         = get_field('location_email', $item_id);

    $args = array(
        'content' => $email,
    );

    $args = array_merge($atts, $args);

    $info = displayEmail($args);

    return $info;
}
add_shortcode('company_email', 'maat_email_shortcode');

function maat_hob_shortcode($atts)
{
    // Attributes
    $atts = shortcode_atts(
        array(
            'location'    => '',
            'wrapper'     => '',
            'class'       => '',
            'title'       => '',
            'add_icons'   => 0,
            'add_links'   => 0,
            'show_parent' => 1,
        ),
        $atts
    );

    $args = array(
        'wrapper'     => $atts['wrapper'],
        'class'       => $atts['class'],
        'title'       => $atts['title'],
        'add_icons'   => $atts['add_icons'],
        'add_links'   => $atts['add_links'],
        'show_parent' => $atts['show_parent'],
        'show_hob'    => 1,
    );

    $location = get_post_id_by_slug($atts['location'], 'location');

    $info = displayLocationInfo($location, $args);

    return $info;
}
add_shortcode('company_hob', 'maat_hob_shortcode');

function maat_logo_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'class' => '',
            'link'  => 1,
        ),
        $atts
    );

    return maat_custom_logo($atts['class'], $atts['link']);
}
add_shortcode('company_logo', 'maat_logo_shortcode');

function maat_social_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'location' => '',
            'class'    => '',
        ),
        $atts
    );

    return socialProfiles($atts['location'], $atts['class']);
}
add_shortcode('company_social', 'maat_social_shortcode');

function video_popup_shortcode($atts)
{

    // Attributes
    $atts = shortcode_atts(
        array(
            'link'  => '',
            'id'    => '',
            'icon'  => '',
            'title' => '',
            'class' => 'btn-primary',
        ),
        $atts
    );
    extract($atts);

    $link_classes = array(
        'btn',
        'has-icon',
        'video-popup',
    );

    $link_atts = array(
        'href' => $link,
        'id' => $id,
        'title' => $title,
        'data-fancybox' => '',
        'class' => maat_item_classes($class, $link_classes)
    );
    $link_atts = maat_add_item_data($link_atts);

    $icon_html = (!empty($icon)) ? '<i class="' . $icon . ' right-icon"></i>' : '';
    $text_html = (!empty($title)) ? '<span class="btn-txt">' . $title . '</span>' : '';

    $btn = wp_sprintf('<a%s><i class="%s"></i>%s%s</a>', $link_atts, 'dana dana-media-video-tv left-icon', $text_html, $icon_html);

    return $btn;
}
add_shortcode('video_popup', 'video_popup_shortcode');

function hoverbox_shortcode($atts)
{

    // Attributes
    $atts = shortcode_atts(
        array(
            'title'        => '',
            'text'         => '',
            'title_tag'    => 'h4',
            'icon'         => '',
            'link'         => '',
            'image'        => '',
            'hover_effect' => '',
        ),
        $atts
    );

    $args = array(
        'title'        => $atts['title'],
        'text'         => $atts['text'],
        'title_tag'    => $atts['title_tag'],
        'icon'         => $atts['icon'],
        'link'         => $atts['link'],
        'link'         => array(
            'url'   => $atts['link'],
            'title' => $atts['title'],
        ),
        'image'        => get_post_thumbnail_id($atts['image'], 'medium'),
        'hover_effect' => $atts['hover_effect'],
    );

    return hoverBox($args);
}
add_shortcode('hoverbox', 'hoverbox_shortcode');

function practice_areas_list_shortcode()
{

    return practice_areas_list();
}
add_shortcode('practice_areas_list', 'practice_areas_list_shortcode');

function maat_iconbox_shortcode($atts)
{

    // Attributes
    $atts = shortcode_atts(
        array(
            'link'    => '',
            'target'  => 'self',
            'icon'    => '',
            'title'   => '',
            'content' => '',
            'id'      => '',
            'class'   => '',
        ),
        $atts
    );

    $iconBox = '<div';
    $iconBox .= (!empty($atts['id'])) ? ' id="' . $atts['id'] . '"' : '';
    $iconBox .= ' class="icon-box-wrapper';
    $iconBox .= (!empty($atts['class'])) ? ' ' . $atts['class'] : '';
    $iconBox .= '">';
    $iconBox .= (!empty($atts['link'])) ? '<a href="' . $atts['link'] . '" target="_' . $atts['target'] . '" title="' . $atts['title'] . '" class="icon-box-wrapper-inner">' : '<div class="icon-box-wrapper-inner">';
    $iconBox .= (!empty($atts['icon'])) ? '<div class="icon-box-icon"><i class="' . $atts['icon'] . '"></i></div>' : '';
    $iconBox .= (!empty($atts['title']) || !empty($atts['content'])) ? '<div class="icon-box-content">' : '';
    $iconBox .= (!empty($atts['title'])) ? '<div class="icon-box-title">' . $atts['title'] . '</div>' : '';
    $iconBox .= (!empty($atts['content'])) ? '<div class="icon-box-text">' . $atts['content'] . '</div>' : '';
    $iconBox .= (!empty($atts['title']) || !empty($atts['content'])) ? '</div>' : '';
    $iconBox .= (!empty($atts['link'])) ? '</a>' : '</div>';
    $iconBox .= '</div>';
    return $iconBox;
}
add_shortcode('iconbox', 'maat_iconbox_shortcode');

function resources_menu_shortcode()
{

    $menu = wp_nav_menu(
        array(
            'container'       => 'nav',
            'menu'            => 'resources-page-menu',
            'menu_class'      => 'custom-menu menu list-group list-group-horizontal nav',
            'container_class' => 'resources-grid menu-resources-page-menu-container',
            'container_id'    => 'resources-menu'
        )
    );
    $js   = '<script type="text/javascript">
            jQuery(function ($) {

                function maxBoxHeight2(elem) {
                    var elementHeights = $(elem)
                        .map(function () {
                            return $(this).outerHeight();
                        })
                        .get();
                    var maxHeight = Math.min.apply(null, elementHeights);
                    $(elem).css("max-height", maxHeight);
                }

                $(document).ready(function () {
                    maxBoxHeight2(".menu-resources-container li");
                });
                $(window).resize(function () {
                    maxBoxHeight2(".menu-resources-container li");
                });
            });
            </script>';

    return $menu;
}
add_shortcode('resources_menu', 'resources_menu_shortcode');

function copyright_shortcode()
{

    return 'Copyright &copy; ' . date('Y') . ' ' . get_bloginfo('name') . ', All Rights Reserved.';
}
add_shortcode('copyright', 'copyright_shortcode');

function youtube_shortcode($atts)
{

    // Attributes
    $atts = shortcode_atts(
        array(
            'id'    => '',
            'class' => '',
        ),
        $atts
    );

    return maat_youtube_video($atts['id'], $atts['class']);
}
add_shortcode('maat_youtube', 'youtube_shortcode');

function youtube_playlist_shortcode($atts)
{

    // Attributes
    $atts = shortcode_atts(
        array(
            'id'    => '',
            'class' => '',
            'columns' => '',
            'video_classes' => ''
        ),
        $atts
    );

    extract($atts);

    return maat_youtube_playlist($id, $class, $columns, $video_classes);
}
add_shortcode('maat_youtube_playlist', 'youtube_playlist_shortcode');

function youtube_video_shortcode($atts)
{

    // Attributes
    $atts = shortcode_atts(
        array(
            'id'    => '',
            'class' => '',
        ),
        $atts
    );

    return maat_youtube_video($atts['id'], $atts['class']);
}
add_shortcode('maat_youtube_video', 'youtube_video_shortcode');



function maat_modal_shortcode($atts)
{

    // Attributes
    $atts = shortcode_atts(
        array(
            'link_title' => '',
            'link_class' => '',
            'link_icon' => '',
            'popup' => '',
            'popup_class' => '',
        ),
        $atts
    );
    extract($atts);

    $modal_id = get_post_id_by_slug($popup, 'maat_modal');
    $link = '';
    if ($modal_id !== null) {

        $link_classes = array(
            'btn',
        );

        $title = (!empty($link_title)) ? $link_title : get_the_title($modal_id);

        $target = get_the_slug($modal_id);

        $link_atts = array(
            'type' => 'button',
            'data-toggle' => 'modal',
            'title' => $title,
            'data-target' => '#' . $target . '-modal',
            'class' => maat_item_classes($link_class, $link_classes)
        );
        $link_atts = maat_add_item_data($link_atts);


        $icon_html = (!empty($link_icon)) ? '<i class="' . $link_icon . ' left-icon"></i>' : '';
        $text_html = (!empty($title)) ? '<span class="btn-txt">' . $title . '</span>' : '';

        $link .= wp_sprintf('<button%s>%s%s</button>', $link_atts, $icon_html, $text_html);

        $link .= displayModal($modal_id);
    } else {
        $link = '<div class="alert alert-danger" role="alert">Modal does not exist</div>';
    }

    return $link;
}
add_shortcode('maat_popup', 'maat_modal_shortcode');

function maat_social_share()
{

    return displaySocialShare();
}
add_shortcode('social_share', 'maat_social_share');
