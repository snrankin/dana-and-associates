<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  7-18-19
 * Last Modified: 8-4-19 at 10:55 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */
?>

<div class="content-wrapper">
    <div class="content-item">
        <?php
        $slug        = get_the_slug(get_the_ID());
        $location_id = get_the_ID();
        $args        = array(
            'wrapper'     => 'div',
            'class'       => 'location-list-grid-item',
            'title'       => get_the_title(),
            'show_parent' => 0,
            'address'     => array(
                'display' => 1,
                'icon'    => 1,
            ),
            'phone'       => array(
                'display' => 1,
                'icon'    => 1,
            ),

        );

        echo displayLocationInfo($location_id, $args);
        $link_title_args = array(
            'before' => __('Get Directions to Our '),
            'after'  => __(' Office'),
            'echo'   => 0,
        );
        $link_title = the_title_attribute($link_title_args);

        ?>
        <a href="<?php the_permalink(); ?>" title="<?php _e($link_title, 'maat'); ?>" class="stretched-link d-flex">
            <i class="dana dana-location-map text-secondary schema-icon"></i>
            <span><?php _e('Get Directions', 'maat'); ?></span>

        </a>
    </div>
</div>
