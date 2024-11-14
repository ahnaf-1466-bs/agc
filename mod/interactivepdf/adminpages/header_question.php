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
$mode = required_param('type',PARAM_TEXT);

$PAGE->set_url('/mod/interactivepdf/adminpages/header_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode));
$PAGE->set_title("Interactive PDF - Header Question");

if ($mode === '3n'){
    $interactivepdf_3n_id = $DB->get_field('interactivepdf_3ns', 'id', ['subquestionid' => $subquesid]);

    $form = new hquestion(new moodle_url('/mod/interactivepdf/adminpages/header_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)));

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)), 'Cancelled the form');
    }
    elseif ($data = $form->get_data()) {
        $headerQuestion = new stdClass();
        $headerQuestion->interactivepdfid = $id;
        $headerQuestion->nid = $interactivepdf_3n_id;
        $headerQuestion->question_text = $data->question_text;
        $headerQuestion->right_ans1 = $data->right_ans1;
        $headerQuestion->right_ans2 = $data->right_ans2;
        $headerQuestion->timecreated = time();
        $headerQuestion->timemodified = time();

        $DB->insert_record('interactivepdf_3n_questions',$headerQuestion);
        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)));
    }
}elseif ($mode === '2ns'){
    $interactivepdf_2ns_id = $DB->get_field('interactivepdf_2ns', 'id', ['subquestionid' => $subquesid]);

    $form = new squestion(new moodle_url('/mod/interactivepdf/adminpages/header_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)));

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)), 'Cancelled the form');
    }
    elseif ($data = $form->get_data()) {
        $headerQuestion = new stdClass();
        $headerQuestion->interactivepdfid = $id;
        $headerQuestion->nid = $interactivepdf_2ns_id;
        $headerQuestion->question_text = $data->question_text;
        $headerQuestion->right_ans = $data->right_ans;
        $headerQuestion->timecreated = time();
        $headerQuestion->timemodified = time();

        $DB->insert_record('interactivepdf_2n_squestions',$headerQuestion);
        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)),'Data Stored Successfully');
    }
}elseif ($mode === '2nm'){
    $interactivepdf_2nms_id = $DB->get_field('interactivepdf_2nms', 'id', ['subquestionid' => $subquesid]);

    $form = new mquestion(new moodle_url('/mod/interactivepdf/adminpages/header_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)));

    if ($form->is_cancelled()) {
        redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)), 'Cancelled the form');
    }
    elseif ($data = $form->get_data()) {
        $headerQuestion = new stdClass();
        $headerQuestion->interactivepdfid = $id;
        $headerQuestion->nid = $interactivepdf_2nms_id;
        $headerQuestion->question_text = '';
        $headerQuestion->right_ans1 = $data->right_ans1;
        $headerQuestion->right_ans2 = $data->right_ans2;
        $headerQuestion->timecreated = time();
        $headerQuestion->timemodified = time();

        $DB->insert_record('interactivepdf_2n_mquestions',$headerQuestion);
        redirect(new moodle_url('/mod/interactivepdf/adminpages/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode)));
    }
}

echo $OUTPUT->header();

$form->display();

echo $OUTPUT->footer();