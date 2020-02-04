<?php
$item = 'blog';
$related_posts = maat_related_posts();
?>
<div class="widget content-item social-share">
    <h4 class="widget-title">Share This Post:</h4>
    <?php echo displaySocialShare(); ?>
</div>
<div class="widget content-item author">
    <h4 class="widget-title">Written By:</h4>
    <?php echo maat_author(get_the_id(), 1); ?>
</div>
<?php if (!empty($related_posts)) : ?>
<div class="widget content-item related-posts">
    <h4 class="widget-title">Related Posts:</h4>
    <?php echo maat_related_posts(); ?>
</div>
<?php endif; ?>
