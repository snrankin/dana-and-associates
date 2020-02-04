<?php
function get_location_cat_list($term)
{
    $location_cat_list = '';
    $location          = get_term_by('slug', $term, 'location_cat');
    $term_id           = $location->term_id;
    $term_name         = $location->name;
    $term_icon         = get_field('location_icon', 'term_' . $term_id);
    $term_icon         = wp_sprintf('<i class="%s"></i>', $term_icon);
    $location_args     = array(
        'post_type'      => array('location'),
        'posts_per_page' => '-1',
        'order'          => 'ASC',
        'orderby'        => 'title',
        'tax_query'      => array(
            array(
                'taxonomy' => 'location_cat',
                'terms'    => $term_id,
            ),
        ),
    );
    if (!empty($term) && !is_wp_error($term)) :
        ob_start();
        ?>
<div class="location-cat-list">
    <h3 class="d-flex flex-column justify-content-center align-items-center text-white mds-mb-2">
        <?php if (!empty($term_icon)) : ?>
        <div class="loc-cat-icon">
            <?php echo $term_icon; ?>
        </div>
        <?php endif; ?>
        <span><?php echo $term_name; ?></span>
    </h3>
    <?php $all_locations = new WP_Query($location_args); ?>
    <?php if ($all_locations->have_posts()) : ?>
    <div class="location-list-grid container-fluid">
        <div class="row">
            <?php while ($all_locations->have_posts()) : ?>
            <?php $all_locations->the_post(); ?>
            <div class="col-lg-6">
                <?php get_component_partial('location', 'loop-item'); ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>
<?php endif; ?>
<?php
    $location_cat = ob_get_clean();
    return $location_cat;
} ?>
