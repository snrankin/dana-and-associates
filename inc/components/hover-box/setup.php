<?php
function hoverBox($args = array())
{
    $defaults = array(
        'title'        => '',
        'text'         => '',
        'title_tag'    => 'h4',
        'icon'         => '',
        'link'         => array(
            'href'   => '',
            'title'  => '',
            'target' => '',
            'rel'    => '',
            'class'  => '',
        ),
        'image_id'     => '',
        'image_size'   => '',
        'hover_effect' => '',
        'class'        => '',
        'id'           => '',
    );
    $options = wp_parse_args($args, $defaults);
    extract($options);

    if (isset($link['class'])) {
        $link['class']  = maat_item_classes('hover-box-link stretched-link', $link['class']);
    } else {
        $link['class']  = 'hover-box-link stretched-link';
    }

    $url            = $link['href'];
    $image          = maat_bg_lazy_sizes($image_id, $image_size);
    $icon_html      = (!empty($icon)) ? sprintf('<i class="hover-box-icon %s"></i>', $icon) : '';
    $title_html     = (!empty($title)) ? sprintf('<%s class="hover-box-title">%s</%s>', $title_tag, __($title, 'maat'), $title_tag) : '';
    $text_html      = (!empty($text)) ? sprintf('<div class="hover-box-text">%s</div>', __($text, 'maat')) : '';
    $link_html      = (!empty($url)) ? '<a' . maat_add_item_data($link) . '></a>' : '';

    $wrapper_classes = array(
        'content-item',
        'hover-box',
        $hover_effect,
    );

    $wrapper_attributes = array(
        'id' => $id,
        'class' =>  maat_item_classes($class, $wrapper_classes),
    );

    if (!empty($id)) {
        $end_comment = '<!-- end #' . esc_attr($id) . '.content-item-->';
    } else {
        $end_comment = '<!-- end .content-item-->';
    }

    $wrapper_atts = maat_add_item_data($wrapper_attributes);

    ob_start();
    ?>
<figure <?php echo $wrapper_atts; ?>>
    <?php if (!empty($image)) { ?>
    <div class="hover-box-image lazyload bg-image" <?php echo $image; ?>></div>
    <?php } ?>
    <div class="hover-box-content-wrapper">
        <figcaption class="hover-box-content-wrapper-inner">
            <div class="hover-box-content">
                <div class="hover-box-title-wrapper">
                    <?php if (!empty($icon)) {
                            echo $icon_html;
                        } ?>
                    <?php if (!empty($title)) {
                            echo $title_html;
                        } ?>
                </div>
                <?php if (!empty($text)) {
                        echo $text_html;
                    } ?>
            </div>
        </figcaption>
        <?php if (!empty($link)) {
                echo $link_html;
            } ?>
    </div>
</figure>
<?php
    $hover_box = ob_get_clean();
    return $hover_box;
}
?>
