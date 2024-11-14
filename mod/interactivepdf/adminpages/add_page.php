<?php

global $DB, $OUTPUT, $PAGE, $CFG;
require_once(__DIR__ . '/../../../config.php');
require_once(__DIR__ . '/../../../lib/datalib.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/add_page.php');

$id = optional_param('id', 0, PARAM_INT);
$returnto = optional_param('returnto', null, PARAM_LOCALURL);


$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$PAGE->set_url(new moodle_url('/mod/interactivepdf/adminpages/add_page.php', array('id' => $id)));
$PAGE->set_title("Add Page");
$PAGE->set_heading("Add Page");

if (!empty($returnto)) {
    $returnto = new moodle_url($returnto);
} else {
    $returnto = new moodle_url('/mod/interactivepdf/view.php', array('id' => $id));
}

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$interactivepdf = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, false, $cm);

$context = context_module::instance($cm->id);
require_capability('mod/interactivepdf:add_page', $context);

$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);


//$cmid = optional_param('id',0, PARAM_INT);
//$cm = get_coursemodule_from_id('interactivepdf', $cmid, 0, false, MUST_EXIST);

//we want to display our form.
$mform = new add_page(new moodle_url('/mod/interactivepdf/adminpages/add_page.php', array('id' => $id)));
if ($mform->is_cancelled()) {
//    redirect($CFG->wwwroot . '/mod/interactivepdf/view.php',array('id' => $id),"cancelled");
    redirect($returnto, 'Cancelled');
} else if ($fromform = $mform->get_data()) {

    $insertRecord = new stdClass();
    $insertRecord->title = $fromform->title;
    $insertRecord->interactivepdfid = $id;
    $fromform->description = '';

    if (!empty($fromform->description_editor)) {
        $insertRecord->description_editor = $fromform->description_editor;
        $insertRecord = file_postupdate_standard_editor($insertRecord, 'description', array("subdirs" => true, "maxfiles" => -1, "maxbytes" => 0), $context, 'mod_interactivepdf', 'description', $insertRecord->id);
    }

    $DB->insert_record('interactivepdf_pages', $insertRecord);

    redirect($returnto, 'Data Stored Successfully');

}

echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();
