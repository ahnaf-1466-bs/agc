<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Version details of mod_interactivepdf.
 *
 * @package    mod_interactivepdf
 * @copyright  2023 @Md. Faisal Abid
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $DB, $PAGE, $OUTPUT, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once (__DIR__ . '/../../../lib/datalib.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/edit_page.php');

$PAGE->set_title("Interactive PDF - Edit Page");
$PAGE->set_heading("Interactive PDF - Edit Page");
$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);

$context = context_module::instance($cm->id);
require_capability('mod/interactivepdf:add_page', $context);

// Retrieve the page from the database
$page = $DB->get_record('interactivepdf_pages', array('id' => $pageid));

// Create the form
$form = new edit_page(new moodle_url('/mod/interactivepdf/adminpages/edit_page.php', array('id'=>$id, 'pageid' => $pageid)));

if ($form->is_cancelled()) {
    // Handle form cancellation
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_page.php', array('id' => $id, 'pageid' => $pageid)),'Cancelled the form');
} elseif ($data = $form->get_data()) {
    // Form submitted and data validated

    // Update the page in the database
    $page->title = $data->title;
    $page->description = $data->description_editor['text'];
    $page->timemodified = time();

    $DB->update_record('interactivepdf_pages', $page);

    // Redirect back to the view page
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_page.php', array('id' => $id, 'pageid' => $pageid)), 'Data Updated');
}

// Display the form
echo $OUTPUT->header();
echo $OUTPUT->heading('Edit Page');

$form->set_data(array(
    'title' => $page->title,
    'description_editor' => array(
        'text' => $page->description,
        'format' => FORMAT_HTML, // Assuming the description is stored as HTML
    ),
));

$form->display();

echo $OUTPUT->footer();

