<?php
function get_locations_grid()
{
    $location_grid = '';
    $currentID     = get_the_ID();
    $args          = array(
        'post_type'      => array('location'),
        'posts_per_page' => '-1',
        'order'          => 'ASC',
        'orderby'        => 'title',
        'post__not_in'   => array($currentID),
    );

    $all_locations = new WP_Query($args);
    if ($all_locations->have_posts()) :
        ob_start();
        ?>
<div class="section-wrapper location-grid">
    <div class="section-inner p-0">
        <div class="container-fluid">
            <div class="row hover-box-row">
                <?php while ($all_locations->have_posts()) : $all_locations->the_post(); ?>
                <?php
                            $address = getLocationInfo(get_the_ID());
                            $address = $address['address'];
                            $text = displayAddress(array(
                                'wrapper'    => 0,
                                'content'    => $address,
                            ));
                            ?>
                <?php
                            $args = array(
                                'title'        => get_the_title(),
                                'text'         => $text,
                                'title_tag'    => 'h4',
                                'icon'         => 'dana dana-location-pin',
                                'link'         => array(
                                    'href'   => get_the_permalink(),
                                    'title'  => get_the_title(),
                                ),
                                'image_id'     => get_post_thumbnail_id(),
                                'image_size'   => 'medium',
                                'hover_effect' => 'effect-bubba',
                                'class'        => 'location-box embed-responsive embed-responsive-3by2',
                            );

                            ?>
                <div class="col-ms-6 col-ml-4 flex-fill">
                    <?php echo hoverBox($args) ?>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<?php
        $location_grid = ob_get_clean();
        wp_reset_postdata();
    endif;

    return $location_grid;
} ?>
