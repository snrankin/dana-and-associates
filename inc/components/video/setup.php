<?php
// Sample php code for playlistItems.list

function maat_video_structure($args = array())
{
    $defaults = array(
        'src'   => '',
        'url'   => '',
        'thumb' => array(
            'url'    => '',
            'width'  => '',
            'height' => '',
        ),
        'bgset' => '',
        'class' => '',
        'id'    => '',
        'host'  => 'youtube',
        'title' => '',
        'desc'  => '',
        'date'  => '',
    );

    $atts = wp_parse_args($args, $defaults);

    $src    = $atts['src'];
    $url    = $atts['url'];
    $thumb  = $atts['thumb'];
    $bgset  = $atts['bgset'];
    $class  = $atts['class'];
    $id     = $atts['id'];
    $host   = $atts['host'];
    $title  = $atts['title'];
    $desc   = $atts['desc'];
    $date   = $atts['date'];
    $width  = '';
    $height = '';

    if (empty($id) && empty($src)) {
        return;
    }

    $wrapper_classes = array(
        'content-item',
        'video-embed',
        'd-print-none',
        $class,
    );

    $video_classes = array(
        'embed-responsive',
        'bg-image',
        'lazyload',
        'type-' . $host,
    );

    $wrapper_atts = array(
        'id'        => $host . '-' . $id,
        'class'     => implode(' ', $wrapper_classes),
        'itemprop'  => 'video',
        'itemscope' => '',
        'itemtype'  => 'http://schema.org/VideoObject',
    );

    $video_atts = array(
        'data-' . $host => $id,
    );

    if (!empty($thumb)) {
        $video_atts['data-bg'] = 'url(' . $thumb['url'] . ')';

        $width  = intval($thumb['width']);
        $height = intval($thumb['height']);
        if (!empty($width) && !empty($height)) {
            $video_atts['data-aspectratio'] = getRatio($width, $height, '/');
            $video_atts['aspectratio']      = (($height / $width) * 100);
            $video_classes[]                = 'embed-responsive-' . getRatio($width, $height, 'by');
        }
    }
    if (!empty($bgset)) {
        $video_atts['data-sizes'] = 'auto';
        $video_atts['data-bgset'] = $bgset;
    }
    if ($host === 'youtube') {
        $video_atts['data-ytparams'] = 'modestbranding=1&playsinline=1';
    } elseif ($host === 'vimeo') {
        $video_atts['data-vimeoparams'] = 'byline=0&responsive=1&title=0&autoplay=0&portrait=0';
    }

    $video_atts['class'] = implode(' ', $video_classes);

    $video = '<div ' . maat_add_item_data($video_atts) . '>';
    if ($host === 'youtube' || $host === 'vimeo') {
        $video .= '<span class="embed-responsive-item d-flex justify-content-center align-items-center"><button class="play-btn  btn btn-link bg-transparent"><i class="dana dana-media-play-circle-filled"></i><span class="sr-only">Play Video</span></button></span>';
    } elseif ($host === 'iframe') {
        $video .= '<iframe frameborder="0" class="embed-responsive-item lazyload" allowfullscreen data-src="' . $src . '"></iframe>';
    } else {
        $video .= '<video class="embed-responsive-item lazyload" controls>';
        foreach ($src as $video_src) {
            $video .= '<source data-src="' . $video_src['url'] . '" type="' . $video_src['type'] . '">';
        }
        $video .= '</video>';
    }
    $video .= '</div>';

    $video_html = '';

    $video_html .= '<figure ' . maat_add_item_data($wrapper_atts) . '>';
    $video_html .= (!empty($thumb)) ? '<meta itemprop="thumbnailUrl" content="' . $thumb['url'] . '" />' : '';
    $video_html .= (!empty($url)) ? '<meta itemprop="contentURL" content="' . $url . '" />' : '';
    $video_html .= (!empty($url)) ? '<meta itemprop="embedURL" content="' . $url . '" />' : '';
    $video_html .= (!empty($date)) ? '<meta itemprop="uploadDate" content="' . $date . '" />' : '';
    $video_html .= (!empty($height)) ? '<meta itemprop="height" content="' . $height . '" />' : '';
    $video_html .= (!empty($width)) ? '<meta itemprop="width" content="' . $width . '" />' : '';
    $video_html .= $video;
    if (!empty($title) || !empty($desc)) {
        $video_html .= '<figcaption class="figure-caption video">';
        $video_html .= (!empty($title)) ? '<span class="font-weight-bold d-block" itemprop="name">' . $title . '</span>' : '';
        $video_html .= (!empty($desc)) ? '<span itemprop="description d-block">' . wp_trim_words($desc, 20) . '</span>' : '';
        $video_html .= '</figcaption>';
    }
    $video_html .= '</figure>';
    return $video_html;

}

function maat_youtube_video($video_id = '', $class = '')
{
    if (empty($video_id)) {
        return;
    }

    $id     = $video_id;
    $url    = 'https://youtu.be/' . $id;
    $thumb  = '';
    $bgset  = '';
    $class  = '';
    $host   = '';
    $title  = '';
    $desc   = '';
    $date   = '';
    $width  = '';
    $height = '';

    $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $video_id . '&key=' . YOUTUBE_KEY;

    $json = json_decode(file_get_contents($api_url), true);

    $video = $json['items'][0]['snippet'];

    if (!empty($video)) {
        $thumbnails = $video['thumbnails'];
        $lrg_size   = end($thumbnails);
        $thumb_url  = $lrg_size['url'];

        $width  = $lrg_size['width'];
        $height = $lrg_size['height'];

        foreach ($thumbnails as $thumb):
            $bgset .= $thumb['url'] . ' ' . $thumb['width'] . 'w, ';
        endforeach;
        $thumb = $thumbnails['default']['url'];
        $date  = $video['publishedAt'];

        $title = $video['title'];
        $desc  = $video['description'];
    }
    $args = array(
        'url'   => $url,
        'thumb' => array(
            'url'    => $thumb_url,
            'width'  => $width,
            'height' => $height,
        ),
        'bgset' => $bgset,
        'class' => $class,
        'id'    => $id,
        'host'  => 'youtube',
        'title' => $title,
        'desc'  => $desc,
        'date'  => $date,
    );

    return maat_video_structure($args);
}

function maat_youtube_playlist($playlist_id = '', $class = '', $columns = '', $video_classes = '')
{
    if (empty($playlist_id)) {
        return;
    }

    $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=3&playlistId=' . $playlist_id . '&key=' . YOUTUBE_KEY;

    $playlist = json_decode(file_get_contents($api_url), true);

    $video_gallery = '';
    $col_class     = '';
    if (!empty($columns)) {
        $col_class = ' col-lg-' . maat_num_col($columns);

    }

    if (!empty($playlist)) {
        $video_gallery = "\n" . '<div class="container-fluid video-gallery ' . $class . '">';
        $video_gallery .= "\n\t" . '<div class="row ">';

        foreach ($playlist['items'] as $item):

            $id = $item['snippet']['resourceId']['videoId'];

            $video_gallery .= "\n\t\t" . '<div class="' . $video_classes . $col_class . '">';
            $video_gallery .= "\n\t\t\t" . '<div class="content-wrapper">';
            $video_gallery .= "\n\t\t\t\t" . '<div class="content-item">';
            $video_gallery .= "\n\t\t\t\t\t" . maat_youtube_video($id);
            $video_gallery .= "\n\t\t\t\t" . '</div>';
            $video_gallery .= "\n\t\t\t" . '</div>';
            $video_gallery .= "\n\t\t" . '</div>';

        endforeach;
        $video_gallery .= "\n\t" . '</div>';
        $video_gallery .= "\n" . '</div>';

    }
    return $video_gallery;
}
