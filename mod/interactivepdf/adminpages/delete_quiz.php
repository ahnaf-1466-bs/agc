<?php
global $DB;

require(__DIR__ . '/../../../config.php');

$id = required_param("id", PARAM_INT);
$pageid = required_param("pageid", PARAM_INT);
$contentid = required_param("content_id", PARAM_INT);
$quizid = required_param('quizid',PARAM_INT);

$content = $DB->get_record('interactivepdf_quizzes', ['content_id' => $contentid], '*', MUST_EXIST);
$content_id = $content->content_id;

$del = $DB->get_records('interactivepdf_subquestions', ['quiz_id' => $quizid]);

foreach ($del as $d){
    if($d->type === '2ns'){
        $data = $DB->get_record('interactivepdf_2ns',['subquestionid' => $d->id]);
        $_2nsId = $data->id;
        $DB->delete_records('interactivepdf_2n_squestions',['nid' => $_2nsId]);
        $DB->delete_records('interactivepdf_2ns',['subquestionid' => $d->id]);

    }else if($d->type === '3n'){
        $data = $DB->get_record('interactivepdf_3ns',['subquestionid' => $d->id]);
        $_3nId = $data->id;
        $DB->delete_records('interactivepdf_3n_questions',['nid' => $_3nId]);
        $DB->delete_records('interactivepdf_3ns',['subquestionid' => $d->id]);

    }
    else if($d->type === '2nm'){
        $data = $DB->get_record('interactivepdf_2nms',['subquestionid' => $d->id]);
        $_2nmId = $data->id;
        $DB->delete_records('interactivepdf_2n_mquestions',['nid' => $_2nmId]);
        $DB->delete_records('interactivepdf_2nms',['subquestionid' => $d->id]);
    }

}
$DB->delete_records('interactivepdf_subquestions',array('quiz_id' => $quizid));

$DB->delete_records('interactivepdf_quizzes', array('content_id' => $contentid));

$DB->delete_records('interactivepdf_contents', array('id' => $content_id));

redirect(new moodle_url('/mod/interactivepdf/adminpages/quiz.php', ['id' => $id, 'pageid' => $pageid]), 'Quiz Deleted Successfully');

