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
global $CFG, $DB, $OUTPUT, $PAGE;
require(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once("$CFG->libdir/formslib.php");

$id = required_param("id", PARAM_INT); // Course_module ID
$pageid = required_param("pageid", PARAM_INT); // Page ID
$contentid = required_param("contentid", PARAM_INT); // Content ID

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

$PAGE->set_url('/mod/interactivepdf/edit_html.php', array('id' => $id, 'pageid' => $pageid, 'contentid' => $contentid));
$PAGE->set_title("Interactive PDF - Edit Content");
$PAGE->set_heading("Edit Content");

// Display the HTML editor form
echo $OUTPUT->header();

class edit_html_form extends moodleform
{
    public function definition()
    {
        $mform = $this->_form;

        $mform->addElement('editor', 'html_editor', 'Content', null, [
            'maxfiles' => EDITOR_UNLIMITED_FILES,
            'accepted_types' => '*',
            'maxbytes' => 1048576, // Maximum file size in bytes (1MB)
        ]);

        $mform->setType('html_editor', PARAM_RAW);
        $mform->setDefault('html_editor', $this->_customdata['description'] ?? '');

        $this->add_action_buttons();
    }
}

$html = $DB->get_record('interactivepdf_htmls',array('id' => $contentid));
$mform = new edit_html_form(new moodle_url('/mod/interactivepdf/adminpages/edit_html.php', array('id' => $id, 'pageid' => $pageid, 'contentid' => $contentid)));
if ($mform->is_cancelled()) {
    // Handle form cancellation, e.g., redirect back to the view page
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_page.php', array('id' => $id, 'pageid' => $pageid)));
} elseif ($data = $mform->get_data()) {
    $html->html = $data->html_editor['text']; // Retrieve the updated HTML content from the editor
    $html->timemodified = time();

    $DB->update_record('interactivepdf_htmls', $html);
    // Redirect to the view page after successful submission
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_page.php', array('id' => $id, 'pageid' => $pageid)),'Content Updated Successfully');
}
if ($contentid) {
    $content = interactivepdf_get_html_data($contentid);

    $formData = file_prepare_standard_editor($content, 'html', interactivepdf_editor_options(), $context, 'mod_interactivepdf', 'html_editor', $content->id);
    $mform->set_data($formData);
}
//$mform->set_data(['html_editor' => ['text' => $context->html]]);
//$mform->set_data(['html_editor' => ['text' => $context->html]]);
$mform->display();

echo $OUTPUT->footer();
