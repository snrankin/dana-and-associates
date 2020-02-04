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
 * Last Modified: 7-18-19 at 6:39 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */

get_header();
$id   = get_the_ID();
$item = 'location';

$wrapper_atts = array(
    'id'       => $item . '-archive',
    'itemprop' => 'mainEntity',
    'role'     => 'main',
    'class'    => 'col-12',
);

$loop_classes = array(
    $item . '-loop',
    'row',
);

$loop_atts = array(
    'id'    => $item . '-loop',
    'class' => maat_item_classes($loop_classes),
);

$content_file = COMPONENT_PATH . '/' . $item . '/partials/archive-loop.php';
$nav_file     = COMPONENT_PATH . '/' . $item . '/partials/archive-nav.php';

?>

<div class="section-wrapper">
    <div class="section-inner">
        <div class="container">
            <div class="row justify-content-center">
                <?php get_component_partial($item, 'archive-content'); ?>
                <div <?php echo maat_add_item_data($wrapper_atts); ?>>
                    <section <?php echo maat_add_item_data($loop_atts); ?>>
                        <?php if (have_posts()): ?>
                        <?php while (have_posts()): ?>
                        <?php the_post(); ?>
                        <div class="col-ms-6 col-mdl-4 col-lg-3">
                        <?php get_component_partial($item, 'loop-item'); ?>
                        </div>
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
