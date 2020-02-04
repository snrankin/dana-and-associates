<?php

/** ===========================================================================
 * Description
 * @package Dana and Associates Website
 * @version 0.9.0
 * -----
 * @author Sam Rankin <sam@maatlegal.com>
 * @copyright Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  7-30-19
 * Last Modified: 7-31-19 at 10:28 am
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date    	By	Comments
 * --------	--	--------------------------------------------------------------
 * ========================================================================= */
$id = get_the_ID();
?>

<ul class="list-inline">
    <li class="list-inline-item"><?php echo maat_time($id); ?></li>
    <li class="list-inline-item"><?php echo maat_categories($id); ?></li>
    <li class="list-inline-item"><?php echo maat_tags($id); ?></li>
</ul>
