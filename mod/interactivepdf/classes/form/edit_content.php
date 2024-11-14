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
 * Version details of mod_interactivepdf.
 *
 * @package    mod_interactivepdf
 * @copyright  2023 @Md. Faisal Abid
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
global $CFG;
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");
class edit_content_form extends moodleform {
    public function definition() {

        $mform = $this->_form;

        $mform->addElement('editor', 'description_editor', 'Content', null, [
            'maxfiles' => EDITOR_UNLIMITED_FILES,
            'accepted_types' => '*',
            'maxbytes' => 1048576, // Maximum file size in bytes (1MB)
        ]);

        $mform->setType('description_editor', PARAM_RAW);
        $mform->setDefault('description_editor', $this->_customdata['description'] ?? '');

        $this->add_action_buttons();
    }
}
