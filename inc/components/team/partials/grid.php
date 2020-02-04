<?php

function get_team($cat)
{
    $team_grid = '';
    $args = array(
        'post_type' => array('team'),
        'posts_per_page' => '-1',
        'order' => 'ASC',
        'orderby' => 'menu_order',
    );
    if (!empty($cat)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'team-category',
                'field' => 'slug',
                'terms' => array($cat),
            ),
        );
    }

    $team = new WP_Query($args);
    if ($team->have_posts()) :
        ob_start(); ?>

<div class="team-grid container">
    <div class="row justify-content-center">
        <?php while ($team->have_posts()) : $team->the_post(); ?>
        <div class="col-ms-6 col-md-4 col-lg-3">
            <div class="content-wrapper">
                <?php
                            $item_id = get_the_id();
                            $slug = get_the_slug($item_id);
                            $bio = get_the_content($item_id);
                            $link = get_permalink($item_id);
                            $name = get_the_title($item_id);
                            $img = get_the_post_thumbnail($item_id, 'medium', array('class' => 'team-image img-fluid', 'title' => $name, 'alt' => $name));
                            $team_link = ($cat === 'attorneys') ? 'href="' . $link . '"' : ' data-toggle="modal" data-target="#' . $slug . '"';
                            $job_title = (!empty(get_field('job_title', $item_id))) ? '<p class="team-title h6 text-center">' . get_field('job_title', $item_id) . '</p>' : '';
                            $wrapper_tag_start = (!empty($bio)) ? '<a ' . $team_link . ' title="' . $name . '" class="team-member content-item">' : '<div class="team-member content-item">';
                            $wrapper_tag_end = (!empty($bio)) ? '</a>' : '</div>';
                            ?>
                <?php echo $wrapper_tag_start; ?>
                <?php if (!empty($img)) {
                                echo $img;
                            } ?>
                <div class="team-info">
                    <p class="team-name h4 text-center"><?php echo $name; ?></p>
                    <?php echo $job_title; ?>
                </div>
                <?php echo $wrapper_tag_end; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<?php $team_grid = ob_get_clean(); ?>
<?php endif; ?>
<?php return $team_grid; ?>
<?php wp_reset_postdata(); ?>
<?php

}

function get_team_bios($cat)
{
    $args = array(
        'post_type' => array('team'),
        'posts_per_page' => '-1',
        'order' => 'ASC',
        'orderby' => 'menu_order',
    );
    if (!empty($cat)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'team-category',
                'field' => 'slug',
                'terms' => array($cat),
            ),
        );
    }
}
