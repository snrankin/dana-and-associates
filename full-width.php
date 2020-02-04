<?php
/*
Template Name: Full Width
 */
?>
<?php
if (!post_password_required()) {
    get_header();
    the_post();

    $layout  = gt3_option('page_sidebar_layout');
    $sidebar = gt3_option('page_sidebar_def');
    $id      = gt3_get_queried_object_id();
    if (class_exists('RWMB_Loader') && $id !== 0) {
        $mb_layout = rwmb_meta('mb_page_sidebar_layout', array(), $id);
        if (!empty($mb_layout) && $mb_layout != 'default') {
            $layout  = $mb_layout;
            $sidebar = rwmb_meta('mb_page_sidebar_def', array(), $id);
        }
    }
    $column = 12;
    if ($layout == 'left' || $layout == 'right') {
        $column = 9;
    } else {
        $sidebar = '';
    }
    $row_class = ' sidebar_' . esc_attr($layout);
    ?>

<div itemprop="mainEntityOfPage">
    <?php the_content(esc_html__('Read more!', 'oconnor')); ?>
    <?php wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'oconnor') . ': ', 'after' => '</div>')); ?>
    <?php if (gt3_option("page_comments") == "1") { ?>
    <?php comments_template(); ?>
    <?php } ?>
    </div>
<?php get_footer();
} else {
    get_header();
    ?>
<div class="wrapper_404 pp_block">
    <div class="container_vertical_wrapper">
        <div class="container a-center pp_container">
            <h1><?php echo esc_html__('Password Protected', 'oconnor'); ?></h1>
            <h2><?php echo esc_html__('This content is password protected. Please enter your password below to continue.', 'oconnor'); ?></h2>
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php
get_footer();
}
