<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * External Library
 *
 * @package    local
 * @subpackage interactivepdf_services
 * @author     Brain Station 23
 * @copyright  2021 Brain Station 23 Limited
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/externallib.php');

/*
 *
 * @subpackage rating_helper
 */

class interactivepdf_services extends external_api
{
    /**
     * Parameter definition for method "interactivepdf_services save answer"
     *
     * @return {object} external_function_parameters
     */
    public static function save_question_answer_parameters()
    {
        return new external_function_parameters(
            array(
                'user_id' =>
                    new external_value(PARAM_INT, 'Id of the user who rated.'
                    ),
                'interactivepdfid' =>
                    new external_value(PARAM_INT, 'The Id of the course module to rate for.'
                    ),
                'quiz_id' =>
                    new external_value(PARAM_INT, 'The rate value.'
                    ),
                'answer' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'attemptid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),
                'quiz_type' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    )

            )
        );
    }

    /**
     * Save a rating for a course module.
     *
     * @param string $userid Id of the user who rated.
     * @param string $cmid The Id of the course module to rate for.
     * @param string $rating The rate value.
     * @param string $comment The rate value.
     * @return array
     * @throws {moodle_exception}
     */
    public static function save_question_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type)
    {
        global $DB, $CFG;

        // Parameter validation.
        $params = self::validate_parameters(
            self::save_question_answer_parameters(),
            array(
                'interactivepdfid' => $interactivepdf,
                'user_id' => $userid,
                'quiz_id' => $quiz_id,
                'answer' => $answer,
                'attemptid' => $attemptid,
                'quiz_type' => $quiz_type,
            )
        );

        require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');

        $id = store_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type);
        if ($id) {
            $output['success'] = true;
        } else {
            $output['success'] = false;
        }
        return $output;
    }

    /**
     * Return definition for method "save_rating"
     *
     * @return external_description
     */
    public static function save_question_answer_returns()
    {
        return new external_single_structure(
            array(
                'success' => new external_value(PARAM_BOOL, 'Return success of operation true or false'),)
        );
    }
    /**
     * Parameter definition for method "interactivepdf_services save answer"
     *
     * @return {object} external_function_parameters
     */
    public static function save_3n_question_answer_parameters()
    {
        return new external_function_parameters(
            array(
                'user_id' =>
                    new external_value(PARAM_INT, 'Id of the user who rated.'
                    ),
                'interactivepdfid' =>
                    new external_value(PARAM_INT, 'The Id of the course module to rate for.'
                    ),
                'quiz_id' =>
                    new external_value(PARAM_INT, 'The rate value.'
                    ),
                'answer' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'attemptid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),
                'quiz_type' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'ansid' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'quiz_3nid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),

            )
        );
    }

    /**
     * Save a rating for a course module.
     *
     * @param string $userid Id of the user who rated.
     * @param string $cmid The Id of the course module to rate for.
     * @param string $rating The rate value.
     * @param string $comment The rate value.
     * @return array
     * @throws {moodle_exception}
     */
    public static function save_3n_question_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type,$ansid,$quiz_3nid)
    {
        global $DB, $CFG;

        // Parameter validation.
        $params = self::validate_parameters(
            self::save_3n_question_answer_parameters(),
            array(
                'interactivepdfid' => $interactivepdf,
                'user_id' => $userid,
                'quiz_id' => $quiz_id,
                'answer' => $answer,
                'attemptid' => $attemptid,
                'quiz_type' => $quiz_type,
                'ansid' => $ansid,
                'quiz_3nid' => $quiz_3nid,
            )
        );
        require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');

        $id = store_3n_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type,$ansid,$quiz_3nid);
        if ($id) {
            $output['success'] = true;
        } else {
            $output['success'] = false;
        }
        return $output;
    }

    /**
     * Return definition for method "save_rating"
     *
     * @return external_description
     */
    public static function save_3n_question_answer_returns()
    {
        return new external_single_structure(
            array(
                'success' => new external_value(PARAM_BOOL, 'Return success of operation true or false'),)
        );
    }

    /**
     * Parameter definition for method "interactivepdf_services save answer"
     *
     * @return {object} external_function_parameters
     */
    public static function save_2nm_question_answer_parameters()
    {
        return new external_function_parameters(
            array(
                'user_id' =>
                    new external_value(PARAM_INT, 'Id of the user who rated.'
                    ),
                'interactivepdfid' =>
                    new external_value(PARAM_INT, 'The Id of the course module to rate for.'
                    ),
                'quiz_id' =>
                    new external_value(PARAM_INT, 'The rate value.'
                    ),
                'answer' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'attemptid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),
                'quiz_type' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'ansid' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'quiz_3nid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),

            )
        );
    }

    /**
     * Save a rating for a course module.
     *
     * @param string $userid Id of the user who rated.
     * @param string $cmid The Id of the course module to rate for.
     * @param string $rating The rate value.
     * @param string $comment The rate value.
     * @return array
     * @throws {moodle_exception}
     */
    public static function save_2nm_question_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type,$ansid,$quiz_3nid)
    {
        global $DB, $CFG;

        // Parameter validation.
        $params = self::validate_parameters(
            self::save_2nm_question_answer_parameters(),
            array(
                'interactivepdfid' => $interactivepdf,
                'user_id' => $userid,
                'quiz_id' => $quiz_id,
                'answer' => $answer,
                'attemptid' => $attemptid,
                'quiz_type' => $quiz_type,
                'ansid' => $ansid,
                'quiz_3nid' => $quiz_3nid,
            )
        );
        require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');

        $id = store_2nm_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type,$ansid,$quiz_3nid);
        if ($id) {
            $output['success'] = true;
        } else {
            $output['success'] = false;
        }
        return $output;
    }

    /**
     * Return definition for method "save_rating"
     *
     * @return external_description
     */
    public static function save_2nm_question_answer_returns()
    {
        return new external_single_structure(
            array(
                'success' => new external_value(PARAM_BOOL, 'Return success of operation true or false'),)
        );
    }

    /**
     * Parameter definition for method "interactivepdf_services save answer"
     *
     * @return {object} external_function_parameters
     */
    public static function save_2ns_question_answer_parameters()
    {
        return new external_function_parameters(
            array(
                'user_id' =>
                    new external_value(PARAM_INT, 'Id of the user who rated.'
                    ),
                'interactivepdfid' =>
                    new external_value(PARAM_INT, 'The Id of the course module to rate for.'
                    ),
                'quiz_id' =>
                    new external_value(PARAM_INT, 'The rate value.'
                    ),
                'answer' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'attemptid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),
                'quiz_type' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'ansid' =>
                    new external_value(PARAM_TEXT, 'The message value.'
                    ),
                'quiz_3nid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),

            )
        );
    }

    /**
     * Save a rating for a course module.
     *
     * @param string $userid Id of the user who rated.
     * @param string $cmid The Id of the course module to rate for.
     * @param string $rating The rate value.
     * @param string $comment The rate value.
     * @return array
     * @throws {moodle_exception}
     */
    public static function save_2ns_question_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type,$ansid,$quiz_3nid)
    {
        global $DB, $CFG;

        // Parameter validation.
        $params = self::validate_parameters(
            self::save_2ns_question_answer_parameters(),
            array(
                'interactivepdfid' => $interactivepdf,
                'user_id' => $userid,
                'quiz_id' => $quiz_id,
                'answer' => $answer,
                'attemptid' => $attemptid,
                'quiz_type' => $quiz_type,
                'ansid' => $ansid,
                'quiz_3nid' => $quiz_3nid,
            )
        );
        require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');

        $id = store_2ns_answer($userid, $interactivepdf, $quiz_id, $answer, $attemptid, $quiz_type,$ansid,$quiz_3nid);
        if ($id) {
            $output['success'] = true;
        } else {
            $output['success'] = false;
        }
        return $output;
    }

    /**
     * Return definition for method "save_rating"
     *
     * @return external_description
     */
    public static function save_2ns_question_answer_returns()
    {
        return new external_single_structure(
            array(
                'success' => new external_value(PARAM_BOOL, 'Return success of operation true or false'),)
        );
    }

    /**
     * Parameter definition for method "interactivepdf_services save answer"
     *
     * @return {object} external_function_parameters
     */
    public static function save_feedback_parameters()
    {
        return new external_function_parameters(
            array(
                'interactivepdfid' =>
                    new external_value(PARAM_INT, 'The Id of the course module to rate for.'
                    ),
                'userid' =>
                    new external_value(PARAM_INT, 'Id of the user who rated.'
                    ),
                'attemptid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),

                'subquestionid' =>
                    new external_value(PARAM_INT, 'The subquestionid value.'
                    ),
                'feedback' =>
                    new external_value(PARAM_INT, 'The feedback value.'
                    ),

                'feedbackcomment' =>
                    new external_value(PARAM_TEXT, 'The feedbackcomment value.'
                    )
            )
        );
    }

    /**
     * Save a rating for a course module.
     *
     * @param string $userid Id of the user who rated.
     * @param string $cmid The Id of the course module to rate for.
     * @param string $rating The rate value.
     * @param string $comment The rate value.
     * @return array
     * @throws {moodle_exception}
     */
    public static function save_feedback($interactivepdf, $userid, $attemptid, $subquestionid, $feedback , $feedbackcomment)
    {
        global $DB, $CFG;

        // Parameter validation.
        $params = self::validate_parameters(
            self::save_feedback_parameters(),
            array(
                'interactivepdfid' => $interactivepdf,
                'userid' => $userid,
                'attemptid' => $attemptid,
                'subquestionid' => $subquestionid,
                'feedback' => $feedback,
                'feedbackcomment' => $feedbackcomment
            )
        );

        require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');

        $id = interactivepdf_store_feedback($interactivepdf, $userid, $attemptid, $subquestionid, $feedback, $feedbackcomment);
        if ($id) {
            $output['success'] = true;
        } else {
            $output['success'] = false;
        }
        return $output;
    }

    /**
     * Return definition for method "save_rating"
     *
     * @return external_description
     */
    public static function save_feedback_returns()
    {
        return new external_single_structure(
            array(
                'success' => new external_value(PARAM_BOOL, 'Return success of operation true or false'),)
        );
    }

    public static function finish_attempt_parameters()
    {
        return new external_function_parameters(
            array(
                'user_id' =>
                    new external_value(PARAM_INT, 'Id of the user who rated.'
                    ),
                'interactivepdfid' =>
                    new external_value(PARAM_INT, 'The Id of the course module to rate for.'
                    ),
                'attemptid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),

            )
        );
    }

    /**
     * Save a rating for a course module.
     *
     * @param string $userid Id of the user who rated.
     * @param string $cmid The Id of the course module to rate for.
     * @param string $rating The rate value.
     * @param string $comment The rate value.
     * @return array
     * @throws {moodle_exception}
     */
    public static function finish_attempt($userid, $interactivepdf, $attemptid)
    {
        global $DB, $CFG;

        // Parameter validation.
        $params = self::validate_parameters(
            self::finish_attempt_parameters(),
            array(
                'interactivepdfid' => $interactivepdf,
                'user_id' => $userid,
                'attemptid' => $attemptid,
            )
        );

        require_once($CFG->dirroot . '/mod/interactivepdf/lib.php');
        $attempt = $DB->get_record('interactivepdf_attempts', ['userid' => $userid, 'interactivepdfid' => $interactivepdf, 'attempt' => $attemptid]);

        if ($attempt) {

            $data = array(
                'id'=>$attempt->id,
                'status'=>1,
                'timefinish'=>strtotime("now"),
            );
            $sql = 'UPDATE {interactivepdf_attempts} SET status =:status, timefinish=:timefinish WHERE id= :id';
            $DB->execute($sql,$data);
//            $DB->update_record('interactivepdf_attempts', $attempt);
            $output['success'] = true;
        } else {
            $output['success'] = false;
        }
        return $output;
    }

    /**
     * Return definition for method "save_rating"
     *
     * @return external_description
     */
    public static function finish_attempt_returns()
    {
        return new external_single_structure(
            array(
                'success' => new external_value(PARAM_BOOL, 'Return success of operation true or false'),)
        );
    }

    public static function send_notification_parameters()
    {
        return new external_function_parameters(
            array(
                'user_id' =>
                    new external_value(PARAM_INT, 'Id of the user who rated.'
                    ),
                'interactivepdfid' =>
                    new external_value(PARAM_INT, 'The Id of the course module to rate for.'
                    ),
                'attemptid' =>
                    new external_value(PARAM_INT, 'The message value.'
                    ),

            )
        );
    }

    /**
     * Save a rating for a course module.
     *
     * @param string $userid Id of the user who rated.
     * @param string $cmid The Id of the course module to rate for.
     * @param string $rating The rate value.
     * @param string $comment The rate value.
     * @return array
     * @throws {moodle_exception}
     */
    public static function send_notification($userid, $interactivepdf, $attemptid)
    {
        require_once(dirname(__FILE__) . '/lib.php');
        global $DB, $USER, $CFG;
        require_once($CFG->libdir.'/moodlelib.php');

        // Parameter validation.
        $params = self::validate_parameters(
            self::send_notification_parameters(),
            array(
                'interactivepdfid' => $interactivepdf,
                'userid' => $userid,
                'attemptid' => $attemptid,
            )
        );
        $cm = get_coursemodule_from_id('interactivepdf', $interactivepdf, 0, false, MUST_EXIST);
        $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
        $teachers = $DB->get_records_sql("
            SELECT u.*
            FROM {role_assignments} ra
            JOIN {user} u ON ra.userid = u.id
            WHERE ra.contextid = :contextid
            AND ra.roleid = :roleid
            ", array('contextid' => context_course::instance($course->id)->id, 'roleid' => 3)
        );
        $recipient = [];
        if (!empty($teachers)) {

            foreach ($teachers as $teacher) {
                $sender = $DB->get_record('user', array('id' => $userid), '*', MUST_EXIST);
                $notification = new \core\message\message();
                $notification->component = 'moodle';
                $notification->name = 'instantmessage';
                $notification->userfrom = $sender;
                $notification->userto = $teacher;
                $notification->subject = 'Quiz submission';
                $notification->fullmessage = $sender->firstname . ' has submitted his '. $attemptid. ' attempt of this quiz. Quiz Link -http://moodle42.local/mod/interactivepdf/view.php?id='.$interactivepdf;
                $notification->fullmessageformat = FORMAT_HTML;
                $notification->notification = 1;
                $notification->contexturl = $CFG->wwwroot;
                $messageid = message_send($notification);
                $output['success'] = true;
            }
        }
        return $output;
    }

    /**
     * Return definition for method "save_rating"
     *
     * @return external_description
     */
    public static function send_notification_returns()
    {
        return new external_single_structure(
            array(
                'success' => new external_value(PARAM_BOOL, 'Return success of operation true or false'),)
        );
    }

}
