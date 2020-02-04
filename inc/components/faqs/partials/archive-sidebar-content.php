<?php
$item = 'faqs';
?>
<div class="widget widget_nav_menu">
    <h4 class="widget-title">All FAQs</h4>
    <nav id="faqs-toc" class="widget widget_nav_menu menu-inner">
        <ul id="menu-faqs-page" class="menu-faqs nav vertical nav-flush">
        <?php wp_list_pages(array(
            'title_li'    => '',
            'sort_column' => 'menu_order, post_title',
            'post_type'   => 'faqs',
            'walker'      => new WP_Bootstrap_Pagewalker_FAQs(),
        )); ?>
        </ul>
    </nav>
</div>
