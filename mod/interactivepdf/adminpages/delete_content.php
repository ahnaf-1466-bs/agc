<?php
global $CFG, $DB, $OUTPUT;

require(__DIR__ . '/../../../config.php');

$id = required_param("id", PARAM_INT); // Course_module ID
$pageid = required_param("pageid", PARAM_INT); // Page ID
$contentid = required_param("contentid", PARAM_INT); // Content ID

$content = $DB->get_record('interactivepdf_htmls', ['id' => $contentid], '*', MUST_EXIST);
$content_id = $content->content_id;

$deleted_html = $DB->delete_records('interactivepdf_htmls', array('id' => $contentid));

$deleted_content = $DB->delete_records('interactivepdf_contents', array('id' => $content_id));

if ($deleted_html && $deleted_content) {
    redirect(new moodle_url('/mod/interactivepdf/adminpages/view_page.php', ['id' => $id, 'pageid' => $pageid]), 'Content Deleted Successfully');
} else {
    echo 'Failed to delete the HTML content and its corresponding content.';
}

