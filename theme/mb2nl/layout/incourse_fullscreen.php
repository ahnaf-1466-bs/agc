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

user_preference_allow_ajax_update('fsmod-open-nav', PARAM_ALPHA);
user_preference_allow_ajax_update('fsmod-toggle-sidebar', PARAM_ALPHA);
$togglesections = get_user_preferences('fsmod-toggle-sidebar', 'toc');
$isisdebar = get_user_preferences('fsmod-open-nav', 'true');
$isisdebarcls = $isisdebar === 'true' ? ' issidebar' : ' nosidebar';
$courseprogress = theme_mb2nl_course_completion_percentage();
$isprogresscls = $courseprogress ? ' isprogress' : ' noprogress';

$sidebar = theme_mb2nl_isblock($PAGE, 'side-pre');
$PAGE->requires->js_call_amd('theme_mb2nl/fsmode','sidebarToggle');
$PAGE->requires->js_call_amd('theme_mb2nl/toc', 'courseTocScroll');

$activetoc = $togglesections === 'toc' ? ' active' : '';
$activeblocks = $togglesections === 'blocks' ? ' active' : '';
$activequicklinks = $togglesections === 'quicklinks' ? ' active' : '';

$quicknum = 2;

?>
<div class="fsmod-course<?php echo $isisdebarcls . $isprogresscls; ?>">
<div id="fsmod-header">
	<div class="fsmod-header-inner flexcols">
		<?php echo $OUTPUT->theme_part('logo'); ?>
		<div class="fsmod-header-links">
			<?php echo theme_mb2nl_panel_link('content', true, false); ?>
			<button type="button" class="fsmod-showhide-sidebar themereset" aria-label="<?php echo get_string('sidebar', 'theme_mb2nl'); ?>" aria-controls="fsmod-sidebar">
				<span class="img-icon icon-expand" aria-hidden="true"><?php echo theme_mb2nl_svg()['expand']; ?></span>
				<span class="img-icon icon-compress" aria-hidden="true"><?php echo theme_mb2nl_svg()['compress'];?></span>
			</button>
		</div>
		<?php echo theme_mb2nl_full_screen_module_backlink(); ?>
	</div>
</div>
<div class="fsmod-wrap">
	<div id="fsmod-sidebar" class="fsmod-course-sections">
		<div class="fsmod-sections-wrap">
			<?php echo theme_mb2nl_course_progressbar(); ?>
			<div class="fsmod-section-tools">
				<div class="fsmod-toggle-sidebar">
					<button type="button" class="themereset<?php echo $activetoc; ?>" aria-label="<?php echo get_string('sections'); ?>" data-id="toc" aria-controls="fsmod-sidebar-toc">1</button>
					<?php if ( $sidebar ) : $quicknum = 3; ?>
						<button type="button" class="themereset<?php echo $activeblocks; ?>" aria-label="<?php echo get_string('blocks'); ?>" data-id="blocks" aria-controls="fsmod-sidebar-blocks">2</button>
					<?php endif; ?>
					<?php if ( theme_mb2nl_site_menu() ) : ?>
						<button type="button" class="themereset<?php echo $activequicklinks; ?>" aria-label="<?php echo get_string('quicklinks', 'theme_mb2nl'); ?>" data-id="quicklinks" aria-controls="fsmod-sidebar-quicklinks"><?php echo $quicknum; ?></button>
					<?php endif; ?>
				</div>
			</div>
			<div id="fsmod-sidebar-toc" class="fsmod-section fsmod-sections<?php echo $activetoc; ?>">
				<?php echo theme_mb2nl_module_sections(); ?>
			</div>
			<?php if ( $sidebar ) : ?>
				<div id="fsmod-sidebar-blocks" class="fsmod-section fsmod-blocks<?php echo $activeblocks; ?>">				
					<section class="fullscreen-sidebar">
						<?php echo $OUTPUT->blocks('side-pre', theme_mb2nl_block_cls($PAGE, 'side-pre', 'none')); ?>
					</section>			
				</div>
			<?php endif; ?>
			<?php if ( theme_mb2nl_site_menu() ) : ?>
				<div id="fsmod-sidebar-quicklinks" class="fsmod-section fsmod-quicklinks<?php echo $activequicklinks; ?>">
					<?php echo theme_mb2nl_site_menu(true); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="fsmod-course-content">
		<div id="main-content">
			<section id="region-main" class="content-col">
				<div id="page-content">
					<?php echo $OUTPUT->page_heading_button(); ?>
					<?php //echo theme_mb2nl_page_builder_pagelink(); ?>
					<?php echo $OUTPUT->course_content_header(); ?>
					<?php echo theme_mb2nl_activityheader(); ?>
					<?php if (theme_mb2nl_isblock($PAGE, 'content-top')) : ?>
						<?php echo $OUTPUT->blocks('content-top', theme_mb2nl_block_cls($PAGE, 'content-top','none')); ?>
					<?php endif; ?>
					<?php echo $OUTPUT->main_content(); ?>
					<?php if (theme_mb2nl_isblock($PAGE, 'content-bottom')) : ?>
						<?php echo $OUTPUT->blocks('content-bottom', theme_mb2nl_block_cls($PAGE, 'content-bottom','none')); ?>
					<?php endif; ?>
					<?php echo theme_mb2nl_theme_setting($PAGE,'coursenav') ? theme_mb2nl_customnav() : $OUTPUT->activity_navigation(); ?>
					<?php echo $OUTPUT->course_content_footer(); ?>
				</div>
			</section>
		</div>
	</div>
</div>
</div>
<?php echo $OUTPUT->standard_after_main_region_html(); ?>
<?php echo $OUTPUT->theme_part('region_adminblock'); ?>
<?php echo $OUTPUT->theme_part('footer', array('sidebar'=>false)); ?>
