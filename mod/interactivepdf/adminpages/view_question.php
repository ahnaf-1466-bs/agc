<?php
global $PAGE, $OUTPUT, $DB, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once (__DIR__ . '/../../../lib/datalib.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$questionid = required_param('questionid', PARAM_INT);


$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

$PAGE->set_url('/mod/interactivepdf/view_question.php', array('id' => $id, 'pageid' => $pageid));
$PAGE->set_title("Interactive PDF - Page");
$PAGE->set_heading("Interactive PDF - Page");


echo $OUTPUT->header();

$question = $DB->get_record('interactivepdf_quizzes', array('id' => $questionid));

$subQuestions = $DB->get_records('interactivepdf_subquestions',['quiz_id' => $questionid]);

$display = (object)[
    'questions' => [
        [
            'ques' => $question->question
        ]
    ],
    'cid' => $id,
//    'nid' => $nid,
    'pageid' => $pageid,
    'questionid' => $questionid,
    'subques' => array_values($subQuestions),
];

$subques_with_type = array();
foreach ($subQuestions as $subQuestion) {
    $subQuestion->is_3n_type = ($subQuestion->type === '3n');
    $subQuestion->is_2ns_type = ($subQuestion->type === '2ns');
    $subQuestion->is_2nm_type = ($subQuestion->type === '2nm');
    $subQuestion->isShortquesType = ($subQuestion->type === 'shortques');
    $subques_with_type[] = $subQuestion;
}
$display->subques = $subques_with_type;

echo $OUTPUT->render_from_template('mod_interactivepdf/view_question', $display);

echo $OUTPUT->footer();
