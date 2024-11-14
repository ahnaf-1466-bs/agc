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

$customLoginPage = theme_mb2nl_is_login(true);
$showContentPos = is_siteadmin() ? true : ($PAGE->pagetype !== 'login-index');

echo $OUTPUT->theme_part('head'); ?>
<?php echo $OUTPUT->theme_part('header'); ?>
<?php echo theme_mb2nl_notice(); ?>
<?php if (!$customLoginPage) : ?>
	<?php //echo $OUTPUT->theme_part('page_header'); ?>
	<?php echo $OUTPUT->theme_part('course_banner'); ?>
<?php endif; ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            	<div id="page-content">
					<?php //echo theme_mb2nl_panel_link(); ?>
                	<?php echo $OUTPUT->course_content_header(); ?>
					<?php if (theme_mb2nl_isblock($PAGE, 'content-top') && $showContentPos) : ?>
                		<?php echo $OUTPUT->blocks('content-top', theme_mb2nl_block_cls($PAGE, 'content-top','none')); ?>
             		<?php endif; ?>
                	<?php echo $OUTPUT->main_content(); ?>
                    <?php if (theme_mb2nl_isblock($PAGE, 'content-bottom') && $showContentPos) : ?>
                		<?php echo $OUTPUT->blocks('content-bottom', theme_mb2nl_block_cls($PAGE, 'content-bottom','none')); ?>
             		<?php endif; ?>
                    <?php //echo $OUTPUT->activity_navigation(); ?>
                	<?php echo $OUTPUT->course_content_footer(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (!$customLoginPage) : ?>
	<?php //echo $OUTPUT->theme_part('region_after_content'); ?>
<?php endif; ?>
<?php echo theme_mb2nl_moodle_from(2018120300) ? $OUTPUT->standard_after_main_region_html() : '' ?>
<?php echo $OUTPUT->theme_part('region_adminblock'); ?>
<?php if (!$customLoginPage) : ?>
	<?php echo $OUTPUT->theme_part('region_bottom'); ?>
	<?php echo $OUTPUT->theme_part('region_bottom_abcd'); ?>
<?php endif; ?>
<?php echo $OUTPUT->theme_part('footer', array('sidebar'=>false)); ?>
