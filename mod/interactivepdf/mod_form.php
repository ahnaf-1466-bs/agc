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
global $CFG;
defined('MOODLE_INTERNAL') || die();
require_once ($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot . '/mod/interactivepdf/locallib.php');

class mod_interactivepdf_mod_form extends moodleform_mod {

    function definition() {
        global $CFG;

        $mform = $this->_form;
        $interactivepdfconfig = get_config('interactivepdf');
        $mform->addElement('header', 'general', 'Info');

        // Name of the mod.
        $mform->addElement('text', 'name', 'Page Info', array('size'=>'64','placeholder'=>'Enter Page Info'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', 'Please enter page info', 'required', null,'server');
        
        // Adding the standard "intro" and "introformat" fields.
        $this->standard_intro_elements();
        $element = $mform->getElement('introeditor');
        $attributes = $element->getAttributes();
        $attributes['rows'] = 5;
        $element->setAttributes($attributes);


        $mform->addElement('header', 'general', 'Grade');

        $this->standard_grading_coursemodule_elements();


        if (property_exists($this->current, 'grade')) {
            $currentgrade = $this->current->grade;
        } else {
            $currentgrade = $interactivepdfconfig->maximumgrade;
        }
        $mform->addElement('hidden', 'grade', $currentgrade);
        $mform->setType('grade', PARAM_FLOAT);

        // Number of attempts.
        $attemptoptions = ['0' => get_string('unlimited')];
        for ($i = 1; $i <= INTERACTIVEPDF_MAX_ATTEMPT_OPTION; $i++) {
            $attemptoptions[$i] = $i;
        }
        $mform->addElement('select', 'attempts', get_string('attemptsallowed', 'interactivepdf'),
            $attemptoptions);

        // Grading method.
        $mform->addElement('select', 'grademethod', get_string('grademethod', 'interactivepdf'),
            interactivepdf_get_grading_options());
        $mform->addHelpButton('grademethod', 'grademethod', 'interactivepdf');
        $this->standard_coursemodule_elements();

        $this->add_action_buttons();
    }
}
