<?php

function get_team_popups($item_id)
{
    $popups = '';
    $slug   = get_the_slug($item_id);

    $bio = get_the_content($item_id);

    $name = team_name($item_id);

    $img = get_the_post_thumbnail($item_id, 'medium', array('wrapper_class' => 'embed-responsive embed-responsive-1by1', 'class' => 'embed-responsive-item lazyload'));

    $job_title = team_job($item_id);

    ?>
<?php if (!empty($bio)) : ob_start(); ?>
<div id="<?php echo $slug; ?>" data-fancybox class="team-bio-popup p-0" tabindex="-1" role="dialog" aria-labelledby="<?php the_slug(get_the_id()); ?>-name" aria-hidden="true">
    <div class="container" style="overflow: hidden;">
        <div class="row no-gutters">
            <button data-fancybox-close class="btn btn-link close-btn close" aria-label="Close"><i class="dana close"></i></button>
            <?php if (has_post_thumbnail($item_id)) { ?>
            <div class="col-md-4">
                <div class="content-wrapper d-flex">
                    <div class="content-item"><?php echo $img; ?></div>
                </div>
            </div>
            <?php } ?>
            <div class="col-md-8">
                <div class="content-wrapper justify-content-center">
                    <div class="content-item mds-p-1">
                        <p class="h2 team-name mds-mb-0"><?php echo $name; ?></p>
                        <?php if (!empty($job_title)) {
                                    echo '<p class="h6 team-job mds-mb-2">' . $job_title . '</p>';
                                } ?>
                        <?php echo wpautop($bio); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $popups = ob_get_clean(); ?>
<?php endif; ?>
<?php return $popups; ?>
<?php

} ?>
