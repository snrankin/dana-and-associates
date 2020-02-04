<header id="site-header" class="site-header d-print-none" role="banner">
    <div class="container">
        <div class="navbar p-0 navbar-dark top-header">
            <div class="menu-container">
                <div class="menu-wrapper p-0">
                    <?php
                    wp_nav_menu(array(
                        'container_class' => 'menu-inner',
                        'container'       => 'nav',
                        'container_id'    => 'info-menu-wrapper',
                        'theme_location'  => 'top_menu',
                        'menu_class'      => 'navbar-nav flex-row flex-nowrap nav-justified justify-content-ml-end',
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="navbar navbar-expand-ml navbar-dark align-items-ml-stretch bottom-header" role="navigation" aria-label="Main navigation">
            <?php echo maat_custom_logo($class = 'navbar-brand mr-auto', $link = 1) ?>
            <?php echo togglerButton('main-menu-wrapper', 'p-0') ?>

            <div id="main-menu-wrapper" class="collapse navbar-collapse justify-content-ml-end align-items-ml-stretch menu-container">
                <div class="menu-wrapper">
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'main_menu',
                        'container'       => 'nav',
                        'container_class' => 'menu-inner',
                        'menu_class'      => 'navbar-nav justify-content-ml-end',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>
