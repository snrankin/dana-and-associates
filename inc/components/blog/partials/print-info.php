<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  7-19-19
 * Last Modified: 7-22-19 at 6:21 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date        By    Comments
 * --------    --    --------------------------------------------------------------
 * ========================================================================= */
$image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
?>
<?php if (has_post_thumbnail()) : ?>
<div class="d-none d-print-block embed-responsive embed-responsive-16by9 bg-image mds-mb-5 bg-image-xc-yc" style="background-image: url(<?php echo $image_url; ?>)"></div>
<?php endif; ?>
<?php the_title('<h1 class="display-1 d-none d-print-block">', '</h1>'); ?>
<div class="d-none d-print-block print-info mds-mb-4">
    <ul class="list-inline">
        <li class="meta-wrapper list-inline-item blog-author">
            <?php echo maat_author(); ?>
        </li>
        <li class="meta-wrapper blog-date list-inline-item">
            <?php echo maat_time(); ?>
        </li>
        <?php if (get_the_category_list()) : ?>
        <li class="meta-wrapper blog-categories list-inline-item"><?php echo maat_categories(); ?></li>
        <?php endif; ?>
        <?php if (get_the_tag_list()) : ?>
        <li class="meta-wrapper blog-tags list-inline-item"><?php echo maat_tags(); ?></li>
        <?php endif; ?>
        <li class="meta-wrapper list-inline-item blog-link">
            <i class="dana dana-bookmark meta-icon"></i><span class="meta-title">Original URL:&thinsp;</span><?php the_permalink(); ?>
        </li>
    </ul>
</div>
