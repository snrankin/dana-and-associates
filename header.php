<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo (is_user_logged_in() && is_admin_bar_showing()) ? 'gt3_wp-admin-bar' : ''; ?>" <?php echo schemaPageType(); ?>>

<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
    <?php ?>
    <?php wp_head(); ?>
    <?php if (is_user_logged_in() && is_admin_bar_showing()) { ?>
    <?php get_component_partial('header', 'admin-bar-styles'); ?>
    <?php } ?>
</head>
<?php
$body_class = '';
$body_class .= gt3_option("add_default_typography_spacing") == '1' ? 'gt3_default_typography_sapcing' : '';
?>

<body id="top" <?php body_class($body_class); ?> data-theme-color="<?php echo esc_attr(gt3_option("theme-custom-color")); ?>">
    <?php get_component_partial('search', 'header-search'); ?>
    <div id="wrapper" class="site-wrapper">
        <?php get_component_template('header'); ?>
        <main class="main-wrapper">
            <?php get_component_template('page-header'); ?>
            <section id="content">
