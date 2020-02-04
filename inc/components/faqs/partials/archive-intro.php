<?php
$post_type = get_post_type();
$item = item_title($post_type);
$intro = get_field($post_type . '_archive_intro_section', 'options');
$intro_title = $intro[$post_type . '_archive_intro_title'];
$intro_content = $intro[$post_type . '_archive_intro'];
?>
<?php if (!empty($intro_title) || !empty($intro_content)) { ?>
    <div class="wpb_text_column content-item">
        <?php if (!empty($intro_title)) { ?>
            <h2 class="display-1"><?php echo $intro_title; ?></h2>
        <?php
    } ?>
        <?php if (!empty($intro_content)) { ?>
            <?php echo $intro_content; ?>
        <?php
    } ?>
    </div>
<?php
} ?>