<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  7-25-19
 * Last Modified: 7-25-19 at 12:25 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date    	By	Comments
 * --------	--	--------------------------------------------------------------
 * ========================================================================= */

function maat_carousel($id = '', &$content = '', &$wrapper_class = 'maat-carousel owl-carousel', $args = array())
{
    $defaults = array();
    $options = wp_parse_args($args, $defaults);
    extract($args);

    $id_num = vc_random_string();

    if (empty($id)) : $id = 'maat-carousel-' . $id_num;
    endif;

    $json = json_encode($options);

    $wrapper_attributes = array(
        'id'                => $id,
        'class'             => maat_item_classes($wrapper_class),
        'data-owlcarousel'  => $json
    );

    $carousel = '';

    if (!empty($content)) {
        $carousel .= '<div' . maat_add_item_data($wrapper_attributes) . '>';
        $carousel .= $content;
        $carousel .= '</div>';
    }
    return $carousel;
}
