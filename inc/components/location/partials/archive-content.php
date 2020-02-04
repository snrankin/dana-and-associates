<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  7-18-19
 * Last Modified: 7-18-19 at 7:04 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */
$archive_description = get_the_archive_description();

if (empty($archive_description)): return;endif;

$archive_description_wrapper = '';
$archive_description_classes = array(
    'archive-description',
    'col-lg-9',
    $item . '-archive-description',
);
$archive_description_atts = array(
    'class' => maat_item_classes($archive_description_classes),
);

$description = '';

ob_start();

?>

<div <?php echo maat_add_item_data($archive_description_atts); ?>>
    <div class="content-wrapper">
        <div class="content-item">
            <?php the_archive_description(); ?>
        </div>
    </div>
</div>
<?php $description = ob_get_clean();
echo $description;
?>
