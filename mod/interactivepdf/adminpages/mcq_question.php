<?php
global $DB, $PAGE, $OUTPUT, $CFG;

require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once (__DIR__ . '/../../../lib/datalib.php');
require_once($CFG->dirroot . '/mod/interactivepdf/classes/form/mcq_question.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);
$mode = required_param('mode', PARAM_ALPHA);

$PAGE->set_url('/mod/interactivepdf/adminpages/mcq_question.php', array('id' => $id, 'pageid' => $pageid, 'mode' => $mode));
$PAGE->set_title("Interactive PDF - MCQ Question");
$PAGE->set_heading("Interactive PDF - MCQ Question");

$form = new mcq_question(new moodle_url('/mod/interactivepdf/adminpages/mcq_question.php', array('id' => $id, 'pageid' => $pageid, 'mode' => $mode)));

if ($form->is_cancelled()) {
    redirect(new moodle_url('/mod/interactivepdf/adminpages/quiz.php', array('id' => $id, 'pageid' => $pageid)), 'Cancelled the form');
} elseif ($data = $form->get_data()) {

    // Insert the type 'mcq' into interactivepdf_contents table
        $contentRecord = new stdClass();
        $contentRecord->page_id = $pageid;
        $contentRecord->type = 'mcq';
        $contentRecord->timecreated = time();
        $contentRecord->timemodified = time();
        $contentId = $DB->insert_record('interactivepdf_contents', $contentRecord);

    // Insert the question into interactivepdf_quizzes table
        $quizRecord  = new stdClass();
        $quizRecord ->content_id = $contentId;
        $quizRecord ->question = $data->question;
        $quizRecord ->correct_ans = $data->correct_ans;
        $quizRecord ->timecreated = time();
        $quizRecord ->timemodified = time();
        $questionId = $DB->insert_record('interactivepdf_quizzes', $quizRecord );

        // Save the options in the interactivepdf_options table
        $options = array($data->option1, $data->option2, $data->option3, $data->option4);
        foreach ($options as $option) {
            if (!empty($option)){
                $optionRecord = new stdClass();
                $optionRecord->quiz_id = $questionId;
                $optionRecord->option_text = $option;
                $optionRecord->timecreated = time();
                $optionRecord->timemodified = time();
                $DB->insert_record('interactivepdf_options', $optionRecord);
            }
        }

        redirect(new moodle_url('/mod/interactivepdf/adminpages/quiz.php', array('id' => $id, 'pageid' => $pageid)), 'MCQ question added successfully');

    } else {
        echo $OUTPUT->header();
        $form->display();
        echo $OUTPUT->footer();
    }