<?php
$item          = maat_item_type();
$level         = count(get_post_ancestors($post->ID)) + 1;
$heading_level = $level + 1;
$class         = 'faqs-item level-' . $level;
?>
<div id="<?php echo get_the_slug(get_the_ID()); ?>" class="<?php echo $class; ?>" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
    <?php the_title('<h' . $heading_level . ' itemprop="name" role="heading" aria-level="' . $heading_level . '">', '</h' . $heading_level . '>', true); ?>
    <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
        <div itemprop="text">
            <?php the_content(); ?>
        </div>
    </div>
</div>
