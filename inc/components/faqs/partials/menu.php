<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  6-24-19
 * Last Modified: 7-31-19 at 3:32 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */

$args = array(
    'post_type'      => 'faqs',
    'posts_per_page' => -1,
    'post_parent'    => 0,
    'order'          => 'ASC',
    'orderby'        => 'menu_order',
);

$query = new WP_Query($args);

if ($query->have_posts()): while ($query->have_posts()): $query->the_post();

        $post_slug = $query->post->post_name; ?>
<li itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement" id="page-item-<?php the_ID(); ?>" class="nav-item nav-item-<?php the_ID(); ?> level-1-menu-item has-children"  role="none">
    <a title="<?php the_title_attribute(); ?>" href="#<?php echo $post_slug; ?>" class="menu-link nav-link flex-fill" data-level="1" role="menuitem" tabindex="0"><?php the_title(); ?></a>
    <a href="#menu-collapse-<?php the_ID(); ?>" data-toggle="collapse" tabindex="-1" aria-controls="menu-collapse-<?php the_ID(); ?>" aria-expanded="false" class="dropdown-toggle"><span class="sr-only">Dropdown link</span></a>
    <div class="collapse menu-container sub-menu level-2-menu" id="menu-collapse-<?php the_ID(); ?>" aria-labelledby="menu-collapse-<?php the_ID(); ?>">
        <div class="menu-wrapper">
            <nav class="menu-inner">
                <ul class="nav vertical nav-flush" role="menu">
                    <?php wp_list_pages(array(
            'title_li'    => '',
            'sort_column' => 'menu_order, post_title',
            'child_of'    => get_the_ID(),
            'post_type'   => 'faqs',
            'walker'      => new WP_Bootstrap_Pagewalker_FAQs(),
        )); ?>
                </ul>
            </nav>
        </div>
    </div>
</li>
<?php endwhile;
endif;
wp_reset_postdata(); ?>


<?php wp_list_pages(array(
            'title_li'    => '',
            'sort_column' => 'menu_order, post_title',
            'post_type'   => 'faqs',
            'walker'      => new WP_Bootstrap_Pagewalker_FAQs(),
        )); ?>