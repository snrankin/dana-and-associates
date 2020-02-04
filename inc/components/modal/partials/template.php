<?php function displayModal($id)
{
    $modal = get_post($id);
    $title = $modal->post_title;
    $content =  apply_filters('the_content', $modal->post_content);
    $show_title = get_field('show_title', $id);
    $modal_size = (!empty(get_field('modal_size', $id))) ? 'modal-' . get_field('modal_size', $id) : '';
    $show_footer = get_field('show_footer', $id);
    $modal_footer = get_field('modal_footer', $id);
    $target = get_the_slug($id);
    $modal_id = $target . '-modal';
    $modal_label = $modal_id . '-title';
    $modal_classes = array(
        'modal',
        'fade',
        $modal_size
    );
    $wrapper_class = get_post_class($modal_classes, $id);
    $modal_atts = array(
        'id' => $modal_id,
        'tabindex' => '-1',
        'role' => 'dialog',
        'aria-hidden' => true,
        'aria-labelledby' => $modal_label,
        'class' => maat_item_classes($wrapper_class)
    );
    ob_start();
    ?>
<div <?php echo maat_add_item_data($modal_atts); ?>>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <?php if (!empty($show_title == 1)) { ?>
            <div class="modal-header">
                <div class="modal-title">
                    <h4 id="<?php echo $modal_label; ?>" class="modal-title-text"><?php echo $title; ?></h4>
                </div>
                <div class="modal-close">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="dana dana-close"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <?php } else { ?>
                <div class="modal-body">
                    <div class="modal-close no-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="dana dana-close"></i>
                        </button>
                    </div>
                    <?php } ?>

                    <?php echo $content; ?>
                </div>
                <?php if ($show_footer == 1) { ?>
                <div class="modal-footer">
                    <?php echo $modal_footer; ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
        $popup = ob_get_clean();
        return $popup;
    }
    ?>
