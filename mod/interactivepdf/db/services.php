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
 * Function definition for the webservicesuite functions.
 *
 * @package    local
 * @subpackage rating_helper
 * @author     Brain Station 23
 * @copyright  2021 Brain Station 23 Limited
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'save_question_answer' => array(
        'classname' => 'interactivepdf_services',
        'methodname' => 'save_question_answer',
        'classpath' => 'mod/interactivepdf/externallib.php',
        'description' => 'Check if the user has rated already.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/interactivepdf:access',
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
    'save_3n_question_answer' => array(
        'classname' => 'interactivepdf_services',
        'methodname' => 'save_3n_question_answer',
        'classpath' => 'mod/interactivepdf/externallib.php',
        'description' => 'Check if the user has rated already.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/interactivepdf:access',
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
    'save_2nm_question_answer' => array(
        'classname' => 'interactivepdf_services',
        'methodname' => 'save_2nm_question_answer',
        'classpath' => 'mod/interactivepdf/externallib.php',
        'description' => 'Check if the user has rated already.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/interactivepdf:access',
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
    'save_2ns_question_answer' => array(
        'classname' => 'interactivepdf_services',
        'methodname' => 'save_2ns_question_answer',
        'classpath' => 'mod/interactivepdf/externallib.php',
        'description' => 'Check if the user has rated already.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/interactivepdf:access',
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
    'finish_attempt' => array(
        'classname' => 'interactivepdf_services',
        'methodname' => 'finish_attempt',
        'classpath' => 'mod/interactivepdf/externallib.php',
        'description' => 'Check if the user has rated already.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/interactivepdf:access',
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
    'send_notification' => array(
        'classname' => 'interactivepdf_services',
        'methodname' => 'send_notification',
        'classpath' => 'mod/interactivepdf/externallib.php',
        'description' => 'Check if the user has rated already.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/interactivepdf:access',
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
    'save_feedback' => array(
        'classname' => 'interactivepdf_services',
        'methodname' => 'save_feedback',
        'classpath' => 'mod/interactivepdf/externallib.php',
        'description' => 'Check if the user has rated already.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'local/interactivepdf:access',
        'services' => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
);