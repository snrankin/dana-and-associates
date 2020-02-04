<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  7-10-19
 * Last Modified: 7-10-19 at 6:20 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */
$id    = get_the_ID();
$item  = maat_item_type($id);
$title = maat_item_title($id);

?>
<?php if (get_previous_posts_link() || get_next_posts_link()): ?>
<nav role="navigation" aria-label="Single <?php echo $title; ?> Navigation" class="single-<?php echo $item; ?>-nav row">
<?php if (get_previous_posts_link()): ?>
<div class="col-md-auto">
<?php previous_posts_link('<i class="dana dana-angle-left"></i> Older'); ?>
</div>

<?php endif; ?>
<?php if (get_next_posts_link()): ?>
<div class="col-md-auto">
    <?php next_posts_link('<i class="dana dana-angle-left"></i> Older'); ?>
</div>
<?php endif; ?>
</nav> <!-- end navigation -->

<?php endif; ?>