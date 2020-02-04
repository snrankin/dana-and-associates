<?php

if (!function_exists('gt3_get_page_title')) {
    function gt3_get_page_title($id)
    {
        $id         = (is_blog()) ? get_option('page_for_posts') : $id;
        $item_type  = maat_item_type();
        $item_title = maat_item_title();
        if ($item_type === 'practice-areas') {
            $item_type = 'practice-area';
        }
        $post_type = to_snake_case($item_type);
        $post_type .= is_singular() ? '_single_' : (is_archive() ? '_archive_' : '_');

        $page_title_conditional = ((gt3_option('page_title_conditional') == '1' || gt3_option('page_title_conditional') == true)) ? 'yes' : 'no';
        $blog_title_conditional = ((gt3_option('blog_title_conditional') == '1' || gt3_option('blog_title_conditional') == true)) ? 'yes' : 'no';

        if (is_singular('post') && $page_title_conditional == 'yes' && $blog_title_conditional == 'no') {
            $page_title_conditional = 'no';
        }

        if ($page_title_conditional == 'yes') {
            $page_title_breadcrumbs_conditional = gt3_option("page_title_breadcrumbs_conditional") == '1' ? 'yes' : 'no';

            $page_title_bg_color = gt3_option("page_title_bg_color");
            $page_title_bg_image = gt3_background_render('page_title', 'mb_page_title_conditional', 'yes', $id);
        }

        if (class_exists('RWMB_Loader') && $id !== 0) {
            $page_sub_title            = rwmb_meta('mb_page_sub_title', array(), $id);
            $mb_page_title_conditional = rwmb_meta('mb_page_title_conditional', array(), $id);
            $page_title_bg_image       = gt3_background_render('page_title', 'mb_page_title_conditional', 'yes', $id);

            if ($mb_page_title_conditional == 'yes') {
                $page_title_conditional             = 'yes';
                $page_title_breadcrumbs_conditional = rwmb_meta('mb_show_breadcrumbs', array(), $id) == '1' ? 'yes' : 'no';
                $page_title_vert_align              = rwmb_meta('mb_page_title_vertical_align', array(), $id);
                $page_title_horiz_align             = rwmb_meta('mb_page_title_horizontal_align', array(), $id);
                $page_title_bg_color                = rwmb_meta('mb_page_title_bg_color', array(), $id);
            } elseif ($mb_page_title_conditional == 'no') {
                $page_title_conditional = 'no';
            }
        }
        $page_title_classes = array(
            'page-title',
            'section-wrapper',
            'bg-primary',
        );
        $page_title_classes[] = (is_404()) ? ' full-height-section' : '';
        $page_title_styles    = !empty($page_title_bg_color) ? 'background-color:' . esc_attr($page_title_bg_color) . ';' : '';

        $gt3_page_title = gt3_page_title();

        // =====================================================================
        // Start Customizations
        // =====================================================================

        $post_header            = get_field($post_type . 'header', 'options');
        $header_title           = '';
        $header_subtitle        = '';
        $header_image           = '';
        $page_title_vert_align  = '';
        $page_title_horiz_align = '';

        $bg_img_pos = get_field($post_type . 'header_bg_img_pos', 'options');
        if (is_singular('team')) {
            $prefix          = get_field('prefix', $id);
            $prefix          = (!empty($prefix)) ? '<span itemprop="honorificPrefix">' . $prefix . '</span> ' : '';
            $suffix          = get_field('suffix', $id);
            $suffix          = (!empty($suffix)) ? ', <span itemprop="honorificSuffix">' . $suffix . '</span>' : '';
            $name            = get_the_title();
            $name            = sprintf('<span itemprop="name">%s%s%s</span>', $prefix, $name, $suffix);
            $header_title    = $name;
            $header_subtitle = (!empty(get_field('job_title', $id))) ? get_field('job_title', $id) : '';
            $header_image    = (!empty(get_field($post_type . 'header_bg_img', $id))) ? get_field($post_type . 'header_bg_img', $id) : '';
            $header_image    = $header_image['id'];
        } elseif ((is_blog() && !is_single()) || is_post_type_archive() || is_404() || is_search()) {
            $header_title    = get_option('options_' . $post_type . 'header_header_title');
            $header_title    = (empty($header_title)) ? $item_title : $header_title;
            $header_subtitle = get_option('options_' . $post_type . 'header_header_subtitle');

            $img          = get_option('options_' . $post_type . 'header_header_bg_img');
            $header_image = (!empty($img)) ? $img : '';

            $img          = get_option('options_' . $post_type . 'header_header_bg_img');
            $header_image = (!empty($img)) ? $img : '';
        } else {

            $header_image           = get_post_thumbnail_id($id);
            $page_title_vert_align  = get_field('bg_image_v_position', $id);
            $page_title_horiz_align = get_field('bg_image_h_position', $id);
        }

        $img_pos = (!empty($bg_img_pos)) ? $bg_img_pos : 'center center';
        if (!empty($header_title)) {
            $gt3_page_title = $header_title;
        } elseif (!empty(gt3_page_title())) {
            $gt3_page_title = gt3_page_title();
        } elseif (is_blog() || is_post_type_archive()) {
            $gt3_page_title = $item_title;
        } else {
            $gt3_page_title = get_the_title($id);
        }
        if (!empty($page_title_vert_align && $page_title_horiz_align)) {
            $page_title_classes[] = 'bg-image-x' . $page_title_horiz_align . '-y' . $page_title_vert_align;
        } else {
            $page_title_classes[] = 'bg-image-xc-yc';
        }
        $page_sub_title = (!empty($header_subtitle)) ? $header_subtitle : '';
        //$page_title_bg_image = (!empty($header_image)) ? 'background-image: url(' . wp_get_attachment_url($header_image). ');' : '';
        $page_title_classes[] = !empty($header_image) ? ' bg-image' : '';
        $page_title_classes[] = !empty($header_image) ? ' lazyload' : '';
        // =====================================================================
        // End Customizations
        // =====================================================================

        $page_header_styles = '';
        $page_header_styles .= (!empty($header_image)) ? ' ' . maat_bg_lazy_sizes($header_image) : '';
        $page_title = '<h1 class="display-1 page-title-text';
        $page_title .= (is_404() || is_search()) ? ' text-center"' : '"';

        $page_title .= (is_singular('post')) ? ' itemprop="name headline">' : '>';
        $page_title .= $gt3_page_title;
        $page_title .= '</h1>';
        $page_subtitle = (!empty($page_sub_title) && !is_404()) ? '<h3 class="page-subtitle display-3">' . esc_attr($page_sub_title) . '</h3>' : '';
        $page_subtitle = (!empty($page_sub_title) && is_404()) ? '<p class="page-subtitle lead text-white text-center">' . esc_attr($page_sub_title) . '</p>' : '';

        if ($page_title_conditional == 'yes') {
            ob_start();
            ?>
<div <?php echo maat_add_item_classes($page_title_classes); ?> <?php echo $page_header_styles; ?>>
    <div class="section-inner">
        <div class="container">
            <div class="row header-margin justify-content-center">
                <div class="col col-12 <?php if (is_404()) {echo 'col-ml-8';} ?>">
                    <div class="content-wrapper justify-content-center">
                        <div class="content-item">
                            <?php echo $page_title . $page_subtitle; ?>
                        </div>
                        <?php if (is_singular('post')) { ?>
                        <div class="content-item">
                            <?php get_component_partial('blog', 'meta'); ?>
                        </div>
                        <?php } elseif (is_404()) { ?>
                        <div class="content-item d-flex justify-content-center position-static">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline-white btn-lrg"><?php esc_html_e('Take me home', 'oconnor'); ?></a>

                            <!-- <a href="#main-content" class="btn-link search-icon d-flex flex-column justify-content-center align-content-center">
                                <span class="h6 d-block text-white h6 text-center">Search</span>
                                <i class="maat maat-angle-down d-block text-white text-center"></i>
                            </a> -->
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$page_title_html = ob_get_clean();
            echo $page_title_html;
        }
    }
}
