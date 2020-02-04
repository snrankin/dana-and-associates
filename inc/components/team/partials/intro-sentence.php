<?php
$acf_field = 'intro_sentence';
$item = item_title($acf_field);
$item_title = str_replace('-', ' ', $item);
$item_title = to_title_case($item_title);
if (get_field($acf_field)) : ?>
    <p class="lead"><?php the_field($acf_field); ?></p>
<?php endif; ?>