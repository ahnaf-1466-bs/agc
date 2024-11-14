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

$sidebarPosField = theme_mb2nl_mb2fields_filed('mb2sidebarpos');
$sidebarPos = ( ! is_null( $sidebarPosField ) && $sidebarPosField !== '' ) ? $sidebarPosField : theme_mb2nl_sidebarpos();
$sidePre = true;
$sidePost = theme_mb2nl_isblock($PAGE, 'side-post');

$sidebar = ( $sidePre || $sidePost );
$contentCol = ' col-lg-12';
$sidePreCol = ' col-lg-3';
$sidePostCol = ' col-lg-3';

if ( $sidePre && $sidePost )
{
	$contentCol = ' col-lg-6';
	$boxcls = 'gutter-thin theme-col-2';

	if ($sidebarPos === 'classic')
	{
		$contentCol .= ' order-2';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-3';
	}
	elseif ($sidebarPos === 'left')
	{
		$contentCol .= ' order-3';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-2';
	}

}
elseif ($sidePre || $sidePost)
{
	$contentCol = ' col-lg-9';

	if ($sidebarPos === 'classic')
	{
		$contentCol .= ' order-2';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-3';
	}
	elseif ($sidebarPos === 'left')
	{
		$contentCol .= ' order-3';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-2';
	}
}

$PAGE->requires->js_call_amd('theme_mb2nl/course','sectionTabs');
$PAGE->requires->js_call_amd('theme_mb2nl/course','sectionsToggle');

?>
<div class="course-layout layout2">
	<div class="container-fluid">
		<div class="row">
			<div class="course-contentcol content-col<?php echo $contentCol; ?>">
				<?php if (theme_mb2nl_isblock($PAGE, 'content-top')) : ?>
					<?php echo $OUTPUT->blocks('content-top', theme_mb2nl_block_cls($PAGE, 'content-top','none')); ?>
				<?php endif; ?>
				<?php echo theme_mb2nl_course_tabs('hor'); ?>
				<?php echo $OUTPUT->theme_part('course_sections'); ?>
				<div id="main-content" class="sr-only">
					<section id="region-main">
						<div id="page-content">
							<?php echo $OUTPUT->main_content(); ?>
						</div>
					</section>
				</div>
				<?php if (theme_mb2nl_isblock($PAGE, 'content-bottom')) : ?>
					<?php echo $OUTPUT->blocks('content-bottom', theme_mb2nl_block_cls($PAGE, 'content-bottom','none')); ?>
				<?php endif; ?>
			</div>
			<div class="course-sidebar sidebar-col<?php echo $sidePreCol; ?>">
				<div class="sidebar-inner">
					<?php //echo theme_mb2nl_module_sections(true); ?>
					<?php echo theme_mb2nl_course_progressbar(); ?>
					<?php echo theme_mb2nl_course_boxes('circle'); ?>
					<?php echo theme_mb2nl_course_tabs(); ?>
					<?php echo $OUTPUT->blocks('side-pre', theme_mb2nl_block_cls($PAGE, 'side-pre')); ?>
				</div>
			</div>
			<?php if ( $sidePost ) : ?>
				<div class="course-sidebar sidebar-col<?php echo $sidePostCol; ?>">
					<div class="sidebar-inner">
						<?php echo $OUTPUT->blocks('side-post', theme_mb2nl_block_cls($PAGE, 'side-post')); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php echo $OUTPUT->standard_after_main_region_html(); ?>
<?php echo $OUTPUT->theme_part('region_adminblock'); ?>
<?php echo $OUTPUT->theme_part('region_bottom'); ?>
<?php echo $OUTPUT->theme_part('region_bottom_abcd'); ?>
<?php echo $OUTPUT->theme_part('footer', array('sidebar'=> true)); ?>
