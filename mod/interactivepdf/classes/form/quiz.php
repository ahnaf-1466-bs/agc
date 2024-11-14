<?php

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

class quiz extends moodleform {
    protected function definition() {
        $mform = $this->_form;

        // Add question type dropdown
        $mform->addElement('select', 'question_type', 'Question Type', array(
            'short' => 'Short Question',
            'mcq' => 'MCQ'
        ));

        // Add buttons
        $this->add_action_buttons('Cancel','Add Question');
    }
}
