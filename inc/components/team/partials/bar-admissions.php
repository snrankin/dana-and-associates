<?php
$acf_field = get_field('bar_admissions');
$item = item_title('bar_admissions');
$item_title = to_title_case($item_title);

if (!empty($acf_field)) : ?>

<div class="widget <?php echo $item; ?>">
    <h4 id="<?php echo $item; ?>-header" class="widget-title">
        <i class="dana dana-legal-scale"></i> <span>Bar Admissions</span>
    </h4>
    <ul id="<?php echo $item; ?>" class="widget-content <?php echo $item; ?>-list list-inline">
        <?php foreach ($acf_field as $state) { ?>
        <?php
                $value = $state['value'];
                $label = $state['label'];

                $abs_img = ASSETS_PATH . '/imgs/' . $value . '-state-bar-association-logo.png';
                $rel_img = ASSETS_PATH_URI . '/imgs/' . $value . '-state-bar-association-logo.png';
                ?>
        <li class="list-inline-item <?php echo $value; ?>">
            <?php if (file_exists($abs_img)) { ?>
            <img data-src="<?php echo $rel_img; ?>" alt="<?php echo $label; ?> State Bar Association" class="bar-admin lazyload img-fluid">
            <span class="sr-only"><?php echo $label; ?></span>
            <?php } else { ?>
            <?php echo $label; ?>
            <?php } ?>
        </li>
        <?php } ?>
    </ul>
</div>
<?php endif; ?>
