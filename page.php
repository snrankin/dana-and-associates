<?php
if (!post_password_required()) {
    get_header();
    the_post();

    $id      = get_the_ID();
    $item    = maat_item_type($id);
    $title   = maat_item_title($id);
    $classes = get_post_class(array('content-item'), $id);

    $wrapper_classes = array(
        'main-content'
    );

    $layout  = gt3_option('page_sidebar_layout');
    $sidebar = gt3_option('page_sidebar_def');
    if (class_exists('RWMB_Loader') && $id !== 0) {
        $mb_layout = rwmb_meta('mb_page_sidebar_layout', array(), $id);
        if (!empty($mb_layout) && $mb_layout != 'default') {
            $layout  = $mb_layout;
            $sidebar = rwmb_meta('mb_page_sidebar_def', array(), $id);
        }
    }
    $column        = 12;
    if ($layout == 'left' || $layout == 'right') {
        $column = 'ml-' . 8;
        if ($layout == 'left') {
            $wrapper_classes[] = 'order-lg-last';
        }
    } else {
        $sidebar = '';
    }
    $wrapper_classes[] = 'col-' . $column;

    $wrapper_classes = maat_item_classes($wrapper_classes, $classes);


    $wrapper_atts = array(
        'id'       => $item . '-content',
        'itemprop' => 'mainEntityOfPage',
        'role'     => 'main',
        'class'    => $wrapper_classes,
    );
    ?>
<div class="section-wrapper">
    <div class="section-inner">
        <div class="container">
            <div class="row">
                <article <?php echo maat_add_item_data($wrapper_atts); ?>>
                    <div class="content-wrapper">
                        <div class="content-item">
                            <?php the_content(); ?>
                        </div>
                        <?php
                            wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'oconnor') . ': ', 'after' => '</div>'));
                            if (gt3_option("page_comments") == "1") { ?>
                        <?php comments_template(); ?>
                        <?php } ?>
                    </div>
                </article>
                <?php
                    if ($layout == 'left' || $layout == 'right') {
                        get_sidebar();
                    }
                    ?>
            </div>
        </div>
    </div>
</div>
<?php

    get_footer();
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
