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
 * This script deals with starting a new attempt at a interactivepdf.
 *
 * Normally, it will end up redirecting to attempt.php - unless a password form is displayed.
 *
 * This code used to be at the top of attempt.php, if you are looking for CVS history.
 *
 * @package   mod_interactivepdf
 * @copyright 2009 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');

// Get submitted parameters.
$id = required_param('id', PARAM_INT); // Course module id
$prev_attempt = optional_param('prev_attempt', 0, PARAM_INT); // Used to force a new preview



$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

$PAGE->set_url('/mod/interactivepdf/startattempt.php', array('id' => $cm->id));
$PAGE->set_title("Interactive PDF");
$PAGE->set_heading("Interactive PDF");
echo $OUTPUT->header();
$attempt = interactivepdf_create_new_attempt($prev_attempt, $id);

$params = array('id' => $id);
$url = new moodle_url('/mod/interactivepdf/view.php', $params);
redirect($url);
// Print footer.
echo $OUTPUT->footer();

//
//
//// Redirect to the attempt page.
//redirect();
