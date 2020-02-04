<?php
$args = array(
    'wrapper_classes'       => 'd-md-flex align-items-start border-bottom',
    'body_classes'          => 'w-75',
    'add_image'             => 1,
    'image_wrapper_classes' => 'w-25 embed-responsive border',
    'image_classes'         => 'embed-responsive-item',
    'image_size'            => 'medium',
    'before_title'          => '',
    'add_title'             => 1,
    'title_tag'             => 'h4',
    'title_classes'         => '',
    'after_title'           => '',
    'add_excerpt'           => 1,
    'excerpt_classes'       => '',
    'add_link'              => 1,
    'link_classes'          => 'btn btn-sm btn-primary stretched-link',
    'add_meta'              => 0,
    'meta_classes'          => 'archive-blog-meta',
    'add_author'            => 0,
    'author_classes'        => '',
    'add_date'              => 0,
    'date_classes'          => '',
    'add_tags'              => 0,
    'tag_classes'           => '',
    'add_cats'              => 0,
    'cat_classes'           => '',
);


?>

<div class="col-12">
    <div class="content-wrapper">
        <?php echo maat_blog_grid_item(get_the_ID(), $args); ?>
    </div>
</div>
