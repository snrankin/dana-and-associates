<?php
$next_post = get_next_post();
$id = $next_post->ID;
$classes = array(
    'single-nav-item',
    'next-post',
    'd-flex',
    'flex-row',
    'align-items-center'
);
$args = array(
    'wrapper_classes'       => $classes,
    'body_classes'          => 'w-75',
    'add_image'             => 1,
    'image_wrapper_classes' => 'w-25 order-md-last',
    'image_classes'         => '',
    'image_size'            => 'admin-thumb',
    'add_title'             => 1,
    'before_title'          => '<h4 class="text-md-right">Next Post:</h4>',
    'title_tag'             => 'h5',
    'title_classes'         => 'text-md-right',
);
?>
<?php if (!empty($next_post)) : ?>
<div class="col-ms-6">
    <div class="content-wrapper">
        <div class="content-item">
            <?php echo maat_blog_grid_item($id, $args); ?>
        </div>
    </div>
</div>
<?php endif; ?>
