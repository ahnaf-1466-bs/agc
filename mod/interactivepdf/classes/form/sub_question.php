<?php

global $CFG;
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class sub_question extends moodleform {
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('textarea', 'question_text', 'Question Title');
        $mform->setType('question_text', PARAM_TEXT);
        $mform->addRule('question_text', 'Please enter the question title', 'required');

        $mform->addElement('textarea', 'correct_ans', 'Correct Answer');
        $mform->setType('correct_ans', PARAM_TEXT);
//        $mform->addRule('correct_ans', 'Please enter the correct answer', 'required');

        $this->add_action_buttons('Cancel', 'Add Sub Question');
    }
}