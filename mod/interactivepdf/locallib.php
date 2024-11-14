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
 * Library of functions used by the INTERACTIVEPDF module.
 *
 * This contains functions that are called from within the INTERACTIVEPDF module only
 * Functions that are also called by core Moodle are in {@link lib.php}
 * This script also loads the code in {@link questionlib.php} which holds
 * the module-indpendent code for handling questions and which in turn
 * initialises all the questiontype classes.
 *
 * @package    mod_INTERACTIVEPDF
 * @copyright  1999 onwards Martin Dougiamas and others {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');
require_once($CFG->libdir . '/completionlib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/questionlib.php');

use mod_quiz\access_manager;
use mod_quiz\event\attempt_submitted;
use mod_quiz\grade_calculator;
use mod_quiz\question\bank\qbank_helper;
use mod_quiz\question\display_options;
use mod_quiz\quiz_attempt;
use mod_quiz\quiz_settings;
use qbank_previewquestion\question_preview_options;

/**
 * @var int We show the countdown timer if there is less than this amount of time left before the
 * the quiz close date. (1 hour)
 */
define('INTERACTIVEPDF_SHOW_TIME_BEFORE_DEADLINE', '3600');

/**
 * @var int If there are fewer than this many seconds left when the student submits
 * a page of the quiz, then do not take them to the next page of the quiz. Instead
 * close the quiz immediately.
 */
define('INTERACTIVEPDF_MIN_TIME_TO_CONTINUE', '2');

/**
 * @var int We show no image when user selects No image from dropdown menu in quiz settings.
 */
define('INTERACTIVEPDF_SHOWIMAGE_NONE', 0);

/**
 * @var int We show small image when user selects small image from dropdown menu in quiz settings.
 */
define('INTERACTIVEPDF_SHOWIMAGE_SMALL', 1);

/**
 * @var int We show Large image when user selects Large image from dropdown menu in quiz settings.
 */
define('INTERACTIVEPDF_SHOWIMAGE_LARGE', 2);

/**
 * @return array int => lang string the options for calculating the interactivepdf grade
 *      from the individual attempt grades.
 */
function interactivepdf_get_grading_options() {
    return [
        INTERACTIVEPDF_GRADEHIGHEST => get_string('gradehighest', 'interactivepdf'),
        INTERACTIVEPDF_GRADEAVERAGE => get_string('gradeaverage', 'interactivepdf'),
        INTERACTIVEPDF_ATTEMPTFIRST => get_string('attemptfirst', 'interactivepdf'),
        INTERACTIVEPDF_ATTEMPTLAST  => get_string('attemptlast', 'interactivepdf')
    ];
}

/**
 * Get the choices for what size user picture to show.
 * @return array string => lang string the options for whether to display the user's picture.
 */
function interactivepdf_get_user_image_options() {
    return [
        INTERACTIVEPDF_SHOWIMAGE_NONE  => get_string('shownoimage', 'interactivepdf'),
        INTERACTIVEPDF_SHOWIMAGE_SMALL => get_string('showsmallimage', 'interactivepdf'),
        INTERACTIVEPDF_SHOWIMAGE_LARGE => get_string('showlargeimage', 'interactivepdf'),
    ];
}

/**
 * @return array string => lang string the options for handling overdue quiz
 *      attempts.
 */
function interactivepdf_get_overdue_handling_options() {
    return [
        'autosubmit'  => get_string('overduehandlingautosubmit', 'interactivepdf'),
        'graceperiod' => get_string('overduehandlinggraceperiod', 'interactivepdf'),
        'autoabandon' => get_string('overduehandlingautoabandon', 'interactivepdf'),
    ];
}

