<?php

$settings = get_option('maat_theme');

/**
 * Combine theme options into one mySQL row
 *
 * @return void
 */
function combine_theme_options()
{
    $fields       = get_fields('option');
    $field_values = array();
    if ($fields) {
        foreach ($fields as $field_name => $value) {
            if (!is_object($value)) {
                $field_values[$field_name] = $value;
            }
        }
        update_option('maat_theme', $field_values, true);
    }
}
add_action('acf/save_post', 'combine_theme_options', 20);
