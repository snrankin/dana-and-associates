<?php
function get_locations_map(){

    $args = array(
        'post_type' => array('location'),
        'posts_per_page' => '-1',
        'order' => 'ASC',
        'orderby' => 'title',
    );

    $locations = new WP_Query($args);
    if ($locations->have_posts())  :
        ob_start();
?>
<div class="location-map-wrapper">
    <div class="location-map embed-responsive">
        <div class="map-markers">
            <?php
                while ($locations->have_posts()) :
                $locations->the_post();
                $id = get_the_ID();
                $slug = get_the_slug($id);
                $info = getLocationInfo($location = $id);
                $icon = get_field('map_pin_image', 'options');
                //$icon = get_stylesheet_directory_uri() . '/assets/imgs/map-marker.svg';
                $imgURL = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                $lat = $info['address']['lat'];
                $lng = $info['address']['lng'];
                $title = (!empty(get_field('location_name'))) ? get_field('location_name') : get_the_title();
                $args = array(
                    'wrapper' => 'div',
                    'class' => 'marker-inner',
                    'title' => $title,
                    'address' => array(
                        'content' => $info['address'],
                        'wrapper' => 'div',
                        'class' => 'has-icon',
                    ),
                    'phone' => array(
                        'content' => $info['phone'],
                        'link' => 1,
                        'wrapper' => 'div',
                        'class' => 'has-icon',
                    ),
                    'fax' => array(
                        'content' => $info['fax'],
                        'wrapper' => 'div',
                        'class' => 'has-icon',
                    ),
                    'email' => array(
                        'content' => $info['email'],
                        'link' => 1,
                        'wrapper' => 'div',
                        'class' => 'has-icon',
                    ),
                    'hob' => array(
                        'content' => $info['hob'],
                        'day' => 'D',
                        'time' => 'g:ia',
                        'wrapper' => 'div',
                        'class' => 'has-icon',
                    ),
                );
            ?>
            <?php if(!empty($lat) && !empty($lng)) : ?>
                <div class="map-marker" data-icon="<?php echo $icon;?>" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>">
                    <?php if (!empty($imgURL)) : ?>
                        <div class="box-image embed-responsive" style="background: url(<?php echo $imgURL; ?>) center center no-repeat; background-size: cover;"></div>
                    <?php endif; ?>
                    <?php echo displayLocationInfo($args); ?>
                </div>
            <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php
    $map_wrapper = ob_get_clean();
    endif;

    return $map_wrapper;
    wp_reset_postdata();

} ?>