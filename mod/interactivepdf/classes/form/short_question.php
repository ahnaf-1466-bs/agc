<?php
/**
* Short question form definition for interactivepdf.
*
* @package    mod_interactivepdf
* @copyright  2023 @Md. Faisal Abid
* @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
global $CFG;
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class short_question_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        $editoroption = array("subdirs"=>1,"maxfiles" => -1);
        $mform->addElement('editor', 'question_editor', 'Question', null, $editoroption);
        $mform->setType('question_editor', PARAM_RAW);
        $mform->setDefault('question_editor', $this->_customdata['html'] ?? '');

        $this->add_action_buttons('Cancel', 'Add Question');
    }
    function data_preprocessing(&$default_values) {
        if ($this->current->instance) {
            // editing existing instance - copy existing files into draft area
            $draftitemid = file_get_submitted_draft_itemid('files');
            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_folder', 'content', 0, array('subdirs'=>true));
            $default_values['files'] = $draftitemid;
        }
    }

}