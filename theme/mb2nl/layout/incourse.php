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

echo $OUTPUT->theme_part('head');
echo $OUTPUT->theme_part('header');

$enrolment_page = theme_mb2nl_is_custom_enrolment_page();
$fullscreenmod = theme_mb2nl_full_screen_module();

if ( $enrolment_page )
{
	include( $CFG->dirroot . theme_mb2nl_themedir() . '/mb2nl/layout/enrol' . theme_mb2nl_enrol_layout() . '.php' );
}
elseif ( $fullscreenmod )
{
	include( $CFG->dirroot . theme_mb2nl_themedir() . '/mb2nl/layout/incourse_fullscreen.php' );
}
else
{
	include( $CFG->dirroot . theme_mb2nl_themedir() . '/mb2nl/layout/incourse_normal.php' );
}
?>
