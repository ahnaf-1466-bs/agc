<?php

global $CFG;
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class mcq_question extends moodleform {
    protected function definition() {
        $mform = $this->_form;

        // Add question title field
        $mform->addElement('text', 'question', 'Question Title');
        $mform->setType('question', PARAM_TEXT);
        $mform->addRule('question', 'Please enter the question title', 'required');

        // Add four answer options
        $mform->addElement('text', 'option1', 'Option 1');
        $mform->setType('option1', PARAM_TEXT);
        $mform->addRule('option1', 'Please enter option 1', 'required');

        $mform->addElement('text', 'option2', 'Option 2');
        $mform->setType('option2', PARAM_TEXT);
        $mform->addRule('option2', 'Please enter option 2', 'required');

        $mform->addElement('text', 'option3', 'Option 3');
        $mform->setType('option3', PARAM_TEXT);

        $mform->addElement('text', 'option4', 'Option 4');
        $mform->setType('option4', PARAM_TEXT);

        $mform->addElement('text', 'correct_ans', 'Correct Answer');
        $mform->setType('correct_ans', PARAM_TEXT);
        $mform->addRule('correct_ans', 'Please enter the correct answer', 'required');

        $this->add_action_buttons('Cancel', 'Add MCQ Question');
    }
}

