<?php

require_once(__DIR__ . '/../../config.php');

global $USER,$PAGE,$CFG, $DB;
require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');

$sign = $_POST['signatureData'];
$username = $_POST['username'];
$userid = $_POST['userid'];
$interactivepdfid = $_POST['interactivepdfid'];
$type = $_POST['type'];
$attempt = $_POST['attempt'];
//$overall_feedback = $_POST['overall_feedback'];

$overall_feedback = optional_param('overall_feedback', 0, PARAM_TEXT);
$attempt = $DB->get_record('interactivepdf_attempts',['interactivepdfid'=>intval($interactivepdfid),'userid'=>intval($userid),'attempt'=>intval($attempt)]);

if ($type == 'student') {
    if (!$overall_feedback) {
        $attempt->overall_feedback = 0;
    }
    $attempt->student_sign = $sign;
    $attempt->student_name = $username;
}
else{
    $attempt->teacher_sign = $sign;
    $attempt->teacher_name = $username;
    $attempt->overall_feedback = $overall_feedback;
}

$res = $DB->update_record('interactivepdf_attempts', $attempt);
//var_dump($res); die;
if ($res){
    echo 'success';
}