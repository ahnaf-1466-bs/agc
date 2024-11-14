<?php
global $DB, $PAGE, $OUTPUT, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once (__DIR__ . '/../../../lib/datalib.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/sub_question.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$questionid = required_param('questionid', PARAM_INT);
$subquesid = required_param('subquesid', PARAM_INT);
$action = optional_param('action', '', PARAM_ALPHA);
$mode = optional_param('type', '', PARAM_TEXT);
//$mode = required_param('type',PARAM_TEXT);
//var_dump($mode);
//die();

$PAGE->set_url('/mod/interactivepdf/adminpages/edit_question.php', array('id' => $id, 'pageid' =>$pageid, 'questionid' => $questionid, 'subquesid' => $subquesid));
$PAGE->set_title("Interactive PDF - Edit Question");
$PAGE->set_heading("Interactive PDF - Edit Question");

$subquestion = $DB->get_record('interactivepdf_subquestions', array('id' => $subquesid));

$form = new sub_question(new moodle_url('/mod/interactivepdf/adminpages/edit_question.php', array('id' => $id, 'pageid'=>$pageid, 'questionid' => $questionid, 'subquesid' => $subquesid)));

if ($form->is_cancelled()) {
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)), 'Cancelled the form');
} elseif ($data = $form->get_data()) {
    $updateQuestion = new stdClass();
    $updateQuestion->id = $subquesid;
    $updateQuestion->question_text = $data->question_text;
    $updateQuestion->correct_ans = $data->correct_ans;
    $updateQuestion->timemodified = time();
    $updateQuestion->timecreated = time();

    $DB->update_record('interactivepdf_subquestions', $updateQuestion);

    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)),'Updated Successfully');

}elseif ($action === 'delete') {

    if($mode === '2nm'){
        $del = $DB->get_record('interactivepdf_2nms',['subquestionid' => $subquesid]);

        $DB->delete_records('interactivepdf_2n_mquestions',['nid' =>$del->id]);
        $DB->delete_records('interactivepdf_2nms',['subquestionid' =>$subquesid]);
        $DB->delete_records('interactivepdf_subquestions',['id' =>$subquesid]);

    }
    elseif ($mode === '2ns'){
        $del = $DB->get_record('interactivepdf_2ns',['subquestionid' => $subquesid]);

        $DB->delete_records('interactivepdf_2n_squestions',['nid' =>$del->id]);
        $DB->delete_records('interactivepdf_2ns',['subquestionid' =>$subquesid]);
        $DB->delete_records('interactivepdf_subquestions',['id' =>$subquesid]);

    }
    elseif ($mode === '3n'){
        $del = $DB->get_record('interactivepdf_3ns',['subquestionid' => $subquesid]);

        $DB->delete_records('interactivepdf_3n_questions',['nid' =>$del->id]);
        $DB->delete_records('interactivepdf_3ns',['subquestionid' =>$subquesid]);
        $DB->delete_records('interactivepdf_subquestions',['id' =>$subquesid]);

    }
    else{
        $DB->delete_records('interactivepdf_subquestions', ['id' => $subquesid]);
    }
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)),'Deleted Successfully');
} else {
    echo $OUTPUT->header();
    $form->set_data($subquestion);
    $form->display();
    echo $OUTPUT->footer();
}

