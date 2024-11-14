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
 * Defines forms.
 *
 * @package    local_mb2reviews
 * @copyright  2021 Mariusz Boloz (mb2themes.com)
 * @license    Commercial https://themeforest.net/licenses
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/api.php');

if ( ! class_exists( 'Mb2reviewsHelper' ) )
{
    class Mb2reviewsHelper
    {




        /*
         *
         * Method to get user roles
         *
         */
        public static function get_roles()
        {
            return role_fix_names( get_all_roles() );
        }





        /*
         *
         * Method to get user roles to selct from field
         *
         */
        public static function get_roles_to_select()
        {
            $select_roles = array();
            $roles = self::get_roles();

            foreach($roles as $role)
            {
                $select_roles[$role->id] = $role->localname;
            }

            // Sort array by role name
            asort( $select_roles );

            return $select_roles;

        }



        /*
         *
         * Method to get user roles id by roleshortname
         *
         */
        public static function get_role_id( $rolename )
        {

            $roles = self::get_roles();

            foreach( $roles as $role )
            {
                if ( $role->shortname === $rolename )
                {
                    return $role->id;
                }
            }

            return 0;

        }



        /*
         *
         * Method to current course and currsent user rating
         *
         */
        public static function get_my_rating()
        {
            global $DB, $COURSE, $USER;

            $sqlwhere = ' WHERE 1=1';
            $isquery = 'SELECT rating FROM {local_mb2reviews_items}';
            $sqlwhere .= ' AND course=' . $COURSE->id;
            $sqlwhere .= ' AND createdby=' . $USER->id;

            if ( ! $DB->record_exists_sql( $isquery . $sqlwhere, array() ) )
            {
                return 0;
            }

            return $DB->get_record_sql($isquery . $sqlwhere, array())->rating;

        }



        /*
         *
         * Method to get user
         *
         */
        public static function get_user($id)
        {
            global $DB;

            if (!$id)
            {
                return;
            }

            return $DB->get_record('user', array('id'=>$id));
        }





        /**
         *
         * Method to check ite date status.
         *
         */
        public static function get_user_date()
        {

            $date = new DateTime( 'now', core_date::get_user_timezone_object() );
            $time = $date->getTimestamp();
            return $time;

        }





        /**
         *
         * Method to get course rating.
         *
         */
        public static function course_rating( $courseid, $teacherid = 0 )
        {
            $options = get_config('local_mb2reviews');
            $ratingcount = self::course_rating_count( $courseid, 0, 1, $teacherid );
            $ratingsum = self::course_rating_sum( $courseid, $teacherid );

            if ( ! $ratingcount || $ratingcount < $options->minrated )
            {
                return 0;
            }

            return round( $ratingsum/$ratingcount, 2 );

        }


        /**
         *
         * Method to get course rating count.
         *
         */
        public static function course_rating_count( $courseid, $ratingnum = 0, $enabled = 1, $teacherid = 0, $content = 0 )
        {
            global $DB;
            $sqlquery = '';
            $sqlwhere = ' WHERE 1=1';
            $params = array();
            $isenabled = $enabled ? 1 : 0;

            $sqlquery .= 'SELECT COUNT( DISTINCT id ) FROM {local_mb2reviews_items}';

            $teachercourses = self::get_teacher_courses( $teacherid );

            if ( ! empty( $teachercourses ) )
            {
                //$teachercourses = self::get_teacher_courses( $teacherid );
                list( $teachercoursesinsql, $teachercoursesparams ) = $DB->get_in_or_equal( $teachercourses );
        		$params = array_merge( $params, $teachercoursesparams );
        		$sqlwhere .= ' AND course ' . $teachercoursesinsql;
            }
            else
            {
                $sqlwhere .= ' AND course=' . $courseid;
            }

            $sqlwhere .= ' AND enable=' . $isenabled;
            $sqlwhere .= $ratingnum ? ' AND rating=' . $ratingnum : '';
            $sqlwhere .= $content ? ' AND content!=\'\'' : '';

            if ( self::is_rating( $courseid, $teacherid ) || ! $enabled )
            {
                return $DB->count_records_sql( $sqlquery . $sqlwhere, $params );
            }

            return 0;

        }





        /**
         *
         * Method to get course rating count.
         *
         */
        public static function get_teacher_courses( $teacherid )
        {
            global $DB;
            $sqlquery = '';
            $sqlwhere = ' WHERE 1=1';
            $courses = array();

            $sqlquery .= 'SELECT DISTINCT c.instanceid FROM {context} c JOIN {role_assignments} ra ON ra.contextid=c.id';
            $sqlwhere .= ' AND c.contextlevel=' . CONTEXT_COURSE;
            $sqlwhere .= ' AND ra.roleid=' . self::get_user_role_id( true );
            $sqlwhere .= ' AND ra.userid=' . $teacherid;

            $results = $DB->get_records_sql( $sqlquery . $sqlwhere, array() );

            if ( count( $results ) )
            {
                foreach ( $results as $r )
                {
                    $courses[] = $r->instanceid;
                }
            }

            return $courses;

        }






        /**
         *
         * Method to get course rating sum.
         *
         */
        public static function course_rating_sum( $courseid, $teacherid = 0 )
        {
            global $DB;

            $sqlquery = '';
            $sqlwhere = ' WHERE 1=1';
            $params = array();

            if ( ! self::is_rating( $courseid, $teacherid ) )
            {
                return 0;
            }

            if ( $teacherid )
            {
                $params = array();
            }

            $sqlquery .= 'SELECT SUM(rating) FROM {local_mb2reviews_items}';

            $teachercourses = self::get_teacher_courses( $teacherid );

            if ( ! empty( $teachercourses ) )
            {
                //$teachercourses = self::get_teacher_courses( $teacherid );
                list( $teachercoursesinsql, $teachercoursesparams ) = $DB->get_in_or_equal( $teachercourses );
        		$params = array_merge( $params, $teachercoursesparams );
        		$sqlwhere .= ' AND course ' . $teachercoursesinsql;
            }
            else
            {
                $sqlwhere .= ' AND course=' . $courseid;
            }

            //$sqlwhere .= ! $teacherid ? ' AND enable=1' : '';
            $sqlwhere .= ' AND enable=1';

            $result = $DB->get_records_sql( $sqlquery . $sqlwhere, $params );
            return key( $result );

        }



        /**
         *
         * Method to get check if course has rating.
         *
         */
        public static function is_rating( $courseid, $teacherid = 0 )
        {

            global $DB;

            $sqlwhere = ' WHERE 1=1';
            $params = array();

            $isquery = 'SELECT id FROM {local_mb2reviews_items}';

            $teachercourses = self::get_teacher_courses( $teacherid );

            if ( ! empty( $teachercourses ) )
            {
                //$teachercourses = self::get_teacher_courses( $teacherid );
                list( $teachercoursesinsql, $teachercoursesparams ) = $DB->get_in_or_equal( $teachercourses );
                $params = array_merge( $params, $teachercoursesparams );
                $sqlwhere .= ' AND course ' . $teachercoursesinsql;
            }
            else
            {
                $sqlwhere .= ' AND course=' . $courseid;
            }

            $sqlwhere .= ' AND enable=1';

            if ( $DB->record_exists_sql( $isquery . $sqlwhere, $params ) )
            {
                return true;
            }

            return false;

        }




        /**
         *
         * Method to get course rating.
         *
         */
        public static function course_rating_form()
        {
            global $USER, $COURSE;

            $output = '';
            $formid = uniqid( 'mb2reviews_form_' );
            $options = get_config('local_mb2reviews');
            $isenable = $options->autoapprove ? 1 : 0;

            $output .= '<form id="' . $formid . '" class="mb2reviews-review-form" action="">';
            $output .= '<input name="id" type="hidden" value="0">';
            $output .= '<input name="course" type="hidden" value="' . $COURSE->id . '">';
            $output .= '<input name="createdby" type="hidden" value="' . $USER->id . '">';
            $output .= '<input name="timecreated" type="hidden" value="' . time() . '">';
            $output .= '<input name="enable" type="hidden" value="' . $isenable . '">';
            $output .= '<input name="sesskey" type="hidden" value="' . $USER->sesskey . '">';

            $output .= '<div class="form-group">';
            $output .= '<label for="rating">' . get_string('rating', 'local_mb2reviews') . '</label>';
            $output .= '<select name="rating" id="rating">';
            $output .= '<option value="0">' . get_string('none', 'local_mb2reviews') . '</option>';
            $output .= '<option value="1">' . get_string('star1', 'local_mb2reviews') . '</option>';
            $output .= '<option value="2">' . get_string('star2', 'local_mb2reviews') . '</option>';
            $output .= '<option value="3">' . get_string('star3', 'local_mb2reviews') . '</option>';
            $output .= '<option value="4">' . get_string('star4', 'local_mb2reviews') . '</option>';
            $output .= '<option value="5">' . get_string('star5', 'local_mb2reviews') . '</option>';
            $output .= '</select>';
            $output .= '</div>';

            $output .= '<div class="form-group">';
            $output .= '<label for="content">' . get_string('comment', 'local_mb2reviews') . '</label>';
            $output .= '<textarea name="content" id="content"></textarea>';
            $output .= '</div>';

            $output .= '<input type="submit" value="' . get_string('submit') . '">';

            $output .= '</form>';

            return $output;

        }




        /**
         *
         * Method to get course rating modal window.
         *
         */
        public static function course_rating_modal()
        {

            $output = '';

            $output .= '<div id="mb2reviews-review-modal" class="modal theme-modal-scale theme-forms" role="dialog">';
            $output .= '<div class="modal-dialog" role="document">';
            $output .= '<div class="modal-content">';
            $output .= '<div class="theme-modal-container">';
            $output .= '<span class="close-container" data-dismiss="modal">&times;</span>';
            $output .= self::course_rating_form();
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            $output .= self::review_formjs_init();

            return $output;


        }





        /**
         *
         * Method to int review form submit.
         *
         */
        public static function review_formjs_init()
        {
            global $PAGE;

            $inline_js = '';
        	$inline_js .= 'require([\'local_mb2reviews/rate\'], function(ReviewContainer) {';
        	$inline_js .= 'new ReviewContainer();';
        	$inline_js .= '});';
            return $PAGE->requires->js_amd_inline( $inline_js );

        }




        /**
         *
         * Method to int review form submit.
         *
         */
        public static function more_reviews_init()
        {
            global $PAGE;

            $inline_js = '';
        	$inline_js .= 'require([\'local_mb2reviews/more\'], function(ReviewMore) {';
        	$inline_js .= 'new ReviewMore();';
        	$inline_js .= '});';
            return $PAGE->requires->js_amd_inline( $inline_js );

        }



        /**
         *
         * Method to int review form submit.
         *
         */
        public static function feedback_init()
        {
            global $PAGE;

            $options = get_config('local_mb2reviews');

            if ( ! $options->helpful ){
                return;
            }

            $inline_js = '';
        	$inline_js .= 'require([\'local_mb2reviews/feedback\'], function(Feedback) {';
        	$inline_js .= 'new Feedback();';
        	$inline_js .= '});';
            return $PAGE->requires->js_amd_inline( $inline_js );

        }





        /**
         *
         * Method to int review form submit.
         *
         */
        public static function notify_users( $submitter, $recipient, $data, $update = false )
        {

            $message = new \core\message\message();
            $message->component = 'local_mb2reviews';
            $message->name = 'submission';
            $message->notification = 1;

            $message->userfrom = $submitter;
            $message->userto = $recipient;
            $message->subject = get_string( 'emailnotifysubject', 'local_mb2reviews', array( 'course' => $data->coursefullname ) );
            $message->fullmessage = get_string( 'emailnotifybody', 'local_mb2reviews', array(
                'rating' => $data->rating, 'comment' => $data->content, 'user' => $data->user ) );
            $message->fullmessageformat = FORMAT_HTML;
            $message->fullmessagehtml = '';
            $message->smallmessage = get_string( 'emailnotifysmall', 'local_mb2reviews', array(
                'course' => $data->coursefullname, 'rating' => $data->rating ) );

            $message->contexturl = '';
            $message->contexturlname = '';

            if ( $update )
            {
                $message->subject = get_string( 'emailnotifyupdatedsubject', 'local_mb2reviews', array( 'course' => $data->coursefullname ) );
            }

            message_send($message);


        }




        /**
         *
         * Method to int review form submit.
         *
         */
        public static function notify_users_message( $review, $update = false )
        {

            global $DB, $CFG;

            // Check for notifications required.
            $notifyexcludeusers = '';
            $groups = '';
            $notifyfields = 'u.id, u.username, u.idnumber, u.email, u.emailstop, u.lang,
                    u.timezone, u.mailformat, u.maildisplay, u.auth, u.suspended, u.deleted, ';

            if ( $CFG->version >= 2021051700 ) // For moodle 3.11+
            {
                $userfieldsapi = \core_user\fields::for_name();
                $notifyfields .= $userfieldsapi->get_sql('u', false, 'useridalias', '', false)->selects;
            }
            else
            {
                $notifyfields .= get_all_user_name_fields(true, 'u');
            }

            $coursecontext = context_course::instance( $review->course );
            $userstonotify = get_users_by_capability( $coursecontext, 'local/mb2reviews:emailnotifysubmission',
                $notifyfields, '', '', '', $groups, $notifyexcludeusers, false, false, true);

            if ( empty( $userstonotify ) )
            {
                return true; // Nothing to do.
            }

            $data = new stdClass();
            $data->userid = $review->createdby;
            $data->course = $review->course;

            $submitter = $DB->get_record('user', array( 'id' => $data->userid ), '*', MUST_EXIST);
            $course = $DB->get_record('course', array( 'id' => $data->course ), '*', MUST_EXIST);

            $data->coursefullname = $course->fullname;
            $data->rating = $review->rating;
            $data->content = $review->content;
            $data->user = $submitter->firstname . ' ' . $submitter->lastname;

            $allok = true;

            // Send notifications if required.
            foreach ( $userstonotify as $recipient )
            {
                $allok = self::notify_users( $submitter, $recipient, $data, $update );
            }

            return $allok;


        }





        /**
         *
         * Method to check current review belongs to curret user
         *
         */
        public static function own_review( $itemid )
        {
        	global $DB, $USER;

        	$sqlquery = 'SELECT * FROM {local_mb2reviews_items} WHERE id=? AND createdby=?';
            $params = array( $itemid, $USER->id );

        	if ( $DB->record_exists_sql( $sqlquery, $params ) )
        	{
        		return true;
        	}

        	return false;

        }



        /**
         *
         * Method to get detailed rating info
         *
         */
        public static function rating_details( $courseid )
        {
            $output = '';
            $ratingcount = self::course_rating_count( $courseid );

            $output .= '<ul class="rating-details">';

            for ( $i=5; $i>0; $i-- )
            {
                $ratingcountn = self::course_rating_count( $courseid, $i );
                $percentage = round( ( $ratingcountn/$ratingcount ) * 100 );

                $output .= '<li>';
                $output .= '<span class="rating-starlabel">' .  $i . ' <i class="glyphicon glyphicon-star"></i></span>';
                $output .= '<div class="rating-starcat rating-' . $i . '">';
                $output .= '<div class="rating-progress" style="width:' .  $percentage . '%"></div>';
                $output .= '</div>';
                $output .= '<span class="rating-count">' .  $percentage . '%</span>';
                $output .= '</li>';
            }

            $output .= '</ul>';

            return $output;

        }




        /**
         *
         * Method to get rating stars as alink to rate course
         *
         */
        public static function rating_stars_link()
        {
            global $COURSE, $PAGE;

            $output = '';
            $courseid = $COURSE->id;
            $options = get_config('local_mb2reviews');

            if ( ! self::can_rate( $courseid ) && ! self::rate_already( $courseid ) )
            {
                return;
            }

            $myrating = self::get_my_rating();

            $output .= '<div class="mb2reviews-star-links" data-rating="' . $myrating . '">';

            if ( self::rate_already( $courseid ) && ! self::rate_already( $courseid, true ) )
            {
                return '<span>' . get_string('reviewwaitingforapprove', 'local_mb2reviews') . '</span>';
            }

            for($i=1; $i<=5; $i++)
            {
                $cls = $i<=$myrating ? ' fill' : '';

                if ( self::rate_already( $COURSE->id ) && $options->caneditreview )
                {
                    $link = new moodle_url( '/local/mb2reviews/edit.php',
                    array( 'itemid' => self::rate_already( $courseid ), 'course' => $courseid, 'rating' => $i, 'returnurl' => new moodle_url( '/course/view.php', array( 'id' => $courseid ) ) ) );
                }
                elseif ( self::rate_already( $COURSE->id ) && ! $options->caneditreview )
                {
                    $link = '';
                }
                else
                {
                    $link = new moodle_url( '/local/mb2reviews/edit.php',
                    array( 'itemid' => 0, 'course' => $courseid, 'rating' => $i, 'returnurl' => new moodle_url( '/course/view.php', array( 'id' => $courseid ) ) ) );
                }

                $output .= self::star_link_html($link, $i, $cls);
            }

            $output .= '</div>';

            $PAGE->requires->js_call_amd( 'local_mb2reviews/stars', 'ratingStars' );

            return $output;

        }




        /**
         *
         * Method to get rating stars as alink to rate course
         *
         */
        public static function star_link_html($link = '', $i = 1, $cls = '')
        {

            $output = '';

            $attr = ' class="mb2reviews-star-link-item' . $cls . '" title="' . get_string('star', 'local_mb2reviews', $i) . '" data-rating="' . $i . '"';

            $output .= $link ? '<a href="' . $link . '"' . $attr . '>' : '<span' . $attr . '>';
            $output .= '<i class="glyphicon glyphicon-star" aria-hidden="true"></i>';
            $output .= $link ? '</a>' : '</span>';

            return $output;


        }



        /**
         *
         * Method to get rating stars
         *
         */
        public static function rating_range()
        {
            return array(1,1.5,2,2.5,3,3.5,4,4.5,5);
        }



        /**
         *
         * Method to get smalest diffrenc between rating and rating range
         *
         */
        public static function min_diff( $num )
        {
            $diff = array();
            $range = self::rating_range();

            foreach ($range as $k=>$r)
            {
                $idiff = round($num-$r, 10);

                // Remove negative values
                if ( $idiff < 0  )
                {
                    $idiff = ( $idiff * -1 );
                }

                $diff[$k] = $idiff;
            }

            // Build array only with minimal
            $diff = array_keys( $diff, min( $diff ) );

            return $diff[0];

        }



        /**
         *
         * Method to get rating stars
         *
         */
        public static function rating_stars( $courseid, $rating = false, $size = '')
        {
            $output = '';
            $cls = $size ? ' ' . $size : '';

            $range = self::rating_range();
            $israting = $rating ? $rating : self::course_rating( $courseid );
            $rangekey = self::min_diff($israting);
            $israting = $range[$rangekey];
            $ratingpercentage = round(($israting/5) * 100, 1);

            if ( ! $ratingpercentage )
            {
                return;
            }

            $output .= '<div class="mb2reviews-stars' . $cls . '">';

            $output .= '<div class="stars-empty">';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '</div>';

            $output .= '<div class="stars-full" style="width:' . $ratingpercentage . '%;">';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '<i class="glyphicon glyphicon-star"></i>';
            $output .= '</div>';

            $output .= '</div>';

            return $output;

        }





        /**
         *
         * Method to check if user rate course
         *
         */
        public static function rate_already( $courseid, $enabled = false )
        {
        	global $DB, $USER;

            $params = array( $courseid, $USER->id );

        	$sqlquery = 'SELECT id FROM {local_mb2reviews_items} WHERE course = ? AND createdby = ?';

            if ( $enabled )
            {
                $sqlquery .= ' AND enable=?';
                $params[] = 1;
            }

        	if ( $DB->record_exists_sql( $sqlquery, $params ) )
        	{
                return $DB->get_record_sql( $sqlquery, $params )->id;
            }

        	return false;

        }





        /**
         *
         * Method to get review link
         *
         */
        public static function review_link( $courseid, $rating = 0, $manage = true, $cls = '' )
        {
            $output = '';
            $options = get_config('local_mb2reviews');
            $coursecontext = context_course::instance( $courseid );

            if ( self::rate_already( $courseid ) )
            {
                if ( ! self::rate_already( $courseid, true ) )
                {
                    $output .= '<span>' . get_string('reviewwaitingforapprove', 'local_mb2reviews') . '</span>';
                }
                elseif ( $options->caneditreview )
                {
                    $editlink = new moodle_url( '/local/mb2reviews/edit.php',
                    array( 'itemid' => self::rate_already( $courseid ), 'course' => $courseid, 'rating' => $rating,
                    'returnurl' => new moodle_url( '/course/view.php', array( 'id' => $courseid ) ) ) );

                    $output .= '<a href="' . $editlink . '" class="mb2reviews-review-btn' . $cls . '">';
                    $output .= get_string('editreview', 'local_mb2reviews');
                    $output .= '</a>';
                }
                else
                {
                    $output .= '<span>' . get_string('coursealreadyrated', 'local_mb2reviews') . '</span>';
                }
            }
            elseif ( self::can_rate( $courseid ) )
            {
                $ratinglink = new moodle_url( '/local/mb2reviews/edit.php',
                array( 'itemid' => 0, 'course' => $courseid, 'rating' => $rating, 'returnurl' => new moodle_url( '/course/view.php', array( 'id' => $courseid ) ) ) );

                $output .= '<a href="' . $ratinglink . '" class="mb2reviews-review-btn' . $cls . '">';
                $output .= get_string('addreview', 'local_mb2reviews');
                $output .= '</a>';
            }
            elseif ( $manage && has_capability( 'local/mb2reviews:managecourseitems', $coursecontext ) )
            {
                $ratinglink = new moodle_url( '/local/mb2reviews/index.php', array( 'course' => $courseid ) );

                $output .= '<a href="' . $ratinglink . '" class="mb2reviews-review-btn' . $cls . '">';
                $output .= get_string('managecourseitems', 'local_mb2reviews');
                $output .= '</a>';
            }

            return $output;

        }






        /**
         *
         * Method to check if user can rate course
         *
         */
        public static function can_rate( $courseid )
        {
            global $USER;

        	$coursecontext = context_course::instance( $courseid );
        	$ratealready = self::rate_already( $courseid );
            $rolestudent = self::get_user_role_id();

        	if ( is_enrolled( $coursecontext, $USER->id ) && user_has_role_assignment( $USER->id, $rolestudent, $coursecontext->id ) && ! $ratealready )
        	{
        		return true;
        	}

        	return false;

        }








        /**
         *
         * Method to show course review link
         *
         */
        public static function rating_block( $style )
        {
        	global $COURSE, $PAGE;

        	$output = '';
        	$options = get_config('local_mb2reviews');
            $rating = self::course_rating( $COURSE->id );

        	if (
                $options->disablereview ||
                $PAGE->user_is_editing() ||
                ( $PAGE->pagelayout !== 'course' && $COURSE->format !== 'singleactivity' ) ||
                ( ! $rating && ( ! isloggedin() || isguestuser() ) )
            )
        	{
        		return;
        	}

            $coursecontext = context_course::instance( $COURSE->id );
        	$ratingcount = self::course_rating_count( $COURSE->id );
            $ratinghiddencount = self::course_rating_count( $COURSE->id, false, false );

            $style = $style === 'classic' ? 'default' : $style;

        	$output .= '<div class="style-' . $style . '">';
        	$output .= '<div class="block block_mb2reviews">';
        	$output .= '<h5 class="sr-only">' . get_string('courserating', 'local_mb2reviews') . '</h5>';
        	$output .= '<div class="content">';

        	if ( $rating )
        	{
        		$output .= self::rating_stars( $COURSE->id );

        		$output .= '<div class="mb2reviews-rating">';
        		$output .= get_string( 'basedonreviewcount', 'local_mb2reviews', array( 'rating'=>$rating, 'count'=>$ratingcount ) );
        		$output .= '</div>';

        		$output .= '<div id="mb2reviews-block-more" class="mb2reviews-rating-more">';
        		$output .= self::rating_details( $COURSE->id );
        		$output .= '</div>';
        	}

            if ( has_capability( 'local/mb2reviews:managecourseitems', $coursecontext ) && $ratinghiddencount > 0 )
            {
                $output .= '<p class="mb2reviews-vhratings">' . get_string( 'hratingcount', 'local_mb2reviews', array( 'h'=>$ratinghiddencount ) ) . '</p>';
            }

            $output .= self::review_link( $COURSE->id );

        	$output .= '</div>'; // content
        	$output .= '</div>';
        	$output .= '</div>';

            $PAGE->requires->js_call_amd( 'local_mb2reviews/block', 'ratingDetails' );

        	return $output;

        }






        /**
         *
         * Method to display reviews list
         *
         */
        public static function review_list()
        {
            global $OUTPUT, $COURSE;
            $output = '';
            $options = get_config('local_mb2reviews');
            $perpage = $options->perpage;
            $opts = array( 'courseid' => $COURSE->id, 'page' => 0 );
            $reviewscount = Mb2reviewsApi::get_list_records( $COURSE->id, true, true, true );

            if ( ! $reviewscount )
            {
                return ;
            }

            $output .= '<div class="mb2reviews-review-list">';
            $output .= self::review_list_items( $opts );
            $output .= '</div>'; // mb2reviews-review-list

            $output .= self::more_reviews_btn( $reviewscount, $perpage );

            self::feedback_init();

            return $output;


        }





        /**
         *
         * Method to display reviews list
         *
         */
        public static function review_list_items( $opts = array() )
        {

            global $OUTPUT, $COURSE;
            $output = '';
            $options = get_config('local_mb2reviews');
            $perpage = $options->perpage;
            $startpage = $perpage * $opts['page'];
            $courseid = $opts['courseid'];
            $reviews = Mb2reviewsApi::get_list_records( $courseid, true, true, false, $startpage, $perpage );

            foreach ( $reviews as $review )
            {

                $revieuser = self::get_user( $review->createdby );

                $output .= '<div class="mb2reviews-review-item item-' . $review->id . '">';
                $output .= '<div class="mb2reviews-review-item-inner">';
                $output .= '<div class="mb2reviews-review-userpicture">';
                $output .= $OUTPUT->user_picture( $revieuser, array( 'size'=> 100, 'link' => 0 ) );
                $output .= '</div>'; // mb2reviews-review-userpicture
                $output .= '<div class="mb2reviews-review-details">';

                $output .= '<div class="mb2reviews-review-header">';
                $output .= self::rating_stars( false, $review->rating );

                $output .= '<span class="mb2reviews-username">';
                $output .= self::get_user_name( $revieuser );
                $output .= '</span>'; // mb2reviews-username

                $output .= '<span class="mb2reviews-date">';
                $output .= userdate( $review->timecreated, get_string( 'strftimedatemonthabbr', 'local_mb2reviews' ) );
                $output .= '</span>'; // mb2reviews-date

                $output .= '</div>'; // mb2reviews-review-header

                $output .= '<div class="mb2reviews-review-content">';
                $output .= $review->content;
                $output .= '</div>'; // mb2reviews-review-content

                if ( $options->helpful && ( isloggedin() || isguestuser() ) )
                {
                    $output .= '<div class="mb2reviews-review-footer">';
                    $output .= '<div class="mb2reviews-review-thumbs">';
                    $output .= '<span class="mb2reviews-review-thumbtext text1">' . get_string( 'reviewhelpful', 'local_mb2reviews' ) . '</span>';
                    $output .= '<span class="mb2reviews-review-thumbtext text2">' . get_string( 'feedbackthankyou', 'local_mb2reviews' ) . '</span>';
                    $output .= '<button class="mb2reviews-review-thumb themereset" data-review="' .
                    $review->id . '" data-thumb="yes" aria-label="' . get_string('yes') . '"><i class="glyphicon glyphicon-thumbs-up"></i></button>';
                    $output .= '<button class="mb2reviews-review-thumb themereset" data-review="' .
                    $review->id . '" data-thumb="no" aria-label="' . get_string('no') . '"><i class="glyphicon glyphicon-thumbs-down"></i></button>';
                    $output .= '</div>'; // mb2reviews-review-thumbs
                    $output .= '</div>'; // mb2reviews-review-footer
                }

                $output .= '</div>'; // mb2reviews-review-details
                $output .= '</div>'; // mb2reviews-review-item-inner
                $output .= '</div>'; // mb2reviews-review-item
            }

            return $output;


        }






        /**
         *
         * Method to display more reviews button
         *
         */
        public static function more_reviews_btn( $reviewscount, $perpage )
        {
            global $COURSE;

            $output = '';

            if ( $reviewscount <= $perpage )
            {
                return;
            }

            $maxpages = ceil($reviewscount/$perpage);

            $output .= '<div class="mb2reviews-more-wrap">';
            $output .= '<button class="mb2reviews-more mb2-pb-btn sizesm typeprimary" data-courseid="' . $COURSE->id . '" data-page="1" data-maxpages="' . $maxpages . '" aria-label="' . get_string('morereviews', 'local_mb2reviews') . '">';
            $output .= '<span class="text1">' . get_string('morereviews', 'local_mb2reviews') . '</span>';
            $output .= '<span class="text2">' . get_string('processing', 'local_mb2reviews') . '</span>';
            $output .= '</button>';
            $output .= '</div>';

            self::more_reviews_init();

            return $output;

        }






        /**
         *
         * Method to display reviews list
         *
         */
        public static function get_user_name( $user )
        {

            $output = '';
            $options = get_config('local_mb2reviews');

            if ( $options->reviewusername == 2 )
            {
                $islastname = $user->lastname ? substr( $user->lastname, 0, 1 ) . '.' : '';
                $output = $user->firstname . ' ' . $islastname;
            }
            elseif ( $options->reviewusername == 3 )
            {
                $output = $user->firstname . ' ' . $user->lastname;
            }
            else
            {
                $output = $user->username;
            }

            return $output;


        }





        /**
         *
         * Method to display reviews summary
         *
         */
        public static function review_summary()
        {
            global $COURSE;
            $output = '';

            if ( ! self::course_rating( $COURSE->id ) )
            {
                return;
            }

            $ratingcount = self::course_rating_count( $COURSE->id );

            $output .= '<div class="mb2reviews-review-summary">';

            $output .= '<div class="mb2reviews-rating-warp">';
            $output .= '<div class="mb2reviews-rating">';
            $output .= self::course_rating( $COURSE->id );
            $output .= '</div>'; //mb2reviews-rating

            $output .= '<div class="mb2reviews-stars-wrap">';
            $output .= self::rating_stars( $COURSE->id, false, 'lg' );

            $output .= '<div class="mb2reviews-ratings">';
            $output .= get_string('ratingscount', 'local_mb2reviews', array('ratings'=>self::course_rating_count( $COURSE->id )) );
            $output .= '</div>'; // mb2reviews-ratings

            $output .= '</div>'; // mb2reviews-stars
            $output .= '</div>'; // mb2reviews-rating-warp

            $output .= '<div class="mb2reviews-rating-details">';
            $output .= self::rating_details( $COURSE->id );
            $output .= '</div>'; // mb2reviews-rating-details

            $output .= '</div>'; // mb2reviews-review-summary

            return $output;


        }



        /*
		 *
		 * Method to get user role id
		 *
		 */
		public static function get_user_role_id( $teacher = false )
		{

			global $DB, $PAGE;

            $options = get_config('local_mb2reviews');

			$usershortname = $teacher ? $options->roleteacher : $options->rolestudent;
			$query = 'SELECT id FROM {role} WHERE shortname = ?';

			if (  ! $DB->record_exists_sql( $query, array( $usershortname ) ) )
			{
				return 0;
			}

			$roleid = $DB->get_record( 'role', array( 'shortname' => $usershortname ), 'id', MUST_EXIST );

			return $roleid->id;

		}






    }

}
