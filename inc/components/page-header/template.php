<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  7-9-19
 * Last Modified: 8-6-19 at 2:12 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */
$item = maat_item_type();
if (is_singular()) {
    $field_prefix = '';
    $post_id      = get_the_ID();
} elseif (is_tax()) {
    $field_prefix = '';

    $post_id = 'term_' . get_queried_object()->term_id;
} else {
    $field_prefix = to_snake_case($item) . '_';
    $post_id      = 'options';
}

$show_header = get_field($field_prefix . 'show_page_header', $post_id);

if (is_singular('post')) {
    $show_header = 1;
}

if ($show_header != 1) {
    return;
}

$page_header         = get_field($field_prefix . 'page_header', $post_id);
$page_header_wrapper = '';
$page_header_classes = array(
    'page-header',
    'bg-dark',
    'section-wrapper',
    'd-print-none',
    'position-relative',
    'overflow-hidden'
);
$page_header_atts = array(
    'itemscope' => '',
    'itemtype'  => esc_url('http://schema.org/WPHeader'),
    'class' => maat_item_classes($page_header_classes),
);

$title = '';
if (!empty($page_header['title'])) {
    $title = $page_header['title'];
} elseif (is_search()) {
    $title = esc_html__('Searching For: ' . get_search_query(), 'oconnor');
} elseif (is_404()) {
    $title = '<span class="xl-text">' . esc_html__('404', 'oconnor') . '</span>';
    $title .= '<span class="small d-block">' . esc_html__('OOPS! Page Not Found!', 'oconnor') . '</span>';
} elseif (is_blog() && !is_singular('post')) {
    $title = get_the_archive_title();
} elseif (!is_singular()) {
    $title = maat_item_title();
} elseif (is_singular('team')) {
    $title = team_name($post_id);
} else {
    $title = get_the_title();
}
$title_classes = array(
    'page-title',
    'display-1'
);
if (is_404()) {
    $title_classes[] = 'text-center';
    $title_classes[] = 'error-404-title';
}
$title_classes = maat_item_classes($title_classes);
$page_title = sprintf('<h1 class="%s" role="heading" aria-level="1" itemprop="headline name">%s</h1>', $title_classes, $title);

$subtitle = '';
if (!empty($page_header['subtitle'])) {
    $subtitle = $page_header['subtitle'];
} elseif (is_singular('team')) {
    $subtitle = team_job($post_id);
} elseif (is_404()) {
    $subtitle = esc_html__('Either something get wrong or the page doesn\'t exist anymore.', 'oconnor');
}
$subtitle_classes = array(
    'page-subtitle',
);
if (!is_404()) {
    $subtitle_classes[] = 'h6';
} else {
    $subtitle_classes[] = 'h5';
    $subtitle_classes[] = 'text-center';
}
$subtitle_classes = maat_item_classes($subtitle_classes);
$page_subtitle = sprintf('<h2 class="%s">%s</h2>', $subtitle_classes, $subtitle);

$bg_img = '';
$img_id = $page_header['bg_img'];
if (is_singular('post')) {
    $img_id = get_post_thumbnail_id(get_the_id());
}

$bg_img_x = $page_header['bg_img_x'];
$bg_img_y = $page_header['bg_img_y'];

if (!empty($img_id)) {
    $bg_img_class = array(
        'position-absolute',
        'page-header-bg',
        'bg-image-x' . $bg_img_x . '-y' . $bg_img_y,
        'w-100',
        'h-100',
        'lazyload',
        'bg-image'
    );
    $bg_img = maat_img_structure($img_id, 'full', array('wrapper_class' => maat_item_classes($bg_img_class), 'img_bg' => 1, 'class' => 'd-none'));
}

$header = '';

ob_start();

?>

<header <?php echo maat_add_item_data($page_header_atts); ?>>
    <?php echo $bg_img; ?>
    <div class="section-inner">
        <div class="container header-margin">
            <div class="row">
                <div class="col-12">
                    <div class="content-wrapper">
                        <div class="content-item">
                            <?php if (!empty($title)) {
                                echo $page_title;
                            } ?>
                            <?php if (!empty($subtitle)) {
                                echo $page_subtitle;
                            } ?>
                            <?php if (is_singular('post')) {
                                get_component_partial('blog', 'meta');
                            } elseif (is_404()) {
                                echo '<p class="text-center mds-mt-4"><a class="btn btn-outline-white btn-lg" href="' . esc_url(home_url('/')) . '"><span class="btn-text">' . __('Take me home', 'oconnor') . '</span></a></p>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $header = ob_get_clean();
echo $header;
?>
