<?php
$elem = 'vc_wp_custommenu';

$newAtts = array(
    array(
        'type'        => 'textfield',
        'heading'     => 'Menu Container Class',
        'param_name'  => 'menu_container_class',
        'description' => __('Class for the menu container', 'maat'),
    ),
    array(
        'type'        => 'textfield',
        'heading'     => 'Menu Class',
        'param_name'  => 'menu_class',
        'description' => __('Class for the menu', 'maat'),
    ),
);
maatAddAtts($elem, $newAtts);
