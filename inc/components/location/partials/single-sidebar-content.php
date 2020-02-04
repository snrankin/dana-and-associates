<?php
$id = get_the_ID();

$item_id  = '';
$args = array(
    'wrapper'     => '',
    'class'       => '',
    'title'       => 'Location Info',
    'show_parent' => 0,
    'address'     => array(
        'display'    => 1,
        'wrapper'    => 1,
        'class'      => '',
        'title'      => 'Address',
        'directions' => 1,
        'link'       => 1,
        'icon'       => 0,
    ),
    'phone'       => array(
        'display' => 1,
        'wrapper' => 1,
        'class'   => '',
        'title'   => 'Phone',
        'link'    => 1,
        'icon'    => 0,
    ),
    'fax'         => array(
        'display' => 1,
        'wrapper' => 1,
        'class'   => '',
        'title'   => 'Fax',
        'link'    => 1,
        'icon'    => 0,
    ),
    'email'       => array(
        'display' => 1,
        'wrapper' => 1,
        'class'   => '',
        'title'   => 'Email',
        'link'    => 1,
        'icon'    => 0,
    ),
    'hob'         => array(
        'display' => 1,
        'wrapper' => 1,
        'class'   => '',
        'title'   => 'Hours of Business',
        'icon'    => 0,
    ),

);

echo displayLocationInfo($id, $args);
