<?php

global $PAGE, $OUTPUT, $DB, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/header_question.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/squestion.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/mquestion.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$questionid = required_param('questionid', PARAM_INT);
$subquesid = required_param('subquesid',PARAM_INT);
$childquesid = optional_param('childquesid', 0,PARAM_TEXT);
$mode = required_param('type',PARAM_TEXT);
//var_dump($mode);
//die();
$action = optional_param('action', '', PARAM_ALPHA);

$PAGE->set_url('/mod/interactivepdf/adminpages/child_edit_question.php', array('id' => $id, 'pageid' =>$pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'childquesid' => $childquesid));
$PAGE->set_title("Interactive PDF - Edit Question");

if($mode === '3n'){
    $childQuestion = $DB->get_record('interactivepdf_3n_questions', ['id' => $childquesid]);

    $form = new hquestion(new moodle_url('/mod/interactivepdf/adminpages/child_edit_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'childquesid' => $childquesid, 'type' => $mode)));

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Cancelled the form');
    }
    elseif($data = $form->get_data()){
        $updateChildQuestion = new stdClass();
        $updateChildQuestion->id = $childquesid;
        $updateChildQuestion->question_text = $data->question_text;
        $updateChildQuestion->right_ans1 = $data->right_ans1;
        $updateChildQuestion->right_ans2 = $data->right_ans2;
        $updateChildQuestion->timemodified = time();
        $updateChildQuestion->timecreated = time();

        $DB->update_record('interactivepdf_3n_questions', $updateChildQuestion);

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Updated Successfully');
    }
    elseif ($action === 'delete'){
        $DB->delete_records('interactivepdf_3n_questions', array('id' => $childquesid));

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Deleted Successfully');
    }
    else {
        echo $OUTPUT->header();

        $form->set_data($childQuestion);
        $form->display();

        echo $OUTPUT->footer();
    }
}
elseif ($mode === '2ns'){
    $childQuestion = $DB->get_record('interactivepdf_2n_squestions', ['id' => $childquesid]);

    $form = new squestion(new moodle_url('/mod/interactivepdf/adminpages/child_edit_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'childquesid' => $childquesid, 'type' => $mode)));

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Cancelled the form');
    }
    elseif($data = $form->get_data()){
        $updateChildQuestion = new stdClass();
        $updateChildQuestion->id = $childquesid;
        $updateChildQuestion->question_text = $data->question_text;
        $updateChildQuestion->right_ans = $data->right_ans;
        $updateChildQuestion->timemodified = time();
        $updateChildQuestion->timecreated = time();

        $DB->update_record('interactivepdf_2n_squestions', $updateChildQuestion);

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Updated Successfully');
    }
    elseif ($action === 'delete'){
        $DB->delete_records('interactivepdf_2n_squestions', array('id' => $childquesid));

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Deleted Successfully');
    }
    else {
        echo $OUTPUT->header();

        $form->set_data($childQuestion);
        $form->display();

        echo $OUTPUT->footer();
    }
}elseif($mode === '2nm'){
    $childQuestion = $DB->get_record('interactivepdf_2n_mquestions', ['id' => $childquesid]);

    $form = new mquestion(new moodle_url('/mod/interactivepdf/adminpages/child_edit_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'childquesid' => $childquesid, 'type' => $mode)));

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Cancelled the form');
    }
    elseif($data = $form->get_data()){
        $updateChildQuestion = new stdClass();
        $updateChildQuestion->id = $childquesid;
        $updateChildQuestion->right_ans1 = $data->right_ans1;
        $updateChildQuestion->right_ans2 = $data->right_ans2;
        $updateChildQuestion->timemodified = time();
        $updateChildQuestion->timecreated = time();

        $DB->update_record('interactivepdf_2n_mquestions', $updateChildQuestion);

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Updated Successfully');
    }
    elseif ($action === 'delete'){
        $DB->delete_records('interactivepdf_2n_mquestions', array('id' => $childquesid));

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Deleted Successfully');
    }
    else {
        echo $OUTPUT->header();

        $form->set_data($childQuestion);
        $form->display();

        echo $OUTPUT->footer();
    }
}
