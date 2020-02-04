<?php

// Create variable length excerpt
function maat_variable_length_excerpt($text, $length, $finish_sentence = 1)
{

    $tokens = array();
    $out    = '';
    $word   = 0;

    //Divide the string into tokens; HTML tags, or words, followed by any whitespace.
    $regex = '/(<[^>]+>|[^<>\s]+)\s*/u';
    preg_match_all($regex, $text, $tokens);
    foreach ($tokens[0] as $t) {
        //Parse each token
        if ($word >= $length && !$finish_sentence) {
            //Limit reached
            break;
        }
        if ($t[0] != '<') {
            //Token is not a tag.
            //Regular expression that checks for the end of the sentence: '.', '?' or '!'
            $regex1 = '/[\?\.\!]\s*$/uS';
            if ($word >= $length && $finish_sentence && preg_match($regex1, $t) == 1) {
                //Limit reached, continue until ? . or ! occur to reach the end of the sentence.
                $out .= trim($t);
                break;
            }
            $word++;
        }
        //Append what's left of the token.
        $out .= $t;
    }
    //Add the excerpt ending as a link.
    $excerpt_end = '';

    //Add the excerpt ending as a non-linked ellipsis with brackets.
    //$excerpt_end = ' [&hellip;]';

    //Append the excerpt ending to the token.
    $out .= $excerpt_end;

    return trim(force_balance_tags($out));
}

function maat_excerpt($text, $length = 1)
{

    $text = get_the_content('');
    $text = strip_shortcodes($text);
    $text = apply_filters('the_content', $text);

    $text = str_replace(']]>', ']]&gt;', $text);

    /**By default the code allows all HTML tags in the excerpt**/
    //Control what HTML tags to allow: If you want to allow ALL HTML tags in the excerpt, then do NOT touch.

    //If you want to Allow SOME tags: THEN Uncomment the next line + Line 80.
    $allowed_tags = '<p>,<b>,<strong>,<h6>,<h5>'; /* Here I am allowing p, a, strong tags. Separate tags by comma. */

    //If you want to Disallow ALL HTML tags: THEN Uncomment the next line + Line 80,
    //$allowed_tags = ''; /* To disallow all HTML tags, keep it empty. The Excerpt will be unformated but newlines are preserved. */
    $text = strip_tags($text, $allowed_tags); /* Line 80 */

    //Create the excerpt.
    $text = maat_variable_length_excerpt($text, $length, 1);
    return $text;
}
//add_filter('get_the_excerpt', 'maat_excerpt_filter', 5);

get_component_partial('blog', 'grid');

function maat_blog_shortcode()
{

    return blog_grid();
}
add_shortcode('maat_blog', 'maat_blog_shortcode');

function maat_author($id = '', $show_image = 0)
{
    if (empty($id)) {
        $id = get_the_id();
    }
    $post = get_post($id);
    $company_name = get_bloginfo('name');
    $site_url     = get_bloginfo('url');
    $author_id    = $post->post_author;
    $team_id      = get_field('team_id', 'user_' . $author_id);
    $logo_img_url = get_field('company_logo', 'options');
    $item         = maat_item_type();
    $name         = team_name($team_id);
    $job_title    = team_job($team_id);
    $author_img   = get_the_post_thumbnail($team_id, 'thumbnail', array('title' => wp_strip_all_tags($name), 'alt' => wp_strip_all_tags($name)));

    $person_wrapper_atts = array(
        'itemscope' => '',
        'itemprop'  => 'author',
        'itemtype'  => 'http://schema.org/Person',
        'class'     => 'meta-wrapper ' . $item . '-author',
    );

    $person_link_atts = array(
        'itemprop' => 'url',
        'href'     => get_permalink($team_id),
        'rel'      => 'author',
        'class'    => 'meta-info',
    );

    $publisher_wrapper_atts = array(
        'itemscope' => '',
        'itemprop'  => 'publisher',
        'itemtype'  => 'http: //schema.org/Organization',
        'class'     => 'meta-wrapper ' . $item . '-publisher d-none',
    );
    $author = '<span' . maat_add_item_data($person_wrapper_atts) . '>';
    $author .= '<i class="dana dana-pencil meta-icon"></i>';
    $author .= '<span class="meta-title">Written By:&thinsp;</span>';
    $author .= '<a' . maat_add_item_data($person_link_atts) . '>';
    $author .= ($show_image == 1) ? $author_img : '';
    $author .= '<span class="author-info">';
    $author .= $name;
    $author .= $job_title;
    $author .= '</span>';
    $author .= '</a>';
    $author .= '</span>';
    $author .= '<span' . maat_add_item_data($publisher_wrapper_atts) . '>';
    $author .= '<meta itemprop="logo" content="' . $logo_img_url . '" />';
    $author .= '<span itemprop="name">' . $company_name . '</span>';
    $author .= '</span>';
    return $author;
}

function maat_categories($id = '')
{
    $category_list = '';
    if (get_the_category_list($id)) {
        $category_list .= '<span class="meta-wrapper post-categories"><i class="dana dana-folder-open meta-icon"></i><span class="meta-title">Filed Under:&thinsp;</span><span class="meta-content">';

        $categories     = get_the_category($id);
        $all_categories = '';
        foreach ($categories as $category) {
            $all_categories .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" title="' . esc_attr($category->name) . '">' . esc_html($category->name) . '</a>, ';
        }
        $category_list .= rtrim($all_categories, ', ');

        $category_list .= '</span></span>';
    }
    return $category_list;
}

function maat_tags($id = '')
{
    $tag_list = '';
    if (get_the_tag_list($id)) {
        $tag_list .= get_the_tag_list('<span class="meta-wrapper post-tags"><i class="dana dana-tags meta-icon"></i><span class="meta-title">Tagged With:&thinsp;</span><span class="meta-content">', ', ', '</span></span>', $id);
    }
    return $tag_list;
}

function maat_time($id = '')
{
    $item                     = maat_item_type();
    $published_UTC_time       = get_the_date('c', $id);
    $published_formatted_time = get_the_date(get_option('date_format'), $id);
    $modified_UTC_time        = get_the_modified_date('c', $id);
    $modified_formatted_time  = get_the_modified_date(get_option('date_format'), $id);
    $post_date                = sprintf('<span class="meta-title">Posted On:&thinsp;</span><time datetime="%s" class="published-date meta-content">%s</time>&thinsp;<span class="meta-title sr-only">Modified On:&thinsp;</span><time datetime="%s" class="modified-date meta-content sr-only">%s</time>', $published_UTC_time, $published_formatted_time, $modified_UTC_time, $modified_formatted_time);
    $time                     = '<span class="meta-wrapper ' . $item . '-date"><i class="dana dana-calendar"></i>' . $post_date . '</span>';
    return $time;
}

function maat_blog_grid_item($post_id = '', $args = array())
{
    $defaults = array(
        'wrapper_classes'       => '',
        'body_classes'          => '',
        'add_image'             => 0,
        'image_wrapper_classes' => '',
        'image_classes'         => '',
        'image_size'            => 'medium',
        'before_title'          => '',
        'add_title'             => 1,
        'title_tag'             => 'h4',
        'title_classes'         => '',
        'after_title'           => '',
        'add_excerpt'           => 0,
        'excerpt_classes'       => '',
        'add_link'              => 0,
        'link_classes'          => '',
        'add_meta'              => 0,
        'meta_classes'          => '',
        'add_author'            => 0,
        'author_classes'        => '',
        'add_date'              => 0,
        'date_classes'          => '',
        'add_tags'              => 0,
        'tag_classes'           => '',
        'add_cats'              => 0,
        'cat_classes'           => '',
    );
    $id = (!empty($post_id)) ? $post_id : get_the_ID();
    $item = maat_item_type($id);
    $atts = wp_parse_args($args, $defaults);
    extract($atts);


    $wrapper_class = array(
        $item . '-item',
    );

    $wrapper_class = maat_item_classes($wrapper_class, $wrapper_classes);
    $wrapper_class = get_post_class($wrapper_class, $id);
    $wrapper_class = maat_item_classes($wrapper_class);
    $wrapper_atts    = array(
        'id'        => $item . '-' . $id,
        'itemscope' => '',
        'itemtype'  => 'http://schema.org/BlogPosting',
        'class'     => $wrapper_class,
    );

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

    $title_class = array(
        $item . '-title',
    );
    $title_class = maat_item_classes($title_class, $title_classes);
    $before_title .= '<' . $title_tag . maat_add_item_classes($title_class) . ' itemprop="name headline">';
    $after_title = '</' . $title_tag . '>' . $after_title;
    $post_title = $before_title . get_the_title($id) . $after_title;
    $title = ($add_title == 1) ? $post_title : '';

    $excerpt_class = array(
        $item . '-excerpt',
    );
    $excerpt_class = maat_item_classes($excerpt_class, $excerpt_classes);
    $excerpt = (has_excerpt($id) && $add_excerpt == 1) ? '<p ' . maat_add_item_classes($excerpt_class) . ' itemprop="description">' . wp_strip_all_tags(get_the_excerpt($id), true) . '</p>' : '';

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
        $meta .= ($add_cats == 1 && get_the_category_list($id)) ? '<li ' . maat_add_item_classes($cat_class, $cat_classes) . '>' . maat_categories($id) . '</li>' : '';

        $tag_class = array(
            'list-inline-item',
            $item . '-tags',
        );
        $meta .= ($add_tags == 1 && get_the_tag_list($id)) ? '<li ' . maat_add_item_classes($tag_class, $tag_class) . '>' . maat_tags($id) . '</li>' : '';

        $meta .= '</ul></footer>';
    }

    $post = '<article' . maat_add_item_data($wrapper_atts) . '>';
    $post .= $image;
    $post .= '<div' . maat_add_item_classes($body_class) . '>';
    $post .= $title;
    $post .= $excerpt;
    $post .= $link;
    $post .= $meta;
    $post .= '</div>';
    $post .= '</article>';
    return $post;
}

function maat_related_posts($id = '')
{

    $related_posts = '';
    $id = (!empty($id)) ? $id : get_the_ID();
    $args      = array(
        'posts_per_page' => '3',
        'exclude'   => array($id),
        'cat'   => wp_get_post_categories($id),
    );

    $posts = get_posts($args);

    if (!empty($posts)) {
        foreach ($posts as $post) {
            setup_postdata($post);
            $post_id = $post->ID;
            $post_args = array(
                'add_date'              => 1,
                'add_image'             => 1,
                'image_wrapper_classes' => 'w-25 border',
                'image_size'            => 'admin-thumb',
                'add_meta'              => 1,
                'meta_classes'          => '',
                'add_title'             => 1,
                'title_classes'         => 'small',
                'title_tag'             => 'h5',
                'wrapper_classes'       => 'blog-post-sm d-flex flex-row align-items-center',
                'body_classes'          => 'w-75',
                'layout'                => 'horizontal',
            );
            $related_posts .= maat_blog_grid_item($post_id, $post_args);
        }
        return $related_posts;
        wp_reset_postdata();
    } else {
        return false;
    }
}
