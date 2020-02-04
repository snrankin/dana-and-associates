<?php
global $post;
$item = maat_item_type();
if (is_blog()) {
    $item_id = get_option('page_for_posts');
} elseif ($item === 'practice-area') {
    $item = 'practice-areas';
} else {
    $item_id = $id;
}
$sidebar = gt3_option('page_sidebar_def');
if (class_exists('RWMB_Loader') && $id !== 0) {
    $mb_layout = rwmb_meta('mb_page_sidebar_layout', array(), $id);
    if (!empty($mb_layout) && $mb_layout != 'default') {
        $layout  = $mb_layout;
        $sidebar = rwmb_meta('mb_page_sidebar_def', array(), $id);
    }
}

?>

<aside id="<?php echo $item; ?>-sidebar" class="sidebar col-lg-4 d-print-none" role="complementary" itemprop="WPSideBar">
    <div class="content-wrapper">
        <div class="content-item flex-fill">
            <div class="sidebar-content bg-light">
                <?php if (is_singular() && !is_page()) {
                    get_component_partial($item, 'single-sidebar-content');
                } elseif (is_post_type_archive() || is_blog()) {
                    get_component_partial($item, 'archive-sidebar-content');
                } else {
                    if (is_active_sidebar($sidebar)) {
                        dynamic_sidebar($sidebar);
                    }
                } ?>
            </div>
        </div>
    </div>
</aside>
