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

global $DB, $CFG, $PAGE, $OUTPUT;
require(__DIR__ . '/../../../config.php');
require_once("../lib.php");
require_once("$CFG->libdir/formslib.php");

$id = required_param("id", PARAM_INT); // Course_module ID
$pageid = required_param("pageid", PARAM_INT); // Page ID


$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$PAGE->set_url('/mod/interactivepdf/add_content.php', array('id' => $id, 'pageid' => $pageid));
$PAGE->set_title("Add Content");
$PAGE->set_heading("Add Content");
$page = $DB->get_record('interactivepdf_pages', array('id' => $pageid), '*', MUST_EXIST);


// Display the description editor form
echo $OUTPUT->header();

class add_content_form extends moodleform {
    public function definition() {

        $editoroption = array("subdirs"=>1,"maxfiles" => -1);
        $mform = $this->_form;
        $mform->addElement('editor', 'html_editor', 'Content', null, $editoroption);
        $mform->setType('html_editor', PARAM_RAW);
        $mform->setDefault('html_editor', $this->_customdata['html'] ?? '');


        $this->add_action_buttons();
    }
    function data_preprocessing(&$default_values) {
        if ($this->current->instance) {
            // editing existing instance - copy existing files into draft area
            $draftitemid = file_get_submitted_draft_itemid('files');
            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_folder', 'content', 0, array('subdirs'=>true));
            $default_values['files'] = $draftitemid;
        }
    }
}

$mform = new add_content_form(new moodle_url('/mod/interactivepdf/adminpages/add_content.php', array('id' => $id, 'pageid' => $pageid)));
if ($mform->is_cancelled()) {
    // Handle form cancellation, e.g., redirect back to the view page
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_page.php', array('id' => $id, 'pageid' => $pageid)));
}
elseif ($data = $mform->get_data()) {
    $phase_id = interactivepdf_insert_content($data, $context,$pageid);
    // Redirect to the view page after successful submission
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_page.php', array('id' => $id, 'pageid' => $pageid)));
}
$mform->display();

echo $OUTPUT->footer();

