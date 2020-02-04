<?php
function html_to_obj($html)
{
    if (is_admin()) {
        return;
    }
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    return element_to_obj($dom->documentElement);
}

function element_to_obj($element)
{
    if (is_admin()) {
        return;
    }
    $obj = array("tag" => $element->tagName);
    foreach ($element->attributes as $attribute) {
        $obj[$attribute->name] = $attribute->value;
    }
    foreach ($element->childNodes as $subElement) {
        if ($subElement->nodeType == XML_TEXT_NODE) {
            $obj["html"] = $subElement->wholeText;
        } else {
            $obj["children"][] = element_to_obj($subElement);
        }
    }
    return $obj;
}

function reviewItemSchema($args)
{
    if (is_admin()) {
        return;
    }
    $defaults = array(
        'id' => '',
        'class'  => '',
        'content' => '',
        'date' => '',
        'author' => '',
        'rating' => '',
        'ratingBest' => '',
        'publisher' => '',
        'url' => '',
    );
    $atts = wp_parse_args($args, $defaults);
    extract($atts);

    $location = getLocationInfo();
    $logo = get_field('company_logo', 'options');
    $phone = $location['phone'];
    $address = $location['address']['full'];

    $wrapper_atts = array(
        'id' => $id,
        'class'  => maat_item_classes($class, 'maat-review'),
        'itemscope' => '',
        'itemtype' => 'https://schema.org/Review',
    );

    $reviewed_item_atts = array(
        'class'  => 'sr-only',
        'itemscope' => '',
        'itemprop' => 'itemReviewed',
    );

    if (!empty(get_field('schema_type', 'options'))) {
        $reviewed_item_atts['itemtype'] = 'https://schema.org/' . get_field('schema_type', 'options');
    } else {
        $reviewed_item_atts['itemtype'] = 'https://schema.org/Organization';
    }

    $reviewed_item = '<span' . maat_add_item_data($reviewed_item_atts) . '>';
    $reviewed_item .= (!empty($logo)) ? '<meta itemprop="image" content="' . $logo . '">' : '';
    $reviewed_item .= (!empty($phone)) ? '<meta itemprop="telephone" content="' . $phone . '">' : '';
    $reviewed_item .= (!empty($address)) ? '<meta itemprop="address" content="' . $address . '">' : '';
    $reviewed_item .= '<meta itemprop="name" content="' . get_bloginfo('name', true) . '">';
    $reviewed_item .= '</span>';

    $review_author_atts = array(
        'class'  => 'review-author',
        'itemscope' => '',
        'itemprop' => 'author',
        'itemtype' => 'https://schema.org/Person'
    );

    $review_author = '<span' . maat_add_item_data($review_author_atts) . '>';
    $review_author .= '<span itemprop="name">' . $author . '</span>';
    $review_author .= '</span>';

    $review_rating_atts = array(
        'class'  => 'review-rating',
        'itemscope' => '',
        'itemprop' => 'reviewRating',
        'itemtype' => 'https://schema.org/Rating'
    );

    $ratingInt = intval($rating);
    $i = 1;

    $review_rating = '<div' . maat_add_item_data($review_rating_atts) . '>';
    $review_rating .= '<span class="sr-only">Rated <span itemprop="ratingValue">' . strval($ratingInt) . '</span> out of <span itemprop="bestRating">' . $ratingBest . '</span> stars.</span>';
    $review_rating .= '</div>';

    $review_link_atts = array(
        'class'  => 'review-link',
        'href' => $url,
        'target' => '_blank',
        'rel' => 'nofollow',
        'title' => 'Read full review on ' . $publisher,
    );

    $review_link = '&hellip; <a' . maat_add_item_data($review_link_atts) . '>Read More &raquo;</a>';

    $review_publisher_atts = array(
        'class'  => 'review-publisher',
        'itemscope' => '',
        'itemprop' => 'publisher',
        'itemtype' => 'https://schema.org/Organization'
    );

    $review_publisher = ' via <cite' . maat_add_item_data($review_publisher_atts) . '>';
    $review_publisher .= '<span itemprop="name">' . $publisher . '</span>';
    $review_publisher .= '</cite>';

    $review_content_atts = array(
        'class'  => 'review-content lead',
        'itemprop' => 'reviewBody',
    );

    $content = str_replace(array(' â¦', 'â¦', 'â'), '', $content);
    $content = wptexturize($content);

    $review_content = '<p' . maat_add_item_data($review_content_atts) . '>';
    $review_content .= $content;
    $review_content .= (!empty($url)) ? $review_link : '';
    $review_content .= '</p>';

    $published_UTC_time       = date('c', strtotime($date));
    $published_formatted_time = time_elapsed_string($date);

    $review_date_atts = array(
        'class'  => 'review-date',
        'itemprop' => 'datePublished',
        'content' => $published_UTC_time
    );

    $review_date = ', published <time' . maat_add_item_data($review_date_atts) . '>';
    $review_date .= $published_formatted_time;
    $review_date .= '</time>';

    $review_header = '<div class="review-header">';
    $review_header .= $review_rating;
    $review_header .= $reviewed_item;
    $review_header .= '</div>';

    $review_footer = '<footer class="review-footer blockquote-footer">';
    $review_footer .= $review_author;
    $review_footer .= $review_date;
    $review_footer .= $review_publisher;
    $review_footer .= '</footer>';



    $review = '<div' . maat_add_item_data($wrapper_atts) . '>';
    $review .= '<blockquote class="blockquote review text-center mb-0">';
    $review .= $review_header;
    $review .= $review_content;
    $review .= $review_footer;
    $review .= '</blockquote>';
    $review .= '</div>';

    return $review;
}

function reviewsAggregated($args)
{
    if (is_admin()) {
        return;
    }
    $defaults = array(
        'class'         => '',
        'rating'        => '',
        'ratingBest'    => '',
        'totalRatings'  => ''
    );
    $atts = wp_parse_args($args, $defaults);
    extract($atts);

    $location = getLocationInfo();
    $logo = get_field('company_logo', 'options');
    $phone = $location['phone'];
    $address = $location['address']['full'];

    $wrapper_atts = array(
        'class'  => maat_item_classes($class, 'reviews-aggregated reviews-header mds-mb-2 text-center h5'),
        'itemscope' => '',
    );

    $aggregated_atts = array(
        'class'  => 'reviews-total',
        'itemscope' => '',
        'itemtype' => 'https://schema.org/AggregateRating',
        'itemprop' => 'aggregateRating'
    );

    if (!empty(get_field('schema_type', 'options'))) {
        $wrapper_atts['itemtype'] = 'https://schema.org/' . get_field('schema_type', 'options');
    } else {
        $wrapper_atts['itemtype'] = 'https://schema.org/Organization';
    }

    $reviewed_item = '<meta itemprop="name" content="' . get_bloginfo('name', true) . '">';
    $reviewed_item .= (!empty($logo)) ? '<meta itemprop="image" content="' . $logo . '">' : '';
    $reviewed_item .= (!empty($phone)) ? '<meta itemprop="telephone" content="' . $phone . '">' : '';
    $reviewed_item .= (!empty($address)) ? '<meta itemprop="address" content="' . $address . '">' : '';

    $ratingInt = intval($rating);
    $i = 1;

    $review_rating = '<div' . maat_add_item_data($aggregated_atts) . '>';
    $review_rating .= '<div class="review-star text-center">';
    while ($i <= $ratingInt) {
        $review_rating .= '<i class="dana dana-star text-secondary"></i>';
        $i++;
    }
    $review_rating .= '</div>';
    $review_rating .= '<span class="rating-title">Rated <span itemprop="ratingValue">' . strval($ratingInt) . '</span> out of <span itemprop="bestRating">' . $ratingBest . '</span> stars</span>';
    $review_rating .= '<small class="text-muted d-block text-center font-weight-normal">(out of <span itemprop="ratingCount">' . $totalRatings . '</span> reviews)</small>';
    $review_rating .= '</div>';

    $review_header = '<div' . maat_add_item_data($wrapper_atts) . '>';
    $review_header .= $review_rating;
    $review_header .= $reviewed_item;
    $review_header .= '</div>';
    return $review_header;
}

function reviewItem($elements)
{
    if (is_admin()) {
        return;
    }
    if (!empty($elements)) {
        $id_num = vc_random_string();
        $carousel_opts = array(
            'loop' => true,
            'items' => 1,
            'nav' => true,
            'dots' => false,
            'autoplay' => true,
            'autoplayHoverPause' => true,
            'autoplayTimeout' => 8000,
            'animateOut' => 'fadeOut'
        );
        $items = '';
        foreach ($elements as $element) {
            if ($element['class'] === 'broadly-review') {
                $review = $element['children'][1]['children'];
                $reviewRating = $review[0]['children'][0]['children'][0]['content'];
                $reviewAuthor = $review[0]['children'][1]['html'];
                $reviewDate = $review[0]['children'][2]['datetime'];
                $reviewBody = $review[1]['children'][0]['html'];
                $reviewLink = $review[1]['children'][1]['href'];
                $reviewPublisher = end($review);
                $reviewPublisher = $reviewPublisher['children'][0]['children'][0]['alt'];
                $args = array(
                    'id' => $element['id'],
                    'content' => $reviewBody,
                    'date' => $reviewDate,
                    'author' => $reviewAuthor,
                    'rating' => $reviewRating,
                    'ratingBest' => 5,
                    'publisher' => $reviewPublisher,
                    'url' => $reviewLink,
                );
                $items .= reviewItemSchema($args);
            }
        }
        $content = maat_carousel('carousel-' . $id_num, $items, $wrapper_class = 'maat-carousel owl-carousel', $carousel_opts);
        return $content;
    }
}

function broadlyReviews()
{
    if (is_admin()) {
        return;
    }
    $broadly_embed_url = 'https://embed.broadly.com/5b50ca8872190300138137ec/reviews';

    $response = wp_remote_get($broadly_embed_url);

    // Verify for errors - not being sent for reporting yet
    $content = null;
    $reviews = '';
    $aggregate = '';
    if (is_wp_error($response)) {
        $content = __('Error Found ( ' . $response->get_error_message() . ' )', 'broadly');
    } else {
        if (!empty($response["body"])) {
            $reviews = '<div class="maat-reviews">';
            $content = html_to_obj($response["body"]);
            $content = $content['children'][0]['children'][0]['children'];
            $aggregate = $content[0]['children'][0]['children'][0]['content'];
            $aggregateTotal = $content[0]['children'][1]['html'];
            preg_match('/\d+/', $aggregateTotal, $totalReviews);

            $total = $totalReviews[0];

            $args = array(
                'rating'        => $aggregate,
                'ratingBest'    => 5,
                'totalRatings'  => $total
            );
            $reviews .= reviewsAggregated($args);
            $reviews .= reviewItem($content);
            $reviews .= '</div>';
        } else {
            $content = __('No body tag in the response', 'broadly');
        }
    }

    return $reviews;
}
