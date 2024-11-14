<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2022 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */

defined('MOODLE_INTERNAL') || die();

//$bodycls = array();
$bodycls = theme_mb2nl_body_cls();

// Page builder footer style
//$urlparams = theme_mb2nl_get_url_params();
$footer = optional_param('footer', 0, PARAM_INT);

if ( $footer == 1 )
{
    $bodycls[] = 'builderfooter';
}
else 
{
    $bodycls[] = 'page-b'; // This is require because of the responsive break point class
}

$bodycls[] = 'page-layout-' . theme_mb2nl_theme_setting($PAGE, 'layout');
?>
<?php echo $OUTPUT->theme_part('head'); ?>
<body <?php echo $OUTPUT->body_attributes($bodycls) . theme_mb2nl_pagebg_image($PAGE); ?>>
<div id="page-outer">
<?php echo $OUTPUT->standard_top_of_body_html(); ?>
<div id="main-content">
<div id="page-content">
<?php echo $OUTPUT->main_content(); ?>
</div>
</div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html(); ?>
</body>
</html>
