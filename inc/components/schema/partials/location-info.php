<?php
function formatHoursofBusiness($hob = array(), $time_format = 'g:ia', $day_format = 'D')
{
    $all_schedules = '';
    $schedules     = $hob;
    if (count($schedules) > 1) {
        $all_schedules .= '<span class="multi-line-wrap">';
    }

    foreach ($schedules as $schedule) {
        $open_days  = $schedule['applicable_days'];
        $open_time  = $schedule['opening_time'];
        $close_time = $schedule['closing_time'];
        $all_schedules .= '<span class="business-schedule">';
        if ($open_days) {
            $day_01 = strtotime($open_days[0]);
            $all_schedules .= '<span class="business-days">';

            if (count($open_days) > 1) {
                $day_02 = strtotime(end($open_days));
                $all_schedules .= '<time class="day-value open">' . date($day_format, $day_01) . '</time><span class="day-label divider">&ndash;</span><time class="day-value closed">' . date($day_format, $day_02) . ': </time>';
            } else {
                $all_schedules .= '<time class="day-value open">' . date($day_format, $day_01) . ': </time>';
            }

            $all_schedules .= '</span>';
        }

        if (!empty($open_time) || !empty($close_time)) {
            $open_time  = strtotime($open_time);
            $close_time = strtotime($close_time);
            $all_schedules .= '<span class="business-hours">';

            if (!empty($open_time)) {
                $all_schedules .= '<time class="time-value open">' . date($time_format, $open_time) . '</time>';
            }
            if (!empty($open_time) && !empty($close_time)) {
                $all_schedules .= '<span class="time-label divider">&ndash;</span>';
            }

            if (!empty($close_time)) {
                $all_schedules .= '<time class="time-value closed">' . date($time_format, $close_time) . '</time>';
            }
            $all_schedules .= '</span>';
        }

        $all_schedules .= '</span>';
    }
    if (count($schedules) > 1) {
        $all_schedules .= '</span>';
    }

    return $all_schedules;
}

function displayAddress($args = array())
{

    $item_id  = '';
    $defaults = array(
        'wrapper'    => 1,
        'class'      => '',
        'title'      => '',
        'icon'       => 0,
        'link'       => 0,
        'directions' => 0,
        'content'    => '',
    );

    $options = wp_parse_args($args, $defaults);

    extract($options);

    if (empty($content)) {
        return;
    }

    extract($content);

    $content_url   = (!empty($map_url)) ? $map_url : 'http://maps.google.com/?q=' . urlencode($full);

    $wrapper_classes = array(
        'schema-info-block',
        'address',
        $class,
    );

    $wrapper_atts = array(
        'id'    => 'location-address-' . $item_id,
        'class' => maat_item_classes($wrapper_classes),
    );

    $link_atts = array(
        'href'   => esc_url($content_url),
        'title'  => esc_attr__('Get Directions to ' . $full, 'maat'),
        'rel'    => 'nofollow',
        'target' => '_blank',
        'class'  => 'schema-info address',
    );

    $schema_info = '';
    if (!empty($title)) {
        $schema_info .= '<h5 class="schema-item-title">' . $title . '</h5>';
        $link_atts['title'] = esc_attr__($title, 'maat');
    }
    if ($wrapper == 1) {
        $schema_info .= (!empty($wrapper)) ? '<address' . maat_add_item_data($wrapper_atts) . '>' : '';
    }

    if ($link == 1) {
        $schema_info .= '<a' . maat_add_item_data($link_atts) . '>';
    } else {
        $schema_info .= '<span class="schema-info address">';
    }
    if ($icon == 1) {
        $schema_info .= '<span class="schema-icon"></span>';
    }
    if (($street || $unit) || ($city || $state || $zip)) {
        $schema_info .= '<span class="multi-line-wrap">';
    }
    if ($street || $unit) {
        $schema_info .= '<span class="address-line-1">';
        $schema_info .= (!empty($street)) ? '<span class="address-street">' . $street . '&thinsp;</span>' : '';
        $schema_info .= (!empty($unit)) ? '<span class="address-unit">' . $unit . '</span>' : '';
        $schema_info .= '</span>';
    }

    if ($city || $state || $zip) {
        $schema_info .= '<span class="address-line-2">';
        $schema_info .= (!empty($city)) ? '<span class="address-city">' . $city . ',&thinsp;</span>' : '';
        $schema_info .= (!empty($state)) ? '<span class="address-state">' . $state . '&thinsp;</span>' : '';
        $schema_info .= (!empty($zip)) ? '<span class="address-zip">' . $zip . '</span>' : '';
        $schema_info .= '</span>';
    }

    if ($directions == 1) {
        $schema_info .= '<span class="directions">Get Directions &raquo;</span>';
    }

    if (($street || $unit) || ($city || $state || $zip)) {
        $schema_info .= '</span>';
    }

    if ($link == 1) {
        $schema_info .= '</a>';
    } else {
        $schema_info .= '</span>';
    }
    if ($wrapper == 1) {
        $schema_info .= '</address>';
    }
    return $schema_info;
}

function displayPhone($args = array())
{
    $item = 'phone';

    $defaults = array(
        'wrapper' => 1,
        'class'   => '',
        'title'   => '',
        'icon'    => 0,
        'link'    => 1,
        'content' => '',
    );

    $options = wp_parse_args($args, $defaults);
    extract($options);

    if (empty($content)) {
        return;
    }

    $wrapper_classes = array(
        'schema-info-block',
        $item,
    );

    $wrapper_atts = array(
        'class' => maat_item_classes($wrapper_classes, $class),
    );

    $classes = array(
        $item,
        'schema-info',
    );

    $classes = maat_item_classes($classes, $class);

    $link_atts = array(
        'href'  => $content,
        'rel'   => 'nofollow',
        'class' => $classes,
    );

    $schema_info = '';
    if (!empty($title)) {
        $schema_info .= '<h5 class="schema-item-title">' . $title . '</h5>';
        $link_atts['title'] = esc_attr__($title, 'maat');
    } else {
        $link_atts['title'] = esc_attr__('Place a call to ' . $content, 'maat');
    }
    if ($wrapper == 1) {
        $schema_info .= (!empty($wrapper)) ? '<div' . maat_add_item_data($wrapper_atts) . '>' : '';
    }

    if ($link == 1) {
        $schema_info .= '<a' . maat_add_item_data($link_atts) . '>';
    } else {
        $schema_info .= '<span class="' . $classes . '">';
    }
    if ($icon == 1) {
        $schema_info .= '<span class="schema-icon"></span><span class="schema-text">';
    }

    $schema_info .= $content;
    if ($icon == 1) {
        $schema_info .= '</span>';
    }
    if ($link == 1) {
        $schema_info .= '</a>';
    } else {
        $schema_info .= '</span>';
    }
    if ($wrapper == 1) {
        $schema_info .= '</div>';
    }
    return $schema_info;
}

function displayFax($args = array())
{
    $item = 'fax';

    $defaults = array(
        'wrapper' => 1,
        'class'   => '',
        'title'   => '',
        'icon'    => 0,
        'link'    => 0,
        'content' => '',
    );

    $options = wp_parse_args($args, $defaults);
    extract($options);

    if (empty($content)) {
        return;
    }

    $wrapper_classes = array(
        'schema-info-block',
        $item,
    );

    $wrapper_atts = array(
        'class' => maat_item_classes($wrapper_classes, $class),
    );

    $link_atts = array(
        'href'  => $content,
        'rel'   => 'nofollow',
        'class' => 'schema-info ' . $item,
    );

    $classes = array(
        $item,
        'schema-info',
        $class
    );

    $classes = maat_item_classes($classes);

    $schema_info = '';
    if (!empty($title)) {
        $schema_info .= '<h5 class="schema-item-title">' . $title . '</h5>';
        $link_atts['title'] = esc_attr__($title, 'maat');
    } else {
        $link_atts['title'] = esc_attr__('Send a fax to ' . $content, 'maat');
    }
    if ($wrapper == 1) {
        $schema_info .= (!empty($wrapper)) ? '<div' . maat_add_item_data($wrapper_atts) . '>' : '';
    }

    if ($link == 1) {
        $schema_info .= '<a' . maat_add_item_data($link_atts) . '>';
    } else {
        $schema_info .= '<span class="' . $classes . '">';
    }
    if ($icon == 1) {
        $schema_info .= '<span class="schema-icon"></span>';
    }

    $schema_info .= $content;

    if ($link == 1) {
        $schema_info .= '</a>';
    } else {
        $schema_info .= '</span>';
    }
    if ($wrapper == 1) {
        $schema_info .= '</div>';
    }
    return $schema_info;
}

function displayEmail($args = array())
{
    $item = 'email';

    $defaults = array(
        'wrapper' => 1,
        'class'   => '',
        'title'   => '',
        'icon'    => 0,
        'link'    => 1,
        'content' => '',
    );

    $options = wp_parse_args($args, $defaults);
    extract($options);

    if (empty($content)) {
        return;
    }

    $wrapper_classes = array(
        'schema-info-block',
        $item,
    );

    $wrapper_atts = array(
        'class' => maat_item_classes($wrapper_classes, $class),
    );

    $classes = array(
        $item,
        'schema-info',
    );

    $classes = maat_item_classes($classes, $class);

    $link_atts = array(
        'href'  => $content,
        'rel'   => 'nofollow',
        'class' => $classes,
    );

    $schema_info = '';
    if (!empty($title)) {
        $schema_info .= '<h5 class="schema-item-title">' . $title . '</h5>';
        $link_atts['title'] = esc_attr__($title, 'maat');
    } else {
        $link_atts['title'] = esc_attr__('Send an email to ' . $content, 'maat');
    }
    if ($wrapper == 1) {
        $schema_info .= (!empty($wrapper)) ? '<div' . maat_add_item_data($wrapper_atts) . '>' : '';
    }

    if ($link == 1) {
        $schema_info .= '<a' . maat_add_item_data($link_atts) . '>';
    } else {
        $schema_info .= '<span class="' . $classes . '">';
    }
    if ($icon == 1) {
        $schema_info .= '<span class="schema-icon"></span><span class="schema-text">';
    }

    $schema_info .= $content;
    if ($icon == 1) {
        $schema_info .= '</span>';
    }
    if ($link == 1) {
        $schema_info .= '</a>';
    } else {
        $schema_info .= '</span>';
    }
    if ($wrapper == 1) {
        $schema_info .= '</div>';
    }
    return $schema_info;
}

function displayHOB($args = array())
{

    $item_id  = '';
    $defaults = array(
        'wrapper' => 1,
        'class'   => '',
        'title'   => '',
        'icon'    => 0,
        'content' => '',
    );

    $options = wp_parse_args($args, $defaults);
    $wrapper = $options['wrapper'];
    $class   = $options['class'];
    $title   = $options['title'];
    $content = $options['content'];
    $icon    = $options['icon'];

    if (empty($content)) {
        return;
    }

    $wrapper_classes = array(
        'schema-info-block',
        'hours-of-business',
        $class,
    );

    $wrapper_atts = array(
        'id'    => 'location-hours-of-business-' . $item_id,
        'class' => maat_item_classes($wrapper_classes),
    );

    $schema_info = '';
    if (!empty($title)) {
        $schema_info .= '<h5 class="schema-item-title">' . $title . '</h5>';
    }
    if ($wrapper == 1) {
        $schema_info .= (!empty($wrapper)) ? '<div' . maat_add_item_data($wrapper_atts) . '>' : '';
    }

    $schema_info .= '<span class="schema-info hours-of-business">';

    if ($icon == 1) {
        $schema_info .= '<span class="schema-icon"></span>';
    }

    $schema_info .= formatHoursofBusiness($content);
    $schema_info .= '</span>';

    if ($wrapper == 1) {
        $schema_info .= '</div>';
    }
    return $schema_info;
}

function getLocationInfo($location = '')
{
    $location_info = array();
    $address       = get_field('location_address', $location);
    $phone         = get_field('location_phone', $location);
    $fax           = get_field('location_fax', $location);
    $email         = get_field('location_email', $location);
    $map_url       = get_field('location_map_url', $location);
    $hob           = get_field('location_hob', $location);

    if (!empty($address)) {
        $street       = $address['street'];
        $unit         = $address['unit'];
        $city         = $address['city'];
        $state        = $address['state'];
        $zip          = $address['zip'];
        $lat          = $address['latitude'];
        $lng          = $address['longitude'];
        $full_address = '';
        $full_address .= (!empty($street)) ? $street : '';
        $full_address .= (!empty($unit)) ? ' ' . $unit . ',' : '';
        $full_address .= (!empty($city)) ? ' ' . $city . ',' : '';
        $full_address .= (!empty($state)) ? ' ' . $state : '';
        $full_address .= (!empty($zip)) ? ' ' . $zip : '';
        $location_address = array(
            'full'   => $full_address,
            'street' => $street,
            'unit'   => $unit,
            'city'   => $city,
            'state'  => $state,
            'zip'    => $zip,
            'lat'    => $lat,
            'lng'    => $lng,
        );
        if (!empty($map_url)) {
            $location_address['map_url'] = $map_url;
        }
        $location_info['address'] = $location_address;
    }
    if (!empty($phone)) {
        $location_info['phone'] = $phone;
    }
    if (!empty($email)) {
        $location_info['email'] = $email;
    }
    if (!empty($fax)) {
        $location_info['fax'] = $fax;
    }
    if (!empty($hob)) {
        $location_info['hob'] = $hob;
    }
    return $location_info;
}

function displayLocationInfo($location_id = '', $args = array())
{
    $item_id  = '';
    $defaults = array(
        'wrapper'     => '',
        'class'       => '',
        'title'       => '',
        'show_parent' => 0,
        'address'     => array(
            'display'    => 0,
            'wrapper'    => 1,
            'class'      => '',
            'title'      => '',
            'directions' => 0,
            'link'       => 0,
            'icon'       => 0,
        ),
        'phone'       => array(
            'display' => 0,
            'wrapper' => 1,
            'class'   => '',
            'title'   => '',
            'link'    => 0,
            'icon'    => 0,
        ),
        'fax'         => array(
            'display' => 0,
            'wrapper' => 1,
            'class'   => '',
            'title'   => '',
            'link'    => 0,
            'icon'    => 0,
        ),
        'email'       => array(
            'display' => 0,
            'wrapper' => 1,
            'class'   => '',
            'title'   => '',
            'link'    => 0,
            'icon'    => 0,
        ),
        'hob'         => array(
            'display' => 0,
            'wrapper' => 1,
            'class'   => '',
            'title'   => '',
            'icon'    => 0,
        ),

    );

    $options     = wp_parse_args($args, $defaults);
    extract($options);

    $title       = (!empty($title)) ? '<h4 class="widget-title schema-title">' . $options['title'] . '</h4>' : '';

    $address_display    = $address['display'];
    $address_wrapper    = $address['wrapper'];
    $address_class      = $address['class'];
    $address_title      = $address['title'];
    $address_directions = $address['directions'];
    $address_link       = $address['link'];
    $address_icon       = $address['icon'];

    $phone_display = $phone['display'];
    $phone_wrapper = $phone['wrapper'];
    $phone_class   = $phone['class'];
    $phone_title   = $phone['title'];
    $phone_link    = $phone['link'];
    $phone_icon    = $phone['icon'];

    $fax_display = $fax['display'];
    $fax_wrapper = $fax['wrapper'];
    $fax_class   = $fax['class'];
    $fax_title   = $fax['title'];
    $fax_link    = $fax['link'];
    $fax_icon    = $fax['icon'];

    $email_display = $email['display'];
    $email_wrapper = $email['wrapper'];
    $email_class   = $email['class'];
    $email_title   = $email['title'];
    $email_link    = $email['link'];
    $email_icon    = $email['icon'];

    $hob_display = $hob['display'];
    $hob_wrapper = $hob['wrapper'];
    $hob_class   = $hob['class'];
    $hob_title   = $hob['title'];
    $hob_icon    = $hob['icon'];

    $parent_ID = get_field('parent_location', 'options');
    $parent_ID = intval($parent_ID);

    if (!empty($location_id)) {
        $item_id = $location_id;
    } elseif ($show_parent == 1) {
        $item_id = $parent_ID;
    } else {
        return;
    }
    $info        = getLocationInfo($item_id);
    $parent_info = '';
    if ($location_id != $parent_ID) {
        $parent_info = getLocationInfo($parent_ID);
    }
    // ---------------------------- Start Wrapper --------------------------- //

    $wrapper_classes = array(
        'schema-info-container',
        $class,
    );

    $wrapper_atts = array(
        'id'    => 'location-info-' . $item_id,
        'class' => maat_item_classes($wrapper_classes),
    );

    $schema_info = '';
    $schema_info .= (!empty($wrapper)) ? '<' . $wrapper . maat_add_item_data($wrapper_atts) . '>' : '';
    $schema_info .= $title;

    // ------------------------------- Address ------------------------------ //
    $location_address = '';
    if (isset($info['address']) && !empty($info['address'])) {
        $location_address = $info['address'];
    } elseif ($show_parent == 1) {
        $location_address = $parent_info['address'];
    }
    if (!empty($location_address) && $address_display == 1) {

        $args = array(
            'wrapper'    => $address_wrapper,
            'class'      => $address_class,
            'title'      => $address_title,
            'icon'       => $address_icon,
            'link'       => $address_link,
            'directions' => $address_directions,
            'content'    => $location_address,
        );

        $schema_info .= displayAddress($args);
    }

    // -------------------------------- Phone ------------------------------- //
    $location_phone = '';
    if (isset($info['phone']) && !empty($info['phone'])) {
        $location_phone = $info['phone'];
    } elseif ($show_parent == 1) {
        $location_phone = $parent_info['phone'];
    }

    if (!empty($location_phone) && $phone_display == 1) {

        $args = array(
            'wrapper' => $phone_wrapper,
            'class'   => $phone_class,
            'title'   => $phone_title,
            'icon'    => $phone_icon,
            'link'    => $phone_link,
            'content' => $location_phone,
        );

        $schema_info .= displayPhone($args);
    }

    // --------------------------------- Fax -------------------------------- //
    $location_fax = '';
    if (isset($info['fax']) && !empty($info['fax'])) {
        $location_fax = $info['fax'];
    } elseif ($show_parent == 1) {
        $location_fax = $parent_info['fax'];
    }

    if (!empty($location_fax) && $fax_display == 1) {

        $args = array(
            'wrapper' => $fax_wrapper,
            'class'   => $fax_class,
            'title'   => $fax_title,
            'icon'    => $fax_icon,
            'link'    => $fax_link,
            'content' => $location_fax,
        );

        $schema_info .= displayFax($args);
    }

    // -------------------------------- Email ------------------------------- //
    $location_email = '';
    if (isset($info['email']) && !empty($info['email'])) {
        $location_email = $info['email'];
    } elseif ($show_parent == 1) {
        $location_email = $parent_info['email'];
    }

    if (!empty($location_email) && $email_display == 1) {

        $args = array(
            'wrapper' => $email_wrapper,
            'class'   => $email_class,
            'title'   => $email_title,
            'icon'    => $email_icon,
            'link'    => $email_link,
            'content' => $location_email,
        );

        $schema_info .= displayEmail($args);
    }

    // -------------------------- Hours of Business ------------------------- //
    $location_hob = '';
    if (isset($info['hob']) && !empty($info['hob'])) {
        $location_hob = $info['hob'];
    } elseif ($show_parent == 1) {
        $location_hob = $parent_info['hob'];
    }

    if (!empty($location_hob) && $hob_display == 1) {

        $args = array(
            'wrapper' => $hob_wrapper,
            'class'   => $hob_class,
            'title'   => $hob_title,
            'icon'    => $hob_icon,
            'content' => $location_hob,
        );

        $schema_info .= displayHOB($args);
    }

    // ----------------------------- End Wrapper ---------------------------- //

    $schema_info .= (!empty($wrapper)) ? '</' . $wrapper . '>' : '';

    return $schema_info;
}
