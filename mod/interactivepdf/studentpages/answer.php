<?php

global $DB, $PAGE, $OUTPUT, $CFG, $USER;

require(__DIR__ . '/../../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");

$id = required_param("id", PARAM_INT);// Course_module ID, or.
$pageid = optional_param('pageid', null, PARAM_INT);
$attemptid = required_param('attemptid', PARAM_INT);

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$PAGE->set_url('/mod/interactivepdf/studentpages/answer.php', array('attemptid' => $attemptid, 'id' => $id));
$PAGE->set_title("Interactive PDF - Answer Attempt");
$PAGE->requires->css('/mod/interactivepdf/mod_interactivepdf.css');

$pages = $DB->get_records('interactivepdf_pages', ['interactivepdfid' => $id]);
$attempt_params = array('interactivepdfid' => $id, 'attempt' => $attemptid, 'userid' => $USER->id);
$attempt_sql = 'select feedback_submit,FROM_UNIXTIME(timestart) as timestart, FROM_UNIXTIME(timefinish) as timefinish, teacher_sign, teacher_name, student_sign, student_name, overall_feedback from {interactivepdf_attempts} where userid=:userid AND interactivepdfid =:interactivepdfid AND attempt =:attempt';
$attempt = $DB->get_record_sql($attempt_sql, $attempt_params);
//var_dump($attempt->teacher_name);
//die();

$attempt_feedback_submit = $attempt->feedback_submit ?? 0;

if ($attemptid->status == 0){
    $reattemp = true;
}
$feedback = '';

if ($attempt->feedback_submit == 1) {
    $sql = 'SELECT
    COUNT(CASE WHEN feedback = 1 THEN 1 END) AS feedback_1_count,
    COUNT(CASE WHEN feedback = 0 THEN 1 END) AS feedback_0_count
FROM
    {interactivepdf_feedback}
WHERE
    attemptid = ' . $attemptid . ' AND
    userid = ' . $USER->id;
    $feedback_record = $DB->get_record_sql($sql);


    $timestart = new DateTime($attempt->timestart);
    $timestart = $timestart->format('l, d F Y, g:i A');
    $timefinish = new DateTime($attempt->timefinish);
    $timefinish = $timefinish->format('l, d F Y, g:i A');

    $total = $feedback_record->feedback_1_count + $feedback_record->feedback_0_count;
    $percentage = ($feedback_record->feedback_1_count * 100) / $total;
    $feedback .= '<table class="generaltable generalbox quizreviewsummary">
                  <tbody>
                    <tr>
                      <th style="vertical-align: middle;" class="cell" scope="row">Started on</th>
                      <td class="cell">'.$timestart.'</td>
                    </tr>
                    <tr>
                      <th style="vertical-align: middle;" class="cell" scope="row">State</th>
                      <td class="cell">Finished</td>
                    </tr>
                    <tr>
                      <th style="vertical-align: middle;" class="cell" scope="row">Completed on</th>
                      <td class="cell">'.$timefinish.'</td>
                    </tr>
                    <tr>
                      <th style="vertical-align: middle;" class="cell" scope="row">Marks</th>
                      <td class="cell">' . number_format($feedback_record->feedback_1_count, 2) . '/' . number_format($total, 2) . '</td>
                    </tr>
                    <tr>
                      <th style="vertical-align: middle;" class="cell" scope="row">Grade</th>
                      <td class="cell"><b>' . number_format($feedback_record->feedback_1_count, 2) . '</b> out of ' . number_format($total, 2) . ' (<b>' . number_format($percentage, 2) . '</b>%)</td>
                    </tr>
                  </tbody>
                </table>';


}
echo $OUTPUT->header();

$sql = "SELECT * FROM {interactivepdf_contents} WHERE page_id = :page_id ORDER BY content_rank ASC";
$params = ['page_id' => $pageid];
$contents = $DB->get_records_sql($sql, $params);//var_dump($contents);

$answers = get_shortquestions_ans($USER->id, $id, null, 'shortques');

$attempt_feedback_submit = $attempt->feedback_submit ?? 0;

if ($attemptid->status == 0){
    $reattemp = true;
}


//if ($attempt->feedback_submit != 1) {
//    $html = '';
//    $html = '<div class="alert">
//  <span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span>
//  <strong>Attention!!</strong> please wait for teachers approval
//</div>';
//}
if ($attempt->feedback_submit != 1) {
    $html = '';
    $html .= '<div class="alert alert-warning fade show" role="alert">';
    $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    $html .= '<span aria-hidden="true">&times;</span>';
    $html .= '</button>';
    $html .= '<strong>Attention!</strong> Please wait for teacher\'s approval.';
    $html .= '</div>';
}

    $html .= $feedback;
    $count = 0;
    foreach ($contents as $content) {
        if ($content->type == 'html') {
            $html .= interactivepdf_load_html_content($content, $context);
        }
        if ($content->type == 'shortques') {
            $count++;

            $html .= '<div class="mt-3" style="background: #8cae47; padding: 10px;color: #fff; font-weight: bold;">';
            $html .= 'Question ' . $count;
            $html .= '</div>';
            $quesValue = [];
            $quesValue = $DB->get_record('interactivepdf_quizzes', ['content_id' => $content->id]);
            $html .= '<div class="mb-3" style="margin-bottom: 10px">';
            $html .= '<div for="question" style="background-color: #dcebd4; padding: 10px 30px; clolor:#000;">' . $quesValue->question . '</div>';
            $html .= '</div>';
            $subquestions = $DB->get_records('interactivepdf_subquestions', ['quiz_id' => $quesValue->id]);

            if (!empty($subquestions)) {
                $html .= '<div>';
                foreach ($subquestions as $subquestion) {
                    if ($subquestion->type == 'shortques') {
                        $html .= interactivepdf_load_shortquestion_content($id,$subquestion,$USER->id,$attemptid, 'shortques','disabled','', $attempt_feedback_submit,$reattemp);
                    } elseif ($subquestion->type == '3n') {
                        $html .= interactivepdf_load_3n_table_content($id, $subquestion, $USER->id,$attemptid,'disabled','',$attempt_feedback_submit,$reattemp);
                    } elseif ($subquestion->type == '2nm') {
//                        $html .= '<label for="subquestion-' . $subquestion->id . '">' . $subquestion->question_text . '</label>';
                        $html .= interactivepdf_load_2nm_table_content($id, $subquestion,$USER->id,$attemptid,'disabled','',$attempt_feedback_submit,$reattemp);
                    }
                    elseif ($subquestion->type == '2ns') {
//                        $html .= '<label for="subquestion-' . $subquestion->id . '">' . $subquestion->question_text . '</label>';
                        $html .= interactivepdf_load_2ns_table_content($id, $subquestion,$USER->id,$attemptid,'disabled','',$attempt_feedback_submit,$reattemp);
                    }

                }
                $html .= '</div>';
            }
        }
    }
    if($attempt->overall_feedback != 0) {
        $html .= '<div class="">';
        $html .= '<h4 class="text-white bg-dark text-center py-2">Overall Feedback</h4>';
        $html .= '<textarea disabled class="form-control">' . $attempt->overall_feedback . '</textarea>';
        $html .= '</div>';
    }

    $html .= '<div class="py-2 row">';

    $html .= '<div class="col-md-6">';
    $html .= '<h6>Student\'s Name:</h6>';
    $html .= '<p>'.$attempt->student_name.'</p>';
    $html .= '<h6>Student\'s Signature:</h6>';
    if (!empty($attempt->student_sign)) {
        $html .= '<img src="' . $attempt->student_sign . '" alt="Student Signature" style="width: 200px; height: 100px">';
    } else {
        $html .= 'Student Signature: N/A';
    }
    $html .= '</div>';
    $html .= '<div class="col-md-6 text-right">';
    $html .= '<h6>Teahcer\'s Name:</h6>';
//    $html .= '<p>'.!empty($attempt->teacher_name) ? $attempt->teacher_name: 'h'.'</p>';
    if (!empty($attempt->teacher_name)) {
        $html .= '<p>'.$attempt->teacher_name.'</p>';
    } else {
        $html .= 'N/A';
    }
    $html .= '<h6>Teahcer\'s Signature:</h6>';
    if (!empty($attempt->teacher_sign)) {
        $html .= '<img src="' . $attempt->teacher_sign . '" alt="Teacher Signature" style="width: 200px; height: 100px">';
    } else {
        $html .= 'N/A';
    }
    $html .= '</div>';
    $html .= '</div>';

    $html .= '</div>';
//else{
//    $html = '';
//    $html .= $feedback;
//    $count = 0;
//    foreach ($contents as $content) {
//        if ($content->type == 'html') {
//            $htmlValue = [];
//            $htmlValue = $DB->get_record('interactivepdf_htmls', ['content_id' => $content->id]);
//            $content = interactivepdf_prepear_html_data_for_view($htmlValue, $context);
//            $html .= '<div style="margin-bottom: 10px">';
//            $html .= $htmlValue->html;
//            $html .= '</div>';
//        }
//        if ($content->type == 'shortques') {
//            $count++;
//            $html .= '<div class="mt-3" style="background: #8cae47; padding: 10px;color: #fff; font-weight: bold;">';
//            $html .= 'Question ' . $count;
//            $html .= '</div>';
//            $quesValue = [];
//            $quesValue = $DB->get_record('interactivepdf_quizzes', ['content_id' => $content->id]);
//            $html .= '<div class="mb-3" style="margin-bottom: 10px">';
//            $html .= '<label class="w-100" for="question" style="background-color: #DDECD4; padding: 10px 30px;">' . $quesValue->question . '</label>';
//            $html .= '</div>';
//
//
//            $subquestions = $DB->get_records('interactivepdf_subquestions', ['quiz_id' => $quesValue->id]);
//
//
//            if (!empty($subquestions)) {
//                $html .= '<div>';
//                foreach ($subquestions as $subquestion) {
////                $html .= '<div id="form-' . $subquestion->id . '" data-type="shortques" data-id = "' . $subquestion->id . '">';
////                $html .= '<div class="mb-3" style="background-color: #F2F2F2;">';
//                    $html .= '<label style="padding: 8px 30px;" for="subquestion-' . $subquestion->id . '">' . $subquestion->question_text . '</label>';
////                $html .= '<textarea disabled style="border-radius: 0;" class="form-control" name="shortques-' . $subquestion->id . '">' . ($answers[$subquestion->id]->answer ?? '') . '</textarea>';
////                $html .= '</div>';
////                $html .= '</div>';
//
//                    $subquestionid = $subquestion->id;
//                    for ($x = 1; $x <= $attemptid; $x++) {
//                        $filteredArray = array_filter($answers, function ($item) use ($subquestionid, $attemptid, $x) {
//                            return $item->quiz_id === $subquestionid && $item->attemptid == $x;
//                        });
//
//                        $singleItem = reset($filteredArray);
//                        if ($singleItem !== false) {
//                            if ($singleItem->feedback == 1) {
//                                $html .= '<div style="background: #A8FF60; color: #000;">';
//                                $html .= '<br><label style="padding: 8px 30px;">' . 'Answer Attempt - ' . $singleItem->attemptid . '</label>';
//                                $html .= '<br><label style="padding: 8px 30px;">' . 'Answer Attempt - ' . $singleItem->answer . '</label>';
//                                $html .= '</div>';
//                                break;
//                            } else {
//                                if ($singleItem->feedback == 0) {
//                                    if ($x == $attempt->attempt) {
//                                        $html .= '<div id="shortques-' . $subquestion->id . '" data-type="shortques" data-id = "' . $subquestion->id . '">';
//                                        $html .= '<div class="mb-1 mt-3" style="background-color: #F2F2F2;">';
//                                        $html .= '<textarea style="border-radius: 0;" class="form-control" name="shortques-' . $subquestion->id . '">' . ($singleItem->answer ?? '') . '</textarea>';
//                                        $html .= '</div>';
//                                        $html .= '<button type="button" class="question-submit-btn btn btn-primary">Save</button>';
//                                        $html .= '</div>';
//                                    } else {
//                                        $html .= '<div style="background: red; color: #000;">';
//                                        $html .= '<br><label style="padding: 8px 30px;">' . 'Answer Attempt - ' . $singleItem->attemptid . '</label>';
//                                        $html .= '<br><label style="padding: 8px 30px;">' . 'Answer Attempt - ' . $singleItem->answer . '</label>';
//                                        $html .= '</div>';
//                                    }
//
//                                } else {
//                                    $html .= '<div id="shortques-' . $subquestion->id . '" data-type="shortques" data-id = "' . $subquestion->id . '">';
//                                    $html .= '<div class="mb-1 mt-3" style="background-color: #F2F2F2;">';
//                                    $html .= '<textarea style="border-radius: 0;" class="form-control" name="shortques-' . $subquestion->id . '">' . ($singleItem->answer ?? '') . '</textarea>';
//                                    $html .= '</div>';
//                                    $html .= '<button type="button" class="question-submit-btn btn btn-primary">Save</button>';
//                                    $html .= '</div>';
//                                }
//
//                            }
//                        } else {
//                            if ($x == $attempt->attempt) {
//                                $html .= '<div id="shortques-' . $subquestion->id . '" data-type="shortques" data-id = "' . $subquestion->id . '">';
//                                $html .= '<div class="mb-1 mt-3" style="background-color: #F2F2F2;">';
//                                $html .= '<textarea style="border-radius: 0;" class="form-control" name="shortques-' . $subquestion->id . '">' . ($singleItem->answer ?? '') . '</textarea>';
//                                $html .= '</div>';
//                                $html .= '<button type="button" class="question-submit-btn btn btn-primary">Save</button>';
//                                $html .= '</div>';
//                            }
//                        }
//                    }
//                }
//                $html .= '</div>';
//            }
//        }
//    }
//}

echo $html;
echo $OUTPUT->footer();




