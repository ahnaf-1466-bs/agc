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
 * Interactive PDF module configuration form.
 *
 * @package    mod_interactivepdf
 * @copyright  2023 @Md. Faisal Abid
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**#@+
 * Option controlling what options are offered on the quiz settings form.
 */
define('INTERACTIVEPDF_MAX_ATTEMPT_OPTION', 10);
define('INTERACTIVEPDF_MAX_QPP_OPTION', 50);
define('INTERACTIVEPDF_MAX_DECIMAL_OPTION', 5);
define('INTERACTIVEPDF_MAX_Q_DECIMAL_OPTION', 7);


define('INTERACTIVEPDF_GRADEHIGHEST', '1');
define('INTERACTIVEPDF_GRADEAVERAGE', '2');
define('INTERACTIVEPDF_ATTEMPTFIRST', '3');
define('INTERACTIVEPDF_ATTEMPTLAST', '4');
function interactivepdf_add_instance(stdClass $data, mod_interactivepdf_mod_form $mform = null): int
{
    global $DB;

    $data->timecreated = time();
    $data->timemodified = $data->timecreated;
    $data->id = $DB->insert_record('interactivepdf', $data);

    interactivepdf_grade_item_update($data);
    return $data->id;
}

function interactivepdf_update_instance(stdClass $data, mod_interactivepdf_mod_form $mform = null): int
{
    global $DB;
    $cmid = required_param('update', PARAM_INT);

    $module = $DB->get_record('modules', ['name' => 'interactivepdf']);
    $instance = $DB->get_record('course_modules', ['module' => $module->id, 'id' => $cmid]);
    $instanceid = $instance->instance;

    $updating_table = new stdClass();
    $updating_table->id = $instanceid;
    $updating_table->name = $data->name;
    $updating_table->intro = $data->intro;
    $updating_table->introformat = $data->introformat;
    $updating_table->attempts = $data->attempts;
    $updating_table->grademethod = $data->grademethod;
    $updating_table->grade = $data->grade;
    $updating_table->timecreated = time();
    $updating_table->timemodified = time();
    $updating_table->id = $DB->update_record('interactivepdf', $updating_table);

    interactivepdf_grade_item_update($data);

    return $updating_table->id;
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id the id of the quiz to delete.
 * @return bool success or failure.
 */
function interactivepdf_delete_instance($id)
{
    global $DB;

    $cmid = required_param('id', PARAM_INT);

    $module = $DB->get_record('modules', ['name' => 'interactivepdf']);
    $instance = $DB->get_record('course_modules', ['module' => $module->id, 'id' => $cmid]);
    $instanceid = $instance->instance;

// We need to do the following deletes before we try and delete randoms, otherwise they would still be 'in use'.
    $DB->delete_records('interactivepdf_3n_qanswers', ['interactivepdfid' => $id]);
    $DB->delete_records('interactivepdf_3n_questions', ['interactivepdfid' => $id]);
    $DB->delete_records('interactivepdf_3ns', ['interactivepdfid' => $id]);
    $DB->delete_records('interactivepdf_answers', ['interactivepdfid' => $id]);
    $DB->delete_records('interactivepdf_attempts', ['interactivepdfid' => $id]);
//    $DB->delete_records('interactivepdf_contents', ['interactivepdfid' => $id]);
//    $DB->delete_records('interactivepdf_htmls', ['interactivepdfid' => $id]);
//    $DB->delete_records('interactivepdf_options', ['interactivepdfid' => $id]);
//    $DB->delete_records('interactivepdf_quizzes', ['interactivepdfid' => $id]);
    $DB->delete_records('interactivepdf_pages', ['interactivepdfid' => $id]);
    $DB->delete_records('interactivepdf_subquestions', ['interactivepdfid' => $id]);

//    access_manager::delete_settings($interactivepdf);
//    quiz_grade_item_delete($quiz);
    // We must delete the module record after we delete the grade item.
    $DB->delete_records('interactivepdf', ['id' => $instanceid]);

    return true;
}

/**
 * This function extends the settings navigation block for the site.
 *
 * It is safe to rely on PAGE here as we will only ever be within the module
 * context when this is called
 *
 * @param settings_navigation $settings
 * @param navigation_node $interactivepdfnode
 */
function interactivepdf_extend_settings_navigation(settings_navigation $settings, navigation_node $interactivepdfnode)
{

    $keys = $interactivepdfnode->get_children_key_list();
    $beforekey = null;
    $i = array_search('modedit', $keys);
    if ($i === false and array_key_exists(0, $keys)) {
        $beforekey = $keys[0];
    } else if (array_key_exists($i + 1, $keys)) {
        $beforekey = $keys[$i + 1];
    }

//    if (has_capability('mod/interactivepdf:manageoverrides', $settings->get_page()->cm->context)) {
//        $url = new moodle_url('/mod/interactivepdf/overrides.php', ['cmid' => $settings->get_page()->cm->id, 'mode' => 'user']);
//        $node = navigation_node::create(get_string('overrides', 'interactivepdf'), $url,
//            navigation_node::TYPE_SETTING, null, 'mod_interactivepdf_useroverrides');
//        $interactivepdfnode->add_node($node, $beforekey);
//    }

    if ($pageid = optional_param('pageid', '', PARAM_INT) && has_capability('mod/interactivepdf:edit_content', $settings->get_page()->cm->context)) {
        $reportsnode = $interactivepdfnode->add(
            get_string('edit_page', 'interactivepdf'),
            new moodle_url('/mod/interactivepdf/adminpages/edit_page.php', ['id' => $settings->get_page()->cm->id,
                'pageid' => $pageid])
        );
    }
    if (!$pageid = optional_param('pageid', '', PARAM_INT) && has_capability('mod/interactivepdf:edit_content', $settings->get_page()->cm->context)) {
        $reportsnode = $interactivepdfnode->add(
            get_string('add_page', 'interactivepdf'),
            new moodle_url('/mod/interactivepdf/adminpages/add_page.php', ['id' => $settings->get_page()->cm->id,
                'action' => 'reportoverview'])
        );
    }
    if (has_capability('mod/interactivepdf:edit_content', $settings->get_page()->cm->context)) {
        $reportsnode = $interactivepdfnode->add(
            get_string('attempts', 'interactivepdf'),
            new moodle_url('/mod/interactivepdf/adminpages/attempt_students.php', ['id' => $settings->get_page()->cm->id,
                'action' => 'reportoverview'])
        );
    }
}

function interactivepdf_insert_content($data, $context, $pageid)
{
    global $DB;
    $content = new stdClass();
    $content->page_id = $pageid;
    $content->type = 'html';
    $content->timecreated = time();
    $content->timemodified = time();
    $contentid = $DB->insert_record('interactivepdf_contents', $content);

    $html = new stdClass();
    $html->content_id = $contentid;
    $html->html = "";
    $html->timecreated = time();
    $html->timemodified = time();

    $html->id = $DB->insert_record('interactivepdf_htmls', $html);

    if (!empty($data->html_editor)) {
        $html->html_editor = $data->html_editor;
        $html = file_postupdate_standard_editor($html, 'html', interactivepdf_editor_options(), $context, 'mod_interactivepdf', 'html_editor', $html->id);
    }

    $DB->update_record('interactivepdf_htmls', $html);
    return $html->id;

}

/**
 * interactivepdf_editor_options
 * return ediitor options
 *
 * @return array
 */
function interactivepdf_editor_options()
{
    return array("subdirs" => true, "maxfiles" => -1, "maxbytes" => 0);
}

/**
 * management_prepear_phase_data_for_view
 * Rwwrite plugin file url for view phase description in student view
 * @param mixed $data
 * @param mixed $context
 * @return void
 */
function interactivepdf_prepear_html_data_for_view($data, $context)
{
    $data->id = !empty($data->id) ? $data->id : $data->contentid;
    if (is_array($data)) {
        $data['html'] = file_rewrite_pluginfile_urls($data['html'], 'pluginfile.php', $context->id, 'mod_interactivepdf', 'html_editor', $data['id']);
        return $data;
    }
    $data->html = file_rewrite_pluginfile_urls($data->html, 'pluginfile.php', $context->id, 'mod_interactivepdf', 'html_editor', $data->id);

    return $data;
}

/**
 * Checks file access for multiple choice questions.
 *
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool
 * @package  qtype_bsmultichoice
 * @category files
 */
function mod_interactivepdf_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array())
{
    if (in_array($filearea, ["html_editor"])) {
        $itemid = $args[0];
        $filename = array_pop($args);
        $filepath = '/';
        $fs = get_file_storage();
        $file = $fs->get_file($context->id, 'mod_interactivepdf', $filearea, $itemid, $filepath, $filename);
        if (!$file) {
            return false;
        }
        send_stored_file($file, 0, 0, $forcedownload, $options);
    } else {
        return false;
    }
}

function interactivepdf_populate_data_in_usr_progress_track_table($id, $context)
{
    global $DB, $USER;
    $sql = 'select * from {interactivepdf_attempts} where userid = ' . $USER->id . ' and interactivepdfid = ' . $id . ' order by id DESC Limit 1';
    $current_progresses = $DB->get_record_sql($sql);
    return $current_progresses;
}

function interactivepdf_create_new_attempt($prev_attepmt, $id)
{
    global $USER, $DB;
    $prev_attepmt = $prev_attepmt ?? 0;

    $sql = 'select * from {interactivepdf_attempts} where userid = ' . $USER->id . ' and interactivepdfid = ' . $id . ' order by id DESC Limit 1';
    $current_progresses = $DB->get_record_sql($sql);
    if ($current_progresses->status == 1 || empty($current_progresses)) {

        $data = array(
            'attempt' => intval($current_progresses->attempt) + 1 ?? 1,
            'userid' => $USER->id,
            'interactivepdfid' => $id,
            'status' => 0,
            'timestart' => strtotime("now"),
        );
//        $sql = 'INSERT INTO {interactivepdf_attempts} (attempt,userid,interactivepdfid,status,timestart) VALUES(?,?,?,?,?)';
//        $current_progresses = $DB->execute($sql, $data);
        $temp = $DB->insert_record('interactivepdf_attempts', $data);

        $current_progresses = $data['attempt'];
        return $current_progresses;
    }

}

/**
 * management_get_phase_data
 *
 * @param int $html_id
 * @param bool $is_array
 * @return array|object
 */
function interactivepdf_get_html_data($html_id, $is_array = false)
{

    global $DB;
    $html = $DB->get_record("interactivepdf_htmls", ["id" => $html_id]);

    if ($is_array && $html)
        return (array)$html;
    return $html;
}

/**
 * interactivepdf_prepear_editor_content_for_db
 *
 * @param mixed $content
 * @param int $context_id
 * @param string $areaName
 * @param string $component
 * @param int $draftId
 * @param int $record_id
 * @return string
 */
function interactivepdf_prepear_editor_content_for_db($content, $context_id, $areaName, $component, $draftId, $record_id)
{
    $fileoptions = array("subdirs" => true, "maxfiles" => -1, "maxbytes" => 0);
    $currenttext = file_save_draft_area_files(
        $draftId,
        $context_id,
        $component,
        $areaName,
        (int)$record_id,
        $fileoptions,
        $content
    );
    $currenttext = file_rewrite_pluginfile_urls($currenttext, "pluginfile.php", $context_id, $component, $areaName, $record_id);
    return $currenttext;
}

function get_shortquestions_ans($userid, $interactivepdf, $attemptid, $quiz_type, $quiz_id = null)
{

    global $DB;

    if ($attemptid) {
        $sql = "SELECT * FROM {interactivepdf_answers} WHERE userid = :userid AND interactivepdfid = :interactivepdf AND attemptid = :attemptid AND quiz_type = :quiz_type AND quiz_id = :quiz_id";
        $params = array('userid' => $userid, 'interactivepdf' => $interactivepdf, 'attemptid' => $attemptid, 'quiz_type' => $quiz_type, 'quiz_id' => $quiz_id);

        $record = $DB->get_record_sql($sql, $params);
        if ($record) {
            return $record;
        }
    } else {
        $sql = "SELECT * FROM {interactivepdf_answers} WHERE userid = :userid AND interactivepdfid = :interactivepdf AND quiz_type = :quiz_type";
        $params = array('userid' => $userid, 'interactivepdf' => $interactivepdf, 'quiz_type' => $quiz_type);

        $records = $DB->get_records_sql($sql, $params);
        if ($records) {
            return $records;
        }
    }

}


function store_3n_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type, $ansid, $quiz_3nid)
{

    global $DB;
    $sql = "SELECT * FROM {interactivepdf_3n_qanswers} WHERE userid = :userid AND interactivepdfid = :interactivepdfid AND subquestionid = :quiz_id AND nquestionid =:nquestionid  AND attemptid = :attemptid AND quiz_type LIKE :quiz_type ";
    $record = $DB->get_record_sql($sql, ['userid' => $userid, 'interactivepdfid' => $interactivepdf, 'quiz_id' => $quiz_id, 'nquestionid' => $quiz_3nid, 'attemptid' => $attemptid, 'quiz_type' => $quiz_type]);
    if ($record) {
        if ($ansid == 'ans1') {
            $record->answer1 = $answer;
        }
        if ($ansid == 'ans2') {
            $record->answer2 = $answer;
        }
        $record->timemodified = time();

        $record->id = $DB->update_record('interactivepdf_3n_qanswers', $record);
        return $record->id;
    } else {
        $record = new stdClass();
        $record->userid = $userid;
        $record->interactivepdfid = $interactivepdf;
        $record->subquestionid = $quiz_id;
        $record->nquestionid = $quiz_3nid;
        $record->attemptid = $attemptid;
        if ($ansid == 'ans1') {
            $record->answer1 = $answer;
        }
        if ($ansid == 'ans2') {
            $record->answer2 = $answer;
        }
        $record->quiz_type = $quiz_type;
        $record->timemodified = time();
        $record->id = $DB->insert_record('interactivepdf_3n_qanswers', $record);

        return $record->id;
    }
}

function store_2nm_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type, $ansid, $quiz_3nid)
{
    global $DB;
    $sql = "SELECT * FROM {interactivepdf_2n_mqanswers} WHERE userid = :userid AND interactivepdfid = :interactivepdfid AND subquestionid = :quiz_id AND mnquestionid =:nquestionid  AND attemptid = :attemptid AND quiz_type LIKE :quiz_type ";
    $record = $DB->get_record_sql($sql, ['userid' => $userid, 'interactivepdfid' => $interactivepdf, 'quiz_id' => $quiz_id, 'nquestionid' => $quiz_3nid, 'attemptid' => $attemptid, 'quiz_type' => $quiz_type]);
    if ($record) {
        if ($ansid == 'ans1') {
            $record->answer1 = $answer;
        }
        if ($ansid == 'ans2') {
            $record->answer2 = $answer;
        }
        $record->timemodified = time();

        $record->id = $DB->update_record('interactivepdf_2n_mqanswers', $record);
        return $record->id;
    } else {

        $record = new stdClass();
        $record->userid = $userid;
        $record->interactivepdfid = $interactivepdf;
        $record->subquestionid = $quiz_id;
        $record->mnquestionid = $quiz_3nid;
        $record->attemptid = $attemptid;
        if ($ansid == 'ans1') {
            $record->answer1 = $answer;
        }
        if ($ansid == 'ans2') {
            $record->answer2 = $answer;
        }
        $record->quiz_type = $quiz_type;
        $record->timemodified = time();
        $record->id = $DB->insert_record('interactivepdf_2n_mqanswers', $record);
        return $record->id;
    }
}

function store_2ns_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type, $ansid, $quiz_3nid)
{
    global $DB;
    $sql = "SELECT * FROM {interactivepdf_2n_sqanswers} WHERE userid = :userid AND interactivepdfid = :interactivepdfid AND subquestionid = :quiz_id AND snquestionid =:snquestionid  AND attemptid = :attemptid AND quiz_type LIKE :quiz_type ";
    $record = $DB->get_record_sql($sql, ['userid' => $userid, 'interactivepdfid' => $interactivepdf, 'quiz_id' => $quiz_id, 'snquestionid' => $quiz_3nid, 'attemptid' => $attemptid, 'quiz_type' => $quiz_type]);

    if ($record) {
        if ($ansid == 'ans1') {
            $record->answer = $answer;
        }
        $record->timemodified = time();

        $record->id = $DB->update_record('interactivepdf_2n_sqanswers', $record);
        return $record->id;
    } else {
        $record = new stdClass();
        $record->userid = $userid;
        $record->interactivepdfid = $interactivepdf;
        $record->subquestionid = $quiz_id;
        $record->snquestionid = $quiz_3nid;
        $record->attemptid = $attemptid;
        if ($ansid == 'ans1') {
            $record->answer = $answer;
        }
        $record->quiz_type = $quiz_type;
        $record->timemodified = time();
        $record->id = $DB->insert_record('interactivepdf_2n_sqanswers', $record);

        return $record->id;
    }
}

function store_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type)
{
    global $DB;
    $sql = "SELECT * FROM {interactivepdf_answers} WHERE userid = :userid AND interactivepdfid = :interactivepdfid AND quiz_id = :quiz_id AND attemptid = :attemptid AND quiz_type LIKE :quiz_type ";
    $record = $DB->get_record_sql($sql, ['userid' => $userid, 'interactivepdfid' => $interactivepdf, 'quiz_id' => $quiz_id, 'attemptid' => $attemptid, 'quiz_type' => $quiz_type]);

    if ($record) {
        $record->answer = $answer;
        $record->timemodified = time();
        $record->id = $DB->update_record('interactivepdf_answers', $record);
        return $record->id;
    } else {
        $record = new stdClass();
        $record->userid = $userid;
        $record->interactivepdfid = $interactivepdf;
        $record->quiz_id = $quiz_id;
        $record->attemptid = $attemptid;
        $record->answer = $answer;
        $record->quiz_type = $quiz_type;
        $record->timemodified = time();
        $record->id = $DB->insert_record('interactivepdf_answers', $record);

        return $record->id;
    }
}

function interactivepdf_store_feedback($interactivepdf, $userid, $attemptid, $subquestionid, $feedback, $feedbackcomment)
{
    global $DB;

    $sql = "SELECT * FROM {interactivepdf_feedback} WHERE userid = :userid AND interactivepdfid = :interactivepdfid AND subquestionid = :subquestionid AND attemptid = :attemptid";
    $record = $DB->get_record_sql($sql, ['userid' => $userid, 'interactivepdfid' => $interactivepdf, 'subquestionid' => $subquestionid, 'attemptid' => $attemptid]);

    if ($record) {
        $record->feedback = intval($feedback);
        $record->feedbackcomment = $feedbackcomment;
        $record->timemodified = time();
        $record->id = $DB->update_record('interactivepdf_feedback', $record);
        return $record->id;
    } else {
        $record = new stdClass();
        $record->userid = $userid;
        $record->interactivepdfid = $interactivepdf;
        $record->subquestionid = $subquestionid;
        $record->attemptid = $attemptid;
        $record->feedback = $feedback;
        $record->feedbackcomment = $feedbackcomment;
        $record->timemodified = time();
        $record->timecreated = time();
        $record->id = $DB->insert_record('interactivepdf_feedback', $record);
        return $record->id;
    }

}

function interactivepdf_load_html_content($content, $context)
{
    global $DB;
    $html = '';
    $htmlValue = [];
    $htmlValue = $DB->get_record('interactivepdf_htmls', ['content_id' => $content->id]);
    $content = interactivepdf_prepear_html_data_for_view($htmlValue, $context);
    $html .= '<div style="margin-bottom: 10px">';
    $html .= $htmlValue->html;
    $html .= '</div>';
    return $html;
}

function interactivepdf_load_3n_table_content($id, $subquestion, $userid, $attemptid, $disabled = null, $access = null, $attempt_feedback_submit = null, $reattemp = false)
{
    global $DB;
    $feedbacks = $DB->get_records('interactivepdf_feedback', ['subquestionid' => $subquestion->id, 'userid' => $userid]);
    $html = '';
    $html .= '<div class="mb-1 mt-3 color">';
    $html .= '<label style="padding: 8px 30px;" for="subquestion-' . $subquestion->id . '">' . $subquestion->question_text . '</label>';
    $html .= '</div>';

    $con = $DB->get_record('interactivepdf_3ns', ['interactivepdfid' => $id, 'subquestionid' => $subquestion->id]);

    $que = $DB->get_records('interactivepdf_3n_questions', ['interactivepdfid' => $id, 'nid' => $con->id]);

    $correct = 0;
    if ($feedbacks) {
        foreach ($feedbacks as $feedback) {
            if ($feedback->feedback == 1) {
                $correct = 1;
                $bg_color = '#0080007d';
                $html .= load_n3_table($que,$disabled,$con,$subquestion,$attemptid,$bg_color,$userid,$attempt_feedback_submit,$feedback->attemptid, $access, $feedback);

                $html .= '<br>';
                $html .= previous_feedback ($feedback);
                break;
            } else {
                $bg_color = '#ff000061';
                $html .= load_n3_table($que,$disabled,$con,$subquestion,$attemptid,$bg_color,$userid,$attempt_feedback_submit, $feedback->attemptid, $access, $feedback);

                $html .= '<br>';
                $html .= previous_feedback ($feedback);
            }
        }
    }


//    if ($reattemp && ($correct == 0)) {
    if ($reattemp && ($correct == 0) && $attemptid > count($feedbacks) ) {
        $html .= load_n3_table($que, $disabled, $con, $subquestion, $attemptid, '', $userid, $attempt_feedback_submit, null, $access, null);
    }
    $html .= feedback_form ($subquestion, $answers, $access) ;
    return $html;
}



function load_n3_table($que,$disabled,$con,$subquestion,$attemptid,$bg_color,$userid,$attempt_feedback_submit,$feedback_attemptid = null, $access = null, $feedback = null)
{
    global $DB;

    $att = empty($feedback_attemptid)  ? $attemptid: $feedback_attemptid;

    $html = '';
    $html .= '<table style="background: ' . $bg_color . '" class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="align-left" width="30%"></th>
                        <th class="align-left" width="35%">' . $con->header2 . '</th>
                        <th class="align-left" width="35%">' . $con->header3 . '</th>
                    </tr>
                    </thead>
                <tbody>';
    foreach ($que as $i) {
        $answers = $DB->get_records('interactivepdf_3n_qanswers', ['subquestionid' => $subquestion->id, 'nquestionid' => $i->id, 'userid' => $userid, 'attemptid' => $att]);
        $html .= '<tr class="">';
        $html .= '<td class="cell">' . $i->question_text . '</td>';
        $html .= '<td class="cell">';
        $html .= interactivepdf_3n_form($userid, $subquestion, $answers, $disabled, $i, $attemptid, 1, $attempt_feedback_submit, $att, $access);

        $html .= '</td>';
        $html .= '<td class="cell">';
        $html .= interactivepdf_3n_form($userid, $subquestion, $answers, $disabled, $i, $attemptid, 2, $attempt_feedback_submit, $att, $access);
        $html .= '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody>
                                        </table>';

    return $html;
}

function interactivepdf_3n_form($userid, $subquestion, $answers, $disabled, $i, $attemptid, $formid, $attempt_feedback_submit, $feedback_attemptid = null, $access = null)
{
    global  $DB;
    $html = '';
    $html .= '<div id="3nques' . $i->id . '-' . $subquestion->id . '-'.$formid.'" data-type="3nques" data-qid="' . $i->id . '" data-ansid = "ans'.$formid.'" data-id = "' . $subquestion->id . '">';

    if ($answers) {
        foreach ($answers as $ans) {
            if ($formid == 1){
                $stans = $ans->answer1;
                $rightans = $i->right_ans1;
            }
            else{
                $stans = $ans->answer2;
                $rightans = $i->right_ans2;
            }

            if ($ans->attemptid == $attemptid && !$attempt_feedback_submit) {
                $html .= '<textarea ' . $disabled . ' style="border-radius: 0;" class="w-100" name="3nques' . $i->id . '-' . $subquestion->id . '-' . $formid . '">' . ($stans ?? '') . '</textarea>';
            } else {
                $html .= '<p>Attempt : ' . $ans->attemptid . '</p>';
                $html .= '<p>User Answer : ' . $ans->answer1 . '</p>';
            }
        }
    } else {
        $html .= '<textarea ' . $disabled . ' style="border-radius: 0;" class="w-100" name="3nques' . $i->id . '-' . $subquestion->id . '-' . $formid . '"></textarea>';
    }

    $html .= !empty($access) ? '<p> <span class="font-weight-bolder correct"> Correct Ans: </span>' . $rightans . '</p>' : '';

    $html .= '</div>';

    return $html;
}

function interactivepdf_load_2nm_table_content($id, $subquestion, $userid, $attemptid, $disabled = null, $access = null,$attempt_feedback_submit = null, $reattemp = false)
{
    global $DB;

    $feedbacks = $DB->get_records('interactivepdf_feedback', ['subquestionid' => $subquestion->id, 'userid' => $userid]);
    $html = '';
    $html .= '<div class="mb-1 mt-3 color">';
    $html .= '<label style="padding: 8px 30px;" for="subquestion-' . $subquestion->id . '">' . $subquestion->question_text . '</label>';
    $html .= '</div>';

    $con = $DB->get_record('interactivepdf_2nms', ['interactivepdfid' => $id, 'subquestionid' => $subquestion->id]);
    $que = $DB->get_records('interactivepdf_2n_mquestions', ['interactivepdfid' => $id, 'nid' => intval($con->id)]);

    $correct = 0;

    if ($feedbacks) {
        foreach ($feedbacks as $feedback) {
            if ($feedback->feedback == 1) {
                $correct = 1;
                $bg_color = '#0080007d';
                $html .= load_2nm_table($que, $disabled, $con, $subquestion, $attemptid, $bg_color, $userid, $attempt_feedback_submit, $feedback->attemptid, $access, $feedback);
                $html .= previous_feedback ($feedback);
                break;
            } else {
                $bg_color = '#ff000061';
                $html .= load_2nm_table($que, $disabled, $con, $subquestion, $attemptid, $bg_color, $userid, $attempt_feedback_submit, $feedback->attemptid, $access, $feedback);
                $html .= previous_feedback ($feedback);
            }
        }
    }
    if ($reattemp && ($correct == 0) && $attemptid > count($feedbacks) ) {
        $html .= load_2nm_table($que, $disabled, $con, $subquestion, $attemptid, '', $userid, $attempt_feedback_submit,'', $access, $feedback);
    }
    $html .= feedback_form ($subquestion, $answers, $access) ;

    return $html;
}

function load_2nm_table($que, $disabled, $con, $subquestion, $attemptid, $bg_color, $userid, $attempt_feedback_submit, $feedback_attemptid=null, $access=null, $feedback = null){

    $att = empty($feedback_attemptid)  ? $attemptid: $feedback_attemptid;

    global $DB;
    $feedback_attemptid = intval($feedback_attemptid);
    $html = '';
    $html .= '<table  style="background: ' . $bg_color . '" class="table table-bordered">
                <thead>
                <tr>
                    <th class="align-left" width="50%">' . $con->header1 . '</th>
                    <th class="align-left" width="50%">' . $con->header2 . '</th>
                </tr>
                </thead>
                <tbody>';
    foreach ($que as $i) {

        $answers = $DB->get_records('interactivepdf_2n_mqanswers', ['subquestionid' => $subquestion->id, 'mnquestionid' => $i->id, 'userid' => $userid, 'attemptid' => $att]);

        $html .= '<tr class="">';
        $html .= '<td class="cell">';
        $html .= '<div id="2nm' . $i->id . '-' . $subquestion->id . '-1" data-type="2nm" data-qid="' . $i->id . '" data-ansid = "ans1" data-id = "' . $subquestion->id . '">';

        $html .= interactivepdf_2nm_form($subquestion, $answers, $disabled, $i, $attemptid, 1, $attempt_feedback_submit, $att, $access);
        $html .= '</div>';
        $html .= '</td>';

        $html .= '<td class="cell">';
        $html .= interactivepdf_2nm_form($subquestion, $answers, $disabled, $i, $attemptid, 2, $attempt_feedback_submit, $att, $access);
        $html .= '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody>
                                                </table>';

    return $html;
}

function feedback_form ($subquestion, $answers, $access) {
    $html = '';
    // Admin Feedback
    if (!empty($access)) {
        $html .= '<form id="feedback_form-' . $subquestion->id . '" method="post">';
        $html .= '<div>';

        $html .= '<div class="d-flex justify-content-between py-1 interactivepdf-feedback-design">';
        $html .= '<h6 class="ml-4 mt-2">Feedback</h6>';
        $html .= '<div class="mt-2 mr-4">';
        $html .= '<input class="redio-btn" data-quiztype="shortques" data-id="' . $subquestion->id . '" type="radio" id="subquestion-feedback-' . $subquestion->id . '" name="subquestion-feedback" value="1"><span class="ml-2">Satisfactory</span>&nbsp&nbsp';
        $html .= '<input class="redio-btn" data-quiztype="shortques" data-id="' . $subquestion->id . '" type="radio" id=""subquestion-feedback-' . $subquestion->id . '"" name="subquestion-feedback" value="0"><span class="ml-2">Not Satisfactory</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<textarea class="w-100" name="feedbackcomment"></textarea>';
        $html .= '</div>';
        $html .= '<input type="hidden" name="subquestionid" value="' . $subquestion->id . '" class="feedback-submit-btn btn btn-primary">';
        $html .= '<br>';
        $html .= '<input type="button" value="Save" class="feedback-submit-btn btn btn-primary" >';
        $html .= '</form>';
    }
    return $html;
}
function interactivepdf_2nm_form($subquestion, $answers, $disabled, $i, $attemptid, $formid, $attempt_feedback_submit, $feedback_attemptid = null , $access = null)
{

    $html = '';
    $html .= '<div id="2nm' . $i->id . '-' . $subquestion->id . '-'.$formid.'" data-type="2nm" data-qid="' . $i->id . '" data-ansid = "ans'.$formid.'" data-id = "' . $subquestion->id . '">';

    if ($answers) {
        foreach ($answers as $ans) {
            if ($formid == 1){
                $stans = $ans->answer1;
                $rightans = $i->right_ans1;
            }
            else{
                $stans = $ans->answer2;
                $rightans = $i->right_ans2;
            }
            if ($ans->attemptid == $attemptid && !$attempt_feedback_submit) {
                    $html .= '<textarea ' . $disabled . ' style="border-radius: 0;" class="w-100" name="2nm' . $i->id . '-' . $subquestion->id . '-'.$formid.'">' . ($stans ?? '') . '</textarea>';
            } else {
                $html .= '<p>Attempt : ' . $ans->attemptid . '</p>';
                $html .= '<p>User Answer : ' . $ans->answer1 . '</p>';
            }
        }
    } else {
            $html .= '<textarea ' . $disabled . ' style="border-radius: 0;" class="w-100" name="2nm' . $i->id . '-' . $subquestion->id . '-'.$formid.'"></textarea>';
    }

    $html .= !empty($access) ? '<p> <span class="font-weight-bolder correct"> Correct Ans: </span>' . $rightans . '</p>' : '';


    $html .= '</div>';
    return $html;
}

function interactivepdf_load_2ns_table_content($id, $subquestion, $userid, $attemptid, $disabled = null, $access = null,$attempt_feedback_submit = null, $reattemp = false)
{
    global $DB;

    $feedbacks = $DB->get_records('interactivepdf_feedback', ['subquestionid' => $subquestion->id, 'userid' => $userid]);

    $html = '';
    $html .= '<div class="mb-1 mt-3 color">';
    $html .= '<label style="padding: 8px 30px;" for="subquestion-' . $subquestion->id . '">' . $subquestion->question_text . '</label>';
    $html .= '</div>';

    $con = $DB->get_record('interactivepdf_2ns', ['interactivepdfid' => $id, 'subquestionid' => $subquestion->id]);

    $que = $DB->get_records('interactivepdf_2n_squestions', ['interactivepdfid' => $id, 'nid' => $con->id]);

    $correct = 0;

    if ($feedbacks) {
        foreach ($feedbacks as $feedback) {
            if ($feedback->feedback == 1) {
                $correct = 1;
                $bg_color = '#0080007d';
                $html .= load_2ns_table($que, $disabled, $con, $subquestion, $attemptid, $bg_color, $userid, $attempt_feedback_submit, $feedback->attemptid, $access, $feedback);
                $html .= previous_feedback ($feedback);

                break;
            } else {
                $bg_color = '#ff000061';
                $html .= load_2ns_table($que, $disabled, $con, $subquestion, $attemptid, $bg_color, $userid, $attempt_feedback_submit, $feedback->attemptid, $access, $feedback);
                $html .= previous_feedback ($feedback);
            }
        }
    }
    if ($reattemp && ($correct == 0) && $attemptid > count($feedbacks) ) {
        $html .= load_2ns_table($que, $disabled, $con, $subquestion, $attemptid, '', $userid, $attempt_feedback_submit,'', $access, $feedback);
    }
    $html .= feedback_form ($subquestion, $answers, $access) ;

    return $html;
}
function load_2ns_table($que, $disabled, $con, $subquestion, $attemptid, $bg_color, $userid, $attempt_feedback_submit, $feedback_attemptid=null, $access=null, $feedback = null){

    global $DB;
    $att = empty($feedback_attemptid)  ? $attemptid: $feedback_attemptid;
    $html = '';
    $html .= '<table style="background: ' . $bg_color . '" class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="align-left" width="35%">' . $con->header1 . '</th>
                                                <th class="align-left" width="35%">' . $con->header2 . '</th>
                                            </tr>
                                            </thead>
                                            <tbody>';
    foreach ($que as $i) {
        $answers = $DB->get_records('interactivepdf_2n_sqanswers', ['subquestionid' => $subquestion->id, 'snquestionid' => $i->id, 'userid' => $userid, 'attemptid' => $att]);

        $html .= '<tr class="">';
        $html .= '<td class="cell">';
        $html .= $i->question_text;
        $html .= '</td>';
        $html .= '<td class="cell">';

        $html .= interactivepdf_2ns_form($subquestion, $answers, $disabled, $i, $attemptid, 1, $attempt_feedback_submit, $att, $access);

        $html .= '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody>
                                        </table>';

    return $html;
}
function interactivepdf_2ns_form($subquestion, $answers, $disabled, $i, $attemptid, $formid, $attempt_feedback_submit, $feedback_attemptid = null, $access = null){

    $html = '';
    $html .= '<div id="2ns' . $i->id . '-' . $subquestion->id . '-1" data-type="2ns" data-qid="' . $i->id . '" data-ansid = "ans1" data-id = "' . $subquestion->id . '">';


    if ($answers) {
        foreach ($answers as $ans) {
            if ($ans->attemptid == $attemptid) {
                $html .= '<textarea ' . $disabled . ' style="border-radius: 0;" class="form-control" name="2ns' . $i->id . '-' . $subquestion->id . '-1">' . ($ans->answer ?? '') . '</textarea>';
            } else {
                $html .= '<p>Attempt : ' . $ans->attemptid . '</p>';
                $html .= '<p>Answer : ' . $ans->answer . '</p>';
            }
        }
    } else {
        $html .= '<textarea  ' . $disabled . '  style="border-radius: 0;" class="w-100" name="2ns' . $i->id . '-' . $subquestion->id . '-1"></textarea>';
    }
    $html .= !empty($access) ? '<p> <span class="font-weight-bolder correct"> Correct Ans: </span>' . $i->right_ans . '</p>' : '';

    $html .= '</div>';

    return $html;
}
function interactivepdf_load_shortquestion_content($id, $subquestion, $userid, $attemptid, $type, $disabled = null, $access = null, $attempt_feedback_submit = null, $reattemp = false)
{

    global $DB;
    $feedbacks = $DB->get_records('interactivepdf_feedback', ['subquestionid' => $subquestion->id, 'userid' => $userid]);

    $html = '';
    $html .= '<div id="shortques-' . $subquestion->id . '" data-type="shortques" data-id = "' . $subquestion->id . '">';
    $html .= '<div class="mb-1 mt-3" style="background-color: #F2F2F2;">';
    $html .= '<label style="padding: 8px 30px;" for="subquestion-' . $subquestion->id . '">' . $subquestion->question_text . '</label>';
    $html .= '</div>';

    $correct = 0;
    if ($feedbacks) // after feedback submit view from student amswers.php
    {
        foreach ($feedbacks as $feedback) {

            $answer = get_shortquestions_ans($userid, $id, $feedback->attemptid, $type, $subquestion->id);

            if ($feedback->feedback == 1) {
                $html .= '<div style="background:#0080007d; padding: 15px">';
                $html .= '<p>Attempt : ' . $feedback->attemptid . '</p>';
                $html .= '<p>Answer : ' . $answer->answer . '</p>';
                $html .= '</div>';
                $correct = 1;
                $html .= '<br>';
                $html .= previous_feedback ($feedback);
                break;
            } else {
                $html .= '<div style="background:#ff000061; padding: 15px">';
                $html .= '<p>Attempt : ' . $feedback->attemptid . '</p>';
                $html .= '<p>Answer : ' . $answer->answer . '</p>';
                $html .= '</div>';
                $html .= '<br>';
                $html .= previous_feedback ($feedback);
            }
        }
    }

    if ($reattemp && ($correct == 0) && $attemptid > count($feedbacks) ) {
        $answer = get_shortquestions_ans($userid, $id, $attemptid, $type, $subquestion->id);
        $html .= '<textarea ' . $disabled . '  style="border-radius: 0;" class="w-100" name="shortques-' . $subquestion->id . '">' . ($answer->answer ?? '') . '</textarea>';
    }

    $html .= !empty($access) ? '<p class="form-control"> <span class="font-weight-bolder correct"> Correct Ans: </span>' . $subquestion->correct_ans . '</p>' : '';
    $html .= empty($disabled) ? '<button type="button" class="question-submit-btn btn btn-primary">Save</button>' : '';
    $html .= '</div>';

    $html .= feedback_form ($subquestion, $answers, $access) ;

    return $html;
}

function interactivepdf_print_recent_mod_activity($activity, $courseid, $detail, $modnames)
{
    global $CFG, $OUTPUT;

    echo '<table border="0" cellpadding="3" cellspacing="0" class="forum-recent">';

    echo '<tr><td class="userpicture" valign="top">';
    echo $OUTPUT->user_picture($activity->user, ['courseid' => $courseid]);
    echo '</td><td>';

    if ($detail) {
        $modname = $modnames[$activity->type];
        echo '<div class="title">';
        echo $OUTPUT->image_icon('monologo', $modname, $activity->type);
        echo '<a href="' . $CFG->wwwroot . '/mod/interactivepdf/view.php?id=' .
            $activity->cmid . '">' . $activity->name . '</a>';
        echo '</div>';
    }

    echo '<div class="grade">';
    echo get_string('attempt', 'interactivepdf', $activity->content->attempt);
    if (isset($activity->content->maxgrade)) {
        $grades = $activity->content->sumgrades . ' / ' . $activity->content->maxgrade;
        echo ': (<a href="' . $CFG->wwwroot . '/mod/interactivepdf/review.php?attempt=' .
            $activity->content->attemptid . '">' . $grades . '</a>)';
    }
    echo '</div>';

    echo '<div class="user">';
    echo '<a href="' . $CFG->wwwroot . '/user/view.php?id=' . $activity->user->id .
        '&amp;course=' . $courseid . '">' . $activity->user->fullname .
        '</a> - ' . userdate($activity->timestamp);
    echo '</div>';

    echo '</td></tr></table>';

    return;
}


/**
 * Return grade for given user or all users.
 *
 * @param int $quizid id of quiz
 * @param int $userid optional user id, 0 means all users
 * @return array array of grades, false if none. These are raw grades. They should
 * be processed with quiz_format_grade for display.
 */
function interactivepdf_get_user_grades($interactivepdf, $userid = 0)
{
    global $CFG, $DB;

    // Add your custom grade item
    $item = new grade_item(array('itemtype' => 'mod', 'itemmodule' => 'pluginname', 'iteminstance' => 1, 'itemnumber' => 0));
    $item->set_source('mod_interactivepdf');
    $item->set_itemname('mod_interactivepdf');
    $items[] = $item;

    return $items;
}


/**
 * Return a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @param object $course
 * @param object $user
 * @param object $mod
 * @param object $interactivepdf
 * @return object
 * @global object
 */
function interactivepdf_user_outline($course, $user, $mod, $interactivepdf)
{
    global $CFG, $DB;

    require_once("$CFG->libdir/gradelib.php");
    $grades = grade_get_grades($course->id, 'mod', 'interactivepdf', 1, $user->id);
    $return = new stdClass();

    if (empty($grades->items[0]->grades)) {
        $return->info = get_string("nointeractivepdfattempts", "interactivepdf");
    } else {
        $grade = reset($grades->items[0]->grades);
        if (empty($grade->grade)) {

            // Check to see if it an ungraded / incomplete attempt.
            $sql = "SELECT *
                      FROM {interactivepdf_timer}
                     WHERE interactivepdfid = :interactivepdfid
                       AND userid = :userid
                  ORDER BY starttime DESC";
            $params = array('interactivepdfid' => 1, 'userid' => $user->id);

            if ($attempts = $DB->get_records_sql($sql, $params, 0, 1)) {
                $attempt = reset($attempts);
                if ($attempt->completed) {
                    $return->info = get_string("completed", "interactivepdf");
                } else {
                    $return->info = get_string("notyetcompleted", "interactivepdf");
                }
                $return->time = $attempt->interactivepdftime;
            } else {
                $return->info = get_string("nointeractivepdfattempts", "interactivepdf");
            }
        } else {
            if (!$grade->hidden || has_capability('moodle/grade:viewhidden', context_course::instance($course->id))) {
                $return->info = get_string('gradenoun') . ': ' . $grade->str_long_grade;
            } else {
                $return->info = get_string('gradenoun') . ': ' . get_string('hidden', 'grades');
            }

            $return->time = grade_get_date_for_user_grade($grade, $user);
        }
    }
    return $return;
}


/**
 * Update grades in central gradebook
 *
 * @param object $interactivepdf
 * @param int $userid specific user only, 0 means all
 * @param bool $nullifnone
 * @category grade
 */
function interactivepdf_update_grades($interactivepdf, $userid = 0, $nullifnone = true)
{
    global $CFG, $DB;
    require_once($CFG->libdir . '/gradelib.php');

    if ($interactivepdf->grade == 0 || $interactivepdf->practice) {
        interactivepdf_grade_item_update($interactivepdf);

    } else if ($grades = interactivepdf_get_user_grades($interactivepdf, $userid)) {
        interactivepdf_grade_item_update($interactivepdf, $grades);

    } else if ($userid and $nullifnone) {
        $grade = new stdClass();
        $grade->userid = $userid;
        $grade->rawgrade = null;
        interactivepdf_grade_item_update($interactivepdf, $grade);

    } else {
        interactivepdf_grade_item_update($interactivepdf);
    }
}


/**
 * Create grade item for given interactivepdfment.
 *
 * @param stdClass $interactivepdf record with extra cmidnumber
 * @param array $grades optional array/object of grade(s); 'reset' means reset grades in gradebook
 * @return int 0 if ok, error code otherwise
 */
function interactivepdf_grade_item_update($interactivepdf, $grades = null)
{
    global $CFG;
    require_once($CFG->libdir . '/gradelib.php');

//    if (!isset($interactivepdf->courseid)) {
//        $interactivepdf->courseid = $interactivepdf->course;
//    }

    $params = array('itemname' => $interactivepdf->name, 'idnumber' => $interactivepdf->cmidnumber);

    // Check if feedback plugin for gradebook is enabled, if yes then
    // gradetype = GRADE_TYPE_TEXT else GRADE_TYPE_NONE.
    $gradefeedbackenabled = false;

//    if (isset($interactivepdf->gradefeedbackenabled)) {
    $gradefeedbackenabled = $interactivepdf->gradefeedbackenabled;
//    } else if ($interactivepdf->grade == 0) { // Grade feedback is needed only when grade == 0.
//        require_once($CFG->dirroot . '/mod/interactivepdf/locallib.php');
//        $mod = get_coursemodule_from_instance('interactivepdf', $interactivepdf->id, $interactivepdf->courseid);
//        $cm = context_module::instance($mod->id);
//        $interactivepdfment = new interactivepdf($cm, null, null);
//        $gradefeedbackenabled = $interactivepdfment->is_gradebook_feedback_enabled();
//    }

    if ($interactivepdf->grade > 0) {
        $params['gradetype'] = GRADE_TYPE_VALUE;
        $params['grademax'] = $interactivepdf->grade;
        $params['grademin'] = 0;

    } else if ($interactivepdf->grade < 0) {
        $params['gradetype'] = GRADE_TYPE_SCALE;
        $params['scaleid'] = -$interactivepdf->grade;

    } else if ($gradefeedbackenabled) {
        // $interactivepdf->grade == 0 and feedback enabled.
        $params['gradetype'] = GRADE_TYPE_TEXT;
    } else {
        // $interactivepdf->grade == 0 and no feedback enabled.
        $params['gradetype'] = GRADE_TYPE_NONE;
    }

    if ($grades === 'reset') {
        $params['reset'] = true;
        $grades = null;
    }

    $params['grademax'] = 100;
    $params['grademin'] = 0;

    return grade_update('mod/interactivepdf',
        $interactivepdf->course,
        'mod',
        'interactivepdf',
        $interactivepdf->id,
        0,
        $grades,
        $params);
}


function load_signeture($id, $userid, $attemptid, $student){
    $html = '';
    $html .= '
 <p> Enter your Name: </p>
  <input type="text" id="student_name" name="student_name" alt = "' . $USER->firstname .'" /> <br> <br>
    <p> Your Signature:  </p>
    
<div class="d-flex flex-row">
       <div class="wrapper" style="border: 1px solid #4b00ff; border-right: 0;">
           <canvas id="signature-pad" style="background: #fff; width: 100%; height: 100%; cursor: crosshair;" width="400" height="200"></canvas>
       </div>
       <div class="clear-btn" style="display: block;">
           <button type="button" id="clear" style="height: 100%; background: #4b00ff; border: 1px solid transparent; color: #fff; font-weight: 600;cursor: pointer;"><span> Clear </span></button>
       </div>
       <div class="save-btn" style="display: block;">
           <button type="button" id="save" style="height: 100%; background: #2C420676; border: 1px solid transparent; color: #fff; font-weight: 600;cursor: pointer;"><span> Save </span></button>
       </div>
       
   </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js" integrity="sha512-kw/nRM/BMR2XGArXnOoxKOO5VBHLdITAW00aG8qK4zBzcLVZ4nzg7/oYCaoiwc8U9zrnsO9UHqpyljJ8+iqYiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
       var canvas = document.getElementById("signature-pad");

       function resizeCanvas() {
           var ratio = Math.max(window.devicePixelRatio || 1, 1);
           canvas.width = canvas.offsetWidth * ratio;
           canvas.height = canvas.offsetHeight * ratio;
           canvas.getContext("2d").scale(ratio, ratio);
       }
       window.onresize = resizeCanvas;
       resizeCanvas();

       var signaturePad = new SignaturePad(canvas, {
        backgroundColor: "rgb(250,250,250)"
       });

       document.getElementById("clear").addEventListener("click", function(event){
        event.preventDefault();
           signaturePad.clear();
       })
       
       document.getElementById("save").addEventListener("click", function(event){
            event.preventDefault();
            var student_name = $("#student_name").val();
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
            }
            else if (!student_name) {
                alert("Please provide your name.");
            }
            else {
                var signatureData = signaturePad.toDataURL();
                saveSignatureToDatabase(signatureData, student_name);
            }
        });

        function saveSignatureToDatabase(signatureData, student_name) {
            fetch("save_signature.php", { 
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "signatureData=" + encodeURIComponent(signatureData) + "&username=" + encodeURIComponent(student_name) +  "&userid=" + encodeURIComponent(' . $userid . ') + "&interactivepdfid=" + encodeURIComponent(' . $id . ')+ "&attempt=" + encodeURIComponent(' . $attemptid . ') + "&type=" + encodeURIComponent("'.$student.'") 
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(result) {
                if(result == "success"){
                    $("#attempt-submit-btn").removeClass("d-none")
                }
            })
            .catch(function(error) {
                console.error("Error:", error);
            });
        }
   </script>
   ';

return $html;
}

function previous_feedback ($feedback)
{
    $html = '';
    $html .= '<div>';
    $html .= '<textarea disabled class="form-control">Feedback: ' . $feedback->feedbackcomment . '</textarea>';
    $html .= '</div>';
    $html .= '<br>';

    return $html;
}