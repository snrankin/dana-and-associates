<?php
$practice_icon = get_field('practice_area_icon', get_the_ID());
$args          = array(
    'title'        => get_the_title(),
    'text'         => '',
    'title_tag'    => 'h4',
    'icon'         => $practice_icon,
    'link'         => array(
        'href'  => get_the_permalink(),
        'title' => get_the_title(),
    ),
    'image_id'     => get_post_thumbnail_id(get_the_ID()),
    'image_size'   => 'medium',
    'hover_effect' => 'effect-bubba',
    'class'        => 'embed-responsive-item',
); ?>

<div class="col col-auto flex-fill embed-responsive embed-responsive-3by2">
    <?php echo hoverBox($args); ?>
</div>
