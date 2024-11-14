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

$sidePre = theme_mb2nl_isblock($PAGE, 'side-pre');
$sidePost = theme_mb2nl_isblock($PAGE, 'side-post');
$sidebarPos = theme_mb2nl_sidebarpos();
$sidebars = theme_mb2nl_theme_setting($PAGE, 'fpsidebars');
$sidebar = ($sidePre || $sidePost);
$contentCol = 'col-lg-12';
$sidePreCol = 'col-lg-3';
$sidePostCol = 'col-lg-3';

if ($sidePre && $sidePost)
{
	$contentCol = 'col-lg-6';

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
elseif($sidePre || $sidePost)
{
	$contentCol = 'col-lg-9';

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

?>
<?php echo $OUTPUT->theme_part('head'); ?>
<?php echo $OUTPUT->theme_part('header'); ?>
<?php echo theme_mb2nl_slider(); ?>
<?php echo theme_mb2nl_notice(); ?>
<?php //echo $OUTPUT->theme_part('region_slider'); ?>
<?php //echo is_siteadmin() ? $OUTPUT->theme_part('page_header') : ''; ?>
<?php echo $OUTPUT->theme_part('course_banner'); ?>
<?php //echo $OUTPUT->theme_part('region_after_slider'); ?>
<?php //echo $OUTPUT->theme_part('region_before_content'); ?>
<div id="main-content">
    <div class="container-fluid">
        <div class="row">
            <section id="region-main" class="content-col <?php echo $contentCol; ?>">
                <div id="page-content">
					<?php //echo theme_mb2nl_page_builder_pagelink(); //theme_mb2nl_panel_link() . theme_mb2nl_page_builder_pagelink(); ?>
					<?php echo theme_mb2nl_check_plugins(); ?>
                	<?php echo $OUTPUT->course_content_header(); ?>
					<?php if ( ! theme_mb2nl_has_builderpage() ) : ?>
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
            </section>
     		<?php if ($sidePre) : ?>
            	<section class="sidebar-col <?php echo $sidePreCol; ?>">
                	<?php echo $OUTPUT->blocks('side-pre', theme_mb2nl_block_cls($PAGE, 'side-pre')); ?>
                </section>
       		<?php endif; ?>
     		<?php if ($sidePost) : ?>
            	<section class="sidebar-col <?php echo $sidePostCol; ?>">
                	<?php echo $OUTPUT->blocks('side-post', theme_mb2nl_block_cls($PAGE, 'side-post')); ?>
                </section>
        	<?php endif; ?>
        </div>
    </div>
</div>
<?php
	// If user use old page builder display the content
	if ( theme_mb2nl_check_builder() == 1 )
	{
		$builder = get_config('local_mb2builder');
		$builderfptext = isset( $builder->builderfptext ) ? json_decode( $builder->builderfptext ) : array();
		echo theme_mb2nl_page_builder_content( $builderfptext );
	}
?>
<?php echo theme_mb2nl_moodle_from(2018120300) ? $OUTPUT->standard_after_main_region_html() : '' ?>
<?php echo $OUTPUT->theme_part('region_bottom'); ?>
<?php echo $OUTPUT->theme_part('region_bottom_abcd'); ?>
<?php echo $OUTPUT->theme_part('footer', array('sidebar'=>$sidebar)); ?>
<?php echo $OUTPUT->theme_part('region_adminblock'); ?>
