<?php

global $DB, $PAGE, $OUTPUT, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once (__DIR__ . '/../../../lib/datalib.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/sub_question.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$questionid = required_param('questionid', PARAM_INT);

$PAGE->set_url('/mod/interactivepdf/adminpages/sub_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid));
$PAGE->set_title("Interactive PDF - Sub Question");
$PAGE->set_heading("Interactive PDF - Sub Question");

$form = new sub_question(new moodle_url('/mod/interactivepdf/adminpages/sub_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)));

if ($form->is_cancelled()) {
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)), 'Cancelled the form');
} elseif ($data = $form->get_data()) {
    $subRecord = new stdClass();
    $subRecord->quiz_id = $questionid;
    $subRecord->interactivepdfid = $id;
    $subRecord->question_text = $data->question_text;
    $subRecord->correct_ans = $data->correct_ans;
    $subRecord->type = 'shortques';
    $subRecord ->timecreated = time();
    $subRecord ->timemodified = time();

    $DB->insert_record('interactivepdf_subquestions', $subRecord);

    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)));

}
else {
        echo $OUTPUT->header();
        $form->display();
        echo $OUTPUT->footer();
}