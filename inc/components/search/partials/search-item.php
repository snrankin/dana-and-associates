<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  8-3-19
 * Last Modified: 8-3-19 at 11:29 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date    	By	Comments
 * --------	--	--------------------------------------------------------------
 * ========================================================================= */

function maat_search_item($post_id = '')
{
    $defaults = array(
        'wrapper_classes'       => 'card bg-light',
        'body_classes'          => 'card-body',
        'add_image'             => 1,
        'image_wrapper_classes' => 'card-img embed-responsive embed-responsive-16by9',
        'image_classes'         => 'embed-responsive-item',
        'image_size'            => 'medium',
        'before_title'          => '',
        'add_title'             => 1,
        'title_tag'             => 'h4',
        'title_classes'         => 'card-title flex-grow-0',
        'after_title'           => '',
        'add_excerpt'           => 1,
        'excerpt_classes'       => 'card-text',
        'add_link'              => 0,
        'link_classes'          => '',
        'add_meta'              => 0,
        'meta_classes'          => 'card-footer',
        'add_author'            => 0,
        'author_classes'        => '',
        'add_date'              => 0,
        'date_classes'          => 'small',
        'add_tags'              => 0,
        'tag_classes'           => '',
        'add_cats'              => 0,
        'cat_classes'           => '',
    );
    $id = (!empty($post_id)) ? $post_id : get_the_ID();
    $item_object = get_post_type_object(get_post_type($id));
    $item_title = $item_object->labels->singular_name;
    $item = to_kebab_case($item_title);
    $blog_args = array(
        'wrapper_classes'       => 'card blog-item bg-light',
        'body_classes'          => 'card-body',
        'image_wrapper_classes' => 'card-img card-img-top embed-responsive embed-responsive-16by9',
        'add_meta'              => 1,
        'meta_classes'          => 'card-footer archive-blog-meta',
        'add_date'              => 1,
        'add_cats'              => 1,
    );
    $blog_atts = wp_parse_args($blog_args, $defaults);
    $page_args = array(
        'wrapper_classes'       => 'card bg-primary',
        'body_classes'          => 'card-img-overlay d-flex flex-column justify-content-end',
    );
    $page_atts = wp_parse_args($page_args, $defaults);
    $faq_args = array(
        'wrapper_classes'       => 'card bg-tertiary',
        'body_classes'          => 'card-body',
    );
    $faq_atts = wp_parse_args($faq_args, $defaults);
    $atts = $defaults;
    if ($item === 'faq') {
        $atts = $faq_atts;
    } elseif ($item === 'post') {
        $atts = $blog_atts;
    } elseif ($item === 'page' || $item === 'practice-area') {
        $atts = $page_atts;
    }
    extract($atts);


    $wrapper_class = array(
        $item . '-item',
        'search-item',
    );

    $wrapper_class = maat_item_classes($wrapper_class, $wrapper_classes);
    $wrapper_class = get_post_class($wrapper_class, $id);
    $wrapper_class = maat_item_classes($wrapper_class);
    $wrapper_atts    = array(
        'id'        => $item . '-' . $id,
        'class'     => $wrapper_class,
    );

    if ($item === 'blog') {
        $wrapper_atts['itemtype'] = 'http://schema.org/BlogPosting';
        $wrapper_atts['itemscope'] = '';
    } elseif ($item === 'faq') {
        $wrapper_atts['itemtype'] = 'https://schema.org/Question';
        $wrapper_atts['itemscope'] = '';
    }

    $image_wrapper_class = array(
        $item . '-image',
    );
    $image_wrapper_class  = maat_item_classes($image_wrapper_class, $image_wrapper_classes);
    $image_class          = maat_item_classes($image_classes);
    $image                = ($add_image == 1 && has_post_thumbnail($id)) ? get_the_post_thumbnail($id, $image_size, array('wrapper_class' => $image_wrapper_class, 'class' => $image_class, 'parent-fit' => 'cover')) : '';

    $body_class = array(
        $item . '-info',
    );
    $body_class = maat_item_classes($body_class, $body_classes);

    $body_atts = array(
        'class' => maat_item_classes($body_class, $body_classes)
    );

    if ($item === 'faq') {
        $body_atts['itemtype'] = 'https://schema.org/Answer';
        $body_atts['itemscope'] = '';
        $body_atts['itemprop'] = 'acceptedAnswer';
    }

    $title_class = array(
        $item . '-title',

    );
    $title_text = get_the_title($id);
    $title_class = maat_item_classes($title_class, $title_classes);
    $before_title .= '<' . $title_tag . maat_add_item_classes($title_class) . ' itemprop="name headline">';
    $after_title = '</' . $title_tag . '>' . $after_title;
    $post_title = $before_title . $title_text . $after_title;
    $title = ($add_title == 1) ? $post_title : '';

    $excerpt_class = array(
        $item . '-excerpt',
    );
    $excerpt_class = maat_item_classes($excerpt_class, $excerpt_classes);
    $excerpt = (has_excerpt($id) && $add_excerpt == 1) ? '<p ' . maat_add_item_classes($excerpt_class) . ' itemprop="description">' . wp_strip_all_tags(get_the_excerpt($id), true) . '</p>' : '';

    if ($item === 'faq') {

        $content = get_the_content($id);
        $answer_excerpt = '<p ' . maat_add_item_classes($excerpt_class) . '>' . wp_strip_all_tags(maat_excerpt($content), true) . '</p>';
        $full_answer = maat_excerpt($content, 500);
        $answer_remaining = str_replace($answer_excerpt, '', $full_answer);
        $read_more = '<p class="card-text m-0"><button class="btn btn-link text-dark small m-0" type="button" data-toggle="collapse" data-target="#' . $item . '-' . $id . '-excerpt" aria-expanded="false" aria-controls="' . $item . '-' . $id . '-excerpt">[See More+]</button></p>';
        $answer_remaining = '<div class="collapse mds-pt-0" id="' . $item . '-' . $id . '-excerpt">' . $answer_remaining . '</div>';
        $excerpt = '<div itemprop="text">' . $answer_excerpt . $read_more . $answer_remaining . '</div>';
    }

    $link_class = array(
        $item . '-link',
    );
    $link_class = maat_item_classes($link_class, $link_classes);

    $link_atts = array(
        'href'      => get_the_permalink($id),
        'title'     => the_title_attribute(
            array(
                'echo' => false,
                'post' => $id,
            )
        ),
        'class'     => $link_class,
        'itemprop'  => 'url',
        'rel'       => 'bookmark'
    );

    $link_hidden = array(
        'href'      => get_the_permalink($id),
        'title'     => the_title_attribute(
            array(
                'echo' => false,
                'post' => $id,
            )
        ),
        'class'     => 'stretched-link',
        'itemprop'  => 'url',
        'rel'       => 'bookmark'
    );

    $link = ($add_link == 1) ? '<a' . maat_add_item_data($link_atts) . '><span class="btn-text">Read More</span></a>' : '<a' . maat_add_item_data($link_hidden) . '></a>';



    if ($add_date == 1 || $add_author == 1 || $add_cats == 1 || $add_tags == 1) {
        $meta_class = array(
            $item . '-footer',
            $item . '-meta',
        );
        $meta = '<footer ' . maat_add_item_classes($meta_class, $meta_classes) . '><ul class="list-inline">';

        $date_class = array(
            'list-inline-item',
            $item . '-date',
        );
        $meta .= ($add_date == 1) ? '<li ' . maat_add_item_classes($date_class, $date_classes) . '>' . maat_time($id) . '</li>' : '';

        $author_class = array(
            'list-inline-item',
            $item . '-author',
        );
        $meta .= ($add_author == 1) ? '<li ' . maat_add_item_classes($author_class, $author_classes) . '>' . maat_author($id) . '</li>' : '';

        $cat_class = array(
            'list-inline-item',
            $item . '-categories',
        );
        $categories = get_the_category_list($id);
        if ($add_cats == 1 && !empty($categories)) {
            $meta .= '<li ' . maat_add_item_classes($cat_class, $cat_classes) . '>';
            $meta .= maat_categories($id);
            $meta .= '</li>';
        }



        $meta .= '</ul></footer>';
    }

    $post = '<article' . maat_add_item_data($wrapper_atts) . '>';
    $post .= (strpos($body_classes, 'card-img-overlay') === false) ? '<div class="card-header"><span class="small">' . $item_title . '</span></div>' : '';
    $post .= $image;
    $post .= '<div' . maat_add_item_classes($body_class) . '>';
    $post .= (strpos($body_classes, 'card-img-overlay') !== false) ? '<div class="card-subtitle"><span class="small">' . $item_title . '</span></div>' : '';
    $post .= $title;
    $post .= $excerpt;
    $post .= $meta;
    $post .= '</div>';
    $post .= ($item !== 'faq') ? $link : '';
    $post .= '</article>';
    return $post;
}
