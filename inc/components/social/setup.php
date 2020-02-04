<?php
function socialProfiles($location = '', $class = '')
{
    $parent_location_id = get_field('parent_location', 'options');
    $location_id        = (!empty($location)) ? get_post_id_by_slug($location, 'location') : $parent_location_id;
    $company_name       = (!empty($location)) ? get_the_title($location_id) : get_bloginfo('name');
    $socials            = get_field('location_social_profiles', $location_id);

    if (!empty($socials)) {
        $social_profiles = '<div class="social-profiles ' . $class . '"><ul class="social-profiles-list list-inline">';

        foreach ($socials as $social) {
            $profile = '<li class="social-profile-item list-inline-item ' . sanitize_key($social['profile_title']) . '"><a href="' . $social['profile_url'] . '" title="' . $company_name . ' ' . $social['profile_title'] . '" target="_blank" class="social-profile-link bg-' . sanitize_key($social['profile_title']) . '"><span class="social-profile-icon embed-responsive embed-responsive-1by1">';
            if ($social['icon_type'] === 'icon') {
                $profile .= '<i class="profile-icon embed-responsive-item ';
                $profile .= $social['icon_class'];
                $profile .= '"></i>';
            } elseif ($social['icon_type'] === 'custom') {
                $profile .= '<img class="profile-icon custom-icon embed-responsive-item" src="';
                $profile .= $social['custom_icon'];
                $profile .= '"/>';
            }
            $profile .= '</span>';
            if (!empty($social['profile_title'])) {
                $profile .= '<span class="social-profile-title';
                $profile .= ($social['show_title'] !== 1) ? ' sr-only' : '';
                $profile .= '">';
                $profile .= $social['profile_title'];
                $profile .= '</span>';
            }
            $profile .= '</a></li>';

            $social_profiles .= $profile;
        }

        $social_profiles .= '</ul></div>';
        return $social_profiles;
    }
}

// Post social share
function displaySocialShare()
{
    $social_links = '<div class="social-profiles social-share"><ul class="social-profiles-list list-inline">';

    $id    = get_the_ID();
    $url   = get_permalink($id);
    $title = get_the_title($id);

    // -------------------------- Share on Facebook ------------------------- //

    $facebook_query = array(
        'u' => $url,
    );

    $facebook_url = add_query_arg($facebook_query, 'https://www.facebook.com/sharer.php');

    $facebook_atts = array(
        'href'    => $facebook_url,
        'onclick' => 'window.open(\'' . $facebook_url . '\',\'popup\',\'width=600,height=600\'); return false;',
        'target'  => 'popup',
        'title'   => 'Share this post on Facebook',
        'rel'     => 'nofollow',
        'class'   => 'social-profile-link bg-facebook',
    );

    $social_links .= '<li class="social-profile-item list-inline-item"><a' . maat_add_item_data($facebook_atts) . '><span class="social-profile-icon embed-responsive embed-responsive-1by1"><i class="dana dana-logo-facebook embed-responsive-item"></i></span></a></li>';

    // -------------------------- Share on Twitter -------------------------- //

    $twitter_query = array(
        'url'  => $url,
        'text' => rawurlencode($title),
        'via'  => 'danaassociates',
    );

    $twitter_url = add_query_arg($twitter_query, 'https://twitter.com/intent/tweet');

    $twitter_atts = array(
        'href'    => $twitter_url,
        'onclick' => 'window.open(\'' . $twitter_url . '\',\'popup\',\'width=600,height=600\'); return false;',
        'target'  => 'popup',
        'title'   => 'Share this post on Twitter',
        'rel'     => 'nofollow',
        'class'   => 'social-profile-link bg-twitter',
    );

    $social_links .= '<li class="social-profile-item list-inline-item"><a' . maat_add_item_data($twitter_atts) . '><span class="social-profile-icon embed-responsive embed-responsive-1by1"><i class="dana dana-logo-twitter embed-responsive-item"></i></span></a></li>';

    // --------------------------- Share via Email -------------------------- //

    $msg = $title . "\n";
    $msg .= $url . "\n\n";
    if (has_excerpt()) {
        $msg .= get_the_excerpt();
    }
    $email_query = array(
        'url'     => $url,
        'subject' => rawurlencode('Check Out This Article From ' . get_bloginfo('title')),
        'body'    => rawurlencode($msg),
    );

    $email_url = add_query_arg($email_query, 'mailto:');

    $email_atts = array(
        'href'    => $email_url,
        'onclick' => 'window.open(\'' . $email_url . '\',\'popup\',\'width=600,height=600\'); return false;',
        'target'  => 'popup',
        'title'   => 'Share this post via email',
        'rel'     => 'nofollow',
        'class'   => 'social-profile-link bg-primary',
    );

    $social_links .= '<li class="social-profile-item list-inline-item"><a' . maat_add_item_data($email_atts) . '><span class="social-profile-icon embed-responsive embed-responsive-1by1"><i class="dana dana-mail embed-responsive-item"></i></span></a></li>';

    // ------------------------- Print This Article ------------------------- //

    $email_atts = array(
        'onclick' => 'window.print(\'' . $url . '\');',
        'title'   => 'Print This Article',
        'class'   => 'social-profile-link bg-gray-700',
    );

    $social_links .= '<li class="social-profile-item list-inline-item"><button' . maat_add_item_data($email_atts) . '><span class="social-profile-icon embed-responsive embed-responsive-1by1"><i class="dana dana-tech-print embed-responsive-item"></i></span></button></li>';

    $social_links .= '</ul></div>';

    return $social_links;
}
include_component_partial('social', 'twitter-feed');
