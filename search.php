<?php
get_header();
$id      = get_the_ID();
$item    = maat_item_type($id);
$title   = maat_item_title($id);
$classes = '';

$loop_classes = array(
    $item . '-loop',
    'card-columns'
);

$column = 12;

$wrapper_atts = array(
    'id'        => $item . '-archive',
    'itemprop'  => 'mainEntity',
    'role'      => 'main',
    'class'     => 'col-' . $column,
);

$loop_atts = array(
    'id'    => $item . '-loop',
    'class' => maat_item_classes($loop_classes, $classes),
);

$content_file = COMPONENT_PATH . '/' . $item . '/partials/archive-loop.php';
$nav_file     = COMPONENT_PATH . '/' . $item . '/partials/archive-nav.php';

?>
<div class="section-wrapper">
    <div class="section-inner">
        <div class="container">
            <div class="row justify-content-center">

                <div <?php echo maat_add_item_data($wrapper_atts); ?>>
                    <?php
                    global $wp_query, $paged, $offset, $posts_per_page;

                    $foundSomething = false;

                    $args = array(
                        'numberposts' => -1,
                        'offset' => 0,
                        'post_type' => array(
                            'page',
                            'faqs',
                            'post',
                            'maat_practice_areas'
                        ),
                        'post_status' =>
                        'publish',
                        'post_password' => '',
                        's' => get_search_query()
                    );

                    $query = http_build_query($args);
                    $posts = get_posts($query);



                    // The Loop

                    if (!empty($posts)) {
                        echo '<section' . maat_add_item_data($loop_atts) . '>';
                        foreach ($posts as $post) {
                            setup_postdata($post);
                            $item_id = get_the_ID();
                            echo maat_search_item($item_id);
                        }
                        get_component_partial('search', 'archive-content');
                        echo '</section>';
                    } else {
                        echo '<div class="alert alert-danger mds-mb-5" role="alert">' . esc_html__('No posts match your search, please try again.', 'oconnor') . '</div>';
                        get_component_partial('search', 'archive-content');
                    }

                    // Restore original Post Data
                    wp_reset_postdata();
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<?php get_footer(); ?>
