<?php

global $DB, $PAGE, $OUTPUT, $CFG, $USER;

require(__DIR__.'/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");

$id = required_param("id", PARAM_INT);// Course_module ID, or.
$studentId = required_param('studentid', PARAM_INT);
$pageid = optional_param('pageid',null,PARAM_INT);

//$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
//$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
//$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);
//
//require_login($course, true, $cm);
//$context = context_module::instance($cm->id);
$PAGE->set_url('/mod/interactivepdf/adminpages/attempt_students.php', array('id' => $id));
$PAGE->set_title("Interactive PDF - Attempt Students");
$PAGE->set_heading("Attempt Students");

echo $OUTPUT->header();

$sql = "SELECT ia.id,ia.attempt, ia.userid, u.firstname, u.lastname, ia.status
        FROM {interactivepdf_attempts} ia
        JOIN {user} u ON u.id = ia.userid
        WHERE ia.interactivepdfid = :interactivepdfid
        AND u.id = :studentid
        AND ia.status = 1";

$students = $DB->get_records_sql($sql, ['interactivepdfid' => $id, 'studentid' => $studentId]);
$page = $DB->get_record('interactivepdf_pages', ['interactivepdfid' => $id], '*', MUST_EXIST);
$pageid = $page->id;
$student = $DB->get_record('user', ['id' => $studentId]);

$display = (object)[
    'students' => array_values($students),
    'cmid' => $id,
    'pageid' => $pageid,
    'viewAttempt_url' => new moodle_url('/mod/interactivepdf/adminpages/attempt_show.php'),
];

foreach ($display->students as $student) {
    $student->status = ($student->status == 1) ? 'Finished' : 'Not Finished';
}

echo $OUTPUT->render_from_template('mod_interactivepdf/attempt_list', $display);

echo $OUTPUT->footer();
