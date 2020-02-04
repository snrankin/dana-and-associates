<?php
$item = maat_item_type();
?>

<div id="mobile-faqs-nav-wrapper" class="d-lg-none bg-primary">
    <select id="mobile-faqs-nav">
        <?php
wp_list_pages(array(
 'title_li'     => '',
 'sort_column'  => 'menu_order, post_title',
 'depth'        => -1,
 'post_type'    => 'faqs',
 'item_spacing' => 'discard',
 'walker'       => new WP_Bootstrap_Navwalker_FAQs_Mobile(),
));
?>
    </select>
</div>
