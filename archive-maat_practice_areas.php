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
 * Last Modified: 7-30-19 at 10:53 am
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */

get_header();
$id      = get_the_ID();
$item    = maat_item_type($id);
$title   = maat_item_title($id);
$classes = get_post_class(array('content-item'), $id);

$loop_classes = array(
    $item . '-loop',
    'row',
    'no-gutters',
    'hover-box-row'
);

$loop_atts = array(
    'class' => maat_item_classes($loop_classes),
    'id'       => $item . '-archive',
    'itemprop' => 'mainEntity',
    'role'     => 'main',
);

$content_file = COMPONENT_PATH . '/' . $item . '/partials/archive-loop.php';
$nav_file     = COMPONENT_PATH . '/' . $item . '/partials/archive-nav.php';

?>
<?php get_component_partial($item, 'archive-content'); ?>
<div class="section-wrapper">
    <div class="section-inner p-0">
        <div class="container-fluid">
            <section <?php echo maat_add_item_data($loop_atts); ?>>
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        get_component_partial($item, 'loop-item');
                    }
                }
                ?>
            </section>
        </div>
    </div>
</div>

<?php get_footer(); ?>
