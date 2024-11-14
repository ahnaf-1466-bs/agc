<?php

global $CFG;
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class multi_question extends moodleform {
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('textarea', 'question_text', 'Question Title');
        $mform->setType('question_text', PARAM_TEXT);
//        $mform->addRule('question_text', 'Please enter the question title', 'required');

        $mform->addElement('textarea', 'header1', 'Header 1');
        $mform->setType('header1', PARAM_TEXT);
        $mform->addRule('header1', 'Please enter the first header', 'required');

        $mform->addElement('textarea', 'header2', 'Header 2');
        $mform->setType('header2', PARAM_TEXT);
        $mform->addRule('header2', 'Please enter the second header', 'required');

        $this->add_action_buttons('Cancel', 'Add Question');
    }
}
