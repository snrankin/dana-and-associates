<?php
get_header();

$item = maat_item_type();
?>

<?php if (have_posts()): ?>
<div id="<?php echo $item; ?>-loop" class="section-wrapper">
    <?php get_component_partial('faqs', 'mobile-nav'); ?>
    <div class="section-inner">
        <div class="container">
            <div id="<?php echo $item; ?>-row" class="row">
                <div id="<?php echo $item; ?>-content" class="main-content col col-lg-8">
                    <div id="<?php echo $item; ?>-wrapper" class="content-wrapper d-block">

                        <?php get_component_partial($item, 'archive-intro'); ?>
                        <div id="<?php echo $item; ?>" class="content-item">
                            <?php while (have_posts()): ?>
                            <?php the_post(); ?>
                            <?php get_component_partial($item, 'loop-item'); ?>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php get_footer(); ?>
