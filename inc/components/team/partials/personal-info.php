<?php
$acf_field = 'personal_info';
$item = item_title($acf_field);
$item_title = str_replace('-', ' ', $item);
$item_title = to_title_case($item_title);
if (get_field($acf_field)) : ?>
<div class="widget <?php echo $item; ?>">
    <h4 id="<?php echo $item; ?>-header" class="widget-title">
        <i class="dana dana-doc-confidential"></i> <span><?php echo $item_title; ?></span>
    </h4>
    <div id="<?php echo $item; ?>" class="widget-content">
        <?php the_field($acf_field); ?>
    </div>
</div>
<?php endif; ?>
