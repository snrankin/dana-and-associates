<?php
get_header();
$id      = get_the_ID();
$item    = maat_item_type($id);
$title   = maat_item_title($id);
$classes = get_post_class(array('content-item'), $id);

$column = 8;

$wrapper_atts = array(
    'id'        => $item . '-archive',
    'itemprop'  => 'mainEntity',
    'role'      => 'main',
    'class'     => 'col-ml-' . $column,
);

$loop_classes = array(
    $item . '-loop',
    'row',
);

$loop_atts = array(
    'id'    => $item . '-loop',
    'class' => maat_item_classes($loop_classes, $classes),
);

$content_file = COMPONENT_PATH . '/' . $item . '/partials/archive-loop.php';
$nav_file     = COMPONENT_PATH . '/' . $item . '/partials/archive-nav.php';

?>
<div class="section-wrapper">
    <div class="section-inner">
        <div class="container">
            <div class="row">
                <div <?php echo maat_add_item_data($wrapper_atts); ?>>
                    <?php get_component_partial($item, 'archive-content'); ?>
                    <?php
                    if (have_posts()) {
                        echo '<section ' . maat_add_item_data($loop_atts) . '>';
                        while (have_posts()) {
                            the_post();
                            get_component_partial($item, 'loop-item');
                        }
                        echo '</section>';
                        (file_exists($nav_file)) ? get_component_partial($item, 'archive-nav') : get_component_partial('pagination', 'archive-nav');
                    }
                    ?>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
