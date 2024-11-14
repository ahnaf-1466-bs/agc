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
 * @package    theme_mb2nl
 * @copyright  2020 Mariusz Boloz (mb2moodle.com)
 * @license   Commercial https://themeforest.net/licenses
 */

defined( 'MOODLE_INTERNAL' ) || die;


require_once( $CFG->libdir . '/externallib.php' );
require ( __DIR__ . '/lib.php' );


class theme_mb2nl_external extends external_api
{


    /**
     *
     * Method to get a list of all services.
     *
     */
    public static function submit_subscribe_form( $formdata )
    {
        global $PAGE;

        //require_login();
		$context = context_system::instance();
		$PAGE->set_context( $context );

        $params = self::validate_parameters( self::submit_subscribe_form_parameters(), array(
            'formdata' => $formdata
        ) );

        $formarray = array();
        parse_str( $params['formdata'], $formarray );

        $opt = array(
            'categories' => $formarray['filter_categories'],
            'tags' => $formarray['filter_tags'],
            'price' => $formarray['filter_price'] > -1 ? $formarray['filter_price'] : -1,
            'instructors' => $formarray['filter_instructors'],
            'page' => 1,
            'searchstr' => ''
        );

        $opt['lazy'] = 0;

        $courses = theme_mb2nl_course_list( $opt );

        $results = array(
            'courses' => $courses
        );

        return $results;

    }




    /**
     * Describes the parameters for submit_grading_form webservice.
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function submit_subscribe_form_parameters() {
        return new external_function_parameters(
            array(
                'formdata' => new external_value( PARAM_RAW, 'The data from the grading form, encoded as a json array' )
            )
        );
    }



    /**
     * Describes the return for submit_grading_form
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function submit_subscribe_form_returns() {
        return new external_single_structure(
            array(
                'courses' => new external_value( PARAM_RAW, 'The data from the grading form, encoded as a json array' ),
                'warnings' => new external_warnings()
            )
        );
    }



    /**
     *
     * Method to get a list of all services.
     *
     */
    public static function set_courses_pagination( $page, $categories, $tags, $instructors, $price, $searchstr )
    {
        global $PAGE;

        //require_login();
		$context = context_system::instance();
		$PAGE->set_context( $context );

        $params = self::validate_parameters( self::set_courses_pagination_parameters(), array(
            'page' => $page,
            'categories' => $categories,
            'tags' => $tags,
            'instructors' => $instructors,
            'price' => $price,
            'searchstr' => $searchstr
        ) );

        $opt = array(
            'page' => $params['page'],
            'categories' => unserialize( urldecode( $params['categories'] ) ),
            'tags' => unserialize( urldecode( $params['tags'] ) ),
            'instructors' => unserialize( urldecode( $params['instructors'] ) ),
            'price' => $params['price'],
            'searchstr' => $params['searchstr']
        );

        $opt['lazy'] = 0;

        $courses = theme_mb2nl_course_list( $opt );

        $results = array(
            'courses' => $courses
        );

        return $results;

    }





    /**
     * Describes the parameters for submit_grading_form webservice.
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function set_courses_pagination_parameters() {
        return new external_function_parameters(
            array(
                'page' => new external_value( PARAM_INT, 'Pagination current page number' ),
                'categories' => new external_value( PARAM_RAW, 'Categories array' ),
                'tags' => new external_value( PARAM_RAW, 'Tags array' ),
                'instructors' => new external_value( PARAM_RAW, 'instructors array' ),
                'price' => new external_value( PARAM_INT, 'Course price' ),
                'searchstr' => new external_value( PARAM_RAW, 'Search query' )
            )
        );
    }



    /**
     * Describes the return for submit_grading_form
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function set_courses_pagination_returns() {
        return new external_single_structure(
            array(
                'courses' => new external_value( PARAM_RAW, 'Course list' ),
                'warnings' => new external_warnings()
            )
        );
    }





    /**
     *
     * Method to get a list of search couses.
     *
     */
    public static function set_courses_search( $searchstr, $categories, $tags, $instructors, $price )
    {
        global $PAGE;

        //require_login();
		$context = context_system::instance();
		$PAGE->set_context( $context );

        $params = self::validate_parameters( self::set_courses_search_parameters(), array(
            'searchstr' => $searchstr,
            'categories' => $categories,
            'tags' => $tags,
            'instructors' => $instructors,
            'price' => $price
        ) );

        $opt = array(
            'page' => 1,
            'searchstr' => $params['searchstr'],
            'categories' => unserialize( urldecode( $params['categories'] ) ),
            'tags' => unserialize( urldecode( $params['tags'] ) ),
            'instructors' => unserialize( urldecode( $params['instructors'] ) ),
            'price' => $params['price']
        );

        $opt['lazy'] = 0;

        $courses = theme_mb2nl_course_list( $opt );

        $results = array(
            'courses' => $courses
        );

        return $results;

    }




    /**
     * Describes the parameters for submit_grading_form webservice.
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function set_courses_search_parameters() {
        return new external_function_parameters(
            array(
                'searchstr' => new external_value( PARAM_RAW, 'Search query' ),
                'categories' => new external_value( PARAM_RAW, 'Categories array' ),
                'tags' => new external_value( PARAM_RAW, 'Tags array' ),
                'instructors' => new external_value( PARAM_RAW, 'instructors array' ),
                'price' => new external_value( PARAM_INT, 'Course price' )
            )
        );
    }



    /**
     * Describes the return for submit_grading_form
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function set_courses_search_returns() {
        return new external_single_structure(
            array(
                'courses' => new external_value( PARAM_RAW, 'Course list' ),
                'warnings' => new external_warnings()
            )
        );
    }





    /**
     *
     * Method to get a list of all services.
     *
     */
    public static function course_quickview( $course )
    {
        global $PAGE;

		$context = context_system::instance();
		$PAGE->set_context( $context );

        $params = self::validate_parameters( self::course_quickview_parameters(), array(
            'course' => $course
        ) );

        $course = theme_mb2nl_course_quickview( $params['course'] );

        $results = array(
            'course' => $course,
            'courseid' => $params['course']
        );

        return $results;

    }





    /**
     * Describes the parameters for submit_grading_form webservice.
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function course_quickview_parameters() {
        return new external_function_parameters(
            array(
                'course' => new external_value( PARAM_INT, 'Course id' )
            )
        );
    }



    /**
     * Describes the return for submit_grading_form
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function course_quickview_returns() {
        return new external_single_structure(
            array(
                'course' => new external_value( PARAM_RAW, 'Course' ),
                'courseid' => new external_value( PARAM_INT, 'Course ID' ),
                'warnings' => new external_warnings()
            )
        );
    }



    /**
     *
     * Method to get a list of all services.
     *
     */
    public static function event_details( $eventid )
    {

        $params = self::validate_parameters( self::event_details_parameters(), array(
            'eventid' => $eventid
        ) );

        // To check event capability
        // check calendar/externallib.php, line 342
        $results = array(
            'eventid' => $params['eventid']
        );

        return $results;

    }




    /**
     * Describes the parameters for submit_grading_form webservice.
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function event_details_parameters() {
        return new external_function_parameters(
            array(
                'eventid' => new external_value( PARAM_INT, 'Event ID' )
            )
        );
    }




    /**
     * Describes the return for submit_grading_form
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function event_details_returns() {
        return new external_single_structure(
            array(
                'eventid' => new external_value( PARAM_INT, 'Event ID' ),
                'warnings' => new external_warnings()
            )
        );
    }


}
