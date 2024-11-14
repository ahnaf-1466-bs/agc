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
 * Web service for mod assign
 * @package    mod_assign
 * @subpackage db
 * @since      Moodle 2.4
 * @copyright  2012 Paul Charsley
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$functions = array(
    'theme_mb2nl_subscribe' => array(
            'classname'     => 'theme_mb2nl_external',
            'methodname'    => 'submit_subscribe_form',
            'classpath'     => 'theme/mb2nl/externallib.php',
            'description'   => 'Submit the course list filter form data via ajax',
            'type'          => 'read',
            'ajax'          => true,
            'loginrequired' => false,
            'capabilities'  => '',
            'services'      => array( MOODLE_OFFICIAL_MOBILE_SERVICE )
    ),
    'theme_mb2nl_course_pagination' => array(
            'classname'     => 'theme_mb2nl_external',
            'methodname'    => 'set_courses_pagination',
            'classpath'     => 'theme/mb2nl/externallib.php',
            'description'   => 'Set cours list pagination links via ajax',
            'type'          => 'read',
            'ajax'          => true,
            'loginrequired' => false,
            'capabilities'  => '',
            'services'      => array( MOODLE_OFFICIAL_MOBILE_SERVICE )
    ),
    'theme_mb2nl_course_search' => array(
            'classname'     => 'theme_mb2nl_external',
            'methodname'    => 'set_courses_search',
            'classpath'     => 'theme/mb2nl/externallib.php',
            'description'   => 'Submit the course search form data via ajax',
            'type'          => 'read',
            'ajax'          => true,
            'loginrequired' => false,
            'capabilities'  => '',
            'services'      => array( MOODLE_OFFICIAL_MOBILE_SERVICE )
    ),
    'theme_mb2nl_course_quickview' => array(
            'classname'     => 'theme_mb2nl_external',
            'methodname'    => 'course_quickview',
            'classpath'     => 'theme/mb2nl/externallib.php',
            'description'   => 'Get course details in modal window',
            'type'          => 'read',
            'ajax'          => true,
            'loginrequired' => false,
            'capabilities'  => '',
            'services'      => array( MOODLE_OFFICIAL_MOBILE_SERVICE )
    ),
    'theme_mb2nl_event_details' => array(
        'classname'     => 'theme_mb2nl_external',
        'methodname'    => 'event_details',
        'classpath'     => 'theme/mb2nl/externallib.php',
        'description'   => 'Submit event details via ajax',
        'type'          => 'read',
        'ajax'          => true,
        'loginrequired' => false,
        'capabilities'  => '',
        'services'      => array( MOODLE_OFFICIAL_MOBILE_SERVICE )
    )
);
