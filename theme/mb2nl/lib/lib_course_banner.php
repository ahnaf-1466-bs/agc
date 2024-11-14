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


/*
 *
 * Method to get course banner
 *
 */
function theme_mb2nl_course_banner()
{

	global $CFG, $COURSE, $PAGE;

	$output = '';
	$bannerbg = '';
	$cls = '';
	$headerstyle = theme_mb2nl_headerstyle();
	$bannerUrl = theme_mb2nl_course_image_url( $COURSE->id );
	$cbanner = theme_mb2nl_theme_setting( $PAGE, 'cbanner' );

	if ( preg_match('@transparent@', $headerstyle) )
	{
		return;
	}

	if ( $COURSE->id <= 1 || ! $cbanner || ! $bannerUrl )
	{
		return;
	}

	if ( $bannerUrl && $cbanner )
	{
		$bannerbg = ' style="background-image:url(\'' . $bannerUrl  . '\');"';
	}
	else
	{
		$cls .= ' noimage';
	}

	$courseurl = new moodle_url( $CFG->wwwroot . '/course/view.php',array( 'id'=> $COURSE->id ) );

	$output .= '<div class="theme-cbanner cbanner-fw' . $cls . '">';
	$output .= '<div class="cbanner-bg"' . $bannerbg . '>';
	$output .= '<a href="' . $courseurl . '" style="display:block;">';
	$output .= '<div class="banner-bg-inner">';

	//if ( $cname )
	//{
		$output .= '<div class="container-fluid">';
		$output .= '<div class="row">';
		$output .= '<div class="col-md-12">';
		$output .= '<h1 class="h4">' . format_text( $COURSE->fullname, FORMAT_HTML ) . '</h1>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	//}

	$output .= '</div>';
	$output .= '</a>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
