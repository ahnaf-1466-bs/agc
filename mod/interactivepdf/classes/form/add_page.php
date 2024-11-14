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
 * Version details of mod_management.
 *
 * @package    mod_interactivepdf
 * @copyright  2023 @Md. Faisal Abid
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CFG;
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class add_page extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG;

        $mform = $this->_form; // Don't forget the underscore!
//        $mform->addElement('hidden', 'cmid');
//        $mform->setType('cmid', PARAM_INT);

        $mform->addElement("text", 'title', 'Title');
        $mform->setType('title', PARAM_RAW);
        $mform->addRule('title', 'Please Give a Title', 'required', null, 'server');

        $mform->addElement("editor", "description_editor", 'Description');
        $mform->setType('description_editor', PARAM_RAW);

        $this->add_action_buttons();
    }

    //Custom validation should be added here
    function validation($data, $files)
    {
        return array();
    }
}

