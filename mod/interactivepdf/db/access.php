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

 defined('MOODLE_INTERNAL') || die();

 $capabilities = array(

    'mod/interactivepdf:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'guest' => CAP_ALLOW,
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),
    'mod/interactivepdf:addinstance' => array(
        'riskbitmask' => RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
        'clonepermissionsfrom' => 'moodle/course:manageactivities'
    ),
     'mod/interactivepdf:add_page' => array(

         'riskbitmask' => RISK_XSS, // we want flash and JS in question pages

         'captype' => 'write',
         'contextlevel' => CONTEXT_MODULE,
         'archetypes' => array(
             'editingteacher' => CAP_ALLOW,
             'manager' => CAP_ALLOW
         )
     ),
     'mod/interactivepdf:edit_page' => array(
         'captype' => 'write',
         'contextlevel' => CONTEXT_MODULE,
         'archetypes' => array(
             'editingteacher' => CAP_ALLOW,
             'manager' => CAP_ALLOW
         )
     ),
     'mod/interactivepdf:edit_content' => array(
         'captype' => 'write',
         'contextlevel' => CONTEXT_MODULE,
         'archetypes' => array(
             'editingteacher' => CAP_ALLOW,
             'manager' => CAP_ALLOW
         )
     ),
    // 'mod/interactivepdf:attemttest' => array(
    //     'captype' => 'write',
    //     'contextlevel' => CONTEXT_MODULE,
    //     'archetypes' => array(
    //         'student' => CAP_ALLOW,
    //         'teacher' => CAP_ALLOW,
    //         'editingteacher' => CAP_ALLOW,
    //         'manager' => CAP_ALLOW
    //     )
    // )
     'mod/interactivepdf:edittest' => array(
         'captype' => 'write',
         'contextlevel' => CONTEXT_MODULE,
         'archetypes' => array(
             'teacher' => CAP_ALLOW,
             'editingteacher' => CAP_ALLOW,
             'manager' => CAP_ALLOW
         )
     ),

     // Manually grade and comment on student attempts at a question.
     'mod/interactivepdf:grade' => [
         'riskbitmask' => RISK_SPAM | RISK_XSS,
         'captype' => 'write',
         'contextlevel' => CONTEXT_MODULE,
         'archetypes' => [
             'teacher' => CAP_ALLOW,
             'editingteacher' => CAP_ALLOW,
             'manager' => CAP_ALLOW
         ]
     ],

     // Regrade quizzes.
     'mod/interactivepdf:regrade' => [
         'riskbitmask' => RISK_SPAM,
         'captype' => 'write',
         'contextlevel' => CONTEXT_MODULE,
         'archetypes' => [
             'teacher' => CAP_ALLOW,
             'editingteacher' => CAP_ALLOW,
             'manager' => CAP_ALLOW
         ],
         'clonepermissionsfrom' =>  'mod/quiz:grade'
     ],

     // View the quiz reports.
     'mod/interactivepdf:viewreports' => [
         'riskbitmask' => RISK_PERSONAL,
         'captype' => 'read',
         'contextlevel' => CONTEXT_MODULE,
         'archetypes' => [
             'teacher' => CAP_ALLOW,
             'editingteacher' => CAP_ALLOW,
             'manager' => CAP_ALLOW
         ]
     ],

     // Delete attempts using the overview report.
     'mod/interactivepdf:deleteattempts' => [
         'riskbitmask' => RISK_DATALOSS,
         'captype' => 'write',
         'contextlevel' => CONTEXT_MODULE,
         'archetypes' => [
             'editingteacher' => CAP_ALLOW,
             'manager' => CAP_ALLOW
         ]
     ],
);