<?php

global $DB, $PAGE, $CFG, $OUTPUT;
require_once(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");
require_once(__DIR__ . '/../../../lib/datalib.php');

$id = required_param('id', PARAM_INT);
$pageid = required_param('pageid', PARAM_INT);

$questions = $DB->get_records_sql(
    "SELECT * FROM {interactivepdf_contents} WHERE page_id = :pageid AND type LIKE 'html' ORDER BY timemodified DESC",
    ['pageid' => $pageid]
);

// Print the page header
$PAGE->set_url('/mod/interactivepdf/adminpages/view_questions.php', array('id' => $id, 'pageid' => $pageid));
$PAGE->set_title("Interactive PDF - View Questions");
$PAGE->set_heading("Interactive PDF - View Questions");
echo $OUTPUT->header();

if (empty($questions)) {
    echo '<p>No questions found.</p>';
} else {
    echo '<h2>All Questions</h2>';
    echo '<ul>';
    foreach ($questions as $question) {
        echo '<li>' . $question->type . '</li>';
    }
    echo '</ul>';
}

// Print the page footer
echo $OUTPUT->footer();
