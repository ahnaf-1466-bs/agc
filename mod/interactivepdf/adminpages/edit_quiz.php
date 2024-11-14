<?php
/**
 * Version details of mod_interactivepdf.
 *
 * @package    mod_interactivepdf
 * @copyright  2023 @Md. Faisal Abid
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
global $DB, $OUTPUT, $PAGE, $CFG;
require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/short_question.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/mcq_question.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$contentid = required_param('contentid', PARAM_INT);
$quizid = required_param('quizid', PARAM_INT);
$mode = required_param('mode', PARAM_ALPHA);

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$PAGE->set_url('/mod/interactivepdf/adminpages/edit_quiz.php', ['id' => $id, 'pageid' => $pageid, 'contentid' => $contentid, 'quizid' => $quizid, 'mode' => $mode]);
$PAGE->set_title("Interactive PDF - Edit Quiz");
$PAGE->set_heading(format_string($course->fullname));

$quiz = $DB->get_record('interactivepdf_quizzes', ['id' => $quizid]);

if ($mode === 'shortques') {
    $form = new short_question_form(new moodle_url('/mod/interactivepdf/adminpages/edit_quiz.php', ['id' => $id, 'pageid' => $pageid, 'contentid' => $contentid, 'quizid' => $quizid, 'mode' => $mode]), ['quiz' => $quiz]);
}
//elseif ($mode === 'mcq') {
//    $options = $DB->get_records('interactivepdf_options', ['quiz_id' => $quizid]);
//    $form = new mcq_question(new moodle_url('/mod/interactivepdf/adminpages/edit_quiz.php', ['id' => $id, 'pageid' => $pageid, 'contentid' => $contentid, 'quizid' => $quizid, 'mode' => $mode]), ['quiz' => $quiz, 'options' => $options]);
//}

if ($form->is_cancelled()) {
    redirect(new moodle_url('/mod/interactivepdf/adminpages/quiz.php', ['id' => $id, 'pageid' => $pageid]), 'Cancelled the form');
}
elseif ($data = $form->get_data()) {
    $quiz->question = $data->question_editor['text'];
//    if ($mode === 'mcq') {
//        $quiz->option1 = $data->option1;
//        $quiz->option2 = $data->option2;
//        $quiz->option3 = $data->option3;
//        $quiz->option4 = $data->option4;
//    }

    $DB->update_record('interactivepdf_quizzes', $quiz);

    redirect(new moodle_url('/mod/interactivepdf/adminpages/quiz.php', ['id' => $id, 'pageid' => $pageid]), 'Quiz updated successfully');
}
echo $OUTPUT->header();

if ($form instanceof short_question_form) {
    $form->set_data(array(
        'question_editor' => array(
            'text' => $quiz->question,
            'format' => FORMAT_HTML,
        ),
    ));
}
$form->display();
echo $OUTPUT->footer();

