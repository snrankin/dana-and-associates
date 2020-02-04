<?php
$acf_field = 'school';
$item = item_title($acf_field);
$item_title = to_title_case($item);
if (have_rows($acf_field)) : ?>
<div class="widget <?php echo $item; ?>">
    <h4 id="<?php echo $item; ?>-header" class="widget-title">
        <i class="dana dana-education"></i> <span>Education</span>
    </h4>
    <ul id="<?php echo $item; ?>" class="widget-content list-unstyled">
        <?php while (have_rows($acf_field)) : the_row(); ?>
        <?php
                $school = get_sub_field('name');
                $location = get_sub_field('location');
                $year = get_sub_field('grad_year');
                $degree = get_sub_field('degree');
                $honors = get_sub_field('honors');

                $education = '<span>';
                $education .= (!empty($school)) ? $school : '';
                $education .= (!empty($location)) ? ' | ' . $location : '';
                $education .= '</span>';
                $education .= '<span>';
                $education .= (!empty($degree)) ? $degree : '';
                $education .= (!empty($year)) ? ' ' . $year : '';
                $education .= (!empty($honors)) ? ', ' . $honors : '';
                $education .= '</span>';
                ?>
        <li class="team-<?php echo $item; ?> mds-mb-0">
            <?php echo $education; ?>
        </li>
        <?php endwhile; ?>
    </ul>
</div>
<?php endif; ?>
