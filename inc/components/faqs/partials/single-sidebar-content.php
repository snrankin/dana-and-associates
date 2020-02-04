<?php
$item = maat_item_type();
?>
test
<h4 class="widget-title"><a href="<?php echo get_post_type_archive_link($item); ?>">All FAQs</a></h4>
<div class="widget widget_nav_menu">
    <nav>
        <?php echo buildFAQsMenu(); ?>
    </nav>
</div>
