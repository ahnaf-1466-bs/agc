<?php

global $CFG;
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class mquestion extends moodleform
{
    protected function definition()
    {
        $mform = $this->_form;

        $mform->addElement('textarea', 'right_ans1', 'Right Answer 1');
        $mform->setType('right_ans1', PARAM_TEXT);
        $mform->addRule('right_ans1', 'Please enter the first right answer', 'required');

        $mform->addElement('textarea', 'right_ans2', 'Right Answer 2');
        $mform->setType('right_ans2', PARAM_TEXT);
        $mform->addRule('right_ans2', 'Please enter the second right answer', 'required');

        $this->add_action_buttons('Check List', 'Add Question');
    }
}
