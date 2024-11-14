<?php
//echo "hello";

global $PAGE, $OUTPUT, $DB, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/nquestion.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$questionid = required_param('questionid', PARAM_INT);

//$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
//$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
//$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);
//
//require_login($course, true, $cm);
//$context = context_module::instance($cm->id);

$PAGE->set_url('/mod/interactivepdf/nquestion.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid));
$PAGE->set_title("Interactive PDF - 3*n Table");

$form = new nquestion(new moodle_url('/mod/interactivepdf/adminpages/nquestion.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)));
if ($form->is_cancelled()) {
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)), 'Cancelled the form');
} elseif ($data = $form->get_data()) {
    $subQuestion = new stdClass();
    $subQuestion->quiz_id = $questionid;
    $subQuestion->interactivepdfid = $id;
    $subQuestion->question_text = $data->question_text;
    $subQuestion->correct_ans = '';
    $subQuestion->type = '3n';
    $subQuestion->timecreated = time();
    $subQuestion->timemodified = time();

    $subquestionid = $DB->insert_record('interactivepdf_subquestions', $subQuestion);

    $tableRecord = new stdClass();
    $tableRecord->interactivepdfid = $id;
    $tableRecord->subquestionid = $subquestionid;
    $tableRecord->header1 = $data->header1;
    $tableRecord->header2 = $data->header2;
    $tableRecord->header3 = $data->header3;
    $tableRecord->timecreated = time();
    $tableRecord->timemodified = time();
    $DB->insert_record('interactivepdf_3ns', $tableRecord);

    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)));

}

echo $OUTPUT->header();

$form->display();

echo $OUTPUT->footer();