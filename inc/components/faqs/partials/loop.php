<?php
$item = maat_item_type();
?>

<?php if (have_posts()) : ?>
    <div id="faqs-loop" class="section-wrapper">
        <div class="section-inner">
            <div id="faqs-grid" class="container">
                <div class="row justify-content-center">
                    <div id="faqs-content" class="main-content col col-lg-8">
                        <div class="content-wrapper">
                            <?php get_component_partial($item, 'mobile-nav'); ?>
                            <div id="faqs" class="content-item">
                                <?php while (have_posts()) : ?>
                                    <?php the_post(); ?>
                                    <?php get_component_partial($item, 'loop-item'); ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>