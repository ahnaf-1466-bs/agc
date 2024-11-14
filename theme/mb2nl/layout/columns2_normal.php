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

$ratingblock = false;

if ( theme_mb2nl_is_review_plugin() )
{
	if ( ! class_exists( 'Mb2reviewsHelper' ) )
	{
		require_once( $CFG->dirroot . '/local/mb2reviews/classes/helper.php' );
	}

	$ratingblock = Mb2reviewsHelper::rating_block(theme_mb2nl_theme_setting($PAGE, 'blockstyle2'));
}

$customLoginPage = theme_mb2nl_is_login(true);
$coursesfilter = theme_mb2nl_courses_filter_form();
$sidebar = theme_mb2nl_isblock($PAGE, 'side-pre') || $coursesfilter || theme_mb2nl_is_toc() || $ratingblock;

// Blog sidebar 
if ( theme_mb2nl_is_blog() && ! theme_mb2nl_theme_setting($PAGE, 'blogsidebar') )
{
	$sidebar = false;
}
elseif ( theme_mb2nl_is_blogsingle() && ! theme_mb2nl_theme_setting($PAGE, 'blogsinglesidebar') )
{
	$sidebar = false;
}

$sidebarPos = theme_mb2nl_sidebarpos();
$divFix = '';

if ($sidebar)
{
	$contentCol = 'col-lg-9';
	$sideCol = 'col-lg-3';

	if ($sidebarPos === 'left' || $sidebarPos === 'classic')
	{
		$contentCol .= ' order-2';
		$sideCol .= ' order-1';
	}
}
else
{
	$contentCol = 'col-lg-12';
}

?>
<?php //echo $OUTPUT->theme_part('head'); ?>
<?php //echo $OUTPUT->theme_part('header'); ?>
<?php echo theme_mb2nl_notice(); ?>
<?php //echo $OUTPUT->theme_part('region_slider'); ?>
<?php if ( ! $customLoginPage ) : ?>
	<?php //echo $OUTPUT->theme_part('page_header'); ?>
	<?php echo $OUTPUT->theme_part('course_banner'); ?>
<?php endif; ?>
<?php //echo $OUTPUT->theme_part('region_after_slider'); ?>
<?php //echo $OUTPUT->theme_part('region_before_content'); ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="row">
     		<section id="region-main" class="content-col <?php echo $contentCol; ?>">
            	<div id="page-content">
					<?php echo $OUTPUT->course_content_header(); ?>
					<?php //echo theme_mb2nl_panel_link(); ?>
					<?php echo theme_mb2nl_check_plugins(); ?>
					<?php if ($PAGE->pagetype === 'user-profile') : ?>
						<?php echo $OUTPUT->context_header(); ?>
					<?php endif; ?>
					<?php if (theme_mb2nl_isblock($PAGE, 'content-top')) : ?>
                		<?php echo $OUTPUT->blocks('content-top', theme_mb2nl_block_cls($PAGE, 'content-top','none')); ?>
             		<?php endif; ?>
                	<?php echo $OUTPUT->main_content(); ?>
                    <?php if (theme_mb2nl_isblock($PAGE, 'content-bottom')) : ?>
                		<?php echo $OUTPUT->blocks('content-bottom', theme_mb2nl_block_cls($PAGE, 'content-bottom','none')); ?>
             		<?php endif; ?>
                    <?php //echo $OUTPUT->activity_navigation(); ?>
                	<?php echo $OUTPUT->course_content_footer(); ?>
                </div>
       		</section><?php //echo $divFix; ?>
            <?php if ( $sidebar ) : ?>
                <section class="sidebar-col <?php echo $sideCol; ?>">
					<?php //echo $OUTPUT->addblockbutton(); ?>
					<?php if ( theme_mb2nl_is_toc() ) : ?>
                        <?php echo theme_mb2nl_module_sections(true); ?>
                    <?php endif; ?>
					<?php echo $ratingblock; ?>
					<?php echo $coursesfilter; ?>
                	<?php echo $OUTPUT->blocks('side-pre', theme_mb2nl_block_cls($PAGE, 'side-pre')); ?>
                </section>
            <?php endif; ?>
    	</div>
	</div>
</div>
<?php echo theme_mb2nl_moodle_from(2018120300) ? $OUTPUT->standard_after_main_region_html() : '' ?>
<?php //echo $OUTPUT->theme_part('region_after_content'); ?>
<?php echo $OUTPUT->theme_part('region_adminblock'); ?>
<?php if (!$customLoginPage) : ?>
	<?php echo $OUTPUT->theme_part('region_bottom'); ?>
	<?php echo $OUTPUT->theme_part('region_bottom_abcd'); ?>
<?php endif; ?>
<?php echo $OUTPUT->theme_part('footer', array('sidebar'=>$sidebar)); ?>