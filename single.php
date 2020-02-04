<?php
get_header();
$id      = get_the_ID();
$item    = maat_item_type($id);
$title   = maat_item_title($id);
$classes = get_post_class(array('content-item'), $id);

$wrapper_atts = array(
    'id'       => $item . '-' . get_the_slug($id),
    'itemprop' => 'mainEntity',
    'class'    => join(' ', $classes),
);
if ($item === 'blog') {
    $wrapper_atts['role']      = 'article';
    $wrapper_atts['itemscope'] = '';
    $wrapper_atts['itemtype']  = 'http://schema.org/BlogPosting';
} else {
    $wrapper_atts['role'] = 'main';
}

$content_file = COMPONENT_PATH . '/' . $item . '/partials/single-content.php';
$nav_file     = COMPONENT_PATH . '/' . $item . '/partials/single-nav.php';
?>

<div id="<?php echo $item; ?>-content" class="section-wrapper">
    <div class="section-inner">
        <div class="container">
            <div class="row">
                <?php if (have_posts()) : ?>
                <?php while (have_posts()) : ?>
                <?php the_post(); ?>
                <div class="col col-lg-8">
                    <div class="content-wrapper">
                        <article <?php echo maat_add_item_data($wrapper_atts); ?>>
                            <meta itemprop='isFamilyFriendly' content='True' />
                            <section class="main-content <?php echo $item; ?>" itemprop="mainEntityOfPage">
                                <?php (file_exists($content_file)) ? get_component_partial($item, 'single-content') : the_content(); ?>
                            </section>
                        </article>
                        <?php (file_exists($nav_file)) ? get_component_partial($item, 'single-nav') : get_component_partial('pagination', 'single-nav'); ?>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php endif; ?>
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>

<?php
if ($item === 'location') {
    echo get_locations_grid();
}
get_footer(); ?>
