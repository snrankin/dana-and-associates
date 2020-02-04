</section>
<?php echo maat_cta(); ?>
</main><!-- .main_wrapper -->


<?php
$gt3_show_contact = gt3_option('show_contact_widget');

if (class_exists('RWMB_Loader')) {
    $mb_footer_switch = rwmb_meta('mb_footer_switch', array(), gt3_get_queried_object_id());
} else {
    $mb_footer_switch = '';
}

if (gt3_option('back_to_top') == '1' && $mb_footer_switch != 'no') {
    echo "<div class='back_to_top_container'><div class='container'>";
    echo "<a href='#' id='back_to_top'>" . esc_html__('Back To Top', 'oconnor') . "</a>";
    echo "</div></div>";
}
gt3_footer_area();

do_action('gt3_footer_action');
?>
</div><!-- .site_wrapper -->
<!-- <a href="#top" id="back-to-top"><i class="maat maat-angle-up-square"></i><span class="sr-only">Back To Top</span></a> -->
<?php wp_footer(); ?>
<?php schemaJSON(); ?>
</body>

</html>
