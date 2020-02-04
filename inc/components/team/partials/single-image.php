<?php if (has_post_thumbnail()) : ?>
<div class="widget team-image-wrapper">
    <?php the_post_thumbnail('medium', array('title' => get_the_title(), 'alt' => get_the_title())); ?>
</div>
<?php endif; ?>
