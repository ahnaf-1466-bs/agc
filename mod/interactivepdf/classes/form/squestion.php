<?php

global $CFG;
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class squestion extends moodleform
{
    protected function definition()
    {
        $mform = $this->_form;

        $mform->addElement('textarea', 'question_text', 'Question Text');
        $mform->setType('question_text', PARAM_TEXT);
        $mform->addRule('question_text', 'Please enter the question text', 'required');

        $mform->addElement('textarea', 'right_ans', 'Right Answer');
        $mform->setType('right_ans', PARAM_TEXT);
        $mform->addRule('right_ans', 'Please enter the right answer', 'required');

        $this->add_action_buttons('Cancel', 'Add Question');
    }
}

