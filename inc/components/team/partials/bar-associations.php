
<?php
$acf_field = 'bar_associations';
$item = item_title($acf_field);
$item_title = str_replace('-', ' ', $item);
$item_title = to_title_case($item_title);

if (have_rows($acf_field)) : ?>
    <div class="widget <?php echo $item; ?>">
        <h4 id="<?php echo $item; ?>-header" class="widget-title">
            <i class="maat maat-law-book"></i> <span><?php echo $item_title; ?></span>
        </h4>
        <ul id="<?php echo $item; ?>" class="widget-content <?php echo $item; ?>-list list-unstyled">
        <?php
            while (have_rows($acf_field)) {
                the_row();
                $title = get_sub_field('title');
                $link = get_sub_field('link');
                if (!empty($link)) {
                    echo '<li><a href="' . $link . '" title="' . $title . '" target="_blank" rel="noopener noreferrer">' . $title . '</a></li>';

                } else {
                    echo '<li>' . $title. '</li>';
                }
            }
        ?>
        </ul>
    </div>
<?php endif; ?>