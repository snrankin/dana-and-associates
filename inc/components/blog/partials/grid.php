<?php
function blog_grid()
{
    $args = array(
        'posts_per_page' => '3',
    );

    $query = new WP_Query($args);
    $grid  = '';
    $item  = 'blog';

    if ($query->have_posts()) {
        $grid = '<div class="blog-grid card-deck row">';

        while ($query->have_posts()) {
            $query->the_post();
            $image_id                 = get_post_thumbnail_id();
            $bg_img                   = maat_bg_lazy_sizes($image_id);
            $published_UTC_time       = get_the_date('c');
            $published_formatted_time = get_the_date(get_option('date_format'));
            $modified_UTC_time        = get_the_modified_date('c');
            $modified_formatted_time  = get_the_modified_date(get_option('date_format'));
            $post_date                = vsprintf('<span class="meta-title sr-only">Posted On: </span><time datetime="%1$s" class="published-date meta-content">%2$s</time><span class="meta-title sr-only"> Modified On: </span><time datetime="%3$s" class="modified-date meta-content sr-only">%4$s</time>', array($published_UTC_time, $published_formatted_time, $modified_UTC_time, $modified_formatted_time));
            $author_id                = get_the_author_meta('ID');
            $team_id                  = get_field('team_id', 'user_' . $author_id);
            $prefix                   = get_field('prefix', $team_id);
            $prefix                   = (!empty($prefix)) ? '<span itemprop="honorificPrefix">' . $prefix . '</span> ' : '';
            $suffix                   = get_field('suffix', $team_id);
            $suffix                   = (!empty($suffix)) ? ', <span itemprop="honorificSuffix">' . $suffix . '</span>' : '';
            $name                     = get_the_author_meta('display_name');
            $name                     = sprintf('<span itemprop="name">%s%s%s</span>', $prefix, $name, $suffix);
            $items                    = '';
            ob_start(); ?>
<div class="col-md-6 col-lg-4">
    <?php echo maat_blog_grid_item(get_the_ID(), 'vertical'); ?>
</div>
<?php $items = ob_get_clean();
            $grid .= $items;
        }
        $grid .= '</div>';
    }

    wp_reset_postdata();
    return $grid;
}

?>
