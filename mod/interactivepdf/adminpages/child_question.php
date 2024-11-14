<?php

global $PAGE, $OUTPUT, $DB, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once(__DIR__ . '/../../../lib/datalib.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$questionid = required_param('questionid', PARAM_INT);
$subquesid = required_param('subquesid', PARAM_INT);
$mode = required_param('type',PARAM_TEXT);

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

$PAGE->set_url('/mod/interactivepdf/child_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid, 'subquesid' => $subquesid, 'type' => $mode));
$PAGE->set_title("Interactive PDF - Child Question");
$PAGE->set_heading("Interactive PDF - Child Question");


$query1 = "SELECT * FROM {interactivepdf_3ns} WHERE subquestionid = ?";
$records3n = $DB->get_records_sql($query1, [$subquesid]);

$query2 = "SELECT * FROM {interactivepdf_2ns} WHERE subquestionid = ?";
$records2ns = $DB->get_records_sql($query2, [$subquesid]);

$query3 = "SELECT * FROM {interactivepdf_2nms} WHERE subquestionid = ?";
$records2nm = $DB->get_records_sql($query3, [$subquesid]);

//$sql = 'select i3nq.id,i3nq.question_text from {interactivepdf_3n_questions} i3nq Left Join {interactivepdf_3ns} i3n ON i3n.id = i3nq.nid where subquestionid = 6';
//$d = $DB->get_records_sql($sql);
//var_dump($d);
//die;
if ($mode === '2ns') {
    $sql = "SELECT i2nsq.id,i2nsq.question_text, i2nsq.right_ans FROM {interactivepdf_2n_squestions} i2nsq LEFT JOIN {interactivepdf_2ns} i2n ON i2n.id = i2nsq.nid WHERE subquestionid = ?";
} elseif ($mode === '3n') {
    $sql = "SELECT i3nq.id,i3nq.question_text, i3nq.right_ans1, i3nq.right_ans2 FROM {interactivepdf_3n_questions} i3nq LEFT JOIN {interactivepdf_3ns} i3n ON i3n.id = i3nq.nid WHERE subquestionid = ?";
} elseif ($mode === '2nm') {
    $sql = "SELECT i2nmq.id,i2nmq.question_text, i2nmq.right_ans1, i2nmq.right_ans2 FROM {interactivepdf_2n_mquestions} i2nmq LEFT JOIN {interactivepdf_2nms} i2nm ON i2nm.id = i2nmq.nid WHERE subquestionid = ?";
}

$childQuestions = [];
if (!empty($sql)) {
    $childQuestions = $DB->get_records_sql($sql, [$subquesid]);
}

$is2nsType = ($mode === '2ns');
$is3nType = ($mode === '3n');
$is2nmType = ($mode === '2nm');

$display = (object)[
    'childQuestions' => array_values($childQuestions),
    'records3n'      => array_values($records3n),
    'records2ns'     => array_values($records2ns),
    'records2nm'     => array_values($records2nm),
    'cid'            => $id,
    'pageid'         => $pageid,
    'questionid'     => $questionid,
    'subquesid'      => $subquesid,
    'is2nsType'      => $is2nsType,
    'is3nType'       => $is3nType,
    'is2nmType'      => $is2nmType,
    'type'           => $mode
];

echo $OUTPUT->header();

echo $OUTPUT->render_from_template('mod_interactivepdf/child_question', $display);

echo $OUTPUT->footer();
