<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Version details of mod_interactivepdf.
 *
 * @package    mod_interactivepdf
 * @copyright  2023 @Md. Faisal Abid
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $DB, $PAGE, $OUTPUT, $CFG, $USER;
require('../../config.php');
require_once("$CFG->dirroot/mod/interactivepdf/lib.php");

$id = required_param("id", PARAM_INT);// Course_module ID, or.
$pageid = optional_param('pageid', null, PARAM_INT);

$cm = get_coursemodule_from_id('interactivepdf', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('interactivepdf', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$PAGE->set_url('/mod/interactivepdf/view.php', array('id' => $cm->id));
$PAGE->set_title("Interactive PDF");
$PAGE->set_heading("Interactive PDF");
$PAGE->requires->css('/mod/interactivepdf/mod_interactivepdf_style.css');


$pages = $DB->get_records('interactivepdf_pages', ['interactivepdfid' => $id]);
$hasCapabilityEditTest = has_capability('mod/interactivepdf:edittest', $context);
//$hasCapabilityAttemptTest = has_capability('mod/interactivepdf:attemttest', $context);

//$pageUrls = array();
if ($hasCapabilityEditTest) {
    echo $OUTPUT->header();
    $attemptsId = $DB->get_field('interactivepdf_attempts', 'id', ['interactivepdfid' => $id]);
    $display = (object)[
        'addPage' => 'Add Page',
        'id' => $id,
        'pageid' => $pageid,
        'pages' => array_values($pages),
        'addPage_url' => new moodle_url('/mod/interactivepdf/adminpages/add_page.php'),
        'attemptsPage_url' => new moodle_url('/mod/interactivepdf/adminpages/attempt_students.php'),
    ];

    foreach ($display->pages as $page) {
        $pageid = $page->id;
        $params = array('id' => $id, 'pageid' => $pageid);
        $url = new moodle_url('/mod/interactivepdf/adminpages/view_page.php', $params);
        $page->page_url = $url->out(false); // Set the page_url without encoding special characters
    }
    echo $OUTPUT->render_from_template('mod_interactivepdf/view', $display);

} else {
    $attemptid = interactivepdf_populate_data_in_usr_progress_track_table($id, $context);
//var_dump($attemptid);

    $display = (object)[
        'addPage' => 'Add Page',
        'id' => $id,
        'pages' => array_values($pages),
    ];

    if (empty($attemptid)) {
        $attempt = interactivepdf_create_new_attempt(0, $id);
        $attemptid = new stdClass();
        $attemptid->attempt = $attempt;
        $attemptid->status = 0;
//        var_dump($attemptid);
    }
    $attempt_feedback_submit = $attemptid->feedback_submit ?? 0;

    if ($attemptid->status == 0) {
        $reattemp = true;
    }

    $firstPage = (!empty($pageid) ? $pageid : ($display->pages[0]->id ?? []));

    if ($attemptid->status == 0 || (empty($attemptid) && $attemptid->feedback_submit != 0)) {
        echo $OUTPUT->header();
        if (empty($attemptid)) {
            $attempt = interactivepdf_create_new_attempt(0, $id);
        }
        $sql = "SELECT * FROM {interactivepdf_contents} WHERE page_id = :page_id ORDER BY content_rank ASC";
        $params = ['page_id' => $firstPage];
        $contents = $DB->get_records_sql($sql, $params);

        $html = '';
        $html = '<form id="mainform">';
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
                            $html .= interactivepdf_load_shortquestion_content($id, $subquestion, $USER->id, $attemptid->attempt, 'shortques', '', '', $attempt_feedback_submit, $reattemp);
                        } elseif ($subquestion->type == '3n') {
                            $html .= interactivepdf_load_3n_table_content($id, $subquestion, $USER->id, $attemptid->attempt, '', '', $attempt_feedback_submit, $reattemp);
                        } elseif ($subquestion->type == '2nm') {
//                            $html .= '<label for="subquestion-' . $subquestion->id . '">' . $subquestion->question_text . '</label>';
                            $html .= interactivepdf_load_2nm_table_content($id, $subquestion, $USER->id, $attemptid->attempt, '', '', $attempt_feedback_submit, $reattemp);
                        } elseif ($subquestion->type == '2ns') {
//                            $html .= '<label for="subquestion-' . $subquestion->id . '">' . $subquestion->question_text . '</label>';
                            $html .= interactivepdf_load_2ns_table_content($id, $subquestion, $USER->id, $attemptid->attempt, '', '', $attempt_feedback_submit, $reattemp);
                        }

                    }
                    $html .= '</div>';
                }
            }
        }

        if ($attemptid->student_sign) {
            $html .= 'Your Name:  '. $attemptid->student_name;
            $html .= 'Your Signature:';
            $html .= '<img src="' . $attemptid->student_sign . '" alt="Signature">';
            $html .= '<div class="text-center"><button type="button" id="attempt-submit-btn" class="btn btn-primary">Finish Attempt</button></div>';

        } else {
            $html .= load_signeture($id, $USER->id, $attemptid->attempt, 'student');
        }
//        $html .= '<button type="button" id="attempt-submit-btn" class="d-none btn btn-primary  mt-5 text-center">Finish Attempt</button>';
        $html .= '<div class="text-center mt-2"><button type="button" id="attempt-submit-btn" class="btn btn-primary">Finish Attempt</button></div>';
        $html .= '</form>';
        $display->content = $html;
        foreach ($display->pages as $page) {
            $pageid = $page->id;
            $params = array('id' => $id, 'pageid' => $pageid);
            $url = new moodle_url('/mod/interactivepdf/view.php', $params);
            $page->page_url = $url->out(false);
        }
        echo $OUTPUT->render_from_template('mod_interactivepdf/student', $display);
    } else {
        echo $OUTPUT->header();
        $url = new moodle_url('/mod/interactivepdf/startattempt.php');
        $attempts = $DB->get_records('interactivepdf_attempts', ['interactivepdfid' => $id, 'userid' => $USER->id]);
        $enabled = 0;
        if ($attemptid->feedback_submit && ($attemptid->attempt < 3 )){
            $enabled = 1;
        }

        if ($attemptid->attempt == 3){
            $attempt_text = 'You reached your maximum attempt limit';
        }
        else{
            $attempt_text = 'You can\'t reattempt Now please wait for teacher\'s feedback';
        }
        $display = (object)[
            'formurl' => $url,
            'prev_attempt' => $attemptid->attempt,
            'cmid' => $id,
            'pageid' => $firstPage,
            'attempts' => array_values($attempts),
            'enable' => $enabled,
            'attempt_text' => $attempt_text,
            'viewAttempt_url' => new moodle_url('/mod/interactivepdf/studentpages/answer.php'),
        ];
        echo $OUTPUT->render_from_template('mod_interactivepdf/reattempt', $display);

    }

    $PAGE->requires->js_call_amd('mod_interactivepdf/validation', 'init', [
        'userid' => $USER->id,
        'interactivepdfid' => $id,
        'attemptid' => $attemptid->attempt ?? 1,
    ]);

}
echo $OUTPUT->footer();
