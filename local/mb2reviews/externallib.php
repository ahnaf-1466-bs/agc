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
 * @copyright  2020 Mariusz Boloz (mb2themes.com)
 * @license    Commercial https://themeforest.net/licenses
 */

defined( 'MOODLE_INTERNAL' ) || die;

require_once ( $CFG->libdir . '/externallib.php' );
require_once ( __DIR__ . '/lib.php' );
require_once ( __DIR__ . '/classes/api.php' );
require_once ( __DIR__ . '/classes/helper.php' );

class local_mb2reviews_external extends external_api
{


    /**
     *
     * Method to get a list of all services.
     *
     */
    public static function submit_review( $formdata )
    {
        global $PAGE, $USER;

		$context = context_system::instance();
		$PAGE->set_context( $context );

        $params = self::validate_parameters( self::submit_review_parameters(), array(
            'formdata' => $formdata
        ) );

        $data = array();
        parse_str( $formdata, $data );
        $reviewdata = (object) $data;

        if ( $reviewdata->id )
        {
            Mb2reviewsApi::update_record( $reviewdata );
        }
        else
        {
            Mb2reviewsApi::add_record( $reviewdata );
        }

        $results = array(
           'courses' => $formdata
        );

        Mb2reviewsHelper::notify_users_message( $reviewdata );

        return $results;

    }





    /**
     * Describes the parameters for submit_grading_form webservice.
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function submit_review_parameters() {
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
    public static function submit_review_returns() {
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
    public static function show_more( $courseid, $page )
    {
        global $PAGE;

		$context = context_system::instance();
		$PAGE->set_context( $context );

        $params = self::validate_parameters( self::show_more_parameters(), array(
            'courseid' => $courseid,
            'page' => $page
        ) );

        $opts = array(
            'courseid' => $params['courseid'],
            'page' => $params['page']
        );

        $results = array(
           'reviews' => Mb2reviewsHelper::review_list_items( $opts )
        );

        return $results;

    }




    /**
     * Describes the parameters for submit_grading_form webservice.
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function show_more_parameters() {
        return new external_function_parameters(
            array(
                'courseid' => new external_value( PARAM_INT, 'Course id number' ),
                'page' => new external_value( PARAM_INT, 'Pagination current page number' )
            )
        );
    }




    /**
     * Describes the return for submit_grading_form
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function show_more_returns() {
        return new external_single_structure(
            array(
                'reviews' => new external_value( PARAM_RAW, 'The review list, encoded as a json array' ),
                'warnings' => new external_warnings()
            )
        );
    }






    /**
     *
     * Method to get a list of all services.
     *
    */
    public static function feedback( $review, $feedback, $oldfeedback )
    {
        global $PAGE;

    	$context = context_system::instance();
    	$PAGE->set_context( $context );

        $params = self::validate_parameters( self::feedback_parameters(), array(
            'review' => $review,
            'feedback' => $feedback,
            'oldfeedback' => $oldfeedback
        ) );

        Mb2reviewsApi::update_feedback( $params['review'], $params['feedback'], $params['oldfeedback'] );

        $results = array(
           'review' => $params['review'],
           'feedback' => $params['feedback'],
           'oldfeedback' => $params['oldfeedback']
        );

        return $results;

    }




    /**
     * Describes the parameters for submit_grading_form webservice.
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function feedback_parameters() {
        return new external_function_parameters(
            array(
                'review' => new external_value( PARAM_INT, 'Review ID number' ),
                'feedback' => new external_value( PARAM_RAW, 'Feedback type' ),
                'oldfeedback' => new external_value( PARAM_RAW, 'Feedback type from cookies' )
            )
        );
    }




    /**
     * Describes the return for submit_grading_form
     * @return external_function_parameters
     * @since  Moodle 3.1
     */
    public static function feedback_returns() {
        return new external_single_structure(
            array(
                'warnings' => new external_warnings()
            )
        );
    }


}
