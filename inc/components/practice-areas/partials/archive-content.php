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
 * Last Modified: 7-18-19 at 4:43 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */
$item = maat_item_type();
if (!is_singular()) {
    $field_prefix = to_snake_case($item) . '_';
    $post_id      = 'options';
} else {
    $field_prefix = '';
    $post_id      = get_the_ID();

}

$archive_description = get_field($field_prefix . 'archive_description', $post_id);

if (!empty($archive_description) != 1) {
    return;
}

$archive_description_wrapper = '';
$archive_description_classes = array(
    'archive-description',
    'section-wrapper',
    $item . '-archive-description',
);
$archive_description_atts = array(
    'class' => maat_item_classes($archive_description_classes),
);

$description = '';

ob_start();

?>

<div <?php echo maat_add_item_data($archive_description_atts); ?>>
    <div class="section-inner">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="content-wrapper">
                        <div class="content-item">
                            <?php echo $archive_description; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $description = ob_get_clean();
echo $description;
?>
