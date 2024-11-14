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

$mb2section = theme_mb2nl_mb2fields_filed('mb2section') && theme_mb2nl_theme_setting($PAGE, 'csection');
$reviews = theme_mb2nl_is_review_plugin();
$reviewlist = '';
$reviewsummary = '';
$startslink = '';
$canrate = '';
$ratealready = '';

if ( $reviews )
{
	if ( ! class_exists( 'Mb2reviewsHelper' ) )
	{
		require_once( $CFG->dirroot . '/local/mb2reviews/classes/helper.php' );
	}

	$rHlpr = new Mb2reviewsHelper;

	$canrate = $rHlpr->can_rate( $COURSE->id );
	$ratealready = $rHlpr->rate_already( $COURSE->id );
	$reviewlist = $rHlpr->review_list();
	$reviewsummary = $rHlpr->review_summary();
	$courserating = $rHlpr->course_rating($COURSE->id);
	$startslink = method_exists( $rHlpr, 'rating_stars_link' ) ? $rHlpr->rating_stars_link() : '';
}

?>
<?php echo theme_mb2nl_tabcontent_topics(); ?>
<?php if ( $mb2section ) : ?>
    <div id="course-nav-section-csection" class="course-nav-section course-nav-section-csection">
        <div id="course-mb2section" class="details-section mb2section">
            <h2 class="section-heading h3"><?php echo theme_mb2nl_mb2sectionfiledname(); ?></h2>
            <div class="details-content">
                <div class="content-inner"><?php echo theme_mb2nl_mb2fields_filed('mb2section'); ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ( $reviewsummary || $reviewlist || $canrate || $ratealready ) : ?>
    <div id="course-nav-section-reviews" class="course-nav-section course-nav-section-reviews">
        <div id="course-ratings" class="details-section reviews-starslink">
            <?php echo $startslink; ?>
        </div>
        <?php if ( $reviewsummary ) : ?>
            <div id="course-ratings" class="details-section reviews-summary">
                <h2 class="section-heading h3"><?php echo get_string( 'courserating', 'local_mb2reviews' ); ?></h2>
                <?php echo $reviewsummary; ?>
            </div>
        <?php endif; ?>
        <?php if ( $reviewlist ) : ?>
            <div class="details-section reviews">
                <h2 class="section-heading h3"><?php echo get_string( 'reviews', 'local_mb2reviews' ); ?></h2>
                <?php echo $reviewlist; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div id="course-nav-section-courseinfo" class="course-nav-section course-nav-section-courseinfo">
    <div id="course-mb2section" class="details-section mb2section">
        <div class="section-content">
            <div class="content-inner">
                <div class="course-summary course-section-part">
					<h2 class="section-heading h3"><?php echo get_string('coursesummary'); ?></h2>
					<div><div><?php echo theme_mb2nl_get_mb2course_description(); ?></div></div>
					<?php echo theme_mb2nl_moreless(); ?>
				</div>
				<div class="course-section-part">
					<h2 class="section-heading h3"><?php echo get_string( 'headinginstructors', 'theme_mb2nl' ); ?></h2>
					<?php echo theme_mb2nl_course_teachers_list($reviews, true); ?>
				</div>
				<?php echo theme_mb2nl_course_info_table(); ?>
            </div>
        </div>
    </div>
</div>
