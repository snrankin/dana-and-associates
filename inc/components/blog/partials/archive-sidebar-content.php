<?php
$sidebar = 'sidebar_blog-sidebar';
?>
<div class="widget content-item">
<h4 class="widget-title">Resources</h4>
    <?php
    wp_nav_menu(array(
        'menu' => 'resources',
        'container_class' => 'menu-inner',
        'container'       => 'nav',
        'container_id'    => 'info-menu-wrapper',
        'menu_class'      => 'nav vertical nav-flush',
    ));
    ?>
</div>
<div class="widget content-item">
    <h4 class="widget-title">Categories</h4>
    <nav class="menu-inner">
        <ul class="nav vertical nav-flush" role="menu">
            <?php
            wp_list_categories(
                array(
                    'title_li' => '',
                    'style' => 'list',
                    'walker'   => new WP_Bootstrap_Catwalker(),
                )
            );
            ?>
        </ul>
    </nav>
</div>
