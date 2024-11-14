<?php


global $DB, $PAGE, $OUTPUT, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once(__DIR__ . '/../../../lib/datalib.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/quiz.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$PAGE->set_url('/mod/interactivepdf/adminpages/quiz.php', array('id' => $id, 'pageid' => $pageid));
$PAGE->set_title("Interactive PDF - Quiz");
$PAGE->set_heading("Interactive PDF - Quiz");


$form = new quiz(new moodle_url('/mod/interactivepdf/adminpages/quiz.php', array('id' => $id, 'pageid' => $pageid)));

if ($form->is_cancelled()) {

    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_page.php', array('id' => $id, 'pageid' => $pageid)), 'Cancelled the form');
} elseif ($data = $form->get_data()) {
    if ($data->question_type == 'short') {

        redirect(new moodle_url('/mod/interactivepdf/adminpages/short_question.php', array('id' => $id, 'pageid' => $pageid, 'mode' => 'shortques')));
    } elseif ($data->question_type == 'mcq') {

        // Process MCQ question here
        redirect(new moodle_url('/mod/interactivepdf/adminpages/mcq_question.php', array('id' => $id, 'pageid' => $pageid, 'mode' => 'mcq')));
    }
} else {
    echo $OUTPUT->header();
    $sql = 'SELECT iq.id as quizid, iq.content_id, iq.question, iq.correct_ans,
            CASE WHEN ic.type = "shortques" THEN 1 ELSE 0 END as is_short_question,
            CASE WHEN ic.type = "mcq" THEN 1 ELSE 0 END as is_mcq
            FROM {interactivepdf_quizzes} iq LEFT JOIN {interactivepdf_contents} ic 
            ON ic.id = iq.content_id LEFT JOIN {interactivepdf_pages} ip ON ip.id=ic.page_id 
            WHERE ip.id = :pageid';
    $quizzes = $DB->get_records_sql($sql, ['pageid' => $pageid]);

    $form->set_data($quizzes);
    $form->display();

    $display = (object)[
        'quizzes' => array_values($quizzes),
        'pageid' => $pageid,
        'id' => $id,
    ];

    echo $OUTPUT->render_from_template('mod_interactivepdf/quiz_template', $display);

    echo $OUTPUT->footer();

}