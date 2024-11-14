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

$sidebar = theme_mb2nl_isblock($PAGE, 'side-pre') || theme_mb2nl_is_toc() || $ratingblock;
$sidebarPos = theme_mb2nl_sidebarpos();

 if ( $sidebar )
 {
 	$contentCol = 'col-lg-9';
 	$sideCol = 'col-lg-3';

 	if ( $sidebarPos === 'left' || $sidebarPos === 'classic' )
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
<?php echo $OUTPUT->theme_part('course_banner'); ?>
<?php //echo $OUTPUT->theme_part('region_after_slider'); ?>
<?php //echo $OUTPUT->theme_part('region_before_content'); ?>
<?php echo theme_mb2nl_notice(); ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="row">
     		<section id="region-main" class="content-col <?php echo $contentCol; ?>">
            	<div id="page-content">
					<?php //echo theme_mb2nl_page_builder_pagelink(); ?>
					<?php echo theme_mb2nl_check_plugins(); ?>
                	<?php echo $OUTPUT->course_content_header(); ?>
					<?php if (theme_mb2nl_isblock($PAGE, 'content-top')) : ?>
                		<?php echo $OUTPUT->blocks('content-top', theme_mb2nl_block_cls($PAGE, 'content-top','none')); ?>
             		<?php endif; ?>
                    <?php echo theme_mb2nl_activityheader(); ?>
                	<?php echo $OUTPUT->main_content(); ?>
                    <?php if (theme_mb2nl_isblock($PAGE, 'content-bottom')) : ?>
                		<?php echo $OUTPUT->blocks('content-bottom', theme_mb2nl_block_cls($PAGE, 'content-bottom','none')); ?>
             		<?php endif; ?>
                    <?php echo theme_mb2nl_theme_setting($PAGE,'coursenav') ? theme_mb2nl_customnav() : $OUTPUT->activity_navigation(); ?>
                	<?php echo $OUTPUT->course_content_footer(); ?>
                </div>
       		</section>
            <?php if ($sidebar) : ?>
                <section class="sidebar-col <?php echo $sideCol; ?>">
                    <?php if ( theme_mb2nl_is_toc() ) : ?>
                        <?php echo theme_mb2nl_module_sections(true); ?>
                    <?php endif; ?>
                    <?php echo $ratingblock; ?>
                    <?php echo $OUTPUT->blocks('side-pre', theme_mb2nl_block_cls($PAGE, 'side-pre')); ?>
                </section>
            <?php endif; ?>
    	</div>
	</div>
</div>
<?php echo theme_mb2nl_moodle_from(2018120300) ? $OUTPUT->standard_after_main_region_html() : '' ?>
<?php //echo $OUTPUT->theme_part('region_after_content'); ?>
<?php echo $OUTPUT->theme_part('region_bottom'); ?>
<?php echo $OUTPUT->theme_part('region_bottom_abcd'); ?>
<?php echo $OUTPUT->theme_part('footer', array('sidebar'=>$sidebar)); ?>
<?php echo $OUTPUT->theme_part('region_adminblock'); ?>
