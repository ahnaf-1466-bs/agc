<?php

global $PAGE, $OUTPUT, $DB, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/nquestion.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/single_question.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/multi_question.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$questionid = required_param('questionid', PARAM_INT);
$subquesid = required_param('subquesid', PARAM_INT);
$mode = required_param('type', PARAM_TEXT);
$action = optional_param('action', '', PARAM_ALPHA);

$PAGE->set_url('/mod/interactivepdf/adminpages/header_edit_question.php', array('id' => $id, 'pageid' =>$pageid, 'questionid' => $questionid, 'subquesid' => $subquesid));

if($mode === '3n'){
    $headerQuestion = $DB->get_record('interactivepdf_3ns', ['subquestionid' => $subquesid]);

    $form = new nquestion(new moodle_url('/mod/interactivepdf/adminpages/header_edit.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)));

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Cancelled the form');
    }
    elseif($data = $form->get_data()){
        $updateHeader = new stdClass();
        $updateHeader->id = $headerQuestion->id;
        $updateHeader->header1 = $data->header1;
        $updateHeader->header2 = $data->header2;
        $updateHeader->header3 = $data->header3;
        $updateHeader->timemodified = time();
        $updateHeader->timecreated = time();

        $DB->update_record('interactivepdf_3ns', $updateHeader);

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Updated Successfully');
    }
    elseif ($action === 'delete'){
        $DB->delete_records('interactivepdf_3n_questions', array('nid' => $headerQuestion->id));
        $DB->delete_records('interactivepdf_3ns', array('subquestionid' => $subquesid));

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Deleted Successfully');
    }
    else {
        echo $OUTPUT->header();

        $form->set_data($headerQuestion);
        $form->display();

        echo $OUTPUT->footer();
    }
}
elseif ($mode === '2ns'){
    $headerQuestion = $DB->get_record('interactivepdf_2ns', ['subquestionid' => $subquesid]);

    $form = new single_question(new moodle_url('/mod/interactivepdf/adminpages/header_edit.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)));

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Cancelled the form');
    }
    elseif($data = $form->get_data()){
        $updateHeader = new stdClass();
        $updateHeader->id = $headerQuestion->id;
        $updateHeader->header1 = $data->header1;
        $updateHeader->header2 = $data->header2;
        $updateHeader->timemodified = time();
        $updateHeader->timecreated = time();

        $DB->update_record('interactivepdf_2ns', $updateHeader);

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Updated Successfully');
    }
    elseif ($action === 'delete'){
        $DB->delete_records('interactivepdf_2n_squestions', array('nid' => $headerQuestion->id));
        $DB->delete_records('interactivepdf_2ns', array('subquestionid' => $subquesid));

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Deleted Successfully');
    }
    else {
        echo $OUTPUT->header();

        $form->set_data($headerQuestion);
        $form->display();

        echo $OUTPUT->footer();
    }
}
elseif ($mode === '2nm'){
    $headerQuestion = $DB->get_record('interactivepdf_2nms', ['subquestionid' => $subquesid]);

    $form = new multi_question(new moodle_url('/mod/interactivepdf/adminpages/header_edit.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)));

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Cancelled the form');
    }
    elseif($data = $form->get_data()){
        $updateHeader = new stdClass();
        $updateHeader->id = $headerQuestion->id;
        $updateHeader->header1 = $data->header1;
        $updateHeader->header2 = $data->header2;
        $updateHeader->timemodified = time();
        $updateHeader->timecreated = time();

        $DB->update_record('interactivepdf_2nms', $updateHeader);

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Updated Successfully');
    }
    elseif ($action === 'delete'){
        $DB->delete_records('interactivepdf_2n_mquestions', array('nid' => $headerQuestion->id));
        $DB->delete_records('interactivepdf_2nms', array('subquestionid' => $subquesid));

        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)), 'Deleted Successfully');
    }
    else {
        echo $OUTPUT->header();

        $form->set_data($headerQuestion);
        $form->display();

        echo $OUTPUT->footer();
    }
}


