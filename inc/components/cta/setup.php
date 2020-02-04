<?php

function maat_cta()
{
    $id = get_the_ID();
    $item = maat_item_type($id);
    $field_prefix = '';
    $cta_wrapper = '';
    if (is_page() || is_singular('maat_practice_areas')) {
        $post_id      = $id;
    } elseif (is_tax()) {
        $post_id = 'term_' . get_queried_object()->term_id;
    } else {
        $field_prefix = to_snake_case($item) . '_';
        $post_id      = 'options';
    }

    $add_cta = get_field($field_prefix . 'add_cta', $post_id);

    if ($add_cta != 1) {
        return;
    }
    $cta         = get_field('cta', 'options');

    $cta_classes = array(
        'cta',
        'bg-primary',
        'section-wrapper',
        'border-top',
        'border-white',
        'd-print-none',
    );
    $cta_atts = array(
        'role' => 'region',
    );

    $title = '';
    if (!empty($cta['title'])) {
        $title                  = $cta['title'];
        $cta_atts['aria-label'] = $cta['title'];
    }
    $cta_title = sprintf('<h2 class="cta-title display-2 text-center mds-mb-3 content-item-lg-10" role="heading" aria-level="2">%s</h2>', $title);

    $subtitle = '';
    if (!empty($cta['subtitle'])) {
        $subtitle = $cta['subtitle'];
    }
    $cta_subtitle = sprintf('<p class="cta-subtitle lead text-center content-item-lg-8">%s</p>', $subtitle);

    $bg_img   = $cta['bg_img'];
    $bg_img_x = $cta['bg_img_x'];
    $bg_img_y = $cta['bg_img_y'];

    if (!empty($bg_img)) {
        $img           = maat_get_bg_lazy_sizes($bg_img);
        $cta_atts      = array_merge($cta_atts, $img);
        $cta_classes[] = 'bg-image';
        $cta_classes[] = 'lazyload';
    }

    if (!empty($bg_img) && !empty($bg_img_x) && !empty($bg_img_y)) {
        $cta_classes[] = 'bg-image-x' . $bg_img_x . '-y' . $bg_img_y;
    }

    $cta_atts['class'] = maat_item_classes($cta_classes);

    $cta_btn  = '';
    $btn_link = $cta['btn_link'];
    $btn_txt  = $cta['btn_txt'];

    if (!empty($btn_link) && !empty($btn_txt)) {
        $cta_btn .= sprintf('<a href="%s" class="btn btn-outline-white btn-lg d-print-none"><span class="btn-txt">%s</span></a>', $btn_link, $btn_txt);
    }

    $page_cta = '';

    ob_start();

    ?>

<section <?php echo maat_add_item_data($cta_atts); ?>>
    <div class="section-inner bg-primary-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="content-wrapper">
                        <div class="content-item d-flex flex-column align-items-center">
                            <?php if (!empty($title)) {
                                    echo $cta_title;
                                } ?>
                            <?php if (!empty($subtitle)) {
                                    echo $cta_subtitle;
                                } ?>
                            <?php if (!empty($cta_btn)) {
                                    echo $cta_btn;
                                } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $page_cta = ob_get_clean();
    return $page_cta;
}
