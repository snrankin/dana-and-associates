<?php
function team_grid_item($id, $add_bio, $bio_type)
{
    $slug      = get_the_slug($id);
    $bio       = get_the_content($id);
    $url       = ($bio_type === 'page') ? 'href="' . get_permalink($id) . '"' : 'href="#' . $slug . '" data-fancybox="team"';
    $name      = '<h4 class="team-name card-title">' . team_name($id) . '</h4>';
    $job       = team_job($id);
    $img       = get_the_post_thumbnail($id, 'medium', array('wrapper_class' => 'team-image card-img-top', 'class' => 'w-100'));
    $link      = (!empty($bio) && $add_bio == 1) ? '<a ' . $url . ' title="' . get_the_title($id) . '" class="team-member-link stretched-link"></a>' : '';
    $grid_item = '<div class="team-member card bg-primary text-center">';
    $grid_item .= (!empty($img)) ? $img : '';
    $grid_item .= '<div class="card-body align-items-stretch">';
    $grid_item .= '<h4 class="team-name card-title">' . team_name($id) . '</h4>';
    $grid_item .= (!empty($job)) ? '<p class="team-jobtitle card-subtitle">' . $job . '</p>' : '';
    $grid_item .= '</div>';
    $grid_item .= $link;
    $grid_item .= '</div>';
    return $grid_item;
}
