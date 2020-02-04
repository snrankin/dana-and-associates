<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  8-3-19
 * Last Modified: 8-4-19 at 12:04 am
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date    	By	Comments
 * --------	--	--------------------------------------------------------------
 * ========================================================================= */

?>

<h2 class="text-center"><?php esc_html__('Can\'t Find What You\'re Looking For?', 'oconnor'); ?></h2>
<p class="lead text-center"><?php esc_html__('Try a different search:', 'oconnor'); ?></p>
<?php get_search_form(); ?>
<p class="lead text-center mds-mt-2"><?php esc_html__('Or check out our other resources:', 'oconnor'); ?></p>
<?php
echo resources_menu_shortcode();
?>
