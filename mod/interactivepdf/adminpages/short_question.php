<?php

/**
 * Short question form for interactivepdf.
 *
 * @package    mod_interactivepdf
 * @copyright  2023 @Md. Faisal Abid
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $DB, $PAGE, $OUTPUT, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("../lib.php");
require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/short_question.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$mode = required_param('mode', PARAM_INT);

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$PAGE->set_url('/mod/interactivepdf/adminpages/short_question.php',['pageid'=>$pageid,'mode'=>$mode]);
$PAGE->set_title('Interactive PDF - Short Question');
$PAGE->set_heading('Interactive PDF - Short Question');


$form = new short_question_form(new moodle_url('/mod/interactivepdf/adminpages/short_question.php', array('id'=>$id, 'pageid' => $pageid, 'mode' => $mode)));

if ($form->is_cancelled()) {
    redirect(new moodle_url('/mod/interactivepdf/adminpages/quiz.php', array('id' => $id, 'pageid' => $pageid)));
}

if ($data = $form->get_data()) {
    $content = new stdClass();
    $content->page_id = $pageid;
    $content->type = 'shortques';
    $content->timecreated = time();
    $content->timemodified = time();
    $contentid = $DB->insert_record('interactivepdf_contents', $content);

    $quiz = new stdClass();
    $quiz->content_id = $contentid;
    $quiz->question = '';
    $quiz->correct_ans = '';
    $quiz->timecreated = time();
    $quiz->timemodified = time();

    if (!empty($data->question_editor)) {
        $quiz->question_editor = $data->question_editor;
        $quiz = file_postupdate_standard_editor($quiz, 'question', interactivepdf_editor_options(), $context, 'mod_interactivepdf', 'question_editor', $quiz->id);
    }

    $questionid = $DB->insert_record('interactivepdf_quizzes', $quiz);

    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_question.php', array('id' => $id, 'pageid' => $pageid, 'questionid' => $questionid)),'Short Question Added Successfully');
}

echo $OUTPUT->header();
$form->display();
echo $OUTPUT->footer();
