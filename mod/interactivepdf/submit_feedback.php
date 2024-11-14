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

global $USER,$PAGE,$CFG;
// Get submitted parameters.
$id = required_param('id', PARAM_INT); // Course module id
$attemptid = optional_param('attemptid', 0, PARAM_INT); // Used to force a new preview
$pageid = optional_param('pageid', 0, PARAM_INT); // Used to force a new preview
$studentid = optional_param('studentid', 0, PARAM_INT); // Used to force a new preview


$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

$PAGE->set_url('/mod/interactivepdf/submit_feedback.php', array('id' => $id));
$PAGE->set_title("Interactive PDF");
$PAGE->set_heading("Interactive PDF");
echo $OUTPUT->header();

$record = $DB->get_record('interactivepdf_attempts',['interactivepdfid'=>$id,'attempt'=>$attemptid,'userid'=>$studentid,'status'=>1]);
$record->feedback_submit = 1;


$record->id = $DB->update_record('interactivepdf_attempts', $record);
$sender = $DB->get_record('user',['id'=>$USER->id]);
$receiver = $DB->get_record('user',['id'=>$studentid]);
$message = 'Hi '.$receiver->firstname. ' ' . $sender->firstname . ' has submitted Your '. $attemptid. ' no attempt\'s feedback. Here is your course link ' . $CFG->wwwroot.'/course/view.php?id='.$course->id;
$notification = new \core\message\message();
$notification->component = 'moodle';
$notification->name = 'instantmessage';
$notification->userfrom = $sender;
$notification->userto = $receiver;
$notification->subject = 'Quiz Feedback Submit';
$notification->fullmessage = $message;
$notification->fullmessageformat = FORMAT_HTML;
$notification->notification = 1;
$notification->contexturl = $CFG->wwwroot;
$messageid = message_send($notification);

$params = array('id' => $id);
$url = new moodle_url('/mod/interactivepdf/view.php', $params);
redirect($url);
echo $OUTPUT->footer();

